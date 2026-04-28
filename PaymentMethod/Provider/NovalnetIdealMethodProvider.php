<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetIdealConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetIdealConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetIdealPaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetIdealMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetIdealPaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetIdealConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetIdealConfigProviderInterface $configProvider
     * @param NovalnetIdealPaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetIdealConfigProviderInterface $configProvider,
        NovalnetIdealPaymentMethodFactoryInterface $factory
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
            $this->addNovalnetIdealPaymentMethod($config);
        }
    }

    /**
     * @param NovalnetIdealConfigInterface $config
     */
    protected function addNovalnetIdealPaymentMethod(NovalnetIdealConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
