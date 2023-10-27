<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetSepaConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetSepaConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetSepaPaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetSepaMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetSepaPaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetSepaConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetSepaConfigProviderInterface $configProvider
     * @param NovalnetSepaPaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetSepaConfigProviderInterface $configProvider,
        NovalnetSepaPaymentMethodFactoryInterface $factory
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
            $this->addNovalnetSepaPaymentMethod($config);
        }
    }

    /**
     * @param NovalnetSepaConfigInterface $config
     */
    protected function addNovalnetSepaPaymentMethod(NovalnetSepaConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
