<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetTwintConfig extends NovalnetConfig implements NovalnetTwintConfigInterface
{
    const ADMIN_LABEL_KEY = 'Twint';
    const ADMIN_LABEL_SUFFIX = 'TWINT';
    const TWINT_TESTMODE = 'twint_testmode';
    const TWINT_NOTIFICATION = 'twint_buyer_notification';

    /**
     * {@inheritDoc}
     */
    public function getTestMode()
    {
        return (int)$this->get(self::TWINT_TESTMODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getBuyerNotification()
    {
        return (string)$this->get(self::TWINT_NOTIFICATION);
    }
}