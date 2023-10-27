<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetGuaranteedInvoiceConfig extends NovalnetConfig implements NovalnetGuaranteedInvoiceConfigInterface
{
    const ADMIN_LABEL_KEY = 'GuaranteedInvoice';
    const ADMIN_LABEL_SUFFIX = 'GUARANTEED INVOICE';
    const GUARANTEED_INVOICE_TESTMODE = 'guaranteed_invoice_testmode';
    const GUARANTEED_INVOICE_NOTIFICATION = 'guaranteed_invoice_buyer_notification';
    const GUARANTEED_INVOICE_PAYMENT_ACTION = 'guaranteed_invoice_payment_action';
    const GUARANTEED_INVOICE_ONHOLD_AMOUNT = 'guaranteed_invoice_onhold_amount';
    const GUARANTEED_INVOICE_MIN_AMOUNT = 'guaranteed_invoice_min_amount';

    /**
     * {@inheritDoc}
     */
    public function getTestMode()
    {
        return (int)$this->get(self::GUARANTEED_INVOICE_TESTMODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getBuyerNotification()
    {
        return (string)$this->get(self::GUARANTEED_INVOICE_NOTIFICATION);
    }

    /**
     * {@inheritDoc}
     */
    public function getOnholdAmount()
    {
        return (int)$this->get(self::GUARANTEED_INVOICE_ONHOLD_AMOUNT);
    }

    /**
     * {@inheritDoc}
     */
    public function getPaymentAction()
    {
        return (string)$this->get(self::GUARANTEED_INVOICE_PAYMENT_ACTION);
    }

    /**
     * {@inheritDoc}
     */
    public function getMinAmount()
    {
        return (int)$this->get(self::GUARANTEED_INVOICE_MIN_AMOUNT);
    }
}
