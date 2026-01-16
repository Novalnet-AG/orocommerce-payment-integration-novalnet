<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetBlikConfig extends NovalnetConfig implements NovalnetBlikConfigInterface
{
    const ADMIN_LABEL_KEY = 'Blik';
    const ADMIN_LABEL_SUFFIX = 'BLIK';
    const BLIK_TESTMODE = 'blik_testmode';
    const BLIK_NOTIFICATION = 'blik_buyer_notification';

    /**
     * {@inheritDoc}
     */
    public function getTestMode()
    {
        return (int)$this->get(self::BLIK_TESTMODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getBuyerNotification()
    {
        return (string)$this->get(self::BLIK_NOTIFICATION);
    }
}