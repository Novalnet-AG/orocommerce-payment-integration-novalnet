<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetInstalmentInvoiceConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetInstalmentInvoiceConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetInstalmentInvoicePaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetInstalmentInvoiceMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetInstalmentInvoicePaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetInstalmentInvoiceConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetInstalmentInvoiceConfigProviderInterface $configProvider
     * @param NovalnetInstalmentInvoicePaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetInstalmentInvoiceConfigProviderInterface $configProvider,
        NovalnetInstalmentInvoicePaymentMethodFactoryInterface $factory
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
            $this->addNovalnetInstalmentInvoicePaymentMethod($config);
        }
    }

    /**
     * @param NovalnetInstalmentInvoiceConfigInterface $config
     */
    protected function addNovalnetInstalmentInvoicePaymentMethod(NovalnetInstalmentInvoiceConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
