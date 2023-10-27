<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetOnlinebanktransferConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetOnlinebanktransferConfigFactory extends NovalnetConfigFactory implements NovalnetOnlinebanktransferConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
           NovalnetOnlinebanktransferConfig::FIELD_PAYMENT_METHOD_IDENTIFIER => $this->getPaymentMethodIdentifier($channel),
           NovalnetOnlinebanktransferConfig::FIELD_ADMIN_LABEL =>
              $this->getAdminLabel($channel, NovalnetOnlinebanktransferConfig::ADMIN_LABEL_SUFFIX),
           NovalnetOnlinebanktransferConfig::FIELD_LABEL => $settings->getOnlinebanktransferLabel(),
           NovalnetOnlinebanktransferConfig::FIELD_SHORT_LABEL => $settings->getOnlinebanktransferShortLabel(),
           NovalnetOnlinebanktransferConfig::TARIFF => $settings->getTariff(),
           NovalnetOnlinebanktransferConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
           NovalnetOnlinebanktransferConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
           NovalnetOnlinebanktransferConfig::ONLINEBANKTRANSFER_TESTMODE => $settings->getOnlinebanktransferTestMode(),
           NovalnetOnlinebanktransferConfig::ONLINEBANKTRANSFER_NOTIFICATION => $settings->getOnlinebanktransferBuyerNotification(),
           NovalnetOnlinebanktransferConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
           NovalnetOnlinebanktransferConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
           NovalnetOnlinebanktransferConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
        ];

        return new NovalnetOnlinebanktransferConfig($params);
    }
}
