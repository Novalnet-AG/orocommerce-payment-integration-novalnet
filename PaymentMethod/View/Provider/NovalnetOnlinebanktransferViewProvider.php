<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetOnlinebanktransferConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider\NovalnetOnlinebanktransferConfigProviderInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory\NovalnetOnlinebanktransferViewFactoryInterface;
use Oro\Bundle\PaymentBundle\Method\View\AbstractPaymentMethodViewProvider;

/**
 * Novalnet payment method view provider factory
 */
class NovalnetOnlinebanktransferViewProvider extends AbstractPaymentMethodViewProvider
{
    /** @var NovalnetOnlinebanktransferViewFactoryInterface */
    private $factory;

    /** @var NovalnetOnlinebanktransferConfigProviderInterface */
    private $configProvider;

    /**
     * @param NovalnetOnlinebanktransferViewFactoryInterface $factory
     * @param NovalnetOnlinebanktransferConfigProviderInterface $configProvider
     */
    public function __construct(
        NovalnetOnlinebanktransferViewFactoryInterface $factory,
        NovalnetOnlinebanktransferConfigProviderInterface $configProvider
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
            $this->addNovalnetOnlinebanktransferView($config);
        }
    }

    /**
     * @param NovalnetConfigInterface $config
     */
    protected function addNovalnetOnlinebanktransferView(NovalnetOnlinebanktransferConfigInterface $config)
    {
        $this->addView(
            $config->getPaymentMethodIdentifier(),
            $this->factory->create($config)
        );
    }
}
