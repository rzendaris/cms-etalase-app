<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\Model\Table\Notifikasi;
use Illuminate\Support\Facades\Auth;


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
        Blade::withoutDoubleEncoding();
        view()->composer(['panel.header'], function ($view) {
          $ratings = Notifikasi::with(['fromusers','apps'])->where('to_users_id',Auth::user()->id)->get();
          $view->with('data', $ratings);
 });
    }
}
