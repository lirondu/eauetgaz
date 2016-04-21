var ThumbMaker = {};

ThumbMaker.topBarHeight = $('#header').height();
ThumbMaker.progressHeight = $('#thumbs_progress').height();
ThumbMaker.occupiedSpace = ThumbMaker.topBarHeight + ThumbMaker.progressHeight + 15;
	
	
// Thumb fail error dialog
ThumbMaker.errorDialog = $('#thumbs_error_details').dialog({
	autoOpen: false,
	resizable: false,
	modal: true,
	width: 'auto',
	buttons: [{
		text: "Ok",
		click: function () {
			$(this).dialog("close");
		}
	}]
});


// Process respone from PHP and show relevant message
ThumbMaker.ShowThumbMakerResponse = function (status) {
	if (status === '1') {
		if ($('#thumbs_progress').attr('custom-on') === 'true') {
			return;
		}

		setTimeout(function () {
			$('#progress_title').text('Thumbnails created successfully');
		}, 4000);

		setTimeout(function () {
			$('#thumbs_progress').fadeOut(500, function () {
				$('#progress_title').text('Preparing Thumbs...');
			});
		}, 8000);
	} else {
		$('#thumbs_progress').attr('custom-on', 'true');
		var filesArray = status.split(';');

		for (i in filesArray) {
			if (filesArray[i].length === 0) {
				continue;
			}

			$('#thumbs_error_details').find('ul').append('<li>' + filesArray[i] + '</li>');
		}

		$('#progress_title').html('Thumbnails failed!! ' +
			'<a id="show_files" href="javascript:void(0)">Click here</a> for details...');
		$('#thumbs_progress').addClass('ui-state-error');
		$('#thumbs_progress').removeClass('ui-state-highlight');

		$('#close_error_handle').fadeIn('fast');


		$('#show_files').click(function () {
			ThumbMaker.errorDialog.dialog('open');
		});
	}
}


// elfinder params - with upload event for thumbs (used in other files)
ThumbMaker.elfinderParams = {
	url: 'elFinder-2.1.6/php/connector.php',
	width: '99%',
	height: $(window).height() - ThumbMaker.occupiedSpace,
	resizable: false,
	uiOptions: CmsConfig.elfinderUiOptions,
	handlers: {
		upload: function (event, instance) {
			$('#thumbs_progress').fadeIn('slow');

			var uploadedFiles = event.data.added;
			if (uploadedFiles.length === 0) {
				return;
			}

			var allowedMimes = ['image/gif', 'image/jpeg', 'image/png'];
			var filesList = '';

			for (i in uploadedFiles) {
				var file = uploadedFiles[i];

				if ($.inArray(file.mime, allowedMimes) >= 0) {
					var fullName = file.hash.substring(3);
					fullName = window.atob(fullName);

					filesList += fullName;

					if (i !== (uploadedFiles.length - 1)) {
						filesList += ';';
					}
					console.log(filesList);
				}

			} //end of uploaded file loop

			$.ajax({
				type: "POST",
				url: "php/elfUplThumbMaker.php",
				data: 'op=create-thumbnails&files=' + filesList,
				success: function (msg) {
					ThumbMaker.ShowThumbMakerResponse(msg);
				}
			});

		} //end upload event
	}
};



$(function () { 
	// Close error box
    $('#close_error_handle').click(function () {
        $(this).parents('#thumbs_progress').attr('custom-on', 'false');
        $(this).parents('#thumbs_progress').fadeOut('slow', function () {
            $('#progress_title').html('Preparing Thumbs...');
            $('#thumbs_progress').removeClass('ui-state-error');
            $('#thumbs_progress').addClass('ui-state-highlight');
            $('#close_error_handle').hide();
        });
    });
	

	// initialize elfinder
    var elf = $('#fm-container').elfinder(ThumbMaker.elfinderParams);

	
	// Handle window resize
    $(window).resize(function () {
        elf.height($(window).height() - ThumbMaker.occupiedSpace);
    });
});