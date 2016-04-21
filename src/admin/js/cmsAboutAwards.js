/* global CmsCommon */

$(function () {

	function SubmitAwardsOrder(posArray) {
		var data = 'positionsArray=' + posArray + '&mod_data=about-award-rearange';
		
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
	var awardsSortable = $('div.awards-sortable').sortable({
		items: '> ul.sortable',
		axis: 'y',
		handle: 'li:nth-child(1)',
		cursor: 'move',
		forcePlaceholderSize: true,
		update: function () {
			var posArray = $(this).sortable('toArray', {attribute: 'custom-id'});
			SubmitAwardsOrder(posArray);
		}
	}).disableSelection();


	// Award form validation rules
	$('#award_form').validate({
		onfocusout: true,
		focusInvalid: false,
		errorElement: "span",
		errorPlacement: function (error, element) {
			$(element).parents('li').first().append(error);
		},
		rules: {
			'award_form_year': {
				required: true,
				number: true,
				minlength: 4,
				maxlength: 4
			},
			'award_form_content': {
				required: true,
				minlength: 1
			}
		}
	});



	function AddAwardBox(id, year, content) {
		var newAwardContainer = $('ul.sortable').first().clone();

		newAwardContainer.attr('custom-id', id);
		newAwardContainer.find('span.award-year').html(year);
		newAwardContainer.find('a.award-content').html(content);

		$('div.awards-sortable').find('ul').last().before(newAwardContainer);
		RegisterAwardsActions();
	}


	function UpdateAwardBox(id, year, content) {
		var awardContainer = $('ul.sortable[custom-id=' + id + ']');

		awardContainer.find('span.award-year').html(year);
		awardContainer.find('a.award-content').html(content);
	}


	function DeleteAwardBox(id) {
		var awardContainer = $('ul.sortable[custom-id=' + id + ']');

		awardContainer.hide('slow', function () {
			awardContainer.remove();
		});
	}


	function SubmitAwardDelete(id) {
		var data = 'id=' + id + '&mod_data=about-award-delete';

		$.ajax({
			type: "POST",
			url: "php/data-modifier.php",
			data: data,
			success: function (msg) {
				CmsCommon.ShowResponseMessage(msg);

				if (msg === '1') {
					DeleteAwardBox(id);
					awardDeleteDialog.dialog('close');
				}
			},
			fail: function () {
				CmsCommon.ShowResponseMessage('0');
			}
		});
	}


	function SubmitAwardForm() {
		if (!$('#award_form').validate().form()) {
			return false;
		}

		var isAwardExist = ($('#award_form').find('#award_form_id').attr('custom-award-exist') === 'true') ? true : false;
		var data = $('#award_form').serialize();
		var year = $('#award_form_year').val();
		var content = $('#award_form_content').val();

		if (isAwardExist) {
			var id = $('#award_form_id').val();
			data += '&id=' + id + '&mod_data=about-award-update';

			$.ajax({
				type: "POST",
				url: "php/data-modifier.php",
				data: data,
				success: function (msg) {
					CmsCommon.ShowResponseMessage(msg);

					if (msg === '1') {
						UpdateAwardBox(id, year, content);
						awardFormDialog.dialog('close');
					}
				},
				fail: function () {
					CmsCommon.ShowResponseMessage('0');
				}
			});
		} else {
			data += '&mod_data=about-award-new';

			$.ajax({
				type: "POST",
				url: "php/data-modifier.php",
				data: data,
				success: function (msg) {
					var returnVal = msg.split(',');

					if (returnVal.length !== 2) {
						CmsCommon.ShowResponseMessage('0');
						return false;
					} else {
						CmsCommon.ShowResponseMessage(returnVal[0]);

						if (returnVal[0] === '1') {
							var id = returnVal[1];

							AddAwardBox(id, year, content);
							awardFormDialog.dialog('close');
						}
					}
				},
				fail: function () {
					CmsCommon.ShowResponseMessage('0');
				}
			});


		}
		return true;
	}


	// Award form dialog
	var awardFormDialog = $('#award_form_dialog').dialog({
		autoOpen: false,
		resizable: false,
		modal: true,
		width: 'auto',
		buttons: [
			{
				text: "Save",
				click: function () {
					SubmitAwardForm();
				}
			},
			{
				text: "Cancel",
				click: function () {
					$(this).dialog("close");
				}
			}
		],
		open: function () {

		},
		close: function () {
			$('#award_form_id').val('');
			$('#award_form_year').val(CmsCommon.dateYear);
			$('#award_form_content').val('');
		}
	});



	// Award deletion dialog
	var awardDeleteDialog = $('#award_delete_dialog').dialog({
		autoOpen: false,
		resizable: false,
		modal: true,
		width: 'auto',
		buttons: [
			{
				text: "Yes",
				click: function () {
					var id = $(this).find('#award_to_delete_id').val();
					SubmitAwardDelete(id);
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
			$('#award_to_delete_id').val('');
			$('#award_to_delete_name').html('');
		}
	});


	// Initialize spinner
	$('#award_form_year').spinner({
		min: 1900,
		max: 2100
	});

	// Set current year as default value
	$('#award_form_year').val(CmsCommon.dateYear);



	// Add award
	$('span.add-about-award').click(function () {
		$('#award_form').find('#award_form_id').attr('custom-award-exist', 'false');
		awardFormDialog.dialog('open');
	});


	//Bind form submit to click 'Save'
	$('#award_form').submit(function () {
		SubmitAwardForm();
	});



	function RegisterAwardsActions() {

		// Edit award
		$('a.award-content').click(function () {
			var id = $(this).parents('ul.sortable').attr('custom-id');
			var year = $(this).parents('ul.sortable').find('span.award-year').html().trim();
			var content = $(this).html().trim();

			$('#award_form').find('#award_form_id').attr('custom-award-exist', 'true');
			$('#award_form').find('#award_form_id').val(id);
			$('#award_form').find('#award_form_year').val(year);
			$('#award_form').find('#award_form_content').val(content);

			awardFormDialog.dialog('open');
		});

		// Delete award
		$('a.delete-award').click(function () {
			var id = $(this).parents('ul.sortable').attr('custom-id');
			var name = $(this).parents('ul.sortable').find('a.award-content').html().trim().split(',')[0];

			$('#award_delete_dialog').find('#award_to_delete_id').val(id);
			$('#award_delete_dialog').find('#award_to_delete_name').html(name);

			awardDeleteDialog.dialog('open');
		});
	}

	RegisterAwardsActions();

});