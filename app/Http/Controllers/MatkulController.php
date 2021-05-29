<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\Matkul;
use App\Models\Prodi;
use App\Models\Semester;
use Illuminate\Http\Request;

class MatkulController extends Controller
{

   public function show(Request $request)
   {
      $user = $request->auth;

      $matkuls = Matkul::where('semester_id', $user->semester_id)->orderBy('session', 'ASC')->get();

      return $matkuls;
   }
}
