<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetTrustlyConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetTrustlyConfigFactory extends NovalnetConfigFactory implements NovalnetTrustlyConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
           NovalnetTrustlyConfig::FIELD_PAYMENT_METHOD_IDENTIFIER => $this->getPaymentMethodIdentifier($channel),
           NovalnetTrustlyConfig::FIELD_ADMIN_LABEL =>
              $this->getAdminLabel($channel, NovalnetTrustlyConfig::ADMIN_LABEL_SUFFIX),
           NovalnetTrustlyConfig::FIELD_LABEL => $settings->getTrustlyLabel(),
           NovalnetTrustlyConfig::FIELD_SHORT_LABEL => $settings->getTrustlyShortLabel(),
           NovalnetTrustlyConfig::TARIFF => $settings->getTariff(),
           NovalnetTrustlyConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
           NovalnetTrustlyConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
           NovalnetTrustlyConfig::TRUSTLY_TESTMODE => $settings->getTrustlyTestMode(),
           NovalnetTrustlyConfig::TRUSTLY_NOTIFICATION => $settings->getTrustlyBuyerNotification(),
           NovalnetTrustlyConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
           NovalnetTrustlyConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
           NovalnetTrustlyConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
        ];

        return new NovalnetTrustlyConfig($params);
    }
}
