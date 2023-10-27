<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetTrustlyConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view provider factory interface
 */
interface NovalnetTrustlyViewFactoryInterface
{
    /**
     * @param NovalnetTrustlyConfigInterface $config
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetTrustlyConfigInterface $config);
}
