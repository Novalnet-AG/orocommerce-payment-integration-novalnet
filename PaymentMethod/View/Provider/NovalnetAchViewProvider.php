<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetAchConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetAchConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetAchViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Provider for retrieving payment method view instances
 */
class NovalnetAchViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetAchViewFactoryInterface */
    private $factory;

    /** @var NovalnetAchConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetAchViewFactoryInterface $factory
     * @param NovalnetAchConfigProviderInterface $configProvider
     */
    public function __construct(
        NovalnetAchViewFactoryInterface $factory,
        NovalnetAchConfigProviderInterface $configProvider
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
            $this->addNovalnetAchView($config);
        }
    }

    /**
     * @param NovalnetAchConfigInterface $config
     */
    protected function addNovalnetAchView(NovalnetAchConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}