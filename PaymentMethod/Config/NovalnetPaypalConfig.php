<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetPaypalConfig extends NovalnetConfig implements NovalnetPaypalConfigInterface
{
    const ADMIN_LABEL_KEY = 'Paypal';
    const ADMIN_LABEL_SUFFIX = 'PAYPAL';
    const PAYPAL_TESTMODE = 'paypal_testmode';
    const PAYPAL_ONHOLD_AMOUNT = 'paypal_onhold_amount';
    const PAYPAL_PAYMENT_ACTION = 'paypal_payment_action';
    const PAYPAL_NOTIFICATION = 'paypal_buyer_notification';
    const PAYPAL_ONECLICK = 'paypal_oneclick';

    /**
     * {@inheritDoc}
     */
    public function getTestMode()
    {
        return (int)$this->get(self::PAYPAL_TESTMODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getPaymentAction()
    {
        return (string)$this->get(self::PAYPAL_PAYMENT_ACTION);
    }

    /**
     * {@inheritDoc}
     */
    public function getOnholdAmount()
    {
        return (int)$this->get(self::PAYPAL_ONHOLD_AMOUNT);
    }

    /**
     * {@inheritDoc}
     */
    public function getBuyerNotification()
    {
        return (string)$this->get(self::PAYPAL_NOTIFICATION);
    }

    /**
     * {@inheritDoc}
     */
    public function getOneclick()
    {
        return (int)$this->get(self::PAYPAL_ONECLICK);
    }
}
