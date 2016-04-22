<?
session_start();
session_destroy();

$referer = (isset($_SESSION['LOGIN_FWD_URI'])) ? $_SESSION['LOGIN_FWD_URI'] : '/';

header('Location: '.$referer);
?>