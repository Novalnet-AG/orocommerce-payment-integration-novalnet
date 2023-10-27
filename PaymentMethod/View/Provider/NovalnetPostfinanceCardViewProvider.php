<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPostfinanceCardConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetPostfinanceCardConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetPostfinanceCardViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Novalnet payment method view provider factory
 */
class NovalnetPostfinanceCardViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetPostfinanceCardViewFactoryInterface */
    private $factory;

    /** @var NovalnetPostfinanceCardConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetPostfinanceCardViewFactoryInterface $factory
     * @param NovalnetPostfinanceCardConfigProviderInterface $configProvider
     */
    public function __construct(
        NovalnetPostfinanceCardViewFactoryInterface $factory,
        NovalnetPostfinanceCardConfigProviderInterface $configProvider
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
            $this->addNovalnetPostfinanceCardView($config);
        }
    }

    /**
     * @param NovalnetConfigInterface $config
     */
    protected function addNovalnetPostfinanceCardView(NovalnetPostfinanceCardConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
