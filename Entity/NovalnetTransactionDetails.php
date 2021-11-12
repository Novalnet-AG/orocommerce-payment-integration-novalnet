<?php

namespace Oro\Bundle\NovalnetPaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="oro_novalnet_payment_transaction_details")
 * @ORM\Entity
 */
class NovalnetTransactionDetails
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var int
     * @ORM\Column(name="tid", type="bigint")
     */
    protected $tid;

    /**
     * @var int
     * @ORM\Column(name="gateway_status", type="integer")
     */
    protected $gatewayStatus;

    /**
     * @var string
     * @ORM\Column(name="test_mode", type="integer")
     */
    protected $testMode;

    /**
     * @var string
     * @ORM\Column(name="amount", type="integer")
     */
    protected $amount;

    /**
     * @var string
     * @ORM\Column(name="currency", type="string")
     */
    protected $currency;
    /**
     * @var string
     * @ORM\Column(name="payment_type", type="text")
     */
    protected $paymentType;
    /**
     * @var string
     * @ORM\Column(name="customer_no", type="string")
     */
    protected $customerNo;
    /**
     * @var string
     * @ORM\Column(name="order_no", type="string")
     */
    protected $orderNo;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTid()
    {
        return $this->tid;
    }

    /**
     * @param string $tid
     * @return NovalnetTransactionDetails
     */
    public function setTid($tid)
    {
        $this->tid = $tid;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return NovalnetTransactionDetails
     */
    public function setAmount($amount)
    {
        $this->amount = (int)$amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return NovalnetTransactionDetails
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }
    /**
     * @return string
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * @param string $paymentType
     * @return NovalnetTransactionDetails
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;

        return $this;
    }
    /**
     * @return string
     */
    public function getCustomerNo()
    {
        return $this->customerNo;
    }

    /**
     * @param string $customerNo
     * @return NovalnetTransactionDetails
     */
    public function setCustomerNo($customerNo)
    {
        $this->customerNo = $customerNo;

        return $this;
    }
    /**
     * @return string
     */
    public function getOrderNo()
    {
        return $this->orderNo;
    }

    /**
     * @param string $orderNo
     * @return NovalnetTransactionDetails
     */
    public function setOrderNo($orderNo)
    {
        $this->orderNo = $orderNo;

        return $this;
    }
}
