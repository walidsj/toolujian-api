<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Mahasiswa;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;

class AuthController extends Controller
{

   private function jwt(Mahasiswa $mahasiswa, Log $log)
   {
      $payload = [
         'iss' => "lumen-jwt",
         'sub' => $mahasiswa->id,
         'log' => $log->id,
         'iat' => time(),
         'exp' => time() + 3600 * 24 * 7 // token kadaluwarsa setelah 3600 detik * 24 * 7
      ];

      return JWT::encode($payload, env('JWT_SECRET'));
   }

   public function authenticate(Request $request)
   {
      $this->validate($request, [
         'npm' => 'required',
         'class' => 'required'
      ]);

      $npm = $request->input('npm');
      $class = $request->input('class');

      $mahasiswa = Mahasiswa::with('semester')->where('npm', $npm)->where('class', $class)->first();

      if ($mahasiswa) {

         $log = new Log();
         $log->mahasiswa_id = $mahasiswa->id;
         $log->save();

         $token = $this->jwt($mahasiswa, $log);

         return response()->json([
            'token' => $token,
         ], 200);
      } else {

         return response()->json([
            'error' => 'Login failed.'
         ], 422);
      }
   }
}
