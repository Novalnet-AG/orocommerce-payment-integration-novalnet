<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetWechatpayConfig extends NovalnetConfig implements NovalnetWechatpayConfigInterface
{
    const ADMIN_LABEL_KEY = 'Wechatpay';
    const ADMIN_LABEL_SUFFIX = 'WECHATPAY';
    const WECHATPAY_TESTMODE = 'wechatpay_testmode';
    const WECHATPAY_NOTIFICATION = 'wechatpay_buyer_notification';

    /**
     * {@inheritDoc}
     */
    public function getTestMode()
    {
        return (int)$this->get(self::WECHATPAY_TESTMODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getBuyerNotification()
    {
        return (string)$this->get(self::WECHATPAY_NOTIFICATION);
    }
}
