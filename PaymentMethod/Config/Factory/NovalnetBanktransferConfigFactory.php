<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetBanktransferConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetBanktransferConfigFactory extends NovalnetConfigFactory implements
    NovalnetBanktransferConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
          NovalnetBanktransferConfig::FIELD_PAYMENT_METHOD_IDENTIFIER => $this->getPaymentMethodIdentifier($channel),
          NovalnetBanktransferConfig::FIELD_ADMIN_LABEL =>
                $this->getAdminLabel($channel, NovalnetBanktransferConfig::ADMIN_LABEL_SUFFIX),
          NovalnetBanktransferConfig::FIELD_LABEL => $settings->getBanktransferLabel(),
          NovalnetBanktransferConfig::FIELD_SHORT_LABEL =>
                $settings->getBanktransferShortLabel(),
          NovalnetBanktransferConfig::TARIFF => $settings->getTariff(),
          NovalnetBanktransferConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
          NovalnetBanktransferConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
          NovalnetBanktransferConfig::BANKTRANSFER_TESTMODE => $settings->getBanktransferTestMode(),
          NovalnetBanktransferConfig::BANKTRANSFER_NOTIFICATION => $settings->getBanktransferBuyerNotification(),
          NovalnetBanktransferConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
          NovalnetBanktransferConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
          NovalnetBanktransferConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
        ];

        return new NovalnetBanktransferConfig($params);
    }
}
