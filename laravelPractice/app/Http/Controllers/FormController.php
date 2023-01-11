<?php

namespace App\Http\Controllers;

use App\Models\AjaxForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class FormController extends Controller
{
    public function view()
    {

        return view('form');

//        $users = AjaxForm::paginate(3);
//        return view('form')->with('users', $users);
    }

    public function store(Request $request)
    {
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required'//|email|unique:ajax_forms,email',

        ]);

        $form          = new AjaxForm();
        $fileStoreToDB = '';
        $destinationPath = public_path('uploads') . '/' . $request->fname . '/';
        //Move Uploaded File
        if ($request->hasFile('file')) {

            $file            = $request->file('file');
            $originalName    = date("h_i_s") . '_' . $file->getClientOriginalName();
            $destinationFile = public_path() . '/uploads/' . $originalName;

            if (!File::exists($destinationFile) && !is_dir($destinationFile)) { // file not exist check
                $fileStoreToDB = $originalName;
            } else {
                $fileStoreToDB = rand() . $originalName;
            }
            if (!File::exists(public_path('/uploads') . '/' . $request->fname)) {
                File::makeDirectory(public_path('/uploads') . '/' . $request->fname, 0775);
            }

            $file->move($destinationPath, $fileStoreToDB);
        }

        $fileStoreToDB = $destinationPath . $fileStoreToDB;
        // $table_object->database_field_name = value
        $form->fname  = $request->fname;
        $form->lname  = $request->lname;
        $form->email  = $request->email;
        $form->propic = $fileStoreToDB;
        $form->save();

        $optInUrl =  url('').'/spa/optin/confirmaiton/'.$form->id;

        $singleData = AjaxForm::where('id', $form->id)->first();

        $singleDataNew = [
            'fname' => $singleData->fname,
            'lname' => $singleData->lname,
            'email' => $singleData->email,
            'optin_url'=> $optInUrl,
        ];

        $emailContent = [
            'fromEmail'=>'noreply@akibuki.co.uk', //'Akibuki Ltd',
            'emailBody'=> 'Your contact has been created successfully',
            'contact'=> $singleData['email'],
            'subject'=>'Contact created successfully',
        ];

        $sendmail = $this->email($emailContent,$singleDataNew);
        if($sendmail){
            return response()->json(['success' => 'Contact created successfully!']);
        }
    }
    public function optin($id)
    {
        $optinIns = AjaxForm::find($id);
        $optinIns-> status = 1;
        $optinIns->save();
        return redirect()->route('form.view')->with('success','Your status has been changed');
    }
    public function formmeta(Request $request)
    {
        $biometric = [
            "fname"=> $request->fname,
            "lname"=> $request->lname,


            'biometric2' => [
                'measurements' => [
                    "height"=> $request->height,
                    "weight"=> $request->weight,
                    "blood_group"=> $request->blood_group,
                ],
                'body_marks' => [
                    "eye_color"=>  $request->eye_color,
                    "hair_color"=> $request->hair_color,
                ],
                'social_marks' => [
                    "occupation"=> $request->occupation,
                    "merital_status"=> $request->merital_status,
                ],
                'academic' => [
                    "academic_qualification" => $request->academic_qualification,
                ],

            ]
        ];
        $storedata = new AjaxForm();
        $data =  json_encode($biometric);
        $storedata->form_meta = $data;
        $storedata->save();

        return response()->json(['data' => $storedata]);

    }

    public function formmetavalue($id)
    {
        $formmetavalue = AjaxForm::find($id);
//        $decodedData = $formmetavalue;
//        $metaDecode = json_decode($decodedData->form_meta);
//
//        return response()->json($metaDecode);

//        return view('jsonresponse')
//            ->with('IloveYou', $decodedData)
//            ->with('anotherVariable', $metaDecode);

    }

    public function token()
    {
        echo csrf_token();

    }
    public function email($emailContent,$singleData)
    {
        Mail::send('mailtemplate.contactMsg', ['singleData' => $singleData], function($message) use ($emailContent) {

            $message -> from($emailContent['fromEmail']);
            $message -> to($emailContent['contact']);
            $message -> subject($emailContent['subject']);
        });

         return true;

    }

    public function list(Request $request)
    {
        $searchKeyword = $request->search;
        $changeKeyword = $request->change;
        $per_page = $request->per_page;

        $query = AjaxForm::query();
//        $query = DB::table('ajax_forms')->paginate(10);

        $query->when($searchKeyword != '', function ($query) use ($searchKeyword) {

            $query->where('id', (int)$searchKeyword)
                ->Orwhere('fname', 'LIKE', '%' . $searchKeyword . '%')
                ->Orwhere('lname', 'LIKE', '%' . $searchKeyword . '%')
                ->Orwhere('email', 'LIKE', '%' . $searchKeyword . '%');
        });
        $query->when($changeKeyword != '', function ($query) use ($changeKeyword) {
            $query->where('status', $changeKeyword);
        });

//        $readData = $query->paginate(10);
        $readData = $query->paginate($per_page);
        return response()->json($readData);

    }

    public function modalview($id)
    {
        // for ambiguous id, i have to mention the desired id field
//        DB::enableQueryLog();
        $modalview = DB::table('ajax_forms')
            ->join('ajax_salary', 'ajax_forms.id', '=', 'ajax_salary.ajf_id')
            ->join('ajax_em_history', 'ajax_salary.id', '=', 'ajax_em_history.salary_id')
            ->where('ajax_forms.id', '=', $id)
            ->first();

//        $query = DB::getQueryLog();
//        dd($query);

        $decodedData = $modalview;
        $metaDecode = json_decode($decodedData->form_meta);
        return response()->json(['metaDecode' => (array) $metaDecode, 'modalview'=>$modalview]);

    }

    public function edit($id)
    {
        $editData = new AjaxForm();
        $results  = $editData->find($id);
        return response()->json($results);
    }

    public function update(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'ajemail' => 'required|email',

        ]);

        $updateData = AjaxForm::find($request->id);
        // $table_object->database_field_name = value
        $updateData->fname = $request->firstname;
        $updateData->lname = $request->lastname;
        $updateData->email = $request->ajemail;
        $updateData->save();


        return response()->json(['success' => 'Contact updated successfully!']);

    }


    public function destroy(Request $request)
    {
        $deleteData = AjaxForm::find($request->id);
        $deleteData->delete();
        return response()->json($deleteData);

    }

}
