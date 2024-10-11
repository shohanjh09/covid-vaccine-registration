<?php

namespace App\Providers;

use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\VaccinationRepository;
use App\Repositories\VaccinationRepositoryInterface;
use App\Repositories\VaccinationCenterCapacityRepository;
use App\Repositories\VaccinationCenterCapacityRepositoryInterface;
use App\Repositories\VaccinationCenterRepository;
use App\Repositories\VaccinationCenterRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->app->bind(VaccinationCenterRepositoryInterface::class, VaccinationCenterRepository::class);

        $this->app->bind(VaccinationCenterCapacityRepositoryInterface::class, VaccinationCenterCapacityRepository::class);

        $this->app->bind(VaccinationRepositoryInterface::class, VaccinationRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
