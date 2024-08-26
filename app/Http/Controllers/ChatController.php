<?php

namespace App\Http\Controllers;

use App\Events\ChatSent;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
        public function sendMessage($user_id, Request $request)
        {
            $validator = Validator::make($request->all(), [
                'message' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            $sender = Auth::user();
            $reciver = User::find($user_id);

            if (!$reciver) {
                return response()->json(['error' => 'receiver not found'], 404);
            }

            $message = new Message([
                'sender' => $sender->id,
                'reciver' => $reciver->id,
                'message' => $request->input('message'),
            ]);

            $message->save();

            broadcast(new ChatSent($reciver, $message))->toOthers();

            return response()->json(['message' => 'Message sent']);
        }
    }

