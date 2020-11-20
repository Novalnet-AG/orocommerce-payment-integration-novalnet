<?php

namespace Novalnet\Bundle\NovalnetBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\IntegrationBundle\Entity\Transport;
use Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Entity which store Novalnet integration settings
 * @ORM\Entity(repositoryClass="Novalnet\Bundle\NovalnetBundle\Entity\Repository\NovalnetSettingsRepository")
 */
class NovalnetSettings extends Transport
{
    /**
     * @var integer
     *
     * @ORM\Column(name="nn_vendor_id", type="integer", length=5, nullable=true)
     */
    private $vendorId;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_authcode", type="string", length=32, nullable=true)
     */
    private $authcode;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_product", type="integer", length=5, nullable=true)
     */
    private $product;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_tariff", type="integer", length=5, nullable=true)
     */
    private $tariff;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_access_key", type="string", length=50, nullable=true)
     */
    private $paymentAccessKey;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_referrer_id", type="integer", length=10, nullable=true)
     */
    private $referrerId;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_gateway_timeout", type="integer", length=5, nullable=true)
     */
    private $gatewayTimeout;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_test_mode", type="boolean", options={"default"=false})
     */
    private $testMode;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_invoice_duedate", type="integer", length=2, nullable=true)
     */
    private $invoiceDuedate;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_invoice_guarantee", type="boolean", options={"default"=false})
     */
    private $invoicePaymentGuarantee;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_inv_guarantee_min_amount", type="integer", length=11, nullable=true)
     */
    private $invoiceGuaranteeMinAmount;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_inv_force_non_guarantee", type="boolean", options={"default"=false})
     */
    private $invoiceForceNonGuarantee;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_sepa_duedate", type="integer", length=2, nullable=true)
     */
    private $sepaDuedate;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_sepa_guarantee", type="boolean", options={"default"=false})
     */
    private $sepaPaymentGuarantee;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_sepa_guarantee_min_amount", type="integer", length=11, nullable=true)
     */
    private $sepaGuaranteeMinAmount;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_sepa_force_non_guarantee", type="boolean", options={"default"=false})
     */
    private $sepaForceNonGuarantee;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_barzahlen_duedate", type="integer", length=2, nullable=true)
     */
    private $cashpaymentDuedate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_cc_3d", type="boolean", options={"default"=false})
     */
    private $cc3d;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_onhold_amount", type="integer", length=11, nullable=true)
     */
    private $onholdAmount;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_callback_testmode", type="boolean",options={"default"=false})
     */
    private $callbackTestmode;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_email_notification", type="boolean", options={"default"=false})
     */
    private $emailNotification;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_email_to", type="string", length=255, nullable=true)
     */
    private $emailTo;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_email_bcc", type="string", length=255, nullable=true)
     */
    private $emailBcc;

    /**
     * @var Collection|LocalizedFallbackValue[]
     *
     * @ORM\ManyToMany(
     *      targetEntity="Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue",
     *      cascade={"ALL"},
     *      orphanRemoval=true
     * )
     * @ORM\JoinTable(
     *      name="nn_credit_card_lbl",
     *      joinColumns={
     *          @ORM\JoinColumn(name="transport_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="localized_value_id", referencedColumnName="id", onDelete="CASCADE", unique=true)
     *      }
     * )
     */
    private $creditCardLabels;

    /**
     * @var Collection|LocalizedFallbackValue[]
     *
     * @ORM\ManyToMany(
     *      targetEntity="Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue",
     *      cascade={"ALL"},
     *      orphanRemoval=true
     * )
     * @ORM\JoinTable(
     *      name="nn_credit_card_sh_lbl",
     *      joinColumns={
     *          @ORM\JoinColumn(name="transport_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="localized_value_id", referencedColumnName="id", onDelete="CASCADE", unique=true)
     *      }
     * )
     */
    private $creditCardShortLabels;

    /**
     * @var Collection|LocalizedFallbackValue[]
     *
     * @ORM\ManyToMany(
     *      targetEntity="Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue",
     *      cascade={"ALL"},
     *      orphanRemoval=true
     * )
     * @ORM\JoinTable(
     *      name="nn_sepa_lbl",
     *      joinColumns={
     *          @ORM\JoinColumn(name="transport_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="localized_value_id", referencedColumnName="id", onDelete="CASCADE", unique=true)
     *      }
     * )
     */
    private $sepaLabels;

    /**
     * @var Collection|LocalizedFallbackValue[]
     *
     * @ORM\ManyToMany(
     *      targetEntity="Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue",
     *      cascade={"ALL"},
     *      orphanRemoval=true
     * )
     * @ORM\JoinTable(
     *      name="nn_sepa_sh_lbl",
     *      joinColumns={
     *          @ORM\JoinColumn(name="transport_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="localized_value_id", referencedColumnName="id", onDelete="CASCADE", unique=true)
     *      }
     * )
     */
    private $sepaShortLabels;

