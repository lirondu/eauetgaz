<?
session_start();
session_destroy();

$referer = (isset($_GET['referer'])) ? $_GET['referer'] : $_SERVER['HTTP_REFERER'];

header('Location: '.$referer);
?>