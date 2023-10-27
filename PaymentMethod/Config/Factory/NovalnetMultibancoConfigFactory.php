<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetMultibancoConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetMultibancoConfigFactory extends NovalnetConfigFactory implements NovalnetMultibancoConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
           NovalnetMultibancoConfig::FIELD_PAYMENT_METHOD_IDENTIFIER => $this->getPaymentMethodIdentifier($channel),
           NovalnetMultibancoConfig::FIELD_ADMIN_LABEL =>
              $this->getAdminLabel($channel, NovalnetMultibancoConfig::ADMIN_LABEL_SUFFIX),
           NovalnetMultibancoConfig::FIELD_LABEL => $settings->getMultibancoLabel(),
           NovalnetMultibancoConfig::FIELD_SHORT_LABEL => $settings->getMultibancoShortLabel(),
           NovalnetMultibancoConfig::TARIFF => $settings->getTariff(),
           NovalnetMultibancoConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
           NovalnetMultibancoConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
           NovalnetMultibancoConfig::MULTIBANCO_TESTMODE => $settings->getMultibancoTestMode(),
           NovalnetMultibancoConfig::MULTIBANCO_NOTIFICATION => $settings->getMultibancoBuyerNotification(),
           NovalnetMultibancoConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
           NovalnetMultibancoConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
           NovalnetMultibancoConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
        ];

        return new NovalnetMultibancoConfig($params);
    }
}
