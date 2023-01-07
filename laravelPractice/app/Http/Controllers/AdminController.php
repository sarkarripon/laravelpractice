<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function index(){
        return view('backend.admin.dashboard');
    }

    public function home(){

//
//        $user = new User(); // calling user model
//        $result = $user->all();
//
        return view('home');
    }

    public function about(){

        return view('about');
    }


}
