<?php
    if(!isset($_SESSION['apidom'])) {
        require_once __DIR__.'/SessionConfig.php';
    }

    if(!isset($_SESSION['bundles_controller'])) {
        require_once __DIR__.'/BundlesConfig.php';
    }

    require_once __DIR__.'/AppRoutes.php';
    require_once __DIR__.'/../controller/MainController.php';
    require_once __DIR__.'/../controller/ConfigController.php';
    require_once __DIR__.'/../service/ShellService.php';
    require_once __DIR__.'/../service/CookieService.php';
    require_once __DIR__.'/../service/XMLService.php';

    foreach ($_SESSION['bundles_controller'] as $controller) {
        require_once __DIR__.'/../bundle/controller/'.$controller.".php";
    }

    require_once __DIR__.'/../bundle/service/BundleService.php';
