<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Interface that describes specific configuration for Novalnet payment method
 */
interface NovalnetInstalmentInvoiceConfigInterface extends NovalnetConfigInterface
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
     * @return integer
     */
    public function getMinAmount();

    /**
     * @return string
     */
    public function getPaymentAction();

    /**
     * @return integer
     */
    public function getOnholdAmount();

    /**
     * @return array
     */
    public function getInstalmentCycle();
}
