<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Doctrine\Common\Collections\Collection;
use Oro\Bundle\IntegrationBundle\Generator\IntegrationIdentifierGeneratorInterface;
use Oro\Bundle\LocaleBundle\Helper\LocalizationHelper;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetBanktransferConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetBanktransferConfigFactory extends NovalnetConfigFactory implements NovalnetBanktransferConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $params = [];
        $channel = $settings->getChannel();

        $params[NovalnetBanktransferConfig::FIELD_PAYMENT_METHOD_IDENTIFIER] = $this->getPaymentMethodIdentifier($channel);
        $params[NovalnetBanktransferConfig::FIELD_ADMIN_LABEL] = $this->getAdminLabel($channel, NovalnetBanktransferConfig::ADMIN_LABEL_SUFFIX);
        $params[NovalnetBanktransferConfig::FIELD_LABEL] = $this->getLocalizedValue($settings->getBanktransferLabels());
        $params[NovalnetBanktransferConfig::FIELD_SHORT_LABEL] = $this->getLocalizedValue($settings->getBanktransferShortLabels());
        $params[NovalnetBanktransferConfig::VENDOR_ID] = $settings->getVendorId();
        $params[NovalnetBanktransferConfig::AUTHCODE] = $settings->getAuthcode();
        $params[NovalnetBanktransferConfig::PRODUCT] = $settings->getProduct();
        $params[NovalnetBanktransferConfig::TARIFF] = $settings->getTariff();
        $params[NovalnetBanktransferConfig::PAYMENT_ACCESS_KEY] = $settings->getPaymentAccessKey();
        $params[NovalnetBanktransferConfig::REFERRER_ID] = $settings->getReferrerId();
        $params[NovalnetBanktransferConfig::TEST_MODE] = $settings->getTestMode();
        $params[NovalnetBanktransferConfig::GATEWAY_TIMEOUT] = $settings->getGatewayTimeout();
        $params[NovalnetBanktransferConfig::CALLBACK_TESTMODE] = $settings->getCallbackTestmode();
        $params[NovalnetBanktransferConfig::EMAIL_NOTIFICATION] = $settings->getEmailNotification();
        $params[NovalnetBanktransferConfig::EMAIL_TO] = $settings->getEmailTo();
        $params[NovalnetBanktransferConfig::EMAIL_BCC] = $settings->getEmailBcc();

        return new NovalnetBanktransferConfig($params);
    }
}
