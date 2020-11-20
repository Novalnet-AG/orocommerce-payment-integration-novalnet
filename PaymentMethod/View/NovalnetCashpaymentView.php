<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View;

/**
 * Cashpayment payment method view
 */
class NovalnetCashpaymentView extends NovalnetView
{
    /**
     * {@inheritdoc}
     */
    public function getBlock()
    {
        return '_payment_methods_novalnet_cashpayment_widget';
    }
}
