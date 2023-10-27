<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPaypalConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetPaypalConfigFactory extends NovalnetConfigFactory implements NovalnetPaypalConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
          NovalnetPaypalConfig::FIELD_PAYMENT_METHOD_IDENTIFIER => $this->getPaymentMethodIdentifier($channel),
          NovalnetPaypalConfig::FIELD_ADMIN_LABEL =>
              $this->getAdminLabel($channel, NovalnetPaypalConfig::ADMIN_LABEL_SUFFIX),
          NovalnetPaypalConfig::FIELD_LABEL => $settings->getPaypalLabel(),
          NovalnetPaypalConfig::FIELD_SHORT_LABEL => $settings->getPaypalShortLabel(),
          NovalnetPaypalConfig::TARIFF => $settings->getTariff(),
          NovalnetPaypalConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
          NovalnetPaypalConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
          NovalnetPaypalConfig::PAYPAL_TESTMODE => $settings->getPaypalTestMode(),
          NovalnetPaypalConfig::PAYPAL_ONHOLD_AMOUNT => $settings->getPaypalOnholdAmount(),
          NovalnetPaypalConfig::PAYPAL_PAYMENT_ACTION => $settings->getPaypalPaymentAction(),
          NovalnetPaypalConfig::PAYPAL_NOTIFICATION => $settings->getPaypalBuyerNotification(),
          NovalnetPaypalConfig::PAYPAL_ONECLICK => $settings->getPaypalOneclick(),
          NovalnetPaypalConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
          NovalnetPaypalConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
          NovalnetPaypalConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
        ];

        return new NovalnetPaypalConfig($params);
    }
}
