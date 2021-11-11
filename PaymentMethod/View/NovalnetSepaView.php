<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View;

/**
 * SEPA payment method view
 */
class NovalnetSepaView extends NovalnetView
{
    /**
     * {@inheritdoc}
     */
    public function getBlock()
    {
        return '_payment_methods_novalnet_sepa_widget';
    }
}
