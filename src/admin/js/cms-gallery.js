/*####  Globals ####*/
/* global CmsConfig, ThumbMaker */

var gallPreview = $('div#gallery-preview');
var numOfPicsInGallery = 1;


/*####  JqueryUI Dialogs ####*/

var newPicPosition = $('div#img-pos-dialog').dialog({
    autoOpen: false,
    resizable: false,
    modal: true,
    width: 'auto'
});


var EditPicTitle = $('div#img-edit-title-dialog').dialog({
    autoOpen: false,
    resizable: false,
    modal: true,
    width: 'auto'
});


var galleryFmDialog = $('div#gallery_fm_dialog').dialog({
    autoOpen: false,
    resizable: false,
    modal: true,
    width: '900',
    height: '600',
	closeOnEscape: false,
	close: function () {
		$('#elfinder').elfinder('destroy');
	}
});




/*####  Functions ####*/

function AddImageToGallery(imgSrc) {
//    var imgFileNameRgx = /(.*)(\/.*)/;
    var imgFileNameRgx = /(.*)(gallery)(\/.*)/;
    var match = imgSrc.match(imgFileNameRgx);
    var thumbSrc = match[1] + 'small' + match[3];

    //add DOM elements
    var newImgCont = $('<div class="img-cont" style="float: left;"></div>');
    $('<a href="javascript:void(0);" class="pic-number">' + numOfPicsInGallery + '</a>').appendTo(newImgCont);
    var newImg = $('<a class="img-link" href="' + imgSrc + '"></a>').appendTo(newImgCont);
    $('<img src="' + thumbSrc + '" class="gall-thumb" />').appendTo(newImg);
    $('<input type="hidden" class="break-after" value="false" />').appendTo(newImg);

    //add buttons
    $('<button id="edit-title" class="edit-title"></button>').appendTo(newImg);
//    $('<button class="break-new-line"></button>').appendTo(newImg);
    $('<button class="delete-pic"></button>').appendTo(newImg);


    //add new image container to gallery preview
    newImgCont.appendTo(gallPreview);

    //add new pic position to "move pic" dialog
    var newSelectOption = $('<option value="' + numOfPicsInGallery + '">' + numOfPicsInGallery + '</option>');
    $('div#img-pos-dialog').find('select#new-idx').append(newSelectOption);


    numOfPicsInGallery++;
}





function AddMultipleImages(filesStr, delimiter) {
    var filesArr = filesStr.split(delimiter);

    for (var i = 0; i < filesArr.length - 1; i++) {
        AddImageToGallery(filesArr[i]);
    }

    BindActionsToNewDoms();
    HandlePicsPerRow($('input#num-per-row-spinner').val());
}





function HandlePicsPerRow(num) {
    var numPerRow = parseInt(num);
    var counter = 0;
    var breakBefore = false;

    var galleryDivsArr = $('div#gallery-preview').find('div.img-cont');

    galleryDivsArr.each(function (key, val) {
        if (breakBefore === false) {
            $(this).css('clear', '');
            $(this).css('float', 'left');
        }

        if (counter === numPerRow) {
            $(this).css('clear', 'both');
            counter = 0;
        }

        if ($(this).find('input.break-after').val() === "true") {
            galleryDivsArr.eq(key + 1).css('clear', 'both');
            breakBefore = true;
            counter = 0;
            return true;
        } else {
            breakBefore = false;
        }

        counter++;
    });
}



function RenumberPicsContainers() {
    var counter = 1;

    $('div#gallery-preview').find('div.img-cont').each(function () {
        $(this).find('a.pic-number').html(counter.toString());
        counter++;
    });
}



function RemoveOptionFromSelectPos(opNumber) {
    opNumber = opNumber.toString();

    $('div#img-pos-dialog').find('select#new-idx option').each(function () {
        if ($(this).val() === opNumber) {
            $(this).remove();
            return false;
        }
    });
}



function BindActionsToNewDoms() {
    //add buttons
    $('button.edit-title').button({
        icons: { primary: "ui-icon-pencil" },
        text: false
    });

    $('button.break-new-line').button({
        icons: { primary: "ui-icon ui-icon-arrowreturnthick-1-s" },
        text: false
    });

    $('button.delete-pic').button({
        icons: { primary: "ui-icon-close" },
        text: false
    });

    //show buttons on hover
    $('a.img-link').hover(function () {
        $(this).find('button').fadeIn(50);
    }, function () {
        $(this).find('button').each(function () {
            if ($(this).hasClass('break-new-line')) {
                var currState = $(this).parents('div.img-cont').find('input.break-after');

                if (currState.val() === "true") {
                    return;
                }
            }

            $(this).fadeOut(50);
        });
    });


    //init tooltips for titles
    gallPreview.tooltip({
        items: "a",
        position: { my: "center top-0.1" }
    });

    //Prevent image links on gallery preview
    $('a.img-link').click(function () {
        //e.stopPropagation();
        //e.preventDefault();
        return false;
    });


    //pic position link to change position
    $('a.pic-number').click(function () {
        $('div#img-pos-dialog').find('input#prev-idx').val($(this).text());
        newPicPosition.dialog("open");
    });

    //Break after click
    $('button.break-new-line').unbind("click");
    $('button.break-new-line').click(function () {
        var currState = $(this).parents('div.img-cont').find('input.break-after');

        if (currState.val() === "true") {
            currState.val("false");
            //$(this).show();
        } else {
            currState.val("true");
            //$(this).hide();
        }

        HandlePicsPerRow($('input#num-per-row-spinner').val());
    });

    //Handle Break after already clicked - show
    $('button.break-new-line').each(function () {
        var currState = $(this).parents('div.img-cont').find('input.break-after');

        if (currState.val() === "true") {
            $(this).show();
        } else {
            $(this).hide();
        }
    });

    //edit title dialog
    $('button.edit-title').click(function () {
        var currId = $(this).parents('div.img-cont').find('a.pic-number').text();
        var currTitle = $(this).parents('div.img-cont').find('a.img-link').attr('custom-name');
        //var currTitle = $(".ui-tooltip-content").html();

        $('div#img-edit-title-dialog').find('input#img-title').val(currTitle);
        $('div#img-edit-title-dialog').find('input#curr-idx').val(currId);

        EditPicTitle.dialog("open");
    });


    //delete pic button
    $('button.delete-pic').click(function () {
        $('a.img-link').click(function () { return false; });

        $(this).parents('div.img-cont').fadeOut(function () {
			$(this).remove();
			RenumberPicsContainers();
			HandlePicsPerRow($('input#num-per-row-spinner').val());
			RemoveOptionFromSelectPos(numOfPicsInGallery - 1);
			numOfPicsInGallery--;

			return false;
		});
    });
}




