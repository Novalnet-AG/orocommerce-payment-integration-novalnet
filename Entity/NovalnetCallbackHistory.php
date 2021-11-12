<?php

namespace Oro\Bundle\NovalnetPaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="oro_novalnet_payment_callback_history")
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
     * @ORM\Column(name="date", type="datetime")
     */
    protected $date;

    /**
     * @var string
     * @ORM\Column(name="callback_amount", type="integer")
     */
    protected $callbackAmount;
    
    /**
     * @var string
     * @ORM\Column(name="order_no", type="string")
     */

    protected $orderNo;
    
    /**
     * @var int
     * @ORM\Column(name="org_tid", type="bigint")
     */
    protected $orgTid;
    
    /**
     * @var int
     * @ORM\Column(name="callback_tid", type="bigint")
     */
    protected $callbackTid;

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
    public function getAmount()
    {
        return $this->amount;
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
}
