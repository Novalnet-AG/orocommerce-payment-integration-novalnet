<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetGuaranteedSepaConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetGuaranteedSepaConfigFactory extends NovalnetConfigFactory implements
    NovalnetGuaranteedSepaConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
           NovalnetGuaranteedSepaConfig::FIELD_PAYMENT_METHOD_IDENTIFIER => $this->getPaymentMethodIdentifier($channel),
           NovalnetGuaranteedSepaConfig::FIELD_ADMIN_LABEL =>
              $this->getAdminLabel($channel, NovalnetGuaranteedSepaConfig::ADMIN_LABEL_SUFFIX),
           NovalnetGuaranteedSepaConfig::FIELD_LABEL => $settings->getGuaranteedSepaLabel(),
           NovalnetGuaranteedSepaConfig::FIELD_SHORT_LABEL => $settings->getGuaranteedSepaShortLabel(),
           NovalnetGuaranteedSepaConfig::TARIFF => $settings->getTariff(),
           NovalnetGuaranteedSepaConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
           NovalnetGuaranteedSepaConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
           NovalnetGuaranteedSepaConfig::GUARANTEED_SEPA_TESTMODE => $settings->getGuaranteedSepaTestMode(),
           NovalnetGuaranteedSepaConfig::GUARANTEED_SEPA_NOTIFICATION
              => $settings->getGuaranteedSepaBuyerNotification(),
           NovalnetGuaranteedSepaConfig::GUARANTEED_SEPA_DUEDATE => $settings->getGuaranteedSepaDuedate(),
           NovalnetGuaranteedSepaConfig::GUARANTEED_SEPA_PAYMENT_ACTION => $settings->getGuaranteedSepaPaymentAction(),
           NovalnetGuaranteedSepaConfig::GUARANTEED_SEPA_ONHOLD_AMOUNT => $settings->getGuaranteedSepaOnholdAmount(),
           NovalnetGuaranteedSepaConfig::GUARANTEED_SEPA_MIN_AMOUNT => $settings->getGuaranteedSepaMinAmount(),
           NovalnetGuaranteedSepaConfig::GUARANTEED_SEPA_ONECLICK => $settings->getGuaranteedSepaOneclick(),
           NovalnetGuaranteedSepaConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
           NovalnetGuaranteedSepaConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
           NovalnetGuaranteedSepaConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
        ];

        return new NovalnetGuaranteedSepaConfig($params);
    }
}
