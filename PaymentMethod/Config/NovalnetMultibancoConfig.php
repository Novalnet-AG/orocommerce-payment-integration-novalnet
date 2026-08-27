<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetMultibancoConfig extends NovalnetConfig implements NovalnetMultibancoConfigInterface
{
    const ADMIN_LABEL_KEY = 'Multibanco';
    const ADMIN_LABEL_SUFFIX = 'MULTIBANCO';
    const MULTIBANCO_TESTMODE = 'multibanco_testmode';
    const MULTIBANCO_NOTIFICATION = 'multibanco_buyer_notification';

    /**
     * {@inheritDoc}
     */
    public function getTestMode()
    {
        return (int)$this->get(self::MULTIBANCO_TESTMODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getBuyerNotification()
    {
        return (string)$this->get(self::MULTIBANCO_NOTIFICATION);
    }
}
