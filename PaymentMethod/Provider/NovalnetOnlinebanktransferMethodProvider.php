<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetOnlinebanktransferConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetOnlinebanktransferConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetOnlinebanktransferPaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetOnlinebanktransferMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetOnlinebanktransferPaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetOnlinebanktransferConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetOnlinebanktransferConfigProviderInterface $configProvider
     * @param NovalnetOnlinebanktransferPaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetOnlinebanktransferConfigProviderInterface $configProvider,
        NovalnetOnlinebanktransferPaymentMethodFactoryInterface $factory
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
            $this->addNovalnetOnlinebanktransferPaymentMethod($config);
        }
    }

    /**
     * @param NovalnetOnlinebanktransferConfigInterface $config
     */
    protected function addNovalnetOnlinebanktransferPaymentMethod(NovalnetOnlinebanktransferConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
