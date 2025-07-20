<?php

namespace App\Providers;

use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

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
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
            ->locales(['en', 'id']);
        });

        
        // $this->loadTranslationsFrom(resource_path('lang/vendors/filament'), 'filament');
        // if ($this->app->environment('local')) {
        //     // Memastikan URL yang dihasilkan adalah HTTPS jika menggunakan link dari Mailtrap
        //     URL::forceScheme('https');
        // }
        
        // // Konfigurasi tambahan untuk Mailtrap (opsional)
        // if (config('mail.default') === 'smtp' && config('mail.mailers.smtp.host') === 'smtp.mailtrap.io') {
        //     // Tambahkan metadata untuk memudahkan identifikasi email di Mailtrap
        //     config(['mail.headers' => [
        //         'X-Environment' => app()->environment(),
        //         'X-Application-Name' => config('app.name'),
        //     ]]);
        // }
    }
    
}
