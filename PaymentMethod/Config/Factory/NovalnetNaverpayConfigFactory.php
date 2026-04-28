<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetNaverpayConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetNaverpayConfigFactory extends NovalnetConfigFactory implements NovalnetNaverpayConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
           NovalnetNaverpayConfig::FIELD_PAYMENT_METHOD_IDENTIFIER => $this->getPaymentMethodIdentifier($channel),
           NovalnetNaverpayConfig::FIELD_ADMIN_LABEL =>
              $this->getAdminLabel($channel, NovalnetNaverpayConfig::ADMIN_LABEL_SUFFIX),
           NovalnetNaverpayConfig::FIELD_LABEL => $settings->getNaverpayLabel(),
           NovalnetNaverpayConfig::FIELD_SHORT_LABEL => $settings->getNaverpayShortLabel(),
           NovalnetNaverpayConfig::TARIFF => $settings->getTariff(),
           NovalnetNaverpayConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
           NovalnetNaverpayConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
           NovalnetNaverpayConfig::NAVERPAY_TESTMODE => $settings->getNaverpayTestMode(),
           NovalnetNaverpayConfig::NAVERPAY_NOTIFICATION => $settings->getNaverpayBuyerNotification(),
           NovalnetNaverpayConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
           NovalnetNaverpayConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
           NovalnetNaverpayConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
        ];

        return new NovalnetNaverpayConfig($params);
    }
}