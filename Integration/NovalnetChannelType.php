<?php

namespace Novalnet\Bundle\NovalnetBundle\Integration;

use Oro\Bundle\IntegrationBundle\Provider\ChannelInterface;
use Oro\Bundle\IntegrationBundle\Provider\IconAwareIntegrationInterface;

/**
 * Novalnet integration channel type
 */
class NovalnetChannelType implements ChannelInterface, IconAwareIntegrationInterface
{
    const TYPE = 'novalnet';

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'novalnet.channel_type.label';
    }

    /**
     * {@inheritdoc}
     */
    public function getIcon()
    {
        return 'bundles/novalnet/img/novalnet-icon.ico';
    }
}
