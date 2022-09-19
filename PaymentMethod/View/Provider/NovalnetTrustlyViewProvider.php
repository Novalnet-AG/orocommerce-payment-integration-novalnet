<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetTrustlyConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetTrustlyConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetTrustlyViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Novalnet payment method view provider factory
 */
class NovalnetTrustlyViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetTrustlyViewFactoryInterface */
    private $factory;

    /** @var NovalnetTrustlyConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetTrustlyViewFactoryInterface $factory
     * @param NovalnetTrustlyConfigProviderInterface $configProvider
     */
    public function __construct(
        NovalnetTrustlyViewFactoryInterface $factory,
        NovalnetTrustlyConfigProviderInterface $configProvider
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
            $this->addNovalnetTrustlyView($config);
        }
    }

    /**
     * @param NovalnetConfigInterface $config
     */
    protected function addNovalnetTrustlyView(NovalnetTrustlyConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
