<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View;

/**
 * Giropay payment method view
 */
class NovalnetGiropayView extends NovalnetView
{
    /**
     * {@inheritdoc}
     */
    public function getBlock()
    {
        return '_payment_methods_novalnet_giropay_widget';
    }
}
