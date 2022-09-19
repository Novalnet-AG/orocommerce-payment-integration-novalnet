<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetInstalmentSepaPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetInstalmentSepaConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetInstalmentSepaConfigInterface $config
 * NovalnetInstalmentSepaPaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetInstalmentSepaPaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetInstalmentSepaPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetInstalmentSepaConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetInstalmentSepaConfigInterface $config)
    {
        return new NovalnetInstalmentSepaPaymentMethod(
            $config,
            $this->routerInterface,
            $this->doctrineHelper,
            $this->novalnetHelper,
            $this->requestStack,
            $this->translator,
            $this->userLocalizationManager,
            $this->client,
            $this->paymentMethodProvider
        );
    }
}
