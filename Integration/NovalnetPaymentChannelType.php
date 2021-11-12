<?php

namespace Oro\Bundle\NovalnetPaymentBundle\Integration;

use Oro\Bundle\IntegrationBundle\Provider\ChannelInterface;
use Oro\Bundle\IntegrationBundle\Provider\IconAwareIntegrationInterface;

class NovalnetPaymentChannelType implements ChannelInterface, IconAwareIntegrationInterface
{
    const TYPE = 'novalnet_payment';

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'oro.novalnet_payment.channel_type.label';
    }

    /**
     * {@inheritdoc}
     */
    public function getIcon()
    {
        return 'bundles/oronovalnetpayment/img/novalnet-payment-icon.ico';
    }
}