    /**
     * @var Collection|LocalizedFallbackValue[]
     *
     * @ORM\ManyToMany(
     *      targetEntity="Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue",
     *      cascade={"ALL"},
     *      orphanRemoval=true
     * )
     * @ORM\JoinTable(
     *      name="nn_invoice_lbl",
     *      joinColumns={
     *          @ORM\JoinColumn(name="transport_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="localized_value_id", referencedColumnName="id", onDelete="CASCADE", unique=true)
     *      }
     * )
     */
    private $invoiceLabels;

    /**
     * @var Collection|LocalizedFallbackValue[]
     *
     * @ORM\ManyToMany(
     *      targetEntity="Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue",
     *      cascade={"ALL"},
     *      orphanRemoval=true
     * )
     * @ORM\JoinTable(
     *      name="nn_invoice_sh_lbl",
     *      joinColumns={
     *          @ORM\JoinColumn(name="transport_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="localized_value_id", referencedColumnName="id", onDelete="CASCADE", unique=true)
     *      }
     * )
     */
    private $invoiceShortLabels;

    /**
     * @var Collection|LocalizedFallbackValue[]
     *
     * @ORM\ManyToMany(
     *      targetEntity="Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue",
     *      cascade={"ALL"},
     *      orphanRemoval=true
     * )
     * @ORM\JoinTable(
     *      name="nn_prepayment_lbl",
     *      joinColumns={
     *          @ORM\JoinColumn(name="transport_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="localized_value_id", referencedColumnName="id", onDelete="CASCADE", unique=true)
     *      }
     * )
     */
    private $prepaymentLabels;

    /**
     * @var Collection|LocalizedFallbackValue[]
     *
     * @ORM\ManyToMany(
     *      targetEntity="Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue",
     *      cascade={"ALL"},
     *      orphanRemoval=true
     * )
     * @ORM\JoinTable(
     *      name="nn_prepayment_sh_lbl",
     *      joinColumns={
     *          @ORM\JoinColumn(name="transport_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="localized_value_id", referencedColumnName="id", onDelete="CASCADE", unique=true)
     *      }
     * )
     */
    private $prepaymentShortLabels;

    /**
     * @var Collection|LocalizedFallbackValue[]
     *
     * @ORM\ManyToMany(
     *      targetEntity="Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue",
     *      cascade={"ALL"},
     *      orphanRemoval=true
     * )
     * @ORM\JoinTable(
     *      name="nn_cashpayment_lbl",
     *      joinColumns={
     *          @ORM\JoinColumn(name="transport_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="localized_value_id", referencedColumnName="id", onDelete="CASCADE", unique=true)
     *      }
     * )
     */
    private $cashpaymentLabels;

    /**
     * @var Collection|LocalizedFallbackValue[]
     *
     * @ORM\ManyToMany(
     *      targetEntity="Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue",
     *      cascade={"ALL"},
     *      orphanRemoval=true
     * )
     * @ORM\JoinTable(
     *      name="nn_cashpayment_sh_lbl",
     *      joinColumns={
     *          @ORM\JoinColumn(name="transport_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="localized_value_id", referencedColumnName="id", onDelete="CASCADE", unique=true)
     *      }
     * )
     */
    private $cashpaymentShortLabels;

    /**
     * @var Collection|LocalizedFallbackValue[]
     *
     * @ORM\ManyToMany(
     *      targetEntity="Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue",
     *      cascade={"ALL"},
     *      orphanRemoval=true
     * )
     * @ORM\JoinTable(
     *      name="nn_paypal_lbl",
     *      joinColumns={
     *          @ORM\JoinColumn(name="transport_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="localized_value_id", referencedColumnName="id", onDelete="CASCADE", unique=true)
     *      }
     * )
     */
    private $paypalLabels;

    /**
     * @var Collection|LocalizedFallbackValue[]
     *
     * @ORM\ManyToMany(
     *      targetEntity="Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue",
     *      cascade={"ALL"},
     *      orphanRemoval=true
     * )
     * @ORM\JoinTable(
     *      name="nn_paypal_sh_lbl",
     *      joinColumns={
     *          @ORM\JoinColumn(name="transport_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="localized_value_id", referencedColumnName="id", onDelete="CASCADE", unique=true)
     *      }
     * )
     */
    private $paypalShortLabels;

    /**
     * @var Collection|LocalizedFallbackValue[]
     *
     * @ORM\ManyToMany(
     *      targetEntity="Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue",
     *      cascade={"ALL"},
     *      orphanRemoval=true
     * )
     * @ORM\JoinTable(
     *      name="nn_banktransfer_lbl",
     *      joinColumns={
     *          @ORM\JoinColumn(name="transport_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="localized_value_id", referencedColumnName="id", onDelete="CASCADE", unique=true)
     *      }
     * )
     */
    private $banktransferLabels;

