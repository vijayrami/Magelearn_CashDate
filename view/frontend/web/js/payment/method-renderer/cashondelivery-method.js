/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/* @api */
define([
    'Magento_Checkout/js/view/payment/default',
    'jquery',
    'mage/validation'
], function (Component,$) {
    'use strict';
    return Component.extend({
        defaults: {
            template: 'Magelearn_CashDate/payment/cashondelivery',
            cashDate:''
        },

        /**
         * Returns payment method instructions.
         *
         * @return {*}
         */
        getInstructions: function () {
            return window.checkoutConfig.payment.instructions[this.item.method];
        },
        showCashDate: function () {
            return window.checkoutConfig.show_cash_date;
        },
        /** @inheritdoc */
        initObservable: function () {
            this._super()
                .observe('cashDate');

            return this;
        },

        /**
         * @return {Object}
         */
        getData: function () {
            console.log(this.cashDate());
            return {
                method: this.item.method,
                /*'cash_date': this.cashDate(),*/
                'additional_data': {
                    'cash_date':this.cashDate()
                }
            };
        },

        /**
         * @return {jQuery}
         */
        validate: function () {
            var form = 'form[data-role=cashondelivery-form]';

            return $(form).validation() && $(form).validation('isValid');
        }
    });
});