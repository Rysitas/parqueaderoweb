<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Empresa;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Para compartir la informacion de la empresa con la aplicacion si esta existe, 
        if (Schema::hasTable('empresas')) {
            $empresa = Empresa::first();
            View::share('empresa', $empresa);
            
        }
    }
}
