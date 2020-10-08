<?php


namespace App\Services\Project;


class ProjectService
{
    public function getAllProjects($user)
    {
        try {
            $projects = $user->projects;

            return response()->json([
                'projects' => $projects
            ]);
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
}
