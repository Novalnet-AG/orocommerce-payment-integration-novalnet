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
    const ONHOLD_AMOUNT = 'onhold_amount';

    /**
     * {@inheritDoc}
     */
    public function getOnholdAmount()
    {
        return (string)$this->get(self::ONHOLD_AMOUNT);
    }
}
