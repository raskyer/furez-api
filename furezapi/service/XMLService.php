<?php
namespace FurezApi\Service;

class XMLService {
	function __construct() {
		$this->domXml = simplexml_load_string($_SESSION['apidom']);
		if(isset($_POST['website'])) {
			$this->website = $_POST['website'];
			$this->image = $_POST['image'];
			$this->url = $_POST['url'];
			$this->lastUpdate = date("F j, Y, g:i a");
			$this->version = $_SESSION['version'];
		}
	}

	function saveNewXml($domXml) {
		$dom = new \DOMDocument('1.0');
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($domXml->asXML());
		$dom->save('FurezApi/config/api_config.xml');
	}

	function add() {
		$list = $this->domXml->list;
		$group = $list->addChild('group');
		$group->addAttribute('current', 'false');
		$group->addChild('website', $this->website);
		$group->addChild('image', $this->image);
		$group->addChild('url', $this->url);
		$group->addChild('lastupdate', $this->lastUpdate);
		$group->addChild('version', $this->version);

		return $this->domXml;
	}

	function edit($api) {
		if($api === "current") {
			$api = $this->domXml->xpath('//group[@current="true"]')[0];
		} else {
			$api = $this->domXml->list->group[intval($api)];
		}

		$api->website = $this->website;
		$api->image = $this->image;
		$api->url = $this->url;
		$api->lastupdate = $this->lastUpdate;

		return $this->domXml;
	}
}
