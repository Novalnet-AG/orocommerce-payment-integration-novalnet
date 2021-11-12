<?php

namespace Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\View\Provider;

use Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\Config\NovalnetPaymentConfigInterface;
use Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\Config\Provider\NovalnetPaymentConfigProviderInterface;
use Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\View\Factory\NovalnetPaymentPaymentMethodViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Provider for retrieving payment method view instances
 */
class NovalnetPaymentViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetPaymentPaymentMethodViewFactoryInterface */
    private $factory;

    /** @var NovalnetPaymentConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetPaymentConfigProviderInterface $configProvider
     * @param NovalnetPaymentPaymentMethodViewFactoryInterface $factory
     */
    public function __construct(
        NovalnetPaymentConfigProviderInterface $configProvider,
        NovalnetPaymentPaymentMethodViewFactoryInterface $factory
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
            $this->addNovalnetPaymentView($config);
        }
    }

    /**
     * @param NovalnetPaymentConfigInterface $config
     */
    protected function addNovalnetPaymentView(NovalnetPaymentConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
