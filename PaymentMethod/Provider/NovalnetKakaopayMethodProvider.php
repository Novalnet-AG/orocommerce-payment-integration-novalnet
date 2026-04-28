<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetKakaopayConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetKakaopayConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetKakaopayPaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetKakaopayMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetKakaopayPaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetKakaopayConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetKakaopayConfigProviderInterface $configProvider
     * @param NovalnetKakaopayPaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetKakaopayConfigProviderInterface $configProvider,
        NovalnetKakaopayPaymentMethodFactoryInterface $factory
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
            $this->addNovalnetKakaopayPaymentMethod($config);
        }
    }

    /**
     * @param NovalnetKakaopayConfigInterface $config
     */
    protected function addNovalnetKakaopayPaymentMethod(NovalnetKakaopayConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}