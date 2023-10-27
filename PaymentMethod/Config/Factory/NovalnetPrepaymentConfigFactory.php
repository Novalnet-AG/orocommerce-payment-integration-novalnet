<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPrepaymentConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetPrepaymentConfigFactory extends NovalnetConfigFactory implements NovalnetPrepaymentConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
          NovalnetPrepaymentConfig::FIELD_PAYMENT_METHOD_IDENTIFIER => $this->getPaymentMethodIdentifier($channel),
          NovalnetPrepaymentConfig::FIELD_ADMIN_LABEL =>
             $this->getAdminLabel($channel, NovalnetPrepaymentConfig::ADMIN_LABEL_SUFFIX),
          NovalnetPrepaymentConfig::FIELD_LABEL => $settings->getPrepaymentLabel(),
          NovalnetPrepaymentConfig::FIELD_SHORT_LABEL =>
             $settings->getPrepaymentShortLabel(),
          NovalnetPrepaymentConfig::TARIFF => $settings->getTariff(),
          NovalnetPrepaymentConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
          NovalnetPrepaymentConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
          NovalnetPrepaymentConfig::PREPAYMENT_TESTMODE => $settings->getPrepaymentTestMode(),
          NovalnetPrepaymentConfig::PREPAYMENT_NOTIFICATION => $settings->getPrepaymentBuyerNotification(),
          NovalnetPrepaymentConfig::PREPAYMENT_DUEDATE => $settings->getPrepaymentDuedate(),
          NovalnetPrepaymentConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
          NovalnetPrepaymentConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
          NovalnetPrepaymentConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
        ];

        return new NovalnetPrepaymentConfig($params);
    }
}
