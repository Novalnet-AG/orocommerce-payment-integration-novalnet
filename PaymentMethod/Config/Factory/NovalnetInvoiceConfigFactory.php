<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetInvoiceConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetInvoiceConfigFactory extends NovalnetConfigFactory implements NovalnetInvoiceConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
           NovalnetInvoiceConfig::FIELD_PAYMENT_METHOD_IDENTIFIER => $this->getPaymentMethodIdentifier($channel),
           NovalnetInvoiceConfig::FIELD_ADMIN_LABEL =>
               $this->getAdminLabel($channel, NovalnetInvoiceConfig::ADMIN_LABEL_SUFFIX),
           NovalnetInvoiceConfig::FIELD_LABEL => $settings->getInvoiceLabel(),
           NovalnetInvoiceConfig::FIELD_SHORT_LABEL => $settings->getInvoiceShortLabel(),
           NovalnetInvoiceConfig::TARIFF => $settings->getTariff(),
           NovalnetInvoiceConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
           NovalnetInvoiceConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
           NovalnetInvoiceConfig::INVOICE_TESTMODE => $settings->getInvoiceTestMode(),
           NovalnetInvoiceConfig::INVOICE_DUEDATE => $settings->getInvoiceDuedate(),
           NovalnetInvoiceConfig::INVOICE_PAYMENT_ACTION => $settings->getInvoicePaymentAction(),
           NovalnetInvoiceConfig::INVOICE_ONHOLD_AMOUNT => $settings->getInvoiceOnholdAmount(),
           NovalnetInvoiceConfig::INVOICE_NOTIFICATION => $settings->getInvoiceBuyerNotification(),
           NovalnetInvoiceConfig::GUARANTEED_INVOICE_MIN_AMOUNT => $settings->getGuaranteedInvoiceMinAmount(),
           NovalnetInvoiceConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
           NovalnetInvoiceConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
           NovalnetInvoiceConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
        ];

        return new NovalnetInvoiceConfig($params);
    }
}
