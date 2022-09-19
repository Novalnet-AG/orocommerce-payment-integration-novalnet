<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetBancontactConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetBancontactConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetBancontactPaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetBancontactMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetBancontactPaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetBancontactConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetBancontactConfigProviderInterface $configProvider
     * @param NovalnetBancontactPaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetBancontactConfigProviderInterface $configProvider,
        NovalnetBancontactPaymentMethodFactoryInterface $factory
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
            $this->addNovalnetBancontactPaymentMethod($config);
        }
    }

    /**
     * @param NovalnetBancontactConfigInterface $config
     */
    protected function addNovalnetBancontactPaymentMethod(NovalnetBancontactConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