    /**
     * @var Collection|LocalizedFallbackValue[]
     *
     * @ORM\ManyToMany(
     *      targetEntity="Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue",
     *      cascade={"ALL"},
     *      orphanRemoval=true
     * )
     * @ORM\JoinTable(
     *      name="nn_banktransfer_sh_lbl",
     *      joinColumns={
     *          @ORM\JoinColumn(name="transport_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="localized_value_id", referencedColumnName="id", onDelete="CASCADE", unique=true)
     *      }
     * )
     */
    private $banktransferShortLabels;

    /**
     * @var Collection|LocalizedFallbackValue[]
     *
     * @ORM\ManyToMany(
     *      targetEntity="Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue",
     *      cascade={"ALL"},
     *      orphanRemoval=true
     * )
     * @ORM\JoinTable(
     *      name="nn_ideal_lbl",
     *      joinColumns={
     *          @ORM\JoinColumn(name="transport_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="localized_value_id", referencedColumnName="id", onDelete="CASCADE", unique=true)
     *      }
     * )
     */
    private $idealLabels;

    /**
     * @var Collection|LocalizedFallbackValue[]
     *
     * @ORM\ManyToMany(
     *      targetEntity="Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue",
     *      cascade={"ALL"},
     *      orphanRemoval=true
     * )
     * @ORM\JoinTable(
     *      name="nn_ideal_sh_lbl",
     *      joinColumns={
     *          @ORM\JoinColumn(name="transport_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="localized_value_id", referencedColumnName="id", onDelete="CASCADE", unique=true)
     *      }
     * )
     */
    private $idealShortLabels;

    /**
     * @var Collection|LocalizedFallbackValue[]
     *
     * @ORM\ManyToMany(
     *      targetEntity="Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue",
     *      cascade={"ALL"},
     *      orphanRemoval=true
     * )
     * @ORM\JoinTable(
     *      name="nn_eps_lbl",
     *      joinColumns={
     *          @ORM\JoinColumn(name="transport_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="localized_value_id", referencedColumnName="id", onDelete="CASCADE", unique=true)
     *      }
     * )
     */
    private $epsLabels;

    /**
     * @var Collection|LocalizedFallbackValue[]
     *
     * @ORM\ManyToMany(
     *      targetEntity="Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue",
     *      cascade={"ALL"},
     *      orphanRemoval=true
     * )
     * @ORM\JoinTable(
     *      name="nn_eps_sh_lbl",
     *      joinColumns={
     *          @ORM\JoinColumn(name="transport_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="localized_value_id", referencedColumnName="id", onDelete="CASCADE", unique=true)
     *      }
     * )
     */
    private $epsShortLabels;

    /**
     * @var Collection|LocalizedFallbackValue[]
     *
     * @ORM\ManyToMany(
     *      targetEntity="Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue",
     *      cascade={"ALL"},
     *      orphanRemoval=true
     * )
     * @ORM\JoinTable(
     *      name="nn_giropay_lbl",
     *      joinColumns={
     *          @ORM\JoinColumn(name="transport_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="localized_value_id", referencedColumnName="id", onDelete="CASCADE", unique=true)
     *      }
     * )
     */
    private $giropayLabels;

    /**
     * @var Collection|LocalizedFallbackValue[]
     *
     * @ORM\ManyToMany(
     *      targetEntity="Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue",
     *      cascade={"ALL"},
     *      orphanRemoval=true
     * )
     * @ORM\JoinTable(
     *      name="nn_giropay_sh_lbl",
     *      joinColumns={
     *          @ORM\JoinColumn(name="transport_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="localized_value_id", referencedColumnName="id", onDelete="CASCADE", unique=true)
     *      }
     * )
     */
    private $giropayShortLabels;

    /**
     * @var Collection|LocalizedFallbackValue[]
     *
     * @ORM\ManyToMany(
     *      targetEntity="Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue",
     *      cascade={"ALL"},
     *      orphanRemoval=true
     * )
     * @ORM\JoinTable(
     *      name="nn_przelewy_lbl",
     *      joinColumns={
     *          @ORM\JoinColumn(name="transport_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="localized_value_id", referencedColumnName="id", onDelete="CASCADE", unique=true)
     *      }
     * )
     */
    private $przelewyLabels;

    /**
     * @var Collection|LocalizedFallbackValue[]
     *
     * @ORM\ManyToMany(
     *      targetEntity="Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue",
     *      cascade={"ALL"},
     *      orphanRemoval=true
     * )
     * @ORM\JoinTable(
     *      name="nn_przelewy_sh_lbl",
     *      joinColumns={
     *          @ORM\JoinColumn(name="transport_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="localized_value_id", referencedColumnName="id", onDelete="CASCADE", unique=true)
     *      }
     * )
     */
    private $przelewyShortLabels;

    /**
     * @var ParameterBag
     */
    private $settings;

