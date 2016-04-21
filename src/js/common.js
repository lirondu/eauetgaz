/* global GlobalHelper */
function RemoveSplashElements() {
	$('#splash_container').remove();
	$('#page_content').css('opacity', '1');
	$('body').css('overflow', '');
}


function IsHomePage() {
	var pathRgx = /\w+:\/\/[\w-]+\.[\w-]+(?:\.[\w-]+)*(.*)/;
	var path = pathRgx.exec(location.toString());

	return (path[1] === '/') ? true : false;
}


function PositionMainMenu() {
	if ($('a.navbar-toggle').css('display') !== 'none') {
		$('ul.navbar-nav').addClass('small-menu');
		$('ul.navbar-nav>li').addClass('small-menu');
	} else {
		$('ul.navbar-nav').removeClass('small-menu');
		$('ul.navbar-nav>li').removeClass('small-menu');

		var linksWidth = 0;
		$('ul.navbar-nav>li').each(function () {
			linksWidth += $(this).width();
		});

		var navWidth = $('nav#main_menu').width() * 0.60 - 30 - linksWidth;


		// $(window).width() * 0.75 -
		// linksWidth -
		// columnWidth - 25; 

		CalculateMenuLinksSpacing(navWidth);
	}
}


function CalculateMenuLinksSpacing(navWidth) {
	var numOfLinks = 0;
	$('ul.navbar-nav>li').each(function () {
		numOfLinks++;
	});

	var linksSapcing = navWidth / numOfLinks;

	$('ul.navbar-nav>li').css('margin-right', linksSapcing);
	$('ul.navbar-nav>li:last-child').css('margin-right', '0');
}


function CalculateSplashElementsPositions() {
	var winHeight = $(window).height();
	var logoHeight = $('#splash_logo').height();
	var newsHeight = $('#splash_news').height();
	var buttonHeight = $('button.splash-enter-btn').height();

	var margin = (winHeight - logoHeight - newsHeight - buttonHeight - 5) / 4;

	$('#splash_logo img').css('margin-top', margin / 2);
	$('#splash_news').css('margin-top', margin);
	$('button.splash-enter-btn').css('margin-top', margin);
}




$(function () {
	var winHeight = $(window).height();
	var showSplash = IsHomePage();



	// Handle splash (cover) screen
	if (showSplash) {
		$('body').css('overflow', 'hidden');
		$('#splash_container').show();
		$('#splash_container').height(winHeight);


		$(window).resize(function () {
			winHeight = $(window).height();
			$('#splash_container').height(winHeight);
		});


		$('#splash_container').scroll(function () {
			var currScroll = $(this).scrollTop();
			var currOpacity = currScroll / $(this).height();

			$('#page_content').css('opacity', currOpacity);

			if (currScroll >= $('#splash_container').height() - 5) {
				RemoveSplashElements();
			}
		});

		$('button.splash-enter-btn').click(function () {
			var splashHeight = $('#splash_container').height() + 10;
			$('#splash_container').animate({ scrollTop: splashHeight }, 750, function () {
				RemoveSplashElements();
			});
		});
	} else {
		RemoveSplashElements();
	}



	// Handle menu position
	PositionMainMenu();
	$(window).resize(function () {
		if (ClientAgent.platform === 'desktop') {
			PositionMainMenu();
		}
	});


	// Handle splash elements positions
	CalculateSplashElementsPositions();
	$(window).resize(function () {
		CalculateSplashElementsPositions();
	});



	// Handle active menu item
	var pageName = $('#page_menu_name').val();
	$('#main_menu ul li a').each(function () {
		if ($(this).html().trim() == pageName.trim()) {
			$(this).addClass('active-page');
			return false;
		}
	});


	// Handle dropdown on hover
	$('li.dropdown').hover(function () {
		if ($('a.navbar-toggle').css('display') !== 'none') {
			return;
		}

		$(this).find('ul.dropdown-menu').show();
	}, function () {
		if ($('a.navbar-toggle').css('display') !== 'none') {
			return;
		}

		$(this).find('ul.dropdown-menu').hide();
	});

});