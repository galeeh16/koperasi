<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\App\Services\DropdownService::class, \App\Repositories\DropdownRepository::class);
        $this->app->singleton(\App\Services\JenisSimpananService::class, \App\Repositories\JenisSimpananRepository::class);
        $this->app->singleton(\App\Services\AnggotaService::class, \App\Repositories\AnggotaRepository::class);
        $this->app->singleton(\App\Services\PekerjaanService::class, \App\Repositories\PekerjaanRepository::class);
        $this->app->singleton(\App\Services\JenisAkunService::class, \App\Repositories\JenisAkunRepository::class);
        $this->app->singleton(\App\Services\DataKasService::class, \App\Repositories\DataKasRepository::class);
        $this->app->singleton(\App\Services\DepartemenService::class, \App\Repositories\DepartemenRepository::class);
        $this->app->singleton(\App\Services\Transaction\PemasukanService::class, \App\Repositories\Transaction\PemasukanRepository::class);
        $this->app->singleton(\App\Services\Transaction\PengeluaranService::class, \App\Repositories\Transaction\PengeluaranRepository::class);
        $this->app->singleton(\App\Services\Transaction\TransferService::class, \App\Repositories\Transaction\TransferRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(! $this->app->isProduction());

        Response::macro('success', function(mixed $value, string $message = 'Success', int $status = 200) {
            return response()->json([
                'message' => $message,
                'data' => $value
            ], $status);
        });

        Response::macro('error', function(mixed $value, string $message = 'Internal Server Error', int $status = 500) {
            return response()->json([
                'message' => $message,
                'data' => $value
            ], $status);
        });
    }
}
