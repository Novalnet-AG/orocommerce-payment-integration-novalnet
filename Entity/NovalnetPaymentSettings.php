<?php

namespace Oro\Bundle\NovalnetPaymentBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\IntegrationBundle\Entity\Transport;
use Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * @ORM\Entity(repositoryClass="Oro\Bundle\NovalnetPaymentBundle\Entity\Repository\NovalnetPaymentSettingsRepository")
 */
class NovalnetPaymentSettings extends Transport
{
    /**
     * @var string
     *
     * @ORM\Column(name="vendor_id", type="text", nullable=true)
     */
    private $vendorId;

    /**
     * @var string
     *
     * @ORM\Column(name="authcode", type="text", nullable=true)
     */
    private $authcode;
    
    /**
     * @var string
     *
     * @ORM\Column(name="product", type="text", nullable=true)
     */
    private $product;
    
    /**
     * @var string
     *
     * @ORM\Column(name="tariff", type="text", nullable=true)
     */
    private $tariff;
    
    /**
     * @var string
     *
     * @ORM\Column(name="payment_access_key", type="text", nullable=true)
     */
    private $paymentAccessKey;
    
    /**
     * @var string
     *
     * @ORM\Column(name="referrer_id", type="text", nullable=true)
     */
    private $referrerId;
    
    /**
     * @var string
     *
     * @ORM\Column(name="gateway_timeout", type="text", nullable=true)
     */
    private $gatewayTimeout;

    /**
     * @var string
     *
     * @ORM\Column(name="test_mode", type="boolean", nullable=true)
     */
    private $testMode;

    /**
     * @var string
     *
     * @ORM\Column(name="invoice_duedate", type="text", nullable=true)
     */
    private $invoiceDuedate;

    /**
     * @var string
     *
     * @ORM\Column(name="sepa_duedate", type="text", nullable=true)
     */
    private $sepaDuedate;
    
    /**
     * @var string
     *
     * @ORM\Column(name="barzahlen_duedate", type="text", nullable=true)
     */
    private $cashpaymentDuedate;
    
    /**
     * @var string
     *
     * @ORM\Column(name="cc_3d", type="boolean", nullable=true)
     */
    private $cc3d;
    
    /**
     * @var string
     *
     * @ORM\Column(name="onhold_amount", type="text", nullable=true)
     */
    private $onholdAmount;
   
    /**
     * @var string
     *
     * @ORM\Column(name="callback_testmode", type="boolean", nullable=true)
     */
    private $callbackTestmode;
    
    /**
     * @var string
     *
     * @ORM\Column(name="email_notification", type="boolean", nullable=true)
     */
    private $emailNotification;
    
