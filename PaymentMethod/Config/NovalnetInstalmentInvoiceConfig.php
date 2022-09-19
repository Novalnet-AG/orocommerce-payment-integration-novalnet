<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetInstalmentInvoiceConfig extends NovalnetConfig implements NovalnetInstalmentInvoiceConfigInterface
{
    const ADMIN_LABEL_KEY = 'InstalmentInvoice';
    const ADMIN_LABEL_SUFFIX = 'INSTALMENT BY INVOICE';

    const INSTALMENT_INVOICE_TESTMODE = 'instalment_invoice_testmode';
    const INSTALMENT_INVOICE_NOTIFICATION = 'instalment_invoice_buyer_notification';
    const INSTALMENT_INVOICE_MIN_AMOUNT = 'instalment_invoice_min_amount';
    const INSTALMENT_INVOICE_PAYMENT_ACTION = 'instalment_invoice_payment_action';
    const INSTALMENT_INVOICE_ONHOLD_AMOUNT = 'instalment_invoice_onhold_amount';
    const INSTALMENT_INVOICE_CYCLE = 'instalment_invoice_cycle';

    /**
     * {@inheritDoc}
     */
    public function getTestMode()
    {
        return (int)$this->get(self::INSTALMENT_INVOICE_TESTMODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getBuyerNotification()
    {
        return (string)$this->get(self::INSTALMENT_INVOICE_NOTIFICATION);
    }

    /**
     * {@inheritDoc}
     */
    public function getMinAmount()
    {
        return (int)$this->get(self::INSTALMENT_INVOICE_MIN_AMOUNT);
    }

    /**
     * {@inheritDoc}
     */
    public function getPaymentAction()
    {
        return (string)$this->get(self::INSTALMENT_INVOICE_PAYMENT_ACTION);
    }

    /**
     * {@inheritDoc}
     */
    public function getOnholdAmount()
    {
        return (int)$this->get(self::INSTALMENT_INVOICE_ONHOLD_AMOUNT);
    }

    /**
     * {@inheritDoc}
     */
    public function getInstalmentCycle()
    {
        return (array)$this->get(self::INSTALMENT_INVOICE_CYCLE);
    }
}
