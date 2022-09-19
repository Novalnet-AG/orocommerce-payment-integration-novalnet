<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetMultibancoConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetMultibancoConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetMultibancoPaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetMultibancoMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetMultibancoPaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetMultibancoConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetMultibancoConfigProviderInterface $configProvider
     * @param NovalnetMultibancoPaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetMultibancoConfigProviderInterface $configProvider,
        NovalnetMultibancoPaymentMethodFactoryInterface $factory
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
            $this->addNovalnetMultibancoPaymentMethod($config);
        }
    }

    /**
     * @param NovalnetMultibancoConfigInterface $config
     */
    protected function addNovalnetMultibancoPaymentMethod(NovalnetMultibancoConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
