<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetKakaopayConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetKakaopayConfigFactory extends NovalnetConfigFactory implements NovalnetKakaopayConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
           NovalnetKakaopayConfig::FIELD_PAYMENT_METHOD_IDENTIFIER => $this->getPaymentMethodIdentifier($channel),
           NovalnetKakaopayConfig::FIELD_ADMIN_LABEL =>
              $this->getAdminLabel($channel, NovalnetKakaopayConfig::ADMIN_LABEL_SUFFIX),
           NovalnetKakaopayConfig::FIELD_LABEL => $settings->getKakaopayLabel(),
           NovalnetKakaopayConfig::FIELD_SHORT_LABEL => $settings->getKakaopayShortLabel(),
           NovalnetKakaopayConfig::TARIFF => $settings->getTariff(),
           NovalnetKakaopayConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
           NovalnetKakaopayConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
           NovalnetKakaopayConfig::KAKAOPAY_TESTMODE => $settings->getKakaopayTestMode(),
           NovalnetKakaopayConfig::KAKAOPAY_NOTIFICATION => $settings->getKakaopayBuyerNotification(),
           NovalnetKakaopayConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
           NovalnetKakaopayConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
           NovalnetKakaopayConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
        ];

        return new NovalnetKakaopayConfig($params);
    }
}