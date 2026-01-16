<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetPrepaymentConfig extends NovalnetConfig implements NovalnetPrepaymentConfigInterface
{
    const ADMIN_LABEL_KEY = 'Prepayment';
    const ADMIN_LABEL_SUFFIX = 'PREPAYMENT';
    const PREPAYMENT_TESTMODE = 'prepayment_testmode';
    const PREPAYMENT_NOTIFICATION = 'prepayment_buyer_notification';
    const PREPAYMENT_DUEDATE = 'prepayment_duedate';

    /**
     * {@inheritDoc}
     */
    public function getTestMode()
    {
        return (int)$this->get(self::PREPAYMENT_TESTMODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getBuyerNotification()
    {
        return (string)$this->get(self::PREPAYMENT_NOTIFICATION);
    }

    /**
     * {@inheritDoc}
     */
    public function getDuedate()
    {
        return (string)$this->get(self::PREPAYMENT_DUEDATE);
    }
}
