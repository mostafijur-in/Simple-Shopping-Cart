"use strict";

(function ($) {
    /** ------------------------------------------------------------
     * csrf_token
     * ---------------------------------------------------------- */
    if (!window.csrf_token) {
        //  X-CSRF-TOKEN
        window.csrf_token = function() {
            return $('meta[name="csrf-token"]').attr('content');
        }
    }
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

    /** ------------------------------------------------------------
     * User logout
     * ---------------------------------------------------------- */
    if (!window.userLogout) {
        window.userLogout = function () {
            $.ajax({
                url: appUrl + "/logout",
                data: {
                    _token: window.csrf_token()
                },
                type: 'POST',
                beforeSend: function (xhr) {
                    //
                },
                success: function (rData) {
                    if (rData == "success") {
                        window.location.href = appUrl;
                    } else {
                        console.log(rData);
                    }
                }
            });
        }
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
                    statusDiv.html(rObj.message);

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
     * Update quantity in cart
     */
    $(document).on("change", ".update-cart", function (e) {
        e.preventDefault();

        var ele = $(this);

        $.ajax({
            url: appUrl+"/cart/update",
            method: "patch",
            data: {
                id: ele.parents("tr").attr("data-id"),
                quantity: ele.parents("tr").find(".quantity").val(),
                _token: window.csrf_token(),
            },
            success: function (response) {
               window.location.reload();
            }
        });
    });

    /**
     * Remove product from cart
     */
    $(document).on("click", ".remove-from-cart", function (e) {
        e.preventDefault();

        var ele = $(this);

        if(confirm("Are you sure want to remove?")) {
            $.ajax({
                url: appUrl+"/cart/remove",
                method: "DELETE",
                data: {
                    id: ele.parents("tr").attr("data-id"),
                    _token: window.csrf_token(),
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });
})(jQuery);
