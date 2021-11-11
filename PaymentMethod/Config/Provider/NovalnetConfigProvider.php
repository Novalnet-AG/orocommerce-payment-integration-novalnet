<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Doctrine\Common\Persistence\ManagerRegistry;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Factory\NovalnetConfigFactoryInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfigInterface;
use Psr\Log\LoggerInterface;

/**
 * Config provider of Novalnet payment method
 */
abstract class NovalnetConfigProvider implements NovalnetConfigProviderInterface
{
    /**
     * @var ManagerRegistry
     */
    protected $doctrine;

    /**
     * @var NovalnetConfigFactoryInterface
     */
    protected $configFactory;

    /**
     * @var NovalnetConfigInterface[]
     */
    protected $configs;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var string
     */
    protected $type;

    /**
     * @param ManagerRegistry $doctrine
     * @param LoggerInterface $logger
     * @param NovalnetConfigFactoryInterface $configFactory
     */
    public function __construct(
        ManagerRegistry $doctrine,
        LoggerInterface $logger,
        NovalnetConfigFactoryInterface $configFactory,
        $type
    ) {
        $this->doctrine = $doctrine;
        $this->logger = $logger;
        $this->configFactory = $configFactory;
        $this->type = $type;
    }

    /**
     * @return string
     */
    protected function getType()
    {
        return $this->type;
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
     * @return NovalnetSettings[]
     */
    protected function getEnabledIntegrationSettings()
    {
        try {
            /** @var NovalnetSettingsRepository $repository */
            $repository = $this->doctrine
                ->getManagerForClass(NovalnetSettings::class)
                ->getRepository(NovalnetSettings::class);
            return $repository->getEnabledSettings();
        } catch (\UnexpectedValueException $e) {
            $this->logger->critical($e->getMessage());

            return [];
        }
    }

    /**
     * @return array
     */
    protected function collectConfigs()
    {
        $configs = [];
        $settings = $this->getEnabledIntegrationSettings();

        foreach ($settings as $setting) {
            $config = $this->configFactory->createConfig($setting);

            $configs[$config->getPaymentMethodIdentifier()] = $config;
        }
        return $configs;
    }
}
