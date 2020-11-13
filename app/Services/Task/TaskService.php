<?php

namespace App\Services\Task;

use App\Models\User;
use Illuminate\Support\Facades\Gate;

class TaskService
{

    public function getAllTasks($project)
    {

        try {
            if (!Gate::allows('containsUser', $project)) {
                return response()->json(['error' => 'You do not have access to these tasks, you are not assigned to this project']);
            }
            return $project->tasks->load('user');
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }


    public function createTask($project, $request)
    {
        try {
            $user = User::where('email', $request['email'])->first();
            if (!$project->members->contains($user)) {
                return response()->json('User with this email is not on this project');
            }

            $task = $project->tasks()->create([
                'title' => $request['title'],
                'description' => $request['description'],
                'user_id' => $user->id
            ]);

            return response()->json([
                'task' => $task
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }


    public function updateStatus($project, $task)
    {
        if (!Gate::allows('canUpdateTask', [$project, $task])) {
            return response()->json(['error' => 'You are not assigned to this task']);
        };

        try {
            $task->update([
                'status' => request('status')
            ]);
            return $task;
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
