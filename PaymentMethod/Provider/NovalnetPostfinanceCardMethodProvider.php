<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPostfinanceCardConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetPostfinanceCardConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetPostfinanceCardPaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetPostfinanceCardMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetPostfinanceCardPaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetPostfinanceCardConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetPostfinanceCardConfigProviderInterface $configProvider
     * @param NovalnetPostfinanceCardPaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetPostfinanceCardConfigProviderInterface $configProvider,
        NovalnetPostfinanceCardPaymentMethodFactoryInterface $factory
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
            $this->addNovalnetPostfinanceCardPaymentMethod($config);
        }
    }

    /**
     * @param NovalnetPostfinanceCardConfigInterface $config
     */
    protected function addNovalnetPostfinanceCardPaymentMethod(NovalnetPostfinanceCardConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
