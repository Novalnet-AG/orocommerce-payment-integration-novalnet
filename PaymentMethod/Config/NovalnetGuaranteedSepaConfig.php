<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetGuaranteedSepaConfig extends NovalnetConfig implements NovalnetGuaranteedSepaConfigInterface
{
    const ADMIN_LABEL_KEY = 'GuaranteedSepa';
    const ADMIN_LABEL_SUFFIX = 'GUARANTEED SEPA';
    const GUARANTEED_SEPA_TESTMODE = 'guaranteed_sepa_testmode';
    const GUARANTEED_SEPA_NOTIFICATION = 'guaranteed_sepa_buyer_notification';
    const GUARANTEED_SEPA_DUEDATE = 'guaranteed_sepa_duedate';
    const GUARANTEED_SEPA_PAYMENT_ACTION = 'guaranteed_sepa_payment_action';
    const GUARANTEED_SEPA_ONHOLD_AMOUNT = 'guaranteed_sepa_onhold_amount';
    const GUARANTEED_SEPA_MIN_AMOUNT = 'guaranteed_sepa_min_amount';
    const GUARANTEED_SEPA_ONECLICK = 'guaranteed_sepa_oneclick';

    /**
     * {@inheritDoc}
     */
    public function getTestMode()
    {
        return (int)$this->get(self::GUARANTEED_SEPA_TESTMODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getBuyerNotification()
    {
        return (string)$this->get(self::GUARANTEED_SEPA_NOTIFICATION);
    }

    /**
     * {@inheritDoc}
     */
    public function getDuedate()
    {
        return (string)$this->get(self::GUARANTEED_SEPA_DUEDATE);
    }

    /**
     * {@inheritDoc}
     */
    public function getOnholdAmount()
    {
        return (int)$this->get(self::GUARANTEED_SEPA_ONHOLD_AMOUNT);
    }

    /**
     * {@inheritDoc}
     */
    public function getPaymentAction()
    {
        return (string)$this->get(self::GUARANTEED_SEPA_PAYMENT_ACTION);
    }

    /**
     * {@inheritDoc}
     */
    public function getMinAmount()
    {
        return (int)$this->get(self::GUARANTEED_SEPA_MIN_AMOUNT);
    }

    /**
     * {@inheritDoc}
     */
    public function getOneclick()
    {
        return (string)$this->get(self::GUARANTEED_SEPA_ONECLICK);
    }
}
