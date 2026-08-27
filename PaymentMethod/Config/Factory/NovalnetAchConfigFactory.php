<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetAchConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetAchConfigFactory extends NovalnetConfigFactory implements NovalnetAchConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
           NovalnetAchConfig::FIELD_PAYMENT_METHOD_IDENTIFIER => $this->getPaymentMethodIdentifier($channel),
           NovalnetAchConfig::FIELD_ADMIN_LABEL =>
              $this->getAdminLabel($channel, NovalnetAchConfig::ADMIN_LABEL_SUFFIX),
           NovalnetAchConfig::FIELD_LABEL => $settings->getAchLabel(),
           NovalnetAchConfig::FIELD_SHORT_LABEL => $settings->getAchShortLabel(),
           NovalnetAchConfig::TARIFF => $settings->getTariff(),
           NovalnetAchConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
           NovalnetAchConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
           NovalnetAchConfig::ACH_TESTMODE => $settings->getAchTestMode(),
           NovalnetAchConfig::ACH_NOTIFICATION => $settings->getAchBuyerNotification(),
           NovalnetAchConfig::ACH_ONECLICK => $settings->getAchOneclick(),
           NovalnetAchConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
           NovalnetAchConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
           NovalnetAchConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
        ];

        return new NovalnetAchConfig($params);
    }
}
