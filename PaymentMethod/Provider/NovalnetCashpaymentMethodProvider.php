<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetCashpaymentConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetCashpaymentConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetCashpaymentPaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetCashpaymentMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetCashpaymentPaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetCashpaymentConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetCashpaymentConfigProviderInterface $configProvider
     * @param NovalnetCashpaymentPaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetCashpaymentConfigProviderInterface $configProvider,
        NovalnetCashpaymentPaymentMethodFactoryInterface $factory
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
            $this->addNovalnetCashpaymentPaymentMethod($config);
        }
    }

    /**
     * @param NovalnetCashpaymentConfigInterface $config
     */
    protected function addNovalnetCashpaymentPaymentMethod(NovalnetCashpaymentConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
