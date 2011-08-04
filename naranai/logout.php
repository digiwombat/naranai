<?php
	require_once('hibbity/config.php');
	setcookie("user_id", '', time() - 31556926, '/', $_SERVER['SERVER_NAME']);
	setcookie("user_name", '', time() - 31556926, '/', $_SERVER['SERVER_NAME']);
	setcookie("user_email", '', time() - 31556926, '/', $_SERVER['SERVER_NAME']);
	header("Location: " . BASE_URL . "/post/list");
	exit();
?>