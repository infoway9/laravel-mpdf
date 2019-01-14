<?php

namespace Infoway\mPdf;

use Illuminate\Support\ServiceProvider;

class mPdfServiceProvider extends ServiceProvider {

    public function boot() {
        $this->publishes([
            __DIR__ . '/../config/pdf.php' => config_path('pdf.php'),
                ], 'laravel-mpdf');
    }

    public function register() {

        $this->mergeConfigFrom(
                __DIR__ . '/../config/pdf.php', 'pdf'
        );
        $this->app->bind('Infoway.mpdf.LaravelMpdfWrapper', function($app) {
            return new LaravelMpdfWrapper();
        });
    }

}
