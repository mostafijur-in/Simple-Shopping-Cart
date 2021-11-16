"use strict";

(function ($) {
    /**
     * Add product submit
     */
    $(document).on("submit", "#add_product_form", function(e){
        e.preventDefault();

        var formEL = $(this);
        var statusDiv = $('#add_product_status');

        formEL.find('.form-control').each(function() {
            $(this).removeClass("input-error");
        });
        formEL.find('.input-status-msg').each(function() {
            $(this).html("");
        });

        var isValid = true;
        var firstError = "";
        var count = 0;

        formEL.find(".reqField").each(function() {
            if ($(this).val().trim() == "") {
                $(this).addClass("is-invalid");

                isValid = false;
                // return isValid;
                if (count == 0) {
                    firstError = $(this);
                }
            } else {
                $(this).removeClass("is-invalid");
            }

            count++;
        });

        if (isValid == true) {
            var FrmData = new FormData(formEL[0]);
            var action  = formEL.attr("action");

            $.ajax({
                url: action,
                data: FrmData,
                type: 'POST',
                processData: false,
                contentType: false,
                beforeSend: function(xhr) {
                    statusDiv.html("<p class='info-msg'>Processing, please wait...</p>");
                    window.loadingScreen("show");
                },
                complete: function(xhr, status) {
                    window.loadingScreen("hide");
                    if (xhr.status == 422) {
                        statusDiv.html('<div class="msg msg-danger msg-full">' + xhr.responseJSON.message + '</div>');

                        $.each(xhr.responseJSON.errors, function (i, msg) {
                            $('#' + i).addClass('input-error');
                            $('#' + i + '_msg').html('<span class="is-error">' + msg + '</span>');
                        });
                    } else if ((xhr.status != 200)) {
                        console.log(xhr);
                        console.log('Failed ajax request, Error: ' + xhr.responseJSON.message);
                    }
                },
                success: function(rData) {
                    window.loadingScreen("hide");

                    let rObj = JSON.parse(rData);
                    if (rObj.status == "success") {
                        formEL[0].reset();
                        statusDiv.html('<div class="msg msg-success msg-full">' + rObj.message + '</div>');
                    } else {
                        statusDiv.html('<div class="msg msg-danger msg-full">' + rObj.message + '</div>');
                    }
                }
            });
        } else {
            firstError.focus();
            statusDiv.html("<p class='msg msg-danger msg-full'>Fill all the required fields</p>");
        }
    });

    /**
     * Edit product submit
     */
    $(document).on("submit", "#edit_product_form", function(e){
        e.preventDefault();

        var formEL = $(this);
        var statusDiv = $('#edit_product_status');

        formEL.find('.form-control').each(function() {
            $(this).removeClass("input-error");
        });
        formEL.find('.input-status-msg').each(function() {
            $(this).html("");
        });

        var isValid = true;
        var firstError = "";
        var count = 0;

        formEL.find(".reqField").each(function() {
            if ($(this).val().trim() == "") {
                $(this).addClass("is-invalid");

                isValid = false;
                // return isValid;
                if (count == 0) {
                    firstError = $(this);
                }
            } else {
                $(this).removeClass("is-invalid");
            }

            count++;
        });

        if (isValid == true) {
            var FrmData = new FormData(formEL[0]);
            var action  = formEL.attr("action");

            $.ajax({
                url: action,
                data: FrmData,
                type: 'POST',
                processData: false,
                contentType: false,
                beforeSend: function(xhr) {
                    statusDiv.html("<p class='info-msg'>Processing, please wait...</p>");
                    window.loadingScreen("show");
                },
                complete: function(xhr, status) {
                    window.loadingScreen("hide");
                    if (xhr.status == 422) {
                        statusDiv.html('<div class="msg msg-danger msg-full">' + xhr.responseJSON.message + '</div>');

                        $.each(xhr.responseJSON.errors, function (i, msg) {
                            $('#' + i).addClass('input-error');
                            $('#' + i + '_msg').html('<span class="is-error">' + msg + '</span>');
                        });
                    } else if ((xhr.status != 200)) {
                        console.log(xhr);
                        console.log('Failed ajax request, Error: ' + xhr.responseJSON.message);
                    }
                },
                success: function(rData) {

                    let rObj = JSON.parse(rData);
                    if (rObj.status == "success") {
                        statusDiv.html('<div class="msg msg-success msg-full">' + rObj.message + '</div>');
                        setTimeout(function(){
                            window.location.href = rObj.redirect;
                        }, 500);
                    } else {

                        window.loadingScreen("hide");
                        statusDiv.html('<div class="msg msg-danger msg-full">' + rObj.message + '</div>');
                    }
                }
            });
        } else {
            firstError.focus();
            statusDiv.html("<p class='msg msg-danger msg-full'>Fill all the required fields</p>");
        }
    });
})(jQuery);
