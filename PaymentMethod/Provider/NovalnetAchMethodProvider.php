<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetAchConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetAchConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetAchPaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetAchMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetAchPaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetAchConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetAchConfigProviderInterface $configProvider
     * @param NovalnetAchPaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetAchConfigProviderInterface $configProvider,
        NovalnetAchPaymentMethodFactoryInterface $factory
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
            $this->addNovalnetAchPaymentMethod($config);
        }
    }

    /**
     * @param NovalnetAchConfigInterface $config
     */
    protected function addNovalnetAchPaymentMethod(NovalnetAchConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}