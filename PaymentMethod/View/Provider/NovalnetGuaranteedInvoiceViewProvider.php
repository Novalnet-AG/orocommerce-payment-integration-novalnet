<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetGuaranteedInvoiceConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetGuaranteedInvoiceConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetGuaranteedInvoiceViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Novalnet payment method view provider factory
 */
class NovalnetGuaranteedInvoiceViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetGuaranteedInvoiceViewFactoryInterface */
    private $factory;

    /** @var NovalnetGuaranteedInvoiceConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetGuaranteedInvoiceViewFactoryInterface $factory
     * @param NovalnetGuaranteedInvoiceConfigProviderInterface $configProvider
     */
    public function __construct(
        NovalnetGuaranteedInvoiceViewFactoryInterface $factory,
        NovalnetGuaranteedInvoiceConfigProviderInterface $configProvider
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
            $this->addNovalnetGuaranteedInvoiceView($config);
        }
    }

    /**
     * @param NovalnetConfigInterface $config
     */
    protected function addNovalnetGuaranteedInvoiceView(NovalnetGuaranteedInvoiceConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
