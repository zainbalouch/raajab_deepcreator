var SERVICE = SERVICE || {};
(function ($) {
    "use strict";

    SERVICE = {
        init: function () {
            this.submit_addons();
            this.scrollTop_package();
        },

        submit_addons: function () {
            var ajax_url = felan_template_vars.ajax_url,
                payment_url = felan_addons_vars.payment_url;

            $("body").on("click", ".btn-submit-addons", function (e) {
                var $this = $(this),
                    packageWarrper = $this.closest(".service-package-submit"),
                    service_package_price = $this.data("price"),
                    service_package_des = $this.data("des"),
                    service_package_time = $this.data("time"),
                    service_package_time_type = $this.data("time-type"),
                    service_id = packageWarrper.find('input[name="service_id').val(),
                    service_package_new =  packageWarrper.find('input[name="service_package_new').val();

                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: ajax_url,
                    dataType: "json",
                    data: {
                        action: "felan_service_package",
                        service_id: service_id,
                        service_package_price: service_package_price,
                        service_package_des: service_package_des,
                        service_package_time: service_package_time,
                        service_package_time_type: service_package_time_type,
                        service_package_new: service_package_new,
                    },
                    beforeSend: function () {
                        $this.find(".btn-loading").fadeIn();
                    },
                    success: function (data) {
                        if (data.success == true) {
                            window.location.href = payment_url;
                        }
                        $this.find(".btn-loading").fadeOut();
                    },
                });
            });
        },

        scrollTop_package: function () {
            $(document).on("click", "a.compare-packages", function (e) {
                e.preventDefault();

                $('html, body').animate({
                    scrollTop: $($(this).attr('href')).offset().top
                }, 1000);
            });
        },
    };
    $(document).ready(function () {
        SERVICE.init();
    });
})(jQuery);
