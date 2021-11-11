<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetCreditCardConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetCreditCardConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetCreditCardViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Novalnet payment method view provider factory
 */
class NovalnetCreditCardViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetCreditCardViewFactoryInterface */
    private $factory;

    /** @var NovalnetCreditCardConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetCreditCardConfigProviderInterface $configProvider
     * @param NovalnetCreditCardPaymentMethodViewFactoryInterface $factory
     */
    public function __construct(
        NovalnetCreditCardViewFactoryInterface $factory,
        NovalnetCreditCardConfigProviderInterface $configProvider
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
            $this->addNovalnetCreditCardView($config);
        }
    }

    /**
     * @param NovalnetConfigInterface $config
     */
    protected function addNovalnetCreditCardView(NovalnetCreditCardConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
