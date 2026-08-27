<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetSepaConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetSepaConfigFactory extends NovalnetConfigFactory implements NovalnetSepaConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
         NovalnetSepaConfig::FIELD_PAYMENT_METHOD_IDENTIFIER => $this->getPaymentMethodIdentifier($channel),
         NovalnetSepaConfig::FIELD_ADMIN_LABEL =>
            $this->getAdminLabel($channel, NovalnetSepaConfig::ADMIN_LABEL_SUFFIX),
         NovalnetSepaConfig::FIELD_LABEL => $settings->getSepaLabel(),
         NovalnetSepaConfig::FIELD_SHORT_LABEL => $settings->getSepaShortLabel(),
         NovalnetSepaConfig::TARIFF => $settings->getTariff(),
         NovalnetSepaConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
         NovalnetSepaConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
         NovalnetSepaConfig::SEPA_TESTMODE => $settings->getSepaTestMode(),
         NovalnetSepaConfig::SEPA_DUEDATE => $settings->getSepaDuedate(),
         NovalnetSepaConfig::SEPA_ONHOLD_AMOUNT => $settings->getSepaOnholdAmount(),
         NovalnetSepaConfig::SEPA_PAYMENT_ACTION => $settings->getSepaPaymentAction(),
         NovalnetSepaConfig::SEPA_NOTIFICATION => $settings->getSepaBuyerNotification(),
         NovalnetSepaConfig::GUARANTEED_SEPA_MIN_AMOUNT => $settings->getGuaranteedSepaMinAmount(),
         NovalnetSepaConfig::SEPA_ONECLICK => $settings->getSepaOneclick(),
         NovalnetSepaConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
         NovalnetSepaConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
         NovalnetSepaConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
        ];

        return new NovalnetSepaConfig($params);
    }
}
