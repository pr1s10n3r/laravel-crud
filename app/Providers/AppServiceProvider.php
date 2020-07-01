<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use NumberFormatter;

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
        Blade::directive('money', function ($value) {
            return '<?php
                $fmt = numfmt_create(\'de_DE\', NumberFormatter::CURRENCY );
                echo numfmt_format_currency($fmt, ' . $value . ', \'COP\');
            ?>';
        });
    }
}
