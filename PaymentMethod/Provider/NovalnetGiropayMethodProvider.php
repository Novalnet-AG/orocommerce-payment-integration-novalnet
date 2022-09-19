<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetGiropayConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetGiropayConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetGiropayPaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetGiropayMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetGiropayPaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetGiropayConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetGiropayConfigProviderInterface $configProvider
     * @param NovalnetGiropayPaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetGiropayConfigProviderInterface $configProvider,
        NovalnetGiropayPaymentMethodFactoryInterface $factory
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
            $this->addNovalnetGiropayPaymentMethod($config);
        }
    }

    /**
     * @param NovalnetGiropayConfigInterface $config
     */
    protected function addNovalnetGiropayPaymentMethod(NovalnetGiropayConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
