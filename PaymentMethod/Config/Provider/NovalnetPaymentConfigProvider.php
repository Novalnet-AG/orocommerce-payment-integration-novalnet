<?php

namespace Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\Config\Provider;

use Doctrine\Common\Persistence\ManagerRegistry;
use Oro\Bundle\NovalnetPaymentBundle\Entity\NovalnetPaymentSettings;
use Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\Config\Factory\NovalnetPaymentConfigFactoryInterface;
use Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\Config\NovalnetPaymentConfigInterface;
use Psr\Log\LoggerInterface;

/**
 * Allows to get configs of Collect on delivery payment method
 */
class NovalnetPaymentConfigProvider implements NovalnetPaymentConfigProviderInterface
{
    /**
     * @var ManagerRegistry
     */
    protected $doctrine;

    /**
     * @var NovalnetPaymentConfigFactoryInterface
     */
    protected $configFactory;

    /**
     * @var NovalnetPaymentConfigInterface[]
     */
    protected $configs;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param ManagerRegistry                  $doctrine
     * @param LoggerInterface                  $logger
     * @param NovalnetPaymentConfigFactoryInterface $configFactory
     */
    public function __construct(
        ManagerRegistry $doctrine,
        LoggerInterface $logger,
        NovalnetPaymentConfigFactoryInterface $configFactory
    ) {
        $this->doctrine = $doctrine;
        $this->logger = $logger;
        $this->configFactory = $configFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function getPaymentConfigs()
    {
        $configs = [];

        $settings = $this->getEnabledIntegrationSettings();

        foreach ($settings as $setting) {
            $config = $this->configFactory->create($setting);

            $configs[$config->getPaymentMethodIdentifier()] = $config;
        }

        return $configs;
    }

    /**
     * {@inheritDoc}
     */
    public function getPaymentConfig($identifier)
    {
        $paymentConfigs = $this->getPaymentConfigs();

        if ([] === $paymentConfigs || false === array_key_exists($identifier, $paymentConfigs)) {
            return null;
        }

        return $paymentConfigs[$identifier];
    }

    /**
     * {@inheritDoc}
     */
    public function hasPaymentConfig($identifier)
    {
        return null !== $this->getPaymentConfig($identifier);
    }

    /**
     * @return NovalnetPaymentSettings[]
     */
    protected function getEnabledIntegrationSettings()
    {
        try {
            /** @var NovalnetPaymentSettingsRepository $repository */
            $repository = $this->doctrine
                ->getManagerForClass(NovalnetPaymentSettings::class)
                ->getRepository(NovalnetPaymentSettings::class);

            return $repository->getEnabledSettings();
        } catch (\UnexpectedValueException $e) {
            $this->logger->critical($e->getMessage());

            return [];
        }
    }
}
