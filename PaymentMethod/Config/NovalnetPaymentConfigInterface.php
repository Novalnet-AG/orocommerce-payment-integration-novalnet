<?php

namespace Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\Config;

use Oro\Bundle\PaymentBundle\Method\Config\PaymentConfigInterface;

/**
 * Interface that describes specific configuration for Novalnet payment method
 */
interface NovalnetPaymentConfigInterface extends PaymentConfigInterface
{
    /**
     * @return string
     */
    public function getVendorId();

    /**
     * @return string
     */
    public function getAuthcode();

    /**
     * @return string
     */
    public function getProduct();

    /**
     * @return string
     */
    public function getTariff();

    /**
     * @return string
     */
    public function getPaymentAccessKey();

    /**
     * @return string
     */
    public function getReferrerId();

    /**
     * @return string
     */
    public function getTestMode();

    /**
     * @return string
     */
    public function getGatewayTimeout();

    /**
     * @return string
     */
    public function getOnholdAmount();

    /**
     * @return string
     */
    public function getInvoiceDueDate();

    /**
     * @return string
     */
    public function getSepaDuedate();

    /**
     * @return string
     */
    public function getCashpaymentDuedate();

    /**
     * @return string
     */
    public function getCc3d();

    /**
     * @return string
     */
    public function getCallbackTestmode();

    /**
     * @return string
     */
    public function getEmailNotification();

    /**
     * @return string
     */
    public function getEmailTo();

    /**
     * @return string
     */
    public function getEmailBcc();

    /**
     * @return string
     */
    public function getNotifyUrl();
}
