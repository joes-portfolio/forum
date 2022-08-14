<?php

namespace App\Providers;

use App\Models\Channel;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        \Illuminate\Support\Facades\View::composer(
            ['threads.create', 'layouts.navigation'],
            fn ($view) => $view->with('channels', Channel::all())
        );
    }

    public function boot(): void
    {
        //
    }
}
