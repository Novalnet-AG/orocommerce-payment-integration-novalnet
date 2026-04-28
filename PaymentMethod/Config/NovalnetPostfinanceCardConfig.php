<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetPostfinanceCardConfig extends NovalnetConfig implements NovalnetPostfinanceCardConfigInterface
{
    const ADMIN_LABEL_KEY = 'PostFinance Card';
    const ADMIN_LABEL_SUFFIX = 'POSTFINANCE CARD';
    const POSTFINANCECARD_TESTMODE = 'postfinance_card_testmode';
    const POSTFINANCECARD_NOTIFICATION = 'postfinance_card_buyer_notification';

    /**
     * {@inheritDoc}
     */
    public function getTestMode()
    {
        return (int)$this->get(self::POSTFINANCECARD_TESTMODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getBuyerNotification()
    {
        return (string)$this->get(self::POSTFINANCECARD_NOTIFICATION);
    }
}
