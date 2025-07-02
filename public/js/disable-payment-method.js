(function ($) {
    'use strict';

    function paymentMethod() {
        this.init = function () {
            this.detectPaymentChange();
            this.codDepositChange();
            this.preventReloadDoAjaxAgain();
        }

        this.detectPaymentChange = function () {
            var parent = this;
            jQuery('body').on('change', 'input[name="payment_method"]', function () {
                parent.cartReload();
            });
        }

        this.cartReload = function () {
            jQuery("body").trigger('update_checkout');
        }

        this.codDepositChange = function () {
            var parent = this;
            jQuery('body').on('change', 'input[name="pi-cod-deposit"]', function () {
                parent.cartReload();
            });
        }

        this.preventReloadDoAjaxAgain = function () {
            jQuery(document.body).on('updated_checkout', function(event, response) {
                if (response && response.fragments && response.fragments['stop_reload_do_ajax_again']) {
                    jQuery("body").trigger('update_checkout');
                }
            });
        }
    }

    jQuery(function () {
        var paymentMethod_Obj = new paymentMethod();
        paymentMethod_Obj.init();
    });

})(jQuery);