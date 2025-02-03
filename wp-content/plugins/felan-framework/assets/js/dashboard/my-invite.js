(function ($) {
  "use strict";

  var my_invite = $(".felan-my-invite");

  var ajax_url = felan_my_invite_vars.ajax_url,
    not_jobs = felan_my_invite_vars.not_jobs;

  $(document).ready(function () {
    my_invite.find("select-pagination").change(function () {
      var number = "";
      my_invite.find(".select-pagination option:selected").each(function () {
        number += $(this).val() + " ";
      });
      $(this).attr("value");
    });

    my_invite.find("select.search-control").on("change", function () {
      my_invite.find(".felan-pagination").find('input[name="paged"]').val(1);
      ajax_load_invite();
    });

    function delay(callback, ms) {
      var timer = 0;
      return function () {
        var context = this,
          args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
          callback.apply(context, args);
        }, ms || 0);
      };
    }

    my_invite.find("input.jobs-search-control").keyup(
      delay(function () {
        my_invite.find(".felan-pagination").find('input[name="paged"]').val(1);
        ajax_load_invite();
      }, 1000)
    );

    $("body").on(
      "click",
      ".felan-my-invite .jobs-control .btn-delete",
      function (e) {
        e.preventDefault();
        var delete_id = $(this).attr("jobs-id");
        ajax_load_invite(delete_id, "delete");
      }
    );

    $("body").on(
      "click",
      ".felan-my-invite .felan-pagination a.page-numbers",
      function (e) {
        e.preventDefault();
        my_invite
          .find(".felan-pagination li .page-numbers")
          .removeClass("current");
        $(this).addClass("current");
        var paged = $(this).text();
        var current_page = 1;
        if (
          my_invite.find(".felan-pagination").find('input[name="paged"]').val()
        ) {
          current_page = my_invite
            .find(".felan-pagination")
            .find('input[name="paged"]')
            .val();
        }
        if ($(this).hasClass("next")) {
          paged = parseInt(current_page) + 1;
        }
        if ($(this).hasClass("prev")) {
          paged = parseInt(current_page) - 1;
        }
        my_invite
          .find(".felan-pagination")
          .find('input[name="paged"]')
          .val(paged);

        ajax_load_invite();
      }
    );

    var paged = 1;
    my_invite.find(".select-pagination").attr("data-value", paged);

    function ajax_load_invite(item_id = "", action_click = "") {
      var paged = 1;
      var height = my_invite.find("#my-invite").height();
      var jobs_search = my_invite.find('input[name="jobs_search"]').val(),
        item_amount = my_invite.find('select[name="item_amount"]').val(),
        jobs_sort_by = my_invite.find('select[name="jobs_sort_by"]').val();
      paged = my_invite.find('.felan-pagination input[name="paged"]').val();

      $.ajax({
        dataType: "json",
        url: ajax_url,
        data: {
          action: "felan_filter_my_invite",
          item_amount: item_amount,
          paged: paged,
          jobs_search: jobs_search,
          jobs_sort_by: jobs_sort_by,
          item_id: item_id,
          action_click: action_click,
        },
        beforeSend: function () {
          my_invite.find(".felan-loading-effect").addClass("loading").fadeIn();
          my_invite.find("#my-invite").height(height);
        },
        success: function (data) {
          if (data.success === true) {
            var $items_pagination = my_invite.find(".items-pagination"),
              select_item = $items_pagination
                .find('select[name="item_amount"] option:selected')
                .val(),
              max_number = data.total_post,
              value_first = select_item * paged + 1 - select_item,
              value_last = select_item * paged;
            if (max_number < value_first) {
              value_first = select_item * (paged - 1) + 1;
            }
            if (max_number < value_last) {
              value_last = max_number;
            }
            $items_pagination.find(".num-first").text(value_first);
            $items_pagination.find(".num-last").text(value_last);

            if (max_number > select_item) {
              $items_pagination.closest(".pagination-dashboard").show();
              $items_pagination.find(".num-total").html(data.total_post);
            } else {
              $items_pagination.closest(".pagination-dashboard").hide();
            }

            my_invite.find(".pagination").html(data.pagination);
            my_invite.find("#my-invite tbody").fadeOut("fast", function () {
              my_invite.find("#my-invite tbody").html(data.jobs_html);
              my_invite.find("#my-invite tbody").fadeIn(300);
            });
            my_invite.find("#my-invite").css("height", "auto");
          } else {
            my_invite
              .find("#my-invite tbody")
              .html('<span class="not-jobs">' + not_jobs + "</span>");
          }
          $(".tab-invite-item span").html("(" + data.total_post + ")");
          my_invite
            .find(".felan-loading-effect")
            .removeClass("loading")
            .fadeOut();
        },
      });
    }
  });
})(jQuery);
