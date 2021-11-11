<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Doctrine\Common\Collections\Collection;
use Oro\Bundle\IntegrationBundle\Generator\IntegrationIdentifierGeneratorInterface;
use Oro\Bundle\LocaleBundle\Helper\LocalizationHelper;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetCreditCardConfig;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetCreditCardConfigFactory extends NovalnetConfigFactory implements NovalnetCreditCardConfigFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createConfig(NovalnetSettings $settings)
    {
        $params = [];
        $channel = $settings->getChannel();

        $params[NovalnetCreditCardConfig::FIELD_PAYMENT_METHOD_IDENTIFIER] = $this->getPaymentMethodIdentifier($channel);
        $params[NovalnetCreditCardConfig::FIELD_ADMIN_LABEL] = $this->getAdminLabel($channel, NovalnetCreditCardConfig::ADMIN_LABEL_SUFFIX);
        $params[NovalnetCreditCardConfig::FIELD_LABEL] = $this->getLocalizedValue($settings->getCreditCardLabels());
        $params[NovalnetCreditCardConfig::FIELD_SHORT_LABEL] = $this->getLocalizedValue($settings->getCreditCardShortLabels());
        $params[NovalnetCreditCardConfig::VENDOR_ID] = $settings->getVendorId();
        $params[NovalnetCreditCardConfig::AUTHCODE] = $settings->getAuthcode();
        $params[NovalnetCreditCardConfig::PRODUCT] = $settings->getProduct();
        $params[NovalnetCreditCardConfig::TARIFF] = $settings->getTariff();
        $params[NovalnetCreditCardConfig::PAYMENT_ACCESS_KEY] = $settings->getPaymentAccessKey();
        $params[NovalnetCreditCardConfig::REFERRER_ID] = $settings->getReferrerId();
        $params[NovalnetCreditCardConfig::TEST_MODE] = $settings->getTestMode();
        $params[NovalnetCreditCardConfig::ONHOLD_AMOUNT] = $settings->getOnholdAmount();
        $params[NovalnetCreditCardConfig::GATEWAY_TIMEOUT] = $settings->getGatewayTimeout();
        $params[NovalnetCreditCardConfig::CC3D] = $settings->getCc3d();
        $params[NovalnetCreditCardConfig::CALLBACK_TESTMODE] = $settings->getCallbackTestmode();
        $params[NovalnetCreditCardConfig::EMAIL_NOTIFICATION] = $settings->getEmailNotification();
        $params[NovalnetCreditCardConfig::EMAIL_TO] = $settings->getEmailTo();
        $params[NovalnetCreditCardConfig::EMAIL_BCC] = $settings->getEmailBcc();

        return new NovalnetCreditCardConfig($params);
    }
}