function ChangePicPosition(prevId, newId) {
    prevId = parseInt(prevId);
    newId = parseInt(newId);

    var movingFwd = (prevId < newId) ? true : false;
    var counter = 1;
    var prevCont;


    $('div#gallery-preview').find('div.img-cont').each(function () {
        if (counter === prevId) {
            prevCont = $(this);
            $(this).remove();
            return false;
        }

        counter++;
    });


    counter = 1;
    $('div#gallery-preview').find('div.img-cont').each(function () {
        if (movingFwd) {
            if (counter === newId - 1) {
                $(this).after(prevCont);
                return false;
            }
        } else {
            if (counter === newId) {
                $(this).before(prevCont);
                return false;
            }
        }

        counter++;
    });


    RenumberPicsContainers();
    HandlePicsPerRow($('input#num-per-row-spinner').val());
    BindActionsToNewDoms();
}



function HandleNumOfPicsForExistGallery() {
    gallPreview.find('div.img-cont').each(function () {
        //add new pic position to "move pic" dialog
        var newSelectOption = $('<option value="' + numOfPicsInGallery + '">' + numOfPicsInGallery + '</option>');
        $('div#img-pos-dialog').find('select#new-idx').append(newSelectOption);

        numOfPicsInGallery++;
    });
}






/*####  PAGE LOAD ####*/
$(function () {

    BindActionsToNewDoms();
    HandleNumOfPicsForExistGallery();

    /*####  JqueryUI Buttons ####*/
    $('#add-pic').button();
	$('#change-pic-title-ok').button();
	$('#change-pic-title-cancel').button();
    //$('input#add-pic-submit').button();
    //$('input#cancel-add-pic').button();

//    $("button#zoom-down").button({
//        icons: { primary: "ui-icon-minus" },
//        text: false
//    });
//
//    $("button#zoom-up").button({
//        icons: { primary: "ui-icon-plus" },
//        text: false
//    });
//
//
//    /*####  JqueryUI Spinner ####*/
//    $('input#num-per-row-spinner').spinner({
//        min: 1,
//        max: 10,
//        spin: function (event, ui) {
//            HandlePicsPerRow(ui.value);
//        }
//    });



    /*####  Zoom buttons actions ####*/
    $('button#zoom-up').click(function () {
        $('div#gallery-preview').find('img.gall-thumb').each(function () {
            var thumbH = $(this).height();
            thumbH = thumbH + 10;

            $(this).css('height', thumbH + 'px');
        });
    });

    $('button#zoom-down').click(function () {
        $('div#gallery-preview').find('img.gall-thumb').each(function () {
            var thumbH = $(this).height();
            thumbH = thumbH - 10;

            $(this).css('height', thumbH + 'px');
        });
    });



    /*####  Change pic title OK click ####*/
    $('#change-pic-title-ok').click(function () {
        var currPicIdx = parseInt($(this).siblings('input#curr-idx').val());
        var newTitle = $(this).siblings('input#img-title').val();
        var counter = 1;

        $('div#gallery-preview').find('div.img-cont').each(function () {
            if (counter === currPicIdx) {
                $(this).find('a.img-link').attr('title', newTitle);
                $(this).find('a.img-link').attr('custom-name', newTitle);
                EditPicTitle.dialog("close");
            }

            counter++;
        });
    });


    /*####  Change pic title Cancel click ####*/
    $('#change-pic-title-cancel').click(function () {
        EditPicTitle.dialog("close");
    });



    /*####  Change pic position select ####*/
    $('select#new-idx').change(function () {
        var prevIdx = $('div#img-pos-dialog').find('input#prev-idx').val();

        if (prevIdx !== $(this).val()) {
            ChangePicPosition(prevIdx, $(this).val());
            $(this).val("");
            newPicPosition.dialog("close");
        }
    });



    /*####  Add pictures button click ####*/
    $('#add-pic').click(function () {
		$("#page-content").animate({ scrollTop: 9999 }, "fast");

		ThumbMaker.elfinderParams.height = '560';
		ThumbMaker.elfinderParams.width = 'auto';

		ThumbMaker.elfinderParams.commandsOptions = {
			getfile: {
				multiple: true
			}
		};

		ThumbMaker.elfinderParams.getFileCallback = function (files) {
			var filesStr = '';
			for (var i = 0; i < files.length; i++) {
				filesStr += files[i].url + ';';
			}

			AddMultipleImages(filesStr, ';');
		};

		$('#elfinder').elfinder(ThumbMaker.elfinderParams);

		galleryFmDialog.dialog("open");

    });

});