    public function __construct()
    {
        $this->creditCardLabels = new ArrayCollection();
        $this->creditCardShortLabels = new ArrayCollection();
        $this->sepaLabels = new ArrayCollection();
        $this->sepaShortLabels = new ArrayCollection();
        $this->invoiceLabels = new ArrayCollection();
        $this->invoiceShortLabels = new ArrayCollection();
        $this->prepaymentLabels = new ArrayCollection();
        $this->prepaymentShortLabels = new ArrayCollection();
        $this->cashpaymentLabels = new ArrayCollection();
        $this->cashpaymentShortLabels = new ArrayCollection();
        $this->paypalLabels = new ArrayCollection();
        $this->paypalShortLabels = new ArrayCollection();
        $this->banktransferLabels = new ArrayCollection();
        $this->banktransferShortLabels = new ArrayCollection();
        $this->idealLabels = new ArrayCollection();
        $this->idealShortLabels = new ArrayCollection();
        $this->giropayLabels = new ArrayCollection();
        $this->giropayShortLabels = new ArrayCollection();
        $this->epsLabels = new ArrayCollection();
        $this->epsShortLabels = new ArrayCollection();
        $this->przelewyLabels = new ArrayCollection();
        $this->przelewyShortLabels = new ArrayCollection();
    }

    /**
     * Add creditCardLabel.
     *
     * @param LocalizedFallbackValue $creditCardLabel
     *
     * @return $this
     */
    public function addCreditCardLabel(LocalizedFallbackValue $creditCardLabel)
    {
        return $this->addLabel($this->creditCardLabels, $creditCardLabel);
    }

    /**
     * Remove creditCardLabel.
     *
     * @param LocalizedFallbackValue $creditCardLabel
     *
     * @return $this
     */
    public function removeCreditCardLabel(LocalizedFallbackValue $creditCardLabel)
    {
        return $this->removeLabel($this->creditCardLabels, $creditCardLabel);
    }

    /**
     * Get creditCardLabels.
     *
     * @return Collection
     */
    public function getCreditCardLabels()
    {
        return $this->creditCardLabels;
    }

    /**
     * Add creditCardShortLabel.
     *
     * @param LocalizedFallbackValue $creditCardShortLabel
     *
     * @return $this
     */
    public function addCreditCardShortLabel(LocalizedFallbackValue $creditCardShortLabel)
    {
        return $this->addLabel($this->creditCardShortLabels, $creditCardShortLabel);
    }

    /**
     * Remove creditCardShortLabel.
     *
     * @param LocalizedFallbackValue $creditCardShortLabel
     *
     * @return $this
     */
    public function removeCreditCardShortLabel(LocalizedFallbackValue $creditCardShortLabel)
    {
        return $this->removeLabel($this->creditCardShortLabels, $creditCardShortLabel);
    }

    /**
     * Get creditCardShortLabels.
     *
     * @return Collection
     */
    public function getCreditCardShortLabels()
    {
        return $this->creditCardShortLabels;
    }

    /**
     * Add sepaLabel.
     *
     * @param LocalizedFallbackValue $sepaLabel
     *
     * @return $this
     */
    public function addSepaLabel(LocalizedFallbackValue $sepaLabel)
    {
        return $this->addLabel($this->sepaLabels, $sepaLabel);
    }

    /**
     * Remove sepaLabel.
     *
     * @param LocalizedFallbackValue $sepaLabel
     *
     * @return $this
     */
    public function removeSepaLabel(LocalizedFallbackValue $sepaLabel)
    {
        return $this->removeLabel($this->sepaLabels, $sepaLabel);
    }

    /**
     * Get sepaLabel.
     *
     * @return Collection
     */
    public function getSepaLabels()
    {
        return $this->sepaLabels;
    }

    /**
     * Add sepaShortLabel.
     *
     * @param LocalizedFallbackValue $sepaShortLabel
     *
     * @return $this
     */
    public function addSepaShortLabel(LocalizedFallbackValue $sepaShortLabel)
    {
        return $this->addLabel($this->sepaShortLabels, $sepaShortLabel);
    }

    /**
     * Remove sepaShortLabel.
     *
     * @param LocalizedFallbackValue $sepaShortLabel
     *
     * @return $this
     */
    public function removeSepaShortLabel(LocalizedFallbackValue $sepaShortLabel)
    {
        return $this->removeLabel($this->sepaShortLabels, $sepaShortLabel);
    }

    /**
     * Get sepaShortLabel.
     *
     * @return Collection
     */
    public function getSepaShortLabels()
    {
        return $this->sepaShortLabels;
    }

    /**
     * Add invoiceLabel.
     *
     * @param LocalizedFallbackValue $invoiceLabel
     *
     * @return $this
     */
    public function addInvoiceLabel(LocalizedFallbackValue $invoiceLabel)
    {
        return $this->addLabel($this->invoiceLabels, $invoiceLabel);
    }

    /**
     * Remove invoiceLabel.
     *
     * @param LocalizedFallbackValue $invoiceLabel
     *
     * @return $this
     */
    public function removeInvoiceLabel(LocalizedFallbackValue $invoiceLabel)
    {
        return $this->removeLabel($this->invoiceLabels, $invoiceLabel);
    }

