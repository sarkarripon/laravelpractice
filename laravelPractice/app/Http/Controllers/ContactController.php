<?php

namespace App\Http\Controllers;

use App\Models\ContactForm;
use Illuminate\Http\Request;
class ContactController extends Controller
{
    public function contact(){

        return view('contact');
    }

    public function store(Request $request)
    {
//        return response()->json($request);
        $contacts = new ContactForm();
        $request->validate([
            'fname'          => 'required',
            'lname'          => 'required',
            'email'         => 'required|email|unique:contact_forms,email',
            'country'         => 'required',
            'mobile'        => 'required||unique:contact_forms,mobile|regex:/^([0-9\s\-\+\(\)]*)$/|min:11',
            'comment'       => 'required|min:20',
        ]);

        // $table_object->database_field_name = value
        $contacts->fname = $request->fname;
        $contacts->lname = $request->lname;
        $contacts->email = $request->email;
        $contacts->mobile = $request->mobile;
        $contacts->country = $request->country;
        $contacts->comment = $request->comment;
        $contacts->save();

        return response()->json(['success'=>'Contact created successfully!']);
    }

    public function list()
    {
        $readData = new ContactForm();
        $results = $readData->all();
        return view('welcome', ['results' => $results]);

    }

    public function edit($id)
    {
        $editData = new ContactForm();
        $results = $editData->find($id);
        return view('edit', ['results' => $results]);
    }

    public function update(Request $request)
    {
        $updateData = ContactForm::find($request->id);
        $updateData->fname = $request->firstname;
        $updateData->lname = $request->lastname;
        $updateData->email = $request->email;
        $updateData->country = $request->country;
        $updateData->comment = $request->comment;
        $updateData->save();
        return redirect()->route('home');

    }

    public function destroy(Request $request)
    {
        $deleteData = ContactForm::find($request->id);
        $deleteData->delete();
        return redirect()->route('home');

    }

}
