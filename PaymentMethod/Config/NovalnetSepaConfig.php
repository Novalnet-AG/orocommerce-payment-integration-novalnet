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
    const SEPA_TESTMODE = 'sepa_testmode';
    const SEPA_ONHOLD_AMOUNT = 'sepa_onhold_amount';
    const SEPA_PAYMENT_ACTION = 'sepa_payment_action';
    const SEPA_NOTIFICATION = 'sepa_buyer_notification';
    const GUARANTEED_SEPA_MIN_AMOUNT = 'guaranteed_sepa_min_amount';
    const SEPA_ONECLICK = 'sepa_oneclick';

    /**
     * {@inheritDoc}
     */
    public function getDuedate()
    {
        return (string)$this->get(self::SEPA_DUEDATE);
    }

    /**
     * {@inheritDoc}
     */
    public function getTestMode()
    {
        return (int)$this->get(self::SEPA_TESTMODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getOnholdAmount()
    {
        return (int)$this->get(self::SEPA_ONHOLD_AMOUNT);
    }

    /**
     * {@inheritDoc}
     */
    public function getPaymentAction()
    {
        return (string)$this->get(self::SEPA_PAYMENT_ACTION);
    }

    /**
     * {@inheritDoc}
     */
    public function getBuyerNotification()
    {
        return (string)$this->get(self::SEPA_NOTIFICATION);
    }

    /**
     * {@inheritDoc}
     */
    public function getOneclick()
    {
        return (int)$this->get(self::SEPA_ONECLICK);
    }

    /**
     * {@inheritDoc}
     */
    public function getMinAmount()
    {
        return (int)$this->get(self::GUARANTEED_SEPA_MIN_AMOUNT);
    }
}
