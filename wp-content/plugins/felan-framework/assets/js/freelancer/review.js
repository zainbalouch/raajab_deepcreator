var FREELANCER_REVIEW = FREELANCER_REVIEW || {};

(function ($) {
  "use strict";

  FREELANCER_REVIEW = {
    init: function () {
      FREELANCER_REVIEW.submit_review();
    },

    submit_review: function () {
      var ajax_url = felan_freelancer_review_vars.ajax_url;
      var freelancer_review = $(".freelancer-review-details");

      freelancer_review.find("input:file").change(function () {
        $(".fileList span").remove();
        for (var i = 0; i < this.files.length; i++) {
          var fileName = this.files[i].name;
          $(".fileList").append("<span>" + fileName + "</span>");
        }
      });

      freelancer_review.find(".entry-nav .reply").on("click", function (e) {
        e.preventDefault();
        $(".author-review").removeClass("active");
        $(".author-review .form-reply").html("");
        var $this = $(this);
        var form_reply = $(".duplicate-form-reply").html();
        var comment_id = $this
          .parents(".author-review")
          .find(".form-reply")
          .data("id");
        $(".add-new-review").hide();
        $this.parents(".author-review").addClass("active");
        $this.parents(".author-review").find(".form-reply").html(form_reply);
        $this
          .parents(".author-review")
          .find('.form-reply input[name="comment_id"]')
          .val(comment_id);
      });

      $("body").on(
        "click",
        ".form-reply .felan-submit-freelancer-reply",
        function (e) {
          e.preventDefault();
          var $this = $(this);
          var $form = $this.parents("form");
          var message = $form.find("textarea").val();
          if (message == "") {
            $form.find("#message-error").fadeIn();
          } else {
            $form.find("#message-error").fadeOut();

            $.ajax({
              type: "POST",
              url: ajax_url,
              data: $form.serialize(),
              dataType: "json",
              beforeSend: function () {
                $this.attr("disabled", true);
                $this.children("i").remove();
                $this.append(
                  '<i class="fa-left fal fa-spinner fa-spin large"></i>'
                );
              },
              success: function () {
                window.location.reload();
              },
              complete: function () {
                $this.children("i").removeClass("fal fa-spinner fa-spin large");
                $this.children("i").addClass("fa fa-check");
              },
            });
          }
        }
      );

      $("body").on("click", ".cancel-reply", function (e) {
        e.preventDefault();
        freelancer_review.find(".author-review").removeClass("active");
        freelancer_review.find(".author-review .form-reply").html("");
        freelancer_review.find(".add-new-review").show();
      });

      $.validator.setDefaults({
        debug: true,
        success: "valid",
      });

      $(".reviewForm").validate({
        rules: {
          message: {
            required: true,
          },
        },
        messages: {
          message: {
            required: "This field is required",
          },
        },
        errorPlacement: function (error, element) {
          if (element.is(":radio")) {
            error.appendTo(element.parents("fieldset"));
          } else {
            // This is the default behavior
            error.insertAfter(element);
          }
        },
        submitHandler: function (form) {
          var $this = $(".reviewForm").find("#btn-submit-review");
          var $form = $(".reviewForm");

          var formdata = false;
          if (window.FormData) {
            formdata = new FormData($form[0]);
          }

          $.ajax({
            type: "POST",
            url: ajax_url,
            data: formdata ? formdata : $form.serialize(),
            enctype: "multipart/form-data",
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function () {
              $this.children("i").remove();
              $this.append(
                '<i class="fa-left fal fa-spinner fa-spin large"></i>'
              );
            },
            success: function (data) {
              window.location.reload();
            },
            complete: function () {
              $this.children("i").removeClass("fal fa-spinner fa-spin large");
              $this.children("i").addClass("fa fa-check");
            },
          });
        },
      });
    },
  };

  $(document).ready(FREELANCER_REVIEW.init());
})(jQuery);
