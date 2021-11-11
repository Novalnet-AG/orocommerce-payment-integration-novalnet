<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetGiropayConfig extends NovalnetConfig implements NovalnetGiropayConfigInterface
{
    const ADMIN_LABEL_KEY = 'Giropay';
    const ADMIN_LABEL_SUFFIX = 'GIROPAY';
}
