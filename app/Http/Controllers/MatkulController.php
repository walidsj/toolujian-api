<?php

namespace App\Http\Controllers;

use App\Models\Matkul;
use Illuminate\Http\Request;

class MatkulController extends Controller
{

   public function show(Request $request)
   {
      $user = $request->auth;

      $matkuls = Matkul::where('semester_id', $user->semester_id)
         ->orderBy('session', 'ASC')
         ->with(['dosen' => function ($query) {
            $query->where('class', '=', request()->auth->class);
         }])
         ->get()
         ->makeHidden('semester_id');

      return response()->json($matkuls, 200);
   }
}