    /**
     * @var string
     *
     * @ORM\Column(name="email_to", type="text", nullable=true)
     */
    private $emailTo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="email_bcc", type="text", nullable=true)
     */
    private $emailBcc;
    
    /**
     * @var string
     *
     * @ORM\Column(name="notify_url", type="text", nullable=true)
     */
    private $notifyUrl;

    /**
     * @var Collection|LocalizedFallbackValue[]
     *
     * @ORM\ManyToMany(
     *      targetEntity="Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue",
     *      cascade={"ALL"},
     *      orphanRemoval=true
     * )
     * @ORM\JoinTable(
     *      name="oro_novalnet_payment_trans_label",
     *      joinColumns={
     *          @ORM\JoinColumn(name="transport_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="localized_value_id", referencedColumnName="id", onDelete="CASCADE", unique=true)
     *      }
     * )
     */
    private $labels;

    /**
     * @var Collection|LocalizedFallbackValue[]
     *
     * @ORM\ManyToMany(
     *      targetEntity="Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue",
     *      cascade={"ALL"},
     *      orphanRemoval=true
     * )
     * @ORM\JoinTable(
     *      name="oro_novalnet_payment_short_label",
     *      joinColumns={
     *          @ORM\JoinColumn(name="transport_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="localized_value_id", referencedColumnName="id", onDelete="CASCADE", unique=true)
     *      }
     * )
     */
    private $shortLabels;

    /**
     * @var ParameterBag
     */
    private $settings;

    public function __construct()
    {
        $this->labels = new ArrayCollection();
        $this->shortLabels = new ArrayCollection();
    }

    /**
     * @return Collection|LocalizedFallbackValue[]
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * @param LocalizedFallbackValue $label
     *
     * @return NovalnetPaymentSettings
     */
    public function addLabel(LocalizedFallbackValue $label)
    {
        if (!$this->labels->contains($label)) {
            $this->labels->add($label);
        }

        return $this;
    }

    /**
     * @param LocalizedFallbackValue $label
     *
     * @return NovalnetPaymentSettings
     */
    public function removeLabel(LocalizedFallbackValue $label)
    {
        if ($this->labels->contains($label)) {
            $this->labels->removeElement($label);
        }

        return $this;
    }

    /**
     * @return Collection|LocalizedFallbackValue[]
     */
    public function getShortLabels()
    {
        return $this->shortLabels;
    }

    /**
     * @param LocalizedFallbackValue $label
     *
     * @return NovalnetPaymentSettings
     */
    public function addShortLabel(LocalizedFallbackValue $label)
    {
        if (!$this->shortLabels->contains($label)) {
            $this->shortLabels->add($label);
        }

        return $this;
    }

    /**
     * @param LocalizedFallbackValue $label
     *
     * @return NovalnetPaymentSettings
     */
    public function removeShortLabel(LocalizedFallbackValue $label)
    {
        if ($this->shortLabels->contains($label)) {
            $this->shortLabels->removeElement($label);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getVendorId()
    {
        return $this->vendorId;
    }

    /**
     * @param string $vendorId
     *
     * @return NovalnetPaymentSettings
     */
    public function setVendorId($vendorId)
    {
        $this->vendorId = $vendorId;

        return $this;
    }
    
    /**
     * @return string
     */
    public function getAuthcode()
    {
        return $this->authcode;
    }

    /**
     * @param string $authcode
     *
     * @return NovalnetPaymentSettings
     */
    public function setAuthcode($authcode)
    {
        $this->authcode = $authcode;

        return $this;
    }

    /**
     * @return string
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param string $product
     *
     * @return NovalnetPaymentSettings
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return string
     */
    public function getTariff()
    {
        return $this->tariff;
    }

    /**
     * @param string $tariff
     *
     * @return NovalnetPaymentSettings
     */
    public function setTariff($tariff)
    {
        $this->tariff = $tariff;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentAccessKey()
    {
        return $this->paymentAccessKey;
    }

    /**
     * @param string $paymentAccessKey
     *
     * @return NovalnetPaymentSettings
     */
    public function setPaymentAccessKey($paymentAccessKey)
    {
        $this->paymentAccessKey = $paymentAccessKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getReferrerId()
    {
        return $this->referrerId;
    }

    /**
     * @param string $referrerId
     *
     * @return NovalnetPaymentSettings
     */
    public function setReferrerId($referrerId)
    {
        $this->referrerId = $referrerId;

        return $this;
    }
    
    /**
     * @return string
     */
    public function getGatewayTimeout()
    {
        return $this->gatewayTimeout;
    }

    /**
     * @param string $gatewayTimeout
     *
     * @return NovalnetPaymentSettings
     */
    public function setGatewayTimeout($gatewayTimeout)
    {
        $this->gatewayTimeout = $gatewayTimeout;

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
     *
     * @return NovalnetPaymentSettings
     */
    public function setTestMode($testMode)
    {
        $this->testMode = $testMode;

        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceDuedate()
    {
        return $this->invoiceDuedate;
    }

    /**
     * @param string $invoiceDuedate
     *
     * @return NovalnetPaymentSettings
     */
    public function setInvoiceDuedate($invoiceDuedate)
    {
        $this->invoiceDuedate = $invoiceDuedate;

        return $this;
    }
   
    /**
     * @return string
     */
    public function getSepaDuedate()
    {
        return $this->sepaDuedate;
    }

    /**
     * @param string $sepaDuedate
     *
     * @return NovalnetPaymentSettings
     */
    public function setSepaDuedate($sepaDuedate)
    {
        $this->sepaDuedate = $sepaDuedate;

        return $this;
    }
    
    /**
     * @return string
     */
    public function getCashpaymentDuedate()
    {
        return $this->cashpaymentDuedate;
    }

    /**
     * @param string $cashpaymentDuedate
     *
     * @return NovalnetPaymentSettings
     */
    public function setCashpaymentDuedate($cashpaymentDuedate)
    {
        $this->cashpaymentDuedate = $cashpaymentDuedate;

        return $this;
    }

    /**
     * @return string
     */
    public function getCc3d()
    {
        return $this->cc3d;
    }

    /**
     * @param string $cc3d
     *
     * @return NovalnetPaymentSettings
     */
    public function setCc3d($cc3d)
    {
        $this->cc3d = $cc3d;

        return $this;
    }
    
    /**
     * @return string
     */
    public function getOnholdAmount()
    {
        return $this->onholdAmount;
    }

    /**
     * @param string $onholdAmount
     *
     * @return NovalnetPaymentSettings
     */
    public function setOnholdAmount($onholdAmount)
    {
        $this->onholdAmount = $onholdAmount;

        return $this;
    }
    
    /**
     * @return string
     */
    public function getCallbackTestmode()
    {
        return $this->callbackTestmode;
    }

    /**
     * @param string $callbackTestmode
     *
     * @return NovalnetPaymentSettings
     */
    public function setCallbackTestmode($callbackTestmode)
    {
        $this->callbackTestmode = $callbackTestmode;

        return $this;
    }
    
    /**
     * @return string
     */
    public function getEmailNotification()
    {
        return $this->emailNotification;
    }

    /**
     * @param string $emailNotification
     *
     * @return NovalnetPaymentSettings
     */
    public function setEmailNotification($emailNotification)
    {
        $this->emailNotification = $emailNotification;

        return $this;
    }
    
    /**
     * @return string
     */
    public function getEmailTo()
    {
        return $this->emailTo;
    }

    /**
     * @param string $emailTo
     *
     * @return NovalnetPaymentSettings
     */
    public function setEmailTo($emailTo)
    {
        $this->emailTo = $emailTo;

        return $this;
    }
    /**
     * @return string
     */
    public function getEmailBcc()
    {
        return $this->emailBcc;
    }

    /**
     * @param string $emailBcc
     *
     * @return NovalnetPaymentSettings
     */
    public function setEmailBcc($emailBcc)
    {
        $this->emailBcc = $emailBcc;

        return $this;
    }
    /**
     * @return string
     */
    public function getNotifyUrl()
    {
        return $this->notifyUrl;
    }

    /**
     * @param string $notifyUrl
     *
     * @return NovalnetPaymentSettings
     */
    public function setNotifyUrl($notifyUrl)
    {
        $this->notifyUrl = $notifyUrl;

        return $this;
    }

    /**
     * @return ParameterBag
     */
    public function getSettingsBag()
    {
        if (null === $this->settings) {
            $this->settings = new ParameterBag(
                [
                    'vendor_id' => $this->getVendorId(),
                    'authcode' => $this->getAuthcode(),
                    'product' => $this->getProduct(),
                    'tariff' => $this->getTariff(),
                    'payment_access_key' => $this->getPaymentAccessKey(),
                    'referrer_id' => $this->getReferrerId(),
                    'labels' => $this->getLabels()->toArray(),
                    'gateway_timeout' => $this->getGatewayTimeout(),
                    'test_mode' => $this->getTestMode(),
                    'invoice_duedate' => $this->getInvoiceDuedate(),
                    'sepa_duedate' => $this->getSepaDuedate(),
                    'cashpayment_duedate' => $this->getCashpaymentDuedate(),
                    'cc_3d' => $this->getCc3d(),
                    'onhold_amount' => $this->getOnholdAmount(),
                    'callback_testmode' => $this->getCallbackTestmode(),
                    'email_notification' => $this->getEmailNotification(),
                    'email_to' => $this->getEmailTo(),
                    'email_bcc' => $this->getEmailBcc(),
                    'notify_url' => $this->getNotifyUrl(),
                ]
            );
        }

        return $this->settings;
    }
}
