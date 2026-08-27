<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetTwintConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetTwintConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetTwintViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Provider for retrieving payment method view instances
 */
class NovalnetTwintViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetTwintViewFactoryInterface */
    private $factory;

    /** @var NovalnetTwintConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetTwintViewFactoryInterface $factory
     * @param NovalnetTwintConfigProviderInterface $configProvider
     */
    public function __construct(
        NovalnetTwintViewFactoryInterface $factory,
        NovalnetTwintConfigProviderInterface $configProvider
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
            $this->addNovalnetTwintView($config);
        }
    }

    /**
     * @param NovalnetTwintConfigInterface $config
     */
    protected function addNovalnetTwintView(NovalnetTwintConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}