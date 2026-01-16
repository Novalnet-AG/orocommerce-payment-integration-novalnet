<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetAchConfig extends NovalnetConfig implements NovalnetAchConfigInterface
{
    const ADMIN_LABEL_KEY = 'ACH';
    const ADMIN_LABEL_SUFFIX = 'ACH';
    const ACH_TESTMODE = 'ach_testmode';
    const ACH_NOTIFICATION = 'ach_buyer_notification';
    const ACH_ONECLICK = 'ach_oneclick';

    /**
     * {@inheritDoc}
     */
    public function getTestMode()
    {
        return (int)$this->get(self::ACH_TESTMODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getBuyerNotification()
    {
        return (string)$this->get(self::ACH_NOTIFICATION);
    }

    /**
     * {@inheritDoc}
     */
    public function getOneclick()
    {
        return (bool)$this->get(self::ACH_ONECLICK);
    }
}
