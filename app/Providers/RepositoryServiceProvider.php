<?php

namespace App\Providers;

use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\SalesRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\SalesRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SalesRepositoryInterface::class, SalesRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
