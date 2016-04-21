/* global CmsConfig */

var CmsCommon = {};

$(function () {

	CmsCommon.globalOkMessageBox = $('div#ok-message-box');
	CmsCommon.globalErrorMessageBox = $('div#error-message-box');
	//CmsCommon.globalMessageDialog = $('div#message-dialog');

	CmsCommon.date = new Date();
	CmsCommon.dateYear = CmsCommon.date.getFullYear();



	CmsCommon.GetParameterByName = function (name, url) {
		if (!url) {
			url = location;
		}
		name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
				results = regex.exec(url);
		return results === null ? "" : decodeURIComponent(results[1].replace(
				/\+/g, " "));
	};


	CmsCommon.ShowResponseMessage = function (retCode) {
		if (retCode === '1') {
			CmsCommon.globalOkMessageBox.fadeIn('slow', function () {
				$(this).delay(2000).fadeOut('slow');
			});
		} else {
			CmsCommon.globalErrorMessageBox.fadeIn('slow', function () {
				$(this).delay(4000).fadeOut('slow');
			});
		}
	};


	CmsCommon.SerializePositionsForm = function (form, idElIdentifier, posElIdentifier) {
		var duplicate = 0;
		var zero_pos = 0;
		var dup_value;
		var idArray = [];
		var posArray = [];
		var posCompareArray = [];

		form.each(function () {
			var currId = $(this).find(idElIdentifier).val();
			var currPos = $(this).find(posElIdentifier).val();

			if (posCompareArray.indexOf(currPos) !== -1) {
				duplicate = 1;
				dup_value = currPos;
				return false;
			} else if (currPos === '0') {
				zero_pos = 1;
				return false;
			}

			posCompareArray.push(currPos);

			if ($(this).find(posElIdentifier).attr('disabled') !== 'disabled') {
				idArray.push(currId);
				posArray.push(currPos);
			}
		});

		if (zero_pos === 1) {
			CmsCommon.globalMessageDialog.html(
					"The position: '0' is illegal.<br/>Can't continue!!!"
					);
			CmsCommon.globalMessageDialog.dialog('open');
			return '-1';
		} else if (duplicate === 1) {
			CmsCommon.globalMessageDialog.html("The position: '" + dup_value +
					"' is used more than once.<br/>Can't continue!!!");
			CmsCommon.globalMessageDialog.dialog('open');
			return '-1';
		} else {
			return 'ids=' + idArray + '&positions=' + posArray;
		}
	}


	//GLOBALS
	var curr_page_name = CmsCommon.GetParameterByName('page-name');
	var currPageTitle = (curr_page_name !== '') ? curr_page_name :
			'manage-main-pages';
	var hdrHeight = $('div#header').height();

	if (currPageTitle.match(/(\w+-)+\w+/)) {
		currPageTitle = currPageTitle.replace(/-/g, ' ');
	}

	currPageTitle = currPageTitle.replace(/\b([a-z])/g, function (m1) {
		return m1.toUpperCase();
	});


	//Jquery UI Button Class
	$(".ui_btn").button();



	/*#### HANDLE PAGE TITLE ####*/
	$('div#header-right-part').children('p').html(currPageTitle);

	/*#### HANDLE SIDE MENU HEIGHT ####*/
	$('div#side-menu').height($(window).height() - hdrHeight);
	$('div#columns-container').height($(window).height() - hdrHeight);
	$('div#page-content').height($(window).height() - hdrHeight - 10);
	$(window).resize(function () {
		$('div#side-menu').height($(window).height() -
				hdrHeight);
		$('div#columns-container').height($(window).height() -
				hdrHeight);
		$('div#page-content').height($(window).height() -
				hdrHeight - 5);
	});


	/*#### HANDLE ACTIVE SIDE MENU ITEM ON PAGE LOAD ####*/
	$('a.side-bar-link').each(function () {
		var currLinkName = CmsCommon.GetParameterByName('page-name', $(
				this).attr('href'));
		if (currLinkName === curr_page_name) {
			$(this).parent('li').addClass('active');
			$(this).parents('ul').addClass('active');
			$(this).parents('ul').siblings('h3').children('a').attr(
					'custom-folded', 'false');
			$(this).parents('div.menu-category').children('h3')
					.children('a').addClass('active');
		}
	});


	// Flexible Responsive Table
	var numOfColumns = 0;
	$('div#table').find('ul').first().find('li').each(function () {
		numOfColumns++;
	});

	var titleWidth = 100 - ((numOfColumns - 1) * 10) - 5;
	$('div#table ul li.title').css('width', titleWidth + '%');


	/*##### TITLE HOVER LINK COLOR #####*/
	$('div#table ul li.title a').hover(function () {
		$(this).css('color', '#2A6496');
		$(this).parents('li').siblings('li.title').children('a').css('color', '#2A6496');
	}, function () {
		$('div#table ul li.title a').css('color', '#000');
	});



	/*#### HANDLE SIDE MENU HOVER ####*/
	$('div#side-menu ul li a').hover(function () {
		$(this).parent('li').addClass('active');
	}, function () {
		var currLinkName = CmsCommon.GetParameterByName('page-name', $(this).attr('href'));
		if (currLinkName !== curr_page_name) {
			$(this).parent('li').removeClass('active');
		}
	});


	/*#### HANDLE SIDE MENU SCROLL ####*/
	$('div#side-menu ul li a').scroll(function () {
		$('div#page-content').scrollTop($(this).scrollTop());
	});


	/*##### MENU HEADER FOLD ANIMATION #####*/
	$('a.menu-hdr-toggle').click(function () {
		$('a.menu-hdr-toggle').each(function () {
			$(this).removeClass('active');
		});
		$(this).addClass('active');
	});


	/*##### MENU FOLD ANIMATION #####*/
	$('a.menu-hdr-toggle').click(function () {
		var list_box = $(this).parent('h3').siblings('ul');
		var currState = $(this).attr('custom-folded');

		if (currState === "false") {
			$(this).attr('custom-folded', 'true');
			list_box.slideUp(300);
		} else {
			$('div#side-menu').find('ul').each(function () {
				$(this).slideUp(300);
				$(this).parent('div.menu-category')
						.find('a.menu-hdr-toggle')
						.attr('custom-folded', 'true');
			});
			$(this).attr('custom-folded', 'false');
			list_box.slideDown(300);
		}
	});


	// Show/hide side menu
	$('a#show-menu-button').click(function () {
		var currState = $(this).attr('custom-folded');
		var pageCont = $('div#page-content');
		var menuCont = $('div#side-menu');
		var leftHdr = $('div#header-left-part');
		var rightHdr = $('div#header-right-part');

		if (currState === "false") {
			$(this).attr('custom-folded', 'true');

			menuCont.animate({
				width: 'hide'
			}, 300);

			leftHdr.animate({
				width: 'hide'
			}, 300);

			pageCont.animate({
				width: '100%',
				left: '0'
			}, 300);

			rightHdr.animate({
				width: '100%',
				left: '0'
			}, 300);

		} else {
			$(this).attr('custom-folded', 'false');

			menuCont.animate({
				width: 'show'
			}, 300);

			leftHdr.animate({
				width: 'show'
			}, 300);

			pageCont.animate({
				width: '85%',
				left: '15%'
			}, 300);

			rightHdr.animate({
				width: '85%',
				left: '15%'
			}, 300);
		}
	});


//	CmsCommon.messageDialog = $('div#message-dialog').dialog({
//		autoOpen: false,
//		resizable: false,
//		modal: true,
//		width: 'auto',
//		buttons: [
//			{
//				text: "Ok",
//				click: function () {
//					$(this).dialog("close");
//				}
//			}
//		]
//	});


//	CmsCommon.ckeditorEn = $('textarea.article-ckeditor').ckeditor({
//		height: '400px',
//		width: '95%',
//		resize_enabled: false,
//		filebrowserBrowseUrl: CmsConfig.elfinderAdminConnector
//	});
//
//
//	// Initialize CKEDITOR small
//	$('#ckeditor_small').ckeditor({
//		height: '300px',
//		resize_enabled: false,
//		filebrowserBrowseUrl: CmsConfig.elfinderAdminConnector
//	});


});