<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Services\Md5HashProvider;

class Md5HashServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Auth::provider('md5', function ($app, array $config) {
            return new Md5HashProvider($app['hash'], $config['model']);
        });
    }

    public function register()
    {
        //
    }
} 