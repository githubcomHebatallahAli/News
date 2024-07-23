<?php

namespace App\Providers;

use App\Models\News;
use App\Policies\NewsPolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('manage_users', function($user) {
            return    Auth::guard('admin')->check();
        });

        // Gate::policy(News::class, NewsPolicy::class);


        Schema::defaultStringLength(191);
    }

    }

