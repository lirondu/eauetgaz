/* global CKEDITOR, CmsCommon */

CKEDITOR.disableAutoInline = true;

CKEDITOR.on('instanceCreated', function (event) {
	var editor = event.editor,
			element = editor.element;

	if (element.is('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'h7')) {
		editor.on('configLoaded', function () {
			editor.config.removePlugins = 'about,basicstyles,colorbutton,find,flash,font,' +
					'forms,iframe,image,newpage,removeformat,' +
					'scayt,smiley,specialchar,stylescombo,templates,links';

			editor.config.removeButtons = 'Link,Unlink,Anchor,PasteFromWord,Outdent,Indent';

		});
	}
});

function EnableAdminButtonsOnChange() {
	$('.cms-menu-btn').removeClass('disabled');
}


function InitializeInlineEditors() {
	$('.cms-editable-editor').each(function () {
		CKEDITOR.inline(this, {
			filebrowserBrowseUrl: 'admin/elFinder-2.1.6/elfinder.php',
			on: {
				change: function () {
					EnableAdminButtonsOnChange();
				}
			}
		});
	});

	$('.cms-editable-text').each(function () {
		var value = $.trim($(this).html());
		var name = $(this).attr('edit-field');

		$(this).text('');

		$(this).append($('<input type="text" name="' + name + '" value="' + value + '">'));
	});

	$('.cms-editable-list').each(function () {
		var dbFieldName = $(this).attr('edit-field');
		var listName = $(this).attr('edit-list');
		var active = $(this).attr('edit-active');
		var title = $(this).attr('title');
		var names = $('#edit_' + listName + '_names').val().split(',');
		var ids = $('#edit_' + listName + '_ids').val().split(',');

		var selectList = $('<select class="cms-editable-list" data-toggle="tooltip"' +
				' name="' + dbFieldName + '" title="' + title + '"></select>');

		for (var i = 0; i < names.length; i++) {
			if (ids[i] === active) {
				selectList.append($('<option value="' + ids[i] + '" selected="selected">' + names[i] + '</option>'));
			} else {
				selectList.append($('<option value="' + ids[i] + '">' + names[i] + '</option>'));
			}
		}

		$(this).before(selectList);
		$(this).remove();
	});
}


function SerializePageInlineContent() {
	var id = $('#edit_id').val();
	var table = $('#edit_table').val();
	var data = "table=" + table + "&id=" + id;


	$('.cms-editable-text').each(function () {
		data += '&' + $(this).find('input').serialize();
	});

	$('.cms-editable-list').each(function () {
		data += '&' + $(this).serialize();
	});

	$('.cms-editable-editor').each(function () {
		if ($(this).is('p')) {
			data += '&' + $('<textarea name="' + $(this).attr('edit-field') + '">' + $(this).html() + '</textarea>').serialize();
		}
	});


	return data;
}


function CustomSerialize(selector) {
	var data = $(selector).serialize();

	if (data !== '') {
		data = '&' + data;
	}

	return data;
}


function SubmitInlineForm(table, data) {
	switch (table) {
		case 'article':
			var tmpData = data + '&mod_data=update-inline-article';
//			console.log(tmpData); return ;
			$.ajax({
				type: "POST",
				url: "./admin/php/db-modifier.php",
				data: tmpData,
				success: function (msg) {
					CmsCommon.ShowResponseMessage(msg);
				},
				fail: function () {
					CmsCommon.ShowResponseMessage('0');
				}
			});
			break;

		default :
			break;
	}
}




$(function () {

	// Markup editable content (for cke and bootstrap)
	$('.cms-editable-editor').attr('contenteditable', true);
	$('.cms-editable-editor, .cms-editable-text').attr('data-toggle', 'tooltip');
	$('.cms-editable-editor, .cms-editable-text, .cms-editable-list').each(function () {
		var title = 'Click to edit';

		if ($(this).attr('tooltip')) {
			title = $(this).attr('tooltip');
		}

		$(this).attr('title', title);
	});

	// Initialize editors from markup
	InitializeInlineEditors();

	// Bootstrap tooltip
	$('[data-toggle="tooltip"]').tooltip()

	// Cancel button action
	$('#cancel_page_changes').click(function () {
		location.reload();
	});

	// Save button action
	$('#article_inline_save').click(function () {
		if ($('#article_inline_form').validate().form()) {
			var data = SerializePageInlineContent();
			data += CustomSerialize('#has_de');
			data += CustomSerialize('#has_it');

			SubmitInlineForm('article', data);
		}
	});

	// Enable save & cancel buttons when list is changed
	$('.cms-editable-list').change(function () {
		EnableAdminButtonsOnChange();
	});

	// Enable save & cancel buttons when text is changed
	$('.cms-editable-text input[type="text"]').on('input', function () {
		EnableAdminButtonsOnChange();
	});

	// Article inline editor validation #####*/
	$('#article_inline_form').validate({
		rules: {
			'writer_id': {
				required: true
			},
			'title_en': {
				required: true,
				minlength: 2
			},
			'content_en': {
				required: true,
				minlength: 50
			},
			'content_de': {
				required: '#has_de:checked',
				minlength: 50
			},
			'content_it': {
				required: '#has_it:checked',
				minlength: 50
			}
		}
	});

});