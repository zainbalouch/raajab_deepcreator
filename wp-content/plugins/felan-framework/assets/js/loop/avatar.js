(function ($) {
  "use strict";
  var ajax_url = felan_avatar_vars.ajax_url,
    avatar_title = felan_avatar_vars.avatar_title,
    avatar_type = felan_avatar_vars.avatar_type,
    avatar_file_size = felan_avatar_vars.avatar_file_size,
    avatar_text = felan_avatar_vars.avatar_text,
    avatar_url = felan_avatar_vars.avatar_url,
    avatar_upload_nonce = felan_avatar_vars.avatar_upload_nonce;

  jQuery(document).ready(function () {
    var felan_avatar = function () {
      var uploader_avatar = new plupload.Uploader({
        browse_button: "felan_select_avatar",
        file_data_name: "felan_avatar_upload_file",
        drop_element: "felan_avatar_view",
        container: "felan_avatar_container",
        url: avatar_url,
        filters: {
          mime_types: [
            {
              title: avatar_title,
              extensions: avatar_type,
            },
          ],
          max_file_size: avatar_file_size,
          prevent_duplicates: true,
        },
      });
    
      uploader_avatar.init();
    
      uploader_avatar.bind("UploadProgress", function (up, file) {
        $("#felan_add_avatar .la-upload").hide();
        document.getElementById("felan_select_avatar").innerHTML =
          '<span><i class="fal fa-spinner fa-spin large"></i></span>';
      });
    
      uploader_avatar.bind("FilesAdded", function (up, files) {
        up.refresh();
        uploader_avatar.start();
      });
    
      uploader_avatar.bind("Error", function (up, err) {
        document.getElementById("felan_avatar_errors").innerHTML +=
          "Error #" + err.code + ": " + err.message + "<br/>";
      });

      // if image already uploaded then get and display it
      var $image_id = $("#felan_avatar_view").data("image-id");
      var $image_url = $("#felan_avatar_view").data("image-url");
      if ($image_id && $image_url) {
        var $html =
          '<figure class="media-thumb media-thumb-wrap">' +
          '<img src="' +
          $image_url +
          '">' +
          '<div class="media-item-actions">' +
          '<a class="icon icon-avatar-delete" data-attachment-id="' +
          $image_id +
          '" href="#" ><i class="far fa-trash-alt large"></i></a>' +
          '<span style="display: none;" class="icon icon-loader"><i class="fal fa-spinner fa-spin large"></i></span>' +
          "</div>" +
          "</figure>";
        $("#felan_avatar_view").html($html);
        $("#felan_add_avatar").hide();
      }

      uploader_avatar.bind("FileUploaded", function (up, file, ajax_response) {
        var response = $.parseJSON(ajax_response.response);
        if (response.success) {
          var attachment_id = response.attachment_id;
          $("input.avatar_id").val(attachment_id);
          // showProgressBar();
          // Call your API to get the new image URL
          $.ajax({
            url: "http://localhost/deepcreator/wp-admin/admin-ajax.php", // The WordPress admin-ajax.php URL
            type: "POST",
            dataType: "json",
            data: {
              action: "replace_image", // Your WordPress action hook
              image_url: response.full_image, // Send the current image URL to your API
            },
            success: function (response) {
              if (response.success) {
                var new_image_url = response.data.new_image_url; // Get the new image URL
                $("input.avatar_url").val(new_image_url);
    
                // Update the image and remove the progress indicator
                var $html =
                  '<figure class="media-thumb media-thumb-wrap">' +
                  '<img src="' + new_image_url + '">' +
                  '<div class="media-item-actions">' +
                  '<a class="icon icon-avatar-delete" data-attachment-id="' +
                  attachment_id +
                  '" href="#"><i class="far fa-trash-alt large"></i></a>' +
                  '<span style="display: none;" class="icon icon-loader"><i class="fal fa-spinner fa-spin large"></i></span>' +
                  "</div>" +
                  "</figure>";
    
                $("#felan_avatar_view").html($html);
                felan_avatar_delete();
                $("#felan_add_avatar .la-upload").hide();
                $("#avatar_url-error").hide();
    
                // If the form is for the freelancer profile, trigger change detection
                if ($(".form-dashboard").hasClass("freelancer-profile-form")) {
                  $("#freelancer-profile-form").find(".point-mark").change();
                }
              } else {
                console.error("Failed to replace image:", response.data.message);
                // Hide the progress indicator if the request fails
                // $("#progress-indicator").remove();
              }
              document.getElementById("felan_drop_avatar").style.display = "none";
            },
            error: function (xhr, status, error) {
              console.error("API call failed:", error);
              console.error("Raw response:", xhr.responseText); // Log the raw response
              // Hide the progress indicator in case of an error
              // $("#progress-indicator").remove();
              document.getElementById("felan_drop_avatar").style.display = "none";

            },
          });
        }
    
        //Company avatar
        // var $company_avatar_url = $("#submit_company_form input.avatar_url");
        // console.log($company_avatar_url.val());
        // var $about = $(".about-company-dashboard");
        // $about
        //   .find(".img-company")
        //   .html('<img src="' + $company_avatar_url.val() + '" alt="">');
      });
    };
    
    // Initialize the function
    felan_avatar();
    

    var felan_avatar_delete = function ($type) {
      $("body").on("click", ".icon-avatar-delete", function (e) {
        e.preventDefault();
        var $this = $(this),
          icon_delete = $this,
          avatar = $this
            .closest("#felan_avatar_view")
            .find(".media-thumb-wrap"),
          attachment_id = $this.data("attachment-id"),
          $drop = $("#felan_drop_avatar");

        icon_delete.html('<i class="fal fa-spinner fa-spin large"></i>');

        $.ajax({
          type: "post",
          url: ajax_url,
          dataType: "json",
          data: {
            action: "felan_avatar_remove_ajax",
            attachment_id: attachment_id,
            type: $type,
            removeNonce: avatar_upload_nonce,
          },
          success: function (response) {
            if (response.success) {
              avatar.remove();
              avatar.hide();

              $("#avatar_url-error").show();
              $("#felan_add_avatar").show();
            }
            icon_delete.html('<i class="fal fa-spinner fa-spin large"></i>');
            $drop.css("display", "block");
            $("#felan_add_avatar .la-upload").show();
            $("#felan_select_avatar").html(avatar_text);
            $("input.avatar_url").val("");
            $("input.avatar_id").val("");
            if ($(".form-dashboard").hasClass("freelancer-profile-form")) {
              $("#freelancer-profile-form").find(".point-mark").change();
            }

            //Company
            var $about = $(".about-company-dashboard");
            $about.find(".img-company").html('<i class="far fa-camera"></i>');
          },
          error: function () {
            icon_delete.html('<i class="far fa-trash-alt large"></i>');
          },
        });
      });
    };
    felan_avatar_delete();

    function showProgressBar() {
      $("#felan_add_avatar .la-upload").hide();
      var progressIndicator = `
      <div style="text-align: center; margin-top: 1rem;">
          <i class="fal fa-spinner fa-spin large"></i> Magic happening
      </div> `;
      $("#felan_avatar_view").html(progressIndicator);
    }


  });
})(jQuery);
