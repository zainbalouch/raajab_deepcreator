var WISHLIST = WISHLIST || {};
(function ($) {
    "use strict";

    WISHLIST = {
        init: function () {
            var wishlist_save = felan_template_vars.wishlist_save,
                wishlist_saved = felan_template_vars.wishlist_saved,
                ajax_url = felan_template_vars.ajax_url;

            $("body").on("click", ".felan-project-wishlist", function (e) {
                e.preventDefault();
                if (!$(this).hasClass("on-handle")) {
                    var $this = $(this).addClass("on-handle"),
                        project_id = $this.attr("data-project-id"),
                        save = "";

                    $.ajax({
                        type: "post",
                        url: ajax_url,
                        dataType: "json",
                        data: {
                            action: "felan_project_wishlist",
                            project_id: project_id,
                        },
                        beforeSend: function () {
                            $this
                                .find(".icon-heart")
                                .html('<span class="felan-dual-ring"></span>');
                        },
                        success: function (data) {
                            if (data.added) {
                                save = wishlist_saved;
                                $this.removeClass("removed").addClass("added");
                                $this
                                    .parents(".felan-project-item")
                                    .removeClass("removed-wishlist");
                            } else {
                                save = wishlist_save;
                                $this.removeClass("added").addClass("removed");
                                $this
                                    .parents(".felan-project-item")
                                    .addClass("removed-wishlist");
                            }

                            $this.children("i").removeClass("fa-spinner fa-spin");
                            if (typeof data.added == "undefined") {
                                console.log("login?");
                            }
                            $this.removeClass("on-handle");
                            $this.html(
                                '<span class="icon-heart"><i class="fas fa-heart"></i></span>'
                            );
                        },
                        error: function (xhr) {
                            var err = eval("(" + xhr.responseText + ")");
                            console.log(err.Message);
                            $this.children("i").removeClass("fa-spinner fa-spin");
                            $this.removeClass("on-handle");
                        },
                    });
                }
            });
        },
    };
    $(document).ready(function () {
        WISHLIST.init();
    });
})(jQuery);
