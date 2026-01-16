<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetGuaranteedInvoiceConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetGuaranteedInvoiceConfigFactory extends NovalnetConfigFactory implements
    NovalnetGuaranteedInvoiceConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
           NovalnetGuaranteedInvoiceConfig::FIELD_PAYMENT_METHOD_IDENTIFIER =>
              $this->getPaymentMethodIdentifier($channel),
           NovalnetGuaranteedInvoiceConfig::FIELD_ADMIN_LABEL =>
              $this->getAdminLabel($channel, NovalnetGuaranteedInvoiceConfig::ADMIN_LABEL_SUFFIX),
           NovalnetGuaranteedInvoiceConfig::FIELD_LABEL => $settings->getGuaranteedInvoiceLabel(),
           NovalnetGuaranteedInvoiceConfig::FIELD_SHORT_LABEL => $settings->getGuaranteedInvoiceShortLabel(),
           NovalnetGuaranteedInvoiceConfig::TARIFF => $settings->getTariff(),
           NovalnetGuaranteedInvoiceConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
           NovalnetGuaranteedInvoiceConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
           NovalnetGuaranteedInvoiceConfig::GUARANTEED_INVOICE_TESTMODE => $settings->getGuaranteedInvoiceTestMode(),
           NovalnetGuaranteedInvoiceConfig::GUARANTEED_INVOICE_NOTIFICATION =>
              $settings->getGuaranteedInvoiceBuyerNotification(),
           NovalnetGuaranteedInvoiceConfig::GUARANTEED_INVOICE_ONHOLD_AMOUNT =>
              $settings->getGuaranteedInvoiceOnholdAmount(),
           NovalnetGuaranteedInvoiceConfig::GUARANTEED_INVOICE_PAYMENT_ACTION =>
              $settings->getGuaranteedInvoicePaymentAction(),
           NovalnetGuaranteedInvoiceConfig::GUARANTEED_INVOICE_MIN_AMOUNT => $settings->getGuaranteedInvoiceMinAmount(),
           NovalnetGuaranteedInvoiceConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
           NovalnetGuaranteedInvoiceConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
           NovalnetGuaranteedInvoiceConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
        ];

        return new NovalnetGuaranteedInvoiceConfig($params);
    }
}
