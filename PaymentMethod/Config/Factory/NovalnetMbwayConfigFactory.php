<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetMbwayConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetMbwayConfigFactory extends NovalnetConfigFactory implements NovalnetMbwayConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
           NovalnetMbwayConfig::FIELD_PAYMENT_METHOD_IDENTIFIER => $this->getPaymentMethodIdentifier($channel),
           NovalnetMbwayConfig::FIELD_ADMIN_LABEL =>
              $this->getAdminLabel($channel, NovalnetMbwayConfig::ADMIN_LABEL_SUFFIX),
           NovalnetMbwayConfig::FIELD_LABEL => $settings->getMbwayLabel(),
           NovalnetMbwayConfig::FIELD_SHORT_LABEL => $settings->getMbwayShortLabel(),
           NovalnetMbwayConfig::TARIFF => $settings->getTariff(),
           NovalnetMbwayConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
           NovalnetMbwayConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
           NovalnetMbwayConfig::MBWAY_TESTMODE => $settings->getMbwayTestMode(),
           NovalnetMbwayConfig::MBWAY_NOTIFICATION => $settings->getMbwayBuyerNotification(),
           NovalnetMbwayConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
           NovalnetMbwayConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
           NovalnetMbwayConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
        ];

        return new NovalnetMbwayConfig($params);
    }
}