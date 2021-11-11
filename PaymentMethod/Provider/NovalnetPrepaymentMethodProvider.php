<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPrepaymentConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetPrepaymentConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetPrepaymentPaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetPrepaymentMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetPrepaymentPaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetPrepaymentConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetPrepaymentConfigProviderInterface $configProvider
     * @param NovalnetPrepaymentPaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetPrepaymentConfigProviderInterface $configProvider,
        NovalnetPrepaymentPaymentMethodFactoryInterface $factory
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
            $this->addNovalnetPrepaymentPaymentMethod($config);
        }
    }

    /**
     * @param NovalnetConfigInterface $config
     */
    protected function addNovalnetPrepaymentPaymentMethod(NovalnetPrepaymentConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
