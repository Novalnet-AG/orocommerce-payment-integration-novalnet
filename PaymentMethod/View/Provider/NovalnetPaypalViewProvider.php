<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPaypalConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetPaypalConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetPaypalViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Novalnet payment method view provider factory
 */
class NovalnetPaypalViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetPaypalViewFactoryInterface */
    private $factory;

    /** @var NovalnetPaypalConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetPaypalViewFactoryInterface $factory
     * @param NovalnetPaypalConfigProviderInterface $configProvider
     */
    public function __construct(
        NovalnetPaypalViewFactoryInterface $factory,
        NovalnetPaypalConfigProviderInterface $configProvider
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
            $this->addNovalnetPaypalView($config);
        }
    }

    /**
     * @param NovalnetPaypalConfigInterface $config
     */
    protected function addNovalnetPaypalView(NovalnetPaypalConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
