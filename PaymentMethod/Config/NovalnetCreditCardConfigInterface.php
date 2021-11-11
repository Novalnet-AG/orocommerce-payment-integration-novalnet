<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Interface that describes specific configuration for Novalnet payment method
 */
interface NovalnetCreditCardConfigInterface extends NovalnetConfigInterface
{

    /**
     * @return string
     */
    public function getCc3d();

    /**
     * @return string
     */
    public function getOnholdAmount();
}
