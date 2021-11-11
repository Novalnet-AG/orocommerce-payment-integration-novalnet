<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetCreditCardConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetCreditCardConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetCreditCardConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetCreditCardConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}
