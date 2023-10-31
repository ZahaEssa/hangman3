<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomepageController extends Controller
{public function showHomepage()
    {
        return view('homepage'); // Assumes you have a Blade view named 'homepage.blade.php'
    }
    
    //
}
