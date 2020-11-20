<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config;

/**
 * Interface that describes specific configuration for Novalnet payment method
 */
interface NovalnetInvoiceConfigInterface extends NovalnetConfigInterface
{

    /**
     * @return string
     */
    public function getInvoiceDuedate();

    /**
     * @return string
     */
    public function getOnholdAmount();

    /**
     * @return boolean
     */
    public function getInvoicePaymentGuarantee();

    /**
     * @return boolean
     */
    public function getInvoiceGuaranteeMinAmount();

    /**
     * @return boolean
     */
    public function getInvoiceForceNonGuarantee();
}
