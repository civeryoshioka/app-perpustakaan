<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

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
        // View pagination bawaan Laravel (tailwind/bootstrap-4/5) pakai ikon SVG
        // dan class CSS framework yang tidak ter-load di project ini (cuma CSS
        // custom polos di layouts/app.blade.php) — tanpa ini, ikon SVG tampil
        // mentah raksasa karena ukurannya seharusnya diatur oleh class Tailwind
        // yang tidak ada. View custom ini murni teks/link, konsisten dengan
        // gaya visual project.
        Paginator::defaultView('vendor.pagination.custom');
    }
}
