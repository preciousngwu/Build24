<?php

namespace App\Providers;

use App\Interfaces\ApiRouteInterface;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ApiRouteInterface::class, function () {
            $api = explode("\\", request()->route()->getControllerClass());
            $api = $api[count($api) - 1];

            $action = 'App\Actions\\' . $api . '\\';
            $action = $action . Str::ucfirst(request()->action);

            return App($action);
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('success', function ($data, $code = 200) {
            return response()->json(['data' => $data], $code);
        });

        Response::macro('failed', function ($message, $code = 400) {
            return response()->json(['message' => $message], $code);
        });
    }
}
