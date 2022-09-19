<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetEpsConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetEpsConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetEpsPaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetEpsMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetEpsPaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetEpsConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetEpsConfigProviderInterface $configProvider
     * @param NovalnetEpsPaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetEpsConfigProviderInterface $configProvider,
        NovalnetEpsPaymentMethodFactoryInterface $factory
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
            $this->addNovalnetEpsPaymentMethod($config);
        }
    }

    /**
     * @param NovalnetEpsConfigInterface $config
     */
    protected function addNovalnetEpsPaymentMethod(NovalnetEpsConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
