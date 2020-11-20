<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetCreditCardPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetHelper;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetCreditCardConfigInterface;
use Symfony\Component\Routing\RouterInterface;
use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Symfony\Component\HttpFoundation\RequestStack;
use Oro\Bundle\FrontendLocalizationBundle\Manager\UserLocalizationManager;
use Novalnet\Bundle\NovalnetBundle\Client\GatewayInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetCreditCardConfigInterface $config
 * NovalnetCreditCardPaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetCreditCardPaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetCreditCardPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetSepaConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetCreditCardConfigInterface $config)
    {
        return new NovalnetCreditCardPaymentMethod(
            $config,
            $this->routerInterface,
            $this->doctrineHelper,
            $this->novalnetHelper,
            $this->requestStack,
            $this->translator,
            $this->userLocalizationManager,
            $this->client
        );
    }
}
