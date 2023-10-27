<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetGiropayConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetGiropayConfigFactory extends NovalnetConfigFactory implements NovalnetGiropayConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
            NovalnetGiropayConfig::FIELD_PAYMENT_METHOD_IDENTIFIER => $this->getPaymentMethodIdentifier($channel),
            NovalnetGiropayConfig::FIELD_ADMIN_LABEL =>
                $this->getAdminLabel($channel, NovalnetGiropayConfig::ADMIN_LABEL_SUFFIX),
            NovalnetGiropayConfig::FIELD_LABEL => $settings->getGiropayLabel(),
            NovalnetGiropayConfig::FIELD_SHORT_LABEL => $settings->getGiropayShortLabel(),
            NovalnetGiropayConfig::TARIFF => $settings->getTariff(),
            NovalnetGiropayConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
            NovalnetGiropayConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
            NovalnetGiropayConfig::GIROPAY_TESTMODE => $settings->getGiropayTestMode(),
            NovalnetGiropayConfig::GIROPAY_NOTIFICATION => $settings->getGiropayBuyerNotification(),
            NovalnetGiropayConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
            NovalnetGiropayConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
            NovalnetGiropayConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
        ];

        return new NovalnetGiropayConfig($params);
    }
}
