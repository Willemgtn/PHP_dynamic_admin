<?php


if (file_exists('../vendor/autoload.php')) {
    require_once('../vendor/autoload.php');
    require_once('../../config.php');
} else {
    require_once('vendor/autoload.php');
}


ob_start();
include('pdfTemplateFinanceiro.php');
$conteudo = ob_get_contents();
ob_end_clean();


// echo $conteudo;




$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($conteudo);
$mpdf->Output();
