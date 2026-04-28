<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Interface that describes specific configuration for Novalnet payment method
 */
interface NovalnetPrepaymentConfigInterface extends NovalnetConfigInterface
{
    /**
     * @return integer
     */
    public function getTestMode();

    /**
     * @return string
     */
    public function getBuyerNotification();

    /**
     * @return string
     */
    public function getDueDate();
}
