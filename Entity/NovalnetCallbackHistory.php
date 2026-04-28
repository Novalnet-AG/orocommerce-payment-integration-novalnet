<?php

namespace Novalnet\Bundle\NovalnetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Novalnet callback script history Entity
 * @ORM\Table(name="nn_callback_history")
 * @ORM\Entity
 */
class NovalnetCallbackHistory
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
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    protected $date;

    /**
     * @var string
     * @ORM\Column(name="callback_amount", type="integer", length=11, nullable=true)
     */
    protected $callbackAmount;

    /**
     * @var string
     * @ORM\Column(name="order_no", type="string", length=30, nullable=true)
     */
    protected $orderNo;

    /**
     * @var int
     * @ORM\Column(name="org_tid", type="bigint", length=20, nullable=true)
     */
    protected $orgTid;

    /**
     * @var int
     * @ORM\Column(name="callback_tid", type="bigint", length=20, nullable=true)
     */
    protected $callbackTid;

    /**
     * @var string
     * @ORM\Column(name="payment_type", type="string", length=64, nullable=true)
     */
    protected $paymentType;

    /**
     * @var string
     * @ORM\Column(name="event_type", type="string", length=64, nullable=true)
     */
    protected $eventType;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCallbackAmount()
    {
        return $this->callbackAmount;
    }

    /**
     * @param int $callbackAmount
     * @return NovalnetCallbackHistory
     */
    public function setCallbackAmount($callbackAmount)
    {
        $this->callbackAmount = (int)$callbackAmount;

        return $this;
    }

    /**
     * @return string
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * @param int $eventType
     * @return NovalnetCallbackHistory
     */
    public function setEventType($eventType)
    {
        $this->eventType = $eventType;

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
     * @param int $paymentType
     * @return NovalnetCallbackHistory
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;
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
     * @return NovalnetCallbackHistory
     */
    public function setOrderNo($orderNo)
    {
        $this->orderNo = $orderNo;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrgTid()
    {
        return $this->orgTid;
    }

    /**
     * @param string $orgTid
     * @return NovalnetCallbackHistory
     */
    public function setOrgTid($orgTid)
    {
        $this->orgTid = $orgTid;

        return $this;
    }

    /**
     * @return string
     */
    public function getCallbackTid()
    {
        return $this->callbackTid;
    }

    /**
     * @param string $callbackTid
     * @return NovalnetCallbackHistory
     */
    public function setCallbackTid($callbackTid)
    {
        $this->callbackTid = $callbackTid;

        return $this;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return NovalnetCallbackHistory
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }
}
