<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetIdealConfig extends NovalnetConfig implements NovalnetIdealConfigInterface
{
    const ADMIN_LABEL_KEY = 'Ideal';
    const ADMIN_LABEL_SUFFIX = 'IDEAL';
}
