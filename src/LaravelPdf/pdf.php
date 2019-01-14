<?php

namespace Infoway\mPdf;

use Config;
use Mpdf;
use Mpdf\Config\ConfigVariables;

/**
 * Laravel PDF: mPDF wrapper for Laravel 5
 *
 * @package laravel-pdf
 * @author Sumanta Kr Ghosh
 */
class pdf {

    protected $config = [];

    public function __construct($html = '', $config = []) {
        $this->config = $config;
        $required_mpdf_config = [
            'mode' => $this->getConfig('mode'), // mode - default ''
            'format' => $this->getConfig('format'), // format - A4, for example, default ''
            'margin_left' => $this->getConfig('margin_left'), // margin_left
            'margin_right' => $this->getConfig('margin_right'), // margin right
            'margin_top' => $this->getConfig('margin_top'), // margin top
            'margin_bottom' => $this->getConfig('margin_bottom'), // margin bottom
            'margin_header' => $this->getConfig('margin_header'), // margin header
            'margin_footer' => $this->getConfig('margin_footer'), // margin footer
            'tempDir' => $this->getConfig('tempDir')            // margin footer
        ];

        // Manage custom fonts
        $mpdf_config = $this->addCustomFontsConfig(array_merge($required_mpdf_config, $config));
        $this->mPdf = new Mpdf\Mpdf($mpdf_config);

        $this->mPdf->SetTitle('Laravel mPdf');
        $this->mPdf->SetAuthor($this->getConfig('author'));
        $this->mPdf->SetCreator($this->getConfig('creator'));
        $this->mPdf->SetSubject($this->getConfig('subject'));
        $this->mPdf->SetKeywords($this->getConfig('keywords'));
        $this->mPdf->SetDisplayMode($this->getConfig('display_mode'));

        if (isset($this->config['instanceConfigurator']) && is_callable(($this->config['instanceConfigurator']))) {
            $this->config['instanceConfigurator']($this->mpdf);
        }
        $this->mPdf->WriteHTML($html);
    }

    protected function getConfig($key) {
        if (isset($this->config[$key])) {
            return $this->config[$key];
        } else {
            return Config::get('pdf.' . $key);
        }
    }

    protected function addCustomFontsConfig($mpdf_config) {
        if (!Config::has('pdf.font_path') || !Config::has('pdf.font_data')) {
            return $mpdf_config;
        }
        // Get default font configuration in mPdf package
        $object = ConfigVariables();
        $fontDirs = $object->getDefaults()['fontDir'];
        $fontData = $object->getDefaults()['fontdata'];

        // Merge default fonts cconfig value with custom configuration
        $mpdf_config['fontDir'] = array_merge($fontDirs, [Config::get('pdf.font_path')]);
        $mpdf_config['fontdata'] = array_merge($fontData, Config::get('pdf.font_data'));
        return $mpdf_config;
    }

    /**
     * Return the PDF as a String to the developer for further processing.
     *
     * @return string The rendered PDF as string
     */
    public function output() {
        return $this->mPdf->Output('', 'S');
    }

    /**
     * Save the PDF in server
     *
     * @param $filename
     * @return static
     */
    public function save($filename) {
        return $this->mPdf->Output($filename, 'F');
    }

    /**
     * Download the pdf
     *
     * @param string $filename
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function download($filename = 'document.pdf') {
        return $this->mPdf->Output($filename, 'D');
    }

    /**
     * Show the content in the browser
     *
     * @param string $filename
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function stream($filename = 'document.pdf') {
        return $this->mPdf->Output($filename, 'I');
    }

}
