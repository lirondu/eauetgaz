<?php

$timeOut = 1200; //20 Min

$referer = (isset($_SESSION['referer'])) ? $_SESSION['referer'] : '/';

if (isset($_SESSION['last_activity'])) {
	$inactive = time() - $_SESSION['last_activity'];
	
	if ($inactive > $timeOut) {
		header("Location: /login/logout?referer=$referer");
	}
}

$_SESSION['last_activity'] = time();