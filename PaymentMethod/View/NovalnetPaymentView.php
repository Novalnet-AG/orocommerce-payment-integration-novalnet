<?php

namespace Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\View;

use Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\Config\NovalnetPaymentConfigInterface;
use Oro\Bundle\PaymentBundle\Context\PaymentContextInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * View for Novalnet Payment payment method
 */
class NovalnetPaymentView implements PaymentMethodViewInterface
{
    /**
     * @var NovalnetPaymentConfigInterface
     */
    protected $config;

    /**
     * @param NovalnetPaymentConfigInterface $config
     */
    public function __construct(NovalnetPaymentConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions(PaymentContextInterface $context)
    {
        return [
            'vendor_id' => $this->config->getVendorId(),
            'authcode' => $this->config->getAuthcode(),
            'product' => $this->config->getProduct(),
            'tariff' => $this->config->getTariff(),
            'payment_access_key' => $this->config->getPaymentAccessKey(),
            'referrer_id' => $this->config->getReferrerId(),
            'test_mode' => $this->config->getTestMode(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getBlock()
    {
        return '_payment_methods_novalnet_payment_widget';
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
