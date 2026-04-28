<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetInvoiceConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetInvoiceConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetInvoiceViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Novalnet payment method view provider factory
 */
class NovalnetInvoiceViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetInvoiceViewFactoryInterface */
    private $factory;

    /** @var NovalnetInvoiceConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetInvoiceViewFactoryInterface $factory
     * @param NovalnetInvoiceConfigProviderInterface $configProvider
     */
    public function __construct(
        NovalnetInvoiceViewFactoryInterface $factory,
        NovalnetInvoiceConfigProviderInterface $configProvider
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
            $this->addNovalnetInvoiceView($config);
        }
    }

    /**
     * @param NovalnetConfigInterface $config
     */
    protected function addNovalnetInvoiceView(NovalnetInvoiceConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
