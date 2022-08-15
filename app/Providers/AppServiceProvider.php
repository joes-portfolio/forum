<?php

namespace App\Providers;

use App\Models\Channel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        \Illuminate\Support\Facades\View::composer(
            ['threads.create', 'layouts.navigation'],
            function ($view) {
                $channels = Cache::rememberForever(
                    'channels',
                    fn () => Channel::all(),
                );

                return $view->with('channels', $channels);
            }
        );
    }

    public function boot(): void
    {
        //
    }
}
