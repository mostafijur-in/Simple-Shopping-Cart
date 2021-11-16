"use strict";

(function ($) {
    /** ------------------------------------------------------------------------------
     * Window loading screen
     * ---------------------------------------------------------------------------- */
    if (!window.loadingScreen) {
        window.loadingScreen = function (Action) {
            if (Action == "show") {
                $("body").addClass("ajax-processing");
            }
            if (Action == "hide") {
                $("body").removeClass("ajax-processing");
            }
        };
    }

    /**
     * Add product to cart
     */
    $(document).on("click", "#addToCartBtn", function(){
        var productId   = $(this).attr("data-product-id");

        var statusDiv   = $("#addToCartStatus");
        $.ajax({
            url: appUrl +'/cart/add',
            data: {
                product_id: productId
            },
            type: "POST",
            // processData: false,
            // contentType: false,
            beforeSend: function (xhr) {
                window.loadingScreen("show");
                statusDiv.html("");
            },
            success: function (rData) {
                window.loadingScreen("hide");
                let rObj = JSON.parse(rData);

                if (rObj.status == "success") {
                    $("#nav-item-cart").load(
                        location.href + " #nav-item-cart>*"
                    );
                } else {
                    statusDiv.html('<div class="msg msg-danger msg-full">'+rObj.message+'</div>');
                }
            }
        });
    });

    /**
     * Add product to cart
     */
    $(document).on("click", "#checkoutBtn", function(){

        var statusDiv   = $("#addToCartStatus");
        $.ajax({
            url: appUrl +'/cart/add',
            data: {
                product_id: productId
            },
            type: "POST",
            // processData: false,
            // contentType: false,
            beforeSend: function (xhr) {
                window.loadingScreen("show");
                statusDiv.html("");
            },
            success: function (rData) {
                window.loadingScreen("hide");
                let rObj = JSON.parse(rData);

                if (rObj.status == "success") {
                    $("#nav-item-cart").load(
                        location.href + " #nav-item-cart>*"
                    );
                } else {
                    statusDiv.html('<div class="msg msg-danger msg-full">'+rObj.message+'</div>');
                }
            }
        });
    });
})(jQuery);
