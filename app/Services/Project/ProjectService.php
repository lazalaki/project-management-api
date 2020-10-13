<?php


namespace App\Services\Project;

use App\Models\Project;

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
            $project = auth()->user()->projects()->create($projectData);

            return response()->json([
                'project' => $project
            ]);
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

            $project->delete();

            return response()->json([], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
