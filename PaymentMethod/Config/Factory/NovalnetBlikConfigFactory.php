<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetBlikConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetBlikConfigFactory extends NovalnetConfigFactory implements NovalnetBlikConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
           NovalnetBlikConfig::FIELD_PAYMENT_METHOD_IDENTIFIER => $this->getPaymentMethodIdentifier($channel),
           NovalnetBlikConfig::FIELD_ADMIN_LABEL =>
              $this->getAdminLabel($channel, NovalnetBlikConfig::ADMIN_LABEL_SUFFIX),
           NovalnetBlikConfig::FIELD_LABEL => $settings->getBlikLabel(),
           NovalnetBlikConfig::FIELD_SHORT_LABEL => $settings->getBlikShortLabel(),
           NovalnetBlikConfig::TARIFF => $settings->getTariff(),
           NovalnetBlikConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
           NovalnetBlikConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
           NovalnetBlikConfig::BLIK_TESTMODE => $settings->getBlikTestMode(),
           NovalnetBlikConfig::BLIK_NOTIFICATION => $settings->getBlikBuyerNotification(),
           NovalnetBlikConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
           NovalnetBlikConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
           NovalnetBlikConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
        ];

        return new NovalnetBlikConfig($params);
    }
}