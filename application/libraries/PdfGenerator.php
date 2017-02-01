<?php

/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 25/10/2016
 * Time: 16:43
 */
class PdfGenerator
{
    public function generate($html,$filename)
    {
        define('DOMPDF_ENABLE_AUTOLOAD', false);
        require_once("./vendor/dompdf/dompdf/dompdf_config.inc.php");

        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->render();
        $dompdf->stream($filename.'.pdf',array("Attachment"=>0));
    }
}