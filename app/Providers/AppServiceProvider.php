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
        $credentialsPath = env('FIREBASE_CREDENTIALS', '/tmp/firebase-service-account.json');

        if (! $credentialsJson) {
            return;
        }

        File::ensureDirectoryExists(dirname($credentialsPath));

        file_put_contents($credentialsPath, $credentialsJson);

        putenv("FIREBASE_CREDENTIALS={$credentialsPath}");
        $_ENV['FIREBASE_CREDENTIALS'] = $credentialsPath;
        $_SERVER['FIREBASE_CREDENTIALS'] = $credentialsPath;

        logger('FIREBASE_CREDENTIALS: ' . $_ENV['FIREBASE_CREDENTIALS']);
    }
}
