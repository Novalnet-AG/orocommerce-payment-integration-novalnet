<?php

namespace Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\Provider;

use Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\Config\NovalnetPaymentConfigInterface;
use Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\Config\Provider\NovalnetPaymentConfigProviderInterface;
use Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\Factory\NovalnetPaymentPaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetPaymentMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetPaymentPaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetPaymentConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetPaymentConfigProviderInterface $configProvider
     * @param NovalnetPaymentPaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetPaymentConfigProviderInterface $configProvider,
        NovalnetPaymentPaymentMethodFactoryInterface $factory
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
            $this->addNovalnetPaymentMethod($config);
        }
    }

    /**
     * @param NovalnetPaymentConfigInterface $config
     */
    protected function addNovalnetPaymentMethod(NovalnetPaymentConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
