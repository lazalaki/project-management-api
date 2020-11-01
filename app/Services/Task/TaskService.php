<?php

namespace App\Services\Task;

use Illuminate\Support\Facades\DB;
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
            $user = DB::table('users')->where('email', $request['email'])->first();

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
}
