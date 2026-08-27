<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetBlikConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetBlikConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetBlikViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Provider for retrieving payment method view instances
 */
class NovalnetBlikViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetBlikViewFactoryInterface */
    private $factory;

    /** @var NovalnetBlikConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetBlikViewFactoryInterface $factory
     * @param NovalnetBlikConfigProviderInterface $configProvider
     */
    public function __construct(
        NovalnetBlikViewFactoryInterface $factory,
        NovalnetBlikConfigProviderInterface $configProvider
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
            $this->addNovalnetBlikView($config);
        }
    }

    /**
     * @param NovalnetBlikConfigInterface $config
     */
    protected function addNovalnetBlikView(NovalnetBlikConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}