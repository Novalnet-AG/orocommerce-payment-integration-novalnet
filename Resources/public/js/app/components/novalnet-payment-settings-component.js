define(function (require) {
    'use strict';

    const $ = require('jquery');
    const _ = require('underscore');
    const __ = require('orotranslation/js/translator');
    const routing = require('routing');
    const mediator = require('oroui/js/mediator');
    const BaseComponent = require('oroui/js/app/components/base/component');

    const NovalnetSettingsComponent = BaseComponent.extend({

        _publicKeyInput: null,
        _privateKeyInput: null,
        _clientKeyInput: null,
        _tariffInput: null,
        _instlInvoiceCycleInput: null,
        _instlSepaCycleInput: null,

        _options: {
            publicKeyInputSelector: null,
            privateKeyInputSelector: null,
            clientKeyInputSelector: null,
            tariffInputSelector: null,
            instlInvoiceCycleSelector: null,
            instlSepaCycleSelector: null
        },

        /**
         * @inheritDoc
         */
        constructor: function NovalnetSettingsComponent(options)
        {
            NovalnetSettingsComponent.__super__.constructor.call(this, options);
        },

        initialize: function (options) {
            NovalnetSettingsComponent.__super__.initialize.call(this, options);

            this._options = _.extend(this._options, options);

            this._publicKeyInput = document.querySelector(this._options.publicKeyInputSelector);
            this._privateKeyInput = document.querySelector(this._options.privateKeyInputSelector);
            this._clientKeyInput = document.querySelector(this._options.clientKeyInputSelector);
            this._tariffInput = document.querySelector(this._options.tariffInputSelector);
            this._instlInvoiceCycleInput = document.querySelector(this._options.instlInvoiceCycleSelector);
            this._instlSepaCycleInput = document.querySelector(this._options.instlSepaCycleSelector);
            
            this._fillInstalmentCycles();
            
            this._getMerchantcredentials();

            this._initInputListeners();

            $('#custom-css-settings').click(function () {
                $('#cc-form-settings').toggle();
            });

        },

        _initInputListeners: function () {
            const handler = this._getMerchantcredentials.bind(this);
            this._publicKeyInput.addEventListener('change', handler);
            this._privateKeyInput.addEventListener('change', handler);
        },
        
        _fillInstalmentCycles: function () {
            var self = this;
            $('#instalment_sepa_cycle_select').on('change', function() {
                $(self._options.instlSepaCycleSelector).val(JSON.stringify($('#' + this.id).val()));
            });
            
            $('#instalment_invoice_cycle_select').on('change', function() {
                $(self._options.instlInvoiceCycleSelector).val(JSON.stringify($('#' + this.id).val()));
            });
            
            var selectedSepaCycle = $(self._options.instlSepaCycleSelector).val();
            if(selectedSepaCycle) {
                var parsedValue = JSON.parse(selectedSepaCycle);
                $.each(parsedValue, function ( key, value ) {
                    $("#instalment_sepa_cycle_select option[value="+value+"]").attr('selected', 'selected');
                });
            }
            else {
                $("#instalment_sepa_cycle_select option[value=12]").attr('selected', 'selected');
                $('#instalment_sepa_cycle_select').trigger("change");
            }
            
            var selectedInvoiceCycle = $(self._options.instlInvoiceCycleSelector).val();
            if(selectedInvoiceCycle) {
                var parsedValue = JSON.parse(selectedInvoiceCycle);
                $.each(parsedValue, function ( key, value ) {
                    $("#instalment_invoice_cycle_select option[value="+value+"]").attr('selected', 'selected');
                });
            }
            else {
                $("#instalment_invoice_cycle_select option[value=12]").attr('selected', 'selected');
                $('#instalment_invoice_cycle_select').trigger("change");
            }
        },

        _getMerchantcredentials: function () {
            if (this._publicKeyInput.value != '' && this._publicKeyInput.value != undefined && this._privateKeyInput.value != '' && this._privateKeyInput.value != undefined) {
                $('#test-mode-notification').hide();
                const data = {
                    publicKey: this._publicKeyInput.value,
                    privateKey: this._privateKeyInput.value,
                };

                var self = this;

                    $.ajax({
                        type: 'POST',
                        url: routing.generate("novalnet_settings_get_merchant_data", data),
                    }).done(function (response) {
                        
                        if (response.result.status_code == 100) {
                            self._fillMerchantCredentials(response, self);
                        } else {
                            mediator.execute(
                                'showMessage',
                                'error',
                                response.result.status_text
                            );
                        }
                    }).fail(function (jqXHR, textStatus, errorThrown) {

                        console.log(errorThrown);
                        mediator.execute(
                                'showMessage',
                                'error',
                                errorThrown
                            );

                    });
            }
        },
        _fillMerchantCredentials: function (response, self) {
            var selectedTariff = this._tariffInput.value;
            var selectedTariffText;
            if (response.merchant.client_key != undefined && response.merchant.client_key != '') {
                $(self._options.clientKeyInputSelector).val(response.merchant.client_key);
            }
            if (response.merchant.test_mode == 1) {
                $('#test-mode-notification').show();
            }
            var tariffSelect = $('#nn_tariff_select');
            $('#nn_tariff_select option').remove();
            $( "#nn_tariff_select" ).prev('span').text('');
            $.each(response.merchant.tariff, function ( key, value ) {
                tariffSelect.append($("<option>").attr('value',key).text(value.name));
                if(key == selectedTariff) {
                    selectedTariffText = value.name;
                }
            });
            if(selectedTariff) {
                $("#nn_tariff_select option[value="+selectedTariff+"]").attr('selected', 'selected');
            }
            $( "#nn_tariff_select" ).prev('span').text(selectedTariffText);
            $( "#nn_tariff_select").on('change', function() {
                $(self._options.tariffInputSelector).val(this.value);
            });
        },
    });

    return NovalnetSettingsComponent;
});
