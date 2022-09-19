<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetGuaranteedInvoiceConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetGuaranteedInvoiceConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetGuaranteedInvoicePaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetGuaranteedInvoiceMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetGuaranteedInvoicePaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetGuaranteedInvoiceConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetGuaranteedInvoiceConfigProviderInterface $configProvider
     * @param NovalnetGuaranteedInvoicePaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetGuaranteedInvoiceConfigProviderInterface $configProvider,
        NovalnetGuaranteedInvoicePaymentMethodFactoryInterface $factory
    ) {
        parent::__construct();

        $this->configProvider = $configProvider;
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    protected function collectMethods()
    {
        $configs = $this->configProvider->getPaymentConfigs();

        foreach ($configs as $config) {
            $this->addNovalnetGuaranteedInvoicePaymentMethod($config);
        }
    }

    /**
     * @param NovalnetGuaranteedInvoiceConfigInterface $config
     */
    protected function addNovalnetGuaranteedInvoicePaymentMethod(NovalnetGuaranteedInvoiceConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
