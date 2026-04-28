<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetNaverpayConfig extends NovalnetConfig implements NovalnetNaverpayConfigInterface
{
    const ADMIN_LABEL_KEY = 'NaverPay';
    const ADMIN_LABEL_SUFFIX = 'NAVERPAY';
    const NAVERPAY_TESTMODE = 'naverpay_testmode';
    const NAVERPAY_NOTIFICATION = 'naverpay_buyer_notification';

    /**
     * {@inheritDoc}
     */
    public function getTestMode()
    {
        return (int)$this->get(self::NAVERPAY_TESTMODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getBuyerNotification()
    {
        return (string)$this->get(self::NAVERPAY_NOTIFICATION);
    }
}