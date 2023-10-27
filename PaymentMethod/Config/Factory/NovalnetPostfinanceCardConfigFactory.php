<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPostfinanceCardConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetPostfinanceCardConfigFactory extends NovalnetConfigFactory implements
    NovalnetPostfinanceCardConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
           NovalnetPostfinanceCardConfig::FIELD_PAYMENT_METHOD_IDENTIFIER =>
              $this->getPaymentMethodIdentifier($channel),
           NovalnetPostfinanceCardConfig::FIELD_ADMIN_LABEL =>
              $this->getAdminLabel($channel, NovalnetPostfinanceCardConfig::ADMIN_LABEL_SUFFIX),
           NovalnetPostfinanceCardConfig::FIELD_LABEL => $settings->getPostfinanceCardLabel(),
           NovalnetPostfinanceCardConfig::FIELD_SHORT_LABEL => $settings->getPostfinanceCardShortLabel(),
           NovalnetPostfinanceCardConfig::TARIFF => $settings->getTariff(),
           NovalnetPostfinanceCardConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
           NovalnetPostfinanceCardConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
           NovalnetPostfinanceCardConfig::POSTFINANCECARD_TESTMODE => $settings->getPostfinanceCardTestMode(),
           NovalnetPostfinanceCardConfig::POSTFINANCECARD_NOTIFICATION
              => $settings->getPostfinanceCardBuyerNotification(),
           NovalnetPostfinanceCardConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
           NovalnetPostfinanceCardConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
           NovalnetPostfinanceCardConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
        ];

        return new NovalnetPostfinanceCardConfig($params);
    }
}
