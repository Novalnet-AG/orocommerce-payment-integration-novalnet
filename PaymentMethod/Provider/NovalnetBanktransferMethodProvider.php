<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetBanktransferConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetBanktransferConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetBanktransferPaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetBanktransferMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetBanktransferPaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetBanktransferConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetBanktransferConfigProviderInterface $configProvider
     * @param NovalnetBanktransferPaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetBanktransferConfigProviderInterface $configProvider,
        NovalnetBanktransferPaymentMethodFactoryInterface $factory
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
            $this->addNovalnetBanktransferPaymentMethod($config);
        }
    }

    /**
     * @param NovalnetConfigInterface $config
     */
    protected function addNovalnetBanktransferPaymentMethod(NovalnetBanktransferConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
