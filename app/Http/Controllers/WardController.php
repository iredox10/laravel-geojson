<?php

namespace App\Http\Controllers;

use App\Models\Wards;

class WardController extends Controller
{
   public function hello(){
    return response()->json('hello world');
   } 
}

