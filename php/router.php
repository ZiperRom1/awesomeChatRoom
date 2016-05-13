<?php

require_once 'autoloader.php';

use \classes\IniManager as Ini;

/**
 * Routing function
 *
 * @param      string  $route  The given route to map
 */
function route($route)
{
    $path        = explode('/', $route);
    $method      = array_pop($path);
    $controller  = ucfirst(array_pop($path)) . 'Controller';
    $deep        = count($path);
    $currentDeep = 0;
    $route       = __DIR__ . DIRECTORY_SEPARATOR .'controllers';

    while ($currentDeep < $deep) {
        $route .= DIRECTORY_SEPARATOR . $path[$currentDeep++];

        if (!is_dir($route)) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request', true, 400);
            die();
        }
    }

    $route .= DIRECTORY_SEPARATOR . $controller . '.php';

    if (stream_resolve_include_path($route) === false) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found', true, 404);
        die(
            file_get_contents(
                dirname(__DIR__) . DIRECTORY_SEPARATOR .
                'static' . DIRECTORY_SEPARATOR .
                'html' . DIRECTORY_SEPARATOR .
                '404NotFound.html'
            )
        );
    }

    include_once $route;

    Ini::setIniFileName(Ini::INI_CONF_FILE);

    // If the print SQL debug mode is on start a buffer
    if (Ini::getParam('Console', 'printSql')) {
        ob_start();
    }

    $controllerPath     = 'controllers\\' . $controller;
    $controllerInstance = new $controllerPath();
    $controllerInstance->$method();
}

if (isset($_GET['action'])) {
    route($_GET['action']);
    unset($_GET);
}
