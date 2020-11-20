<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View;

/**
 * PayPal payment method view
 */
class NovalnetPaypalView extends NovalnetView
{
    /**
     * {@inheritdoc}
     */
    public function getBlock()
    {
        return '_payment_methods_novalnet_paypal_widget';
    }
}
