var FOLLOW = FOLLOW || {};
(function ($) {
  "use strict";

  FOLLOW = {
    init: function () {
      var follow_save = felan_template_vars.follow_save,
        follow_saved = felan_template_vars.follow_saved,
        package_expires = felan_template_vars.package_expires,
        ajax_url = felan_template_vars.ajax_url;

      $("body").on("click", ".felan-add-to-follow", function (e) {
        e.preventDefault();
        if (!$(this).hasClass("on-handle")) {
          var $this = $(this).addClass("on-handle"),
            company_inner = $this
              .closest(".company-inner")
              .addClass("company-active-hover"),
            company_id = $this.attr("data-company-id"),
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
              action: "felan_add_to_follow",
              company_id: company_id,
            },
            beforeSend: function () {
              $this
                .find(".icon-plus")
                .html('<span class="felan-dual-ring"></span>');
            },
            success: function (data) {
              if (data.added) {
                $this.removeClass("removed").addClass("added");
                $this
                  .parents(".felan-company-item")
                  .removeClass("removed-follow");
                $this.html(
                  '<span class="icon-plus"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.75 3.5C5.12665 3.5 3 5.75956 3 8.54688C3 14.125 12 20.5 12 20.5C12 20.5 21 14.125 21 8.54688C21 5.09375 18.8734 3.5 16.25 3.5C14.39 3.5 12.7796 4.63593 12 6.2905C11.2204 4.63593 9.61003 3.5 7.75 3.5Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /></svg></span>'
                );
              } else {
                $this.removeClass("added").addClass("removed");
                $this.parents(".felan-company-item").addClass("removed-follow");
                $this.html(
                  '<span class="icon-plus"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.75 3.5C5.12665 3.5 3 5.75956 3 8.54688C3 14.125 12 20.5 12 20.5C12 20.5 21 14.125 21 8.54688C21 5.09375 18.8734 3.5 16.25 3.5C14.39 3.5 12.7796 4.63593 12 6.2905C11.2204 4.63593 9.61003 3.5 7.75 3.5Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /></svg></span>'
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
              company_inner.removeClass("company-active-hover");
            },
            error: function (xhr) {
              var err = eval("(" + xhr.responseText + ")");
              $this.children("i").removeClass("fa-spinner fa-spin");
              $this.removeClass("on-handle");
              company_inner.removeClass("company-active-hover");
            },
          });
        }
      });
    },
  };
  $(document).ready(function () {
    FOLLOW.init();
  });
})(jQuery);
