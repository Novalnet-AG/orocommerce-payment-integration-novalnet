<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetTwintConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetTwintConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetTwintPaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetTwintMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetTwintPaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetTwintConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetTwintConfigProviderInterface $configProvider
     * @param NovalnetTwintPaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetTwintConfigProviderInterface $configProvider,
        NovalnetTwintPaymentMethodFactoryInterface $factory
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
            $this->addNovalnetTwintPaymentMethod($config);
        }
    }

    /**
     * @param NovalnetTwintConfigInterface $config
     */
    protected function addNovalnetTwintPaymentMethod(NovalnetTwintConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}