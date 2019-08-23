<?php

namespace Akbarcandra\EnvConsole;

use Illuminate\Support\ServiceProvider;

class EnvConsoleServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'akbarcandra');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'akbarcandra');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

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

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/akbarcandra'),
        ], 'env-console.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/akbarcandra'),
        ], 'env-console.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/akbarcandra'),
        ], 'env-console.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
