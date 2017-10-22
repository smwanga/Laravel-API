<?php

namespace App\Providers;

use App\Auth\UserProvider;
use App\Guards\SimpleGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::extend('simpleapi', function ($app, $name, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\Guard...
            //dd($config);
            $model = $app['config']['auth.providers.token.model'];

            $provider = new UserProvider($app->make(HasherContract::class), $model);

            return new SimpleGuard($provider, request());
        });
    }
}
