<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetNaverpayConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetNaverpayConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetNaverpayPaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetNaverpayMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetNaverpayPaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetNaverpayConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetNaverpayConfigProviderInterface $configProvider
     * @param NovalnetNaverpayPaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetNaverpayConfigProviderInterface $configProvider,
        NovalnetNaverpayPaymentMethodFactoryInterface $factory
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
            $this->addNovalnetNaverpayPaymentMethod($config);
        }
    }

    /**
     * @param NovalnetNaverpayConfigInterface $config
     */
    protected function addNovalnetNaverpayPaymentMethod(NovalnetNaverpayConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}