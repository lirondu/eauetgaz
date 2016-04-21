/* global ClientAgent */
var ContactPage = {
	LoadPlatformCss: function () {
		if ($(window).width() > 600) {
			if ($('#contact_css').length === 0) {
				ClientAgent.AddCssLink('./css/contact.css', 'contact_css');
				ClientAgent.RemoveCssLink('contact_phone_css');
			}
		} else {
			if ($('#contact_phone_css').length === 0) {
				ClientAgent.AddCssLink('./css/contact-phone.css', 'contact_phone_css');
				ClientAgent.RemoveCssLink('contact_css');
			}
			
			//iPhone WA
			$('#page_content').fadeOut(100, function () { 
				$('#page_content').fadeIn();
			});
		}
	},
	
	CalcWinHeight: function () { 
		var winH = $(window).height() - $('#main_menu').height();
		$('#columns_container').height(winH);
	}
};

$(function () {
	ContactPage.LoadPlatformCss();
	ContactPage.CalcWinHeight();
	
	$(window).resize(function () {
		ContactPage.LoadPlatformCss();
		ContactPage.CalcWinHeight();
	});
});