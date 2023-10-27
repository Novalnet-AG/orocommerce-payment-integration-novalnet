<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetIdealConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetIdealConfigFactory extends NovalnetConfigFactory implements NovalnetIdealConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
           NovalnetIdealConfig::FIELD_PAYMENT_METHOD_IDENTIFIER => $this->getPaymentMethodIdentifier($channel),
           NovalnetIdealConfig::FIELD_ADMIN_LABEL =>
              $this->getAdminLabel($channel, NovalnetIdealConfig::ADMIN_LABEL_SUFFIX),
           NovalnetIdealConfig::FIELD_LABEL => $settings->getIdealLabel(),
           NovalnetIdealConfig::FIELD_SHORT_LABEL => $settings->getIdealShortLabel(),
           NovalnetIdealConfig::TARIFF => $settings->getTariff(),
           NovalnetIdealConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
           NovalnetIdealConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
           NovalnetIdealConfig::IDEAL_TESTMODE => $settings->getIdealTestMode(),
           NovalnetIdealConfig::IDEAL_NOTIFICATION => $settings->getIdealBuyerNotification(),
           NovalnetIdealConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
           NovalnetIdealConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
           NovalnetIdealConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
        ];

        return new NovalnetIdealConfig($params);
    }
}
