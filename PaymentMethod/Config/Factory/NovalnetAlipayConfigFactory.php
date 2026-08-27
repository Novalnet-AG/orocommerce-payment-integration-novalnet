<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetAlipayConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetAlipayConfigFactory extends NovalnetConfigFactory implements NovalnetAlipayConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
           NovalnetAlipayConfig::FIELD_PAYMENT_METHOD_IDENTIFIER => $this->getPaymentMethodIdentifier($channel),
           NovalnetAlipayConfig::FIELD_ADMIN_LABEL =>
              $this->getAdminLabel($channel, NovalnetAlipayConfig::ADMIN_LABEL_SUFFIX),
           NovalnetAlipayConfig::FIELD_LABEL => $settings->getAlipayLabel(),
           NovalnetAlipayConfig::FIELD_SHORT_LABEL => $settings->getAlipayShortLabel(),
           NovalnetAlipayConfig::TARIFF => $settings->getTariff(),
           NovalnetAlipayConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
           NovalnetAlipayConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
           NovalnetAlipayConfig::ALIPAY_TESTMODE => $settings->getAlipayTestMode(),
           NovalnetAlipayConfig::ALIPAY_NOTIFICATION => $settings->getAlipayBuyerNotification(),
           NovalnetAlipayConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
           NovalnetAlipayConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
           NovalnetAlipayConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
        ];

        return new NovalnetAlipayConfig($params);
    }
}
