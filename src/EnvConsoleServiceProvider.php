<?php

namespace Akbarcandra\EnvConsole;

use Illuminate\Support\ServiceProvider;
use Akbarcandra\EnvConsole\Console\Commands\SetEnv;

class EnvConsoleServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/env-console.php', 'env-console');

        // Register the service the package provides.
        $this->app->singleton('env-console', function ($app) {
            return new EnvConsole;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['env-console'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/env-console.php' => config_path('env-console.php'),
        ], 'env-console.config');

        // Registering package commands.
        $this->commands([SetEnv::class]);
    }
}
