<?php

namespace Infoway\mPdf;

use File;
use View;

/**
 * Laravel PDF: mPDF wrapper for Laravel 5
 *
 * @package laravel-pdf
 * @author Sumanta Kr Ghosh
 */
class LaravelMpdfWrapper {

    /**
     * Load a HTML string
     *
     * @param string $html
     * @return Pdf
     */
    public function loadHTML($html, $config = []) {
        return new pdf($html, $config);
    }

    /**
     * Load a HTML file
     *
     * @param string $file
     * @return Pdf
     */
    public function loadFile($file, $config = []) {
        return new pdf(File::get($file), $config);
    }

    /**
     * Load a View and convert to HTML
     *
     * @param string $view
     * @param array $data
     * @param array $mergeData
     * @return Pdf
     */
    public function loadView($view, $data = [], $mergeData = [], $config = []) {
        return new pdf(View::make($view, $data, $mergeData)->render(), $config);
    }

}
