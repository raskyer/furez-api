<?php
namespace FurezApi\Service;

class ShellService {
	function __construct() {
		$this->apiUrl = $_SESSION['apiurl'];
        if($this->callTest()) {
            $this->isWindow = $this->isWindow();
        }
	}

	//CORE
	function callTest() {
		return @file_get_contents($this->apiUrl);
	}

	function callShell($cmd) {
		$postdata = http_build_query(
			array(
				'eval' => "echo shell_exec('". $cmd ."');"
			)
		);
		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header'  => 'Content-type: application/x-www-form-urlencoded',
				'content' => $postdata
			)
		);
		$context  = stream_context_create($opts);
		$result = file_get_contents($this->apiUrl, false, $context);
		$normalize = trim(htmlspecialchars($result));

		return $normalize;
	}

	//GENERAL
	function isWindow() {
        if(!isset($_SESSION['isWindow'])) {
            if(!$this->callShell("pwd")) {
                $_SESSION['isWindow'] = true;
                return true;
            } else {
                $_SESSION['isWindow'] = false;
                return false;
            }
        }
		return $_SESSION['isWindow'];
	}

	function listFolderContent($working_dir_raw, $context) {
		$working_dir_line = explode("\n",$working_dir_raw);
		$folderArray = array();
		$fileArray = array();
		$folder = true;

		for($i = 0; $i < count($working_dir_line); $i++) {
			if(strlen($working_dir_line[$i]) < 11) {
				$folder = false;
				continue;
			}
			$objArray_raw = explode(" ", $working_dir_line[$i]);
			foreach ($objArray_raw as $key => $value) {
				if(!strlen($value)>0) {
					unset($objArray_raw[$key]);
				}
			}
			$objArray_raw = array_values($objArray_raw);

			$objArray = array();
			$objArray["name"] = str_replace("/", "", str_replace(trim($context), "", $objArray_raw[8]));
			$objArray["size"] = $objArray_raw[4];
			$objArray["lastUpdate"] = $objArray_raw[5] . " " . $objArray_raw[7];
			$objArray["owner"] = $objArray_raw[2];
			$objArray["right"] = $objArray_raw[0];

			if(!$folder) {
				$objArray["type"] = "file";
				$fileArray[] = $objArray;
			} else {
				$objArray["type"] = "folder";
				$folderArray[] = $objArray;
			}
		}

		$working_dir = array_merge($folderArray, $fileArray);
		$working_dir['context'] = $context;

		return $working_dir;
	}

	function showFolderContent($working_dir) {
		$template = "";
		foreach($working_dir as $key => $dir) {
			if($key === "context") {
				break;
			}
			if($dir["type"] === "file") {
				$template = $template.
					"<div>
						<li class='uFile'
							data-name='".$dir['name']."'
							data-context='".$working_dir['context']."'
							data-owner='".$dir['owner']."'
							data-lastupdate='".$dir['lastUpdate']."'
							data-right='".$dir['right']."'
						>"
						.$dir["name"]." (".$dir["size"]."octet)"
					."</li></div>";
			} elseif($dir["type"] === "folder") {
				$template = $template.
					"<div>
						<li class='uFolder'
							data-name='". $dir['name']."'
							data-context='". $working_dir['context'] ."'
							data-owner='".$dir['owner']."'
							data-lastupdate='".$dir['lastUpdate']."'
							data-right='".$dir['right']."'
						>"
						."<i class='fa fa-caret-right'></i> <i class='fa fa-folder'></i> ".$dir["name"] ." (". $dir["size"] ." octet)"
					."</li></div>";
			}
		}
		return $template;
	}

	//INDEX ACTION
	function getCurrentDir() {
		if($this->isWindow) {
			$cur_dir = $this->callShell("chdir");
		} else {
			$cur_dir = $this->callShell("pwd");
		}

		return $cur_dir;
	}

	function getRacineRelativePath() {
		$racine_dir = $this->callShell("ls");
		$racine_relativePath = "";
		$i = 0;

		while($racine_dir != "www" && $i < 5) {
			$cmd = "ls ".$racine_relativePath;
			$racine_dir = $this->callShell($cmd);

			$racine_dirArray = explode("\n", $racine_dir);
			if(in_array("www", $racine_dirArray)) {
				$racine_dir = "www";
				break;
			}

			$racine_relativePath = $racine_relativePath . "../";
			$i++;
		}

		return $racine_relativePath;
	}

	function getContext($racine_relativePath) {
		if($this->isWindow) {
			$cmd = "chdir ".$racine_relativePath." && chdir";
			$context = $this->callShell($cmd);
		} else {
			$cmd = "cd ".$racine_relativePath." && pwd";
			$context = $this->callShell($cmd);
		}

		return $context;
	}

	function getTotal($context) {
		$cmd = "ls -lh ".$context;
		$response = $this->callShell($cmd);

		$array = explode("\n", $response);
		$total = str_replace("total ", "", $array[0]);

		return $total;
	}

	function getParentDir($context) {
		$cmd = "ls -lhd ".$context."/*/ && ls -lhp ".$context." | grep -v /";
		$parent_dir = $this->callShell($cmd);
		$parent_dir = $this->listFolderContent($parent_dir, $context);

		return $parent_dir;
	}

	function getIdentity() {
		if($this->isWindow) {
			return $this->callShell('echo %USERDOMAIN%\%USERNAME%');
		} else {
			return $this->callShell('whoami');
		}
	}

	//FOLDER CONTENT ACTION
	function getFolderContent($folder) {
		$cmdFolder = "ls -lhd ".$folder."/*/ ";
		$cmdFile = "ls -lhp ".$folder." | grep -v /";

		$folderToList = $this->callShell($cmdFolder);
		$fileToList = $this->callShell($cmdFile);
		$allToList = $folderToList . "\n" . $fileToList;

		$folder_content = $this->listFolderContent($allToList, $folder);

		return $folder_content;
	}

	//FILE CONTENT ACTION
	function getFileContent($file) {
		$cmd = "cat ".$file;
		$file_content = $this->callShell($cmd);

		return $file_content;
	}

	//ZIP ELEMENT ACTION
	function zipElement($element, $context, $export_dir) {
		$element = str_replace(".", "_", $element);

		$zipName = $export_dir."/".$element."-".date("his").".zip";
		$elementLocation = $context."/".$element;

		$cmd = "zip -r ".$zipName." ".$elementLocation;
		$output = $this->callShell($cmd);

		$cmd = "ls ".$export_dir;
		$check = $this->callShell($cmd);
		$check = explode("\n", $check);

		if(in_array($zipName, $check)) {
			$result = array("success","Success!");
		} else {
			$result = array("failure","Failed!"."<br>".$output."Note that this feature is only available on linux server and can be blocked if you don't have the rights to write on the export folder!");
		}

		return $result;
	}

	//DELETE ELEMENT ACTION
	function deleteElement($element, $context) {
		$cmd = "rm -rf ".$context."/".$element;
		$output = $this->callShell($cmd);

		$cmd = "ls ".$context;
		$check = $this->callShell($cmd);
		$check = explode("\n", $check);

		if(in_array($element, $check)) {
			$result = "Failed!"."\n".$output;
		} else {
			$result = "Success!";
		}

		return $result;
	}
}
