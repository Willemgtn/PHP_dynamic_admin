<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <title><?php echo $sql['pagetitle'] ?></title>
    <link rel="stylesheet" href="./fontawesome/css/all.css">
    <script src="./js/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="./css/loaders.css">
    <link rel="stylesheet" href="./css/notifications.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css" integrity="sha384-BY+fdrpOd3gfeRvTSMT+VUZmA728cfF9Z2G42xpaRkUGu2i3DyzpTURDo5A6CaLK" crossorigin="anonymous">
    <!-- page description -->
    <meta name="description" content="<?php echo $sql['pagedescription'] ?>">


    <link rel="stylesheet" href="./css/style.css">
    <style>
        section.banner-principal {
            background-image: url('./img/Landscape_mountain.jpg');
        }

        div.dropdown_menu {
            position: relative;
            display: inline-block;
        }

        ul.dropdown_content {
            display: none;
            position: absolute;
            background-color: #3D437ABA;
            /* opacity: 0.5; */
            /* min-width: 160px; */
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            /* padding: 12px 0; */
            z-index: 2;
        }

        .dropdown_menu:hover ul.dropdown_content,

        .dropdown_menu:focus ul.dropdown_content

        /* .dropdown_menu:active ul.dropdown_content */
            {
            display: block;
        }

        ul.dropdown_content li {
            padding: 12px 18px;
        }

        header.pageheader nav ul li span {
            /* padding: 1em 0px; */
            display: block;
        }
    </style>
</head>

<body>
    <header class="pageHeader">
        <div class="center">
            <div class="logo f-left"><a href="./"><?php //echo $sql['logotitle'] 
                                                    ?> Projeto 01</a></div>
            <nav class="desktop f-right">
                <div class="menu-btn">
                    <i class="fa-solid fa-bars"></i>
                </div>
                <ul>
                    <li class="dropdown_menu">
                        <span><a href="./">Home</a></span>

                        <ul class="dropdown_content">
                            <li><a href="./">Home</a></li>
                            <li><a href="./#sobre">Sobre</a></li>
                            <li><a href="./#servicos">Serviços</a></li>
                            <li><a href="./#sobre">Sobre</a></li>
                            <li><a href="./contact">Contatos</a></li>
                            <li><a href="./painel/">Admin</a></li>
                        </ul>
                    </li>
                    <li><a href="./imoveis">Imoveis</a></li>
                </ul>

            </nav>
        </div>
        <div class="clear"></div>
    </header>
    <?php print_r($_SESSION); ?>
    <br>
    <?php print_r($_GET); ?>