<?php
namespace FurezApi\Config;

use AltoRouter;

class AppRoutes extends \AltoRouter {
    protected $appRoutes = array();

    public function init() {
        $this->setBasePath($_SESSION['basepath']);
        $this->appRoutes = array(
            array('method' => 'GET|POST', 'url' => '/', 'action' => 'FurezApi\Controller\MainController#indexAction', 'name' => 'index'),
            array('method' => 'GET', 'url' => '/config', 'action' => 'FurezApi\Controller\ConfigController#indexAction', 'name' => 'config'),
            array('method' => 'POST', 'url' => '/handleApi', 'action' => 'FurezApi\Controller\ConfigController#handleApiAction', 'name' => 'handleApi'),
            array('method' => 'GET', 'url' => '/selectNewApi', 'action' => 'FurezApi\Controller\ConfigController#selectNewApiAction', 'name' => 'selectNewApi'),
            array('method' => 'GET', 'url' => '/folder', 'action' => 'FurezApi\Controller\MainController#folderAction', 'name' => 'getFolder'),
            array('method' => 'GET', 'url' => '/file', 'action' => 'FurezApi\Controller\MainController#fileAction', 'name' => 'getFile'),
            array('method' => 'GET', 'url' => '/zip', 'action' => 'FurezApi\Controller\MainController#zipAction', 'name' => 'zipElement'),
            array('method' => 'GET', 'url' => '/delete', 'action' => 'FurezApi\Controller\MainController#deleteAction', 'name' => 'deleteElement'),
            array('method' => 'GET', 'url' => '/cmd', 'action' => 'FurezApi\Controller\MainController#cmdAction', 'name' => 'cmd'),
            array('method' => 'GET', 'url' => '/reloadBundle', 'action' => 'FurezApi\Controller\MainController#reloadBundleAction', 'name' => 'reloadBundle'),
            array('method' => 'GET', 'url' => '/reloadAll', 'action' => 'FurezApi\Controller\ConfigController#reloadAllAction', 'name' => 'reloadAll')
        );

        if(!isset($_SESSION['allRoutes'])) {
            foreach ($_SESSION['bundles_controller'] as $controller) {
                $bundle_controller = "FurezApi\\Bundle\\Controller\\".$controller;
                $bundle_controller = new $bundle_controller;

                foreach($bundle_controller->getRoutes() as $route) {
                    $this->appRoutes[] = $route;
                }
            }

            $_SESSION['allRoutes'] = $this->appRoutes;
        } else {
            $this->appRoutes = $_SESSION['allRoutes'];
        }

        $this->get();
    }

    public function get() {
        foreach($this->appRoutes as $route) {
            $this->map($route['method'], $route['url'], $route['action'], $route['name']);
        }
    }
}
