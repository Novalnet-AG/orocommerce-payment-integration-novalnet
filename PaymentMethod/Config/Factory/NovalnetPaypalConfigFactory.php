<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Doctrine\Common\Collections\Collection;
use Oro\Bundle\IntegrationBundle\Generator\IntegrationIdentifierGeneratorInterface;
use Oro\Bundle\LocaleBundle\Helper\LocalizationHelper;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPaypalConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetPaypalConfigFactory extends NovalnetConfigFactory implements NovalnetPaypalConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $params = [];
        $channel = $settings->getChannel();

        $params[NovalnetPaypalConfig::FIELD_PAYMENT_METHOD_IDENTIFIER] = $this->getPaymentMethodIdentifier($channel);
        $params[NovalnetPaypalConfig::FIELD_ADMIN_LABEL] = $this->getAdminLabel($channel, NovalnetPaypalConfig::ADMIN_LABEL_SUFFIX);
        $params[NovalnetPaypalConfig::FIELD_LABEL] = $this->getLocalizedValue($settings->getPaypalLabels());
        $params[NovalnetPaypalConfig::FIELD_SHORT_LABEL] = $this->getLocalizedValue($settings->getPaypalShortLabels());
        $params[NovalnetPaypalConfig::VENDOR_ID] = $settings->getVendorId();
        $params[NovalnetPaypalConfig::AUTHCODE] = $settings->getAuthcode();
        $params[NovalnetPaypalConfig::PRODUCT] = $settings->getProduct();
        $params[NovalnetPaypalConfig::TARIFF] = $settings->getTariff();
        $params[NovalnetPaypalConfig::PAYMENT_ACCESS_KEY] = $settings->getPaymentAccessKey();
        $params[NovalnetPaypalConfig::REFERRER_ID] = $settings->getReferrerId();
        $params[NovalnetPaypalConfig::TEST_MODE] = $settings->getTestMode();
        $params[NovalnetPaypalConfig::ONHOLD_AMOUNT] = $settings->getOnholdAmount();
        $params[NovalnetPaypalConfig::GATEWAY_TIMEOUT] = $settings->getGatewayTimeout();
        $params[NovalnetPaypalConfig::CALLBACK_TESTMODE] = $settings->getCallbackTestmode();
        $params[NovalnetPaypalConfig::EMAIL_NOTIFICATION] = $settings->getEmailNotification();
        $params[NovalnetPaypalConfig::EMAIL_TO] = $settings->getEmailTo();
        $params[NovalnetPaypalConfig::EMAIL_BCC] = $settings->getEmailBcc();

        return new NovalnetPaypalConfig($params);
    }
}
