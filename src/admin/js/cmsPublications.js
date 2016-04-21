/* global CmsCommon, CKEDITOR, CmsConfig */

$(function () {
	
	function SubmitPublicationsOrder(posArray) {
		var data = 'positionsArray=' + posArray + '&mod_data=publications-order';
		
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


	// Initialize sortable
	$('div.pubs-sortable').sortable({
		items: '> ul.sortable',
		axis: 'y',
		handle: 'li:nth-child(1)',
		cursor: 'move',
		forcePlaceholderSize: true,
		update: function () {
			var posArray = $(this).sortable('toArray', {attribute: 'custom-id'});
			SubmitPublicationsOrder(posArray);
		}
	}).disableSelection();


	// Publication form validation rules
	$('form.publication-editor').validate({
		onfocusout: true,
		focusInvalid: false,
		errorElement: "span",
		errorPlacement: function (error, element) {
			$(element).parents('li').first().append(error);
		},
		rules: {
			'pub_title': {
				required: true,
				minlength: 1
			}
		}
	});



	// Submit new publication
	function SubmitPublicationNew() {
		var data = $('form.publication-editor').serialize();
		data += '&mod_data=publication-new';

		$.ajax({
			type: "POST",
			url: "php/data-modifier.php",
			data: data,
			success: function (msg) {
				if (msg === '1') {
					location.assign('/admin/index.php?page-name=manage-publications');
				} else {
					CmsCommon.ShowResponseMessage('0');
				}
			},
			fail: function () {
				CmsCommon.ShowResponseMessage('0');
			}
		});
	}


	// Submit edit publication
	function SubmitPublicationEdit() {
		var data = $('form.publication-editor').serialize();
		data += '&mod_data=publication-edit';

		$.ajax({
			type: "POST",
			url: "php/data-modifier.php",
			data: data,
			success: function (msg) {
				if (msg === '1') {
					location.assign('/admin/index.php?page-name=manage-publications');
				} else {
					CmsCommon.ShowResponseMessage('0');
				}
			},
			fail: function () {
				CmsCommon.ShowResponseMessage('0');
			}
		});
	}


	// publication form submit
	$('form.publication-editor').submit(function () {
		if (!$(this).validate().form()) {
			return;
		}

		if ($(this).attr('custom-new') === 'false') {
			SubmitPublicationEdit();
		} else {
			SubmitPublicationNew()
		}
	});


	// Edit publication SELECT redirect
	$('#edit_pub_select').change(function () {
		var id = $(this).val();
		location.assign('/admin/index.php?page-name=edit-publication&id=' + id);
	});



	function RemovePublicationRow(id) {
		var pubContainer = $('ul.sortable[custom-id=' + id + ']');

		pubContainer.hide('slow', function () {
			pubContainer.remove();
		});
	}


	function SubmitPublicationDelete(id) {
		var data = 'id=' + id + '&mod_data=publication-delete';

		$.ajax({
			type: "POST",
			url: "php/data-modifier.php",
			data: data,
			success: function (msg) {
				if (msg === '1') {
					publicationDeleteDialog.dialog('close');
					RemovePublicationRow(id);
				} else {
					CmsCommon.ShowResponseMessage('0');
				}
			},
			fail: function () {
				CmsCommon.ShowResponseMessage('0');
			}
		});
	}


	// Publication deletion dialog
	var publicationDeleteDialog = $('#pub_delete_dialog').dialog({
		autoOpen: false,
		resizable: false,
		modal: true,
		width: 'auto',
		buttons: [
			{
				text: "Yes",
				click: function () {
					var id = $(this).find('#pub_to_delete_id').val();
					SubmitPublicationDelete(id);
				}
			},
			{
				text: "No",
				click: function () {
					$(this).dialog("close");
				}
			}
		],
		open: function () {

		},
		close: function () {
			$('#pub_to_delete_id').val('');
			$('#pub_to_delete_name').html('');
		}
	});



	// Publication delete
	$('a.delete-publication').click(function () {
		var id = $(this).parents('ul.sortable').attr('custom-id');
		var name = $(this).parents('ul.sortable').find('a.publication-title').html().trim().split(',')[0];

		$('#pub_delete_dialog').find('#pub_to_delete_id').val(id);
		$('#pub_delete_dialog').find('#pub_to_delete_name').html(name);

		publicationDeleteDialog.dialog('open');
	});

});