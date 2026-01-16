<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPayconiqConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetPayconiqConfigFactory extends NovalnetConfigFactory implements NovalnetPayconiqConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
           NovalnetPayconiqConfig::FIELD_PAYMENT_METHOD_IDENTIFIER => $this->getPaymentMethodIdentifier($channel),
           NovalnetPayconiqConfig::FIELD_ADMIN_LABEL =>
              $this->getAdminLabel($channel, NovalnetPayconiqConfig::ADMIN_LABEL_SUFFIX),
           NovalnetPayconiqConfig::FIELD_LABEL => $settings->getPayconiqLabel(),
           NovalnetPayconiqConfig::FIELD_SHORT_LABEL => $settings->getPayconiqShortLabel(),
           NovalnetPayconiqConfig::TARIFF => $settings->getTariff(),
           NovalnetPayconiqConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
           NovalnetPayconiqConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
           NovalnetPayconiqConfig::PAYCONIQ_TESTMODE => $settings->getPayconiqTestMode(),
           NovalnetPayconiqConfig::PAYCONIQ_NOTIFICATION => $settings->getPayconiqBuyerNotification(),
           NovalnetPayconiqConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
           NovalnetPayconiqConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
           NovalnetPayconiqConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
        ];

        return new NovalnetPayconiqConfig($params);
    }
}