<?php

namespace App\Http\Middleware;

use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\Semester;
use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class JwtMiddleware
{
   public function handle($request, Closure $next)
   {
      $token = $request->bearerToken();

      if (!$token) {
         return response()->json([
            'status' => 'error',
            'message' => 'Token not provided.'
         ], 401);
      }

      try {
         $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
      } catch (ExpiredException $e) {
         return response()->json([
            'status' => 'error',
            'message' => 'Provided token is expired.'
         ], 400);
      } catch (Exception $e) {
         return response()->json([
            'status' => 'error',
            'message' => 'An error while decoding token.'
         ], 400);
      }

      // $user = User::find($credentials->sub);
      // $user = Mahasiswa::with('semester', 'prodi', 'jurusan')->find($credentials->sub)->makeHidden('semester_id');

      $user = Mahasiswa::find($credentials->sub);

      // Now let's put the user in the request class so that you can grab it from there
      $request->auth = $user;

      return $next($request);
   }
}
