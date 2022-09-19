<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetInstalmentSepaConfig extends NovalnetConfig implements NovalnetInstalmentSepaConfigInterface
{
    const ADMIN_LABEL_KEY = 'InstalmentSepa';
    const ADMIN_LABEL_SUFFIX = 'INSTALMENT BY SEPA';

    const INSTALMENT_SEPA_TESTMODE = 'instalment_sepa_testmode';
    const INSTALMENT_SEPA_NOTIFICATION = 'instalment_sepa_buyer_notification';
    const INSTALMENT_SEPA_DUEDATE = 'instalment_sepa_duedate';
    const INSTALMENT_SEPA_MIN_AMOUNT = 'instalment_sepa_min_amount';
    const INSTALMENT_SEPA_PAYMENT_ACTION = 'instalment_sepa_payment_action';
    const INSTALMENT_SEPA_ONHOLD_AMOUNT = 'instalment_sepa_onhold_amount';
    const INSTALMENT_SEPA_CYCLE = 'instalment_sepa_cycle';
    const INSTALMENT_SEPA_ONECLICK = 'instalment_oneclick';

    /**
     * {@inheritDoc}
     */
    public function getTestMode()
    {
        return (int)$this->get(self::INSTALMENT_SEPA_TESTMODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getBuyerNotification()
    {
        return (string)$this->get(self::INSTALMENT_SEPA_NOTIFICATION);
    }

    /**
     * {@inheritDoc}
     */
    public function getDuedate()
    {
        return (string)$this->get(self::INSTALMENT_SEPA_DUEDATE);
    }

    /**
     * {@inheritDoc}
     */
    public function getMinAmount()
    {
        return (int)$this->get(self::INSTALMENT_SEPA_MIN_AMOUNT);
    }

    /**
     * {@inheritDoc}
     */
    public function getPaymentAction()
    {
        return (string)$this->get(self::INSTALMENT_SEPA_PAYMENT_ACTION);
    }

    /**
     * {@inheritDoc}
     */
    public function getOnholdAmount()
    {
        return (int)$this->get(self::INSTALMENT_SEPA_ONHOLD_AMOUNT);
    }

    /**
     * {@inheritDoc}
     */
    public function getInstalmentCycle()
    {
        return (array)$this->get(self::INSTALMENT_SEPA_CYCLE);
    }

    /**
     * {@inheritDoc}
     */
    public function getOneclick()
    {
        return (int)$this->get(self::INSTALMENT_SEPA_ONECLICK);
    }
}
