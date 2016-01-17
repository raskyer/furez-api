<?php
namespace FurezApi\Service;

class CookieService {
	function storeInCache($cur_dir, $context, $racine_relativePath, $total, $identity, $parent_dir) {
		setcookie("api", $_SESSION['apiurl']);
		setcookie("cur_dir", $cur_dir);
		setcookie("context", $context);
		setcookie("racine_relativePath", $racine_relativePath);
		setcookie("total", $total);
		setcookie("identity", $identity);
		$_SESSION['parent_dir'] = $parent_dir;
	}

	function restoreCookie($key, $cookies, $shell) {
		$cooky = $cookies;
		switch($key) {
			case "cur_dir":
				setcookie("cur_dir", $shell->getCurrentDir());
				break;
			case "context":
				setcookie("context", $shell->getContext($cooky['racine_relativePath']));
				break;
			case "total":
				setcookie("total", $shell->getTotal($cooky['context']));
				break;
			case "identity":
				setcookie("identity", $shell->getIdentity());
				break;
			case "parent_dir":
				$_SESSION['parent_dir'] = $shell->getParentDir($cooky['context']);
				break;
		}
	}

	function checkCookie($shell) {
		$result = false;
		$cookies = array("cur_dir" => $_COOKIE['cur_dir'],
						"context" => $_COOKIE['context'],
						"total" => $_COOKIE['total'],
						"identity" => $_COOKIE['identity'],
						"parent_dir" => $_SESSION['parent_dir']
		);

		foreach($cookies as $key => $cookie) {
			if(!$cookie) {
				$this->restoreCookie($key, $cookies, $shell);
				$result = true;
			}
		}

		return $result;
	}

	function unsetCookies() {
        session_destroy();
		foreach ($_COOKIE as $c_id => $c_value) {
			unset($_COOKIE[$c_id]);
			setcookie($c_id, NULL, -10);
		}
	}
}
