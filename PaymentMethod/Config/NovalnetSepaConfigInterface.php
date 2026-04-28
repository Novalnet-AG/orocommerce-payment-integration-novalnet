<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Interface that describes specific configuration for Novalnet payment method
 */
interface NovalnetSepaConfigInterface extends NovalnetConfigInterface
{

   /**
     * @return string
     */
    public function getDuedate();

    /**
     * @return integer
     */
    public function getTestMode();

    /**
     * @return integer
     */
    public function getOnholdAmount();

    /**
     * @return string
     */
    public function getPaymentAction();

    /**
     * @return string
     */
    public function getBuyerNotification();

    /**
     * @return integer
     */
    public function getMinAmount();

    /**
     * @return integer
     */
    public function getOneclick();
}
