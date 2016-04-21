/* global CmsCommon */

function ToggleLanguage(fieldset) {
	if (fieldset.attr('custom-hidden') === 'true') {
		fieldset.slideDown(100, function () {
			$('body').scrollTo(fieldset, {duration: 750, offset: -45});
		});
		fieldset.attr('custom-hidden', 'false');
	} else {
		fieldset.slideUp(750);
		fieldset.attr('custom-hidden', 'true');
	}
}


function SerializeGallery() {
	var galleryTextarea = $('<textarea name="gallery-content">' + $('#gallery-preview').html() + '</textarea>')
			.serialize();
	var galleryTitle = $('#gallery_title').serialize();

	return galleryTitle + "&" + galleryTextarea;
}



$(function () {

	/*##### USE GERMAN BIND #####*/
	$('#use_de').change(function () {
		ToggleLanguage($('#fieldset_de'));
	});

	/*##### USE ITALIAN BIND #####*/
	$('#use_it').change(function () {
		ToggleLanguage($('#fieldset_it'));
	});
	
	/*##### CHECK IF USE GERMAN #####*/
	if ($('#use_de').is(':checked')) {
		$('#fieldset_de').show();
	}

	/*##### FORM JQUERY UI SUBMIT BUTTON #####*/
	$('#article_editor_submit').button();


	/*##### ARTICLE FORM VALIDATION #####*/
	$('#article_editor').validate({
		rules: {
			'writer_id': {
				required: true
			},
			'title_en': {
				required: true,
				minlength: 2
			},
			'second_title_en': {
				required: true,
				minlength: 2
			},
			'content_en': {
				required: true,
				minlength: 50
			},
			'title_de': {
				required: '#use_de:checked',
				minlength: 2
			},
			'second_title_de': {
				required: '#use_de:checked',
				minlength: 2
			},
			'content_de': {
				required: '#use_de:checked',
				minlength: 50
			},
			'title_it': {
				required: '#use_it:checked',
				minlength: 2
			},
			'second_title_it': {
				required: '#use_it:checked',
				minlength: 2
			},
			'content_it': {
				required: '#use_it:checked',
				minlength: 50
			}
		}
	});


	/*####  NEW ARTICLE FORM SUBMIT ####*/
	$('#article_editor').submit(function () {
		if ($(this).validate().form()) {
			var data = $(this).serialize();
			data += SerializeGallery() + '&mod_data=edit-article';
			console.log(data);
			return;
			$.ajax({
				type: "POST",
				url: "php/db-modifier.php",
				data: data,
				success: function (msg) {
					if (msg === '1') {
						location.assign('/admin/index.php');
					} else {
						CmsCommon.ShowResponseMessage('0');
					}
				},
				fail: function () {
					CmsCommon.ShowResponseMessage('0');
				}
			});
		}

	});
});