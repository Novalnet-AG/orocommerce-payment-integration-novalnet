<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetBancontactConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetBancontactConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetBancontactViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Novalnet payment method view provider factory
 */
class NovalnetBancontactViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetBancontactViewFactoryInterface */
    private $factory;

    /** @var NovalnetBancontactConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetBancontactViewFactoryInterface $factory
     * @param NovalnetBancontactConfigProviderInterface $configProvider
     */
    public function __construct(
        NovalnetBancontactViewFactoryInterface $factory,
        NovalnetBancontactConfigProviderInterface $configProvider
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
            $this->addNovalnetBancontactView($config);
        }
    }

    /**
     * @param NovalnetConfigInterface $config
     */
    protected function addNovalnetBancontactView(NovalnetBancontactConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
