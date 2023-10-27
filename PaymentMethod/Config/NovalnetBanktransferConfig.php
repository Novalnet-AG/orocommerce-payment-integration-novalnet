<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetBanktransferConfig extends NovalnetConfig implements NovalnetBanktransferConfigInterface
{
    const ADMIN_LABEL_KEY = 'Banktransfer';
    const ADMIN_LABEL_SUFFIX = 'INSTANT BANK TRANSFER';
    const BANKTRANSFER_TESTMODE = 'banktransfer_testmode';
    const BANKTRANSFER_NOTIFICATION = 'banktransfer_buyer_notification';

    /**
     * {@inheritDoc}
     */
    public function getTestMode()
    {
        return (int)$this->get(self::BANKTRANSFER_TESTMODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getBuyerNotification()
    {
        return (string)$this->get(self::BANKTRANSFER_NOTIFICATION);
    }
}
