<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetSepaConfig extends NovalnetConfig implements NovalnetSepaConfigInterface
{
    const ADMIN_LABEL_KEY = 'Sepa';
    const ADMIN_LABEL_SUFFIX = 'DIRECT DEBIT SEPA';
    const SEPA_DUEDATE = 'sepa_duedate';
    const ONHOLD_AMOUNT = 'onhold_amount';
    const SEPA_PAYMENT_GUARANTEE = 'invoice_payment_guarantee';
    const SEPA_GUARANTEE_MIN_AMOUNT = 'invoice_guarantee_min_amount';
    const SEPA_FORCE_NON_GUARANTEE = 'invoice_force_non_guarantee';

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
    public function getOnholdAmount()
    {
        return (string)$this->get(self::ONHOLD_AMOUNT);
    }

    /**
     * {@inheritDoc}
     */
    public function getSepaPaymentGuarantee()
    {
        return (boolean)$this->get(self::SEPA_PAYMENT_GUARANTEE);
    }

    /**
     * {@inheritDoc}
     */
    public function getSepaGuaranteeMinAmount()
    {
        return (integer)$this->get(self::SEPA_GUARANTEE_MIN_AMOUNT);
    }

    /**
     * {@inheritDoc}
     */
    public function getSepaForceNonGuarantee()
    {
        return (boolean)$this->get(self::SEPA_FORCE_NON_GUARANTEE);
    }
}
