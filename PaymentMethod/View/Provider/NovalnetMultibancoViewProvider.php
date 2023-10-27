<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetMultibancoConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetMultibancoConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetMultibancoViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Novalnet payment method view provider factory
 */
class NovalnetMultibancoViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetMultibancoViewFactoryInterface */
    private $factory;

    /** @var NovalnetMultibancoConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetMultibancoViewFactoryInterface $factory
     * @param NovalnetMultibancoConfigProviderInterface $configProvider
     */
    public function __construct(
        NovalnetMultibancoViewFactoryInterface $factory,
        NovalnetMultibancoConfigProviderInterface $configProvider
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
            $this->addNovalnetMultibancoView($config);
        }
    }

    /**
     * @param NovalnetConfigInterface $config
     */
    protected function addNovalnetMultibancoView(NovalnetMultibancoConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
