<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Doctrine\Common\Collections\Collection;
use Oro\Bundle\IntegrationBundle\Generator\IntegrationIdentifierGeneratorInterface;
use Oro\Bundle\LocaleBundle\Helper\LocalizationHelper;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPrepaymentConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetPrepaymentConfigFactory extends NovalnetConfigFactory implements NovalnetPrepaymentConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $params = [];
        $channel = $settings->getChannel();

        $params[NovalnetPrepaymentConfig::FIELD_PAYMENT_METHOD_IDENTIFIER] = $this->getPaymentMethodIdentifier($channel);
        $params[NovalnetPrepaymentConfig::FIELD_ADMIN_LABEL] = $this->getAdminLabel($channel, NovalnetPrepaymentConfig::ADMIN_LABEL_SUFFIX);
        $params[NovalnetPrepaymentConfig::FIELD_LABEL] = $this->getLocalizedValue($settings->getPrepaymentLabels());
        $params[NovalnetPrepaymentConfig::FIELD_SHORT_LABEL] = $this->getLocalizedValue($settings->getPrepaymentShortLabels());
        $params[NovalnetPrepaymentConfig::VENDOR_ID] = $settings->getVendorId();
        $params[NovalnetPrepaymentConfig::AUTHCODE] = $settings->getAuthcode();
        $params[NovalnetPrepaymentConfig::PRODUCT] = $settings->getProduct();
        $params[NovalnetPrepaymentConfig::TARIFF] = $settings->getTariff();
        $params[NovalnetPrepaymentConfig::PAYMENT_ACCESS_KEY] = $settings->getPaymentAccessKey();
        $params[NovalnetPrepaymentConfig::REFERRER_ID] = $settings->getReferrerId();
        $params[NovalnetPrepaymentConfig::TEST_MODE] = $settings->getTestMode();
        $params[NovalnetPrepaymentConfig::GATEWAY_TIMEOUT] = $settings->getGatewayTimeout();

        return new NovalnetPrepaymentConfig($params);
    }
}
