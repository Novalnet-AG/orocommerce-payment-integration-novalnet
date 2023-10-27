<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Interface that describes specific configuration for Novalnet payment method
 */
interface NovalnetCashpaymentConfigInterface extends NovalnetConfigInterface
{

    /**
     * @return string
     */
    public function getDuedate();

    /**
     * @return string
     */
    public function getTestMode();

    /**
     * @return string
     */
    public function getBuyerNotification();
}
