<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPrepaymentConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetPrepaymentConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetPrepaymentViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Novalnet payment method view provider factory
 */
class NovalnetPrepaymentViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetPrepaymentViewFactoryInterface */
    private $factory;

    /** @var NovalnetPrepaymentConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetPrepaymentViewFactoryInterface $factory
     * @param NovalnetPrepaymentConfigProviderInterface $configProvider
     */
    public function __construct(
        NovalnetPrepaymentViewFactoryInterface $factory,
        NovalnetPrepaymentConfigProviderInterface $configProvider
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
            $this->addNovalnetPrepaymentView($config);
        }
    }

    /**
     * @param NovalnetPrepaymentConfigInterface $config
     */
    protected function addNovalnetPrepaymentView(NovalnetPrepaymentConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
