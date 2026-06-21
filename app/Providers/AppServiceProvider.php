<?php

namespace App\Providers;

use App\Services\IPONZService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(IPONZService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Windows fix: the project path contains parentheses which causes tempnam()
        // to fail writing to the storage directory and fall back to system temp,
        // emitting an E_WARNING that Laravel converts to a fatal ErrorException.
        // We redirect PHP's temp dir to a simple path and suppress the warning.
        if (PHP_OS_FAMILY === 'Windows') {
            $tmpDir = sys_get_temp_dir();
            putenv('TMP=' . $tmpDir);
            putenv('TEMP=' . $tmpDir);
        }

        set_error_handler(function (int $code, string $message, string $file, int $line): bool {
            if ($code === E_WARNING && str_contains($message, 'tempnam()')) {
                return true; // suppress — file was still created successfully
            }
            return false; // pass everything else to Laravel's default handler
        }, E_WARNING);
    }
}
