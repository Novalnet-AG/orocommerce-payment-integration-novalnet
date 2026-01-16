<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetBancontactConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetBancontactConfigFactory extends NovalnetConfigFactory implements NovalnetBancontactConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
           NovalnetBancontactConfig::FIELD_PAYMENT_METHOD_IDENTIFIER => $this->getPaymentMethodIdentifier($channel),
           NovalnetBancontactConfig::FIELD_ADMIN_LABEL =>
              $this->getAdminLabel($channel, NovalnetBancontactConfig::ADMIN_LABEL_SUFFIX),
           NovalnetBancontactConfig::FIELD_LABEL => $settings->getBancontactLabel(),
           NovalnetBancontactConfig::FIELD_SHORT_LABEL => $settings->getBancontactShortLabel(),
           NovalnetBancontactConfig::TARIFF => $settings->getTariff(),
           NovalnetBancontactConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
           NovalnetBancontactConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
           NovalnetBancontactConfig::BANCONTACT_TESTMODE => $settings->getBancontactTestMode(),
           NovalnetBancontactConfig::BANCONTACT_NOTIFICATION => $settings->getBancontactBuyerNotification(),
           NovalnetBancontactConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
           NovalnetBancontactConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
           NovalnetBancontactConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),

        ];

        return new NovalnetBancontactConfig($params);
    }
}
