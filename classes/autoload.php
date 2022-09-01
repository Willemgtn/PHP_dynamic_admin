<?php


spl_autoload_register(function ($class) {
    // project-specific namespace prefix
    $prefix = '';

    // For backwards compatibility
    $customBaseDir = '';
    // @todo v6: Remove support for 'FACEBOOK_SDK_V4_SRC_DIR'
    // if (defined('FACEBOOK_SDK_V4_SRC_DIR')) {
    //     $customBaseDir = FACEBOOK_SDK_V4_SRC_DIR;
    // } elseif (defined('FACEBOOK_SDK_SRC_DIR')) {
    //     $customBaseDir = FACEBOOK_SDK_SRC_DIR;
    // }

    // base directory for the namespace prefix
    $baseDir = $customBaseDir ?: __DIR__ . '/';

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relativeClass = substr($class, $len);
    // $relativeClass = $class;

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php

    // $file1 = rtrim($baseDir, '/') . '/' . str_replace('\\', '/', $relativeClass) . '.php';
    // $file2 = rtrim($baseDir, '/') . '/../' . str_replace('\\', '/', $relativeClass) . '.php';
    // $file3 = rtrim($baseDir, '/') . '/../../' . str_replace('\\', '/', $relativeClass) . '.php';
    // echo "Auth File required: $file1 <br>";



    // if the file exists, require it
    // if (file_exists($file1)) {
    //     require $file1;
    // } else if (file_exists($file2)){
    //     require $file2;
    // } else if (file_exists($file3)){
    //     require $file3;
    // } else {
    //     echo "<hr> File could not be found:  $baseDir $relativeClass.php <hr>";
    // }


    $file = str_replace('\\', '/', $relativeClass) . '.php';
    // $baseDir = rtrim($baseDir, '/');
    if (file_exists($baseDir . $file)) {
        require($baseDir . $file);
    } else if (file_exists($baseDir . '../' . $file)) {
        require($baseDir . '../' . $file);
    } else if (file_exists($baseDir . '../../' . $file)) {
        require($baseDir . '../../' . $file);
    } else {
        echo "<hr> File could not be found:  $baseDir $relativeClass.php <hr>";
    }
});
