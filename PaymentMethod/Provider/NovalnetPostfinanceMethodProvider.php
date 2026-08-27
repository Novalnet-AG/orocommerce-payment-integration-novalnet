<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPostfinanceConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetPostfinanceConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetPostfinancePaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetPostfinanceMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetPostfinancePaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetPostfinanceConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetPostfinanceConfigProviderInterface $configProvider
     * @param NovalnetPostfinancePaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetPostfinanceConfigProviderInterface $configProvider,
        NovalnetPostfinancePaymentMethodFactoryInterface $factory
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
            $this->addNovalnetPostfinancePaymentMethod($config);
        }
    }

    /**
     * @param NovalnetPostfinanceConfigInterface $config
     */
    protected function addNovalnetPostfinancePaymentMethod(NovalnetPostfinanceConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
