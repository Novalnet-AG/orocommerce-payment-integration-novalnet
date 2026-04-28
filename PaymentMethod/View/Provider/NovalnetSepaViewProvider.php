<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetSepaConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetSepaConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetSepaViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Novalnet payment method view provider factory
 */
class NovalnetSepaViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetSepaViewFactoryInterface */
    private $factory;

    /** @var NovalnetSepaConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetSepaViewFactoryInterface $factory
     * @param NovalnetSepaConfigProviderInterface $configProvider
     */
    public function __construct(
        NovalnetSepaViewFactoryInterface $factory,
        NovalnetSepaConfigProviderInterface $configProvider
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
            $this->addNovalnetSepaView($config);
        }
    }

    /**
     * @param NovalnetSepaConfigInterface $config
     */
    protected function addNovalnetSepaView(NovalnetSepaConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
