<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory;

use Doctrine\Common\Collections\Collection;
use Oro\Bundle\IntegrationBundle\Entity\Channel;
use Oro\Bundle\IntegrationBundle\Generator\IntegrationIdentifierGeneratorInterface;
use Oro\Bundle\LocaleBundle\Helper\LocalizationHelper;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfig;

/**
 * Creates instances of configurations for Novalnet payment method
 */
abstract class NovalnetConfigFactory
{
    /**
     * @var LocalizationHelper
     */
    private $localizationHelper;

    /**
     * @var IntegrationIdentifierGeneratorInterface
     */
    private $identifierGenerator;

    /**
     * @param LocalizationHelper $localizationHelper
     * @param IntegrationIdentifierGeneratorInterface $identifierGenerator
     */
    public function __construct(
        LocalizationHelper $localizationHelper,
        IntegrationIdentifierGeneratorInterface $identifierGenerator
    ) {
        $this->localizationHelper = $localizationHelper;
        $this->identifierGenerator = $identifierGenerator;
    }

    /**
     * @param Collection $values
     *
     * @return string
     */
    protected function getLocalizedValue(Collection $values)
    {
        return (string)$this->localizationHelper->getLocalizedValue($values);
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
