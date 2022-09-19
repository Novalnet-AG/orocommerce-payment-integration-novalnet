<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetAlipayConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetAlipayConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetAlipayViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Novalnet payment method view provider factory
 */
class NovalnetAlipayViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetAlipayViewFactoryInterface */
    private $factory;

    /** @var NovalnetAlipayConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetAlipayViewFactoryInterface $factory
     * @param NovalnetAlipayConfigProviderInterface $configProvider
     */
    public function __construct(
        NovalnetAlipayViewFactoryInterface $factory,
        NovalnetAlipayConfigProviderInterface $configProvider
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
            $this->addNovalnetAlipayView($config);
        }
    }

    /**
     * @param NovalnetConfigInterface $config
     */
    protected function addNovalnetAlipayView(NovalnetAlipayConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
