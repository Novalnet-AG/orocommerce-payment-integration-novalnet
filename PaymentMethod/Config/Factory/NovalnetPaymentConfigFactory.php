<?php

namespace Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\Config\Factory;

use Doctrine\Common\Collections\Collection;
use Oro\Bundle\IntegrationBundle\Generator\IntegrationIdentifierGeneratorInterface;
use Oro\Bundle\LocaleBundle\Helper\LocalizationHelper;
use Oro\Bundle\NovalnetPaymentBundle\Entity\NovalnetPaymentSettings;
use Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\Config\NovalnetPaymentConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
class NovalnetPaymentConfigFactory implements NovalnetPaymentConfigFactoryInterface
{
    /**
     * @var LocalizationHelper
     */
    private $localizationHelper;

    /**
     * @var IntegrationIdentifierGeneratorInterface
     */
    private $identifierGenerator;

    /**
     * @param LocalizationHelper                      $localizationHelper
     * @param IntegrationIdentifierGeneratorInterface $identifierGenerator
     */
    public function __construct(
        LocalizationHelper $localizationHelper,
        IntegrationIdentifierGeneratorInterface $identifierGenerator
    ) {
        $this->localizationHelper = $localizationHelper;
        $this->identifierGenerator = $identifierGenerator;
    }

    /**
     * {@inheritDoc}
     */
    public function create(NovalnetPaymentSettings $settings)
    {
        $params = [];
        $channel = $settings->getChannel();

        $params[NovalnetPaymentConfig::LABEL_KEY] = $this->getLocalizedValue($settings->getLabels());
        $params[NovalnetPaymentConfig::SHORT_LABEL_KEY] = $this->getLocalizedValue($settings->getShortLabels());
        $params[NovalnetPaymentConfig::ADMIN_LABEL_KEY] = $channel->getName();
        $params[NovalnetPaymentConfig::PAYMENT_METHOD_IDENTIFIER_KEY] =
            $this->identifierGenerator->generateIdentifier($channel);
        $params[NovalnetPaymentConfig::VENDOR_ID] = $settings->getVendorId();
        $params[NovalnetPaymentConfig::AUTHCODE] = $settings->getAuthcode();
        $params[NovalnetPaymentConfig::PRODUCT] = $settings->getProduct();
        $params[NovalnetPaymentConfig::TARIFF] = $settings->getTariff();
        $params[NovalnetPaymentConfig::PAYMENT_ACCESS_KEY] = $settings->getPaymentAccessKey();
        $params[NovalnetPaymentConfig::REFERRER_ID] = $settings->getReferrerId();
        $params[NovalnetPaymentConfig::TEST_MODE] = $settings->getTestMode();
        $params[NovalnetPaymentConfig::ONHOLD_AMOUNT] = $settings->getOnholdAmount();
        $params[NovalnetPaymentConfig::GATEWAY_TIMEOUT] = $settings->getGatewayTimeout();
        $params[NovalnetPaymentConfig::INVOICE_DUEDATE] = $settings->getInvoiceDueDate();
        $params[NovalnetPaymentConfig::SEPA_DUEDATE] = $settings->getSepaDuedate();
        $params[NovalnetPaymentConfig::CASHPAYMENT_DUEDATE] = $settings->getCashpaymentDuedate();
        $params[NovalnetPaymentConfig::CC3D] = $settings->getCc3d();
        $params[NovalnetPaymentConfig::CALLBACK_TESTMODE] = $settings->getCallbackTestmode();
        $params[NovalnetPaymentConfig::EMAIL_NOTIFICATION] = $settings->getEmailNotification();
        $params[NovalnetPaymentConfig::EMAIL_TO] = $settings->getEmailTo();
        $params[NovalnetPaymentConfig::EMAIL_BCC] = $settings->getEmailBcc();
        $params[NovalnetPaymentConfig::NOTIFY_URL] = $settings->getNotifyUrl();

        return new NovalnetPaymentConfig($params);
    }

    /**
     * @param Collection $values
     *
     * @return string
     */
    private function getLocalizedValue(Collection $values)
    {
        return (string)$this->localizationHelper->getLocalizedValue($values);
    }
}
