<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
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
        $credentialsJson = env('FIREBASE_CREDENTIALS_JSON');
        $credentialsPath = env('FIREBASE_CREDENTIALS');

        if ($credentialsJson && $credentialsPath) {
            File::ensureDirectoryExists(dirname($credentialsPath));

            file_put_contents($credentialsPath, $credentialsJson);
        }
    }
}
