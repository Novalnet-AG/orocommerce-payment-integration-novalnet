<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetNaverpayConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetNaverpayConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetNaverpayViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Provider for retrieving payment method view instances
 */
class NovalnetNaverpayViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetNaverpayViewFactoryInterface */
    private $factory;

    /** @var NovalnetNaverpayConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetNaverpayViewFactoryInterface $factory
     * @param NovalnetNaverpayConfigProviderInterface $configProvider
     */
    public function __construct(
        NovalnetNaverpayViewFactoryInterface $factory,
        NovalnetNaverpayConfigProviderInterface $configProvider
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
            $this->addNovalnetNaverpayView($config);
        }
    }

    /**
     * @param NovalnetNaverpayConfigInterface $config
     */
    protected function addNovalnetNaverpayView(NovalnetNaverpayConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}