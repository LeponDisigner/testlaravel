<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class homeController extends Controller
{
    //la function qui retourne la home page
    public function home()
    {
        return view('home.Home');
    }

    //la function qui retourne About page
    public function About()
    {
        return view('home.About');
    }

      //la function qui retourne About page
      public function dashboard()
      {
          return view('home.dashboard');
      }
}
