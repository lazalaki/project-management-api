<?php


namespace App\Services\Project;

use App\Models\Project;
use Illuminate\Support\Facades\Gate;

class ProjectService
{
    public function getAllProjects($user)
    {
        try {
            // $projects = Project::where('owner_id', $user->id)->latest()->get();
            $projects = $user->projects()->latest()->get();

            return response()->json([
                'projects' => $projects
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }




    public function createProject($projectData)
    {
        try {
            if (Gate::allows('create', Project::class)) {
                $project = auth()->user()->projects()->create($projectData);

                return response()->json([
                    'project' => $project
                ]);
            }
            return response()->json('Unauthorized for this action');
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }



    public function getProjectById($projectId)
    {
        try {
            $project = Project::findOrFail($projectId);

            return response()->json([
                'project' => $project
            ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }




    public function deleteProject($projectId)
    {
        try {
            $project = Project::findOrFail($projectId);

            if (Gate::allows('delete', $project)) {
                $project->delete();
                return response()->json([], 200);
            }
            return response()->json('Unauthorized for this action');
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
