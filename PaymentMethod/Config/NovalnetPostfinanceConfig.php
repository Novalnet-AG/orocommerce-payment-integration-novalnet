<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetPostfinanceConfig extends NovalnetConfig implements NovalnetPostfinanceConfigInterface
{
    const ADMIN_LABEL_KEY = 'Postfinance';
    const ADMIN_LABEL_SUFFIX = 'POSTFINANCE';
    const POSTFINANCE_TESTMODE = 'postfinance_testmode';
    const POSTFINANCE_NOTIFICATION = 'postfinance_buyer_notification';

    /**
     * {@inheritDoc}
     */
    public function getTestMode()
    {
        return (int)$this->get(self::POSTFINANCE_TESTMODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getBuyerNotification()
    {
        return (string)$this->get(self::POSTFINANCE_NOTIFICATION);
    }
}
