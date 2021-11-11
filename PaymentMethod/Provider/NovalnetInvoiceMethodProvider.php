<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetInvoiceConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetInvoiceConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetInvoicePaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetInvoiceMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetInvoicePaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetInvoiceConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetInvoiceConfigProviderInterface $configProvider
     * @param NovalnetInvoicePaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetInvoiceConfigProviderInterface $configProvider,
        NovalnetInvoicePaymentMethodFactoryInterface $factory
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
            $this->addNovalnetInvoicePaymentMethod($config);
        }
    }

    /**
     * @param NovalnetConfigInterface $config
     */
    protected function addNovalnetInvoicePaymentMethod(NovalnetInvoiceConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
