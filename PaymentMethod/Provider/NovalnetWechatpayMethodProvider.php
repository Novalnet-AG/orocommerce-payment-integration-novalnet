<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetWechatpayConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetWechatpayConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetWechatpayPaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetWechatpayMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetWechatpayPaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetWechatpayConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetWechatpayConfigProviderInterface $configProvider
     * @param NovalnetWechatpayPaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetWechatpayConfigProviderInterface $configProvider,
        NovalnetWechatpayPaymentMethodFactoryInterface $factory
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
            $this->addNovalnetWechatpayPaymentMethod($config);
        }
    }

    /**
     * @param NovalnetWechatpayConfigInterface $config
     */
    protected function addNovalnetWechatpayPaymentMethod(NovalnetWechatpayConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
