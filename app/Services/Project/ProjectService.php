<?php


namespace App\Services\Project;

use App\Models\Project;

class ProjectService
{
    public function getAllProjects($id)
    {
        $projects = Project::where('owner_id', $id)->get();

        return response()->json([
            'projects' => $projects
        ]);
    }
}
