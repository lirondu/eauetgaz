<?php

require '../../php/db-functions.php';
require '../../php/parameters.php';


if (!isset($_POST['mod_data'])) {
	return false;
}




/* ##### PAGES SHOW/HIDE ##### */
if ($_POST['mod_data'] == 'update-inline-article') {
	global $DB_CON;

	//DEFINE VARS FROM POSTED DATA
	$id				 = $_POST['id'];
	$writerId		 = $_POST['writer_id'];
	$titleEn		 = $_POST['title_en'];
	$secondTitleEn	 = $_POST['second_title_en'];
	$contentEn		 = $_POST['content_en'];
	$secondTitleDe	 = (isset($_POST['has_de'])) ? $_POST['second_title_de'] : '0';
	$contentDe		 = (isset($_POST['content_de'])) ? $_POST['content_de'] : '' ;
	$secondTitleIt	 = (isset($_POST['has_it'])) ? $_POST['second_title_it'] : '0';
	$contentIt		 = (isset($_POST['content_it'])) ? $_POST['content_it'] : '' ;

	//UPDATE PAGE SHOW
	$q = mysqli_query($DB_CON, "UPDATE `articles` SET
			`writer_id`='$writerId', `title_en`='$titleEn', `second_title_en`='$secondTitleEn',
			`content_en`='$contentEn', `second_title_de`='$secondTitleDe', `content_de`='$contentDe',
			`second_title_it`='$secondTitleIt', `content_it`='$contentIt'
			WHERE `id`='$id' LIMIT 1");

	echo ($q) ? '1' : '0';

	return false;
}




/* ##### PAGES SHOW/HIDE ##### */
if ($_POST['mod_data'] == 'update-menu-show') {
	global $DB_CON;

	//DEFINE VARS FROM POSTED DATA
	$id		 = $_POST['id'];
	$state	 = ($_POST['show-in-menu'] == 'true') ? '1' : '0';

	//UPDATE PAGE SHOW
	$q = mysqli_query($DB_CON, "UPDATE `menu_pages` SET `published`='$state' WHERE `id`='$id' LIMIT 1");

	echo ($q) ? '1' : '0';

	return false;
}


/* ##### PAGES MENU POSITIONS ##### */
if ($_POST['mod_data'] == 'save-positions') {
	global $DB_CON;
	$q = true;

	//DEFINE VARS FROM POSTED DATA
	$id_array	 = $_POST['ids'];
	$pos_array	 = $_POST['positions'];

	$id_array	 = explode(',', $id_array);
	$pos_array	 = explode(',', $pos_array);

	foreach ($pos_array as $key => $val) {
		$q &= mysqli_query($DB_CON, "UPDATE `pages` SET `position`='$val' WHERE `id`='$id_array[$key]' LIMIT 1");
	}

	echo ($q) ? '1' : '0';

	return false;
}


/* ##### PAGE COPY ##### */
if ($_POST['mod_data'] == 'copy-page') {
	global $DB_CON;

	$origPage	 = GetSinglePage($_POST['id']);
	$titleEn	 = 'Copy of ' . $origPage['title_en'];
	$pos		 = GetNextMenuPosition();

	$q = mysqli_query($DB_CON, "INSERT INTO `pages`
        (`position`, `published`, `show_social`, `title_en`, `title_de`, `type`, `content_en`, `content_de`)
		VALUES
        ('$pos', '0','$origPage[show_social]', '$titleEn', '$origPage[title_de]', '$origPage[type]', '$origPage[content_en]',
        '$origPage[content_de]')"
	);

	echo ($q) ? '1' : '0';

	return false;
}


/* ##### PAGE DELETE ##### */
if ($_POST['mod_data'] == 'del-menu-page') {
	global $DB_CON;

	$id = $_POST['id'];

	$result	 = mysqli_query($DB_CON, "SELECT `content_id` FROM `menu_pages` WHERE id='$id' LIMIT 1");
	$page	 = mysqli_fetch_assoc($result);

	$articleId = $page['content_id'];

	$q = mysqli_query($DB_CON, "DELETE FROM `articles` WHERE `id`='$articleId' LIMIT 1");

	if (!$q) {
		echo '0';
		die();
	}

	$q = mysqli_query($DB_CON, "DELETE FROM `menu_pages` WHERE `id`='$id' LIMIT 1");

	echo ($q) ? '1' : '0';

	return false;
}


/* ##### SITE UNDER CONSTRUCTION TOGGLE ##### */
if ($_POST['mod_data'] == 'update-construction') {
	global $DB_CON;

	//DEFINE VARS FROM POSTED DATA
	$state = ($_POST['construction'] == 'true') ? '1' : '0';

	//UPDATE CONSTRUCTION STATE
	$q = mysqli_query($DB_CON, "UPDATE `under_construction` SET `state`='$state' LIMIT 1");

	echo ($q) ? '1' : '0';

	return false;
}


/* ##### CREATE PAGE ##### */
if ($_POST['mod_data'] == 'new-menu-page') {
	global $DB_CON;

	$q = mysqli_query($DB_CON, "INSERT INTO `articles`
			(`writer_id`, `title_en`, `title_de`, `title_it`, `second_title_en`, `second_title_de`,
			`second_title_it`, `content_en`, `content_de`, `content_it`, `gallery_title`, `gallery_content`, `is_writer`)
			VALUES ('0', '', '0', '0', '', '', '', '', '', '', '', '', '0')"
	);

	if (!$q) {
		echo '0';
		die();
	}

	$newArticleId	 = mysqli_insert_id($DB_CON);
	$nextPos		 = GetNextMenuPagePosition();

	$q = mysqli_query($DB_CON, "INSERT INTO `menu_pages`
			(`published`, `name`, `position`, `is_list`, `list_name`, `page_type`, `content_id`)
			VALUES
			('0', 'NO TITLE', '$nextPos', '0', NULL, '0', '$newArticleId')"
	);

	$newPageId = mysqli_insert_id($DB_CON);

	echo ($q) ? '1,' . $newPageId : '0';

	return false;
}


/* ##### EDIT PAGE ##### */
if ($_POST['mod_data'] == 'edit-page') {
	global $DB_CON;

	//DEFINE VARS FROM POSTED DATA
	$id			 = $_POST['edit-page-id'];
	$titleEn	 = $_POST['title-en'];
	$showSocial	 = '0';
	$contentEn	 = $_POST['content-en'];

	$q = mysqli_query($DB_CON, "UPDATE `pages` SET `show_social`='$showSocial', `title_en`='$titleEn',
            `content_en`='$contentEn' WHERE id='$id' LIMIT 1");

	echo ($q) ? '1' : '0';

	return false;
}


/* ##### EDIT ARTICLE ##### */
if ($_POST['mod_data'] == 'edit-article') {
	global $DB_CON;

	//DEFINE VARS FROM POSTED DATA
	$id				 = $_POST['id'];
	$isWriter		 = ($_POST['is_writer'] === 'on') ? '1' : '0';
	$writerId		 = ($isWriter === '0') ? $_POST['writer_id'] : '0';
	$titleEn		 = $_POST['title_en'];
	$secondTitleEn	 = $_POST['second_title_en'];
	$contentEn		 = $_POST['content_en'];
	$titleDe		 = (isset($_POST['use_de'])) ? $_POST['title_de'] : '0';
	$secondTitleDe	 = $_POST['second_title_de'];
	$contentDe		 = $_POST['content_de'];
	$titleIt		 = (isset($_POST['use_it'])) ? $_POST['title_it'] : '0';
	$secondTitleIt	 = $_POST['second_title_it'];
	$contentIt		 = $_POST['content_it'];
	$GalleryTitle	 = $_POST['gallery-title'];
	$GalleryContent	 = $_POST['gallery-content'];

	$q = mysqli_query($DB_CON, "UPDATE `articles` SET
			`writer_id`='$writerId',
			`title_en`='$titleEn',
			`second_title_en`='$secondTitleEn',
			`content_en`='$contentEn',
			`title_de`='$titleDe',
			`second_title_de`='$secondTitleDe',
			`content_de`='$contentDe',
			`title_it`='$titleIt',
			`second_title_it`='$secondTitleIt',
			`content_it`='$contentIt',
			`gallery_title`='$GalleryTitle',
			`gallery_content`='$GalleryContent',
			`is_writer`='$isWriter'
			WHERE id='$id' LIMIT 1");

	echo ($q) ? '1' : '0';

	return false;
}


/* ##### EDIT ABOUT PAGE ##### */
if ($_POST['mod_data'] == 'edit-about-page') {
	global $DB_CON;

	//DEFINE VARS FROM POSTED DATA
	$id			 = 3;
	$contentEn	 = $_POST['content-en'];

	$q = mysqli_query($DB_CON, "UPDATE `pages` SET `content_en`='$contentEn' WHERE id='$id' LIMIT 1");

	echo ($q) ? '1' : '0';

	return false;
}


/* ##### POSTS SHOW/HIDE ##### */
if ($_POST['mod_data'] == 'update-posts-show') {
	global $DB_CON;

	//DEFINE VARS FROM POSTED DATA
	$id		 = $_POST['id'];
	$state	 = ($_POST['show-post'] == 'true') ? '1' : '0';

	//UPDATE PAGE SHOW
	$q = mysqli_query($DB_CON, "UPDATE `work_posts` SET published = '$state' WHERE id = '$id' LIMIT 1");

	echo ($q) ? '1' : '0';

	return false;
}


/* ##### POSTS SHOW/HIDE ON HOME ##### */
if ($_POST['mod_data'] == 'update-posts-show-on-home') {
	global $DB_CON;

	//DEFINE VARS FROM POSTED DATA
	$id		 = $_POST['id'];
	$state	 = ($_POST['show-on-home'] == 'true') ? '1' : '0';

	//UPDATE PAGE SHOW
	$q = mysqli_query($DB_CON, "UPDATE `work_posts` SET `show_on_home`='$state' WHERE id='$id' LIMIT 1");

	echo ($q) ? '1' : '0';

	return false;
}


/* ##### WORK POSTS POSITIONS ##### */
if ($_POST['mod_data'] == 'save-posts-positions') {
	global $DB_CON;
	$q = true;

	//DEFINE VARS FROM POSTED DATA
	$id_array	 = $_POST['ids'];
	$pos_array	 = $_POST['positions'];

	$id_array	 = explode(',', $id_array);
	$pos_array	 = explode(',', $pos_array);

	foreach ($pos_array as $key => $val) {
		$q &= mysqli_query($DB_CON, "UPDATE `work_posts` SET `position`='$val' WHERE id='$id_array[$key]' LIMIT 1");
	}

	echo ($q) ? '1' : '0';

	return false;
}


/* ##### WORK POSTS HOME POSITIONS ##### */
if ($_POST['mod_data'] == 'save-posts-home-positions') {
	global $DB_CON;
	$q = true;

	//DEFINE VARS FROM POSTED DATA
	$id_array = $_POST['positionsArray'];

	$id_array = explode(',', $id_array);

	foreach ($id_array as $key => $val) {
		$currPos = $key + 1;
		$q &= mysqli_query($DB_CON, "UPDATE `work_posts` SET `home_position`='$currPos' WHERE id='$val' LIMIT 1");
	}

	echo ($q) ? '1' : '0';

	return false;
}


/* ##### POST DELETION ##### */
if ($_POST['mod_data'] == 'del-post') {
	global $DB_CON;

	$id = $_POST['id'];

	$q = mysqli_query($DB_CON, "DELETE FROM `work_posts` WHERE id='$id' LIMIT 1");

	echo ($q) ? '1' : '0';

	return false;
}


/* ##### CREATE POST ##### */
if ($_POST['mod_data'] == 'new-post') {
	global $DB_CON;

	//DEFINE VARS FROM POSTED DATA
	$titleEn			 = $_POST['post-title-en'];
	$location			 = $_POST['post-location'];
	$city				 = $_POST['post-city'];
	$country			 = $_POST['post-country'];
	$year				 = $_POST['post-year'];
	$contentEn			 = $_POST['post-content-en'];
	//$position			 = GetNextWorkPostPosition();
	//$homePosition		 = GetNextWorkPostHomePosition();
	$position			 = 0;
	$homePosition		 = 0;
	$galleryContent		 = (isset($_POST['gallery-content'])) ? $_POST['gallery-content'] : '0';
	$galleryTitle		 = (isset($_POST['gallery-content'])) ? $_POST['gallery-title'] : '0';
	$galleryNumPerRow	 = (isset($_POST['gallery-content'])) ? $_POST['num-per-row-spinner'] : '0';

	if (isset($_POST['show-on-home'])) {
		$thumb		 = $_POST['post-thumb'];
		$showOnHome	 = '1';
	} else {
		$thumb		 = '0';
		$showOnHome	 = '0';
	}


	$q = mysqli_query($DB_CON, "INSERT INTO `work_posts`
                (`published`, `position`, `thumbnail`, `title_en`, `year`, `location`, `city`, `country`, `show_on_home`,
				`home_position`, `content_en`, `gallery_title_en`, `gallery_title_de`, `gallery_content`, `gallery_img_per_row`)
                VALUES
                ('0', '$position', '$thumb', '$titleEn', '$year', '$location', '$city', '$country', '$showOnHome',
                '$homePosition', '$contentEn', '$galleryTitle', '0', '$galleryContent', '$galleryNumPerRow')"
	);

	if ($q) {
		PrepareTableForNewEntryOnTop('work_posts', 'position');
		PrepareTableForNewEntryOnTop('work_posts', 'home_position');
	}
	echo ($q) ? '1' : '0';

	return false;
}


/* ##### EDIT POST ##### */
if ($_POST['mod_data'] == 'edit-post') {
	global $DB_CON;

	//DEFINE VARS FROM POSTED DATA
	$id					 = $_POST['post_id'];
	$titleEn			 = $_POST['post-title-en'];
	$location			 = $_POST['post-location'];
	$city				 = $_POST['post-city'];
	$country			 = $_POST['post-country'];
	$year				 = $_POST['post-year'];
	$contentEn			 = $_POST['post-content-en'];
	$galleryContent		 = (isset($_POST['gallery-content'])) ? $_POST['gallery-content'] : '0';
	$galleryTitle		 = (isset($_POST['gallery-content'])) ? $_POST['gallery-title'] : '0';
	$galleryNumPerRow	 = (isset($_POST['gallery-content'])) ? $_POST['num-per-row-spinner'] : '0';

	if (isset($_POST['show-on-home'])) {
		$thumb		 = $_POST['post-thumb'];
		$showOnHome	 = '1';
	} else {
		$thumb		 = '0';
		$showOnHome	 = '0';
	}

	$q = mysqli_query($DB_CON, "UPDATE `work_posts` SET
				`title_en`='$titleEn', `location`='$location', `city`='$city', `country`='$country', `year`='$year',
        		`show_on_home`='$showOnHome', `thumbnail`='$thumb', `content_en`='$contentEn', `gallery_content`='$galleryContent',
				`gallery_title_en`='$galleryTitle', `gallery_img_per_row`='$galleryNumPerRow'
				WHERE `id`='$id' LIMIT 1"
	);

	echo ($q) ? '1' : '0';

	return false;
}


/* ##### META DATA UPDATE ##### */
if ($_POST['mod_data'] == 'meta-update') {
	global $DB_CON;

	$title	 = mysqli_real_escape_string($DB_CON, $_POST['meta_title']);
	$kwd	 = mysqli_real_escape_string($DB_CON, $_POST['meta_keywords']);
	$desc	 = mysqli_real_escape_string($DB_CON, $_POST['meta_description']);

	$q = mysqli_query($DB_CON, "UPDATE `meta_data` SET `title`='$title', `keywords` = '$kwd', `description` = '$desc' LIMIT 1");

	echo ($q) ? '1' : '0';

	return false;
}


/* ##### CMS admin password change ##### */
if ($_POST['mod_data'] == 'update-admin-pwd') {
	global $DB_CON;

	$pwd = mysqli_real_escape_string($DB_CON, $_POST['exist-pwd']);

	//Authenticate current password
	$result	 = mysqli_query($DB_CON, "SELECT passwd FROM `cms_users` WHERE id='1'");
	$row	 = mysqli_fetch_assoc($result);

	if ($row['passwd'] != md5($pwd)) {
		echo 'false pwd';
		return false;
	}

	$newPwd = mysqli_real_escape_string($DB_CON, $_POST['new-pwd']);

	$md5Pwd = md5($newPwd);

	$q = mysqli_query($DB_CON, "UPDATE `cms_users` SET `passwd`='$md5Pwd' WHERE id='1' LIMIT 1");

	echo ($q) ? '1' : '0';

	return false;
}


/* ##### CMS guest password change ##### */
if ($_POST['mod_data'] == 'update-guest-pwd') {
	global $DB_CON;

	$newPwd = mysqli_real_escape_string($DB_CON, $_POST['new-pwd']);

	$md5Pwd = md5($newPwd);

	$q = mysqli_query($DB_CON, "UPDATE `cms_users` SET `passwd`='$md5Pwd' WHERE id='2' LIMIT 1");

	echo ($q) ? '1' : '0';

	return false;
}



/* About Exhibition Cheack If Year Exist */
if ($_POST['mod_data'] == 'exhib-year-check-exist') {
	global $DB_CON;

	$year		 = $_POST['year'];
	$existYears	 = GetAboutExhibitionsYears();

	echo (in_array($year, $existYears)) ? '0' : '1';

	return false;
}


/* Add About Exhibition */
if ($_POST['mod_data'] == 'add-about-exhib') {
	global $DB_CON;

	$year	 = $_POST['year'];
	$pos	 = GetNextAboutExhibitionPosition($year);

	$q = mysqli_query($DB_CON, "INSERT INTO `about_exhibitions`
                            (`year`, `content`, `solo`, `position`)
                            VALUES
                            ('$year', '', '0', '$pos')"
	);

	$insertId = ($q) ? mysqli_insert_id($DB_CON) : '-1';

	echo ($q) ? '1,' . $insertId : '0,' . $insertId;

	return false;
}


/* About Exhibition Update Solo */
if ($_POST['mod_data'] == 'about-exhib-update-solo') {
	global $DB_CON;

	$id		 = $_POST['id'];
	$state	 = ($_POST['state'] == 'true') ? '1' : '0';

	$q = mysqli_query($DB_CON, "UPDATE `about_exhibitions` SET `solo`='$state' WHERE `id`='$id' LIMIT 1");

	echo ($q) ? '1' : '0';

	return false;
}


/* About Exhibition Delete */
if ($_POST['mod_data'] == 'about-exhib-delete') {
	global $DB_CON;

	$id = $_POST['id'];

	$q = mysqli_query($DB_CON, "DELETE FROM `about_exhibitions` WHERE `id`='$id' LIMIT 1");

	echo ($q) ? '1' : '0';

	return false;
}


/* About Exhibition Update Content */
if ($_POST['mod_data'] == 'about-exhib-update-content') {
	global $DB_CON;

	$id		 = $_POST['id'];
	$content = $_POST['content'];

	$q = mysqli_query($DB_CON, "UPDATE `about_exhibitions` SET `content`='$content' WHERE `id`='$id' LIMIT 1");

	echo ($q) ? '1' : '0';

	return false;
}


/* About Exhibition Delete Full Year */
if ($_POST['mod_data'] == 'about-exhib-delete-year') {
	global $DB_CON;

	$year = $_POST['year'];

	$q = mysqli_query($DB_CON, "DELETE FROM `about_exhibitions` WHERE `year`='$year'");

	echo ($q) ? '1' : '0';

	return false;
}


/* Add About Exhibition Year */
if ($_POST['mod_data'] == 'about-exhib-add-year') {
	global $DB_CON;

	$year = $_POST['year'];

	$q = mysqli_query($DB_CON, "INSERT INTO `about_exhibitions`
                            (`year`, `content`, `solo`, `position`)
                            VALUES
                            ('$year', '', '0', '1')"
	);

	$insertId = ($q) ? mysqli_insert_id($DB_CON) : '-1';

	echo ($q) ? '1,' . $insertId : '0,' . $insertId;

	return false;
}


/* About Exhibition Update Year Positions */
if ($_POST['mod_data'] == 'about-exhib-rearange-year') {
	global $DB_CON;

	$year		 = $_POST['year'];
	$positions	 = $_POST['positionsArray'];
	$posArray	 = array_reverse(explode(',', $positions));
	$q			 = true;

	foreach ($posArray as $key => $val) {
		$q &= mysqli_query($DB_CON, "UPDATE `about_exhibitions` SET `position`='$key' WHERE `id`='$val' LIMIT 1");
	}

	echo ($q) ? '1' : '0';

	return false;
}


/* Rearange Changeable Pages */
if ($_POST['mod_data'] == 'pages-rearange-changeable') {
	global $DB_CON;
	global $allSpecialPages;

	$positions		 = $_POST['positionsArray'];
	$posArray		 = explode(',', $positions);
	$numOfFixedPages = count($allSpecialPages);
	$q				 = true;

	foreach ($posArray as $key => $val) {
		$currPos = $key + 1 + $numOfFixedPages;
		$q &= mysqli_query($DB_CON, "UPDATE `menu_pages` SET `position`='$currPos' WHERE `id`='$val' LIMIT 1");
	}

	echo ($q) ? '1' : '0';

	return false;
}



/* Rearange Work Posts */
if ($_POST['mod_data'] == 'rearange-work-posts') {
	global $DB_CON;

	$positions	 = $_POST['positionsArray'];
	$posArray	 = explode(',', $positions);
	$q			 = true;

	foreach ($posArray as $key => $val) {
		$currPos = $key + 1;
		$q &= mysqli_query($DB_CON, "UPDATE `work_posts` SET `position`='$currPos' WHERE `id`='$val' LIMIT 1");
	}

	echo ($q) ? '1' : '0';

	return false;
}



/* Add About Award */
if ($_POST['mod_data'] == 'about-award-new') {
	global $DB_CON;

	$year		 = $_POST['award_form_year'];
	$content	 = $_POST['award_form_content'];
	$position	 = GetNextAboutAwardPosition();

	$q = mysqli_query($DB_CON, "INSERT INTO `about_awards`
                            (`year`, `content`, `published`, `position`)
                            VALUES
                            ('$year', '$content', '1', '$position')"
	);

	$insertId = ($q) ? mysqli_insert_id($DB_CON) : '-1';

	echo ($q) ? '1,' . $insertId : '0,' . $insertId;

	return false;
}


/* Add About Award */
if ($_POST['mod_data'] == 'about-award-update') {
	global $DB_CON;

	$id		 = $_POST['id'];
	$year	 = $_POST['award_form_year'];
	$content = $_POST['award_form_content'];

	$q = mysqli_query($DB_CON, "UPDATE `about_awards` SET `year`='$year', `content`='$content' WHERE `id`='$id' LIMIT 1");

	echo ($q) ? '1' : '0';

	return false;
}


/* Delete About Award */
if ($_POST['mod_data'] == 'about-award-delete') {
	global $DB_CON;

	$id = $_POST['id'];

	$q = mysqli_query($DB_CON, "DELETE FROM `about_awards` WHERE `id`='$id' LIMIT 1");

	echo ($q) ? '1' : '0';

	return false;
}


/* Rearange About Awards */
if ($_POST['mod_data'] == 'about-award-rearange') {
	global $DB_CON;

	$positions	 = $_POST['positionsArray'];
	$posArray	 = explode(',', $positions);
	$q			 = true;

	foreach ($posArray as $key => $val) {
		$currPos = $key + 1;
		$q &= mysqli_query($DB_CON, "UPDATE `about_awards` SET `position`='$currPos' WHERE `id`='$val' LIMIT 1");
	}

	echo ($q) ? '1' : '0';

	return false;
}



/* Add Publication */
if ($_POST['mod_data'] == 'publication-new') {
	global $DB_CON;

	$title	 = $_POST['pub_title'];
	$content = $_POST['pub_content'];
	$pos	 = GetNextPublicationPosition();

	$q = mysqli_query($DB_CON, "INSERT INTO `publications`
			(`title`, `content`, `published`, `position`)
			VALUES
			('$title', '$content', '1', '$pos')");

	echo ($q) ? '1' : '0';

	return false;
}


/* Edit Publication */
if ($_POST['mod_data'] == 'publication-edit') {
	global $DB_CON;

	$id		 = $_POST['pub_id'];
	$title	 = $_POST['pub_title'];
	$content = $_POST['pub_content'];

	$q = mysqli_query($DB_CON, "UPDATE `publications` SET `title`='$title', `content`='$content' WHERE `id`='$id' LIMIT 1");

	echo ($q) ? '1' : '0';

	return false;
}


/* Delete Publication */
if ($_POST['mod_data'] == 'publication-delete') {
	global $DB_CON;

	$id = $_POST['id'];

	$q = mysqli_query($DB_CON, "DELETE FROM `publications` WHERE `id`='$id' LIMIT 1");

	echo ($q) ? '1' : '0';

	return false;
}



/* Publications Order */
if ($_POST['mod_data'] == 'publications-order') {
	global $DB_CON;

	$positions	 = $_POST['positionsArray'];
	$posArray	 = explode(',', $positions);
	$q			 = true;

	foreach ($posArray as $key => $val) {
		$currPos = $key + 1;
		$q &= mysqli_query($DB_CON, "UPDATE `publications` SET `position`='$currPos' WHERE `id`='$val' LIMIT 1");
	}

	echo ($q) ? '1' : '0';

	return false;
}