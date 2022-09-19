<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetWechatpayConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetWechatpayConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetWechatpayViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Novalnet payment method view provider factory
 */
class NovalnetWechatpayViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetWechatpayViewFactoryInterface */
    private $factory;

    /** @var NovalnetWechatpayConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetWechatpayViewFactoryInterface $factory
     * @param NovalnetWechatpayConfigProviderInterface $configProvider
     */
    public function __construct(
        NovalnetWechatpayViewFactoryInterface $factory,
        NovalnetWechatpayConfigProviderInterface $configProvider
    ) {
        $this->factory = $factory;
        $this->configProvider = $configProvider;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function buildViews()
    {
        $configs = $this->configProvider->getPaymentConfigs();
        foreach ($configs as $config) {
            $this->addNovalnetWechatpayView($config);
        }
    }

    /**
     * @param NovalnetConfigInterface $config
     */
    protected function addNovalnetWechatpayView(NovalnetWechatpayConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
