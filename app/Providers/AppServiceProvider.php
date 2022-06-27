<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Section;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        // Sharing Data With All Views
        View::share('sections', Section::translated()->get());
        View::share('categories', Category::translated()->get());
    }
}
