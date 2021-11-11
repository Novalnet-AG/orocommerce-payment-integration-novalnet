<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Doctrine\Common\Collections\Collection;
use Oro\Bundle\IntegrationBundle\Generator\IntegrationIdentifierGeneratorInterface;
use Oro\Bundle\LocaleBundle\Helper\LocalizationHelper;
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
        $params = [];
        $channel = $settings->getChannel();

        $params[NovalnetSepaConfig::FIELD_PAYMENT_METHOD_IDENTIFIER] = $this->getPaymentMethodIdentifier($channel);
        $params[NovalnetSepaConfig::FIELD_ADMIN_LABEL] = $this->getAdminLabel($channel, NovalnetSepaConfig::ADMIN_LABEL_SUFFIX);
        $params[NovalnetSepaConfig::FIELD_LABEL] = $this->getLocalizedValue($settings->getSepaLabels());
        $params[NovalnetSepaConfig::FIELD_SHORT_LABEL] = $this->getLocalizedValue($settings->getSepaShortLabels());
        $params[NovalnetSepaConfig::VENDOR_ID] = $settings->getVendorId();
        $params[NovalnetSepaConfig::AUTHCODE] = $settings->getAuthcode();
        $params[NovalnetSepaConfig::PRODUCT] = $settings->getProduct();
        $params[NovalnetSepaConfig::TARIFF] = $settings->getTariff();
        $params[NovalnetSepaConfig::PAYMENT_ACCESS_KEY] = $settings->getPaymentAccessKey();
        $params[NovalnetSepaConfig::REFERRER_ID] = $settings->getReferrerId();
        $params[NovalnetSepaConfig::TEST_MODE] = $settings->getTestMode();
        $params[NovalnetSepaConfig::ONHOLD_AMOUNT] = $settings->getOnholdAmount();
        $params[NovalnetSepaConfig::GATEWAY_TIMEOUT] = $settings->getGatewayTimeout();
        $params[NovalnetSepaConfig::SEPA_DUEDATE] = $settings->getSepaDuedate();
        $params[NovalnetSepaConfig::SEPA_PAYMENT_GUARANTEE] = $settings->getSepaPaymentGuarantee();
        $params[NovalnetSepaConfig::SEPA_GUARANTEE_MIN_AMOUNT] = $settings->getSepaGuaranteeMinAmount();
        $params[NovalnetSepaConfig::SEPA_FORCE_NON_GUARANTEE] = $settings->getSepaForceNonGuarantee();

        return new NovalnetSepaConfig($params);
    }
}
