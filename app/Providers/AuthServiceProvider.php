<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Policies\UserModelPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserModelPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            return $user->isAdmin() ? true : null;
        });

        Gate::define('teacher', function ($user) {
            return $user->isTeacher();
        });

        Gate::define('student', function ($user) {
            return $user->isStudent();
        });
    }

}
