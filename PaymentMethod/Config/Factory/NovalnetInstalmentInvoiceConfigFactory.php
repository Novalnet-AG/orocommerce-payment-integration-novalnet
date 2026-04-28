<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetInstalmentInvoiceConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetInstalmentInvoiceConfigFactory extends NovalnetConfigFactory implements
    NovalnetInstalmentInvoiceConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
           NovalnetInstalmentInvoiceConfig::FIELD_PAYMENT_METHOD_IDENTIFIER =>
              $this->getPaymentMethodIdentifier($channel),
           NovalnetInstalmentInvoiceConfig::FIELD_ADMIN_LABEL =>
              $this->getAdminLabel($channel, NovalnetInstalmentInvoiceConfig::ADMIN_LABEL_SUFFIX),
           NovalnetInstalmentInvoiceConfig::FIELD_LABEL => $settings->getInstalmentInvoiceLabel(),
           NovalnetInstalmentInvoiceConfig::FIELD_SHORT_LABEL => $settings->getInstalmentInvoiceShortLabel(),
           NovalnetInstalmentInvoiceConfig::TARIFF => $settings->getTariff(),
           NovalnetInstalmentInvoiceConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
           NovalnetInstalmentInvoiceConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
           NovalnetInstalmentInvoiceConfig::INSTALMENT_INVOICE_TESTMODE => $settings->getInstalmentInvoiceTestMode(),
           NovalnetInstalmentInvoiceConfig::INSTALMENT_INVOICE_MIN_AMOUNT => $settings->getInstalmentInvoiceMinAmount(),
           NovalnetInstalmentInvoiceConfig::INSTALMENT_INVOICE_PAYMENT_ACTION
             => $settings->getInstalmentInvoicePaymentAction(),
           NovalnetInstalmentInvoiceConfig::INSTALMENT_INVOICE_ONHOLD_AMOUNT
             => $settings->getInstalmentInvoiceOnholdAmount(),
           NovalnetInstalmentInvoiceConfig::INSTALMENT_INVOICE_CYCLE => $settings->getInstalmentInvoiceCycle(),
           NovalnetInstalmentInvoiceConfig::INSTALMENT_INVOICE_NOTIFICATION
             => $settings->getInstalmentInvoiceBuyerNotification(),
           NovalnetInstalmentInvoiceConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
           NovalnetInstalmentInvoiceConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
           NovalnetInstalmentInvoiceConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
        ];

        return new NovalnetInstalmentInvoiceConfig($params);
    }
}
