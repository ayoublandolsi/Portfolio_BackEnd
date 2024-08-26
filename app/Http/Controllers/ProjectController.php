<?php

namespace App\Http\Controllers;

use App\Models\Project;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index()
    {
        return Project::select('id','title', 'description', 'category', 'shortDescription', 'image', 'url', 'created_at', 'updated_at')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'shortDescription' => 'required',
            'category' => 'required',
            'url' => 'required|url',
            'image' => 'required|image|max:4096' // Adding extension and size requirements
        ]);

        try {
            $imageName = Str::random() . '.' . $request->image->getClientOriginalExtension();



            // Save the image locally
            Storage::disk('public')->putFileAs('project/image', $request->image, $imageName);


                      Project::create($request->post()+['image' =>$imageName]);

            return response()->json([
                'message' => 'The project was added successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while adding the project.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Project $project)
    {
        return response()->json([
            'project' => array_merge($project->toArray(), ['id' => $project->id])
        ]);
    }

    public function update(Request $request, Project $project)
    {
    $request->validate([
        'title' => 'required',
        'description' => 'required',
        'shortDescription' => 'required',
        'category' => 'required',
        'url' => 'required|url',
    'image' => 'nullable|image|max:4096' // Adding extension and size requirements
    ]);


try {

            $project->fill($request->all())->update();
            if ($request->hasFile('image')) {
                if ($Project->image) {
                        $exist = Storage::disk('public')->exists("Project/image/{$Project->image}"  );
                        if ($exist) {
                        Storage::disk('public')->delete("Project/image/{$Project->image}");
                        }
                }

            $imageName = Str::random() . '.' . $request->image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('Project/image', $request->image, $imageName);
            $Project->image = $imageName;
            $Project->save();

            }



            return response()->json([
                'message' => 'Item updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the project.',
                'error' => $e->getMessage(),
            ], 500);
        }

    }
    public function destroy($id)
    {

            $project = Project::find($id);
            if (!$project) {
                return response()->json([
                    'message' => 'Comment not found.',
                ], 404);
            }

            $project->delete();

            return response()->json([
                'message' => 'The comment was deleted successfully.',
            ]);

    }


}

