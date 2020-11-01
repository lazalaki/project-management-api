<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\Project' => 'App\Policies\ProjectPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isSuperAdmin', function (User $user) {
            return $user->role === 'superAdmin';
        });

        Gate::define('isAdmin', function (User $user) {
            return $user->role === 'superAdmin' || $user->role === 'admin';
        });

        Gate::define('containsUser', function (User $user, Project $project) {
            return $user->is($project->owner) || $project->members->contains($user);
        });
    }
}
