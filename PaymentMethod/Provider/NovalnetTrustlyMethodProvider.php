<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetTrustlyConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetTrustlyConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory\NovalnetTrustlyPaymentMethodFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\AbstractPaymentMethodProvider;

/**
 * Provider for retrieving configured payment method instances
 */
class NovalnetTrustlyMethodProvider extends AbstractPaymentMethodProvider
{
    /**
     * @var NovalnetTrustlyPaymentMethodFactoryInterface
     */
    protected $factory;

    /**
     * @var NovalnetTrustlyConfigProviderInterface
     */
    private $configProvider;

    /**
     * @param NovalnetTrustlyConfigProviderInterface $configProvider
     * @param NovalnetTrustlyPaymentMethodFactoryInterface $factory
     */
    public function __construct(
        NovalnetTrustlyConfigProviderInterface $configProvider,
        NovalnetTrustlyPaymentMethodFactoryInterface $factory
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
            $this->addNovalnetTrustlyPaymentMethod($config);
        }
    }

    /**
     * @param NovalnetTrustlyConfigInterface $config
     */
    protected function addNovalnetTrustlyPaymentMethod(NovalnetTrustlyConfigInterface $config)
    {
        $this->addMethod(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
