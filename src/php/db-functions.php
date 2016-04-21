<?

$DB_CON = mysqli_connect("localhost", "root", "", "eauetgaz");
//$DB_CON = mysqli_connect("localhost", "lirondug_gaz", "Password123!", "lirondug_eauetgaz");
// $DB_CON = mysqli_connect("localhost", "mimikri_gaz", "Password123!", "mimikri_gaz");

$PAGE_TYPES = [
	'0' => 'article',
	'1' => 'artists',
	'2' => 'writers',
	'3' => 'contact'
];

function GetMenuPages() {
	global $DB_CON;
	$result = mysqli_query($DB_CON, "SELECT * FROM `menu_pages` WHERE `published`='1' ORDER BY `position`");

	while ($row = mysqli_fetch_assoc($result)) {
		$pages[] = $row;
	}

	return $pages;
}


function GetMenuPageLink($name) {
	global $DB_CON;
	global $PAGE_TYPES;
	$result = mysqli_query($DB_CON, "SELECT * FROM `menu_pages` WHERE name='$name' LIMIT 1");

	$page = mysqli_fetch_assoc($result);
	
	$link = '/index?type='.$PAGE_TYPES[$page['page_type']].'&id='.$page['content_id'].'&menu-name='.$page['name'];

	return $link;
}


function GetTableYears($table) {
	global $DB_CON;

	$yearsArray = [];

	$q = mysqli_query($DB_CON, "SELECT year FROM $table WHERE published=1 ORDER BY year DESC");
echo mysqli_error($DB_CON);
	while ($row = mysqli_fetch_assoc($q)) {
		if (!in_array($row['year'], $yearsArray)) {
			$yearsArray[] = $row['year'];
		}
	}

	return $yearsArray;
}


function GetTableYearEntries($table, $year) {
	global $DB_CON;
	$result = mysqli_query($DB_CON, "SELECT * FROM $table WHERE year=$year AND published=1 ORDER BY position");

	while ($row = mysqli_fetch_assoc($result)) {
		$entries[] = $row;
	}

	return $entries;
}


function GetArticleById($id) {
	global $DB_CON;
	
	$result = mysqli_query($DB_CON, "SELECT * FROM `articles` WHERE `id`='$id' LIMIT 1");

	$article = mysqli_fetch_assoc($result);

	return $article;
}


function GetTableList($name) {
	global $DB_CON;
	
	$result = mysqli_query($DB_CON, "SELECT * FROM $name ORDER BY `position`");

	while ($row = mysqli_fetch_assoc($result)) {
		$list[] = $row;
	}

	return $list;
}


function GetPublishedArtists() {
	global $DB_CON;
	
	$result = mysqli_query($DB_CON, "SELECT * FROM `artists` WHERE published=1 ORDER BY RAND()");

	while ($row = mysqli_fetch_assoc($result)) {
		$list[] = $row;
	}

	return $list;
}


function GetPublishedArtistsOfYear($year) {
	global $DB_CON;
	
	$result = mysqli_query($DB_CON, "SELECT * FROM `artists` WHERE year='$year' AND published=1 ORDER BY RAND()");

	while ($row = mysqli_fetch_assoc($result)) {
		$list[] = $row;
	}

	return $list;
}


function GetEntry($table, $id) {
	global $DB_CON;
	
	$result = mysqli_query($DB_CON, "SELECT * FROM $table WHERE id='$id' LIMIT 1");

	$entry = mysqli_fetch_assoc($result);
	
	return $entry;
}


function GetAllPublishedWritersArticles() {
	global $DB_CON;
	
	$result = mysqli_query($DB_CON, "SELECT `article_id` FROM `writers` WHERE published=1 ORDER BY position");

	while ($row = mysqli_fetch_assoc($result)) {
		$articlesIds[] = $row['article_id'];
	}
	
	foreach ($articlesIds as $id) {
		$articles[] = GetEntry('articles', $id);
	}

	return $articles;
}





/******** CMS ********/


function IsValidCmsAdminLogin($user, $pwd) {
	global $DB_CON;

	$result = mysqli_query($DB_CON, "SELECT * FROM `cms_users` WHERE `priviliged`='1'");

	while ($row = mysqli_fetch_assoc($result)) {
		$users[] = $row;
	}

	foreach ($users as $value) {
		if ($value['uname'] != $user) {
			continue;
		}

		if ($value['passwd'] != $pwd) {
			return false;
		}

		return true;
	}

	return false;
}


function getUnderConstruction() {
	global $DB_CON;

	$result = mysqli_query($DB_CON, "SELECT `state` FROM `under_construction` LIMIT 1");

	$data = mysqli_fetch_assoc($result);

	return $data['state'];
}


function setUnderConstruction($state) {
	global $DB_CON;

	$result = mysqli_query($DB_CON, "UPDATE `under_construction` SET `state`='$state' LIMIT 1");

	echo ($result) ? '1' : '0';
}


function GetAllPages() {
	global $DB_CON;
	$result = mysqli_query($DB_CON, "SELECT * FROM `menu_pages` ORDER BY `position`");

	while ($row = mysqli_fetch_assoc($result)) {
		$pages[] = $row;
	}

	return $pages;
}


function GetAllWriters() {
	global $DB_CON;
	$result = mysqli_query($DB_CON, "SELECT * FROM `writers` ORDER BY `position`");

	while ($row = mysqli_fetch_assoc($result)) {
		$writers[] = $row;
	}

	return $writers;
}


function GetAllPublishedWriters() {
	global $DB_CON;
	$result = mysqli_query($DB_CON, "SELECT * FROM `writers` WHERE published='1' ORDER BY `position`");

	while ($row = mysqli_fetch_assoc($result)) {
		$writers[] = $row;
	}

	return $writers;
}


function GetSinglePage($id) {
	global $DB_CON;
	$result = mysqli_query($DB_CON, "SELECT * FROM `menu_pages` WHERE `id`='$id' LIMIT 1");

	$page = mysqli_fetch_assoc($result);

	return $page;
}


function GetNextMenuPagePosition() {
	global $DB_CON;
	
	$result = mysqli_query($DB_CON, "SELECT position FROM `menu_pages` ORDER BY position DESC LIMIT 1");
	
	$page = mysqli_fetch_assoc($result);
	
	return (int)$page['position'] + 1;
}