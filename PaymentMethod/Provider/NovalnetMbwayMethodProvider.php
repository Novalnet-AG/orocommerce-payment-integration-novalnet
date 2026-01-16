<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetMbwayConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetMbwayConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetMbwayPaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetMbwayMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetMbwayPaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetMbwayConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetMbwayConfigProviderInterface $configProvider
     * @param NovalnetMbwayPaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetMbwayConfigProviderInterface $configProvider,
        NovalnetMbwayPaymentMethodFactoryInterface $factory
    ) {
        parent::__construct();

        $this->configProvider = $configProvider;
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    protected function collectMethods()
    {
        $configs = $this->configProvider->getPaymentConfigs();

        foreach ($configs as $config) {
            $this->addNovalnetMbwayPaymentMethod($config);
        }
    }

    /**
     * @param NovalnetMbwayConfigInterface $config
     */
    protected function addNovalnetMbwayPaymentMethod(NovalnetMbwayConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}