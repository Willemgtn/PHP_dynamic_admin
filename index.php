<?php
ob_start();
include('config.php');

// include('classes/autoload.php');
ViewMetrics::updateOnlineUser();
ViewMetrics::cookieCounter();
// if(isset($_GET['code'])){
//     header('Location: ./?url=login');
//     // Painel::redirect('./?url=login');
// }
// $sql = DButils2::selectWhere('*', 'tb_site.home', 'id = 1');
// $sql = $sql[0];

// $homeController = new controllers\homeController();
// $empreendimentosController = new controllers\empreendimentoController();

// Router::get('', function () use ($homeController) {
//     $homeController->index('');
// });
// Router::get('?', function ($par) use ($empreendimentosController) {
//     $empreendimentosController->index($par);
// });

$init = new controllers\homeController();
$init->initialIndex();
ob_end_flush();
