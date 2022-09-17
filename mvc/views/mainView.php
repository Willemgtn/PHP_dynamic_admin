<?php

namespace views;

class MainView
{
    static $param = [];
    static function setParam($par)
    {
        self::$param = $par;
    }
    static function render($filename, $header = 'mvc/templates/header.php', $footer = 'mvc/templates/footer.php')
    {
        include($header);
        include('mvc/templates/' . $filename);
        include($footer);
    }
    static function renderInitial($filename)
    {
        $header = 'pages/header.php';
        $footer = 'pages/footer.php';
        include($header);

        if (is_string($filename)) {
            if (file_exists('pages/' . $filename))
                include('pages/' . $filename);
        } else if (is_array($filename)) {
            foreach ($filename as $value) {
                if (file_exists('pages/' . $value))
                    include('pages/' . $value);
            }
        }

        include($footer);
    }
}
