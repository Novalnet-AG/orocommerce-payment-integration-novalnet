define(function (require) {
    'use strict';

    const mediator = require('oroui/js/mediator');
    const Modal = require('oroui/js/modal');
    const _ = require('underscore');
    const __ = require('orotranslation/js/translator');
    const $ = require('jquery');
    const routing = require('routing');
    require('jquery.validate');

    const BaseComponent = require('oroui/js/app/components/base/component');

    const InstalmentInvoiceAdditionalFieldsComponent = BaseComponent.extend({
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
                container: '.novalnet-instalment-sepa-additional-fields',
                fieldSepaIban: '[name$="novalnet_instalment_sepa_form_type[instalmentSepaiban]"]',
                fieldInstalmentCycles: '[name$="novalnet_instalment_sepa_form_type[instalmentSepaCycle]"]',
                fieldSepaToken : '[name$="novalnet_instalment_sepa_form_type[instalmentSepaSavedAccountDetails][paymentData]"]:checked',
                fieldSepaSaveAccountDetails : '[name$="novalnet_instalment_sepa_form_type[instlSepaSaveAccountDetails]',
                removeButtonSelector: '.instalment-sepa-remove-saved-account-details'
            }
        },

        /**
         * @inheritDoc
         */
        constructor: function InstalmentInvoiceAdditionalFieldsComponent()
        {
            InstalmentInvoiceAdditionalFieldsComponent.__super__.constructor.apply(this, arguments);
        },

        /**
         * @inheritDoc
         */
        initialize: function (options) {
            this.options = _.extend({}, this.options, options);
            this.$el = $(options._sourceElement);

            $('#nn-instalment-sepa-mandate').click(function () {
                $('#nn-instalment-sepa-mandate-details').toggle();
            });

            var selectedValue = $('select[name="novalnet_instalment_sepa_form_type[instalmentSepaCycle]"] option:selected').val();
            $('#nn-sepa-instalment-table'+selectedValue).show();

            $('select[name="novalnet_instalment_sepa_form_type[instalmentSepaCycle]"]').on('change', function () {
                $('.nn-instalment-sepa-table').not('#nn-sepa-instalment-table'+this.value).hide();
                $('#nn-sepa-instalment-table'+this.value).show();
            });


            $('input[name="novalnet_instalment_sepa_form_type[instalmentSepaSavedAccountDetails][paymentData]"]').change(function (event) {
                if ($('input[name="novalnet_instalment_sepa_form_type[instalmentSepaSavedAccountDetails][paymentData]"]:checked').val() == 'new_account_details') {
                    $('#novalnet-instalment-sepa-payment-form').show();
                } else {
                    $('#novalnet-instalment-sepa-payment-form').hide();
                }
            });


            $('.instalment-sepa-remove-saved-account-details').click(function (event) {
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
                            $('#instalment_sepa_saved_account_details_'+tokenId).remove();
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

        removeFilledForm: function () {
            // Remove hidden form js component
            if (!this.disposable) {
                this.disposable = true;
                this.dispose();
            }
        },


        /**
         * @param {Object} eventData
         */
        beforeTransit: function (eventData) {
            if (eventData.data.paymentMethod === this.options.paymentMethod) {
                eventData.stopped = true;
                var instalmentCycles = this.$el.find(this.options.selectors.fieldInstalmentCycles).val();
                var sepaIban = this.$el.find(this.options.selectors.fieldSepaIban).val();
                var sepaToken = this.$el.find(this.options.selectors.fieldSepaToken).val();
                var sepaSaveAccountDetails = this.$el.find(this.options.selectors.fieldSepaSaveAccountDetails).prop('checked');
                var additionalData = {
                    sepaInstalmentCycles: instalmentCycles,
                    instlSepaIban: sepaIban,
                    instlSepaToken: (sepaToken != undefined && sepaToken != 'new_account_details' && sepaToken != '') ? sepaToken : '',
                    instlSepaSaveAccountDetails: (sepaSaveAccountDetails != undefined) ? sepaSaveAccountDetails : ''
                };

                if ((sepaToken == 'new_account_details' || sepaToken == undefined) && !this.validate()) {
                    return;
                }

                mediator.trigger('checkout:payment:additional-data:set', JSON.stringify(additionalData));
                eventData.resume();
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

            InstalmentInvoiceAdditionalFieldsComponent.__super__.dispose.call(this);
        },
    });

    return InstalmentInvoiceAdditionalFieldsComponent;
});

