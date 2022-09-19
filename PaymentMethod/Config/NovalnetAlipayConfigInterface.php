<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Interface that describes specific configuration for Novalnet payment method
 */
interface NovalnetAlipayConfigInterface extends NovalnetConfigInterface
{
    /**
     * @return integer
     */
    public function getTestMode();

    /**
     * @return string
     */
    public function getBuyerNotification();
}
