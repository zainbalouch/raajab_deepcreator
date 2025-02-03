(function ($) {
  "use strict";
  var ajax_url = felan_custom_image_vars.ajax_url,
    custom_image_title = felan_custom_image_vars.custom_image_title,
    custom_image_type = felan_custom_image_vars.custom_image_type,
    custom_image_file_size = felan_custom_image_vars.custom_image_file_size,
    custom_image_text = felan_custom_image_vars.custom_image_text,
    custom_image_upload_nonce =
      felan_custom_image_vars.custom_image_upload_nonce;

  jQuery(document).ready(function () {
    var custom_image = $(".felan-fields-custom_image");
    $.each(custom_image, function () {
      var custom_image_id = $(this).find("input.image-id").val();
      var felan_custom_image = function () {
        var uploader_custom_image = new plupload.Uploader({
          browse_button: "felan_select_custom_image_" + custom_image_id,
          file_data_name: "felan_custom_image_upload_file_" + custom_image_id,
          drop_element: "felan_custom_image_view_" + custom_image_id,
          container: "felan_custom_image_container_" + custom_image_id,
          url:
            ajax_url +
            "?action=felan_custom_image_upload_ajax&nonce=" +
            custom_image_upload_nonce +
            "&custom_image_id=" +
            custom_image_id,
          filters: {
            mime_types: [
              {
                title: custom_image_title,
                extensions: custom_image_type,
              },
            ],
            max_file_size: custom_image_file_size,
            prevent_duplicates: true,
          },
        });
        uploader_custom_image.init();

        uploader_custom_image.bind("UploadProgress", function (up, file) {
          document.getElementById(
            "felan_select_custom_image_" + custom_image_id
          ).innerHTML =
            '<span><i class="fal fa-spinner fa-spin large"></i></span>';
        });

        uploader_custom_image.bind("FilesAdded", function (up, files) {
          up.refresh();
          uploader_custom_image.start();
        });
        uploader_custom_image.bind("Error", function (up, err) {
          document.getElementById(
            "felan_custom_image_errors_" + custom_image_id
          ).innerHTML += "Error #" + err.code + ": " + err.message + "<br/>";
        });

        var $image_id = $("#custom_image_id_" + custom_image_id).val();
        var $image_url = $("#custom_image_url_" + custom_image_id).val();
        if ($image_id && $image_url) {
          var $html =
            '<figure class="media-thumb media-thumb-wrap">' +
            '<img src="' +
            $image_url +
            '">' +
            '<div class="media-item-actions">' +
            '<a class="icon icon-custom_image-delete_' +
            custom_image_id +
            '" data-attachment-id="' +
            $image_id +
            '" href="#" ><i class="far fa-trash-alt large"></i></a>' +
            '<span style="display: none;" class="icon icon-loader"><i class="fal fa-spinner fa-spin large"></i></span>' +
            "</div>" +
            "</figure>";
          $("#felan_custom_image_view_" + custom_image_id).html($html);
          $("#felan_add_custom_image_" + custom_image_id).hide();
        }

        uploader_custom_image.bind(
          "FileUploaded",
          function (up, file, ajax_response) {
            document.getElementById(
              "felan_drop_custom_image_" + custom_image_id
            ).style.display = "none";
            var response = $.parseJSON(ajax_response.response);
            if (response.success) {
              $("#custom_image_url_" + custom_image_id).val(
                response.full_image
              );
              $("#custom_image_id_" + custom_image_id).val(
                response.attachment_id
              );
              var $html =
                '<figure class="media-thumb media-thumb-wrap">' +
                '<img src="' +
                response.full_image +
                '">' +
                '<div class="media-item-actions">' +
                '<a class="icon icon-custom_image-delete_' +
                custom_image_id +
                '" data-attachment-id="' +
                response.attachment_id +
                '" href="#" ><i class="far fa-trash-alt large"></i></a>' +
                '<span style="display: none;" class="icon icon-loader"><i class="fal fa-spinner fa-spin large"></i></span>' +
                "</div>" +
                "</figure>";
              $("#felan_custom_image_view_" + custom_image_id).html($html);
              felan_thumbnai_delete();
              $("#custom_image_url-error_" + custom_image_id).hide();
            }
          }
        );
      };
      felan_custom_image();

      var felan_thumbnai_delete = function ($type) {
        $("body").on(
          "click",
          ".icon-custom_image-delete_" + custom_image_id,
          function (e) {
            e.preventDefault();
            var $this = $(this),
              icon_delete = $this,
              custom_image = $this
                .closest("#felan_custom_image_view_" + custom_image_id)
                .find(".media-thumb-wrap"),
              attachment_id = $this.data("attachment-id"),
              $drop = $("#felan_drop_custom_image_" + custom_image_id);

            icon_delete.html('<i class="fal fa-spinner fa-spin large"></i>');

            $.ajax({
              type: "post",
              url: ajax_url,
              dataType: "json",
              data: {
                action: "felan_custom_image_remove_ajax",
                attachment_id: attachment_id,
                type: $type,
                removeNonce: custom_image_upload_nonce,
              },
              success: function (response) {
                if (response.success) {
                  custom_image.remove();
                  custom_image.hide();

                  $("#custom_image_url-error_" + custom_image_id).show();
                  $("#felan_add_custom_image_" + custom_image_id).show();
                }
                icon_delete.html(
                  '<i class="fal fa-spinner fa-spin large"></i>'
                );
                $drop.css("display", "block");
                $("#felan_select_custom_image_" + custom_image_id).html(
                  custom_image_text
                );
                $("input.custom_image_url_" + custom_image_id).val("");
                $("input.custom_image_id_" + custom_image_id).val("");
              },
              error: function () {
                icon_delete.html('<i class="far fa-trash-alt large"></i>');
              },
            });
          }
        );
      };
      felan_thumbnai_delete();
    });
  });
})(jQuery);
