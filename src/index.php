<?
if (!isset($_SESSION)) {
	session_start();
}

require_once './php/db-functions.php';
require_once './login/expire.php';

$_SESSION['LOGIN_FWD_URI'] = $_SERVER['REQUEST_URI'];
$_SESSION['referer'] = $_SERVER['REQUEST_URI'];

$adminSession = false;
if (isset($_SESSION['valid_admin']) && $_SESSION['valid_admin']) {
	$adminSession = true;
}


define('HOME_PAGE', 'artists');

$pageType		 = (isset($_GET['type'])) ? $_GET['type'] : HOME_PAGE;
$pageId			 = (isset($_GET['id'])) ? $_GET['id'] : '0';
$pageMenuName	 = (isset($_GET ['menu-name'])) ? $_GET ['menu-name'] : HOME_PAGE;


function PrintMenuLinks() {
	global $PAGE_TYPES;
	$menuPages = GetMenuPages();

	foreach ($menuPages as $key => $page) {
		$type			 = $PAGE_TYPES[$page['page_type']];
		$hasList		 = ($page['is_list'] !== '0') ? true : false;
		$hasListPerYear	 = ($page['is_list'] === '2' || $page['is_list'] === '3') ? true : false;

		if ($hasList) {
			$list = GetTableList($page['list_name']);

			if ($hasListPerYear) {
				$yearsArr = GetTableYears($page['list_name']);
			}
		}
		?>

		<!-- Link Menu Item -->
		<li class="<?= ($hasList) ? 'dropdown' : ''; ?>">
			<a class="menu-link <?= ($hasList) ? 'dropdown-toggle' : ''; ?>"
			   id="dropdownMenu<?= $key; ?>" aria-haspopup="true" aria-expanded="false"
			   href="index?type=<?= $type ?>&id=<?= $page['content_id'] ?>&menu-name=<?= $page['name'] ?>">
				   <?= $page['name']; ?>
			</a>
			<?
			// Link has inner list
			if ($hasList) {
				?>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu<?= $key; ?>">
					<?
					// List is sorted per year
					if ($hasListPerYear) {
						foreach ($yearsArr as $year) {
							$yearEntries = GetTableYearEntries($page['list_name'], $year);
							?>
							<li class="menu-year">
								<?
								// Years are links
								if ($page['is_list'] === '3') {
									?>
									<a href="/index?type=<?= $page['list_name'] ?>&menu-name=<?= $page['name'] ?>
									   &year=<?= $year ?>">
										   <?= $year ?>
									</a>
									<?
								} else {
									echo $year;
								}
								?>
							</li>

							<?
							foreach ($yearEntries as $entry) {
								?>
								<li>
									<a href="/index?type=article&menu-name=<?= $page['name'] ?>
									   &id=<?= $entry['article_id'] ?>&year=<?= $year ?>">
										   <?= $entry['name'] ?>
									</a>
								</li>
								<?
							}
						}
					} else {
						// Unsorted inner list
						foreach ($list as $listItem) {
							?>
							<li>
								<a href="/index?type=article&menu-name=<?= $page['name'] ?>
								   &id=<?= $listItem['article_id'] ?>">
									   <?= $listItem['name'] ?>
								</a>
							</li>
							<?
						}
					}
					?>
				</ul>
				<?
			}
			?>
		</li>
		<?php
	}
}
?>
<!DOCTYPE html>
<html>

	<head>
		<title>EAU&GAZ</title>
		<meta charset="UTF-8">
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
		<meta name="theme-color" content="#000032">
		<link rel="icon" type="image/jpg" href="">

		<link href='https://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/common.css" />
	</head>

	<body>
		<div id="site_container">

			<nav class="navbar navbar-default navbar-fixed-top" id="main_menu">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main_menu_links" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</a>

						<div>
							<?
							if ($adminSession) {
								?>
								<a class="btn btn-default cms-menu-btn" href="/login/logout.php" title="Log Out">Log Out</a>
								<?
								if ($pageType !== 'artists') {
									?>

									<a class="btn btn-default cms-menu-btn disabled" id="article_inline_save">Save Article</a>
									<a class="btn btn-default cms-menu-btn disabled" data-toggle="modal" data-target="#cancel_modal">Cancel</a>
									<?
								}
							} else {
								?>
								<!--LOGO CONTAINER-->
								<a class="navbar-brand" href="/"></a>

								<a class="btn btn-default cms-menu-btn" href="/login"
								   style="margin-top: 10px; background-color: transparent; color: #FFF;">
									Admin
								</a>
								<?
							}
							?>
						</div>

					</div>

					<div class="collapse navbar-collapse" id="main_menu_links">
						<ul class="nav navbar-nav">
							<?php PrintMenuLinks(); ?>
						</ul>

					</div> <!-- /.navbar-collapse -->
				</div> <!-- /.container-fluid -->
			</nav>


			<div id="page_content">
				<?php include "./php/$pageType.php"; ?>
			</div>

		</div>


		<div id="splash_container">
			<div class="splash-half">
				<div id="splash_logo">
					<img src="./css/img/EGLOGOTransparent.svg">
				</div>
				<div id="splash_news">
					<h3 class="splash-title">exhibition</h3>
					<ul class="splash-exhib-list">
						<li>
							<a href="/index?type=article&menu-name=Exhibitions&id=23">
								Opening 8th April at 7pm<br>
								9th April - 9th May 2016<br>
								Hours: Fri - Sun, 4pm to 8pm
							</a>
						</li>

					</ul>

					<h3 class="splash-title">lanserhaus</h3>
					<ul class="splash-exhib-list">
						<li>
							<a href="/index?type=contact&id=&menu-name=Contact">
								J.G.Plazer Street 22-24<br>
								39057 Eppan (Italy)
							</a>
						</li>

					</ul>


					<h3 class="splash-title">artists</h3>
					<ul>
						<li><a href="/index?type=article&menu-name=Artists&id=21&year=2016">Stefan Alber</a></li>
						<li><a href="/index?type=article&menu-name=Artists&id=10&year=2016">Zohar Gotesman</a></li>
						<li><a href="/index?type=article&menu-name=Artists&id=9&year=2016">Monika Grabuschnigg</a></li>
						<li><a href="/index?type=article&menu-name=Artists&id=13&year=2016">Vincent Grunwald</a></li>
						<li><a href="/index?type=article&menu-name=Artists&id=15&year=2016">The Wa</a></li>
						<li><a href="/index?type=article&menu-name=Artists&id=12&year=2016">Ivette Mrova Zub</a></li>
					</ul>
				</div>
				<button class="splash-enter-btn glyphicon glyphicon-menu-down" aria-hidden="true"></button>
			</div>

			<div class="splash-half"></div>
		</div>


		<input type="hidden" id="page_menu_name" value="<?= $pageMenuName ?>">


		<link rel="stylesheet" href="./plugins/baguetteBox/baguetteBox.min.css">
		<link rel="stylesheet" href="./css/baguetteBoxCustom.css">

		<script src="js/clientAgent.js"></script>
		<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

		<script src="./js/global-helper.js"></script>
		<script src="./js/columns-layout.js"></script>
		<script src="./js/common.js"></script>
		<script src="./plugins/jquery.scrollTo.min.js"></script>
		<script src="./js/<?= $pageType ?>.js"></script>
		<script src="./plugins/baguetteBox/baguetteBox.min.js"></script>
		<script src="./js/gallery-init.js"></script>

		<script>
			(function (i, s, o, g, r, a, m) {
				i['GoogleAnalyticsObject'] = r;
				i[r] = i[r] || function () {
					(i[r].q = i[r].q || []).push(arguments)
				}, i[r].l = 1 * new Date();
				a = s.createElement(o),
						m = s.getElementsByTagName(o)[0];
				a.async = 1;
				a.src = g;
				m.parentNode.insertBefore(a, m)
			})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

			ga('create', 'UA-75666205-1', 'auto');
			ga('send', 'pageview');
		</script>


		<!-- ###### LOAD CMS ######-->
		<?
		if ($adminSession) {
			?>
			<link rel="stylesheet" type="text/css" href="admin/css/cmsInline.css"/>

			<script src="./admin/elFinder-2.1.6/js/elfinder.min.js"></script>
			<script src="./admin/ckeditor/ckeditor.js"></script>
			<script src="./admin/ckeditor/adapters/jquery.js"></script>
			<script src="./plugins/jquery.validate.min.js"></script>
			<script src="./admin/js/cmsConfig.js"></script>
			<script src="./admin/js/cmsCommon.js"></script>
			<script src="./admin/js/cmsInline.js"></script>
			<script src="./admin/js/cmsInlineLang.js"></script>
			<?

				require_once './admin/php/cms-inline-elements.php';
		}
		?>


	</body>

</html>
