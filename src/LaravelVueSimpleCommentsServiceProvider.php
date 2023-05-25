<?php

namespace GlebRed\LaravelVueSimpleComments;

use GlebRed\LaravelVueSimpleComments\Models\Comment;
use Illuminate\Support\ServiceProvider;

class LaravelVueSimpleCommentsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        $this->loadViewsFrom(__DIR__.'/../resources/js', 'laravel-vue-simple-comments');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if ($this->app->runningInConsole()) {
            // Publishing the views.
            $this->publishes([
                __DIR__.'/../resources/js' => resource_path('js/vendor/laravel-vue-simple-comments'),
            ], 'laravel-vue-simple-comments');

            // Publishing the model.
            $this->publishes([
                __DIR__.'/Models' => app_path('Models'),
            ], 'laravel-vue-simple-comments');

            // Publishing the migrations.
            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'laravel-vue-simple-comments');

            // Publishing the requests.
            $this->publishes([
                __DIR__.'/Requests/CommentRequest.php' => app_path('Http/Requests/CommentRequest.php'),
            ], 'laravel-vue-simple-comments');

            // Publishing the traits.
            $this->publishes([
                __DIR__.'/Traits/HasComments.php' => app_path('Models/Traits/HasComments.php'),
            ], 'laravel-vue-simple-comments');

            // Publishing the resources.
            $this->publishes([
                __DIR__.'/Resources/CommentResource.php' => app_path('Http/Resources/CommentResource.php'),
            ], 'laravel-vue-simple-comments');

              // Registering package model.
            $this->app->bind('LaravelVueSimpleComments\Models\Comment', function () {
                return new Comment;
            });
    
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Register the main class to use with the facade
        $this->app->singleton('laravel-vue-simple-comments', function () {
            return new LaravelVueSimpleComments;
        });
    }
}
