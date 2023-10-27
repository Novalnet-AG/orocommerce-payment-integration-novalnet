<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPrzelewyConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetPrzelewyConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetPrzelewyPaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetPrzelewyMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetPrzelewyPaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetPrzelewyConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetPrzelewyConfigProviderInterface $configProvider
     * @param NovalnetPrzelewyPaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetPrzelewyConfigProviderInterface $configProvider,
        NovalnetPrzelewyPaymentMethodFactoryInterface $factory
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
            $this->addNovalnetPrzelewyPaymentMethod($config);
        }
    }

    /**
     * @param NovalnetPrzelewyConfigInterface $config
     */
    protected function addNovalnetPrzelewyPaymentMethod(NovalnetPrzelewyConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
