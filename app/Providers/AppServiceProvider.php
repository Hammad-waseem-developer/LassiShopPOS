<?php

namespace App\Providers;

use Config;
use App\utils\helpers;
use App\Models\Notification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        try {
            $helpers           = new helpers();
            $currency          = $helpers->Get_Currency();
            $symbol_placement  = $helpers->get_symbol_placement();
            $notifications = Notification::with('NotificationDetail')
                // ->where('notification_details.user_id', auth()->user()->id)
                ->orderBy('id', 'desc')
                ->get();

            View::share([
                'currency'         => $currency,
                'symbol_placement' => $symbol_placement,
                'notifications' => $notifications,
            ]);
        } catch (\Exception $e) {

            return [];
        }

        Schema::defaultStringLength(191);
        if (isset($_COOKIE['language'])) {
            App::setLocale($_COOKIE['language']);
        } else {
            App::setLocale('en');
        }
    }
}
