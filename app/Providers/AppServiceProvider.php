<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
        Password::default(function(){
            return env('APP_ENV')=='local' ?
                Password::min(6) :
                Password::min(6)
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised();
        });
        
        DB::listen(function ($query){
            Log::info($query->sql);
        });
    }
}
