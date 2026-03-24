<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Crud;
use App\Models\Notification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

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
        //
        if (Schema::hasTable('cruds')) {
            $crud = Crud::get();
            view()->share('crud', $crud);
        }

        // Share notifications with all views
        View::composer('*', function ($view) {
            if (Auth::check() && Schema::hasTable('notifications')) {
                $notifications = Notification::where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->limit(10)
                    ->get();

                $unreadCount = Notification::where('user_id', Auth::id())
                    ->where('is_read', 0)
                    ->count();

                $view->with('notifications', $notifications);
                $view->with('unreadCount', $unreadCount);
            }
        });
    }
}
