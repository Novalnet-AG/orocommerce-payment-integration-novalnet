<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

use Oro\Bundle\PaymentBundle\Method\Config\ParameterBag\AbstractParameterBagPaymentConfig;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
abstract class NovalnetConfig extends AbstractParameterBagPaymentConfig implements NovalnetConfigInterface
{
    const TARIFF = 'tariff';
    const PAYMENT_ACCESS_KEY = 'payment_access_key';
    const PRODUCT_ACTIVATION_KEY = 'product_activation_key';
    const CALLBACK_TESTMODE = 'callback_testmode';
    const CALLBACK_EMAILTO = 'email_to';
    const DISPLAY_PAYMENT_LOGO = 'display_payment_logo';

    /**
     * {@inheritDoc}
     */
    public function __construct(array $parameters)
    {
        parent::__construct($parameters);
    }


    /**
     * {@inheritDoc}
     */
    public function getTariff()
    {
        return (int)$this->get(self::TARIFF);
    }

    /**
     * {@inheritDoc}
     */
    public function getPaymentAccessKey()
    {
        return (string)$this->get(self::PAYMENT_ACCESS_KEY);
    }


    /**
     * {@inheritDoc}
     */
    public function getProductActivationKey()
    {
        return (string)$this->get(self::PRODUCT_ACTIVATION_KEY);
    }

    /**
     * {@inheritDoc}
     */
    public function getCallbackTestMode()
    {
        return (int)$this->get(self::CALLBACK_TESTMODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getCallbackEmailTo()
    {
        return (string)$this->get(self::CALLBACK_EMAILTO);
    }

    /**
     * {@inheritDoc}
     */
    public function getDisplayPaymentLogo()
    {
        return (int)$this->get(self::DISPLAY_PAYMENT_LOGO);
    }
}
