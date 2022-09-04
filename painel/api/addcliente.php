<?php

include("../../config.php");



if (!Painel::logado()) {
    $data = ['success' => false, 'error' => 'You must be logged in'];
    die(json_encode($data));
}







$data = ['success' => true];

die(json_encode($data));
