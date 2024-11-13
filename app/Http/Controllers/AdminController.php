<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    function index(){
       return view('dashboard.welcome');
    }
    public function admin(){
        return view('dashboard.dashboardadmin');
    }
    function kasir(){
        echo "Selamat Datang di Halaman Kasir";
        echo "<h1>" . Auth::user()->name . "</h1>";
        echo "<a href='/logout'> Logout>>> </a>";
    }
    function owner(){
        echo "Selamat Datang di Halaman Owner";
        echo "<h1>" . Auth::user()->name . "</h1>";
        echo "<a href='/logout'> Logout>>> </a>";
    }

   
}
