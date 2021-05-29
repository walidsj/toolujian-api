<?php

namespace App\Http\Middleware;

use App\Models\Log;
use App\Models\Mahasiswa;
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

      if (!empty($credentials->sub) && !empty($credentials->log)) {
         $user = Mahasiswa::find($credentials->sub);
         if ($user) {
            $log = Log::where('mahasiswa_id', $user->id)->orderBy('id', 'DESC')->first();
            if ($log->id != $credentials->log) {
               return response()->json([
                  'status' => 'error',
                  'message' => 'User was logged in a new device.'
               ], 400);
            }

            $user->log = $log;
         } else {
            return response()->json([
               'status' => 'error',
               'message' => 'User not found.'
            ], 400);
         }
      } else {
         return response()->json([
            'status' => 'error',
            'message' => 'Token not provided properly.'
         ], 400);
      }
      // Now let's put the user in the request class so that you can grab it from there
      $request->auth = $user;

      return $next($request);
   }
}
