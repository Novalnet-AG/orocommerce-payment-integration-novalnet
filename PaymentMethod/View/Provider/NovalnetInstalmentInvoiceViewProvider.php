<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetInstalmentInvoiceConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetInstalmentInvoiceConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetInstalmentInvoiceViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Novalnet payment method view provider factory
 */
class NovalnetInstalmentInvoiceViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetInstalmentInvoiceViewFactoryInterface */
    private $factory;

    /** @var NovalnetInstalmentInvoiceConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetInstalmentInvoiceViewFactoryInterface $factory
     * @param NovalnetInstalmentInvoiceConfigProviderInterface $configProvider
     */
    public function __construct(
        NovalnetInstalmentInvoiceViewFactoryInterface $factory,
        NovalnetInstalmentInvoiceConfigProviderInterface $configProvider
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
            $this->addNovalnetInstalmentInvoiceView($config);
        }
    }

    /**
     * @param NovalnetConfigInterface $config
     */
    protected function addNovalnetInstalmentInvoiceView(NovalnetInstalmentInvoiceConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
