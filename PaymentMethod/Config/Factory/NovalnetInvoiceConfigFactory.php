<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Doctrine\Common\Collections\Collection;
use Oro\Bundle\IntegrationBundle\Generator\IntegrationIdentifierGeneratorInterface;
use Oro\Bundle\LocaleBundle\Helper\LocalizationHelper;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetInvoiceConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetInvoiceConfigFactory extends NovalnetConfigFactory implements NovalnetInvoiceConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $params = [];
        $channel = $settings->getChannel();

        $params[NovalnetInvoiceConfig::FIELD_PAYMENT_METHOD_IDENTIFIER] = $this->getPaymentMethodIdentifier($channel);
        $params[NovalnetInvoiceConfig::FIELD_ADMIN_LABEL] = $this->getAdminLabel($channel, NovalnetInvoiceConfig::ADMIN_LABEL_SUFFIX);
        $params[NovalnetInvoiceConfig::FIELD_LABEL] = $this->getLocalizedValue($settings->getInvoiceLabels());
        $params[NovalnetInvoiceConfig::FIELD_SHORT_LABEL] = $this->getLocalizedValue($settings->getInvoiceShortLabels());
        $params[NovalnetInvoiceConfig::VENDOR_ID] = $settings->getVendorId();
        $params[NovalnetInvoiceConfig::AUTHCODE] = $settings->getAuthcode();
        $params[NovalnetInvoiceConfig::PRODUCT] = $settings->getProduct();
        $params[NovalnetInvoiceConfig::TARIFF] = $settings->getTariff();
        $params[NovalnetInvoiceConfig::PAYMENT_ACCESS_KEY] = $settings->getPaymentAccessKey();
        $params[NovalnetInvoiceConfig::REFERRER_ID] = $settings->getReferrerId();
        $params[NovalnetInvoiceConfig::TEST_MODE] = $settings->getTestMode();
        $params[NovalnetInvoiceConfig::ONHOLD_AMOUNT] = $settings->getOnholdAmount();
        $params[NovalnetInvoiceConfig::GATEWAY_TIMEOUT] = $settings->getGatewayTimeout();
        $params[NovalnetInvoiceConfig::INVOICE_DUEDATE] = $settings->getInvoiceDuedate();
        $params[NovalnetInvoiceConfig::INVOICE_PAYMENT_GUARANTEE] = $settings->getInvoicePaymentGuarantee();
        $params[NovalnetInvoiceConfig::INVOICE_GUARANTEE_MIN_AMOUNT] = $settings->getInvoiceGuaranteeMinAmount();
        $params[NovalnetInvoiceConfig::INVOICE_FORCE_NON_GUARANTEE] = $settings->getInvoiceForceNonGuarantee();

        return new NovalnetInvoiceConfig($params);
    }
}
