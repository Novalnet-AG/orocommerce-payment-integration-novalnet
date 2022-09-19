<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Interface that describes specific configuration for Novalnet payment method
 */
interface NovalnetGuaranteedSepaConfigInterface extends NovalnetConfigInterface
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
    public function getDuedate();

    /**
     * @return integer
     */
    public function getOnholdAmount();

    /**
     * @return string
     */
    public function getPaymentAction();

    /**
     * @return integer
     */
    public function getMinAmount();

    /**
     * @return integer
     */
    public function getOneclick();
}
