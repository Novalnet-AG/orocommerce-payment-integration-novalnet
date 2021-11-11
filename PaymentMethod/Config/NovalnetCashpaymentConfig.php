<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetCashpaymentConfig extends NovalnetConfig implements NovalnetCashpaymentConfigInterface
{
    const ADMIN_LABEL_KEY = 'Cashpayment';
    const ADMIN_LABEL_SUFFIX = 'CASHPAYMENT';
    const CASHPAYMENT_DUEDATE = 'cashpayment_duedate';

    /**
     * {@inheritDoc}
     */
    public function getCashpaymentDuedate()
    {
        return (string)$this->get(self::CASHPAYMENT_DUEDATE);
    }
}
