<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{

   public function show(Request $request)
   {
      return $request->auth;
   }
}
