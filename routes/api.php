<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\Auth\UsersController;
use App\Http\Controllers\TasksController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//API ROUTES
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('/register', [UsersController::class, 'register']);
    Route::post('/login', [UsersController::class, 'login']);
});


//ALL ROLES ROUTES
Route::group([
    'middleware' => 'auth'
], function () {
    Route::get('/users/projects/{user}', [ProjectsController::class, 'getProjectsForGivenUser']);
    Route::get('/projects/{projectId}', [ProjectsController::class, 'getProjectById']);
    Route::get('/projects/{project}/tasks', [TasksController::class, 'getAllTasks']);
});



//SUPERADMIN ROUTES
Route::group([
    'middleware' => 'auth.role:superAdmin'
], function () {
    Route::get('/users', [UsersController::class, 'getUsers']);
    Route::post('/users/{user}', [UsersController::class, 'updateRole']);
});



//ADMIN AND SUPERADMIN ROUTES
Route::group([
    'middleware' => 'auth.role:admin,superAdmin'
], function () {
    Route::post('/projects/create', [ProjectsController::class, 'createProject']);
    Route::post('/projects/{project}', [ProjectsController::class, 'deleteProject']);
    Route::post('/projects/{project}/invitation', [ProjectsController::class, 'addMemberToProject']);
    Route::patch('/projects/{project}/update', [ProjectsController::class, 'updateProject']);
    Route::post('/projects/{project}/tasks/create', [TasksController::class, 'createTask']);
});
