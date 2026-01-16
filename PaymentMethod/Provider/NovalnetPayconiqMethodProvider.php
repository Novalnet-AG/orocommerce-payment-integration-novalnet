<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPayconiqConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetPayconiqConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetPayconiqPaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetPayconiqMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetPayconiqPaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetPayconiqConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetPayconiqConfigProviderInterface $configProvider
     * @param NovalnetPayconiqPaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetPayconiqConfigProviderInterface $configProvider,
        NovalnetPayconiqPaymentMethodFactoryInterface $factory
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
            $this->addNovalnetPayconiqPaymentMethod($config);
        }
    }

    /**
     * @param NovalnetPayconiqConfigInterface $config
     */
    protected function addNovalnetPayconiqPaymentMethod(NovalnetPayconiqConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}