<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetGiropayConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetGiropayConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetGiropayViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Novalnet payment method view provider factory
 */
class NovalnetGiropayViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetGiropayViewFactoryInterface */
    private $factory;

    /** @var NovalnetGiropayConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetGiropayViewFactoryInterface $factory
     * @param NovalnetGiropayConfigProviderInterface $configProvider
     */
    public function __construct(
        NovalnetGiropayViewFactoryInterface $factory,
        NovalnetGiropayConfigProviderInterface $configProvider
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
            $this->addNovalnetGiropayView($config);
        }
    }

    /**
     * @param NovalnetConfigInterface $config
     */
    protected function addNovalnetGiropayView(NovalnetGiropayConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
