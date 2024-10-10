<?php

namespace App\Providers;

use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\VaccinationRepository;
use App\Repositories\VaccinationRepositoryInterface;
use App\Repositories\VaccineCenterCapacityRepository;
use App\Repositories\VaccineCenterCapacityRepositoryInterface;
use App\Repositories\VaccineCenterRepository;
use App\Repositories\VaccineCenterRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            VaccineCenterRepositoryInterface::class,
            VaccineCenterRepository::class
        );

        $this->app->bind(
            VaccineCenterCapacityRepositoryInterface::class,
            VaccineCenterCapacityRepository::class
        );

        $this->app->bind(
            VaccinationRepositoryInterface::class,
            VaccinationRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
