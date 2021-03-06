<?php

namespace App\Providers;

use App\Models\Document;
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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin-action', function (User $user) {
            return in_array('admin', explode(',', $user->roles));
        });
        Gate::define('update-document', function (User $user, Document $document) {
            return is_null($document->id) OR ($document->user_id === $user->id) OR $user->can('admin-action');
        });
        Gate::define('update-project', function (User $user, Project $project) {
            return is_null($project->id) OR ($project->user_id === $user->id) OR $user->can('admin-action');
        });
    }
}
