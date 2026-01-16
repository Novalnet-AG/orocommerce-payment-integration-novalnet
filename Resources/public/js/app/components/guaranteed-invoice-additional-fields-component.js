define(function (require) {
    'use strict';

    const mediator = require('oroui/js/mediator');
    const _ = require('underscore');
    const $ = require('jquery');
    require('jquery.validate');

    const BaseComponent = require('oroui/js/app/components/base/component');

    const GuaranteedInvoiceValidation = BaseComponent.extend({

        /**
         * @property {Object}
         */
        options: {
            paymentMethod: null,
        },

        /**
         * @inheritDoc
         */
        constructor: function GuaranteedInvoiceValidation()
        {
            GuaranteedInvoiceValidation.__super__.constructor.apply(this, arguments);
        },

        /**
         * @inheritDoc
         */
        initialize: function (options) {
            this.options = _.extend({}, this.options, options);
            mediator.on('checkout:payment:before-transit', this.validateBeforeTransit, this);
        },

        /**
         * @param {Object} eventData
         */
        validateBeforeTransit: function (eventData) {
            if (eventData.data.paymentMethod === this.options.paymentMethod) {
                var fieldErrorMsg = $('#guaranteed_invoice_error_msg').val();
                if (fieldErrorMsg && fieldErrorMsg != undefined) {
                    eventData.stopped = true;
                    mediator.execute('hideLoading');
                    mediator.execute('showErrorMessage', fieldErrorMsg);
                }
            }
        },


        /**
         * @inheritDoc
         */
        dispose: function () {
            if (this.disposed) {
                return;
            }
            mediator.off('checkout:payment:before-transit', this.validateBeforeTransit, this);
            GuaranteedInvoiceValidation.__super__.dispose.call(this);
        },
    });

    return GuaranteedInvoiceValidation;
});