    /**
     * Get invoiceLabel.
     *
     * @return Collection
     */
    public function getInvoiceLabels()
    {
        return $this->invoiceLabels;
    }

    /**
     * Add invoiceShortLabel.
     *
     * @param LocalizedFallbackValue $invoiceShortLabel
     *
     * @return $this
     */
    public function addInvoiceShortLabel(LocalizedFallbackValue $invoiceShortLabel)
    {
        return $this->addLabel($this->invoiceShortLabels, $invoiceShortLabel);
    }

    /**
     * Remove invoiceShortLabel.
     *
     * @param LocalizedFallbackValue $invoiceShortLabel
     *
     * @return $this
     */
    public function removeInvoiceShortLabel(LocalizedFallbackValue $invoiceShortLabel)
    {
        return $this->removeLabel($this->invoiceShortLabels, $invoiceShortLabel);
    }

    /**
     * Get invoiceShortLabel.
     *
     * @return Collection
     */
    public function getInvoiceShortLabels()
    {
        return $this->invoiceShortLabels;
    }

    /**
     * @return string
     */
    public function getInvoicePaymentGuarantee()
    {
        return $this->invoicePaymentGuarantee;
    }

    /**
     * @param string $invoicePaymentGuarantee
     *
     * @return NovalnetSettings
     */
    public function setInvoicePaymentGuarantee($invoicePaymentGuarantee)
    {
        $this->invoicePaymentGuarantee = $invoicePaymentGuarantee;

        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceGuaranteeMinAmount()
    {
        return $this->invoiceGuaranteeMinAmount;
    }

    /**
     * @param string $invoiceGuaranteeMinAmount
     *
     * @return NovalnetSettings
     */
    public function setInvoiceGuaranteeMinAmount($invoiceGuaranteeMinAmount)
    {
        $this->invoiceGuaranteeMinAmount = $invoiceGuaranteeMinAmount;

        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceForceNonGuarantee()
    {
        return $this->invoiceForceNonGuarantee;
    }

    /**
     * @param string $invoiceForceNonGuarantee
     *
     * @return NovalnetSettings
     */
    public function setInvoiceForceNonGuarantee($invoiceForceNonGuarantee)
    {
        $this->invoiceForceNonGuarantee = $invoiceForceNonGuarantee;

        return $this;
    }

    /**
     * @return string
     */
    public function getSepaPaymentGuarantee()
    {
        return $this->sepaPaymentGuarantee;
    }

    /**
     * @param string $sepaPaymentGuarantee
     *
     * @return NovalnetSettings
     */
    public function setSepaPaymentGuarantee($sepaPaymentGuarantee)
    {
        $this->sepaPaymentGuarantee = $sepaPaymentGuarantee;

        return $this;
    }

    /**
     * @return string
     */
    public function getSepaGuaranteeMinAmount()
    {
        return $this->sepaGuaranteeMinAmount;
    }

    /**
     * @param string $sepaGuaranteeMinAmount
     *
     * @return NovalnetSettings
     */
    public function setSepaGuaranteeMinAmount($sepaGuaranteeMinAmount)
    {
        $this->sepaGuaranteeMinAmount = $sepaGuaranteeMinAmount;

        return $this;
    }

    /**
     * @return string
     */
    public function getSepaForceNonGuarantee()
    {
        return $this->sepaForceNonGuarantee;
    }

    /**
     * @param string $sepaForceNonGuarantee
     *
     * @return NovalnetSettings
     */
    public function setSepaForceNonGuarantee($sepaForceNonGuarantee)
    {
        $this->sepaForceNonGuarantee = $sepaForceNonGuarantee;

        return $this;
    }

    /**
     * Add prepaymentLabel.
     *
     * @param LocalizedFallbackValue $prepaymentLabel
     *
     * @return $this
     */
    public function addPrepaymentLabel(LocalizedFallbackValue $prepaymentLabel)
    {
        return $this->addLabel($this->prepaymentLabels, $prepaymentLabel);
    }

    /**
     * Remove prepaymentLabel.
     *
     * @param LocalizedFallbackValue $prepaymentLabel
     *
     * @return $this
     */
    public function removePrepaymentLabel(LocalizedFallbackValue $prepaymentLabel)
    {
        return $this->removeLabel($this->prepaymentLabels, $prepaymentLabel);
    }

    /**
     * Get prepaymentLabel.
     *
     * @return Collection
     */
    public function getPrepaymentLabels()
    {
        return $this->prepaymentLabels;
    }

    /**
     * Add prepaymentShortLabel.
     *
     * @param LocalizedFallbackValue $prepaymentShortLabel
     *
     * @return $this
     */
    public function addPrepaymentShortLabel(LocalizedFallbackValue $prepaymentShortLabel)
    {
        return $this->addLabel($this->prepaymentShortLabels, $prepaymentShortLabel);
    }

    /**
     * Remove prepaymentShortLabel.
     *
     * @param LocalizedFallbackValue $prepaymentShortLabel
     *
     * @return $this
     */
    public function removePrepaymentShortLabel(LocalizedFallbackValue $prepaymentShortLabel)
    {
        return $this->removeLabel($this->prepaymentShortLabels, $prepaymentShortLabel);
    }

    /**
     * Get prepaymentShortLabel.
     *
     * @return Collection
     */
    public function getPrepaymentShortLabels()
    {
        return $this->prepaymentShortLabels;
    }

    /**
     * Add cashpaymentLabel.
     *
     * @param LocalizedFallbackValue $cashpaymentLabel
     *
     * @return $this
     */
    public function addCashpaymentLabel(LocalizedFallbackValue $cashpaymentLabel)
    {
        return $this->addLabel($this->cashpaymentLabels, $cashpaymentLabel);
    }

    /**
     * Remove cashpaymentLabel.
     *
     * @param LocalizedFallbackValue $cashpaymentLabel
     *
     * @return $this
     */
    public function removeCashpaymentLabel(LocalizedFallbackValue $cashpaymentLabel)
    {
        return $this->removeLabel($this->cashpaymentLabels, $cashpaymentLabel);
    }

    /**
     * Get cashpaymentLabel.
     *
     * @return Collection
     */
    public function getCashpaymentLabels()
    {
        return $this->cashpaymentLabels;
    }

    /**
     * Add cashpaymentShortLabel.
     *
     * @param LocalizedFallbackValue $cashpaymentShortLabel
     *
     * @return $this
     */
    public function addCashpaymentShortLabel(LocalizedFallbackValue $cashpaymentShortLabel)
    {
        return $this->addLabel($this->cashpaymentShortLabels, $cashpaymentShortLabel);
    }

    /**
     * Remove cashpaymentShortLabel.
     *
     * @param LocalizedFallbackValue $cashpaymentShortLabel
     *
     * @return $this
     */
    public function removeCashpaymentShortLabel(LocalizedFallbackValue $cashpaymentShortLabel)
    {
        return $this->removeLabel($this->cashpaymentShortLabels, $cashpaymentShortLabel);
    }

    /**
     * Get cashpaymentShortLabel.
     *
     * @return Collection
     */
    public function getCashpaymentShortLabels()
    {
        return $this->cashpaymentShortLabels;
    }

    /**
     * Add paypalLabel.
     *
     * @param LocalizedFallbackValue $paypalLabel
     *
     * @return $this
     */
    public function addPaypalLabel(LocalizedFallbackValue $paypalLabel)
    {
        return $this->addLabel($this->paypalLabels, $paypalLabel);
    }

    /**
     * Remove paypalLabel.
     *
     * @param LocalizedFallbackValue $paypalLabel
     *
     * @return $this
     */
    public function removePaypalLabel(LocalizedFallbackValue $paypalLabel)
    {
        return $this->removeLabel($this->paypalLabels, $paypalLabel);
    }

    /**
     * Get paypalLabel.
     *
     * @return Collection
     */
    public function getPaypalLabels()
    {
        return $this->paypalLabels;
    }

    /**
     * Add paypalShortLabel.
     *
     * @param LocalizedFallbackValue $paypalShortLabel
     *
     * @return $this
     */
    public function addPaypalShortLabel(LocalizedFallbackValue $paypalShortLabel)
    {
        return $this->addLabel($this->paypalShortLabels, $paypalShortLabel);
    }

    /**
     * Remove paypalShortLabel.
     *
     * @param LocalizedFallbackValue $paypalShortLabel
     *
     * @return $this
     */
    public function removePaypalShortLabel(LocalizedFallbackValue $paypalShortLabel)
    {
        return $this->removeLabel($this->paypalShortLabels, $paypalShortLabel);
    }

    /**
     * Get paypalShortLabel.
     *
     * @return Collection
     */
    public function getPaypalShortLabels()
    {
        return $this->paypalShortLabels;
    }

    /**
     * Add banktransferLabel.
     *
     * @param LocalizedFallbackValue $banktransferLabel
     *
     * @return $this
     */
    public function addBanktransferLabel(LocalizedFallbackValue $banktransferLabel)
    {
        return $this->addLabel($this->banktransferLabels, $banktransferLabel);
    }

    /**
     * Remove banktransferLabel.
     *
     * @param LocalizedFallbackValue $banktransferLabel
     *
     * @return $this
     */
    public function removeBanktransferLabel(LocalizedFallbackValue $banktransferLabel)
    {
        return $this->removeLabel($this->banktransferLabels, $banktransferLabel);
    }

    /**
     * Get banktransferLabel.
     *
     * @return Collection
     */
    public function getBanktransferLabels()
    {
        return $this->banktransferLabels;
    }

    /**
     * Add banktransferShortLabel.
     *
     * @param LocalizedFallbackValue $banktransferShortLabel
     *
     * @return $this
     */
    public function addBanktransferShortLabel(LocalizedFallbackValue $banktransferShortLabel)
    {
        return $this->addLabel($this->banktransferShortLabels, $banktransferShortLabel);
    }

    /**
     * Remove banktransferShortLabel.
     *
     * @param LocalizedFallbackValue $banktransferShortLabel
     *
     * @return $this
     */
    public function removeBanktransferShortLabel(LocalizedFallbackValue $banktransferShortLabel)
    {
        return $this->removeLabel($this->banktransferShortLabels, $banktransferShortLabel);
    }

    /**
     * Get banktransferShortLabel.
     *
     * @return Collection
     */
    public function getBanktransferShortLabels()
    {
        return $this->banktransferShortLabels;
    }

    /**
     * Add idealLabel.
     *
     * @param LocalizedFallbackValue $idealLabel
     *
     * @return $this
     */
    public function addIdealLabel(LocalizedFallbackValue $idealLabel)
    {
        return $this->addLabel($this->idealLabels, $idealLabel);
    }

    /**
     * Remove idealLabel.
     *
     * @param LocalizedFallbackValue $idealLabel
     *
     * @return $this
     */
    public function removeIdealLabel(LocalizedFallbackValue $idealLabel)
    {
        return $this->removeLabel($this->idealLabels, $idealLabel);
    }

    /**
     * Get idealLabel.
     *
     * @return Collection
     */
    public function getIdealLabels()
    {
        return $this->idealLabels;
    }

    /**
     * Add idealShortLabel.
     *
     * @param LocalizedFallbackValue $idealShortLabel
     *
     * @return $this
     */
    public function addIdealShortLabel(LocalizedFallbackValue $idealShortLabel)
    {
        return $this->addLabel($this->idealShortLabels, $idealShortLabel);
    }

    /**
     * Remove idealShortLabel.
     *
     * @param LocalizedFallbackValue $idealShortLabel
     *
     * @return $this
     */
    public function removeIdealShortLabel(LocalizedFallbackValue $idealShortLabel)
    {
        return $this->removeLabel($this->idealShortLabels, $idealShortLabel);
    }

    /**
     * Get idealShortLabel.
     *
     * @return Collection
     */
    public function getIdealShortLabels()
    {
        return $this->idealShortLabels;
    }

    /**
     * Add giropayLabel.
     *
     * @param LocalizedFallbackValue $giropayLabel
     *
     * @return $this
     */
    public function addGiropayLabel(LocalizedFallbackValue $giropayLabel)
    {
        return $this->addLabel($this->giropayLabels, $giropayLabel);
    }

    /**
     * Remove giropayLabel.
     *
     * @param LocalizedFallbackValue $giropayLabel
     *
     * @return $this
     */
    public function removeGiropayLabel(LocalizedFallbackValue $giropayLabel)
    {
        return $this->removeLabel($this->giropayLabels, $giropayLabel);
    }

    /**
     * Get giropayLabel.
     *
     * @return Collection
     */
    public function getGiropayLabels()
    {
        return $this->giropayLabels;
    }

    /**
     * Add giropayShortLabel.
     *
     * @param LocalizedFallbackValue $giropayShortLabel
     *
     * @return $this
     */
    public function addGiropayShortLabel(LocalizedFallbackValue $giropayShortLabel)
    {
        return $this->addLabel($this->giropayShortLabels, $giropayShortLabel);
    }

    /**
     * Remove giropayShortLabel.
     *
     * @param LocalizedFallbackValue $giropayShortLabel
     *
     * @return $this
     */
    public function removeGiropayShortLabel(LocalizedFallbackValue $giropayShortLabel)
    {
        return $this->removeLabel($this->giropayShortLabels, $giropayShortLabel);
    }

    /**
     * Get giropayShortLabel.
     *
     * @return Collection
     */
    public function getGiropayShortLabels()
    {
        return $this->giropayShortLabels;
    }

    /**
     * Add epsLabel.
     *
     * @param LocalizedFallbackValue $epsLabel
     *
     * @return $this
     */
    public function addEpsLabel(LocalizedFallbackValue $epsLabel)
    {
        return $this->addLabel($this->epsLabels, $epsLabel);
    }

    /**
     * Remove epsLabel.
     *
     * @param LocalizedFallbackValue $epsLabel
     *
     * @return $this
     */
    public function removeEpsLabel(LocalizedFallbackValue $epsLabel)
    {
        return $this->removeLabel($this->epsLabels, $epsLabel);
    }

    /**
     * Get epsLabel.
     *
     * @return Collection
     */
    public function getEpsLabels()
    {
        return $this->epsLabels;
    }

    /**
     * Add epsShortLabel.
     *
     * @param LocalizedFallbackValue $epsShortLabel
     *
     * @return $this
     */
    public function addEpsShortLabel(LocalizedFallbackValue $epsShortLabel)
    {
        return $this->addLabel($this->epsShortLabels, $epsShortLabel);
    }

    /**
     * Remove epsShortLabel.
     *
     * @param LocalizedFallbackValue $epsShortLabel
     *
     * @return $this
     */
    public function removeEpsShortLabel(LocalizedFallbackValue $epsShortLabel)
    {
        return $this->removeLabel($this->epsShortLabels, $epsShortLabel);
    }

    /**
     * Get epsShortLabel.
     *
     * @return Collection
     */
    public function getEpsShortLabels()
    {
        return $this->epsShortLabels;
    }

    /**
     * Add przelewyLabel.
     *
     * @param LocalizedFallbackValue $przelewyLabel
     *
     * @return $this
     */
    public function addPrzelewyLabel(LocalizedFallbackValue $przelewyLabel)
    {
        return $this->addLabel($this->przelewyLabels, $przelewyLabel);
    }

    /**
     * Remove przelewyLabel.
     *
     * @param LocalizedFallbackValue $przelewyLabel
     *
     * @return $this
     */
    public function removePrzelewyLabel(LocalizedFallbackValue $przelewyLabel)
    {
        return $this->removeLabel($this->przelewyLabels, $przelewyLabel);
    }

    /**
     * Get przelewyLabel.
     *
     * @return Collection
     */
    public function getPrzelewyLabels()
    {
        return $this->przelewyLabels;
    }

    /**
     * Add przelewyShortLabel.
     *
     * @param LocalizedFallbackValue $przelewyShortLabel
     *
     * @return $this
     */
    public function addPrzelewyShortLabel(LocalizedFallbackValue $przelewyShortLabel)
    {
        return $this->addLabel($this->przelewyShortLabels, $przelewyShortLabel);
    }

    /**
     * Remove przelewyShortLabel.
     *
     * @param LocalizedFallbackValue $przelewyShortLabel
     *
     * @return $this
     */
    public function removePrzelewyShortLabel(LocalizedFallbackValue $przelewyShortLabel)
    {
        return $this->removeLabel($this->przelewyShortLabels, $przelewyShortLabel);
    }

    /**
     * Get przelewyShortLabel.
     *
     * @return Collection
     */
    public function getPrzelewyShortLabels()
    {
        return $this->przelewyShortLabels;
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
     * @return NovalnetSettings
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
     * @return NovalnetSettings
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
     * @return NovalnetSettings
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
     * @return NovalnetSettings
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
     * @return NovalnetSettings
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
     * @return NovalnetSettings
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
     * @return NovalnetSettings
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
     * @return NovalnetSettings
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
     * @return NovalnetSettings
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
     * @return NovalnetSettings
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
     * @return NovalnetSettings
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
     * @return NovalnetSettings
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
     * @return NovalnetSettings
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
     * @return NovalnetSettings
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
     * @return NovalnetSettings
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
     * @return NovalnetSettings
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
     * @return NovalnetSettings
     */
    public function setEmailBcc($emailBcc)
    {
        $this->emailBcc = $emailBcc;

        return $this;
    }

    /**
     * @param Collection $collection
     * @param LocalizedFallbackValue $label
     *
     * @return $this
     */
    private function removeLabel(Collection $collection, LocalizedFallbackValue $label)
    {
        if ($collection->contains($label)) {
            $collection->removeElement($label);
        }

        return $this;
    }

    /**
     * @param Collection $collection
     * @param LocalizedFallbackValue $label
     *
     * @return $this
     */
    private function addLabel(Collection $collection, LocalizedFallbackValue $label)
    {
        if (!$collection->contains($label)) {
            $collection->add($label);
        }

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
                    'credit_card_labels' => $this->getCreditCardLabels(),
                    'credit_card_short_labels' => $this->getCreditCardShortLabels(),
                    'sepa_labels' => $this->getSepaLabels(),
                    'sepa_short_labels' => $this->getSepaShortLabels(),
                    'invoice_labels' => $this->getInvoiceLabels(),
                    'invoice_short_labels' => $this->getInvoiceShortLabels(),
                    'prepayment_labels' => $this->getPrepaymentLabels(),
                    'prepayment_short_labels' => $this->getPrepaymentShortLabels(),
                    'cashpayment_labels' => $this->getCashpaymentLabels(),
                    'cashpayment_short_labels' => $this->getCashpaymentShortLabels(),
                    'paypal_labels' => $this->getPaypalLabels(),
                    'paypal_short_labels' => $this->getPaypalShortLabels(),
                    'banktransfer_labels' => $this->getBanktransferLabels(),
                    'banktransfer_short_labels' => $this->getBanktransferShortLabels(),
                    'ideal_labels' => $this->getIdealLabels(),
                    'ideal_short_labels' => $this->getIdealShortLabels(),
                    'giropay_labels' => $this->getGiropayLabels(),
                    'giropay_short_labels' => $this->getGiropayShortLabels(),
                    'eps_labels' => $this->getEpsLabels(),
                    'eps_short_labels' => $this->getEpsShortLabels(),
                    'przelewy_labels' => $this->getPrzelewyLabels(),
                    'przelewy_short_labels' => $this->getPrzelewyShortLabels(),
                ]
            );
        }

        return $this->settings;
    }
}
