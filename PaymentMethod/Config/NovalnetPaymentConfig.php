<?php

namespace Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\Config;

use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetPaymentConfig extends ParameterBag implements NovalnetPaymentConfigInterface
{
    const LABEL_KEY = 'label';
    const SHORT_LABEL_KEY = 'short_label';
    const ADMIN_LABEL_KEY = 'admin_label';
    const PAYMENT_METHOD_IDENTIFIER_KEY = 'payment_method_identifier';
    const VENDOR_ID = 'vendor_id';
    const PRODUCT = 'product';
    const AUTHCODE = 'authcode';
    const TARIFF = 'tariff';
    const PAYMENT_ACCESS_KEY = 'payment_access_key';
    const REFERRER_ID = 'referrer_id';
    const GATEWAY_TIMEOUT = 'referrer_id';
    const TEST_MODE = 'test_mode';
    const INVOICE_DUEDATE = 'invoice_duedate';
    const SEPA_DUEDATE = 'sepa_duedate';
    const CASHPAYMENT_DUEDATE = 'cashpayment_duedate';
    const CC3D = '33_cd';
    const ONHOLD_AMOUNT = 'onhold_amount';
    const CALLBACK_TESTMODE = 'callback_testmode';
    const EMAIL_NOTIFICATION = 'email_notification';
    const EMAIL_TO = 'email_to';
    const EMAIL_BCC = 'email_bcc';
    const NOTIFY_URL = 'notify_url';

    /**
     * {@inheritDoc}
     */
    public function __construct(array $parameters)
    {
        parent::__construct($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return (string)$this->get(self::LABEL_KEY);
    }

    /**
     * {@inheritdoc}
     */
    public function getShortLabel()
    {
        return (string)$this->get(self::SHORT_LABEL_KEY);
    }

    /** {@inheritdoc} */
    public function getAdminLabel()
    {
        return (string)$this->get(self::ADMIN_LABEL_KEY);
    }

    /** {@inheritdoc} */
    public function getPaymentMethodIdentifier()
    {
        return (string)$this->get(self::PAYMENT_METHOD_IDENTIFIER_KEY);
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
    public function getInvoiceDueDate()
    {
        return (string)$this->get(self::INVOICE_DUEDATE);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getSepaDuedate()
    {
        return (string)$this->get(self::SEPA_DUEDATE);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getCashpaymentDuedate()
    {
        return (string)$this->get(self::CASHPAYMENT_DUEDATE);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getCc3d()
    {
        return (string)$this->get(self::CC3D);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOnholdAmount()
    {
        return (string)$this->get(self::ONHOLD_AMOUNT);
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

    /**
     * {@inheritDoc}
     */
    public function getNotifyUrl()
    {
        return (string)$this->get(self::NOTIFY_URL);
    }
}
