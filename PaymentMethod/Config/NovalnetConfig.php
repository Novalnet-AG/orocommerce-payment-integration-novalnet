<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

use Oro\Bundle\PaymentBundle\Method\Config\ParameterBag\AbstractParameterBagPaymentConfig;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
abstract class NovalnetConfig extends AbstractParameterBagPaymentConfig implements NovalnetConfigInterface
{
    const VENDOR_ID = 'vendor_id';
    const PRODUCT = 'product';
    const AUTHCODE = 'authcode';
    const TARIFF = 'tariff';
    const PAYMENT_ACCESS_KEY = 'payment_access_key';
    const REFERRER_ID = 'referrer_id';
    const GATEWAY_TIMEOUT = 'gateway_timeout';
    const TEST_MODE = 'test_mode';
    const CALLBACK_TESTMODE = 'callback_testmode';
    const EMAIL_NOTIFICATION = 'email_notification';
    const EMAIL_TO = 'email_to';
    const EMAIL_BCC = 'email_bcc';

    /**
     * {@inheritDoc}
     */
    public function __construct(array $parameters)
    {
        parent::__construct($parameters);
    }

    /**
     * {@inheritDoc}
     */
    public function getVendorId()
    {
        return (string)$this->get(self::VENDOR_ID);
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthcode()
    {
        return (string)$this->get(self::AUTHCODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getTariff()
    {
        return (string)$this->get(self::TARIFF);
    }

    /**
     * {@inheritDoc}
     */
    public function getProduct()
    {
        return (string)$this->get(self::PRODUCT);
    }

    /**
     * {@inheritDoc}
     */
    public function getPaymentAccessKey()
    {
        return (string)$this->get(self::PAYMENT_ACCESS_KEY);
    }

    /**
     * {@inheritDoc}
     */
    public function getReferrerId()
    {
        return (string)$this->get(self::REFERRER_ID);
    }

    /**
     * {@inheritDoc}
     */
    public function getGatewayTimeout()
    {
        return (string)$this->get(self::GATEWAY_TIMEOUT);
    }

    /**
     * {@inheritDoc}
     */
    public function getTestMode()
    {
        return (string)$this->get(self::TEST_MODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getCallbackTestmode()
    {
        return (string)$this->get(self::CALLBACK_TESTMODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getEmailNotification()
    {
        return (string)$this->get(self::EMAIL_NOTIFICATION);
    }

    /**
     * {@inheritDoc}
     */
    public function getEmailTo()
    {
        return (string)$this->get(self::EMAIL_TO);
    }

    /**
     * {@inheritDoc}
     */
    public function getEmailBcc()
    {
        return (string)$this->get(self::EMAIL_BCC);
    }
}
