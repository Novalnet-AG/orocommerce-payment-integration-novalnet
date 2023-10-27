define(function (require) {
    'use strict';

    const mediator = require('oroui/js/mediator');
    const __ = require('orotranslation/js/translator');
    const _ = require('underscore');
    const $ = require('jquery');
    const Modal = require('oroui/js/modal');
    const routing = require('routing');
    require('jquery.validate');

    const BaseComponent = require('oroui/js/app/components/base/component');

    const PaypalAdditionalFieldsComponent = BaseComponent.extend({
        /**
         * @property {jQuery}
         */
        $el: null,

        /**
         * @property {Boolean}
         */
        disposable: true,

        /**
         * @property {Object}
         */
        options: {
            paymentMethod: null,
            controllerRouteName: 'novalnet_frontend_ajax_remove_payment_data',
            selectors: {
                fieldPaypalToken : '[name$="novalnet_paypal_form_type[paymentData]"]:checked',
                fieldSaveAccountDetails : '[name$="novalnet_paypal_form_type[paypalSaveAccountDetails]"]',
                removeButtonSelector: '.paypal-remove-saved-account-details'
            }
        },

        /**
         * @inheritDoc
         */
        constructor: function PaypalAdditionalFieldsComponent()
        {
            PaypalAdditionalFieldsComponent.__super__.constructor.apply(this, arguments);
        },

        /**
         * @inheritDoc
         */
        initialize: function (options) {
            this.options = _.extend({}, this.options, options);
            this.$el = $(options._sourceElement);

            $('input[name="novalnet_paypal_form_type[paymentData]"]').change(function (event) {
                if ($('input[name="novalnet_paypal_form_type[paymentData]"]:checked').val() == 'new_account_details') {
                    $('#novalnet-paypal-payment-form').show();
                } else {
                    $('#novalnet-paypal-payment-form').hide();
                }
            });


            $('.paypal-remove-saved-account-details').click(function (event) {
                const modal = new Modal({
                    allowCancel: true,
                    className: 'modal modal-primary',
                    title: __('novalnet.remove_account_details_confirmation_text'),
                    content: ''
                });
                modal.on('ok', _.bind(function () {
                    const tokenId = $(this).attr('data-token-id');
                    $.ajax({
                        url: routing.generate("novalnet_frontend_ajax_remove_payment_data", { id: tokenId }),
                        type: 'POST',
                    }).done(function (data) {

                        if (data.successful == true) {
                            $('#paypal_saved_account_details_'+tokenId).remove();
                            mediator.execute(
                                'showFlashMessage',
                                'success',
                                __('novalnet.remove_account_details_success_msg')
                            );
                        } else {
                            mediator.execute(
                                'showFlashMessage',
                                'error',
                                __('novalnet.remove_account_details_failure_msg')
                            );
                        }
                    }).fail(function (jqXHR, textStatus, errorThrown) {
                            mediator.execute(
                                'showFlashMessage',
                                'success',
                                errorThrown
                            );
                    });
                }, this));

                modal.open();
            });


            mediator.on('checkout:payment:before-transit', this.beforeTransit, this);
            mediator.on('checkout:payment:before-hide-filled-form', this.beforeHideFilledForm, this);
            mediator.on('checkout:payment:before-restore-filled-form', this.beforeRestoreFilledForm, this);
            mediator.on('checkout:payment:remove-filled-form', this.removeFilledForm, this);
            mediator.on('checkout-content:initialized', this.refreshPaymentMethod, this);
        },
        /**
         * @param {Object} eventData
         */
        beforeTransit: function (eventData) {
            if (eventData.data.paymentMethod === this.options.paymentMethod) {
                eventData.stopped = true;
                var paypalToken = this.$el.find(this.options.selectors.fieldPaypalToken).val();
                var saveAccountDetails = this.$el.find(this.options.selectors.fieldSaveAccountDetails).prop('checked');
                var additionalData = {
                    paypalToken: (paypalToken != undefined && paypalToken != 'new_account_details' && paypalToken != '') ? paypalToken : '',
                    savePaypalAccountDetails: (saveAccountDetails != undefined) ? saveAccountDetails : ''
                };
                mediator.trigger('checkout:payment:additional-data:set', JSON.stringify(additionalData));
                eventData.resume();
            }
        },

        refreshPaymentMethod: function () {
            mediator.trigger('checkout:payment:method:refresh');
        },

        beforeHideFilledForm: function () {
            this.disposable = false;
        },

        beforeRestoreFilledForm: function () {
            if (this.disposable) {
                this.dispose();
            }
        },

        removeFilledForm: function () {
            // Remove hidden form js component
            if (!this.disposable) {
                this.disposable = true;
                this.dispose();
            }
        },

        /**
         * @inheritDoc
         */
        dispose: function () {
            if (this.disposed || !this.disposable) {
                return;
            }

            mediator.off('checkout:payment:before-transit', this.beforeTransit, this);
            mediator.off('checkout:payment:before-hide-filled-form', this.beforeHideFilledForm, this);
            mediator.off('checkout:payment:before-restore-filled-form', this.beforeRestoreFilledForm, this);
            mediator.off('checkout:payment:remove-filled-form', this.removeFilledForm, this);
            mediator.off('checkout-content:initialized', this.refreshPaymentMethod, this);
            PaypalAdditionalFieldsComponent.__super__.dispose.call(this);
        },
    });

    return PaypalAdditionalFieldsComponent;
});

