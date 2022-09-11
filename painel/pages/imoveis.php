<?php
$pageTable = 'tb_admin.imoveis';
$pageTableImg = 'tb_admin.imoveis_imagens';
function pageUrl($next = null)
{
    $baseUrl = './imoveis';
    // echo $baseUrl . $next;
    // return $baseUrl . $next;
    return $next ? $baseUrl . $next : $baseUrl;
}
$maxItemsPerPage = 6;
