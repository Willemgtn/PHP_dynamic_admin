<?php
// include('../config.php');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if (isset($_GET['logout'])) {
    Painel::logout();
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de controle</title>
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="./css/main.css">
    <style>
        @media screen and (max-width: 500px) {
            aside.menu {
                display: none;
                flex-grow: 10;
            }

            main.dash section table tbody tr :nth-child(1) {
                /* background: black;
                word-break: break-all; */
                max-width: 100px;
                overflow-x: clip;
                overflow-x: -ms-hidden-unscrollable;
            }
        }
    </style>
</head>

<body>
    <?php
    // $_SESSION['avatar'] = '../img/default_profile.webp';
    // $_SESSION['avatar'] = null;
    // unset($_SESSION['avatar']);
    ?>


    <!-- <div class="red-box"><i class="fa-solid fa-circle-exclamation"> </i> User or password mismatched</div> -->
    <!-- logged in -->
    <aside class="menu f-left">
        <header class="center">
            <div class="avatar center" <?php if ($_SESSION['avatar'] != null) {
                                            echo 'style="background-image: url(./uploads/' . $_SESSION['avatar'] . ');">'
                                        ?> <?php
                                        } else {
                                            ?>><i class="fa-solid fa-user-large"></i>
            <?php } ?>
            <!-- <img src="../img/default_profile.webp" alt="profile_picture"> -->
            </div>

            <div class="info">
                <p><?php echo $_SESSION['name'] ?></p>
                <p><?php echo UsersMod::nameRole($_SESSION['role']) ?></p>
            </div>
        </header>
        <nav>
            <a href="./">
                <i class="fa-solid fa-house-user"></i>
                Home</a>
            <?php
            $navItems = (array(
                ['permission' => '1', 'type' => 'title', 'content' => 'Edit Page'],
                ['permission' => '2', 'type' => 'link', 'link' => '?url=editHomePage', 'content' => 'Edit Home Page'],
                ['permission' => '1', 'type' => 'link', 'link' => '?url=editSlide', 'content' => 'Edit Slides'],
                ['permission' => '1', 'type' => 'link', 'link' => '?url=editDepo', 'content' => 'Edit Depoimentos'],
                ['permission' => '1', 'type' => 'link', 'link' => '?url=editService', 'content' => 'Edit Serviços'],


                // ['permission' => '1', 'type' => 'title', 'content' => 'Cadastro'],
                // ['permission' => '1', 'type' => 'link', 'link' => '?url=addDepo', 'content' => 'Cadastro Depoimento'],
                // ['permission' => '1', 'type' => 'link', 'link' => '?url=addService', 'content' => 'Cadastro Serviços'],
                // ['permission' => '1', 'type' => 'link', 'link' => '?url=addSlide', 'content' => 'Cadastro Slides'],

                // ['permission' => '0', 'type' => 'title', 'content' => 'Gestão'],
                // ['permission' => '0', 'type' => 'link', 'link' => '?url=listDepo', 'content' => 'Listar Depoimento'],
                // ['permission' => '0', 'type' => 'link', 'link' => '?url=listService', 'content' => 'Listar Serviços'],
                // ['permission' => '0', 'type' => 'link', 'link' => '?url=listSlide', 'content' => 'Listar Slides'],

                ['permission' => '1', 'type' => 'title', 'content' => 'Administração do painel'],
                ['permission' => '2', 'type' => 'link', 'link' => '?url=editUsers', 'content' => 'Editar Usuarios'],
                // ['permission' => '1', 'type' => 'link', 'link' => '?url=userAdd', 'content' => 'Adicionar Usuario'],

                ['permission' => '2', 'type' => 'title', 'content' => 'Configuração Geral'],
                ['permission' => '0', 'type' => 'link', 'link' => '?url=userEdit', 'content' => 'Editar Usuario'],

                ['permission' => '2', 'type' => 'title', 'content' => 'Isaac - Eventos '],
                ['permission' => '2', 'type' => 'link', 'link' => '', 'content' => 'Plataforma de eventos'],
                ['permission' => '2', 'type' => 'link', 'link' => '', 'content' => 'Assinaturas mensal'],
                ['permission' => '2', 'type' => 'link', 'link' => '', 'content' => 'Add/edit events'],
                ['permission' => '2', 'type' => 'link', 'link' => '', 'content' => 'admin panel'],
                ['permission' => '2', 'type' => 'link', 'link' => '', 'content' => 'Member area'],
                ['permission' => '2', 'type' => 'link', 'link' => '', 'content' => 'finance area'],
                ['permission' => '2', 'type' => 'link', 'link' => '', 'content' => ''],



            ));

            foreach ($navItems as $key => $value) {
                if ($value['permission'] <= $_SESSION['role']) {
                    // print_r($value);
                    switch ($value['type']) {
                        case 'title':
                            echo "<h3>" . $value['content'] . "</h3>";
                            break;
                        case 'link':
                            echo '<a href="' . $value['link'] . '">' . $value['content'] . "</a>";
                            break;
                        default:
                            # code...
                            break;
                    }
                }
            }
            ?>
            <!-- <h3>Cadastro</h3>
            <a href="">Cadastro Depoimento</a>
            <a href="">Cadastro Serviço</a>
            <a href="">Cadastro Slides</a>

            <h3>Gestão</h3>
            <a href="">Listar Depoimentos</a>
            <a href="">Listar Serviços</a>
            <a href="">Listar Slides</a>

            <h3>Administração do painel</h3>
            <a href="?url=userEdit">Editar Usuario</a>
            <a href="?url=userAdd">Adicionar Usuario</a>

            <h3>Configuração Geral</h3>
            <a href="">Editar</a> -->
        </nav>

    </aside>

    <main class="dash">
        <header>
            <nav>
                <div class="center">
                    <div class="menu-btn">
                        <i class="fa-solid fa-bars"></i>
                    </div>
                    <div class="logout f-right">
                        <a href="./?logout"> <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
                    </div>
                </div>
            </nav>

        </header>
        <section id="views" class="center">
            <h2>
                <i class="fa-solid fa-house"></i>
                Painel de Controle - Dashboard
            </h2>
            <?php
            $usersOnline = Painel::listOnlineUsers();
            ?>
            <div class="usersOnline">
                <p>Users online</p>
                <span id="usersOnline">
                    <?php echo count($usersOnline);
                    //   echo $usersOnline -> rowCount(); 
                    ?>
                </span>
            </div>
            <div class="totalVisits">
                <p>Total visits</p>
                <span id="totalVisits">
                    <?php echo Painel::totalVisits(); ?>
                </span>
            </div>
            <div class="todaysVisits">
                <p>Todays visits</p>
                <span id="todaysVisits">
                    <?php echo Painel::todaysVisits(); ?>
                </span>
            </div>
        </section>


        <?php

        if (isset($_GET["url"])) {
            if (!ctype_alpha($_GET['url'])) {
                die('Alpha only; Incidend will be reported!');
            }
            if (file_exists("./pages/" . $_GET["url"] . ".html")) {
                include("./pages/" . $_GET["url"] . ".html");
            } elseif (file_exists("./pages/" . $_GET["url"] . ".php")) {
                include("./pages/" . $_GET["url"] . ".php");
            } else {
                include("../pages/404.html");
            }
        } else {
            include('./pages/section-viewMetrics.php');
            include('./pages/section-users.php');
        }

        // echo "<hr>";
        // print_r($_SESSION);
        // // print_r($_SESSION['avatar']);
        // echo "<hr>";

        // for($i=0; $i<100; $i++){
        //     echo"<h2> testando</h2>";
        // }
        ?>



    </main>

    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/dashboardMain.js"></script>

    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>


    <script>
        tinymce.init({
            selector: 'textarea',
            plugin: 'image'
        });
    </script>
</body>

</html>