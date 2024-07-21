<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind('App\Repository\CategoryRepositoryInterface','App\Repository\CategoryRepository');
        $this->app->bind('App\Repository\ProductRepositoryInterface','App\Repository\ProductRepository');
    }


    public function boot()
    {
        //
    }
}
