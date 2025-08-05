<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
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
   public function boot()
{
    View::composer('*', function ($view) {
        if (Auth::check()) {
            $unreadCount = Auth::user()->unreadNotifications()->count();
            $unreadNotifications = Auth::user()->unreadNotifications()->latest()->take(1)->get();
            $view->with('unreadCount', $unreadCount)
                 ->with('unreadNotifications', $unreadNotifications);
        }
    });
}
}
