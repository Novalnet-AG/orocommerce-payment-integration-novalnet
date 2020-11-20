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
    public function getSepaDuedate();

    /**
     * @return string
     */
    public function getOnholdAmount();

    /**
     * @return boolean
     */
    public function getSepaPaymentGuarantee();

    /**
     * @return boolean
     */
    public function getSepaGuaranteeMinAmount();

    /**
     * @return boolean
     */
    public function getSepaForceNonGuarantee();
}
