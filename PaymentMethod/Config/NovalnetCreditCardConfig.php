<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Configuration class which is used to get specific configuration for Novalnet payment method
 * Usually it has additional get methods for payment type specific configurations
 */
class NovalnetCreditCardConfig extends NovalnetConfig implements NovalnetCreditCardConfigInterface
{

    const ADMIN_LABEL_KEY = 'admin_label';
    const ADMIN_LABEL_SUFFIX = 'CREDIT CARD';
    const CREDITCARD_TESTMODE = 'creditcard_testmode';
    const CREDITCARD_ONHOLD_AMOUNT = 'creditcard_onhold_amount';
    const CREDITCARD_PAYMENT_ACTION = 'creditcard_payment_action';
    const CREDITCARD_NOTIFICATION = 'creditcard_notification';
    const CREDITCARD_INLINE_FORM = 'creditcard_inline_form';
    const CREDITCARD_INPUT_STYLE = 'creditcard_input_style';
    const CREDITCARD_LABEL_STYLE = 'creditcard_label_style';
    const CREDITCARD_CONTAINER_STYLE = 'creditcard_container_style';
    const CREDITCARD_ENFORCE_3D = 'creditcard_enforce_3d';
    const CREDITCARD_ONECLICK = 'creditcard_oneclick';
    const CREDITCARD_CLIENT_KEY = 'creditcard_client_key';
    const CREDITCARD_LOGO = 'creditcard_logo';

    /**
     * {@inheritDoc}
     */
    public function getCcEnforce3d()
    {
        return (int)$this->get(self::CREDITCARD_ENFORCE_3D);
    }

    /**
     * {@inheritDoc}
     */
    public function getOnholdAmount()
    {
        return (int)$this->get(self::CREDITCARD_ONHOLD_AMOUNT);
    }

    /**
     * {@inheritDoc}
     */
    public function getTestMode()
    {
        return (int)$this->get(self::CREDITCARD_TESTMODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getPaymentAction()
    {
        return (string)$this->get(self::CREDITCARD_PAYMENT_ACTION);
    }

    /**
     * {@inheritDoc}
     */
    public function getBuyerNotification()
    {
        return (string)$this->get(self::CREDITCARD_NOTIFICATION);
    }

    /**
     * {@inheritDoc}
     */
    public function getInlineForm()
    {
        return (int)$this->get(self::CREDITCARD_INLINE_FORM);
    }

    /**
     * {@inheritDoc}
     */
    public function getInputStyle()
    {
        return (string)$this->get(self::CREDITCARD_INPUT_STYLE);
    }

    /**
     * {@inheritDoc}
     */
    public function getContainerStyle()
    {
        return (string)$this->get(self::CREDITCARD_CONTAINER_STYLE);
    }

    /**
     * {@inheritDoc}
     */
    public function getLabelStyle()
    {
        return (string)$this->get(self::CREDITCARD_LABEL_STYLE);
    }

    /**
     * {@inheritDoc}
     */
    public function getOneclick()
    {
        return (int)$this->get(self::CREDITCARD_ONECLICK);
    }

    /**
     * {@inheritDoc}
     */
    public function getClientKey()
    {
        return (string)$this->get(self::CREDITCARD_CLIENT_KEY);
    }

    /**
     * {@inheritDoc}
     */
    public function getCreditCardLogo()
    {
        return (array)$this->get(self::CREDITCARD_LOGO);
    }
}
