<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\CartController;
use View;
use App\User;

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
        view()->composer('*', function($view){
            $c = new CartController();
            $cart="";$user = auth()->user();
            if (Auth::check()) {
              $cart = $c->getCartItems();
            }

            $view->with('cart', $cart)->with(compact('user'));
        });

    }
}
