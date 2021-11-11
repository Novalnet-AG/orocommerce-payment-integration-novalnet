<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Doctrine\Common\Collections\Collection;
use Oro\Bundle\IntegrationBundle\Generator\IntegrationIdentifierGeneratorInterface;
use Oro\Bundle\LocaleBundle\Helper\LocalizationHelper;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetCashpaymentConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetCashpaymentConfigFactory extends NovalnetConfigFactory implements NovalnetCashpaymentConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $params = [];
        $channel = $settings->getChannel();

        $params[NovalnetCashpaymentConfig::FIELD_PAYMENT_METHOD_IDENTIFIER] = $this->getPaymentMethodIdentifier($channel);
        $params[NovalnetCashpaymentConfig::FIELD_ADMIN_LABEL] = $this->getAdminLabel($channel, NovalnetCashpaymentConfig::ADMIN_LABEL_SUFFIX);
        $params[NovalnetCashpaymentConfig::FIELD_LABEL] = $this->getLocalizedValue($settings->getCashpaymentLabels());
        $params[NovalnetCashpaymentConfig::FIELD_SHORT_LABEL] = $this->getLocalizedValue($settings->getCashpaymentShortLabels());
        $params[NovalnetCashpaymentConfig::VENDOR_ID] = $settings->getVendorId();
        $params[NovalnetCashpaymentConfig::AUTHCODE] = $settings->getAuthcode();
        $params[NovalnetCashpaymentConfig::PRODUCT] = $settings->getProduct();
        $params[NovalnetCashpaymentConfig::TARIFF] = $settings->getTariff();
        $params[NovalnetCashpaymentConfig::PAYMENT_ACCESS_KEY] = $settings->getPaymentAccessKey();
        $params[NovalnetCashpaymentConfig::REFERRER_ID] = $settings->getReferrerId();
        $params[NovalnetCashpaymentConfig::TEST_MODE] = $settings->getTestMode();
        $params[NovalnetCashpaymentConfig::GATEWAY_TIMEOUT] = $settings->getGatewayTimeout();
        $params[NovalnetCashpaymentConfig::CASHPAYMENT_DUEDATE] = $settings->getCashpaymentDuedate();

        return new NovalnetCashpaymentConfig($params);
    }
}
