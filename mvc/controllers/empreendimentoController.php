<?php

namespace controllers;

class empreendimentoController
{
    function index($par)
    {
        \views\mainView::render('empreendimento.php');
    }
}
