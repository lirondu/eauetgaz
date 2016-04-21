<?php
//###### CREATE SESSION IF DOESN'T EXIST ######
if (!isset($_SESSION)) {
	session_start();
}

//######## AUTHENTICATION ########
if (!isset($_SESSION['valid_admin']) || !$_SESSION['valid_admin']) {
	$_SESSION['LOGIN_FWD_URI'] = $_SERVER['REQUEST_URI'];
	header('location: /login');
}

$page_name			 = (isset($_GET['page-name'])) ? $_GET['page-name'] : 'manage-main-pages';
$_SESSION['referer'] = "/admin/index.php?page-name=$page_name";

require "../login/expire.php";
require '../php/parameters.php';
require '../php/db-functions.php';

require '../index.php'
?>
