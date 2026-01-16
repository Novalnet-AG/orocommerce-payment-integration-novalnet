<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetBlikConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetBlikConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetBlikPaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetBlikMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetBlikPaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetBlikConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetBlikConfigProviderInterface $configProvider
     * @param NovalnetBlikPaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetBlikConfigProviderInterface $configProvider,
        NovalnetBlikPaymentMethodFactoryInterface $factory
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
            $this->addNovalnetBlikPaymentMethod($config);
        }
    }

    /**
     * @param NovalnetBlikConfigInterface $config
     */
    protected function addNovalnetBlikPaymentMethod(NovalnetBlikConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}