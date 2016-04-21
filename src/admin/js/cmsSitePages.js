/* global CmsCommon */

$(function () {
	/**************************************************************************/
	/* Manage main pages
	 /**************************************************************************/

	function DeleteMenuPage(id) {
		var data = 'id=' + id + '&mod_data=del-menu-page';
		$.ajax({
			type: "POST",
			url: "php/db-modifier.php",
			data: data,
			success: function (msg) {
				if (msg === '1') {
					location.reload();
				} else {
					CmsCommon.ShowResponseMessage('0');
				}
			},
			fail: function () {
				CmsCommon.ShowResponseMessage('0');
			}
		});
	}



	/*##### MENU POSITIONS SORT #####*/
	function RearangeChangeablePages(posArray) {
		var data = 'positionsArray=' + posArray + '&mod_data=pages-rearange-changeable';

		$.ajax({
			type: "POST",
			url: "php/db-modifier.php",
			data: data,
			success: function (msg) {
				CmsCommon.ShowResponseMessage(msg);
			},
			fail: function () {
				CmsCommon.ShowResponseMessage('0');
			}
		});
	}

	var pagesPositionsSortable = $('div#table').sortable({
		items: '> ul.sortable',
		axis: 'y',
		handle: 'li:nth-child(1)',
		cursor: 'move',
		forcePlaceholderSize: true,
		update: function () {
			var posArray = $(this).sortable('toArray', {attribute: 'custom-id'});
			RearangeChangeablePages(posArray);
		}
	}).disableSelection();


	/*##### SHOW IN MENU TOGGLE #####*/
	$('input.show-in-menu').change(function () {
		var new_state = ($(this).is(':checked'));
		var id = $(this).siblings('input.position-id').val();
		var data = 'show-in-menu=' + new_state + '&id=' + id + '&mod_data=update-menu-show';

		$.ajax({
			type: "POST",
			url: "php/db-modifier.php",
			data: data,
			success: function (msg) {
				CmsCommon.ShowResponseMessage(msg);
			},
			fail: function () {
				CmsCommon.ShowResponseMessage('0');
			}
		});

	});



	/*####  PAGE EDIT REDIRECT ####*/
	$('a.edit-page-button').click(function () {
		var page_id = $(this).siblings('.page-id').val();
		location.assign('/admin/index.php?page-name=edit-page&id=' + page_id);
	});


	



	/**************************************************************************/
	/* Create page + Edit page
	 /**************************************************************************/

	/*##### PAGE FORM VALIDATION #####*/
	$('form.page-editor').validate({
		rules: {
			'title-en': {
				required: true,
				minlength: 2
			}
		},
		messages: {
			'title-en': "Please add name."
		}
	});


	/*####  NEW PAGE FORM SUBMIT ####*/
	$('input#new-page-submit').click(function () {
		if ($('form.page-editor').validate().form()) {
			var data = $(this).parents('form.page-editor').serialize();
			data += '&mod_data=new-page';
			$.ajax({
				type: "POST",
				url: "php/data-modifier.php",
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


	/*##### EDIT PAGE SELECT BOX #####*/
	$('#edit_page_select').change(function () {
		location.assign('/admin/index.php?page-name=edit-page&id=' + $(this).val());
	});


	/*####  EDIT PAGE FORM SUBMIT ####*/
	$('input#edit-page-submit').click(function () {
		var confirmEmpty;
		if ($('#ckeditor').val() === '') {
			confirmEmpty = confirm('You have no content for the page.\nDo you want to continue?');
		} else {
			confirmEmpty = true;
		}

		if (confirmEmpty && $('form.page-editor').validate().form()) {
			var data = $(this).parents('form.page-editor').serialize();
			data += '&mod_data=edit-page';
			$.ajax({
				type: "POST",
				url: "php/data-modifier.php",
				data: data,
				success: function (msg) {
					location.assign('/admin/index.php');
				},
				fail: function () {
					CmsCommon.ShowResponseMessage('0');
				}
			});
		}

	});



	/*####  EDIT ABOUT PAGE FORM SUBMIT ####*/
	$('input#edit-about-page-submit').click(function () {
		if ($('form.page-editor').validate().form()) {
			var data = $(this).parents('form.page-editor').serialize();
			data += '&mod_data=edit-about-page';
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

	});



	/*##### UNDER CONSTRUCTION TOGGLE #####*/
	function UpdateUnderConstruction(state) {
		var data = 'construction=' + state + '&mod_data=update-construction';
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


	var confirmUnderConstDialog = $('div#confirm_under_const').dialog({
		autoOpen: false,
		resizable: false,
		modal: true,
		width: 'auto',
		buttons: [
			{
				text: "Yes",
				click: function () {
					var newState = $('input.construction-toggle').is(':checked');
					UpdateUnderConstruction(newState);
					$(this).dialog("close");
				}
			},
			{
				text: "No",
				click: function () {
					$('input.construction-toggle').prop('checked', false);
					$(this).dialog("close");
				}
			}
		]
	});


	$('input.construction-toggle').change(function () {
		var newState = ($(this).is(':checked'));

		if (newState) {
			confirmUnderConstDialog.dialog('open');
			return;
		}

		UpdateUnderConstruction(newState);
	});




	// new EAU&GAZ //

	// New Page
	$('#add_menu_page').click(function () {
		var data = 'mod_data=new-menu-page';
		$.ajax({
			type: "POST",
			url: "php/db-modifier.php",
			data: data,
			success: function (msg) {
				var retCode = msg.split(',');

				if (retCode[0] === '1') {
					location.assign('/admin/index.php?page-name=edit-page&id=' + retCode[1]);
				} else {
					CmsCommon.ShowResponseMessage('0');
				}
			},
			fail: function () {
				CmsCommon.ShowResponseMessage('0');
			}
		});
	});
	
	
	/*####  DELETE PAGE ####*/
	var confirmPageDelDialog = $('#confirm-page-del-dialog').dialog({
		autoOpen: false,
		resizable: false,
		modal: true,
		width: 'auto',
		buttons: [{
				text: "Yes",
				click: function () {
					var id = $(this).find('#page-id').val();
					$(this).dialog("close");
					DeleteMenuPage(id);
				}
			}, {
				text: "No",
				click: function () {
					$(this).dialog("close");
				}
			}],
		close: function () {
			$(this).find('#page-id').val('');
		}
	});

	$('a.del-page-button').click(function () {
		var pageName = $(this).siblings('.page-name').val();
		var pageId = $(this).siblings('.page-id').val();

		confirmPageDelDialog.find('p:nth-of-type(2)').html('Are you sure you want to delete <span class="highlight">"' + pageName + '"</span> ?');
		confirmPageDelDialog.find('input#page-id').val(pageId);
		confirmPageDelDialog.dialog('open');

		$('.ui-dialog :button').blur();
	});


});