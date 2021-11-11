<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Doctrine\Common\Collections\Collection;
use Oro\Bundle\IntegrationBundle\Generator\IntegrationIdentifierGeneratorInterface;
use Oro\Bundle\LocaleBundle\Helper\LocalizationHelper;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetGiropayConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetGiropayConfigFactory extends NovalnetConfigFactory implements NovalnetGiropayConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $params = [];
        $channel = $settings->getChannel();

        $params[NovalnetGiropayConfig::FIELD_PAYMENT_METHOD_IDENTIFIER] = $this->getPaymentMethodIdentifier($channel);
        $params[NovalnetGiropayConfig::FIELD_ADMIN_LABEL] = $this->getAdminLabel($channel, NovalnetGiropayConfig::ADMIN_LABEL_SUFFIX);
        $params[NovalnetGiropayConfig::FIELD_LABEL] = $this->getLocalizedValue($settings->getGiropayLabels());
        $params[NovalnetGiropayConfig::FIELD_SHORT_LABEL] = $this->getLocalizedValue($settings->getGiropayShortLabels());
        $params[NovalnetGiropayConfig::VENDOR_ID] = $settings->getVendorId();
        $params[NovalnetGiropayConfig::AUTHCODE] = $settings->getAuthcode();
        $params[NovalnetGiropayConfig::PRODUCT] = $settings->getProduct();
        $params[NovalnetGiropayConfig::TARIFF] = $settings->getTariff();
        $params[NovalnetGiropayConfig::PAYMENT_ACCESS_KEY] = $settings->getPaymentAccessKey();
        $params[NovalnetGiropayConfig::REFERRER_ID] = $settings->getReferrerId();
        $params[NovalnetGiropayConfig::TEST_MODE] = $settings->getTestMode();
        $params[NovalnetGiropayConfig::GATEWAY_TIMEOUT] = $settings->getGatewayTimeout();

        return new NovalnetGiropayConfig($params);
    }
}
