<?php
$main=require_once 'lib/base.php';
$main->route('GET /',
	function() {
		echo 'Hello, world!';
	}
);
$main->run();
?>
