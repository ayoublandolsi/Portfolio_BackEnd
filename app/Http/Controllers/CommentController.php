<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{


    public function getAllUsers()
    {
        $comments = DB::table('comments')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->select('comments.*', 'users.name', 'users.avatar')
            ->orderBy('comments.created_at', 'desc')
            ->get();

        return $comments;
    }


    public function index()
    {
        $userId = Auth::id();
        return Comment::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
    }

    public function store(Request $request)
    {
        try{
        $validatedData = $request->validate([
            'comment' => 'required',
            'stars' => 'required|numeric|min:1|max:5',
            'user_id' => 'required',
        ]);


            $comment = Comment::create( $validatedData);

            return response()->json(['message' => 'the comment added succesfuly'], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while adding the comment.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        $comment = Comment::find($id);
        return response()->json([
            'comment' => $comment,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'comment' => 'required',
            'stars' => 'required|numeric|min:1|max:5',
            'user_id' => 'required',
        ]);

        try {
            $comment= Comment::find($id);
            $comment->update($validatedData);

            return response()->json(['message' => 'the comment updated succesfuly'], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the comment.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $comment = Comment::find($id);
            if (!$comment) {
                return response()->json([
                    'message' => 'Comment not found.',
                ], 404);
            }

            $comment->delete();

            return response()->json([
                'message' => 'The comment was deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the comment.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}

