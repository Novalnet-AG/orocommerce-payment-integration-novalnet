<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetKakaopayConfig extends NovalnetConfig implements NovalnetKakaopayConfigInterface
{
    const ADMIN_LABEL_KEY = 'Kakaopay';
    const ADMIN_LABEL_SUFFIX = 'KAKAOPAY';
    const KAKAOPAY_TESTMODE = 'kakaopay_testmode';
    const KAKAOPAY_NOTIFICATION = 'kakaopay_buyer_notification';

    /**
     * {@inheritDoc}
     */
    public function getTestMode()
    {
        return (int)$this->get(self::KAKAOPAY_TESTMODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getBuyerNotification()
    {
        return (string)$this->get(self::KAKAOPAY_NOTIFICATION);
    }
}