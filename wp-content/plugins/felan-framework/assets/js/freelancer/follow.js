var FOLLOW_FREELANCER = FOLLOW_FREELANCER || {};
(function ($) {
    "use strict";

    FOLLOW_FREELANCER = {
        init: function () {
            var package_expires = felan_template_vars.package_expires,
                ajax_url = felan_template_vars.ajax_url;

            $("body").on("click", ".felan-add-to-follow-freelancer", function (e) {
                e.preventDefault();
                if (!$(this).hasClass("on-handle")) {
                    var $this = $(this).addClass("on-handle"),
                        freelancer_inner = $this
                            .closest(".freelancer-inner")
                            .addClass("freelancer-active-hover"),
                        freelancer_id = $this.attr("data-freelancer-id"),
                        save = "";

                    if (!$this.hasClass("added")) {
                        var offset = $this.offset(),
                            width = $this.width(),
                            height = $this.height(),
                            coords = {
                                x: offset.left + width / 2,
                                y: offset.top + height / 2,
                            };
                    }

                    $.ajax({
                        type: "post",
                        url: ajax_url,
                        dataType: "json",
                        data: {
                            action: "felan_add_to_follow_freelancer",
                            freelancer_id: freelancer_id,
                        },
                        beforeSend: function () {
                            $this
                                .find(".icon-plus")
                                .html('<span class="felan-dual-ring"></span>');
                        },
                        success: function (data) {
                            console.log(data.added);
                            if (data.added) {
                                $this.removeClass("removed").addClass("added");
                                $this
                                    .parents(".felan-freelancer-item")
                                    .removeClass("removed-follow_freelancer");
                                $this.find('.icon-plus').html(
                                    '<i class="fas fa-heart"></i>'
                                );
                            } else {
                                $this.removeClass("added").addClass("removed");
                                $this
                                    .parents(".felan-freelancer-item")
                                    .addClass("removed-follow_freelancer");
                                $this.find('.icon-plus').html(
                                    '<i class="far fa-heart"></i>'
                                );
                            }
                            if (data.package_expires) {
                                $this.removeClass("added").removeClass("removed");
                                alert(package_expires);
                                window.location.reload();
                            }
                            if (typeof data.added == "undefined") {
                                console.log("login?");
                            }
                            $this.removeClass("on-handle");
                            freelancer_inner.removeClass("freelancer-active-hover");
                        },
                        error: function (xhr) {
                            var err = eval("(" + xhr.responseText + ")");
                            console.log(err.Message);
                            $this.children("i").removeClass("fa-spinner fa-spin");
                            $this.removeClass("on-handle");
                            freelancer_inner.removeClass("freelancer-active-hover");
                        },
                    });
                }
            });
        },
    };
    $(document).ready(function () {
        FOLLOW_FREELANCER.init();
    });
})(jQuery);
