<?php

namespace App\Http\Controllers;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function create(Request $request)
    {
        Like::create([
            'user_id' => $request->user_id,
            'project_id' => $request->project_id,
        ]);

        return response()->json(['message' => 'Like created successfully']);
    }

    public function delete(Request $request)
    {
        Like::where('user_id', $request->user_id)
            ->where('project_id', $request->project_id)
            ->delete();

        return response()->json(['message' => 'Like deleted successfully']);
    }

    public function count(Request $request)
    {
        $count = Like::where('project_id', $request->project_id)->count();

        return response()->json(['count' => $count]);
    }
}
