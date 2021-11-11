<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Interface that describes specific configuration for Novalnet payment method
 */
interface NovalnetPaypalConfigInterface extends NovalnetConfigInterface
{
    /**
     * @return string
     */
    public function getOnholdAmount();
}
