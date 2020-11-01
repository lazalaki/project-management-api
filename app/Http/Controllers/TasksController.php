<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Services\Task\TaskService;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }


    public function getAllTasks(Project $project)
    {
        return $this->taskService->getAllTasks($project);
    }


    public function createTask(Project $project, TaskRequest $request)
    {
        return $this->taskService->createTask($project, $request);
    }
}
