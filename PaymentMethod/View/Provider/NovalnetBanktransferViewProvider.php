<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetBanktransferConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetBanktransferConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetBanktransferViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Novalnet payment method view provider factory
 */
class NovalnetBanktransferViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetBanktransferViewFactoryInterface */
    private $factory;

    /** @var NovalnetBanktransferConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetBanktransferViewFactoryInterface $factory
     * @param NovalnetBanktransferConfigProviderInterface $configProvider
     */
    public function __construct(
        NovalnetBanktransferViewFactoryInterface $factory,
        NovalnetBanktransferConfigProviderInterface $configProvider
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
            $this->addNovalnetBanktransferView($config);
        }
    }

    /**
     * @param NovalnetBanktransferConfigInterface $config
     */
    protected function addNovalnetBanktransferView(NovalnetBanktransferConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
