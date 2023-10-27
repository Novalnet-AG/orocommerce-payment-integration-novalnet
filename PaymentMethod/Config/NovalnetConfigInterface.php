<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

use Oro\Bundle\PaymentBundle\Method\Config\PaymentConfigInterface;

/**
 * Interface that describes specific configuration for Novalnet payment method
 */
interface NovalnetConfigInterface extends PaymentConfigInterface
{
    /**
     * @return integer
     */
    public function getTariff();

    /**
     * @return string
     */
    public function getPaymentAccessKey();

    /**
     * @return string
     */
    public function getProductActivationKey();

    /**
     * @return integer
     */
    public function getCallbackTestMode();

    /**
     * @return string
     */
    public function getCallbackEmailTo();
}
