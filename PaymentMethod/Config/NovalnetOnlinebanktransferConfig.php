<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetOnlinebanktransferConfig extends NovalnetConfig implements NovalnetOnlinebanktransferConfigInterface
{
    const ADMIN_LABEL_KEY = 'Onlinebanktransfer';
    const ADMIN_LABEL_SUFFIX = 'ONLINE_BANK_TRANSFER';
    const ONLINEBANKTRANSFER_TESTMODE = 'onlinebanktransfer_testmode';
    const ONLINEBANKTRANSFER_NOTIFICATION = 'onlinebanktransfer_buyer_notification';

    /**
     * {@inheritDoc}
     */
    public function getTestMode()
    {
        return (int)$this->get(self::ONLINEBANKTRANSFER_TESTMODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getBuyerNotification()
    {
        return (string)$this->get(self::ONLINEBANKTRANSFER_NOTIFICATION);
    }
}
