<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPayconiqConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetPayconiqConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetPayconiqViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Provider for retrieving payment method view instances
 */
class NovalnetPayconiqViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetPayconiqViewFactoryInterface */
    private $factory;

    /** @var NovalnetPayconiqConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetPayconiqViewFactoryInterface $factory
     * @param NovalnetPayconiqConfigProviderInterface $configProvider
     */
    public function __construct(
        NovalnetPayconiqViewFactoryInterface $factory,
        NovalnetPayconiqConfigProviderInterface $configProvider
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
            $this->addNovalnetPayconiqView($config);
        }
    }

    /**
     * @param NovalnetPayconiqConfigInterface $config
     */
    protected function addNovalnetPayconiqView(NovalnetPayconiqConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}