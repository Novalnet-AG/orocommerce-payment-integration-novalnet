<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetAlipayConfig extends NovalnetConfig implements NovalnetAlipayConfigInterface
{
    const ADMIN_LABEL_KEY = 'Alipay';
    const ADMIN_LABEL_SUFFIX = 'ALIPAY';
    const ALIPAY_TESTMODE = 'alipay_testmode';
    const ALIPAY_NOTIFICATION = 'alipay_buyer_notification';

    /**
     * {@inheritDoc}
     */
    public function getTestMode()
    {
        return (int)$this->get(self::ALIPAY_TESTMODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getBuyerNotification()
    {
        return (string)$this->get(self::ALIPAY_NOTIFICATION);
    }
}
