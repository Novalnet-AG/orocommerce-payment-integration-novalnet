<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetGuaranteedSepaConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetGuaranteedSepaConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetGuaranteedSepaPaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetGuaranteedSepaMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetGuaranteedSepaPaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetGuaranteedSepaConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetGuaranteedSepaConfigProviderInterface $configProvider
     * @param NovalnetGuaranteedSepaPaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetGuaranteedSepaConfigProviderInterface $configProvider,
        NovalnetGuaranteedSepaPaymentMethodFactoryInterface $factory
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
            $this->addNovalnetGuaranteedSepaPaymentMethod($config);
        }
    }

    /**
     * @param NovalnetGuaranteedSepaConfigInterface $config
     */
    protected function addNovalnetGuaranteedSepaPaymentMethod(NovalnetGuaranteedSepaConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
