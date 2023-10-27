<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetCashpaymentConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetCashpaymentConfigFactory extends NovalnetConfigFactory implements
    NovalnetCashpaymentConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();

        $params = [
            NovalnetCashpaymentConfig::FIELD_PAYMENT_METHOD_IDENTIFIER =>
                $this->getPaymentMethodIdentifier($channel),
            NovalnetCashpaymentConfig::FIELD_ADMIN_LABEL =>
                $this->getAdminLabel($channel, NovalnetCashpaymentConfig::ADMIN_LABEL_SUFFIX),
            NovalnetCashpaymentConfig::FIELD_LABEL => $settings->getCashpaymentLabel(),
            NovalnetCashpaymentConfig::FIELD_SHORT_LABEL =>
                $settings->getCashpaymentShortLabel(),
            NovalnetCashpaymentConfig::TARIFF => $settings->getTariff(),
            NovalnetCashpaymentConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
            NovalnetCashpaymentConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
            NovalnetCashpaymentConfig::CASHPAYMENT_TESTMODE => $settings->getCashpaymentTestMode(),
            NovalnetCashpaymentConfig::CASHPAYMENT_DUEDATE => $settings->getCashpaymentDuedate(),
            NovalnetCashpaymentConfig::CASHPAYMENT_NOTIFICATION => $settings->getCashpaymentBuyerNotification(),
            NovalnetCashpaymentConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
            NovalnetCashpaymentConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
            NovalnetCashpaymentConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
        ];

        return new NovalnetCashpaymentConfig($params);
    }
}
