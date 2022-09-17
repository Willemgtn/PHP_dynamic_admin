<?php
class Router
{
    static function get($path, $callback)
    {
        if (empty($_POST)) {
            $url = @$_GET['url'];
            if ($url == $path) {
                $callback();
                die();
            }
            $path = explode('/', $path);
            $url = explode('/', @$_GET['url']);
            $ok = true;
            $par = [];
            if (count($path) == count($url)) {
                foreach ($path as $key => $value) {
                    if ($value == '?') {
                        if ($url[$key] === '')
                            return;
                        $par[$key] = $url[$key];
                    } else if ($url[$key] != $value) {
                        $ok = false;
                        break;
                    }
                }
                if ($ok) {
                    $callback($par);
                    // die();
                    return true;
                }
            }
        }
    }
    static function post($path, $callback)
    {
        if (!empty($_POST)) {
            $url = @$_GET['url'];
            if ($url == $path) {
                $callback();
                die();
            }
            $path = explode('/', $path);
            $url = explode('/', @$_GET['url']);
            $ok = true;
            $par = [];
            if (count($path) == count($url)) {
                foreach ($path as $key => $value) {
                    if ($value == '?') {
                        $par[$key] = $url[$key];
                    } else if ($url[$key] != $value) {
                        $ok = false;
                        break;
                    }
                }
                if ($ok) {
                    $callback($par);
                    // die();
                    return;
                }
            }
        }
    }
}
