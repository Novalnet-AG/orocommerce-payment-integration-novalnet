<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetKakaopayConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetKakaopayConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetKakaopayViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Provider for retrieving payment method view instances
 */
class NovalnetKakaopayViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetKakaopayViewFactoryInterface */
    private $factory;

    /** @var NovalnetKakaopayConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetKakaopayViewFactoryInterface $factory
     * @param NovalnetKakaopayConfigProviderInterface $configProvider
     */
    public function __construct(
        NovalnetKakaopayViewFactoryInterface $factory,
        NovalnetKakaopayConfigProviderInterface $configProvider
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
            $this->addNovalnetKakaopayView($config);
        }
    }

    /**
     * @param NovalnetKakaopayConfigInterface $config
     */
    protected function addNovalnetKakaopayView(NovalnetKakaopayConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}