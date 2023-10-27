<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetInstalmentSepaConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetInstalmentSepaPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetInstalmentSepaConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetInstalmentSepaConfigInterface $config);
}
