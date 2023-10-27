<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetEpsConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetEpsConfigFactory extends NovalnetConfigFactory implements NovalnetEpsConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
           NovalnetEpsConfig::FIELD_PAYMENT_METHOD_IDENTIFIER => $this->getPaymentMethodIdentifier($channel),
           NovalnetEpsConfig::FIELD_ADMIN_LABEL =>
              $this->getAdminLabel($channel, NovalnetEpsConfig::ADMIN_LABEL_SUFFIX),
           NovalnetEpsConfig::FIELD_LABEL => $settings->getEpsLabel(),
           NovalnetEpsConfig::FIELD_SHORT_LABEL => $settings->getEpsShortLabel(),
           NovalnetEpsConfig::TARIFF => $settings->getTariff(),
           NovalnetEpsConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
           NovalnetEpsConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
           NovalnetEpsConfig::EPS_TESTMODE => $settings->getEpsTestMode(),
           NovalnetEpsConfig::EPS_NOTIFICATION => $settings->getEpsBuyerNotification(),
           NovalnetEpsConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
           NovalnetEpsConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
           NovalnetEpsConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
        ];


        return new NovalnetEpsConfig($params);
    }
}
