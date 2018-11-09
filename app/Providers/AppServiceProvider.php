<?php

namespace App\Providers;


use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Encore\Admin\Config\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Config::load();
        Blade::directive('dateFormat', function ($date, $days = 0) {

            return "<?php echo \Carbon\Carbon::parse($date)->format('d.m.Y'); ?>";

        });

        Blade::directive('dateNow', function () {

            return "<?php echo \Carbon\Carbon::now()->format('d.m.Y'); ?>";

        });



    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
