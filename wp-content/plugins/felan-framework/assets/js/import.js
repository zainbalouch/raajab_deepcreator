"use strict";

var felan = (($) => {
  return {
    init() {
      this.updateTheme();
      this.refreshTransients();
      this.processPluginActions();
      this.goToChangelog();
      this.applyPatch();
      this.fetchDemoSteps();
      this.selectDemoSteps();
      this.closeImportPopup();
      this.importDemo();
      this.refreshPlace();
    },
    playLottie(el, path, loop, duration) {
      var lt = lottie.loadAnimation({
        container: el,
        renderer: "svg",
        loop: loop,
        autoplay: true,
        path: path,
      });

      lt.play();

      if (!loop && 0 < duration) {
        setTimeout(() => {
          lt.stop();
        }, duration);
      }
    },
    humanFileSize(size) {
      var i = Math.floor(Math.log(size) / Math.log(1024));
      return (
        (size / Math.pow(1024, i)).toFixed(2) * 1 +
        " " +
        ["B", "kB", "MB", "GB", "TB"][i]
      );
    },
    updateTheme() {
      $(".felan-update-btn").on("click", (e) => {
        $(e.currentTarget)
          .find("i, .svg-inline--fa")
          .removeClass("la-cloud-download")
          .addClass("la-circle-notch la-spin");
      });
    },
    refreshTransients() {
      $(".felan-box--update__refresh").on("click", (e) => {
        e.preventDefault();

        var $el = $($(e.currentTarget));
        $el.find("i, .svg-inline--fa").addClass("felan-spin");

        $.ajax({
          type: "POST",
          url: felan_import_vars.ajax_url,
          data: {
            action: "refresh_transients",
            _wpnonce: $el.attr("data-nonce"),
          },
          timeout: 20000,
        })
          .done((response) => {
            if (response.success) {
              $el.html('<i class="las la-check"></i> Done');

              setTimeout(() => {
                location.reload();
              }, 800);
            } else {
              $el.html('<i class="las la-times"></i> Failed');
            }
          })
          .fail((jqXHR, textStatus) => {
            console.error(`${jqXHR.responseText}: ${jqXHR.status}`);
            console.error(`${textStatus}`);
          });
      });
    },
    processPluginActions() {
      $(".felan-plugin-link").on("click", (e) => {
        e.preventDefault();

        var $el = $(e.currentTarget),
          $pluginsTable = $(".felan-box--plugins table"),
          $pluginRow = $el.closest(".felan-plugin--required"),
          pluginAction = $el.attr("data-plugin-action"),
          $icon = $pluginRow.find("i, .svg-inline--fa"),
          ajaxData = {
            action: "process_plugin_actions",
            slug: $el.attr("data-slug"),
            source: $el.attr("data-source"),
            plugin_action: $el.attr("data-plugin-action"),
            _wpnonce: $el.attr("data-nonce"),
          };

        if ("deactivate-plugin" === pluginAction) {
          $el.html('<i class="las la-circle-notch la-spin"></i>Deactivating');
        }

        if ("activate-plugin" === pluginAction) {
          $el.html('<i class="las la-circle-notch la-spin"></i>Activating');
        }

        $.ajax({
          type: "POST",
          url: felan_import_vars.ajax_url,
          data: ajaxData,
          timeout: 20000,
        })
          .done((response) => {
            if (response.success) {
              if ("deactivate-plugin" === pluginAction) {
                $pluginRow
                  .removeClass("felan-plugin--activated")
                  .addClass("felan-plugin--deactivated");
                $el
                  .text("Activate")
                  .attr("data-plugin-action", "activate-plugin")
                  .attr("data-nonce", response.data)
                  .removeClass("felan-plugin-link--deactivate")
                  .addClass("felan-plugin-link--activate");
                $icon.addClass("la-times").removeClass("la-check");
              }

              if ("activate-plugin" === pluginAction) {
                $pluginRow
                  .removeClass("felan-plugin--deactivated")
                  .addClass("felan-plugin--activated");
                $el
                  .text("Deactivate")
                  .attr("data-plugin-action", "deactivate-plugin")
                  .attr("data-nonce", response.data)
                  .removeClass("felan-plugin-link--activate")
                  .addClass("felan-plugin-link--deactivate");
                $icon.addClass("la-check").removeClass("la-times");
              }

              var requiredPluginCount = $pluginsTable.find(
                  ".felan-plugin--required.felan-plugin--deactivated"
                ).length,
                $pluginCount = $(".felan-box--plugins .felan-box__footer span");

              if (requiredPluginCount) {
                $pluginCount
                  .css("color", "#dc433f")
                  .text(
                    "Please install and activate all required plugins (" +
                      requiredPluginCount +
                      ")"
                  );
              } else {
                $pluginCount
                  .css("color", "#6fbcae")
                  .text(
                    "All required plugins are activated. Now you can import the demo data."
                  );
              }
            } else {
              $el.text("Error");
            }
          })
          .fail((jqXHR, textStatus) => {
            console.error(`${jqXHR.responseText}: ${jqXHR.status}`);
            console.error(`${textStatus}`);
          });
      });
    },

    refreshPlace: function ($this) {
      $(".felan-import-refresh__button").on("click", (e) => {
        e.preventDefault();

        var $button = $(e.currentTarget),
          buttonText = $button.html();

        $button.html(
          '<i class="las la-circle-notch la-spin" style="display:inline-block"></i> Refreshing Data'
        );

        $.ajax({
          type: "POST",
          url: felan_import_vars.ajax_url,
          data: {
            action: "refresh_data",
          },
          success: function (response) {
            $button.html(buttonText);
            $("#felan-import-demo-popup").html(response.data);

            $.magnificPopup.open({
              items: {
                src: "#felan-import-demo-popup",
                type: "inline",
              },
              modal: true,
              removalDelay: 300,
              mainClass: "mfp-fade",
            });
          },
        });
      });
    },

    goToChangelog() {
      $("#go-to-changelog").on("click", (e) => {
        e.preventDefault();

        $("html, body").animate({
          scrollTop: $(".felan-box--changelog").offset().top,
        });
      });
    },

    applyPatch() {
      $(".felan-apply-patch").on("click", (e) => {
        e.preventDefault();

        var $el = $(e.currentTarget),
          $error = $(".felan-error-text"),
          ajaxData = {
            action: "apply_patch",
            key: $el.attr("data-key"),
            _wpnonce: $el.attr("data-nonce"),
          };

        if ($el.attr("disabled")) {
          return;
        }

        $(".felan-apply-patch").attr("disabled", true);
        $el.html(
          '<i class="las la-circle-notch la-spin" style="display:inline-block"></i> Applying'
        );
        $error.hide();

        $.ajax({
          type: "POST",
          url: felan_import_vars.ajax_url,
          data: ajaxData,
          timeout: 20000,
        })
          .done((response) => {
            if (response.success) {
              $el.removeAttr("disabled");
              $el.html(
                '<i class="las la-check" style="display:inline-block"></i> Patch Applied'
              );

              setTimeout(() => {
                location.reload();
              }, 800);
            } else {
              $el.removeAttr("disabled");
              $el.html(
                '<i class="las la-times" style="display:inline-block"></i> Error. Try again.'
              );
              $error
                .show()
                .html(
                  response.data.length
                    ? response.data
                    : "There was an error occurs when applying this patch, please try again."
                );
            }
          })
          .fail((jqXHR, textStatus) => {
            console.error(`${jqXHR.responseText}: ${jqXHR.status}`);
            console.error(`${textStatus}`);
          });
      });
    },
    fetchDemoSteps() {
      $(".felan-import-demo__button").on("click", (e) => {
        e.preventDefault();

        var $button = $(e.currentTarget),
          buttonText = $button.html(),
          $error = $(".felan-error-text"),
          ajaxData = {
            action: "fetch_demo_steps",
            demo_slug: $button.attr("data-demo-slug"),
            _wpnonce: $button.attr("data-nonce"),
          };

        if ($button.attr("disabled")) {
          return;
        }

        $button.html(
          '<i class="las la-circle-notch la-spin" style="display:inline-block"></i> Fetching Data'
        );
        $button.attr("disabled", true).removeClass("error");
        $error.hide();

        $.ajax({
          type: "POST",
          url: felan_import_vars.ajax_url,
          data: ajaxData,
          timeout: 20000,
        })
          .done((response) => {
            if (response.success) {
              $button.removeAttr("disabled");
              $button.html(buttonText);

              $("#felan-import-demo-popup").html(response.data);

              $.magnificPopup.open({
                items: {
                  src: "#felan-import-demo-popup",
                  type: "inline",
                },
                modal: true,
                removalDelay: 300,
                mainClass: "mfp-fade",
              });
            } else {
              $button.removeAttr("disabled").addClass("error");
              $button.html(
                '<i class="las la-times" style="display:inline-block"></i> Imported Failed'
              );
              $error
                .show()
                .html(
                  response.data.length
                    ? response.data
                    : "There was an error occurs when applying this patch, please try again."
                );
            }
          })
          .fail((jqXHR, textStatus) => {
            console.log(jqXHR.status);
            console.log(textStatus);
          });
      });
    },
    selectDemoSteps() {
      $(document).on("click", ".felan-demo-steps__svg", (e) => {
        $(e.currentTarget).prev('input[type="checkbox"]').trigger("click");
      });

      $(document).on("change", "#felan-all-demo-steps", (e) => {
        var $checkbox = $(e.currentTarget);

        if ($checkbox.is(":checked")) {
          $(".felan-demo-steps__checkbox").not($checkbox).attr("checked", true);
        } else {
          $(".felan-demo-steps__checkbox")
            .not($checkbox)
            .attr("checked", false);
        }
      });

      $(document).on("change", ".felan-demo-steps__checkbox", (e) => {
        var $checkbox = $(e.currentTarget),
          $checkAll = $("#felan-all-demo-steps"),
          uncheckCount = 0;

        if ($checkbox.is(":checked")) {
          $(".felan-demo-steps__checkbox")
            .not($checkAll)
            .each((idx, chkbox) => {
              if (!$(chkbox).is(":checked")) {
                uncheckCount++;
              }
            });

          if (1 <= uncheckCount) {
            $checkAll.attr("checked", false);
          } else {
            $checkAll.attr("checked", true);
          }
        } else {
          $checkAll.attr("checked", false);
        }
      });
    },
    closeImportPopup() {
      $(document).on("click", ".felan-popup__close-button", (e) => {
        e.preventDefault();
        $.magnificPopup.close();
      });
    },
    importDemo() {
      $(document).on("submit", "#demo-steps-form", (e) => {
        e.preventDefault();

        // Get all steps before submitting the form.
        $(".felan-demo-steps__checkbox")
          .not("#felan-all-demo-steps")
          .each((idx, chkbox) => {
            var demoSteps = $("#selected-steps").val();

            if ($(chkbox).is(":checked")) {
              $("#selected-steps").val(`${demoSteps}${$(chkbox).attr("id")},`);
            }
          });

        var $form = $(e.currentTarget),
          $popup = $("#felan-import-demo-popup"),
          $error = $form.find(".felan-error-text"),
          formData = $form.serialize();

        $popup.addClass("felan-loading");
        $error.hide();

        $.ajax({
          type: "POST",
          url: felan_import_vars.ajax_url,
          data: `${formData}&action=import_demo`,
        })
          .done((response) => {
            if (response.success) {
              // Change HTML for the popup.
              if (response.data) {
                $popup.html(response.data);
              }

              // Copy images from local media package.
              if ($("#copy-images-form").length) {
                this.copyImages();
                $("#copy-images-form").submit();
              }

              // Download image.
              if ($("#download-media-package-form").length) {
                this.downloadMediaPackage();
                $("#download-media-package-form").submit();
              }

              // Import content.
              if ($("#import-content-wrapper").length) {
                this.importData();
              }
            } else {
              $error
                .show()
                .html(
                  response.data.length
                    ? response.data
                    : "There was an error occurs when importing demo data, please try again."
                );
            }

            $popup.removeClass("felan-loading");
          })
          .fail((jqXHR, textStatus) => {
            console.error(`${jqXHR.responseText}: ${jqXHR.status}`);
            console.error(`${textStatus}`);
          });
      });

      // Prevent close windows while importing
      window.onbeforeunload = (e) => {
        if ($.magnificPopup.instance.isOpen) {
          if (!e) {
            e = window.event;
          }

          e.cancelBubble = true;
          e.returnValue =
            "The importer is running. Please don't navigate away from this page.";

          if (evt.stopPropagation) {
            e.stopPropagation();
            e.preventDefault();
          }
        }
      };
    },
    downloadMediaPackage() {
      var self = this;

      $("#download-media-package-form").on("submit", (e) => {
        e.preventDefault();

        var $form = $(e.currentTarget),
          $error = $form.find(".felan-error-text"),
          $note = $form.find(".felan-popup__note"),
          $closeButton = $form.find(".felan-popup__close-button"),
          $progressBar = $form.find(".felan-progress-bar"),
          formData = $form.serialize();

        $note.css({
          opacity: "1",
          visibility: "visible",
        });
        $closeButton.css({
          display: "none",
        });
        $error.hide();
        $progressBar.show();

        $.ajax({
          type: "POST",
          url: felan_import_vars.ajax_url,
          data: `${formData}&action=download_media_package`,
        })
          .done((response) => {
            if (response.success) {
              // Show progress when download file.
              var downloadPromise = new Promise((resolve, reject) => {
                var xhr = new XMLHttpRequest();
                xhr.open(
                  "GET",
                  "https://cors-anywhere.herokuapp.com/" +
                    $("#media_package_url").val(),
                  true
                );
                xhr.responseType = "blob";
                xhr.onprogress = (e) => {
                  if (0 < e.total) {
                    var percent = Math.round((e.loaded / e.total) * 100),
                      loaded = self.humanFileSize(e.loaded),
                      total = self.humanFileSize(e.total);

                    $progressBar
                      .find(".felan-progress-bar__inner")
                      .css("width", `${percent}%`);
                    $progressBar
                      .find(".felan-progress-bar__text")
                      .text(`${loaded} / ${total} (${percent}%)`);
                  }
                };

                xhr.onload = () => {
                  resolve(xhr.response);
                };

                xhr.onerror = () => {
                  reject(xhr.response);
                };

                xhr.send();
              });

              downloadPromise.then(() => {
                setTimeout(() => {
                  if (response.data) {
                    $("#felan-import-demo-popup").html(response.data);
                  }

                  // Copy images to wp-content/uploads
                  if ($("#copy-images-form").length) {
                    this.copyImages();
                    $("#copy-images-form").submit();
                  }
                }, 2000);
              });
            } else {
              $note.css({
                opacity: "0",
                visibility: "hidden",
              });
              $closeButton.css({
                display: "block",
              });
              $progressBar.hide();
              $error
                .show()
                .html(
                  response.data.length
                    ? response.data
                    : "There was an error occurs when downloading the media package, please try again."
                );
            }
          })
          .fail((jqXHR, textStatus) => {
            console.error(`${jqXHR.responseText}: ${jqXHR.status}`);
            console.error(`${textStatus}`);
          });
      });
    },
    copyImages() {
      $("#copy-images-form").on("submit", (e) => {
        e.preventDefault();

        var $popup = $("#felan-import-demo-popup"),
          $form = $(e.currentTarget),
          $error = $form.find(".felan-error-text"),
          $note = $form.find(".felan-popup__note"),
          $closeButton = $form.find(".felan-popup__close-button"),
          $title = $form.find(".felan-popup__title"),
          formData = $form.serialize();

        $note.css({
          opacity: "1",
          visibility: "visible",
        });
        $closeButton.css({
          opacity: "0",
          visibility: "hidden",
        });
        $error.hide();

        this.playLottie(
          $title[0],
          felan_import_vars.animation_url + "file-copying.json",
          true
        );

        $.ajax({
          type: "POST",
          url: felan_import_vars.ajax_url,
          data: `${formData}&action=copy_images`,
        }).done((response) => {
          setTimeout(() => {
            $title.find("svg").remove();

            if (response.success) {
              if (response.data) {
                $popup.html(response.data);

                if ($("#import-content-wrapper").length) {
                  this.importData();
                }

                if ($("#import-success").length) {
                  this.playLottie(
                    $("#import-success .felan-popup__subtitle")[0],
                    felan_import_vars.animation_url + "star-success.json",
                    true
                  );
                }
              }
            } else {
              $note.css({
                opacity: "0",
                visibility: "hidden",
              });
              $closeButton.css({
                opacity: "1",
                visibility: "visible",
              });
              $error
                .show()
                .html(
                  response.data.length
                    ? response.data
                    : "There was an error occurs when downloading the media package, please try again."
                );
            }
          }, 3000);
        });

        // .fail((jqXHR, textStatus) => {
        // 	console.error(`${jqXHR.responseText}: ${jqXHR.status}`);
        // 	console.error(`${textStatus}`);
        // });
      });
    },
    importData() {
      var $firstStep = $(
          "#import-content-wrapper .felan-import-content__item:first-child"
        ),
        $title = $("#import-content-wrapper .felan-popup__title"),
        data = {
          import_content_steps: $("#import_content_steps").val(),
          demo_slug: $("#demo_slug").val(),
          _wpnonce: $firstStep.attr("data-nonce"),
          action: $firstStep.attr("data-action"),
        };

      this.playLottie(
        $title[0],
        felan_import_vars.animation_url + "import-content.json",
        true
      );

      if ($firstStep.length) {
        this.runImportContentAjax(data);
      }
    },
    setUpAJAXData($el, data) {
      if ($el.prev().length) {
        $el
          .prev()
          .find("i, .svg-inline--fa")
          .removeClass("la-circle-notch la-spin")
          .addClass("la-check");
      } else {
        $el
          .find("i, .svg-inline--fa")
          .removeClass("la-circle-notch la-spin")
          .addClass("la-check");
      }

      data._wpnonce = $el.attr("data-nonce");
      data.action = $el.attr("data-action");

      return data;
    },
    runImportContentAjax(data) {
      var $wrapper = $("#import-content-wrapper"),
        $popup = $("#felan-import-demo-popup"),
        $error = $wrapper.find(".felan-error-text"),
        $note = $wrapper.find(".felan-popup__note"),
        $closeButton = $wrapper.find(".felan-popup__close-button"),
        $title = $wrapper.find(".felan-popup__title");

      $note.css({
        opacity: "1",
        visibility: "visible",
      });
      $closeButton.css({
        display: "none",
      });

      $error.hide();

      $.ajax({
        type: "POST",
        url: felan_import_vars.ajax_url,
        data: data,
      })
        .done((response) => {
          if (
            "undefined" !== typeof response.status &&
            "newAJAX" === response.status
          ) {
            this.runImportContentAjax(data);
          } else if ("undefined" !== typeof response.next_step) {
            data = this.setUpAJAXData(
              $(`#import-content-wrapper #${response.next_step}`),
              data
            );
            this.runImportContentAjax(data);
          } else if (response.success) {
            // Add checkbox for the last item
            $("#import-content-wrapper .felan-import-content__item:last-child")
              .find("i, .svg-inline--fa")
              .removeClass("la-circle-notch la-spin")
              .addClass("la-check");
            setTimeout(() => {
              if (response.data) {
                $popup.html(response.data);
                if ($("#import-success").length) {
                  this.playLottie(
                    $("#import-success .felan-popup__subtitle")[0],
                    felan_import_vars.animation_url + "star-success.json",
                    true
                  );
                }
              }
            }, 1500);
          } else {
            $title.find("svg").remove();
            $(".felan-import-content-list").hide();
            $note.css({
              opacity: "0",
              visibility: "hidden",
            });
            $closeButton.css({
              display: "block",
            });
            console.log(response);
            $error
                .show()
                .html(
                    typeof response.data === "string" && response.data.length
                        ? response.data
                        : "There was an error occurs when importing, please try again."
                );
          }
        })
        .fail((jqXHR, textStatus) => {
          console.error(`${jqXHR.responseText}: ${jqXHR.status}`);
          console.error(`${textStatus}`);
        });
    },
  };
})(jQuery);

jQuery(document).ready(() => felan.init());
