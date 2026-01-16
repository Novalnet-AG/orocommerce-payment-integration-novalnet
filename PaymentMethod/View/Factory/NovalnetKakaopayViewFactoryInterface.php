<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetKakaopayConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view factory interface
 */
interface NovalnetKakaopayViewFactoryInterface
{
    /**
     * @param NovalnetKakaopayConfigInterface $config
     *
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetKakaopayConfigInterface $config);
}