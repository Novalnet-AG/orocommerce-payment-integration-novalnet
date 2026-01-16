<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetTwintConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetTwintConfigFactory extends NovalnetConfigFactory implements NovalnetTwintConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
           NovalnetTwintConfig::FIELD_PAYMENT_METHOD_IDENTIFIER => $this->getPaymentMethodIdentifier($channel),
           NovalnetTwintConfig::FIELD_ADMIN_LABEL =>
              $this->getAdminLabel($channel, NovalnetTwintConfig::ADMIN_LABEL_SUFFIX),
           NovalnetTwintConfig::FIELD_LABEL => $settings->getTwintLabel(),
           NovalnetTwintConfig::FIELD_SHORT_LABEL => $settings->getTwintShortLabel(),
           NovalnetTwintConfig::TARIFF => $settings->getTariff(),
           NovalnetTwintConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
           NovalnetTwintConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
           NovalnetTwintConfig::TWINT_TESTMODE => $settings->getTwintTestMode(),
           NovalnetTwintConfig::TWINT_NOTIFICATION => $settings->getTwintBuyerNotification(),
           NovalnetTwintConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
           NovalnetTwintConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
           NovalnetTwintConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
        ];

        return new NovalnetTwintConfig($params);
    }
}