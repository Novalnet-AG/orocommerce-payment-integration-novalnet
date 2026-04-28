<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetWechatpayConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view provider factory interface
 */
interface NovalnetWechatpayViewFactoryInterface
{
    /**
     * @param NovalnetWechatpayConfigInterface $config
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetWechatpayConfigInterface $config);
}
