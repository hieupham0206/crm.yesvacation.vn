<?php

namespace App\Providers;

use App\Entities\Core\Menu;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Carbon::setLocale(config('app.locale'));
        \Schema::defaultStringLength(191);

        $theme  = config('theme.name');
        $layout = "layouts.themes.{$theme}";

        view()->share('layout', $layout);
        view()->share('theme', $theme);
        view()->share('breadcrumbs', []);
        view()->composer([$layout . '.partials.vertical_menu', $layout . '.partials.horizontal_menu'], function ($view) {
            $menus = Menu::generate();

            return $view->with('menus', $menus);
        });
        view()->composer('*', function ($view) {
            $view->with('currentUser', auth()->user());
        });

        //force https trong môi trưởng production
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        if ($this->app->environment() == 'local') {
            $this->app->register(\Reliese\Coders\CodersServiceProvider::class);
        }
    }
}
