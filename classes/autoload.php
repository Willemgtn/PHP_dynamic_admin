<?php


spl_autoload_register(function ($class) {
    $debug = false;
    // project-specific namespace prefix
    $prefix = '';

    // For backwards compatibility
    $customBaseDir = '';

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


    $file = str_replace('\\', '/', $relativeClass) . '.php';
    // $baseDir = rtrim($baseDir, '/');
    if (file_exists($baseDir . $file)) {
        require($baseDir . $file);
    } else if (file_exists($baseDir . '../' . $file)) {
        require($baseDir . '../' . $file);
    } else if (file_exists($baseDir . '../../' . $file)) {
        require($baseDir . '../../' . $file);
    } else if (file_exists($baseDir . '../mvc/' . $file)) {
        require($baseDir . '../mvc/' . $file);
    } else {
        // echo "<hr> File could not be found:  $baseDir $relativeClass.php <hr>";
        if ($debug) {
            echo "<hr> File could not be found:  $baseDir $relativeClass.php <hr>";
        }
    }
    if ($debug) {
        echo "<hr> classes/Autoload::   baseDir: $baseDir, RelativeClass: $relativeClass <hr>";
    }
});
