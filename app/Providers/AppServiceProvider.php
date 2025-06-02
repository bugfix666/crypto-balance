<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Interfaces\OperationRepositoryInterface;
use App\Repositories\Interfaces\PrecisionRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\WalletRepositoryInterface;
use App\Repositories\OperationRepository;
use App\Repositories\PrecisionRepository;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            OperationRepositoryInterface::class,
            OperationRepository::class
        );
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->bind(
            WalletRepositoryInterface::class,
            WalletRepository::class
        );
        $this->app->bind(
            PrecisionRepositoryInterface::class,
            PrecisionRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
