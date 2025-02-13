var FELAN_STRIPE = FELAN_STRIPE || {};
(function ($) {
  "use strict";

  FELAN_STRIPE = {
    init: function () {
      this.setupForm();
    },

    setupForm: function () {
      var self = this,
        $form = $(".felan-service-stripe-form");
      if ($form.length === 0) return;
      var formId = $form.attr("id");
      // Set formData array index of the current form ID to match the localized data passed over for form settings.
      var formData = felan_stripe_vars[formId];
      // Variable to hold the Stripe configuration.
      var stripeHandler = null;
      var $submitBtn = $form.find(".felan-stripe-button");

      if ($submitBtn.length) {
        stripeHandler = StripeCheckout.configure({
          // Key param MUST be sent hfelan instead of stripeHandler.open().
          key: formData.key,
          locale: "auto",
          token: function (token, args) {
            $("<input>")
              .attr({
                type: "hidden",
                name: "stripeToken",
                value: token.id,
              })
              .appendTo($form);

            $("<input>")
              .attr({
                type: "hidden",
                name: "stripeTokenType",
                value: token.type,
              })
              .appendTo($form);

            if (token.email) {
              $("<input>")
                .attr({
                  type: "hidden",
                  name: "stripeEmail",
                  value: token.email,
                })
                .appendTo($form);
            }
            $form.submit();
          },
        });

        $submitBtn.on("click", function (event) {
          event.preventDefault();
          stripeHandler.open(formData.params);
        });
      }

      // Close Checkout on page navigation:
      window.addEventListener("popstate", function () {
        if (stripeHandler != null) {
          stripeHandler.close();
        }
      });
    },
  };

  $(document).ready(function () {
    FELAN_STRIPE.init();

    var show_loading = function ($text) {
      if ($text == "undefined" || $text == "" || $text == null) {
        $text = loading_text;
      }
      var template = wp.template("felan-processing-template");
      $("body").append(template({ ico: "fa fa-spinner fa-spin", text: $text }));
    };

    if (typeof felan_payment_vars !== "undefined") {
      var ajax_url = felan_template_vars.ajax_url;

      $("#felan_payment_service").on("click", function (event) {
        var payment_method = $(
          "input[name='felan_payment_method']:checked"
        ).val();
        var service_id = $(".payment-wrap")
          .find("input[name='service_id']")
          .val();
        if (payment_method == "paypal") {
          felan_paypal_payment_service_addons(service_id);
        } else if (payment_method == "stripe") {
          $("#felan_stripe_service_addons button").trigger("click");
        } else if (payment_method == "wire_transfer") {
          felan_wire_transfer_service_addons(service_id);
        } else if (payment_method == "woocheckout") {
          felan_woocommerce_payment_service_addons(service_id);
        } else if (payment_method == "razor") {
			felan_razor_payment_service_addons(service_id);
		}
      });

        $('input[name="felan_payment_method"]').on('change', function () {
            var selectedPaymentMethod = $('input[name="felan_payment_method"]:checked').val();
            var user_demo = $('input[name="user_demo"]').val();

			if ( user_demo == 'yes' ) {
				$('.payment-wrap .btn-add-to-message').remove();
				$('.payment-wrap .btn-submit').remove();
				if (selectedPaymentMethod == 'wire_transfer') {
					$('.payment-wrap .btn-wrapper').append(
						'<button id="felan_payment_service" type="submit" class="btn btn-success btn-submit gl-button">Pay Now</button>'
					);
					$("#felan_payment_service").on("click", function (event) {
						var service_id = $(".payment-wrap")
							.find("input[name='service_id']")
							.val();
						felan_wire_transfer_service_addons(service_id);
					});
				} else {
					$('.payment-wrap .btn-wrapper').append(
						'<a href="#" class="btn-add-to-message felan-button button-circle" data-text="Oops! Sorry. This action is restricted on the demo site.">Pay Now</a>'
					);
				}
			}
        });

      var felan_paypal_payment_service_addons = function (service_id) {
          let package_addons = [];

          $('.package-addons input[type="checkbox"]:checked').each(function() {
              let title = $(this).siblings('label').find('.title').text();
              let deliveryTime = $(this).data('delivery-time');
              let value = $(this).val();

              // Push the addon details to the array
              package_addons.push({
                  title: title,
                  deliveryTime: deliveryTime,
                  value: value
              });
          });

        $.ajax({
          type: "POST",
          url: ajax_url,
          data: {
            action: "felan_paypal_payment_service_addons",
            service_id: service_id,
            felan_service_security_payment: $(
              "#felan_service_security_payment"
            ).val(),
            total_price: $(".package-service")
              .find('input[name="total_price"]')
              .val(),
            package_time: $(".package-service")
              .find('input[name="package_time"]')
              .val(),
            package_time_type: $(".package-service")
              .find('input[name="package_time_type"]')
              .val(),
              package_des: $(".package-service")
                  .find('input[name="package_des"]')
                  .val(),
              package_new: $(".package-service")
                  .find('input[name="package_new"]')
                  .val(),
              package_addons: package_addons,
          },
          beforeSend: function () {
            $("#felan_payment_service").append(
              '<div class="felan-loading-effect"><span class="felan-dual-ring"></span></div>'
            );
          },
          success: function (data) {
            window.location.href = data;
          },
        });
      };

      var felan_wire_transfer_service_addons = function (service_id) {

        let package_addons = [];

        $('.package-addons input[type="checkbox"]:checked').each(function() {
            let title = $(this).siblings('label').find('.title').text();
            let deliveryTime = $(this).data('delivery-time');
            let value = $(this).val();

            // Push the addon details to the array
            package_addons.push({
                title: title,
                deliveryTime: deliveryTime,
                value: value
            });
        });

        $.ajax({
          type: "POST",
          url: ajax_url,
          data: {
            action: "felan_wire_transfer_service_addons",
            service_id: service_id,
            felan_service_security_payment: $(
              "#felan_service_security_payment"
            ).val(),
            price_default: $(".package-service")
                .find('input[name="package_price"]')
                .val(),
            total_price: $(".package-service")
              .find('input[name="total_price"]')
              .val(),
            package_time: $(".package-service")
              .find('input[name="package_time"]')
              .val(),
            package_time_type: $(".package-service")
              .find('input[name="package_time_type"]')
              .val(),
              package_des: $(".package-service")
                  .find('input[name="package_des"]')
                  .val(),
              package_new: $(".package-service")
                  .find('input[name="package_new"]')
                  .val(),
              package_addons: package_addons,
          },
          beforeSend: function () {
            $("#felan_payment_service").append(
              '<div class="felan-loading-effect"><span class="felan-dual-ring"></span></div>'
            );
          },
          success: function (data) {
            window.location.href = data;
          },
        });
      };

      var felan_woocommerce_payment_service_addons = function (service_id) {
          let package_addons = [];

          $('.package-addons input[type="checkbox"]:checked').each(function() {
              let title = $(this).siblings('label').find('.title').text();
              let deliveryTime = $(this).data('delivery-time');
              let value = $(this).val();

              // Push the addon details to the array
              package_addons.push({
                  title: title,
                  deliveryTime: deliveryTime,
                  value: value
              });
          });

        $.ajax({
          type: "POST",
          url: ajax_url,
              data: {
            action: "felan_woocommerce_payment_service_addons",
            service_id: service_id,
            felan_service_security_payment: $(
              "#felan_service_security_payment"
            ).val(),
            total_price: $(".package-service")
              .find('input[name="total_price"]')
              .val(),
            package_time: $(".package-service")
              .find('input[name="package_time"]')
              .val(),
            package_time_type: $(".package-service")
              .find('input[name="package_time_type"]')
              .val(),
              package_des: $(".package-service")
                  .find('input[name="package_des"]')
                  .val(),
              package_new: $(".package-service")
                  .find('input[name="package_new"]')
                  .val(),
              package_addons: package_addons,
          },
          beforeSend: function () {
            $("#felan_payment_service").append(
              '<div class="felan-loading-effect"><span class="felan-dual-ring"></span></div>'
            );
          },
          success: function (data) {
            window.location.href = data;
          },
        });
      };

	  	// var data = felan_payment_razor_vars;
		var setDisabled = function(id, state) {
			if (typeof state === 'undefined') {
				state = true;
			}
			var elem = document.getElementById(id);
			if (state === false) {
				elem.removeAttribute('disabled');
			} else {
				elem.setAttribute('disabled', state);
			}
		};

		function felan_razor_payment_service_addons (service_id) {
			let package_addons = [];

			$('.package-addons input[type="checkbox"]:checked').each(function() {
				let title = $(this).siblings('label').find('.title').text();
				let deliveryTime = $(this).data('delivery-time');
				let value = $(this).val();

				// Push the addon details to the array
				package_addons.push({
					title: title,
					deliveryTime: deliveryTime,
					value: value
				});
			});

			$.ajax({
				type: "POST",
				url: ajax_url,
				data: {
					action: "felan_razor_service_create_order",
					service_id: service_id,
					felan_service_security_payment: $(
						"#felan_service_security_payment"
					).val(),
					total_price: $(".package-service")
						.find('input[name="total_price"]')
						.val(),
				},
				beforeSend: function () {
					$("#felan_payment_service").append(
						'<div class="felan-loading-effect"><span class="felan-dual-ring"></span></div>'
					);
				},
				success: function (order) {
					order = JSON.parse( order );
					// Payment was closed without handler getting called
					order.modal = {
						ondismiss: function() {
							setDisabled('felan_payment_service', false);
						},
					};

					order.handler = function(payment) {
						console.log('payment', payment);
						document.getElementById('razorpay_payment_id').value =
							payment.razorpay_payment_id;
						document.getElementById('razorpay_signature').value =
							payment.razorpay_signature;
						// document.razorpayform.submit();

						$.ajax({
							url: ajax_url,
							data: {
								action: "felan_razor_service_payment_verify",
								razorpay_payment_id: $( '#razorpay_payment_id' ).val(),
								razorpay_order_id: order.order_id,
								razorpay_signature: $( '#razorpay_signature' ).val(),
								package_time: $(".package-service").find( 'input[name="package_time"]' ).val(),
								package_time_type: $(".package-service").find( 'input[name="package_time_type"]' ).val(),
								price_default: $(".package-service").find( 'input[name="package_price"]' ).val(),
								package_des: $(".package-service").find( 'input[name="package_des"]' ).val(),
								package_addons: package_addons,
								package_new: $(".package-service").find( 'input[name="package_new"]' ).val(),
							},
							type: 'POST',
							success: function(response){
								if (response) {
									window.location.href = response
								}
							}
						});
					};
					openCheckout(order);
				},
			});
		}

		// global method
		function openCheckout(order) {
			var razorpayCheckout = new Razorpay(order);
			razorpayCheckout.open();
		}
    }
  });
})(jQuery);
