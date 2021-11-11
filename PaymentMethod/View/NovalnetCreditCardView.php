<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View;

/**
 * Credit Card payment method view
 */
class NovalnetCreditCardView extends NovalnetView
{
    /**
     * {@inheritdoc}
     */
    public function getBlock()
    {
        return '_payment_methods_novalnet_credit_card_widget';
    }
}
