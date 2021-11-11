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
    const CC3D = 'cc_3d';
    const ONHOLD_AMOUNT = 'onhold_amount';

    /**
     * {@inheritDoc}
     */
    public function getCc3d()
    {
        return (string)$this->get(self::CC3D);
    }

    /**
     * {@inheritDoc}
     */
    public function getOnholdAmount()
    {
        return (string)$this->get(self::ONHOLD_AMOUNT);
    }
}
