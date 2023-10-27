<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetInstalmentSepaConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetInstalmentSepaConfigFactory extends NovalnetConfigFactory implements
    NovalnetInstalmentSepaConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $channel = $settings->getChannel();
        $params = [
           NovalnetInstalmentSepaConfig::FIELD_PAYMENT_METHOD_IDENTIFIER => $this->getPaymentMethodIdentifier($channel),
           NovalnetInstalmentSepaConfig::FIELD_ADMIN_LABEL =>
              $this->getAdminLabel($channel, NovalnetInstalmentSepaConfig::ADMIN_LABEL_SUFFIX),
           NovalnetInstalmentSepaConfig::FIELD_LABEL => $settings->getInstalmentSepaLabel(),
           NovalnetInstalmentSepaConfig::FIELD_SHORT_LABEL => $settings->getInstalmentSepaShortLabel(),
           NovalnetInstalmentSepaConfig::TARIFF => $settings->getTariff(),
           NovalnetInstalmentSepaConfig::PRODUCT_ACTIVATION_KEY => $settings->getProductActivationKey(),
           NovalnetInstalmentSepaConfig::PAYMENT_ACCESS_KEY => $settings->getPaymentAccessKey(),
           NovalnetInstalmentSepaConfig::INSTALMENT_SEPA_TESTMODE => $settings->getInstalmentSepaTestMode(),
           NovalnetInstalmentSepaConfig::INSTALMENT_SEPA_DUEDATE => $settings->getInstalmentSepaDuedate(),
           NovalnetInstalmentSepaConfig::INSTALMENT_SEPA_MIN_AMOUNT => $settings->getInstalmentSepaMinAmount(),
           NovalnetInstalmentSepaConfig::INSTALMENT_SEPA_PAYMENT_ACTION => $settings->getInstalmentSepaPaymentAction(),
           NovalnetInstalmentSepaConfig::INSTALMENT_SEPA_ONHOLD_AMOUNT => $settings->getInstalmentSepaOnholdAmount(),
           NovalnetInstalmentSepaConfig::INSTALMENT_SEPA_CYCLE => $settings->getInstalmentSepaCycle(),
           NovalnetInstalmentSepaConfig::INSTALMENT_SEPA_NOTIFICATION
              => $settings->getInstalmentSepaBuyerNotification(),
           NovalnetInstalmentSepaConfig::INSTALMENT_SEPA_ONECLICK => $settings->getInstalmentSepaOneclick(),
           NovalnetInstalmentSepaConfig::CALLBACK_TESTMODE => $settings->getCallbackTestMode(),
           NovalnetInstalmentSepaConfig::CALLBACK_EMAILTO => $settings->getCallbackEmailTo(),
           NovalnetInstalmentSepaConfig::DISPLAY_PAYMENT_LOGO => $settings->getDisplayPaymentLogo(),
        ];

        return new NovalnetInstalmentSepaConfig($params);
    }
}
