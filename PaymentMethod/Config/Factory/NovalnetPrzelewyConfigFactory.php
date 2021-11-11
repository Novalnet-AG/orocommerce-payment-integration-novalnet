<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Doctrine\Common\Collections\Collection;
use Oro\Bundle\IntegrationBundle\Generator\IntegrationIdentifierGeneratorInterface;
use Oro\Bundle\LocaleBundle\Helper\LocalizationHelper;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPrzelewyConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetPrzelewyConfigFactory extends NovalnetConfigFactory implements NovalnetPrzelewyConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $params = [];
        $channel = $settings->getChannel();

        $params[NovalnetPrzelewyConfig::FIELD_PAYMENT_METHOD_IDENTIFIER] = $this->getPaymentMethodIdentifier($channel);
        $params[NovalnetPrzelewyConfig::FIELD_ADMIN_LABEL] = $this->getAdminLabel($channel, NovalnetPrzelewyConfig::ADMIN_LABEL_SUFFIX);
        $params[NovalnetPrzelewyConfig::FIELD_LABEL] = $this->getLocalizedValue($settings->getPrzelewyLabels());
        $params[NovalnetPrzelewyConfig::FIELD_SHORT_LABEL] = $this->getLocalizedValue($settings->getPrzelewyShortLabels());
        $params[NovalnetPrzelewyConfig::VENDOR_ID] = $settings->getVendorId();
        $params[NovalnetPrzelewyConfig::AUTHCODE] = $settings->getAuthcode();
        $params[NovalnetPrzelewyConfig::PRODUCT] = $settings->getProduct();
        $params[NovalnetPrzelewyConfig::TARIFF] = $settings->getTariff();
        $params[NovalnetPrzelewyConfig::PAYMENT_ACCESS_KEY] = $settings->getPaymentAccessKey();
        $params[NovalnetPrzelewyConfig::REFERRER_ID] = $settings->getReferrerId();
        $params[NovalnetPrzelewyConfig::TEST_MODE] = $settings->getTestMode();
        $params[NovalnetPrzelewyConfig::GATEWAY_TIMEOUT] = $settings->getGatewayTimeout();
        $params[NovalnetPrzelewyConfig::CALLBACK_TESTMODE] = $settings->getCallbackTestmode();
        $params[NovalnetPrzelewyConfig::EMAIL_NOTIFICATION] = $settings->getEmailNotification();
        $params[NovalnetPrzelewyConfig::EMAIL_TO] = $settings->getEmailTo();
        $params[NovalnetPrzelewyConfig::EMAIL_BCC] = $settings->getEmailBcc();

        return new NovalnetPrzelewyConfig($params);
    }
}
