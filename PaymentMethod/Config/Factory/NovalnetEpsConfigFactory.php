<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Doctrine\Common\Collections\Collection;
use Oro\Bundle\IntegrationBundle\Generator\IntegrationIdentifierGeneratorInterface;
use Oro\Bundle\LocaleBundle\Helper\LocalizationHelper;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetEpsConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetEpsConfigFactory extends NovalnetConfigFactory implements NovalnetEpsConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $params = [];
        $channel = $settings->getChannel();

        $params[NovalnetEpsConfig::FIELD_PAYMENT_METHOD_IDENTIFIER] = $this->getPaymentMethodIdentifier($channel);
        $params[NovalnetEpsConfig::FIELD_ADMIN_LABEL] = $this->getAdminLabel($channel, NovalnetEpsConfig::ADMIN_LABEL_SUFFIX);
        $params[NovalnetEpsConfig::FIELD_LABEL] = $this->getLocalizedValue($settings->getEpsLabels());
        $params[NovalnetEpsConfig::FIELD_SHORT_LABEL] = $this->getLocalizedValue($settings->getEpsShortLabels());
        $params[NovalnetEpsConfig::VENDOR_ID] = $settings->getVendorId();
        $params[NovalnetEpsConfig::AUTHCODE] = $settings->getAuthcode();
        $params[NovalnetEpsConfig::PRODUCT] = $settings->getProduct();
        $params[NovalnetEpsConfig::TARIFF] = $settings->getTariff();
        $params[NovalnetEpsConfig::PAYMENT_ACCESS_KEY] = $settings->getPaymentAccessKey();
        $params[NovalnetEpsConfig::REFERRER_ID] = $settings->getReferrerId();
        $params[NovalnetEpsConfig::TEST_MODE] = $settings->getTestMode();
        $params[NovalnetEpsConfig::GATEWAY_TIMEOUT] = $settings->getGatewayTimeout();
        $params[NovalnetEpsConfig::CALLBACK_TESTMODE] = $settings->getCallbackTestmode();
        $params[NovalnetEpsConfig::EMAIL_NOTIFICATION] = $settings->getEmailNotification();
        $params[NovalnetEpsConfig::EMAIL_TO] = $settings->getEmailTo();
        $params[NovalnetEpsConfig::EMAIL_BCC] = $settings->getEmailBcc();

        return new NovalnetEpsConfig($params);
    }
}
