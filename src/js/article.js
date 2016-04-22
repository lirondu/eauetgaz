/* global GlobalHelper, ClientAgent */

var ArticlePage = {
	lastNumOfCols: 0,
	SetArticleLayout: function () {
		var numOfColumns = GlobalHelper.CalculateNumOfColumns();

		if (ArticlePage.lastNumOfCols === numOfColumns) {
			return;
		}

		ArticlePage.lastNumOfCols = numOfColumns;

		if (numOfColumns === 1) {
			var galleryCol = $('#gallery_column');
			$('#gallery_column').remove();
			$('#columns_container').append(galleryCol);

			$('div.single-column').css('float', 'none');
			$('#gallery_column').css('width', '100%');
			$('#text_column').css('width', '100%');
		} else {
			var textCol = $('#text_column');
			$('#text_column').remove();
			$('#columns_container').append(textCol);

			$('div.single-column').css('float', '');
			$('#gallery_column').css('width', '');
			$('#text_column').css('width', '');
		}
	},
	CalcLangPosition: function () {
		var colW = $('#text_column').innerWidth();
		var authorW = $('p.author_header').find('span').width();
		var langW = $('p.other_lang').first().find('span').width();
		if (langW === 0) {
			langW = $('p.other_lang').last().find('span').width();
		}

		if (colW < (authorW + langW + 100)) {
			$('p.other_lang').css('float', 'left');
			$('p.other_lang.visible').css('display', 'block');
			$('p.author_header').css('display', 'block');
		} else {
			$('p.other_lang').css('float', 'right');
			$('p.other_lang.visible').css('display', 'inline-block');
			$('p.author_header').css('display', 'inline-block');
		}
	},
	HandleReadMoreOnMobile: function () {
		if (ClientAgent.platform !== 'phone') {
			return;
		}

		var splitRgx = /(.*)(<br\/?>\s*)(<br\/?>)([\s\S]*)/;

		$('p.article-content').each(function () {
			var splitedText = splitRgx.exec($(this).html());
			if (splitedText === null || splitedText.length < 5) {
				return;
			}

			var shownText = splitedText[1];
			var hiddenText = splitedText[2] + splitedText[4];

			$(this).before($('<p>' + shownText + '</p>'));
			$(this).before($('<p class="hidden-text">' + hiddenText + '</p>'));
			$(this).before($('<a title="Read more" href="javascript:void(0)" class="read-more">Read <span>more</span></a>'));

			$(this).remove();
		});

		ArticlePage.RegisterReadMoreClick();

	},
	RegisterReadMoreClick: function () {
		$('a.read-more').click(function () {
			var currLink = $(this);
			var corrHiddenText = $(this).siblings('p.hidden-text').first();
			var folded = (corrHiddenText.css('display') === 'none') ? true : false;

			if (folded) {
				corrHiddenText.fadeIn(500, function () {
					currLink.find('span').html('less');
				});
			} else {
				corrHiddenText.fadeOut(500, function () {
					currLink.find('span').html('more');
				});
			}
		});
	},
	ChangeArticleLang: function (lang) {
		var currArticle;
		var articleToShow;
		var langBtnToHide;

		if ($('#article_content_de').is(':visible')) {
			currArticle = $('#article_content_de');
		} else if ($('#article_content_en').is(':visible')) {
			currArticle = $('#article_content_en');
		} else if ($('#article_content_it').is(':visible')) {
			currArticle = $('#article_content_it');
		}

		if (lang === 'en') {
			articleToShow = $('#article_content_en');
			langBtnToHide = $('#other_lang_en');
		} else if (lang === 'de') {
			articleToShow = $('#article_content_de');
			langBtnToHide = $('#other_lang_de');
		} else if (lang === 'it') {
			articleToShow = $('#article_content_it');
			langBtnToHide = $('#other_lang_it');
		}

		currArticle.fadeOut(300, function () {
			articleToShow.fadeIn(300);

			$('p.other_lang').show();
			$('p.other_lang').addClass('visible');

			langBtnToHide.hide();
			langBtnToHide.removeClass('visible');

			ArticlePage.CalcLangPosition();
		});
	}

};

$(function () {

	// Page Layout on load and resize
	ArticlePage.SetArticleLayout();
	ArticlePage.CalcLangPosition();

	$(window).resize(function () {
		ArticlePage.SetArticleLayout();
		ArticlePage.CalcLangPosition();
	});


	// Change to English also on load
	ArticlePage.ChangeArticleLang('en');
	$('#goto_english').click(function () {
		ArticlePage.ChangeArticleLang('en');
	});


	// Change to German
	$('#goto_german').click(function () {
		ArticlePage.ChangeArticleLang('de');
	});


	// Change to Italian
	$('#goto_italian').click(function () {
		ArticlePage.ChangeArticleLang('it');
	});


	// Read more for mobile
	ArticlePage.HandleReadMoreOnMobile();



});
