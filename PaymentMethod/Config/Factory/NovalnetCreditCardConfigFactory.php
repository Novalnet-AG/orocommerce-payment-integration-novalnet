<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetCreditCardConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetCreditCardConfigFactory extends NovalnetConfigFactory implements NovalnetCreditCardConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
          NovalnetCreditCardConfig::FIELD_PAYMENT_METHOD_IDENTIFIER => $this->getPaymentMethodIdentifier($channel),
          NovalnetCreditCardConfig::FIELD_ADMIN_LABEL =>
              $this->getAdminLabel($channel, NovalnetCreditCardConfig::ADMIN_LABEL_SUFFIX),
          NovalnetCreditCardConfig::FIELD_LABEL => $settings->getCreditCardLabel(),
          NovalnetCreditCardConfig::FIELD_SHORT_LABEL => $settings->getCreditCardShortLabel(),
          NovalnetCreditCardConfig::TARIFF => $settings->getTariff(),
          NovalnetCreditCardConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
          NovalnetCreditCardConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
          NovalnetCreditCardConfig::CREDITCARD_TESTMODE => $settings->getCreditCardTestMode(),
          NovalnetCreditCardConfig::CREDITCARD_ONHOLD_AMOUNT => $settings->getCreditCardOnholdAmount(),
          NovalnetCreditCardConfig::CREDITCARD_PAYMENT_ACTION => $settings->getCreditCardPaymentAction(),
          NovalnetCreditCardConfig::CREDITCARD_NOTIFICATION => $settings->getCreditcardBuyerNotification(),
          NovalnetCreditCardConfig::CREDITCARD_INLINE_FORM => $settings->getCreditCardInlineForm(),
          NovalnetCreditCardConfig::CREDITCARD_INPUT_STYLE => $settings->getCreditCardInputStyle(),
          NovalnetCreditCardConfig::CREDITCARD_LABEL_STYLE => $settings->getCreditCardLabelStyle(),
          NovalnetCreditCardConfig::CREDITCARD_CONTAINER_STYLE => $settings->getCreditCardContainerStyle(),
          NovalnetCreditCardConfig::CREDITCARD_ENFORCE_3D => $settings->getCreditCardEnforce3d(),
          NovalnetCreditCardConfig::CREDITCARD_ONECLICK => $settings->getCreditCardOneclick(),
          NovalnetCreditCardConfig::CREDITCARD_CLIENT_KEY => $settings->getClientKey(),
          NovalnetCreditCardConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
          NovalnetCreditCardConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
          NovalnetCreditCardConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
          NovalnetCreditCardConfig::CREDITCARD_LOGO => $settings->getCreditCardLogo(),
        ];


        return new NovalnetCreditCardConfig($params);
    }
}
