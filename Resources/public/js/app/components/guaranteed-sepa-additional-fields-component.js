define(function (require) {
    'use strict';

    const mediator = require('oroui/js/mediator');
    const _ = require('underscore');
    const __ = require('orotranslation/js/translator');
    const $ = require('jquery');
    const Modal = require('oroui/js/modal');
    const routing = require('routing');
    require('jquery.validate');

    const BaseComponent = require('oroui/js/app/components/base/component');

    const GuaranteedSepaAdditionalFieldsComponent = BaseComponent.extend({
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
                container: '.novalnet-guaranteed-sepa-additional-fields',
                fieldSepaAccountHolder: '[name$="novalnet_guaranteed_sepa_form_type[guaranteedSepaaccountholder]"]',
                fieldSepaIban: '[name$="novalnet_guaranteed_sepa_form_type[guaranteedSepaiban]"]',
                fieldSepaBic: '[name$="novalnet_guaranteed_sepa_form_type[guaranteedSepabic]"]',
                fieldErrorMsg: '[name$="novalnet_guaranteed_sepa_form_type[guaranteedSepaErrorMsg]"]',
                fieldSepaToken : '[name$="novalnet_guaranteed_sepa_form_type[guaranteedSepaSavedAccountDetails][paymentData]"]:checked',
                fieldSepaSaveAccountDetails : '[name$="novalnet_guaranteed_sepa_form_type[guaranteedSepaSaveAccountDetails]'
            }
        },

        /**
         * @inheritDoc
         */
        constructor: function GuaranteedSepaAdditionalFieldsComponent()
        {
            GuaranteedSepaAdditionalFieldsComponent.__super__.constructor.apply(this, arguments);
        },

        /**
         * @inheritDoc
         */
        initialize: function (options) {
            this.options = _.extend({}, this.options, options);
            this.$el = $(options._sourceElement);
            const self = this;
            
            const bicField  = document.querySelector('[name="novalnet_guaranteed_sepa_form_type[guaranteedSepabic]"]');
			const bicLabel  = bicField.closest('div').querySelector('label');
			if (bicLabel) bicLabel.style.display = 'none';
			
			const ibanField = document.querySelector('[name="novalnet_guaranteed_sepa_form_type[guaranteedSepaiban]"]');
			if(ibanField.value) {
				const countryCode = ibanField.value.slice(0, 2).toUpperCase();
				self.toggleBicField(countryCode);
			}
			
			ibanField.addEventListener('input', function () {
				const value = $(this).val().trim().toUpperCase().substring(0, 2);
				self.toggleBicField(value);
			});
			
			$('input[name="novalnet_guaranteed_sepa_form_type[guaranteedSepaaccountholder]"]').on('input', function (event) {
                this.value = this.value.replace(/[0-9]/g, '');
            });

            $('#nn-guaranteed-sepa-mandate').click(function () {
                $('#nn-guaranteed-sepa-mandate-details').toggle();
            });


            $('input[name="novalnet_guaranteed_sepa_form_type[guaranteedSepaSavedAccountDetails][paymentData]"]').change(function (event) {
                if ($('input[name="novalnet_guaranteed_sepa_form_type[guaranteedSepaSavedAccountDetails][paymentData]"]:checked').val() == 'new_account_details') {
                    $('#novalnet-guaranteed-sepa-payment-form').show();
                } else {
                    $('#novalnet-guaranteed-sepa-payment-form').hide();
                }
            });

            $('.guaranteed-sepa-remove-saved-account-details').click(function (event) {
                const modal = new Modal({
                    allowCancel: true,
                    className: 'modal modal-primary',
                    title: 'Are you sure you want to remove these account details?',
                    content: ''
                });
                modal.on('ok', _.bind(function () {
                    const tokenId = $(this).attr('data-token-id');
                    $.ajax({
                        url: routing.generate("novalnet_frontend_ajax_remove_payment_data", { id: tokenId }),
                        type: 'POST',
                    }).done(function (data) {

                        if (data.successful == true) {
                            $('#guaranteed_sepa_saved_account_details_'+tokenId).remove();
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
        
        toggleBicField: function (countryCode) {
			const bicCountries = ['CH', 'MC', 'SM', 'GB', 'GI'];
			
			const bicField  = document.querySelector('[name="novalnet_guaranteed_sepa_form_type[guaranteedSepabic]"]');
			const bicLabel  = bicField.closest('div').querySelector('label');
			
			if (bicCountries.includes(countryCode)) {
				bicField.style.display = '';
				if (bicLabel) bicLabel.style.display = '';
			} else {
				bicField.style.display = 'none';
				if (bicLabel) bicLabel.style.display = 'none';
				bicField.value = '';
			}
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
                var fieldErrorMsg = this.$el.find(this.options.selectors.fieldErrorMsg).val();
                if (fieldErrorMsg && fieldErrorMsg != undefined) {
                    mediator.execute('hideLoading');
                    mediator.execute('showErrorMessage', fieldErrorMsg);
                } else {
					const sepaAccountHolder = this.$el.find(this.options.selectors.fieldSepaAccountHolder).val();
                    var sepaIban = this.$el.find(this.options.selectors.fieldSepaIban).val();
                    const sepaBic = this.$el.find(this.options.selectors.fieldSepaBic).val();
                    var sepaToken = this.$el.find(this.options.selectors.fieldSepaToken).val();
                    var sepaSaveAccountDetails = this.$el.find(this.options.selectors.fieldSepaSaveAccountDetails).prop('checked');
                    var additionalData = {
                        sepaAccountHolder: sepaAccountHolder,
						sepaBic: sepaBic,
						sepaIban: sepaIban,
                        sepaToken: (sepaToken != undefined && sepaToken != 'new_account_details') ? sepaToken : '',
                        sepaSaveAccountDetails: (sepaSaveAccountDetails != undefined) ? sepaSaveAccountDetails : ''
                    };

                    if ((sepaToken == 'new_account_details' || sepaToken == undefined) && !this.validate()) {
                        return;
                    }

                    mediator.trigger('checkout:payment:additional-data:set', JSON.stringify(additionalData));
                    eventData.resume();
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
            this.getForm().off('focusout', 'input,textarea', this.validate);

            mediator.off('checkout:payment:before-transit', this.beforeTransit, this);
            mediator.off('checkout:payment:before-hide-filled-form', this.beforeHideFilledForm, this);
            mediator.off('checkout:payment:before-restore-filled-form mediator', this.beforeRestoreFilledForm, this);
            mediator.off('checkout:payment:remove-filled-form', this.removeFilledForm, this);
            mediator.off('checkout-content:initialized mediator', this.refreshPaymentMethod, this);

            GuaranteedSepaAdditionalFieldsComponent.__super__.dispose.call(this);
        },
    });

    return GuaranteedSepaAdditionalFieldsComponent;
});

