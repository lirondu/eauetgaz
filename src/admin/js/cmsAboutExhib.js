/* global CmsCommon */

$(function () {
	/*********************/
	/* ABOUT EXHIBITIONS */
	/*********************/

	var delExhibitionDialog = $('div#del_exhib_dialog').dialog({
		autoOpen: false,
		resizable: false,
		modal: true,
		width: 'auto',
		buttons: [
			{
				text: "Yes",
				click: function () {
					var id = $(this).find('input#exhib-del-id').val();
					var data = 'id=' + id + '&mod_data=about-exhib-delete';

					$.ajax({
						type: "POST",
						url: "php/data-modifier.php",
						data: data,
						success: function (msg) {
							CmsCommon.ShowResponseMessage(msg);

							if (msg === '1') {
								$('ul.sortable').each(function () {
									if ($(this).find('input.exhib-id').val() === id) {
										$(this).remove();
										return false;
									}
								});
							}
						},
						fail: function () {
							CmsCommon.ShowResponseMessage('0');
						}
					});

					$(this).dialog("close");
				}
			},
			{
				text: "No",
				click: function () {
					$(this).dialog("close");
				}
			}
		],
		close: function () {
			$(this).find('span#del_exhib_name').html('');
			$(this).find('input#exhib-del-id').val('');
		}
	});


	function RearangeYearExhibitions(year, posArray) {
		var data = 'year=' + year + '&positionsArray=' + posArray + '&mod_data=about-exhib-rearange-year';

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


	function RegisterExhibRowButtons() {
		// Keyup Event - while typing, check if to offer save
		$('input.exhib_content').keyup(function () {
			var storedValue = $(this).attr('stored-value');
			var saveBtn = $(this).siblings('input.exhib_save_content');

			if ($(this).val() !== storedValue) {
				saveBtn.removeAttr('disabled');
				saveBtn.button('option', 'disabled', false);
				saveBtn.addClass('ui-state-error');
			} else {
				saveBtn.attr('disabled', 'disabled');
				saveBtn.button('option', 'disabled', true);
				saveBtn.removeClass('ui-state-error');
			}
		});


		// Save Exhibition Content
		$('input.exhib_save_content').click(function () {
			var content = $(this).siblings('input.exhib_content').val();
			var contentElement = $(this).siblings('input.exhib_content');
			var id = $(this).siblings('input.exhib-id').val();
			var data = 'content=' + content + '&id=' + id + '&mod_data=about-exhib-update-content';

			$.ajax({
				type: "POST",
				url: "php/data-modifier.php",
				data: data,
				success: function (msg) {
					CmsCommon.ShowResponseMessage(msg);

					if (msg === '1') {
						contentElement.attr('stored-value', content);
						contentElement.keyup();
					}
				},
				fail: function () {
					CmsCommon.ShowResponseMessage('0');
				}
			});
		});


		// Solo checkbox change
		$('input.exhib_solo').change(function () {
			var id = $(this).siblings('input.exhib-id').val();
			var newState = ($(this).is(':checked'));
			var data = 'id=' + id + '&state=' + newState + '&mod_data=about-exhib-update-solo';

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


		// Delete Exhibition
		$('a.del-about-exhib').click(function () {
			var id = $(this).siblings('input.exhib-id').val();
			var name = $(this).parents('ul.sortable').find('input.exhib_content').val();
			name = name.split(',');

			$('div#del_exhib_dialog').find('span#del_exhib_name').html(name[0]);
			$('div#del_exhib_dialog').find('input#exhib-del-id').val(id);
			delExhibitionDialog.dialog('open');
		});
	}


	function RegisterYearBoxButtons() {
		// Delete Exhibition Year
		$('span.del_exhib_year').click(function () {
			var year = $(this).parent('h2').attr('custom-year');

			$('div#del_year_dialog').find('span#del_year').html(year);
			delYearDialog.dialog('open');
		});


		//Initialize sortable
		$('div.year_exhib_box').sortable({
			items: '> ul.sortable',
			axis: 'y',
			handle: 'li:nth-child(1)',
			cursor: 'move',
			forcePlaceholderSize: true,
			update: function () {
				var posArray = $(this).sortable('toArray', { attribute: 'custom-id' });
				var year = $(this).find('h2').attr('custom-year');
				RearangeYearExhibitions(year, posArray);
			}
		});
		
		
		// Register add exhibtion click
		$('span.add_about_exhib').click(function () {
			var currentYearContainer = $(this).parents('div.year_exhib_box');
			var year = $(this).parents('div.year_exhib_box').children('h2').attr('custom-year');
			var data = 'year=' + year + '&mod_data=add-about-exhib';

			$.ajax({
				type: "POST",
				url: "php/data-modifier.php",
				data: data,
				success: function (msg) {
					var rc = msg.split(',')[0];
					if (rc !== '1') {
						CmsCommon.ShowResponseMessage('0');
					} else {
						var newId = msg.split(',')[1];
						var newExhibContainer = $('ul.sortable').first().clone();

						newExhibContainer.attr('custom-id', newId);
						newExhibContainer.find('input[type=text]').val('');
						newExhibContainer.find('input.exhib_content').attr('stored-value', '');
						newExhibContainer.find('input.exhib_save_content').removeClass('ui-state-error');
						newExhibContainer.find('input.exhib_save_content').button({ disabled: true });
						newExhibContainer.find('input.exhib-id').val(newId);

						currentYearContainer.find('ul.header').first().after(newExhibContainer);

						RegisterExhibRowButtons();
					}
				},
				fail: function () {
					CmsCommon.ShowResponseMessage('0');
				}
			});
		});

		RegisterExhibRowButtons();
	}


	// Run once on page load, for existing elements
	RegisterYearBoxButtons();


	/* DELETE YEAR */
	function DeleteYearBox(year) {
		$('div.year_exhib_box').each(function () {
			if ($(this).children('h2').attr('custom-year') === year) {
				$(this).remove();
				return false;
			}
		});
	}


	var delYearDialog = $('div#del_year_dialog').dialog({
		autoOpen: false,
		resizable: false,
		modal: true,
		width: 'auto',
		buttons: [
			{
				text: "Yes",
				click: function () {
					var year = $(this).find('span#del_year').html();
					var data = 'year=' + year + '&mod_data=about-exhib-delete-year';

					$.ajax({
						type: "POST",
						url: "php/data-modifier.php",
						data: data,
						success: function (msg) {
							CmsCommon.ShowResponseMessage(msg);

							if (msg === '1') {
								DeleteYearBox(year);
							}
						},
						fail: function () {
							CmsCommon.ShowResponseMessage('0');
						}
					});

					$(this).dialog("close");
				}
			},
			{
				text: "No",
				click: function () {
					$(this).dialog("close");
				}
			}
		],
		close: function () {
			$(this).find('span#del_year').html('');
		}
	});


	$('span.del_exhib_year').click(function () {
		var year = $(this).parent().attr('custom-year');

		$('div#del_year_dialog').find('span#del_year').html(year);
		delYearDialog.dialog('open');
	});



	/* ADD YEAR */
	function FindNewExhibYearPosition(year) {
		var yearNum = parseInt(year);
		console.log(yearNum);
		var retValue = '-1';

		$('div.year_exhib_box').each(function () {
			var currentBoxYear = parseInt($(this).find('h2').attr('custom-year'));
			console.log(currentBoxYear);

			if (yearNum > currentBoxYear) {
				retValue = $(this);
				return false;
			}
		});

		return retValue;
	}


	function AddExhibYear(year) {
		var data = 'year=' + year + '&mod_data=about-exhib-add-year';
		var boxAfterNewYear = FindNewExhibYearPosition(year);
		console.log(boxAfterNewYear);

		$.ajax({
			type: "POST",
			url: "php/data-modifier.php",
			data: data,
			success: function (msg) {
				var rc = msg.split(',')[0];
				CmsCommon.ShowResponseMessage(rc);

				if (rc === '1') {
					var newId = msg.split(',')[1];
					var newYearContainer = $('div.year_exhib_box').first().clone();
					var newYearDeleteBtn = newYearContainer.find('h2').find('span.del_exhib_year');

					newYearContainer.find('h2').html(year);
					newYearContainer.find('h2').attr('custom-year', year);
					newYearContainer.find('h2').append(newYearDeleteBtn);
					newYearContainer.find('ul.sortable').not(':first').remove();
					newYearContainer.find('input[type=text]').val('');
					newYearContainer.find('input[type=text]').attr('stored-value', '');
					newYearContainer.find('input.exhib_save_content').button({ disabled: true });
					newYearContainer.find('input.exhib-id').val(newId);

					if (boxAfterNewYear === '-1') {
						$('div.year_exhib_box').last().after(newYearContainer);
					} else {
						boxAfterNewYear.before(newYearContainer);
					}

					RegisterYearBoxButtons();
				}
			},
			fail: function () {
				CmsCommon.ShowResponseMessage('0');
			}
		});
	}

	function AddExhibYearCheckDuplicate(year) {
		var data = 'year=' + year + '&mod_data=exhib-year-check-exist';

		$.ajax({
			type: "POST",
			url: "php/data-modifier.php",
			data: data,
			success: function (msg) {
				if (msg === '0') {
					$('#error_dupl_year').html(year);
					$('#year_exist_err').fadeIn('slow', function () {
						$(this).delay(4000).fadeOut('slow', function () { 
							$('#error_dupl_year').html('');
						});
					});
				} else {
					AddExhibYear(year);
				}
			},
			fail: function () {
				CmsCommon.ShowResponseMessage('0');
			}
		});
	}

	var addNewYearDialog = $('div#add_year_dialog').dialog({
		autoOpen: false,
		resizable: false,
		modal: true,
		width: 'auto',
		buttons: [
			{
				text: "Yes",
				click: function () {
					AddExhibYearCheckDuplicate($(this).find('input#new_year').val());
					$(this).dialog("close");
				}
			},
			{
				text: "No",
				click: function () {
					$(this).dialog("close");
				}
			}
		],
		close: function () {
			$(this).find('input').val('');
		}
	});

	$('span.add_about_exhib_year').click(function () {
		addNewYearDialog.dialog('open');
	});

	$('input#new_year').keypress(function (e) {
		//var currYear = $(this).val();
		if (e.keyCode === $.ui.keyCode.ENTER) {
			AddExhibYearCheckDuplicate($('input#new_year').val());
			addNewYearDialog.dialog("close");
		}
	});



});