/* global ArticlePage */

var CmsInlineLang = {
	DOM_TO_REMOVE: ['.other_lang'],
	RemoveDomElements: function () {
		var elements = CmsInlineLang.DOM_TO_REMOVE;

		for (var i = 0; i < elements.length; i++) {
			$(elements[i]).remove();
		}
	},
	ToggleLang: function (state, langLink) {
		if (state) {
			langLink.removeClass('disabled');
		} else {
			langLink.addClass('disabled');
		}
	}
};


$(function () {
	CmsInlineLang.RemoveDomElements();

	CmsInlineLang.ToggleLang($('#has_de').is(':checked'), $('#goto_german'));
	$('#has_de').change(function (){
		CmsInlineLang.ToggleLang($('#has_de').is(':checked'), $('#goto_german'));
	});

	CmsInlineLang.ToggleLang($('#has_it').is(':checked'), $('#goto_italian'));
	$('#has_it').change(function (){
		CmsInlineLang.ToggleLang($('#has_it').is(':checked'), $('#goto_italian'));
	});

	$('#goto_english').click(function (){
		ArticlePage.ChangeArticleLang('en');
	});

	$('#goto_german').click(function (){
		ArticlePage.ChangeArticleLang('de');
	});

	$('#goto_italian').click(function (){
		ArticlePage.ChangeArticleLang('it');
	});
});