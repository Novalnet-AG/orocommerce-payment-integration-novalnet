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

    const AchAdditionalFieldsComponent = BaseComponent.extend({
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
                container: '.novalnet-ach-additional-fields',
                fieldAchAccountHolder: '[name$="novalnet_ach_form_type[achAccountHolder]"]',
                fieldAchAccountNumber: '[name$="novalnet_ach_form_type[achAccountNumber]"]',
                fieldAchRoutingNumber: '[name$="novalnet_ach_form_type[achRoutingNumber]"]',
                fieldAchToken : '[name$="novalnet_ach_form_type[achSavedAccountDetails][paymentData]"]:checked',
                fieldAchSaveAccountDetails : '[name$="novalnet_ach_form_type[achSaveAccountDetails]"]',
                removeButtonSelector: '.ach-remove-saved-account-details'
            }
        },

        /**
         * @inheritDoc
         */
        constructor: function AchAdditionalFieldsComponent()
        {
            AchAdditionalFieldsComponent.__super__.constructor.apply(this, arguments);
        },

        /**
         * @inheritDoc
         */
        initialize: function (options) {
            this.options = _.extend({}, this.options, options);
            this.$el = $(options._sourceElement);

            $('input[name="novalnet_ach_form_type[achSavedAccountDetails][paymentData]"]').change(function (event) {
                if ($('input[name="novalnet_ach_form_type[achSavedAccountDetails][paymentData]"]:checked').val() == 'new_account_details') {
                    $('#novalnet-ach-payment-form').show();
                } else {
                    $('#novalnet-ach-payment-form').hide();
                }
            });
            
            $('input[name="novalnet_ach_form_type[achAccountHolder]"]').on('input', function (event) {
                this.value = this.value.replace(/[0-9]/g, '');
            });     
            
            $('.ach-remove-saved-account-details').click(function (event) {
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
                            $('#ach_saved_account_details_'+tokenId).remove();
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

            this.validate = this.validate.bind(this);
            this.getForm().on('focusout', 'input,textarea', this.validate);

        },

        /**
         * @returns {jQuery|HTMLElement}
         */
        getForm: function () {
            return $(this.options.selectors.container);
        },

        /**
         * @param {Object} [event]
         *
         * @returns {Boolean}
         */
        validate: function (event) {
            let appendElement;
            if (event !== undefined && event.target) {
                const element = $(event.target);
                const parentForm = element.closest('form');

                if (parentForm.length) {
                    return element.validate().form();
                }

                appendElement = element.clone();
            } else {
                appendElement = this.getForm().clone();
            }

            const virtualForm = $('<form>');
            virtualForm.append(appendElement);

            const self = this;
            const validator = virtualForm.validate({
                ignore: '', // required to validate all fields in virtual form
                errorPlacement: function (error, element) {
                    const $el = self.getForm().find('#' + $(element).attr('id'));
                    const parentWithValidation = $el.parents('[data-validation]');

                    $el.addClass('error');

                    if (parentWithValidation.length) {
                        error.appendTo(parentWithValidation.first());
                    } else {
                        error.appendTo($el.parent());
                    }
                }
            });

            virtualForm.find('select').each(function (index, item) {
                $(item).val(self.getForm().find('select').eq(index).val());
            });

            // Add validator to form
            $.data(virtualForm, 'validator', validator);

            let errors;

            if (event) {
                errors = $(event.target).parent();
            } else {
                errors = this.getForm();
            }

            errors.find(validator.settings.errorElement + '.' + validator.settings.errorClass).remove();
            errors.parent().find('.error').removeClass('error');

            return validator.form();
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

        /**
         * @param {Object} eventData
         */
        beforeTransit: function (eventData) {

            if (eventData.data.paymentMethod !== this.options.paymentMethod) {
                return;
            }
            eventData.stopped = true;

            const achAccountHolder = this.$el.find(this.options.selectors.fieldAchAccountHolder).val();
            const achAccountNumber = this.$el.find(this.options.selectors.fieldAchAccountNumber).val();
            const achRoutingNumber = this.$el.find(this.options.selectors.fieldAchRoutingNumber).val();
            const achToken = this.$el.find(this.options.selectors.fieldAchToken).val();
            const achSaveAccountDetails = this.$el.find(this.options.selectors.fieldAchSaveAccountDetails).prop('checked');

                const additionalData = {
                    achAccountHolder: achAccountHolder,
                    achAccountNumber: achAccountNumber,
                    achRoutingNumber: achRoutingNumber,
                    achToken: (achToken != undefined && achToken != 'new_account_details') ? achToken : '',
                    achSaveAccountDetails: (achSaveAccountDetails != undefined) ? achSaveAccountDetails : ''
				};

            if ((achToken == 'new_account_details' || achToken == undefined) && !this.validate()) {
                return;
            }
            
			mediator.trigger('checkout:payment:additional-data:set', JSON.stringify(additionalData));
			eventData.resume();
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
            this.getForm().off('focusout', 'input,textarea', this.validate);
            mediator.off('checkout:payment:before-transit', this.beforeTransit, this);
            mediator.off('checkout:payment:before-hide-filled-form', this.beforeHideFilledForm, this);
            mediator.off('checkout:payment:before-restore-filled-form', this.beforeRestoreFilledForm, this);
            mediator.off('checkout:payment:remove-filled-form', this.removeFilledForm, this);
            mediator.off('checkout-content:initialized', this.refreshPaymentMethod, this);

            AchAdditionalFieldsComponent.__super__.dispose.call(this);
        },
    });

    return AchAdditionalFieldsComponent;
});

