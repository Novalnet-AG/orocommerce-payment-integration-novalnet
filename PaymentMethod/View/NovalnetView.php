<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfigInterface;
use Oro\Bundle\PaymentBundle\Context\PaymentContextInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Abstract payment method view
 */
abstract class NovalnetView implements PaymentMethodViewInterface
{
    /**
     * @var NovalnetConfigInterface
     */
    protected $config;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @param NovalnetConfigInterface $config
     */
    public function __construct(FormFactoryInterface $formFactory, NovalnetConfigInterface $config)
    {
        $this->formFactory = $formFactory;
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions(PaymentContextInterface $context)
    {
        return [
            'test_mode' => $this->config->getTestMode()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return $this->config->getLabel();
    }

    /**
     * {@inheritdoc}
     */
    public function getShortLabel()
    {
        return $this->config->getShortLabel();
    }

    /**
     * {@inheritdoc}
     */
    public function getAdminLabel()
    {
        return $this->config->getAdminLabel();
    }

    /** {@inheritdoc} */
    public function getPaymentMethodIdentifier()
    {
        return $this->config->getPaymentMethodIdentifier();
    }
}
