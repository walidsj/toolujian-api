<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Log;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{

   public function show(Request $request)
   {
      $user = $request->auth->makeHidden('semester_id');
      $user->semester = Semester::find($user->semester_id)
         ->makeHidden('prodi_id', 'created_at', 'updated_at');
      $user->prodi = Prodi::find($user->semester->prodi_id)
         ->makeHidden('jurusan_id', 'created_at', 'updated_at');
      $user->jurusan = Jurusan::find($user->prodi->jurusan_id)
         ->makeHidden('created_at', 'updated_at');
      return $user;
   }

   public function log(Request $request)
   {
      $logs = Log::where('mahasiswa_id', $request->auth->id)->get();
      return $logs;
   }
}
