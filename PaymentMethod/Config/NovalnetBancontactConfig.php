<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetBancontactConfig extends NovalnetConfig implements NovalnetBancontactConfigInterface
{
    const ADMIN_LABEL_KEY = 'Bancontact';
    const ADMIN_LABEL_SUFFIX = 'BANCONTACT';
    const BANCONTACT_TESTMODE = 'bancontact_testmode';
    const BANCONTACT_NOTIFICATION = 'bancontact_buyer_notification';

    /**
     * {@inheritDoc}
     */
    public function getTestMode()
    {
        return (int)$this->get(self::BANCONTACT_TESTMODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getBuyerNotification()
    {
        return (string)$this->get(self::BANCONTACT_NOTIFICATION);
    }
}
