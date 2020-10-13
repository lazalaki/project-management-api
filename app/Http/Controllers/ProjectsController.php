<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProjectRequest;
use App\Models\Project;
use App\Models\User;
use App\Services\Project\ProjectService;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }


    public function getProjectsForGivenUser(User $user)
    {
        return $this->projectService->getAllProjects($user);
    }


    public function createProject(CreateProjectRequest $request)
    {
        return $this->projectService->createProject($request->validated());
    }


    public function getProjectById($projectId)
    {
        return $this->projectService->getProjectById($projectId);
    }


    public function deleteProject(Project $project)
    {
        $this->authorize('delete', $project);

        return $this->projectService->deleteProject($project->id);
    }
}
