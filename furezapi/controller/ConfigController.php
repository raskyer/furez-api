<?php
namespace FurezApi\Controller;

use FurezApi\Service\XMLService;
use FurezApi\Service\CookieService;

class ConfigController {
    public function __construct($router) {
        $this->xml = new xmlService();
        $this->router = $router;
    }

    public function indexAction() {
        $dom = simplexml_load_string($_SESSION['apidom']);
        if($_SESSION['apiurl']) {
            $current_api = $dom->xpath('//group[@current="true"]')[0];
        }
        $group = $dom->list->group;

        exit(include("ressource/views/config.php"));
    }

    public function handleApiAction() {
        if($_POST['edit'] === "false") {
            $domXml = $this->xml->add();
        } else {
            $domXml = $this->xml->edit($_POST['edit']);
        }

        $cookie = new CookieService();
        $cookie->unsetCookies();
        $this->xml->saveNewXml($domXml);
        header('Location: '.$this->router->generate('config'));
    }

    public function selectNewApiAction() {
        $domXml = simplexml_load_string($_SESSION['apidom']);
        if($_SESSION['apiurl']) {
            $current_api = $domXml->xpath('//group[@current="true"]');
            $current_api[0]->attributes()->current = "false";
        }

        $api = $domXml->list->group[intval($_GET['index'])];
        $api->attributes()->current = "true";

        $this->xml->saveNewXml($domXml);

        $cookie = new CookieService();
        $cookie->unsetCookies();
        header('Location: '.$this->router->generate('config'));
    }

    public function reloadAllAction() {
        $cookie = new CookieService();
        $cookie->unsetCookies();

        header('Location: '.$this->router->generate('config'));
    }
}
