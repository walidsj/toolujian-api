<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{

   public function send(Request $request)
   {
      $this->validate($request, [
         'message' => 'required|max:255|min:4',
      ]);

      $message = $request->input('message');
      $user = $request->auth;

      $chat = new Message();
      $chat->mahasiswa_id = $user->id;
      $chat->message = $message;
      $chat->save();

      return response()->json(['alert' => 'Message sent.', 'message' => $chat], 200);
   }
}
