<?php

namespace App\Providers;

use App\Repositories\BloqueRepository;
use App\Repositories\Contracts\BloqueRepositoryInterface;
use App\Repositories\Contracts\PiezaRepositoryInterface;
use App\Repositories\Contracts\ProyectoRepositoryInterface;
use App\Repositories\PiezaRepository;
use App\Repositories\ProyectoRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ProyectoRepositoryInterface::class, ProyectoRepository::class);
        $this->app->bind(BloqueRepositoryInterface::class, BloqueRepository::class);
        $this->app->bind(PiezaRepositoryInterface::class, PiezaRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
