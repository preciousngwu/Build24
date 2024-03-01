<?php

namespace App\Providers;

use App\Interfaces\ApiRouteInterface;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
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
            $action = $action . Str::ucfirst(request()->action ?? "Index");

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

        Str::macro('join_name', function ($first, $last, $middle = "") {
            return Str::of($first)->append(" ", $last, " ", $middle);
        });

        Str::macro('split_name', function ($str) {
            $names  = explode(' ', $str);
            $expose = [];
            if (count($names) > 2) {
                $expose = [
                    "first_name"  => $names[0] ?? "",
                    "middle_name" => $names[1] ?? "",
                    "last_name"   => $names[2] ?? "",
                ];
            } else {
                $expose = [
                    "first_name" => $names[0] ?? "",
                    "last_name"  => $names[1] ?? "",
                ];
            }
            return $expose;
        });

        Validator::extend('without_spaces', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });

    }
}
