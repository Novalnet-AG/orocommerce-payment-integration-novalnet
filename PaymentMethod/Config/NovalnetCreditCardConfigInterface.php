<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Interface that describes specific configuration for Novalnet payment method
 */
interface NovalnetCreditCardConfigInterface extends NovalnetConfigInterface
{

    /**
     * @return integer
     */
    public function getCcEnforce3d();

    /**
     * @return integer
     */
    public function getOnholdAmount();

    /**
     * @return integer
     */
    public function getTestMode();

    /**
     * @return string
     */
    public function getPaymentAction();

    /**
     * @return string
     */
    public function getBuyerNotification();

    /**
     * @return integer
     */
    public function getInlineForm();

    /**
     * @return string
     */
    public function getInputStyle();

    /**
     * @return string
     */
    public function getContainerStyle();

    /**
     * @return string
     */
    public function getLabelStyle();

    /**
     * @return integer
     */
    public function getOneclick();

    /**
     * @return string
     */
    public function getClientKey();

    /**
     * @return array
     */
    public function getCreditCardLogo();
}
