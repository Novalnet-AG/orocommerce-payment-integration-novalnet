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
    const ONHOLD_AMOUNT = 'onhold_amount';
    const INVOICE_PAYMENT_GUARANTEE = 'invoice_payment_guarantee';
    const INVOICE_GUARANTEE_MIN_AMOUNT = 'invoice_guarantee_min_amount';
    const INVOICE_FORCE_NON_GUARANTEE = 'invoice_force_non_guarantee';

    /**
     * {@inheritDoc}
     */
    public function getInvoiceDuedate()
    {
        return (string)$this->get(self::INVOICE_DUEDATE);
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
    public function getInvoicePaymentGuarantee()
    {
        return (boolean)$this->get(self::INVOICE_PAYMENT_GUARANTEE);
    }

    /**
     * {@inheritDoc}
     */
    public function getInvoiceGuaranteeMinAmount()
    {
        return (integer)$this->get(self::INVOICE_GUARANTEE_MIN_AMOUNT);
    }

    /**
     * {@inheritDoc}
     */
    public function getInvoiceForceNonGuarantee()
    {
        return (boolean)$this->get(self::INVOICE_FORCE_NON_GUARANTEE);
    }
}
