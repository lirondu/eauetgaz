$(function (){
    /**************************************************************************/
    /* META DATA UPDATE
     /**************************************************************************/


    /*##### POST FORM VALIDATION #####*/
    $('form.meta-editor').validate({
        onfocusout: true,
        focusInvalid: false,
        errorElement: "span",
        errorPlacement: function (error, element) {
            $(element).parent().append(error);
        },
        rules: {
            meta_title: {
                required: true,
                minlength: 2
            },
            meta_description: {
                required: true,
                minlength: 5
            },
            meta_keywords: {
                required: true,
                minlength: 5
            }
        }
    });



    $('form.meta-editor').submit(function () {
        if (!$('form.meta-editor').validate().form()) {
            return;
        }

        var data = $(this).serialize();
        data += '&mod_data=meta-update';

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
});