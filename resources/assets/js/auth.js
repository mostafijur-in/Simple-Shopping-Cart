"use strict";

/** ------------------------------------------------------------
 * Login Form Submit
 * ---------------------------------------------------------- */
 if (!window.loginSubmit) {
    window.loginSubmit = function () {
        var formEl  = $("#login_form");

        formEl.find(".form-control").each(function(){
            $(this).removeClass('input-error');
        });
        formEl.find(".input-status-msg").each(function(){
            $(this).html('');
        });

        var FrmData = new FormData(formEl[0]);
        FrmData.append("_token", window.csrf_token());

        $.ajax({
            url: appUrl + "/login",
            data: FrmData,
            type: 'POST',
            processData: false,
            contentType: false,
            beforeSend: function (xhr) {
                window.loadingScreen("show");
                $("#login_form_status").html("");
            },
            complete: function (xhr, status) {
                if ((xhr.status != 200)) {
                    window.loadingScreen("hide");
                    console.log('Error: ' + xhr.responseJSON.message);
                }
            },
            success: function (rData) {
                window.loadingScreen("hide");

                let rObj = JSON.parse(rData);
                if(rObj.status == "success") {
                    $("#login_form_status").html('<p class="msg msg-success msg-full">'+rObj.message+'</p>');

                    window.location.href = rObj.redirect;
                } else {
                    $("#login_form_status").html('<p class="msg msg-danger msg-full">'+rObj.message+'</p>');
                    $.each(rObj.errors, function (i, msg) {
                        $('#'+i).addClass('input-error');
                        $('#'+i+'_msg').html('<span class="is-error">'+msg+'</span>');
                    });
                }
            }
        });
    }
}

/** ------------------------------------------------------------
 * Registration Form Submit
 * ---------------------------------------------------------- */
 if (!window.registerSubmit) {
    window.registerSubmit = function () {
        var formEl  = $("#register_form");

        formEl.find(".form-control").each(function(){
            $(this).removeClass('input-error');
        });
        formEl.find(".input-status-msg").each(function(){
            $(this).html('');
        });

        var FrmData = new FormData(formEl[0]);
        FrmData.append("_token", window.csrf_token());

        $.ajax({
            url: appUrl + "/register",
            data: FrmData,
            type: 'POST',
            processData: false,
            contentType: false,
            beforeSend: function (xhr) {
                window.loadingScreen("show");
                $("#register_form_status").html("");
            },
            complete: function (xhr, status) {
                if ((xhr.status != 200)) {
                    window.loadingScreen("hide");
                    console.log('Error: ' + xhr.responseJSON.message);
                }
            },
            success: function (rData) {
                window.loadingScreen("hide");

                let rObj = JSON.parse(rData);
                if(rObj.status == "success") {
                    formEl[0].reset();
                    $("#register_form_status").html('<p class="msg msg-success msg-full">'+rObj.message+'</p>');

                    // window.location.href = rObj.redirect;
                } else {
                    $("#register_form_status").html('<p class="msg msg-danger msg-full">'+rObj.message+'</p>');
                    $.each(rObj.errors, function (i, msg) {
                        $('#'+i).addClass('input-error');
                        $('#'+i+'_msg').html('<span class="is-error">'+msg+'</span>');
                    });
                }
            }
        });
    }
}

/** ------------------------------------------------------------
 * Logged in user Get change Password form
 * ---------------------------------------------------------- */
 if (!window.get_changePassword) {
    window.get_changePassword = function () {
        $.ajax({
            url: appUrl + "/auth-ajax",
            data: {
                requestName: "get_changePassword"
            },
            type: 'POST',
            beforeSend: function (xhr) {
                //
            },
            success: function (rData) {
                $("#defaultModalContent").html(rData);
                $("#defaultModal").modal("show");
            }
        });
    }
}


/** ------------------------------------------------------------
 * Get Transactions Receive Edit Modal
 * ---------------------------------------------------------- */
 if (!window.changePassword_submit) {
    window.changePassword_submit = function () {
        var formEl  = $("#user_change_password_form");

        formEl.find(".form-control").each(function(){
            $(this).removeClass('input-error');
        });
        formEl.find(".input-status-msg").each(function(){
            $(this).html('');
        });

        var FrmData = new FormData(formEl[0]);
        FrmData.append("requestName", "changePassword_submit");

        $.ajax({
            url: appUrl + "/auth-ajax",
            data: FrmData,
            type: 'POST',
            processData: false,
            contentType: false,
            beforeSend: function (xhr) {
                $("#change_password_status").html('');
            },
            success: function (rData) {

                let rObj = JSON.parse(rData);
                if(rObj.status == "success") {

                    formEl[0].reset();
                    $("#change_password_status").html('<p class="msg msg-success msg-full">'+rObj.message+'</p>');

                    setTimeout(function(){
                        window.location.reload();
                    }, 1000);
                } else {
                    if(rObj.message) {
                        $("#change_password_status").html('<p class="msg msg-danger msg-full">'+rObj.message+'</p>');
                    }
                    $.each(rObj.errors, function (i, msg) {
                        $('#'+i).addClass('input-error');
                        $('#'+i+'_msg').html('<span class="is-error">'+msg+'</span>');
                    });
                }
            }
        });
    }
}

