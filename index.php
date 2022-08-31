<?php
include('config.php');


ViewMetrics::updateOnlineUser();
ViewMetrics::cookieCounter();
// if(isset($_GET['code'])){
//     header('Location: ./?url=login');
//     // Painel::redirect('./?url=login');
// }
$sql = DButils2::selectWhere('*', 'tb_site.home', 'id = 1');
$sql = $sql[0];
?>
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
    <!-- page description -->
    <meta name="description" content="<?php echo $sql['pagedescription'] ?>">


    <link rel="stylesheet" href="./css/style.css">
    <style>
        section.banner-principal {
            background-image: url('./img/Landscape_mountain.jpg');
        }
    </style>
</head>

<body>
    <?php
    require_once('./pages/pageHeader.php');
    ?>

    <?php
    // if(isset($_POST['emailSend'])){
    //     if($_POST['email'] != ''){
    //         $email = $_POST['email'];
    //         if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    //             echo '<script>alert("Invalid e-mail format")</script>';
    //         } else {
    //             $mail = new Email();
    //             $mail -> addrecipient ($email, 'john doe');
    //             $mail -> formatMail(array(
    //                 'subject' => 'php development',
    //                 'body' => 'it <strong>works</strong><hr> é isso aí ÂÊÎÔÛáéíóúàèìòùÏï Wï'
    //             ));
    //             $mail -> sendEmail();
    //         }
    //     } else { echo '<script>alert("No e-mail provided")</script>'; }
    // } else if(isset($_POST['contactSend'])){
    //     $nome = $_POST['nome'];
    //     $email = $_POST['email'];
    //     $telefone = $_POST['telefone'];
    //     $mensagem = $_POST['mensagem'];


    //     $emailBody = '';
    //     foreach ($_POST as $key => $value) {
    //         $emailBody .= ucfirst($key).": ".$value."<hr>";
    //     }
    //     $mail = new Email();
    //     $mail -> addrecipient ($email, 'Developer');
    //     $mail -> formatMail(array(
    //         'subject' => 'New Contact - php in development',
    //         'body' => $emailBody
    //     ));
    //     $mail -> sendEmail();
    // }



    // print_r($_GET);
    if (isset($_GET["url"])) {
        if (!ctype_alpha($_GET['url'])) {
            die('Alpha only Insidend will be reported!');
        }
        if (file_exists("./pages/" . $_GET["url"] . ".html")) {
            include("./pages/" . $_GET["url"] . ".html");
        } elseif (file_exists("./pages/" . $_GET["url"] . ".php")) {
            include("./pages/" . $_GET["url"] . ".php");
        } else {
            include("./pages/404.html");
        }
    } else {
        include('./pages/home.php');
        include('./pages/slides.php');
        include('./pages/extra.php');
    }
    ?>

    <div style="padding:  2em;"></div>
    <footer class="">
        <div class="center">
            <p>
                <i class="fa-solid fa-copyright"></i>
                Todos os direitos reservados
            </p>
        </div>
    </footer>

    <script>
        $(function() {
            $('header.pageHeader nav i').click(function() {
                var menuIcon = $('header.pageHeader nav .menu-btn i')
                var listaMenu = $('header.pageHeader nav ul')
                if (listaMenu.is(':hidden') == true) {
                    // listaMenu.fadeIn();
                    listaMenu.slideToggle();
                    menuIcon.removeClass('fa-bars')
                    menuIcon.addClass('fa-xmark')

                } else {
                    // listaMenu.fadeOut();
                    listaMenu.slideToggle();
                    menuIcon.removeClass('fa-xmark')
                    menuIcon.addClass('fa-bars')
                }
            })
        })
        // Animate scroll event to targeted interest point.
        // $('html, body').animate({scrollTop: $('footer').offset().top}, 2000)
    </script>
    <!-- <script src="./js/slider.js"></script> -->
    <script src="./js/animarEspecialidades.js"></script>
    <script src="./js/ajaxForm.js"></script>
</body>

</html>