<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfigInterface;

/**
 * Interface for Novalnet payment method config factory
 * Creates instances of NovalnetSettings with configuration for payment method
 */
interface NovalnetConfigFactoryInterface
{
    /**
     * @param NovalnetSettings $settings
     * @return NovalnetConfigInterface
     */
    public function createConfig(NovalnetSettings $settings);
}
