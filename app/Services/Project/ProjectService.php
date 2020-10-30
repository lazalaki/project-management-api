<?php


namespace App\Services\Project;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class ProjectService
{
    public function getAllProjects($user)
    {
        try {
            $projects = $user->accessibleProjects();

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
            return response()->json('Unauthorized for this action');
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }



    public function getProjectById($projectId)
    {
        try {
            $project = Project::findOrFail($projectId)->load(['owner', 'members']);
            // dd($project);
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



    public function addMemberToProject($project, $email)
    {
        try {
            if (Gate::allows('isAdmin')) {
                $user = User::whereEmail($email)->first();

                if ($user == null) {
                    return response()->json(['error' => 'User with this email does not exist']);
                }

                if ($project->members->contains($user)) {
                    return response()->json(['error' => 'User with this email is already added']);
                }

                $project->invite($user);

                return response()->json([], 200);
            };
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }



    public function updateProject($project)
    {

        try {
            $project->update(request()->validate([
                'title' => 'sometimes|required',
                'description' => 'sometimes|required',
                'notes' => 'nullable'
            ]));

            return response()->json([], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
