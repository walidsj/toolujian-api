<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Mahasiswa;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;

class AuthController extends Controller
{

   private function jwt(Mahasiswa $mahasiswa)
   {
      $payload = [
         'iss' => "lumen-jwt",
         'sub' => $mahasiswa->id,
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

      $class[1] = 0;
      $class = explode('-', $request->input('class'));

      $mahasiswa = Mahasiswa::with('semester')->where('npm', $npm)->where('class', $class[1])->first();

      if ($mahasiswa && $mahasiswa->semester->number == $class[0]) {

         $log = new Log();
         if($log->where('mahasiswa_id', $mahasiswa->id)->first()) {
            $log->mahasiswa_id = $mahasiswa->id;
            $log->update();
         } else {
            $log->mahasiswa_id = $mahasiswa->id;
            $log->save();
         }

         $token = $this->jwt($mahasiswa);

         return response()->json([
            'token' => $token,
         ], 200);
      } else {

         return response([
            'error' => 'Login failed.'
         ], 422);
      }
   }



   // public function authenticate(Request $request)
   // {
   //    $this->validate($request, [
   //       'email' => 'required|email',
   //       'password' => 'required'
   //    ]);

   //    $username = $request->input('email');
   //    $password = $request->input('password');

   //    $selectedUser = User::where('email', '=', $username)->first();

   //    if ($selectedUser && Hash::check($password, $selectedUser->password)) {

   //       $username = $selectedUser->username;

   //       $token = $this->jwt($selectedUser);

   //       return response()->json([
   //          'status' => 'success',
   //          'message' => 'Login success.',
   //          'data' => $selectedUser,
   //          'token' => $token,
   //       ], 200);
   //    } else {

   //       return response([
   //          'status' => 'error',
   //          'message' => 'Login failed.'
   //       ], 422);
   //    }
   // }
}
