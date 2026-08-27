<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPostfinanceConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetPostfinanceConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetPostfinanceViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Novalnet payment method view provider factory
 */
class NovalnetPostfinanceViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetPostfinanceViewFactoryInterface */
    private $factory;

    /** @var NovalnetPostfinanceConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetPostfinanceViewFactoryInterface $factory
     * @param NovalnetPostfinanceConfigProviderInterface $configProvider
     */
    public function __construct(
        NovalnetPostfinanceViewFactoryInterface $factory,
        NovalnetPostfinanceConfigProviderInterface $configProvider
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
            $this->addNovalnetPostfinanceView($config);
        }
    }

    /**
     * @param NovalnetConfigInterface $config
     */
    protected function addNovalnetPostfinanceView(NovalnetPostfinanceConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
