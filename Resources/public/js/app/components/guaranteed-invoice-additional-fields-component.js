import mediator from 'oroui/js/mediator';
import _ from 'underscore';
import $ from 'jquery';
import 'jquery.validate';
import BaseComponent from 'oroui/js/app/components/base/component';

const GuaranteedInvoiceValidation = BaseComponent.extend({
    options: {
        paymentMethod: null
    },

    constructor: function GuaranteedInvoiceValidation() {
        GuaranteedInvoiceValidation.__super__.constructor.apply(this, arguments);
    },

    initialize: function(options) {
        this.options = _.extend({}, this.options, options);
        mediator.on('checkout:payment:before-transit', this.validateBeforeTransit, this);
    },

    validateBeforeTransit: function(eventData) {
        if (eventData.data.paymentMethod === this.options.paymentMethod) {
            const fieldErrorMsg = $('#guaranteed_invoice_error_msg').val();
            if (fieldErrorMsg) {
                eventData.stopped = true;
                mediator.execute('hideLoading');
                mediator.execute('showErrorMessage', fieldErrorMsg);
            }
        }
    },

    dispose: function() {
        if (this.disposed) {
            return;
        }
        mediator.off('checkout:payment:before-transit', this.validateBeforeTransit, this);
        GuaranteedInvoiceValidation.__super__.dispose.call(this);
    }
});

export default GuaranteedInvoiceValidation;
