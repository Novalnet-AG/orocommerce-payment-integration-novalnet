<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPaypalConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetPaypalConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetPaypalPaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetPaypalMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetPaypalPaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetPaypalConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetPaypalConfigProviderInterface $configProvider
     * @param NovalnetPaypalPaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetPaypalConfigProviderInterface $configProvider,
        NovalnetPaypalPaymentMethodFactoryInterface $factory
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
            $this->addNovalnetPaypalPaymentMethod($config);
        }
    }

    /**
     * @param NovalnetPaypalConfigInterface $config
     */
    protected function addNovalnetPaypalPaymentMethod(NovalnetPaypalConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
