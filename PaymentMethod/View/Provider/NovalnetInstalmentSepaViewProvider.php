<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetInstalmentSepaConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetInstalmentSepaConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetInstalmentSepaViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Novalnet payment method view provider factory
 */
class NovalnetInstalmentSepaViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetInstalmentSepaViewFactoryInterface */
    private $factory;

    /** @var NovalnetInstalmentSepaConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetInstalmentSepaViewFactoryInterface $factory
     * @param NovalnetInstalmentSepaConfigProviderInterface $configProvider
     */
    public function __construct(
        NovalnetInstalmentSepaViewFactoryInterface $factory,
        NovalnetInstalmentSepaConfigProviderInterface $configProvider
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
            $this->addNovalnetInstalmentSepaView($config);
        }
    }

    /**
     * @param NovalnetConfigInterface $config
     */
    protected function addNovalnetInstalmentSepaView(NovalnetInstalmentSepaConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
