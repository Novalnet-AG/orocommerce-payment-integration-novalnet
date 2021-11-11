<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetCreditCardConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetCreditCardConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetCreditCardPaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetCreditCardMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetCreditCardPaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetCreditCardConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetCreditCardConfigProviderInterface $configProvider
     * @param NovalnetCreditCardPaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetCreditCardConfigProviderInterface $configProvider,
        NovalnetCreditCardPaymentMethodFactoryInterface $factory
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
            $this->addNovalnetCreditCardPaymentMethod($config);
        }
    }

    /**
     * @param NovalnetConfigInterface $config
     */
    protected function addNovalnetCreditCardPaymentMethod(NovalnetCreditCardConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
