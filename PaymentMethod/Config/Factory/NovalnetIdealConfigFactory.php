<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Doctrine\Common\Collections\Collection;
use Oro\Bundle\IntegrationBundle\Generator\IntegrationIdentifierGeneratorInterface;
use Oro\Bundle\LocaleBundle\Helper\LocalizationHelper;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetIdealConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetIdealConfigFactory extends NovalnetConfigFactory implements NovalnetIdealConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $params = [];
        $channel = $settings->getChannel();

        $params[NovalnetIdealConfig::FIELD_PAYMENT_METHOD_IDENTIFIER] = $this->getPaymentMethodIdentifier($channel);
        $params[NovalnetIdealConfig::FIELD_ADMIN_LABEL] = $this->getAdminLabel($channel, NovalnetIdealConfig::ADMIN_LABEL_SUFFIX);
        $params[NovalnetIdealConfig::FIELD_LABEL] = $this->getLocalizedValue($settings->getIdealLabels());
        $params[NovalnetIdealConfig::FIELD_SHORT_LABEL] = $this->getLocalizedValue($settings->getIdealShortLabels());
        $params[NovalnetIdealConfig::VENDOR_ID] = $settings->getVendorId();
        $params[NovalnetIdealConfig::AUTHCODE] = $settings->getAuthcode();
        $params[NovalnetIdealConfig::PRODUCT] = $settings->getProduct();
        $params[NovalnetIdealConfig::TARIFF] = $settings->getTariff();
        $params[NovalnetIdealConfig::PAYMENT_ACCESS_KEY] = $settings->getPaymentAccessKey();
        $params[NovalnetIdealConfig::REFERRER_ID] = $settings->getReferrerId();
        $params[NovalnetIdealConfig::TEST_MODE] = $settings->getTestMode();
        $params[NovalnetIdealConfig::GATEWAY_TIMEOUT] = $settings->getGatewayTimeout();

        return new NovalnetIdealConfig($params);
    }
}
