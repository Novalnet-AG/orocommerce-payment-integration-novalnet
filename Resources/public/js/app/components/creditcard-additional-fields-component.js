import mediator from 'oroui/js/mediator';
import _ from 'underscore';
import $ from 'jquery';
import __ from 'orotranslation/js/translator';
import scriptjs from 'scriptjs';
import Modal from 'oroui/js/modal';
import routing from 'routing';
import 'jquery.validate';
import BaseComponent from 'oroui/js/app/components/base/component';

const CreditCardAdditionalFieldsComponent = BaseComponent.extend({
    $el: null,
    disposable: true,

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
            fieldCreditCardToken: '[name$="novalnet_credit_card_form_type[creditCardSavedCardDetails][paymentData]"]:checked'
        }
    },

    constructor: function CreditCardAdditionalFieldsComponent(options) {
        CreditCardAdditionalFieldsComponent.__super__.constructor.call(this, options);
    },

    initialize: function(options) {
        this.options = _.extend({}, this.options, options);
        this.$el = $(options._sourceElement);

        $('input[name="novalnet_credit_card_form_type[creditCardSavedCardDetails][paymentData]"]').change(function() {
            if ($('input[name="novalnet_credit_card_form_type[creditCardSavedCardDetails][paymentData]"]:checked').val() == 'new_account_details') {
                $('#novalnet-credit-card-payment-form').show();
            } else {
                $('#novalnet-credit-card-payment-form').hide();
            }
        });

        $('.credit-card-remove-saved-card-details').click(function() {
            const modal = new Modal({
                allowCancel: true,
                className: 'modal modal-primary',
                title: __('novalnet.remove_card_details_confirmation_text'),
                content: ''
            });
            modal.on('ok', _.bind(function() {
                const tokenId = $(this).attr('data-token-id');
                $.ajax({
                    url: routing.generate('novalnet_frontend_ajax_remove_payment_data', {id: tokenId}),
                    type: 'POST'
                }).done(function(data) {
                    if (data.successful == true) {
                        $('#credit_card_saved_card_details_' + tokenId).remove();
                        mediator.execute('showFlashMessage', 'success', __('novalnet.remove_card_details_success_msg'));
                    } else {
                        mediator.execute('showFlashMessage', 'error', __('novalnet.remove_card_details_failure_msg'));
                    }
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    mediator.execute('showFlashMessage', 'success', errorThrown);
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

    _includeJs: function() {
        mediator.execute('showLoading');
        this.loadNovalnetPaymentIframe(this.$el);
        mediator.execute('hideLoading');
    },

    loadNovalnetPaymentIframe: function(form) {
        const inlineForm = form.find(this.options.selectors.fieldInlineForm).val();
        const enforce3d = form.find(this.options.selectors.fieldEnforce3d).val();

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
            callback: {
                on_success: function(data) {
                    $('input[name="novalnet_credit_card_form_type[panhash]"]').val(data['hash']);
                    $('input[name="novalnet_credit_card_form_type[uniqueId]"]').val(data['unique_id']);
                    $('input[name="novalnet_credit_card_form_type[doRedirect]"]').val(data['do_redirect']);
                    $('form[name="oro_workflow_transition"]').submit();
                    return true;
                },
                on_error: function(data) {
                    if (undefined !== data['error_message']) {
                        mediator.execute('showFlashMessage', 'error', data['error_message']);
                        return false;
                    }
                },
                on_show_overlay: function() {
                    $('#novalnet_cc_iframe').addClass('novalnet_cc_overlay');
                },
                on_hide_overlay: function() {
                    $('#novalnet_cc_iframe').removeClass('novalnet_cc_overlay');
                }
            },
            iframe: {
                id: 'novalnet_cc_iframe',
                inline: inlineForm,
                style: {
                    container: form.find(this.options.selectors.fieldContainerstyle).val(),
                    input: form.find(this.options.selectors.fieldInputstyle).val(),
                    label: form.find(this.options.selectors.fieldLabelstyle).val()
                },
                text: {
                    error: __('novalnet.cc_error_msg'),
                    card_holder: {
                        label: __('novalnet.card_holder_label'),
                        place_holder: __('novalnet.card_holder_placeholder'),
                        error: ''
                    },
                    card_number: {
                        label: __('novalnet.card_number_label'),
                        place_holder: 'XXXX XXXX XXXX XXXX',
                        error: ''
                    },
                    expiry_date: {
                        label: __('novalnet.expiry_date_label'),
                        error: '',
                        place_holder: __('novalnet.expiry_date_placeholder')
                    },
                    cvc: {
                        label: __('novalnet.cvc_label'),
                        place_holder: 'XXX',
                        error: ''
                    }
                }
            },
            customer: {
                first_name: customerDetails.first_name,
                last_name: customerDetails.last_name,
                email: customerDetails.email,
                billing: {
                    street: customerDetails.street,
                    city: customerDetails.city,
                    zip: customerDetails.zip,
                    country_code: customerDetails.country_code
                },
                shipping: {
                    same_as_billing: customerDetails.same_as_billing
                }
            },
            transaction: {
                amount: customerDetails.amount,
                currency: customerDetails.currency,
                test_mode: customerDetails.test_mode,
                enforce_3d: enforce3d
            },
            custom: {
                lang: customerDetails.lang
            }
        };

        NovalnetUtility.createCreditCardForm(configurationObject);
    },

    beforeTransit: function(eventData) {
        if (eventData.data.paymentMethod !== this.options.paymentMethod) {
            return;
        }
        eventData.stopped = true;

        const ccPanHash = this.$el.find(this.options.selectors.fieldPanHash).val();
        const ccUniqueId = this.$el.find(this.options.selectors.fieldUniqueId).val();
        const ccDoRedirect = this.$el.find(this.options.selectors.fieldDoRedirect).val();
        const ccToken = this.$el.find(this.options.selectors.fieldCreditCardToken).val();
        const saveCardDetails = this.$el.find(this.options.selectors.fieldSaveCardDetails).prop('checked');

        if (((ccPanHash && ccUniqueId) || (ccToken && ccToken !== 'new_account_details'))) {
            const additionalData = {
                panHash: ccPanHash,
                uniqueId: ccUniqueId,
                doRedirect: ccDoRedirect,
                ccToken: (ccToken && ccToken !== 'new_account_details') ? ccToken : '',
                saveCardDetails: saveCardDetails || ''
            };
            mediator.trigger('checkout:payment:additional-data:set', JSON.stringify(additionalData));
            eventData.resume();
        } else {
            NovalnetUtility.getPanHash();
        }
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
        CreditCardAdditionalFieldsComponent.__super__.dispose.call(this);
    }
});

export default CreditCardAdditionalFieldsComponent;
