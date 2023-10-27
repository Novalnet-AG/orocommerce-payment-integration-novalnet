<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPrzelewyConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetPrzelewyConfigFactory extends NovalnetConfigFactory implements NovalnetPrzelewyConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
           NovalnetPrzelewyConfig::FIELD_PAYMENT_METHOD_IDENTIFIER => $this->getPaymentMethodIdentifier($channel),
           NovalnetPrzelewyConfig::FIELD_ADMIN_LABEL =>
              $this->getAdminLabel($channel, NovalnetPrzelewyConfig::ADMIN_LABEL_SUFFIX),
           NovalnetPrzelewyConfig::FIELD_LABEL => $settings->getPrzelewyLabel(),
           NovalnetPrzelewyConfig::FIELD_SHORT_LABEL => $settings->getPrzelewyShortLabel(),
           NovalnetPrzelewyConfig::TARIFF => $settings->getTariff(),
           NovalnetPrzelewyConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
           NovalnetPrzelewyConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
           NovalnetPrzelewyConfig::PRZELEWY_TESTMODE => $settings->getPrzelewyTestMode(),
           NovalnetPrzelewyConfig::PRZELEWY_NOTIFICATION => $settings->getPrzelewyBuyerNotification(),
           NovalnetPrzelewyConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
           NovalnetPrzelewyConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
           NovalnetPrzelewyConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),

        ];

        return new NovalnetPrzelewyConfig($params);
    }
}
