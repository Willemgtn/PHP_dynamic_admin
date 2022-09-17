<?php

require_once('./pages/header.php');

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

require_once('./pages/footer.php');
