<?php

namespace Novalnet\Bundle\NovalnetBundle\Integration;

use Oro\Bundle\IntegrationBundle\Entity\Transport;
use Oro\Bundle\IntegrationBundle\Provider\TransportInterface;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\Form\Type\NovalnetSettingsType;

/**
 * Novalnet integration transport
 */
class NovalnetTransport implements TransportInterface
{
    /**
     * {@inheritDoc}
     */
    public function init(Transport $transportEntity)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getSettingsFormType()
    {
        return NovalnetSettingsType::class;
    }

    /**
     * {@inheritDoc}
     */
    public function getSettingsEntityFQCN()
    {
        return NovalnetSettings::class;
    }

    /**
     * {@inheritDoc}
     */
    public function getLabel()
    {
        return 'novalnet.settings.label';
    }
}
