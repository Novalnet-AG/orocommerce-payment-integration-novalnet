import mediator from 'oroui/js/mediator';
import _ from 'underscore';
import $ from 'jquery';
import 'jquery.validate';
import BaseComponent from 'oroui/js/app/components/base/component';

const InstalmentInvoiceAdditionalFieldsComponent = BaseComponent.extend({
    $el: null,
    disposable: true,

    options: {
        paymentMethod: null,
        selectors: {
            container: '.novalnet-instalment-invoice-additional-fields',
            fieldInstalmentCycles: '[name$="novalnet_instalment_invoice_form_type[instalmentInvoiceCycle]"]'
        }
    },

    constructor: function InstalmentInvoiceAdditionalFieldsComponent() {
        InstalmentInvoiceAdditionalFieldsComponent.__super__.constructor.apply(this, arguments);
    },

    initialize: function(options) {
        this.options = _.extend({}, this.options, options);
        this.$el = $(options._sourceElement);

        const selectedValue = $('select[name="novalnet_instalment_invoice_form_type[instalmentInvoiceCycle]"] option:selected').val();
        $('#nn-invoice-instalment-table' + selectedValue).show();

        $('select[name="novalnet_instalment_invoice_form_type[instalmentInvoiceCycle]"]').on('change', function() {
            $('.nn-instalment-invoice-table').not('#nn-invoice-instalment-table' + this.value).hide();
            $('#nn-invoice-instalment-table' + this.value).show();
        });

        mediator.on('checkout:payment:before-transit', this.beforeTransit, this);
        mediator.on('checkout:payment:before-hide-filled-form', this.beforeHideFilledForm, this);
        mediator.on('checkout:payment:before-restore-filled-form', this.beforeRestoreFilledForm, this);
        mediator.on('checkout:payment:remove-filled-form', this.removeFilledForm, this);
        mediator.on('checkout-content:initialized', this.refreshPaymentMethod, this);
    },

    refreshPaymentMethod: function() {
        mediator.trigger('checkout:payment:method:refresh');
    },

    beforeHideFilledForm: function() {
        this.disposable = false;
    },

    beforeRestoreFilledForm: function() {
        if (this.disposable) {
            this.dispose();
        }
    },

    removeFilledForm: function() {
        if (!this.disposable) {
            this.disposable = true;
            this.dispose();
        }
    },

    beforeTransit: function(eventData) {
        if (eventData.data.paymentMethod !== this.options.paymentMethod) {
            return;
        }
        eventData.stopped = true;
        const instalmentCycles = this.$el.find(this.options.selectors.fieldInstalmentCycles).val();
        mediator.trigger('checkout:payment:additional-data:set', JSON.stringify({invoiceInstalmentCycles: instalmentCycles}));
        eventData.resume();
    },

    dispose: function() {
        if (this.disposed || !this.disposable) {
            return;
        }
        mediator.off('checkout:payment:before-transit', this.beforeTransit, this);
        mediator.off('checkout:payment:before-hide-filled-form', this.beforeHideFilledForm, this);
        mediator.off('checkout:payment:before-restore-filled-form', this.beforeRestoreFilledForm, this);
        mediator.off('checkout:payment:remove-filled-form', this.removeFilledForm, this);
        mediator.off('checkout-content:initialized', this.refreshPaymentMethod, this);
        InstalmentInvoiceAdditionalFieldsComponent.__super__.dispose.call(this);
    }
});

export default InstalmentInvoiceAdditionalFieldsComponent;
