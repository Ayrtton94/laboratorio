<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade as TemplateBlade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
		
		TemplateBlade::if('verifypermissions', function ($pers) {
			$permisos = collect(session('permisos'));
			$intersect = $permisos->pluck('name')->intersect($pers);
			return  $intersect->count() > 0 ;
		});

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		//
    }
}
