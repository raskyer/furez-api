<?php
namespace FurezApi\Bundle\Controller;

use FurezApi\Bundle\Service\BundleService;

class UploadController {
    public function getRoutes() {
        return array(
            array('method' => 'POST','url' => '/upload', 'action' => 'FurezApi\Bundle\Controller\UploadController#uploadAction', 'name' => 'uploadElement')
        );
    }

    public function uploadAction() {
        $content_dir = "uploads";
        $tmp_file = $_FILES['file']['tmp_name'];
        if(!is_uploaded_file($tmp_file)){
            $_SESSION['flash'] = array("failure","Furez can't find the file");
            exit(header("Location: ".$_SESSION['basepath']));
        }
        $name_file = $_FILES['file']['name'];
        if(!move_uploaded_file($tmp_file, $content_dir . "/" . $name_file)) {
            $_SESSION['flash'] = array("failure","Error, Furez can't succed to copy file in $content_dir");
            exit(header("Location: ".$_SESSION['basepath']));
        }

        $filepath = $_POST['exportdir'] . "/" . $_FILES['file']['name'];
        $cmd = "\$file = \$_POST['file'];
                file_put_contents('".$filepath."', \$file);
                if (file_exists('".$filepath."')) {
                    echo 'Succeed! Furez upload the file';
                }";

        $bundle = new BundleService();
        $result = $bundle->callCurlUpload($cmd);

        $_SESSION['flash'] = array("success", $result);

        header("Location: ".$_SESSION['basepath']);
    }
}
