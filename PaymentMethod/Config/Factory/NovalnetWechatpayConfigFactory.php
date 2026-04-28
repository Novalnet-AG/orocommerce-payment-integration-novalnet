<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetWechatpayConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetWechatpayConfigFactory extends NovalnetConfigFactory implements NovalnetWechatpayConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
           NovalnetWechatpayConfig::FIELD_PAYMENT_METHOD_IDENTIFIER => $this->getPaymentMethodIdentifier($channel),
           NovalnetWechatpayConfig::FIELD_ADMIN_LABEL =>
              $this->getAdminLabel($channel, NovalnetWechatpayConfig::ADMIN_LABEL_SUFFIX),
           NovalnetWechatpayConfig::FIELD_LABEL => $settings->getWechatpayLabel(),
           NovalnetWechatpayConfig::FIELD_SHORT_LABEL => $settings->getWechatpayShortLabel(),
           NovalnetWechatpayConfig::TARIFF => $settings->getTariff(),
           NovalnetWechatpayConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
           NovalnetWechatpayConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
           NovalnetWechatpayConfig::WECHATPAY_TESTMODE => $settings->getWechatpayTestMode(),
           NovalnetWechatpayConfig::WECHATPAY_NOTIFICATION => $settings->getWechatpayBuyerNotification(),
           NovalnetWechatpayConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
           NovalnetWechatpayConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
           NovalnetWechatpayConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
        ];

        return new NovalnetWechatpayConfig($params);
    }
}
