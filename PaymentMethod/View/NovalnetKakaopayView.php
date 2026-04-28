<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View;

use Oro\Bundle\PaymentBundle\Context\PaymentContextInterface;

/**
 * Kakaopay payment method view
 */
class NovalnetKakaopayView extends NovalnetView
{
    /**
     * {@inheritdoc}
     */
    public function getBlock()
    {
        return '_payment_methods_novalnet_kakaopay_widget';
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions(PaymentContextInterface $context)
    {
        return [
            'testMode' => $this->config->getTestMode(),
            'notification' => $this->config->getBuyerNotification(),
            'paymentMethod' => $this->config->getPaymentMethodIdentifier(),
            'displayLogo' => $this->config->getDisplayPaymentLogo()
        ];
    }
}