/* global CmsCommon, CmsConfig */

$(function () {
	/**************************************************************************/
	/* Mange Work Posts
	 /**************************************************************************/

	if ($('input#post-year').val() === "") {
		$('input#post-year').val(CmsCommon.dateYear);
	}

	$('input#post-year').spinner({
		min: 1900,
		max: 2100
	});


	function DeletePost(id) {
		var data = 'id=' + id + '&mod_data=del-post';
		$.ajax({
			type: "POST",
			url: "php/data-modifier.php",
			data: data,
			success: function (msg) {
				location.reload();
			},
			fail: function () {
				CmsCommon.ShowResponseMessage('0');
			}
		});
	}


	function SerializeGallery(galleryDom) {
		var galleryExist = ($(galleryDom).is(':visible')) ? true :
			false;
		var galleryTextarea = '';
		var galleryTitle = '';
		var galleryNumPerRow = '';

		if (galleryExist) {
			galleryTextarea = $('<textarea name="gallery-content">' +
				galleryDom.html() + '</textarea>').serialize();
			galleryTitle = $('input#gallery_title').serialize();
			galleryNumPerRow = $('input#num-per-row-spinner').serialize();
			return galleryTitle + "&" + galleryNumPerRow + "&" +
				galleryTextarea;
		}

		return "";
	}


	function RearangeWorkPosts(posArray) {
		var data = 'positionsArray=' + posArray + '&mod_data=rearange-work-posts';

		$.ajax({
			type: "POST",
			url: "php/data-modifier.php",
			data: data,
			success: function (msg) {
				CmsCommon.ShowResponseMessage(msg);
			},
			fail: function () {
				CmsCommon.ShowResponseMessage('0');
			}
		});
	}


	/*##### WORK POSTS POSITIONS SORT #####*/
	var workPostsPosSortable = $('div.manage_work_posts').sortable({
		items: '> ul.sortable',
		axis: 'y',
		handle: 'li:nth-child(1)',
		cursor: 'move',
		forcePlaceholderSize: true,
		update: function () {
			var posArray = $(this).sortable('toArray', { attribute: 'custom-id' });
			RearangeWorkPosts(posArray);
		}
	}).disableSelection();



	/*##### PUBLISH POSTS TOGGLE #####*/
	$('input.show-in-posts').change(function () {
		var new_state = ($(this).is(':checked'));
		var id = $(this).siblings('input.position-id').val();
		var data = 'show-post=' + new_state + '&id=' + id + '&mod_data=update-posts-show';

		$.ajax({
			type: "POST",
			url: "php/data-modifier.php",
			data: data,
			success: function (msg) {
				CmsCommon.ShowResponseMessage(msg);
			},
			fail: function () {
				CmsCommon.ShowResponseMessage('0');
			}
		});
	});



	/*####  POST EDIT REDIRECT ####*/
	$('a.edit-post-button').click(function () {
		var post_id = $(this).siblings('.post-id').val();
		location.assign('/admin/index.php?page-name=edit-work-post&id=' + post_id);
	});



	/*####  DELETE POST ####*/
	var confirmPostDelDialog = $('div#confirm-post-del-dialog').dialog({
		autoOpen: false,
		resizable: false,
		modal: true,
		width: 'auto',
		buttons: [{
			text: "Yes",
			click: function () {
				var id = $(this).find(
					'#post-del-id').val();
				$(this).dialog("close");
				DeletePost(id);
			}
		}, {
				text: "No",
				click: function () {
					$(this).dialog("close");
				}
			}],
		close: function () {
			$(this).find('#post-del-id').val('');
		}
	});

	$('a.del-post-button').click(function () {
		var postName = $(this).siblings('.post-name').val();
		var postId = $(this).siblings('.post-id').val();

		confirmPostDelDialog.find('p:nth-of-type(2)')
			.html('Are you sure you want to delete <span class="highlight">"' + postName + '"</span> ?');
		confirmPostDelDialog.find('input#post-del-id').val(postId);
		confirmPostDelDialog.dialog('open');

		$('.ui-dialog :button').blur();
	});



	/*##### POSTS HOME POSITIONS SUBMIT #####*/
	function RearangeWorkPostsOnHomePage(posArray) {
		var data = 'positionsArray=' + posArray + '&mod_data=save-posts-home-positions';

		$.ajax({
			type: "POST",
			url: "php/data-modifier.php",
			data: data,
			success: function (msg) {
				CmsCommon.ShowResponseMessage(msg);
			},
			fail: function () {
				CmsCommon.ShowResponseMessage('0');
			}
		});
	}

	var PostHomePosSortable = $('div.home-page-sortable').sortable({
		containment: 'parent',
		items: '> ul.sortable',
		axis: 'y',
		handle: 'li:nth-child(1)',
		cursor: 'move',
		forcePlaceholderSize: true,
		scroll: true,
		update: function () {
			var posArray = $(this).sortable('toArray', { attribute: 'post-id' });
			RearangeWorkPostsOnHomePage(posArray);
		}
	}).disableSelection();



	/*##### EDIT POST SELECT BOX #####*/
	$('#edit_post_select').change(function () {
		location.assign('/admin/index.php?page-name=edit-work-post&id=' + $(this).val());
	});


	/*##### SHOW POST ON HOME PAGE TOGGLE #####*/
	$('#show-on-home').change(function () {
		if ($(this).is(':checked')) {
			$('#post-thumb-li').css({
				visibility: 'visible',
				opacity: 0
			}).animate({
				opacity: 1
			}, 200, function () {
				$(this).focus();
			});
		} else {
			$('#post-thumb-li').css({
				visibility: 'visible',
				opacity: 1
			}).animate({
				opacity: 0
			}, 200);
		}
	});


	/*##### POST FORM VALIDATION #####*/
	$('form.post-editor').validate({
		onfocusout: true,
		focusInvalid: false,
		errorPlacement: function (error, element) {
			$(element).parent().append(error);
		},
		errorElement: "span",
		rules: {
			'post-title-en': {
				required: true,
				minlength: 2
			},
			'post-location': {
				required: true,
				minlength: 2
			},
			'post-city': {
				required: true,
				minlength: 2
			},
			'post-country': {
				required: true,
				minlength: 2
			},
			'post-thumb': {
				required: '#show-on-home:checked'
			},
			'ckeditor-en': {
				required: true
			}
		}
	});


	/*####  POST THUMB BROWSE ####*/
	var fmDialog = $('#file_manager_dialog').dialog({
		autoOpen: false,
		resizable: false,
		modal: true,
		closeOnEscape: false,
		width: '800',
		height: '600',
		close: function () {
			$('#file_manager_cont').elfinder('destroy');
		}
	});

	$('input#post-thumb-browse').click(function () {
		$('#file_manager_cont').elfinder({
			url: 'elFinder-2.1.6/php/connector.php',
			width: 'auto',
			height: '566',
			resizable: false,
			uiOptions: CmsConfig.elfinderUiOptions,
			commandsOptions: {
				getfile: {
					multiple: false
				}
			},
			getFileCallback: function (file) {
				$('input#post-thumb').val(file.url);

				fmDialog.dialog('close');
			}
		});

		fmDialog.dialog('open');
	});


	/*####  NEW POST FORM SUBMIT ####*/
	$('input#new-post-submit').click(function () {
		if ($('form.post-editor').validate().form()) {

			if (!$('#use-title-de').is(':checked')) {
				$('#post-title-de').val('');
			}

			var data = $(this).parents('form.post-editor').serialize();
			var galleryDom = $(this).siblings(
				'div#gallery-editor').find(
					'div#gallery-preview');
			var galleryData = SerializeGallery(galleryDom);
			data += '&mod_data=new-post&' + galleryData;
			$.ajax({
				type: "POST",
				url: "php/data-modifier.php",
				data: data,
				success: function (msg) {
					if (msg === '1') {
						location.assign('/admin/index.php?page-name=manage-work-posts');
					} else {
						alert('error:\n' + msg);
					}
				},
				fail: function () {
					CmsCommon.ShowResponseMessage('0');
				}
			});
		}

	});


	/*####  EDIT POST FORM SUBMIT ####*/
	$('input#edit-post-submit').click(function () {
		if ($('form.post-editor').validate().form()) {

			if (!$('#use-title-de').is(':checked')) {
				$('#post-title-de').val('');
			}

			var data = $(this).parents('form.post-editor').serialize();
			var galleryDom = $(this).siblings(
				'div#gallery-editor').find(
					'div#gallery-preview');
			var galleryData = SerializeGallery(galleryDom);

			data += '&mod_data=edit-post&' + galleryData;

			$.ajax({
				type: "POST",
				url: "php/data-modifier.php",
				data: data,
				success: function (msg) {
					if (msg === '1') {
						location.assign('/admin/index.php?page-name=manage-work-posts');
					} else {
						alert('error:\n' + msg);
					}
				},
				fail: function () {
					CmsCommon.ShowResponseMessage('0');
				}
			});
		}
	});




	/*####  JqueryUI Button 'Add remove gallery editor' ####*/
	var addRemoveGallBtn = $("span#add-gallery")/*.button({
	 icons: {
	 primary: "ui-icon-plus"
	 },
	 text: false
	 })*/.click(function () {
		var currAdded = $(this).attr('custom-added');
		if (currAdded === 'false') {
			if ($('div#gallery-editor').html() === '') {
				$('div#gallery-editor').load('php/gallery.php');
			}

			$('div#gallery-editor').fadeIn(250);
			$(this).attr('custom-added', 'true');
			$(this).siblings('label').html('Remove gallery');
			//            addRemoveGallBtn.button("option", "icons", {
			//                primary: "ui-icon-minus"
			//            });
			$(this).removeClass('ui-icon-plus');
			$(this).addClass('ui-icon-minus');
		} else {
			$(this).parent('div').siblings('div#gallery-editor').fadeOut(250);
			$(this).attr('custom-added', 'false');
			$(this).siblings('label').html('Add gallery');
			//            addRemoveGallBtn.button("option", "icons", {
			//                primary: "ui-icon-plus"
			//            });
			$(this).removeClass('ui-icon-minus');
			$(this).addClass('ui-icon-plus');
		}
	});


	var currGalleryStatus = $("button#add-gallery").attr('custom-added');
	if (currGalleryStatus === 'true') {
		addRemoveGallBtn.button("option", "icons", {
			primary: "ui-icon-minus"
		});
	}


});