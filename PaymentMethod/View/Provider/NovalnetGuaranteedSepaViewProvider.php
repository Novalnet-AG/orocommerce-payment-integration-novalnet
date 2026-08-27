<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetGuaranteedSepaConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetGuaranteedSepaConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetGuaranteedSepaViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Novalnet payment method view provider factory
 */
class NovalnetGuaranteedSepaViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetGuaranteedSepaViewFactoryInterface */
    private $factory;

    /** @var NovalnetGuaranteedSepaConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetGuaranteedSepaViewFactoryInterface $factory
     * @param NovalnetGuaranteedSepaConfigProviderInterface $configProvider
     */
    public function __construct(
        NovalnetGuaranteedSepaViewFactoryInterface $factory,
        NovalnetGuaranteedSepaConfigProviderInterface $configProvider
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
            $this->addNovalnetGuaranteedSepaView($config);
        }
    }

    /**
     * @param NovalnetConfigInterface $config
     */
    protected function addNovalnetGuaranteedSepaView(NovalnetGuaranteedSepaConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
