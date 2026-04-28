<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetMbwayConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetMbwayConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetMbwayViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Provider for retrieving payment method view instances
 */
class NovalnetMbwayViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetMbwayViewFactoryInterface */
    private $factory;

    /** @var NovalnetMbwayConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetMbwayViewFactoryInterface $factory
     * @param NovalnetMbwayConfigProviderInterface $configProvider
     */
    public function __construct(
        NovalnetMbwayViewFactoryInterface $factory,
        NovalnetMbwayConfigProviderInterface $configProvider
    ) {
        parent::__construct();

        $this->factory = $factory;
        $this->configProvider = $configProvider;
    }

    /**
     * {@inheritdoc}
     */
    protected function buildViews()
    {
        $configs = $this->configProvider->getPaymentConfigs();

        foreach ($configs as $config) {
            $this->addNovalnetMbwayView($config);
        }
    }

    /**
     * @param NovalnetMbwayConfigInterface $config
     */
    protected function addNovalnetMbwayView(NovalnetMbwayConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}