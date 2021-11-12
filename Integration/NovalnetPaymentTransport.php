<?php

namespace Oro\Bundle\NovalnetPaymentBundle\Integration;

use Oro\Bundle\IntegrationBundle\Entity\Transport;
use Oro\Bundle\IntegrationBundle\Provider\TransportInterface;
use Oro\Bundle\NovalnetPaymentBundle\Entity\NovalnetPaymentSettings;
use Oro\Bundle\NovalnetPaymentBundle\Form\Type\NovalnetPaymentSettingsType;

class NovalnetPaymentTransport implements TransportInterface
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
        return NovalnetPaymentSettingsType::class;
    }

    /**
     * {@inheritDoc}
     */
    public function getSettingsEntityFQCN()
    {
        return NovalnetPaymentSettings::class;
    }

    /**
     * {@inheritDoc}
     */
    public function getLabel()
    {
        return 'oro.novalnet_payment.settings.label';
    }
}
