<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetAlipayConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetAlipayConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetAlipayPaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetAlipayMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetAlipayPaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetAlipayConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetAlipayConfigProviderInterface $configProvider
     * @param NovalnetAlipayPaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetAlipayConfigProviderInterface $configProvider,
        NovalnetAlipayPaymentMethodFactoryInterface $factory
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
            $this->addNovalnetAlipayPaymentMethod($config);
        }
    }

    /**
     * @param NovalnetAlipayConfigInterface $config
     */
    protected function addNovalnetAlipayPaymentMethod(NovalnetAlipayConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
