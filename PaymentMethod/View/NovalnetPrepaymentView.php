<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View;

/**
 * Prepayment payment method view
 */
class NovalnetPrepaymentView extends NovalnetView
{
    /**
     * {@inheritdoc}
     */
    public function getBlock()
    {
        return '_payment_methods_novalnet_prepayment_widget';
    }
}
