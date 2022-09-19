<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetInvoiceConfig extends NovalnetConfig implements NovalnetInvoiceConfigInterface
{
    const ADMIN_LABEL_KEY = 'Invoice';
    const ADMIN_LABEL_SUFFIX = 'INVOICE';
    const INVOICE_DUEDATE = 'invoice_duedate';
    const INVOICE_TESTMODE = 'invoice_testmode';
    const INVOICE_ONHOLD_AMOUNT = 'invoice_onhold_amount';
    const INVOICE_PAYMENT_ACTION = 'invoice_payment_action';
    const INVOICE_NOTIFICATION = 'invoice_buyer_notification';
    const GUARANTEED_INVOICE_MIN_AMOUNT = 'guaranteed_invoice_min_amount';

    /**
     * {@inheritDoc}
     */
    public function getDuedate()
    {
        return (string)$this->get(self::INVOICE_DUEDATE);
    }

    /**
     * {@inheritDoc}
     */
    public function getTestMode()
    {
        return (int)$this->get(self::INVOICE_TESTMODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getOnholdAmount()
    {
        return (int)$this->get(self::INVOICE_ONHOLD_AMOUNT);
    }

    /**
     * {@inheritDoc}
     */
    public function getPaymentAction()
    {
        return (string)$this->get(self::INVOICE_PAYMENT_ACTION);
    }

    /**
     * {@inheritDoc}
     */
    public function getBuyerNotification()
    {
        return (string)$this->get(self::INVOICE_NOTIFICATION);
    }

    /**
     * {@inheritDoc}
     */
    public function getMinAmount()
    {
        return (int)$this->get(self::GUARANTEED_INVOICE_MIN_AMOUNT);
    }
}
