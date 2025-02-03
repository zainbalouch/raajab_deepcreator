(function ($) {
  "use strict";
  var body = $("body.felan-ltw"),
    popupForm = body.find("#popup-form"),
    loginToView = felan_template_vars.login_to_view;

  $(document).ready(function () {
    popupForm.addClass("open");
    popupForm.find(".btn-close").remove();
    popupForm
      .find(".notice")
      .html('<i class="fal fa-exclamation-circle"></i>' + loginToView);

    body.on("click", ".bg-overlay", function () {
      $(this).parents("#popup-form").addClass("open");
      return false;
    });
  });
})(jQuery);
