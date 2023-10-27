<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetCashpaymentConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetCashpaymentConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetCashpaymentViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Novalnet payment method view provider factory
 */
class NovalnetCashpaymentViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetCashpaymentViewFactoryInterface */
    private $factory;

    /** @var NovalnetCashpaymentConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetCashpaymentViewFactoryInterface $factory
     * @param NovalnetCashpaymentConfigProviderInterface $configProvider
     */
    public function __construct(
        NovalnetCashpaymentViewFactoryInterface $factory,
        NovalnetCashpaymentConfigProviderInterface $configProvider
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
            $this->addNovalnetCashpaymentView($config);
        }
    }

    /**
     * @param NovalnetConfigInterface $config
     */
    protected function addNovalnetCashpaymentView(NovalnetCashpaymentConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
