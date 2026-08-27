<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetMbwayConfig extends NovalnetConfig implements NovalnetMbwayConfigInterface
{
    const ADMIN_LABEL_KEY = 'Mbway';
    const ADMIN_LABEL_SUFFIX = 'MBWAY';
    const MBWAY_TESTMODE = 'mbway_testmode';
    const MBWAY_NOTIFICATION = 'mbway_buyer_notification';

    /**
     * {@inheritDoc}
     */
    public function getTestMode()
    {
        return (int)$this->get(self::MBWAY_TESTMODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getBuyerNotification()
    {
        return (string)$this->get(self::MBWAY_NOTIFICATION);
    }
}