<?php
    $dom = simplexml_load_file("furezapi/config/api_config.xml");
    $_SESSION['apidom'] = $dom->asXML();
    $_SESSION['version'] = (string) $dom->version;
    $_SESSION['basepath'] = (string) $dom->basepath;

    $current_api = $dom->xpath('//group[@current="true"]');
    if(isset($current_api[0])) {
        $_SESSION['apiurl'] = (string) $current_api[0]->url;
    } else {
        $_SESSION['apiurl'] = null;
    }
