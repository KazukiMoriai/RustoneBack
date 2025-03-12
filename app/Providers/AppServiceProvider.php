<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // APIルートを直接ここで登録
        Route::prefix('api')->middleware('api')->group(function () {
            Route::post('/photos', [PhotoController::class, 'store']);

        });
    }
}