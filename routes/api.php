<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\Auth\UsersController;

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
    Route::post('register', [UsersController::class, 'register']);
    Route::post('login', [UsersController::class, 'login']);
});


//ALL ROLES ROUTES
Route::group([
    'middleware' => 'auth'
], function () {
    Route::get('projects/{user}', [ProjectsController::class, 'getProjectsForGivenUser']);
    Route::get('projects/project/{projectId}', [ProjectsController::class, 'getProjectById']);
});



//SUPERADMIN ROUTES
Route::group([
    'middleware' => 'auth.role:superAdmin'
], function () {
    Route::get('/users', [UsersController::class, 'getUsers']);
    Route::post('/users', [UsersController::class, 'updateRole']);
});



//ADMIN ROUTES
Route::group([
    'middleware' => 'auth.role:admin|superAdmin'
], function () {
    Route::post('/projects/create', [ProjectsController::class, 'createProject']);
    Route::post('/projects/{project}', [ProjectsController::class, 'deleteProject']);
});
