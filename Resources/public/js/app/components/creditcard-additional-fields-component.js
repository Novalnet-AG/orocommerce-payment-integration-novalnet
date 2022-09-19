define(function (require) {
    'use strict';

    const mediator = require('oroui/js/mediator');
    const _ = require('underscore');
    const $ = require('jquery');
    const __ = require('orotranslation/js/translator');
    const scriptjs = require('scriptjs');
    const Modal = require('oroui/js/modal');
    const routing = require('routing');
    require('jquery.validate');

    const BaseComponent = require('oroui/js/app/components/base/component');

    const CreditCardAdditionalFieldsComponent = BaseComponent.extend({

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
            selectors: {
                fieldPanHash: '[name$="novalnet_credit_card_form_type[panhash]"]',
                fieldUniqueId: '[name$="novalnet_credit_card_form_type[uniqueId]"]',
                fieldDoRedirect: '[name$="novalnet_credit_card_form_type[doRedirect]"]',
                fieldCustomerDetails: '[name$="novalnet_credit_card_form_type[customerDetails]"]',
                fieldClientKey: '[name$="novalnet_credit_card_form_type[clientKey]"]',
                fieldLabelstyle: '[name$="novalnet_credit_card_form_type[labelStyle]"]',
                fieldInputstyle: '[name$="novalnet_credit_card_form_type[inputStyle]"]',
                fieldContainerstyle: '[name$="novalnet_credit_card_form_type[containerStyle]"]',
                fieldInlineForm: '[name$="novalnet_credit_card_form_type[inlineForm]"]',
                fieldEnforce3d: '[name$="novalnet_credit_card_form_type[enforce3d]"]',
                fieldSaveCardDetails: '[name$="novalnet_credit_card_form_type[saveCardDetails]"]',
                fieldCreditCardToken : '[name$="novalnet_credit_card_form_type[creditCardSavedCardDetails][paymentData]"]:checked',
            }
        },

        /**
         * @inheritDoc
         */
        constructor: function CreditCardAdditionalFieldsComponent(options)
        {
            CreditCardAdditionalFieldsComponent.__super__.constructor.call(this, options);
        },

        /**
         * @inheritDoc
         */
        initialize: function (options) {
            this.options = _.extend({}, this.options, options);
            this.$el = $(options._sourceElement);


            $('input[name="novalnet_credit_card_form_type[creditCardSavedCardDetails][paymentData]"]').change(function (event) {
                if ($('input[name="novalnet_credit_card_form_type[creditCardSavedCardDetails][paymentData]"]:checked').val() == 'new_account_details') {
                    $('#novalnet-credit-card-payment-form').show();
                } else {
                    $('#novalnet-credit-card-payment-form').hide();
                }
            });

            $('.credit-card-remove-saved-card-details').click(function (event) {
                const modal = new Modal({
                    allowCancel: true,
                    className: 'modal modal-primary',
                    title: __('novalnet.remove_card_details_confirmation_text'),
                    content: ''
                });
                modal.on('ok', _.bind(function () {
                    const tokenId = $(this).attr('data-token-id');
                    $.ajax({
                        url: routing.generate("novalnet_frontend_ajax_remove_payment_data", { id: tokenId }),
                        type: 'POST',
                    }).done(function (data) {

                        if (data.successful == true) {
                            $('#credit_card_saved_card_details_'+tokenId).remove();
                            mediator.execute(
                                'showFlashMessage',
                                'success',
                                __('novalnet.remove_card_details_success_msg')
                            );
                        } else {
                            mediator.execute(
                                'showFlashMessage',
                                'error',
                                __('novalnet.remove_card_details_failure_msg')
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



            if (typeof NovalnetUtility !== 'object') {
                scriptjs('https://cdn.novalnet.de/js/v2/NovalnetUtility.js', this._includeJs.bind(this));
            } else {
                this.loadNovalnetPaymentIframe(this.$el);
            }

            mediator.on('checkout:payment:before-transit', this.beforeTransit, this);
            mediator.on('checkout:payment:before-hide-filled-form', this.beforeHideFilledForm, this);
            mediator.on('checkout:payment:before-restore-filled-form', this.beforeRestoreFilledForm, this);
            mediator.on('checkout:payment:remove-filled-form', this.removeFilledForm, this);
            mediator.on('checkout-content:initialized', this.refreshPaymentMethod, this);

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

        _includeJs: function () {
            mediator.execute('showLoading');
            this.loadNovalnetPaymentIframe(this.$el);
            mediator.execute('hideLoading');

        },


        loadNovalnetPaymentIframe: function (form) {
            var inlineForm = form.find(this.options.selectors.fieldInlineForm).val();
            var enforce3d = form.find(this.options.selectors.fieldEnforce3d).val();
            
            if (inlineForm == 0) {
                $('#novalnet_cc_iframe').css('min-height', '175px');
            }

            $('input[name="novalnet_credit_card_form_type[panhash]"]').val('');
            $('input[name="novalnet_credit_card_form_type[uniqueId]"]').val('');
            $('input[name="novalnet_credit_card_form_type[doRedirect]"]').val('');

            const clientKey = form.find(this.options.selectors.fieldClientKey).val();

            const customerDetails = JSON.parse(form.find(this.options.selectors.fieldCustomerDetails).val());

            NovalnetUtility.setClientKey(clientKey);

            const configurationObject = {

            // You can handle the process here, when specific events occur.
                callback: {

                    // Called once the pan_hash (temp. token) created successfully.
                    on_success: function (data) {
                        
                        $('input[name="novalnet_credit_card_form_type[panhash]"]').val(data ['hash']);
                        $('input[name="novalnet_credit_card_form_type[uniqueId]"]').val(data ['unique_id']);
                        $('input[name="novalnet_credit_card_form_type[doRedirect]"]').val(data ['do_redirect']);

                        $('form[name="oro_workflow_transition"]').submit();

                        return true;
                    },

                    // Called in case of an invalid payment data or incomplete input.
                    on_error:  function (data) {
                        if ( undefined !== data['error_message'] ) {
                            mediator.execute(
                                'showFlashMessage',
                                'error',
                                data['error_message'],
                            );
                            return false;
                        }
                    },

                    // Called in case the Challenge window Overlay (for 3ds2.0) displays
                    on_show_overlay:  function (data) {
                        $('#novalnet_cc_iframe').addClass('novalnet_cc_overlay');
                    },

                    // Called in case the Challenge window Overlay (for 3ds2.0) hided
                    on_hide_overlay:  function (data) {
                        $('#novalnet_cc_iframe').removeClass('novalnet_cc_overlay');
                    }
                },

                // You can customize your Iframe container styel, text etc.
                iframe: {

                    // It is mandatory to pass the Iframe ID here.  Based on which the entire process will took place.
                    id: "novalnet_cc_iframe",

                    // Set to 1 to make you Iframe input container more compact (default - 0)
                    inline: inlineForm,
                    
                    skip_auth: 1,

                    // Add the style (css) here for either the whole Iframe contanier or for particular label/input field
                    style: {
                        // The css for the Iframe container
                        container: form.find(this.options.selectors.fieldContainerStyle).val(),

                        // The css for the input field of the Iframe container
                        input: form.find(this.options.selectors.fieldInputStyle).val(),

                        // The css for the label of the Iframe container
                        label: form.find(this.options.selectors.fieldLabelStyle).val(),
                    },

                    // You can customize the text of the Iframe container here
                    text: {

                        // Basic Error Message
                        error: __('novalnet.cc_error_msg'),

                        // You can customize the text for the Card Holder here
                        card_holder : {

                            // You have to give the Customized label text for the Card Holder Container here
                            label: __('novalnet.card_holder_label'), //__('novalnet.card_holder.label'),

                            // You have to give the Customized placeholder text for the Card Holder Container here
                            place_holder: __('novalnet.card_holder_placeholder'),

                            // You have to give the Customized error text for the Card Holder Container here
                            error: ''
                        },
                        card_number : {

                            // You have to give the Customized label text for the Card Number Container here
                            label: __('novalnet.card_number_label'),

                            // You have to give the Customized placeholder text for the Card Number Container here
                            place_holder: 'XXXX XXXX XXXX XXXX',

                            // You have to give the Customized error text for the Card Number Container here
                            error: ''
                        },
                        expiry_date : {

                            // You have to give the Customized label text for the Expiry Date Container here
                            label: __('novalnet.expiry_date_label'),

                            // You have to give the Customized error text for the Expiry Date Container here
                            error: '',
                            
                            // You have to give the Customized placeholder text for the Expiry Date Container here
                            place_holder: __('novalnet.expiry_date_placeholder')
                        },
                        cvc : {

                            // You have to give the Customized label text for the CVC/CVV/CID Container here
                            label: __('novalnet.cvc_label'),

                            // You have to give the Customized placeholder text for the CVC/CVV/CID Container here
                            place_holder: 'XXX',

                            // You have to give the Customized error text for the CVC/CVV/CID Container here
                            error: ''
                        }
                    }
                },

                // Add Customer data
                customer: {


                    // Your End-customer's First name which will be prefilled in the Card Holder field
                    first_name: customerDetails.first_name,

                    // Your End-customer's Last name which will be prefilled in the Card Holder field
                    last_name: customerDetails.last_name,

                    // Your End-customer's Email ID.
                    email: customerDetails.email,

                    // Your End-customer's billing address.
                    billing: {

                        // Your End-customer's billing street (incl. House no).
                        street: customerDetails.street,

                        // Your End-customer's billing city.
                        city: customerDetails.city,

                        // Your End-customer's billing zip.
                        zip: customerDetails.zip,

                        // Your End-customer's billing country ISO code.
                        country_code: customerDetails.country_code,
                    },
                    shipping: {

                        // Set to 1 if the billing and shipping address are same and no need to specify shipping details again here.
                        same_as_billing: customerDetails.same_as_billing,

                    },
                },

                // Add transaction data
                transaction: {

                    // The payable amount that can be charged for the transaction (in minor units), for eg:- Euro in Eurocents (5,22 EUR = 522).
                    amount: customerDetails.amount,

                    // The three-character currency code as defined in ISO-4217.
                    currency: customerDetails.currency,

                    // Set to 1 for the TEST transaction (default - 0).
                    test_mode: customerDetails.test_mode,
                    
                    enforce_3d : enforce3d
                },
                custom: {
                    // The End-customers selected language. The Iframe container will be rendered in this Language.
                    lang : customerDetails.lang,
                }
            }
            // Create the Credit Card form
            NovalnetUtility.createCreditCardForm(configurationObject);
        },



        /**
         * @param {Object} eventData
         */
        beforeTransit: function (eventData) {

            if (eventData.data.paymentMethod === this.options.paymentMethod) {
                
                eventData.stopped = true;

                const ccPanHash = this.$el.find(this.options.selectors.fieldPanHash).val();
                const ccUniqueId = this.$el.find(this.options.selectors.fieldUniqueId).val();
                const ccDoRedirect = this.$el.find(this.options.selectors.fieldDoRedirect).val();
                const ccToken = this.$el.find(this.options.selectors.fieldCreditCardToken).val();
                const saveCardDetails = this.$el.find(this.options.selectors.fieldSaveCardDetails).prop('checked');
                if (((ccPanHash != undefined && ccPanHash != '') && (ccUniqueId != '' && ccUniqueId != undefined)) || (ccToken != 'new_account_details' && ccToken != undefined)) {
                    const additionalData = {
                        panHash: ccPanHash,
                        uniqueId: ccUniqueId,
                        doRedirect: ccDoRedirect,
                        ccToken: (ccToken != undefined && ccToken != 'new_account_details' && ccToken != '') ? ccToken : '',
                        saveCardDetails: (saveCardDetails != undefined) ? saveCardDetails : '',
                    };

                    

                    mediator.trigger('checkout:payment:additional-data:set', JSON.stringify(additionalData));
                    eventData.resume();
                } else {
                    
                    NovalnetUtility.getPanHash();
                }
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

            CreditCardAdditionalFieldsComponent.__super__.dispose.call(this);
        },


    });

    return CreditCardAdditionalFieldsComponent;
});

