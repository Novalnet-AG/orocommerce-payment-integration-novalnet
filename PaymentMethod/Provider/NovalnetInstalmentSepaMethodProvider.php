<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetInstalmentSepaConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetInstalmentSepaConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetInstalmentSepaPaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetInstalmentSepaMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetInstalmentSepaPaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetInstalmentSepaConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetInstalmentSepaConfigProviderInterface $configProvider
     * @param NovalnetInstalmentSepaPaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetInstalmentSepaConfigProviderInterface $configProvider,
        NovalnetInstalmentSepaPaymentMethodFactoryInterface $factory
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
            $this->addNovalnetInstalmentSepaPaymentMethod($config);
        }
    }

    /**
     * @param NovalnetInstalmentSepaConfigInterface $config
     */
    protected function addNovalnetInstalmentSepaPaymentMethod(NovalnetInstalmentSepaConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
