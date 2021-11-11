<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetPrepaymentConfig extends NovalnetConfig implements NovalnetPrepaymentConfigInterface
{
    const ADMIN_LABEL_KEY = 'Prepayment';
    const ADMIN_LABEL_SUFFIX = 'PREPAYMENT';
}
