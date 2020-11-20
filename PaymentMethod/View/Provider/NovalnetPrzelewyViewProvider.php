<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPrzelewyConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetPrzelewyConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetPrzelewyViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Novalnet payment method view provider factory
 */
class NovalnetPrzelewyViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetPrzelewyViewFactoryInterface */
    private $factory;

    /** @var NovalnetPrzelewyConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetPrzelewyConfigProviderInterface $configProvider
     * @param NovalnetPrzelewyPaymentMethodViewFactoryInterface $factory
     */
    public function __construct(
        NovalnetPrzelewyViewFactoryInterface $factory,
        NovalnetPrzelewyConfigProviderInterface $configProvider
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
            $this->addNovalnetPrzelewyView($config);
        }
    }

    /**
     * @param NovalnetConfigInterface $config
     */
    protected function addNovalnetPrzelewyView(NovalnetPrzelewyConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
