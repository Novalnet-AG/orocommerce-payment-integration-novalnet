<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPostfinanceConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetPostfinanceConfigFactory extends NovalnetConfigFactory implements
    NovalnetPostfinanceConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
           NovalnetPostfinanceConfig::FIELD_PAYMENT_METHOD_IDENTIFIER =>
              $this->getPaymentMethodIdentifier($channel),
           NovalnetPostfinanceConfig::FIELD_ADMIN_LABEL =>
              $this->getAdminLabel($channel, NovalnetPostfinanceConfig::ADMIN_LABEL_SUFFIX),
           NovalnetPostfinanceConfig::FIELD_LABEL => $settings->getPostfinanceLabel(),
           NovalnetPostfinanceConfig::FIELD_SHORT_LABEL => $settings->getPostfinanceShortLabel(),
           NovalnetPostfinanceConfig::TARIFF => $settings->getTariff(),
           NovalnetPostfinanceConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
           NovalnetPostfinanceConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
           NovalnetPostfinanceConfig::POSTFINANCE_TESTMODE => $settings->getPostfinanceTestMode(),
           NovalnetPostfinanceConfig::POSTFINANCE_NOTIFICATION =>
              $settings->getPostfinanceBuyerNotification(),
           NovalnetPostfinanceConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
           NovalnetPostfinanceConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
           NovalnetPostfinanceConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
        ];

        return new NovalnetPostfinanceConfig($params);
    }
}
