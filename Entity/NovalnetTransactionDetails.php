<?php

namespace Novalnet\Bundle\NovalnetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Novalnet transaction details Entity
 * @ORM\Table(name="nn_transaction_details")
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
     * @var integer
     * @ORM\Column(name="tid", type="bigint", length=20, nullable=true)
     */
    protected $tid;

    /**
     * @var integer
     * @ORM\Column(name="gateway_status", type="integer", length=10, nullable=true)
     */
    protected $gatewayStatus;

    /**
     * @var boolean
     * @ORM\Column(name="test_mode", type="boolean", options={"default"=false})
     */
    protected $testMode;

    /**
     * @var integer
     * @ORM\Column(name="amount", type="integer", length=11, nullable=true)
     */
    protected $amount;

    /**
     * @var string
     * @ORM\Column(name="currency", type="string", length=5, nullable=true)
     */
    protected $currency;

    /**
     * @var string
     * @ORM\Column(name="payment_type", type="string", length=80, nullable=true)
     */
    protected $paymentType;

    /**
     * @var string
     * @ORM\Column(name="customer_no", type="string", length=20, nullable=true)
     */
    protected $customerNo;

    /**
     * @var string
     * @ORM\Column(name="order_no", type="string", length=30, nullable=true)
     */
    protected $orderNo;

    /**
     * @return integer
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

    /**
     * @return string
     */
    public function getTestMode()
    {
        return $this->testMode;
    }

    /**
     * @param string $testMode
     * @return NovalnetTransactionDetails
     */
    public function setTestMode($testMode)
    {
        $this->testMode = $testMode;
        return $this;
    }

    /**
     * @return string
     */
    public function getGatewayStatus()
    {
        return $this->gatewayStatus;
    }

    /**
     * @param string $gatewayStatus
     * @return NovalnetTransactionDetails
     */
    public function setGatewayStatus($gatewayStatus)
    {
        $this->gatewayStatus = $gatewayStatus;
        return $this;
    }
}
