<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View;

/**
 * Ideal payment method view
 */
class NovalnetIdealView extends NovalnetView
{
    /**
     * {@inheritdoc}
     */
    public function getBlock()
    {
        return '_payment_methods_novalnet_ideal_widget';
    }
}
