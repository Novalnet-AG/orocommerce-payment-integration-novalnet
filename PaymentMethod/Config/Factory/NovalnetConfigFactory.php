<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Oro\Bundle\IntegrationBundle\Entity\Channel;
use Oro\Bundle\IntegrationBundle\Generator\IntegrationIdentifierGeneratorInterface;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
abstract class NovalnetConfigFactory
{
    /**
     * @var IntegrationIdentifierGeneratorInterface
     */
    private $identifierGenerator;

    /**
     * @param IntegrationIdentifierGeneratorInterface $identifierGenerator
     */
    public function __construct(
        IntegrationIdentifierGeneratorInterface $identifierGenerator
    ) {
        $this->identifierGenerator = $identifierGenerator;
    }


    public function getPaymentMethodIdentifier(Channel $channel)
    {
        return (string)$this->identifierGenerator->generateIdentifier($channel);
    }

    /**
     * @param Channel $channel
     * @param string $suffix
     *
     * @return string
     */
    protected function getAdminLabel(Channel $channel, $suffix)
    {
        return sprintf('%s - %s', $channel->getName(), $suffix);
    }
}
