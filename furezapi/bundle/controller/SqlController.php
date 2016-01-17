<?php
namespace FurezApi\Bundle\Controller;

use FurezApi\Bundle\Service\BundleService;

class SqlController {
    public function getRoutes() {
        return array(
            array('method' => 'GET','url' => '/SQL/connect', 'action' => 'FurezApi\Bundle\Controller\SqlController#sqlConnectAction', 'name' => 'sqlConnect'),
            array('method' => 'GET','url' => '/SQL/execute', 'action' => 'FurezApi\Bundle\Controller\SqlController#sqlExecuteAction', 'name' => 'sqlExecute')
        );
    }

    public function sqlConnectAction() {
        $host = $_GET['host'];
        $username = $_GET['username'];
        $password = $_GET['password'];

        $cmd = "\$host = \"$host\";
        \$username = \"$username\";
        \$password = \"$password\";
        ini_set('display_errors', 0);
        \$connexion = new \\mysqli(\$host, \$username, \$password);
        if (\$connexion->connect_error) {
            http_response_code(400);
            die('Connection failed: ' . \$connexion->connect_error);
        }
        ";

        $bundle = new BundleService();
        $result = $bundle->callEval($cmd);
        if($result) {
            http_response_code(400);
            die( utf8_encode( str_replace(chr(146),"'",$result) ) );
        }

        $cmd = "\$host = \"$host\";
        \$username = \"$username\";
        \$password = \"$password\";
        ini_set('display_errors', 0);
        \$connexion = new \\mysqli(\$host, \$username, \$password);
        \$sql = 'SHOW DATABASES';
        \$result = mysqli_query(\$connexion, \$sql);
        \$database = array();
        while(\$row = mysqli_fetch_row(\$result)) {
            \$database[] = \$row[0];
        }
        echo(json_encode(array('Connected successfully',\$database)));
        ";

        $result = $bundle->callEval($cmd);

        $_SESSION['host'] = $host;
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;

        die($result);
    }

    public function sqlExecuteAction() {
        $host = $_SESSION['host'];
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
        $db = $_GET['database'];
        $sql = $_GET['sql'];

        $cmd = "\$host = \"$host\";
        \$username = \"$username\";
        \$password = \"$password\";
        \$db = \"$db\";
        \$co = new \\mysqli(\$host, \$username, \$password);
        \$co->select_db(\$db);
        \$sql = \"$sql\";
        \$result = mysqli_query(\$co, \$sql);
        \$results = array();
        while(\$row = mysqli_fetch_row(\$result)) {
            \$results[] = \$row;
        }

        echo(json_encode(\$results));
        ";

        $bundle = new BundleService();
        $result = $bundle->callEval($cmd);

        die($result);
    }
}
