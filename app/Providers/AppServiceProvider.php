<?php

namespace App\Providers;

use App\Repositories\CommentRepositoryInterface;
use App\Repositories\CommentRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\NewsRepositoryInterface;
use App\Repositories\EloquentNewsRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NewsRepositoryInterface::class, EloquentNewsRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
