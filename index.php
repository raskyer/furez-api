<?php
    session_start();
    header('content-type: text/html; charset=utf-8');
    ini_set('display_errors', 1);
    ini_set('error_reporting', E_ALL);

    require_once __DIR__.'/vendor/autoload.php';
    require_once __DIR__.'/furezapi/config/Loader.php';

    $router = new \FurezApi\Config\AppRoutes();
    $router->init();
    $match = $router->match();

    list($controller, $action) = explode( '#', $match['target'] );
    if (is_callable(array($controller, $action))) {
        $obj = new $controller($router);
        call_user_func_array(array($obj,$action), array($match['params']));
    } else {
        session_destroy();
    }
