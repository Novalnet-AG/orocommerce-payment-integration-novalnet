<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetEpsConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetEpsConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetEpsViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Novalnet payment method view provider factory
 */
class NovalnetEpsViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetEpsViewFactoryInterface */
    private $factory;

    /** @var NovalnetEpsConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetEpsViewFactoryInterface $factory
     * @param NovalnetEpsConfigProviderInterface $configProvider
     */
    public function __construct(
        NovalnetEpsViewFactoryInterface $factory,
        NovalnetEpsConfigProviderInterface $configProvider
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
            $this->addNovalnetEpsView($config);
        }
    }

    /**
     * @param NovalnetEpsConfigInterface $config
     */
    protected function addNovalnetEpsView(NovalnetEpsConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
