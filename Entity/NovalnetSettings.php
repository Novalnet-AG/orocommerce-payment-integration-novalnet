<?php

namespace Novalnet\Bundle\NovalnetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\IntegrationBundle\Entity\Transport;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Entity which store Novalnet integration settings
 * @ORM\Entity(repositoryClass="Novalnet\Bundle\NovalnetBundle\Entity\Repository\NovalnetSettingsRepository")
 */
class NovalnetSettings extends Transport
{
    /**
     * @var string
     *
     * @ORM\Column(name="nn_public_key", type="string", length=255, nullable=true)
     */
    private $productActivationKey;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_private_key", type="string", length=255, nullable=true)
     */
    private $paymentAccessKey;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_client_key", type="string", length=255, nullable=true)
     */
    private $clientKey;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_tariff", type="integer", length=10, nullable=true)
     */
    private $tariff;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_display_payment_logo", type="boolean", nullable=true)
     */
    private $displayPaymentLogo;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_callback_test_mode", type="boolean", options={"default"=false})
     */
    private $callbackTestMode;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_callback_email_to", type="string", length=255, nullable=true)
     */
    private $callbackEmailTo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_invoice_test_mode", type="boolean", options={"default"=false})
     */
    private $invoiceTestMode;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_invoice_duedate", type="integer", length=2, nullable=true)
     */
    private $invoiceDuedate;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_invoice_notify", type="string", length=255, nullable=true)
     */
    private $invoiceBuyerNotification;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_invoice_action", type="string", length=15, nullable=true)
     */
    private $invoicePaymentAction;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_invoice_onhold_amnt", type="integer", length=30, nullable=true)
     */
    private $invoiceOnholdAmount;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_instl_inv_test_mode", type="boolean", options={"default"=false})
     */
    private $instalmentInvoiceTestMode;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_instl_inv_onhold_amnt", type="integer", length=30, nullable=true)
     */
    private $instalmentInvoiceOnholdAmount;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_instl_inv_action", type="string", length=255, nullable=true)
     */
    private $instalmentInvoicePaymentAction;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_instl_inv_min_amnt", type="integer", length=30, nullable=true)
     */
    private $instalmentInvoiceMinAmount;

    /**
     * @var text
     *
     * @ORM\Column(name="nn_instl_inv_cycle", type="text", nullable=true)
     */
    private $instalmentInvoiceCycle;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_instl_inv_notify", type="string", length=255, nullable=true)
     */
    private $instalmentInvoiceBuyerNotification;


    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_instl_sepa_test_mode", type="boolean", options={"default"=false})
     */
    private $instalmentSepaTestMode;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_instl_sepa_onhold_amnt", type="integer", length=30, nullable=true)
     */
    private $instalmentSepaOnholdAmount;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_instl_sepa_action", type="string", length=255, nullable=true)
     */
    private $instalmentSepaPaymentAction;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_instl_sepa_min_amnt", type="integer", length=30, nullable=true)
     */
    private $instalmentSepaMinAmount;


    /**
     * @var text
     *
     * @ORM\Column(name="nn_instl_sepa_cycle", type="text", nullable=true)
     */
    private $instalmentSepaCycle;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_instl_sepa_notify", type="string", length=255, nullable=true)
     */
    private $instalmentSepaBuyerNotification;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_instl_sepa_oneclick", type="boolean", nullable=true)
     */
    private $instalmentSepaOneclick;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_prepayment_test_mode", type="boolean", options={"default"=false})
     */
    private $prepaymentTestMode;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_prepayment_duedate", type="integer", length=2, nullable=true)
     */
    private $prepaymentDuedate;


    /**
     * @var string
     *
     * @ORM\Column(name="nn_prepayment_notify", type="string", length=255, nullable=true)
     */
    private $prepaymentBuyerNotification;

     /**
     * @var boolean
     *
     * @ORM\Column(name="nn_cc_test_mode", type="boolean", options={"default"=false})
     */
    private $creditCardTestMode;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_cc_enforce_3d", type="boolean", options={"default"=false})
     */
    private $creditCardEnforce3d;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_cc_oneclick", type="boolean", nullable=true)
     */
    private $creditCardOneclick;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_cc_inline_form", type="boolean", nullable=true)
     */
    private $creditCardInlineForm;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_cc_payment_action", type="string", length=10)
     */
    private $creditCardPaymentAction;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_cc_onhold_amount", type="integer", length=30)
     */
    private $creditCardOnholdAmount;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_cc_logo", type="array", nullable=true)
     */
    private $creditCardLogo;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_cc_notify", type="string", length=255, nullable=true)
     */
    private $creditCardBuyerNotification;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_cc_input_style", type="text", nullable=true)
     */
    private $creditCardInputStyle;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_cc_label_style", type="text", nullable=true)
     */
    private $creditCardLabelStyle;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_cc_container_style", length=255, nullable=true)
     */
    private $creditCardContainerStyle;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_sepa_test_mode", type="boolean", options={"default"=false})
     */
    private $sepaTestMode;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_sepa_duedate", type="integer", length=2, nullable=true)
     */
    private $sepaDuedate;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_sepa_notify", type="string", length=255, nullable=true)
     */
    private $sepaBuyerNotification;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_sepa_action", type="string", length=15, nullable=true)
     */
    private $sepaPaymentAction;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_sepa_onhold_amnt", type="integer", length=30, nullable=true)
     */
    private $sepaOnholdAmount;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_sepa_oneclick", type="boolean", nullable=true)
     */
    private $sepaOneclick;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_paypal_test_mode", type="boolean", options={"default"=false})
     */
    private $paypalTestMode;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_paypal_notify", type="string", length=255, nullable=true)
     */
    private $paypalBuyerNotification;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_paypal_action", type="string", length=15, nullable=true)
     */
    private $paypalPaymentAction;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_paypal_onhold_amnt", type="integer", length=30, nullable=true)
     */
    private $paypalOnholdAmount;


    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_ideal_test_mode", type="boolean", options={"default"=false})
     */
    private $idealTestMode;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_ideal_notify", type="string", length=255, nullable=true)
     */
    private $idealBuyerNotification;


    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_g_sepa_test_mode", type="boolean", options={"default"=false})
     */
    private $guaranteedSepaTestMode;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_g_sepa_notify", type="string", length=255, nullable=true)
     */
    private $guaranteedSepaBuyerNotification;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_g_sepa_action", type="string", length=255, nullable=true)
     */
    private $guaranteedSepaPaymentAction;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_g_sepa_onhold_amnt", type="integer", length=30, nullable=true)
     */
    private $guaranteedSepaOnholdAmount;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_g_sepa_min_amnt", type="integer", length=30, nullable=true)
     */
    private $guaranteedSepaMinAmount;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_g_sepa_oneclick", type="boolean", nullable=true)
     */
    private $guaranteedSepaOneclick;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_g_invoice_test_mode", type="boolean", options={"default"=false})
     */
    private $guaranteedInvoiceTestMode;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_g_invoice_notify", type="string", length=255, nullable=true)
     */
    private $guaranteedInvoiceBuyerNotification;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_g_invoice_action", type="string", length=255, nullable=true)
     */
    private $guaranteedInvoicePaymentAction;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_g_invoice_onhold_amnt", type="integer", length=30, nullable=true)
     */
    private $guaranteedInvoiceOnholdAmount;

    /**
     * @var integer
     *
     * @ORM\Column(name="nn_g_invoice_min_amnt", type="integer", length=30, nullable=true)
     */
    private $guaranteedInvoiceMinAmount;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_eps_test_mode", type="boolean", options={"default"=false})
     */
    private $epsTestMode;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_eps_notify", type="string", length=255, nullable=true)
     */
    private $epsBuyerNotification;



    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_przelewy_test_mode", type="boolean", options={"default"=false})
     */
    private $przelewyTestMode;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_przelewy_notify", type="string", length=255, nullable=true)
     */
    private $przelewyBuyerNotification;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_postfinance_test_mode", type="boolean", options={"default"=false})
     */
    private $postfinanceTestMode;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_postfinance_notify", type="string", length=255, nullable=true)
     */
    private $postfinanceBuyerNotification;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_postfinancecard_test_mode", type="boolean", options={"default"=false})
     */
    private $postfinanceCardTestMode;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_postfinancecard_notify", type="string", length=255, nullable=true)
     */
    private $postfinanceCardBuyerNotification;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_multibanco_test_mode", type="boolean", options={"default"=false})
     */
    private $multibancoTestMode;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_multibanco_notify", type="string", length=255, nullable=true)
     */
    private $multibancoBuyerNotification;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_bancontact_test_mode", type="boolean", options={"default"=false})
     */
    private $bancontactTestMode;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_bancontact_notify", type="string", length=255, nullable=true)
     */
    private $bancontactBuyerNotification;


    
    /**
	 * @var boolean
	 *
	 * @ORM\Column(name="nn_alipay_test_mode", type="boolean", options={"default"=false})
	 */
	private $alipayTestMode;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="nn_alipay_notify", type="string", length=255, nullable=true)
	 */
	private $alipayBuyerNotification;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="nn_wechatpay_test_mode", type="boolean", options={"default"=false})
	 */
	private $wechatpayTestMode;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="nn_wechatpay_notify", type="string", length=255, nullable=true)
	 */
	private $wechatpayBuyerNotification;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="nn_trustly_test_mode", type="boolean", options={"default"=false})
	 */
	private $trustlyTestMode;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="nn_trustly_notify", type="string", length=255, nullable=true)
	 */
	private $trustlyBuyerNotification;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="nn_ob_transfer_test_mode", type="boolean", options={"default"=false})
	 */
	private $onlinebanktransferTestMode;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="nn_ob_transfer_notify", type="string", length=255, nullable=true)
	 */
	private $onlinebanktransferBuyerNotification;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_credit_card_lbl", type="string", length=50, nullable=true)
     */
    private $creditCardLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_credit_card_sh_lbl", type="string", length=50, nullable=true)
     */
    private $creditCardShortLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_sepa_lbl", type="string", length=50, nullable=true)
     */
    private $sepaLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_sepa_sh_lbl", type="string", length=50, nullable=true)
     */
    private $sepaShortLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_invoice_lbl", type="string", length=50, nullable=true)
     */
    private $invoiceLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_invoice_sh_lbl", type="string", length=50, nullable=true)
     */
    private $invoiceShortLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_instl_invoice_lbl", type="string", length=50, nullable=true)
     */
    private $instalmentInvoiceLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_instl_invoice_sh_lbl", type="string", length=50, nullable=true)
     */
    private $instalmentInvoiceShortLabel;


    /**
     * @var string
     *
     * @ORM\Column(name="nn_instl_sepa_lbl", type="string", length=50, nullable=true)
     */
    private $instalmentSepaLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_instl_sepa_sh_lbl", type="string", length=50, nullable=true)
     */
    private $instalmentSepaShortLabel;


    /**
     * @var string
     *
     * @ORM\Column(name="nn_prepayment_lbl", type="string", length=50, nullable=true)
     */
    private $prepaymentLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_prepayment_sh_lbl", type="string", length=50, nullable=true)
     */
    private $prepaymentShortLabel;



    /**
     * @var string
     *
     * @ORM\Column(name="nn_paypal_lbl", type="string", length=50, nullable=true)
     */
    private $paypalLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_paypal_sh_lbl", type="string", length=50, nullable=true)
     */
    private $paypalShortLabel;



    /**
     * @var string
     *
     * @ORM\Column(name="nn_ideal_lbl", type="string", length=50, nullable=true)
     */
    private $idealLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_ideal_sh_lbl", type="string", length=50, nullable=true)
     */
    private $idealShortLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_g_sepa_lbl", type="string", length=50, nullable=true)
     */
    private $guaranteedSepaLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_g_sepa_sh_lbl", type="string", length=50, nullable=true)
     */
    private $guaranteedSepaShortLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_g_invoice_lbl", type="string", length=50, nullable=true)
     */
    private $guaranteedInvoiceLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_g_invoice_sh_lbl", type="string", length=50, nullable=true)
     */
    private $guaranteedInvoiceShortLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_eps_lbl", type="string", length=50, nullable=true)
     */
    private $epsLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_eps_sh_lbl", type="string", length=50, nullable=true)
     */
    private $epsShortLabel;



    /**
     * @var string
     *
     * @ORM\Column(name="nn_przelewy_lbl", type="string", length=50, nullable=true)
     */
    private $przelewyLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_przelewy_sh_lbl", type="string", length=50, nullable=true)
     */
    private $przelewyShortLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_postfinance_lbl", type="string", length=50, nullable=true)
     */
    private $postfinanceLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_postfinance_sh_lbl", type="string", length=50, nullable=true)
     */
    private $postfinanceShortLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_postfinance_card_lbl", type="string", length=50, nullable=true)
     */
    private $postfinanceCardLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_postfinance_card_sh_lbl", type="string", length=50, nullable=true)
     */
    private $postfinanceCardShortLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_bancontact_lbl", type="string", length=50, nullable=true)
     */
    private $bancontactLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_bancontact_sh_lbl", type="string", length=50, nullable=true)
     */
    private $bancontactShortLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_multibanco_lbl", type="string", length=50, nullable=true)
     */
    private $multibancoLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_multibanco_sh_lbl", type="string", length=50, nullable=true)
     */
    private $multibancoShortLabel;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nn_alipay_lbl", type="string", length=50, nullable=true)
     */
    private $alipayLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_alipay_sh_lbl", type="string", length=50, nullable=true)
     */
    private $alipayShortLabel;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nn_wechatpay_lbl", type="string", length=50, nullable=true)
     */
    private $wechatpayLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_wechatpay_sh_lbl", type="string", length=50, nullable=true)
     */
    private $wechatpayShortLabel;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nn_trustly_lbl", type="string", length=50, nullable=true)
     */
    private $trustlyLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_trustly_sh_lbl", type="string", length=50, nullable=true)
     */
    private $trustlyShortLabel;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nn_onlinebanktransfer_lbl", type="string", length=50, nullable=true)
     */
    private $onlinebanktransferLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_onlinebanktransfer_sh_lbl", type="string", length=50, nullable=true)
     */
    private $onlinebanktransferShortLabel;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_naverpay_test_mode", type="boolean", options={"default"=false})
     */
    private $naverpayTestMode;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_naverpay_notify", type="string", length=255, nullable=true)
     */
    private $naverpayBuyerNotification;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_naverpay_lbl", type="string", length=50, nullable=true)
     */
    private $naverpayLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_naverpay_sh_lbl", type="string", length=50, nullable=true)
     */
    private $naverpayShortLabel;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_blik_test_mode", type="boolean", options={"default"=false})
     */
    private $blikTestMode;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_blik_notify", type="string", length=255, nullable=true)
     */
    private $blikBuyerNotification;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_blik_lbl", type="string", length=50, nullable=true)
     */
    private $blikLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_blik_sh_lbl", type="string", length=50, nullable=true)
     */
    private $blikShortLabel;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_kakaopay_test_mode", type="boolean", options={"default"=false})
     */
    private $kakaopayTestMode;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_kakaopay_notify", type="string", length=255, nullable=true)
     */
    private $kakaopayBuyerNotification;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_kakaopay_lbl", type="string", length=50, nullable=true)
     */
    private $kakaopayLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_kakaopay_sh_lbl", type="string", length=50, nullable=true)
     */
    private $kakaopayShortLabel;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_mbway_test_mode", type="boolean", options={"default"=false})
     */
    private $mbwayTestMode;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_mbway_notify", type="string", length=255, nullable=true)
     */
    private $mbwayBuyerNotification;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_mbway_lbl", type="string", length=50, nullable=true)
     */
    private $mbwayLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_mbway_sh_lbl", type="string", length=50, nullable=true)
     */
    private $mbwayShortLabel;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_payconiq_test_mode", type="boolean", options={"default"=false})
     */
    private $payconiqTestMode;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_payconiq_notify", type="string", length=255, nullable=true)
     */
    private $payconiqBuyerNotification;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_payconiq_lbl", type="string", length=50, nullable=true)
     */
    private $payconiqLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_payconiq_sh_lbl", type="string", length=50, nullable=true)
     */
    private $payconiqShortLabel;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_twint_test_mode", type="boolean", options={"default"=false})
     */
    private $twintTestMode;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_twint_notify", type="string", length=255, nullable=true)
     */
    private $twintBuyerNotification;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_twint_lbl", type="string", length=50, nullable=true)
     */
    private $twintLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_twint_sh_lbl", type="string", length=50, nullable=true)
     */
    private $twintShortLabel;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_ach_test_mode", type="boolean", options={"default"=false})
     */
    private $achTestMode;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_ach_notify", type="string", length=255, nullable=true)
     */
    private $achBuyerNotification;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_ach_lbl", type="string", length=50, nullable=true)
     */
    private $achLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="nn_ach_sh_lbl", type="string", length=50, nullable=true)
     */
    private $achShortLabel;

    /**
     * @var boolean
     *
     * @ORM\Column(name="nn_ach_oneclick", type="boolean", nullable=true)
     */
    private $achOneclick;

    /**
     * @var ParameterBag
     */
    private $settings;


    /**
     * Add creditCardLabel.
     *
     * @param $creditCardLabel
     *
     * @return $this
     */
    public function setCreditCardLabel($creditCardLabel)
    {
        $this->creditCardLabel = $creditCardLabel;
        return $this;
    }


    /**
     * Get creditCardLabel.
     *
     * @return string
     */
    public function getCreditCardLabel()
    {
        return $this->creditCardLabel;
    }

    /**
     * Add sepaLabel.
     *
     * @param $sepaLabel
     *
     * @return $this
     */
    public function setSepaLabel($sepaLabel)
    {
        $this->sepaLabel = $sepaLabel;
        return $this;
    }

    /**
     * Get sepaLabel.
     *
     * @return string
     */
    public function getSepaLabel()
    {
        return $this->sepaLabel;
    }

    /**
     * Add sepaShortLabel.
     *
     * @param $sepaShortLabel
     *
     * @return $this
     */
    public function setSepaShortLabel($sepaShortLabel)
    {
        $this->sepaShortLabel = $sepaShortLabel;
        return $this;
    }

    /**
     * Get sepaShortLabel.
     *
     * @return string
     */
    public function getSepaShortLabel()
    {
        return $this->sepaShortLabel;
    }

    /**
     * Add creditCardShortLabel.
     *
     * @param $creditCardShortLabel
     *
     * @return $this
     */
    public function setCreditCardShortLabel($creditCardShortLabel)
    {
        $this->creditCardShortLabel = $creditCardShortLabel;
        return $this;
    }

    /**
     * Get creditCardShortLabel.
     *
     * @return string
     */
    public function getCreditCardShortLabel()
    {
        return $this->creditCardShortLabel;
    }

    /**
     * Add invoiceLabel.
     *
     * @param $invoiceLabel
     *
     * @return $this
     */
    public function setInvoiceLabel($invoiceLabel)
    {
        $this->invoiceLabel = $invoiceLabel;
        return $this;
    }



    /**
     * Get invoiceLabel.
     *
     * @return string
     */
    public function getInvoiceLabel()
    {
        return $this->invoiceLabel;
    }

    /**
     * Add InstalmentinvoiceLabel.
     *
     * @param $instalmentInvoiceLabel
     *
     * @return $this
     */
    public function setInstalmentInvoiceLabel($instalmentInvoiceLabel)
    {
        $this->instalmentInvoiceLabel = $instalmentInvoiceLabel;
        return $this;
    }


    /**
     * Get instalmentInvoiceLabel.
     *
     * @return string
     */
    public function getInstalmentInvoiceLabel()
    {
        return $this->instalmentInvoiceLabel;
    }

    /**
     * Add InstalmentsepaLabel.
     *
     * @param $instalmentSepaLabel
     *
     * @return $this
     */
    public function setInstalmentSepaLabel($instalmentSepaLabel)
    {
        $this->instalmentSepaLabel = $instalmentSepaLabel;
        return $this;
    }

    /**
     * Get instalmentSepaLabel.
     *
     * @return string
     */
    public function getInstalmentSepaLabel()
    {
        return $this->instalmentSepaLabel;
    }

    /**
     * Add invoiceShortLabel.
     *
     * @param $invoiceShortLabel
     *
     * @return $this
     */
    public function setInvoiceShortLabel($invoiceShortLabel)
    {
        $this->invoiceShortLabel = $invoiceShortLabel;
        return $this;
    }

    /**
     * Get invoiceShortLabel.
     *
     * @return string
     */
    public function getInvoiceShortLabel()
    {
        return $this->invoiceShortLabel;
    }

    /**
     * Add instalmentInvoiceShortLabel.
     *
     * @param $instalmentInvoiceShortLabel
     *
     * @return $this
     */
    public function setInstalmentInvoiceShortLabel($instalmentInvoiceShortLabel)
    {
        $this->instalmentInvoiceShortLabel = $instalmentInvoiceShortLabel;
        return $this;
    }

    /**
     * Get instalmentInvoiceShortLabel.
     *
     * @return string
     */
    public function getInstalmentInvoiceShortLabel()
    {
        return $this->instalmentInvoiceShortLabel;
    }

    /**
     * Add instalmentSepaShortLabel.
     *
     * @param $instalmentSepaShortLabel
     *
     * @return $this
     */
    public function setInstalmentSepaShortLabel($instalmentSepaShortLabel)
    {
        $this->instalmentSepaShortLabel = $instalmentSepaShortLabel;
        return $this;
    }

    /**
     * Get instalmentSepaShortLabel.
     *
     * @return string
     */
    public function getInstalmentSepaShortLabel()
    {
        return $this->instalmentSepaShortLabel;
    }

    /**
     * Add prepaymentLabel.
     *
     * @param $prepaymentLabel
     *
     * @return $this
     */
    public function setPrepaymentLabel($prepaymentLabel)
    {
        $this->prepaymentLabel = $prepaymentLabel;
        return $this;
    }

    /**
     * Get prepaymentLabel.
     *
     * @return string
     */
    public function getPrepaymentLabel()
    {
        return $this->prepaymentLabel;
    }

    /**
     * Add prepaymentShortLabel.
     *
     * @param $prepaymentShortLabel
     *
     * @return $this
     */
    public function setPrepaymentShortLabel($prepaymentShortLabel)
    {
        $this->prepaymentShortLabel = $prepaymentShortLabel;
        return $this;
    }

    /**
     * Get prepaymentShortLabel.
     *
     * @return string
     */
    public function getPrepaymentShortLabel()
    {
        return $this->prepaymentShortLabel;
    }



    /**
     * Add paypalLabel.
     *
     * @param $paypalLabel
     *
     * @return $this
     */
    public function setPaypalLabel($paypalLabel)
    {
        $this->paypalLabel = $paypalLabel;
        return $this;
    }

    /**
     * Get paypalLabel.
     *
     * @return string
     */
    public function getPaypalLabel()
    {
        return $this->paypalLabel;
    }

    /**
     * Add paypalShortLabel.
     *
     * @param $paypalShortLabel
     *
     * @return $this
     */
    public function setPaypalShortLabel($paypalShortLabel)
    {
        $this->paypalShortLabel = $paypalShortLabel;
        return $this;
    }

    /**
     * Get paypalShortLabel.
     *
     * @return string
     */
    public function getPaypalShortLabel()
    {
        return $this->paypalShortLabel;
    }



    /**
     * Add idealLabel.
     *
     * @param $idealLabel
     *
     * @return $this
     */
    public function setIdealLabel($idealLabel)
    {
        $this->idealLabel = $idealLabel;
        return $this;
    }

    /**
     * Get idealLabel.
     *
     * @return string
     */
    public function getIdealLabel()
    {
        return $this->idealLabel;
    }

    /**
     * Add idealShortLabel.
     *
     * @param $idealShortLabel
     *
     * @return $this
     */
    public function setIdealShortLabel($idealShortLabel)
    {
        $this->idealShortLabel = $idealShortLabel;
        return $this;
    }

    /**
     * Get idealShortLabel.
     *
     * @return string
     */
    public function getIdealShortLabel()
    {
        return $this->idealShortLabel;
    }

    /**
     * Add guaranteedSepaLabel.
     *
     * @param $guaranteedSepaLabel
     *
     * @return $this
     */
    public function setGuaranteedSepaLabel($guaranteedSepaLabel)
    {
        $this->guaranteedSepaLabel = $guaranteedSepaLabel;
        return $this;
    }

    /**
     * Get guaranteedSepaLabel.
     *
     * @return string
     */
    public function getGuaranteedSepaLabel()
    {
        return $this->guaranteedSepaLabel;
    }

    /**
     * Add guaranteedSepaShortLabel.
     *
     * @param $guaranteedSepaShortLabel
     *
     * @return $this
     */
    public function setGuaranteedSepaShortLabel($guaranteedSepaShortLabel)
    {
        $this->guaranteedSepaShortLabel = $guaranteedSepaShortLabel;
        return $this;
    }

    /**
     * Get guaranteedSepaShortLabel.
     *
     * @return string
     */
    public function getGuaranteedSepaShortLabel()
    {
        return $this->guaranteedSepaShortLabel;
    }

    /**
     * Add guaranteedInvoiceLabel.
     *
     * @param $guaranteedInvoiceLabel
     *
     * @return $this
     */
    public function setGuaranteedInvoiceLabel($guaranteedInvoiceLabel)
    {
        $this->guaranteedInvoiceLabel = $guaranteedInvoiceLabel;
        return $this;
    }

    /**
     * Get guaranteedInvoiceLabel.
     *
     * @return string
     */
    public function getGuaranteedInvoiceLabel()
    {
        return $this->guaranteedInvoiceLabel;
    }

    /**
     * Add guaranteedInvoiceShortLabel.
     *
     * @param $guaranteedInvoiceShortLabel
     *
     * @return $this
     */
    public function setGuaranteedInvoiceShortLabel($guaranteedInvoiceShortLabel)
    {
        $this->guaranteedInvoiceShortLabel = $guaranteedInvoiceShortLabel;
        return $this;
    }

    /**
     * Get guaranteedInvoiceShortLabel.
     *
     * @return string
     */
    public function getGuaranteedInvoiceShortLabel()
    {
        return $this->guaranteedInvoiceShortLabel;
    }



    /**
     * Add epsLabel.
     *
     * @param $epsLabel
     *
     * @return $this
     */
    public function setEpsLabel($epsLabel)
    {
        $this->epsLabel = $epsLabel;
        return $this;
    }

    /**
     * Get epsLabel.
     *
     * @return string
     */
    public function getEpsLabel()
    {
        return $this->epsLabel;
    }

    /**
     * Add epsShortLabel.
     *
     * @param $epsShortLabel
     *
     * @return $this
     */
    public function setEpsShortLabel($epsShortLabel)
    {
        $this->epsShortLabel = $epsShortLabel;
        return $this;
    }


    /**
     * Get epsShortLabel.
     *
     * @return string
     */
    public function getEpsShortLabel()
    {
        return $this->epsShortLabel;
    }

    /**
     * Add przelewyLabel.
     *
     * @param $przelewyLabel
     *
     * @return $this
     */
    public function setPrzelewyLabel($przelewyLabel)
    {
        $this->przelewyLabel = $przelewyLabel;
        return $this;
    }

    /**
     * Get przelewyLabel.
     *
     * @return string
     */
    public function getPrzelewyLabel()
    {
        return $this->przelewyLabel;
    }

    /**
     * Add PostfinanceLabel.
     *
     * @param $postfinanceLabel
     *
     * @return $this
     */
    public function setPostfinanceLabel($postfinanceLabel)
    {
        $this->postfinanceLabel = $postfinanceLabel;
        return $this;
    }

    /**
     * Get PostfinanceLabel.
     *
     * @return string
     */
    public function getPostfinanceLabel()
    {
        return $this->postfinanceLabel;
    }

    /**
     * Add PostfinanceCardLabel.
     *
     * @param $postfinanceCardLabel
     *
     * @return $this
     */
    public function setPostfinanceCardLabel($postfinanceCardLabel)
    {
        $this->postfinanceCardLabel = $postfinanceCardLabel;
        return $this;
    }


    /**
     * Get PostfinanceCardLabel.
     *
     * @return string
     */
    public function getPostfinanceCardLabel()
    {
        return $this->postfinanceCardLabel;
    }

    /**
     * Add MultibancoLabel.
     *
     * @param $multibancoLabel
     *
     * @return $this
     */
    public function setMultibancoLabel($multibancoLabel)
    {
        $this->multibancoLabel = $multibancoLabel;
        return $this;
    }


    /**
     * Get MultibancoLabel.
     *
     * @return string
     */
    public function getMultibancoLabel()
    {
        return $this->multibancoLabel;
    }

    /**
     * Add BancontactLabel.
     *
     * @param $bancontactLabel
     *
     * @return $this
     */
    public function setBancontactLabel($bancontactLabel)
    {
        $this->bancontactLabel = $bancontactLabel;
        return $this;
    }


    /**
     * Get bancontactLabel.
     *
     * @return string
     */
    public function getBancontactLabel()
    {
        return $this->bancontactLabel;
    }

    /**
     * Add przelewyShortLabel.
     *
     * @param $przelewyShortLabel
     *
     * @return $this
     */
    public function setPrzelewyShortLabel($przelewyShortLabel)
    {
        $this->przelewyShortLabel = $przelewyShortLabel;
        return $this;
    }



    /**
     * Get przelewyShortLabel.
     *
     * @return string
     */
    public function getPrzelewyShortLabel()
    {
        return $this->przelewyShortLabel;
    }

    /**
     * Add PostfinanceShortLabel.
     *
     * @param $postfinanceShortLabel
     *
     * @return $this
     */
    public function setPostfinanceShortLabel($postfinanceShortLabel)
    {
        $this->postfinanceShortLabel = $postfinanceShortLabel;
        return $this;
    }

    /**
     * Get postfinanceShortLabel.
     *
     * @return string
     */
    public function getPostfinanceShortLabel()
    {
        return $this->postfinanceShortLabel;
    }

    /**
     * Add PostfinanceCardShortLabel.
     *
     * @param $postfinanceCardShortLabel
     *
     * @return $this
     */
    public function setPostfinanceCardShortLabel($postfinanceCardShortLabel)
    {
        $this->postfinanceCardShortLabel = $postfinanceCardShortLabel;
        return $this;
    }

    /**
     * Get postfinanceCardShortLabel.
     *
     * @return string
     */
    public function getPostfinanceCardShortLabel()
    {
        return $this->postfinanceCardShortLabel;
    }

    /**
     * Add BancontactShortLabel.
     *
     * @param $bancontactShortLabel
     *
     * @return $this
     */
    public function setBancontactShortLabel($bancontactShortLabel)
    {
        $this->bancontactShortLabel = $bancontactShortLabel;
        return $this;
    }

    /**
     * Get BancontactShortLabel.
     *
     * @return string
     */
    public function getBancontactShortLabel()
    {
        return $this->bancontactShortLabel;
    }

    /**
     * Add MultibancoShortLabel.
     *
     * @param $multibancoShortLabel
     *
     * @return $this
     */
    public function setMultibancoShortLabel($multibancoShortLabel)
    {
        $this->multibancoShortLabel = $multibancoShortLabel;
        return $this;
    }

    /**
     * Get MultibancoShortLabel.
     *
     * @return string
     */
    public function getMultibancoShortLabel()
    {
        return $this->multibancoShortLabel;
    }
    
    /**
     * Add alipayLabel.
     *
     * @param $alipayLabel
     *
     * @return $this
     */
    public function setAlipayLabel($alipayLabel)
    {
        $this->alipayLabel = $alipayLabel;
        return $this;
    }

    /**
     * Get alipayLabel.
     *
     * @return string
     */
    public function getAlipayLabel()
    {
        return $this->alipayLabel;
    }
    
    /**
     * Add wechatpayLabel.
     *
     * @param $wechatpayLabel
     *
     * @return $this
     */
    public function setWechatpayLabel($wechatpayLabel)
    {
        $this->wechatpayLabel = $wechatpayLabel;
        return $this;
    }

    /**
     * Get wechatpayLabel.
     *
     * @return string
     */
    public function getWechatpayLabel()
    {
        return $this->wechatpayLabel;
    }
    
    /**
     * Add trustlyLabel.
     *
     * @param $trustlyLabel
     *
     * @return $this
     */
    public function setTrustlyLabel($trustlyLabel)
    {
        $this->trustlyLabel = $trustlyLabel;
        return $this;
    }

    /**
     * Get trustlyLabel.
     *
     * @return string
     */
    public function getTrustlyLabel()
    {
        return $this->trustlyLabel;
    }
    
    /**
     * Add onlinebanktransferLabel.
     *
     * @param $onlinebanktransferLabel
     *
     * @return $this
     */
    public function setOnlinebanktransferLabel($onlinebanktransferLabel)
    {
        $this->onlinebanktransferLabel = $onlinebanktransferLabel;
        return $this;
    }

    /**
     * Get onlinebanktransferLabel.
     *
     * @return string
     */
    public function getOnlinebanktransferLabel()
    {
        return $this->onlinebanktransferLabel;
    }
    
    /**
     * Add alipayShortLabel.
     *
     * @param $alipayShortLabel
     *
     * @return $this
     */
    public function setAlipayShortLabel($alipayShortLabel)
    {
        $this->alipayShortLabel = $alipayShortLabel;
        return $this;
    }

    /**
     * Get alipayShortLabel.
     *
     * @return string
     */
    public function getAlipayShortLabel()
    {
        return $this->alipayShortLabel;
    }
    
    /**
     * Add wechatpayShortLabel.
     *
     * @param $wechatpayShortLabel
     *
     * @return $this
     */
    public function setWechatpayShortLabel($wechatpayShortLabel)
    {
        $this->wechatpayShortLabel = $wechatpayShortLabel;
        return $this;
    }

    /**
     * Get wechatpayShortLabel.
     *
     * @return string
     */
    public function getWechatpayShortLabel()
    {
        return $this->wechatpayShortLabel;
    }
    
    /**
     * Add trustlyShortLabel.
     *
     * @param $trustlyShortLabel
     *
     * @return $this
     */
    public function setTrustlyShortLabel($trustlyShortLabel)
    {
        $this->trustlyShortLabel = $trustlyShortLabel;
        return $this;
    }

    /**
     * Get trustlyShortLabel.
     *
     * @return string
     */
    public function getTrustlyShortLabel()
    {
        return $this->trustlyShortLabel;
    }
    
    /**
     * Add onlinebanktransferShortLabel.
     *
     * @param $onlinebanktransferShortLabel
     *
     * @return $this
     */
    public function setOnlinebanktransferShortLabel($onlinebanktransferShortLabel)
    {
        $this->onlinebanktransferShortLabel = $onlinebanktransferShortLabel;
        return $this;
    }

    /**
     * Get onlinebanktransferShortLabel.
     *
     * @return string
     */
    public function getOnlinebanktransferShortLabel()
    {
        return $this->onlinebanktransferShortLabel;
    }

    /**
     * Add naverpayLabel.
     *
     * @param $naverpayLabel
     *
     * @return $this
     */
    public function setNaverpayLabel($naverpayLabel)
    {
        $this->naverpayLabel = $naverpayLabel;
        return $this;
    }

    /**
     * Get naverpayLabel.
     *
     * @return string
     */
    public function getNaverpayLabel()
    {
        return $this->naverpayLabel;
    }

    /**
     * Add naverpayShortLabel.
     *
     * @param $naverpayShortLabel
     *
     * @return $this
     */
    public function setNaverpayShortLabel($naverpayShortLabel)
    {
        $this->naverpayShortLabel = $naverpayShortLabel;
        return $this;
    }

    /**
     * Get naverpayShortLabel.
     *
     * @return string
     */
    public function getNaverpayShortLabel()
    {
        return $this->naverpayShortLabel;
    }

    /**
     * @return integer
     */
    public function getNaverpayTestMode()
    {
        return $this->naverpayTestMode;
    }

    /**
     * @param integer $naverpayTestMode
     *
     * @return NovalnetSettings
     */
    public function setNaverpayTestMode($naverpayTestMode)
    {
        $this->naverpayTestMode = $naverpayTestMode;

        return $this;
    }

    /**
     * @return string
     */
    public function getNaverpayBuyerNotification()
    {
        return $this->naverpayBuyerNotification;
    }

    /**
     * @param string $naverpayBuyerNotification
     *
     * @return NovalnetSettings
     */
    public function setNaverpayBuyerNotification($naverpayBuyerNotification)
    {
        $this->naverpayBuyerNotification = $naverpayBuyerNotification;

        return $this;
    }

    /**
     * Add blikLabel.
     *
     * @param $blikLabel
     *
     * @return $this
     */
    public function setBlikLabel($blikLabel)
    {
        $this->blikLabel = $blikLabel;
        return $this;
    }

    /**
     * Get blikLabel.
     *
     * @return string
     */
    public function getBlikLabel()
    {
        return $this->blikLabel;
    }

    /**
     * Add blikShortLabel.
     *
     * @param $blikShortLabel
     *
     * @return $this
     */
    public function setBlikShortLabel($blikShortLabel)
    {
        $this->blikShortLabel = $blikShortLabel;
        return $this;
    }

    /**
     * Get blikShortLabel.
     *
     * @return string
     */
    public function getBlikShortLabel()
    {
        return $this->blikShortLabel;
    }

    /**
     * @return integer
     */
    public function getBlikTestMode()
    {
        return $this->blikTestMode;
    }

    /**
     * @param integer $blikTestMode
     *
     * @return NovalnetSettings
     */
    public function setBlikTestMode($blikTestMode)
    {
        $this->blikTestMode = $blikTestMode;

        return $this;
    }

    /**
     * @return string
     */
    public function getBlikBuyerNotification()
    {
        return $this->blikBuyerNotification;
    }

    /**
     * @param string $blikBuyerNotification
     *
     * @return NovalnetSettings
     */
    public function setBlikBuyerNotification($blikBuyerNotification)
    {
        $this->blikBuyerNotification = $blikBuyerNotification;

        return $this;
    }

    /**
     * Add kakaopayLabel.
     *
     * @param $kakaopayLabel
     *
     * @return $this
     */
    public function setKakaopayLabel($kakaopayLabel)
    {
        $this->kakaopayLabel = $kakaopayLabel;
        return $this;
    }

    /**
     * Get kakaopayLabel.
     *
     * @return string
     */
    public function getKakaopayLabel()
    {
        return $this->kakaopayLabel;
    }

    /**
     * Add kakaopayShortLabel.
     *
     * @param $kakaopayShortLabel
     *
     * @return $this
     */
    public function setKakaopayShortLabel($kakaopayShortLabel)
    {
        $this->kakaopayShortLabel = $kakaopayShortLabel;
        return $this;
    }

    /**
     * Get kakaopayShortLabel.
     *
     * @return string
     */
    public function getKakaopayShortLabel()
    {
        return $this->kakaopayShortLabel;
    }

    /**
     * @return integer
     */
    public function getKakaopayTestMode()
    {
        return $this->kakaopayTestMode;
    }

    /**
     * @param integer $kakaopayTestMode
     *
     * @return NovalnetSettings
     */
    public function setKakaopayTestMode($kakaopayTestMode)
    {
        $this->kakaopayTestMode = $kakaopayTestMode;

        return $this;
    }

    /**
     * @return string
     */
    public function getKakaopayBuyerNotification()
    {
        return $this->kakaopayBuyerNotification;
    }

    /**
     * @param string $kakaopayBuyerNotification
     *
     * @return NovalnetSettings
     */
    public function setKakaopayBuyerNotification($kakaopayBuyerNotification)
    {
        $this->kakaopayBuyerNotification = $kakaopayBuyerNotification;

        return $this;
    }

    // Mbway methods
    public function setMbwayLabel($mbwayLabel) { $this->mbwayLabel = $mbwayLabel; return $this; }
    public function getMbwayLabel() { return $this->mbwayLabel; }
    public function setMbwayShortLabel($mbwayShortLabel) { $this->mbwayShortLabel = $mbwayShortLabel; return $this; }
    public function getMbwayShortLabel() { return $this->mbwayShortLabel; }
    public function getMbwayTestMode() { return $this->mbwayTestMode; }
    public function setMbwayTestMode($mbwayTestMode) { $this->mbwayTestMode = $mbwayTestMode; return $this; }
    public function getMbwayBuyerNotification() { return $this->mbwayBuyerNotification; }
    public function setMbwayBuyerNotification($mbwayBuyerNotification) { $this->mbwayBuyerNotification = $mbwayBuyerNotification; return $this; }

    // Payconiq methods
    public function setPayconiqLabel($payconiqLabel) { $this->payconiqLabel = $payconiqLabel; return $this; }
    public function getPayconiqLabel() { return $this->payconiqLabel; }
    public function setPayconiqShortLabel($payconiqShortLabel) { $this->payconiqShortLabel = $payconiqShortLabel; return $this; }
    public function getPayconiqShortLabel() { return $this->payconiqShortLabel; }
    public function getPayconiqTestMode() { return $this->payconiqTestMode; }
    public function setPayconiqTestMode($payconiqTestMode) { $this->payconiqTestMode = $payconiqTestMode; return $this; }
    public function getPayconiqBuyerNotification() { return $this->payconiqBuyerNotification; }
    public function setPayconiqBuyerNotification($payconiqBuyerNotification) { $this->payconiqBuyerNotification = $payconiqBuyerNotification; return $this; }

    // Twint methods
    public function setTwintLabel($twintLabel) { $this->twintLabel = $twintLabel; return $this; }
    public function getTwintLabel() { return $this->twintLabel; }
    public function setTwintShortLabel($twintShortLabel) { $this->twintShortLabel = $twintShortLabel; return $this; }
    public function getTwintShortLabel() { return $this->twintShortLabel; }
    public function getTwintTestMode() { return $this->twintTestMode; }
    public function setTwintTestMode($twintTestMode) { $this->twintTestMode = $twintTestMode; return $this; }
    public function getTwintBuyerNotification() { return $this->twintBuyerNotification; }
    public function setTwintBuyerNotification($twintBuyerNotification) { $this->twintBuyerNotification = $twintBuyerNotification; return $this; }

    // ACH methods
    public function setAchLabel($achLabel) { $this->achLabel = $achLabel; return $this; }
    public function getAchLabel() { return $this->achLabel; }
    public function setAchShortLabel($achShortLabel) { $this->achShortLabel = $achShortLabel; return $this; }
    public function getAchShortLabel() { return $this->achShortLabel; }
    public function getAchTestMode() { return $this->achTestMode; }
    public function setAchTestMode($achTestMode) { $this->achTestMode = $achTestMode; return $this; }
    public function getAchBuyerNotification() { return $this->achBuyerNotification; }
    public function setAchBuyerNotification($achBuyerNotification) { $this->achBuyerNotification = $achBuyerNotification; return $this; }
    public function getAchOneclick() { return $this->achOneclick; }
    public function setAchOneclick($achOneclick) { $this->achOneclick = $achOneclick; return $this; }

    /**
     * @return string
     */
    public function getProductActivationKey()
    {
        return $this->productActivationKey;
    }

    /**
     * @param string $productActivationKey
     *
     * @return NovalnetSettings
     */
    public function setProductActivationKey($productActivationKey)
    {
        $this->productActivationKey = $productActivationKey;

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
     * @return int
     */
    public function getCallbackTestMode()
    {
        return $this->callbackTestMode;
    }

    /**
     * @param string $callbackTestMode
     *
     * @return NovalnetSettings
     */
    public function setCallbackTestMode($callbackTestMode)
    {
        $this->callbackTestMode = $callbackTestMode;

        return $this;
    }

    /**
     * @return string
     */
    public function getCallbackEmailTo()
    {
        return $this->callbackEmailTo;
    }

    /**
     * @param string $callbackEmailTo
     *
     * @return NovalnetSettings
     */
    public function setCallbackEmailTo($callbackEmailTo)
    {
        $this->callbackEmailTo = $callbackEmailTo;

        return $this;
    }

    /**
     * @return string
     */
    public function getClientKey()
    {
        return $this->clientKey;
    }

    /**
     * @param string $clientKey
     *
     * @return NovalnetSettings
     */
    public function setClientKey($clientKey)
    {
        $this->clientKey = $clientKey;

        return $this;
    }


    /**
     * @return integer
     */
    public function getTariff()
    {
        return $this->tariff;
    }

    /**
     * @param integer $tariff
     *
     * @return NovalnetSettings
     */
    public function setTariff($tariff)
    {
        $this->tariff = $tariff;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getDisplayPaymentLogo()
    {
        return $this->displayPaymentLogo;
    }

    /**
     * @param boolean $displayPaymentLogo
     *
     * @return NovalnetSettings
     */
    public function setDisplayPaymentLogo($displayPaymentLogo)
    {
        $this->displayPaymentLogo = $displayPaymentLogo;

        return $this;
    }


    /**
     * @return boolean
     */
    public function getCreditCardEnforce3d()
    {
        return $this->creditCardEnforce3d;
    }

    /**
     * @param boolean $creditCardEnforce3d
     *
     * @return NovalnetSettings
     */
    public function setCreditCardEnforce3d($creditCardEnforce3d)
    {
        $this->creditCardEnforce3d = $creditCardEnforce3d;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreditCardPaymentAction()
    {
        return $this->creditCardPaymentAction;
    }

    /**
     * @param string $creditCardPaymentAction
     *
     * @return NovalnetSettings
     */
    public function setCreditCardPaymentAction($creditCardPaymentAction)
    {
        $this->creditCardPaymentAction = $creditCardPaymentAction;
        return $this;
    }

    /**
     * @return integer
     */
    public function getCreditCardOnholdAmount()
    {
        return $this->creditCardOnholdAmount;
    }

    /**
     * @param integer $creditCardOnholdAmount
     *
     * @return NovalnetSettings
     */
    public function setCreditCardOnholdAmount($creditCardOnholdAmount)
    {
        $this->creditCardOnholdAmount = $creditCardOnholdAmount;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getCreditCardOneclick()
    {
        return $this->creditCardOneclick;
    }

    /**
     * @param boolean $creditCardOneclick
     *
     * @return NovalnetSettings
     */
    public function setCreditCardOneclick($creditCardOneclick)
    {
        $this->creditCardOneclick = $creditCardOneclick;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getCreditCardInlineForm()
    {
        return $this->creditCardInlineForm;
    }

    /**
     * @param boolean $creditCardInlineForm
     *
     * @return NovalnetSettings
     */
    public function setCreditCardInlineForm($creditCardInlineForm)
    {
        $this->creditCardInlineForm = $creditCardInlineForm;
        return $this;
    }

    /**
     * @return array
     */
    public function getCreditCardLogo()
    {
        return $this->creditCardLogo;
    }

    /**
     * @param array $creditCardLogo
     *
     * @return NovalnetSettings
     */
    public function setCreditCardLogo($creditCardLogo)
    {
        $this->creditCardLogo = $creditCardLogo;
        return $this;
    }


    /**
     * @return integer
     */
    public function getCreditCardTestMode()
    {
        return $this->creditCardTestMode;
    }

    /**
     * @param integer $creditCardTestMode
     *
     * @return NovalnetSettings
     */
    public function setCreditCardTestMode($creditCardTestMode)
    {
        $this->creditCardTestMode = $creditCardTestMode;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreditCardBuyerNotification()
    {
        return $this->creditCardBuyerNotification;
    }

    /**
     * @param string $creditCardBuyerNotification
     *
     * @return NovalnetSettings
     */
    public function setCreditCardBuyerNotification($creditCardBuyerNotification)
    {
        $this->creditCardBuyerNotification = $creditCardBuyerNotification;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreditCardInputStyle()
    {
        return $this->creditCardInputStyle;
    }

    /**
     * @param string $creditCardInputStyle
     *
     * @return NovalnetSettings
     */
    public function setCreditCardInputStyle($creditCardInputStyle)
    {
        $this->creditCardInputStyle = $creditCardInputStyle;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreditCardLabelStyle()
    {
        return $this->creditCardLabelStyle;
    }

    /**
     * @param string $creditCardLabelStyle
     *
     * @return NovalnetSettings
     */
    public function setCreditCardLabelStyle($creditCardLabelStyle)
    {
        $this->creditCardLabelStyle = $creditCardLabelStyle;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreditCardContainerStyle()
    {
        return $this->creditCardContainerStyle;
    }

    /**
     * @param string $creditCardContainerStyle
     *
     * @return NovalnetSettings
     */
    public function setCreditCardContainerStyle($creditCardContainerStyle)
    {
        $this->creditCardContainerStyle = $creditCardContainerStyle;

        return $this;
    }

    /**
     * @return integer
     */
    public function getInvoiceTestMode()
    {
        return $this->invoiceTestMode;
    }

    /**
     * @param integer $invoiceTestMode
     *
     * @return NovalnetSettings
     */
    public function setInvoiceTestMode($invoiceTestMode)
    {
        $this->invoiceTestMode = $invoiceTestMode;

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
    public function getInvoicePaymentAction()
    {
        return $this->invoicePaymentAction;
    }

    /**
     * @param string $invoicePaymentAction
     *
     * @return NovalnetSettings
     */
    public function setInvoicePaymentAction($invoicePaymentAction)
    {
        $this->invoicePaymentAction = $invoicePaymentAction;

        return $this;
    }

    /**
     * @return integer
     */
    public function getInvoiceOnholdAmount()
    {
        return $this->invoiceOnholdAmount;
    }

    /**
     * @param int $invoiceOnholdAmount
     * @return NovalnetSettings
     */
    public function setInvoiceOnholdAmount($invoiceOnholdAmount)
    {
        $this->invoiceOnholdAmount = $invoiceOnholdAmount;

        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceBuyerNotification()
    {
        return $this->invoiceBuyerNotification;
    }

    /**
     * @param string $invoiceBuyerNotification
     *
     * @return NovalnetSettings
     */
    public function setInvoiceBuyerNotification($invoiceBuyerNotification)
    {
        $this->invoiceBuyerNotification = $invoiceBuyerNotification;

        return $this;
    }

    /**
     * @return integer
     */
    public function getInstalmentInvoiceTestMode()
    {
        return $this->instalmentInvoiceTestMode;
    }

    /**
     * @param integer $instalmentInvoiceTestMode
     *
     * @return NovalnetSettings
     */
    public function setInstalmentInvoiceTestMode($instalmentInvoiceTestMode)
    {
        $this->instalmentInvoiceTestMode = $instalmentInvoiceTestMode;

        return $this;
    }

    /**
     * @return string
     */
    public function getInstalmentInvoicePaymentAction()
    {
        return $this->instalmentInvoicePaymentAction;
    }

    /**
     * @param string $instalmentInvoicePaymentAction
     *
     * @return NovalnetSettings
     */
    public function setInstalmentInvoicePaymentAction($instalmentInvoicePaymentAction)
    {
        $this->instalmentInvoicePaymentAction = $instalmentInvoicePaymentAction;

        return $this;
    }

    /**
     * @return integer
     */
    public function getInstalmentInvoiceOnholdAmount()
    {
        return $this->instalmentInvoiceOnholdAmount;
    }

    /**
     * @param int $instalmentInvoiceOnholdAmount
     * @return NovalnetSettings
     *
     */
    public function setInstalmentInvoiceOnholdAmount($instalmentInvoiceOnholdAmount)
    {
        $this->instalmentInvoiceOnholdAmount = $instalmentInvoiceOnholdAmount;

        return $this;
    }

    /**
     * @return string
     */
    public function getInstalmentInvoiceBuyerNotification()
    {
        return $this->instalmentInvoiceBuyerNotification;
    }

    /**
     * @param string $instalmentInvoiceBuyerNotification
     *
     * @return NovalnetSettings
     */
    public function setInstalmentInvoiceBuyerNotification($instalmentInvoiceBuyerNotification)
    {
        $this->instalmentInvoiceBuyerNotification = $instalmentInvoiceBuyerNotification;

        return $this;
    }

    /**
     * @return string
     */
    public function getInstalmentInvoiceMinAmount()
    {
        return $this->instalmentInvoiceMinAmount;
    }

    /**
     * @param string $instalmentInvoiceMinAmount
     *
     * @return NovalnetSettings
     */
    public function setInstalmentInvoiceMinAmount($instalmentInvoiceMinAmount)
    {
        $this->instalmentInvoiceMinAmount = $instalmentInvoiceMinAmount;

        return $this;
    }



    /**
     * @return string
     */
    public function getInstalmentInvoiceCycle()
    {
        return $this->instalmentInvoiceCycle;
    }

    /**
     * @param string $instalmentInvoiceCycle
     *
     * @return NovalnetSettings
     */
    public function setInstalmentInvoiceCycle($instalmentInvoiceCycle)
    {
        $this->instalmentInvoiceCycle = $instalmentInvoiceCycle;

        return $this;
    }

    /**
     * @return integer
     */
    public function getInstalmentSepaTestMode()
    {
        return $this->instalmentSepaTestMode;
    }

    /**
     * @param integer $instalmentSepaTestMode
     *
     * @return NovalnetSettings
     */
    public function setInstalmentSepaTestMode($instalmentSepaTestMode)
    {
        $this->instalmentSepaTestMode = $instalmentSepaTestMode;

        return $this;
    }

    /**
     * @return string
     */
    public function getInstalmentSepaPaymentAction()
    {
        return $this->instalmentSepaPaymentAction;
    }

    /**
     * @param string $instalmentSepaPaymentAction
     *
     * @return NovalnetSettings
     */
    public function setInstalmentSepaPaymentAction($instalmentSepaPaymentAction)
    {
        $this->instalmentSepaPaymentAction = $instalmentSepaPaymentAction;

        return $this;
    }

    /**
     * @return integer
     */
    public function getInstalmentSepaOnholdAmount()
    {
        return $this->instalmentSepaOnholdAmount;
    }

    /**
     * @param int $instalmentSepaOnholdAmount
     * @return NovalnetSettings
     *
     */
    public function setInstalmentSepaOnholdAmount($instalmentSepaOnholdAmount)
    {
        $this->instalmentSepaOnholdAmount = $instalmentSepaOnholdAmount;

        return $this;
    }

    /**
     * @return string
     */
    public function getInstalmentSepaBuyerNotification()
    {
        return $this->instalmentSepaBuyerNotification;
    }

    /**
     * @param string $instalmentSepaBuyerNotification
     *
     * @return NovalnetSettings
     */
    public function setInstalmentSepaBuyerNotification($instalmentSepaBuyerNotification)
    {
        $this->instalmentSepaBuyerNotification = $instalmentSepaBuyerNotification;

        return $this;
    }

    /**
     * @return string
     */
    public function getInstalmentSepaMinAmount()
    {
        return $this->instalmentSepaMinAmount;
    }

    /**
     * @param string $instalmentSepaMinAmount
     *
     * @return NovalnetSettings
     */
    public function setInstalmentSepaMinAmount($instalmentSepaMinAmount)
    {
        $this->instalmentSepaMinAmount = $instalmentSepaMinAmount;

        return $this;
    }

    /**
     * @return string
     */
    public function getInstalmentSepaCycle()
    {
        return $this->instalmentSepaCycle;
    }

    /**
     * @param string $instalmentSepaCycle
     *
     * @return NovalnetSettings
     */
    public function setInstalmentSepaCycle($instalmentSepaCycle)
    {
        $this->instalmentSepaCycle = $instalmentSepaCycle;

        return $this;
    }

    /**
     * @return integer
     */
    public function getInstalmentSepaOneclick()
    {
        return $this->instalmentSepaOneclick;
    }

    /**
     * @param integer $instalmentSepaOneclick
     *
     * @return NovalnetSettings
     */
    public function setInstalmentSepaOneclick($instalmentSepaOneclick)
    {
        $this->instalmentSepaOneclick = $instalmentSepaOneclick;

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
     * @return integer
     */
    public function getSepaTestMode()
    {
        return $this->sepaTestMode;
    }

    /**
     * @param integer $sepaTestMode
     *
     * @return NovalnetSettings
     */
    public function setSepaTestMode($sepaTestMode)
    {
        $this->sepaTestMode = $sepaTestMode;

        return $this;
    }

    /**
     * @return integer
     */
    public function getSepaOneclick()
    {
        return $this->sepaOneclick;
    }

    /**
     * @param integer $sepaOneclick
     *
     * @return NovalnetSettings
     */
    public function setSepaOneclick($sepaOneclick)
    {
        $this->sepaOneclick = $sepaOneclick;

        return $this;
    }

    /**
     * @return string
     */
    public function getSepaPaymentAction()
    {
        return $this->sepaPaymentAction;
    }

    /**
     * @param string $sepaPaymentAction
     *
     * @return NovalnetSettings
     */
    public function setSepaPaymentAction($sepaPaymentAction)
    {
        $this->sepaPaymentAction = $sepaPaymentAction;

        return $this;
    }

    /**
     * @return integer
     */
    public function getSepaOnholdAmount()
    {
        return $this->sepaOnholdAmount;
    }

    /**
     * @param integer $sepaOnholdAmount
     *
     * @return NovalnetSettings
     */
    public function setSepaOnholdAmount($sepaOnholdAmount)
    {
        $this->sepaOnholdAmount = $sepaOnholdAmount;

        return $this;
    }

    /**
     * @return string
     */
    public function getSepaBuyerNotification()
    {
        return $this->sepaBuyerNotification;
    }

    /**
     * @param string $sepaBuyerNotification
     *
     * @return NovalnetSettings
     */
    public function setSepaBuyerNotification($sepaBuyerNotification)
    {
        $this->sepaBuyerNotification = $sepaBuyerNotification;

        return $this;
    }

    /**
     * @return integer
     */
    public function getPaypalTestMode()
    {
        return $this->paypalTestMode;
    }

    /**
     * @param integer $paypalTestMode
     *
     * @return NovalnetSettings
     */
    public function setPaypalTestMode($paypalTestMode)
    {
        $this->paypalTestMode = $paypalTestMode;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaypalPaymentAction()
    {
        return $this->paypalPaymentAction;
    }

    /**
     * @param string $paypalPaymentAction
     *
     * @return NovalnetSettings
     */
    public function setPaypalPaymentAction($paypalPaymentAction)
    {
        $this->paypalPaymentAction = $paypalPaymentAction;

        return $this;
    }

    /**
     * @return integer
     */
    public function getPaypalOnholdAmount()
    {
        return $this->paypalOnholdAmount;
    }

    /**
     * @param integer $paypalOnholdAmount
     *
     * @return NovalnetSettings
     */
    public function setPaypalOnholdAmount($paypalOnholdAmount)
    {
        $this->paypalOnholdAmount = $paypalOnholdAmount;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaypalBuyerNotification()
    {
        return $this->paypalBuyerNotification;
    }

    /**
     * @param string $paypalBuyerNotification
     *
     * @return NovalnetSettings
     */
    public function setPaypalBuyerNotification($paypalBuyerNotification)
    {
        $this->paypalBuyerNotification = $paypalBuyerNotification;

        return $this;
    }

    /**
     * @return integer
     */
    public function getPrepaymentTestMode()
    {
        return $this->prepaymentTestMode;
    }

    /**
     * @param integer $prepaymentTestMode
     *
     * @return NovalnetSettings
     */
    public function setPrepaymentTestMode($prepaymentTestMode)
    {
        $this->prepaymentTestMode = $prepaymentTestMode;

        return $this;
    }

    /**
     * @return integer
     */
    public function getPrepaymentDuedate()
    {
        return $this->prepaymentDuedate;
    }

    /**
     * @param integer $prepaymentDuedate
     *
     * @return NovalnetSettings
     */
    public function setPrepaymentDuedate($prepaymentDuedate)
    {
        $this->prepaymentDuedate = $prepaymentDuedate;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrepaymentBuyerNotification()
    {
        return $this->prepaymentBuyerNotification;
    }

    /**
     * @param string $prepaymentBuyerNotification
     *
     * @return NovalnetSettings
     */
    public function setPrepaymentBuyerNotification($prepaymentBuyerNotification)
    {
        $this->prepaymentBuyerNotification = $prepaymentBuyerNotification;

        return $this;
    }



    /**
     * @return integer
     */
    public function getIdealTestMode()
    {
        return $this->idealTestMode;
    }

    /**
     * @param integer $idealTestMode
     *
     * @return NovalnetSettings
     */
    public function setIdealTestMode($idealTestMode)
    {
        $this->idealTestMode = $idealTestMode;

        return $this;
    }

    /**
     * @return string
     */
    public function getIdealBuyerNotification()
    {
        return $this->idealBuyerNotification;
    }
    
    /**
     * @return string
     */
    public function setIdealBuyerNotification($idealBuyerNotification)
    {
        $this->idealBuyerNotification = $idealBuyerNotification;
        return $this;
    }

    /**
     * @return integer
     */
    public function getAlipayTestMode()
    {
        return $this->alipayTestMode;
    }

    /**
     * @param integer $alipayTestMode
     *
     * @return NovalnetSettings
     */
    public function setAlipayTestMode($alipayTestMode)
    {
        $this->alipayTestMode = $alipayTestMode;

        return $this;
    }

    /**
     * @return string
     */
    public function getAlipayBuyerNotification()
    {
        return $this->alipayBuyerNotification;
    }
    
    /**
     * @return string
     */
    public function setAlipayBuyerNotification($alipayBuyerNotification)
    {
        $this->alipayBuyerNotification = $alipayBuyerNotification;
        return $this;
    }
    
    /**
     * @return integer
     */
    public function getWechatpayTestMode()
    {
        return $this->wechatpayTestMode;
    }

    /**
     * @param integer $wechatpayTestMode
     *
     * @return NovalnetSettings
     */
    public function setWechatpayTestMode($wechatpayTestMode)
    {
        $this->wechatpayTestMode = $wechatpayTestMode;

        return $this;
    }

    /**
     * @return string
     */
    public function getWechatpayBuyerNotification()
    {
        return $this->wechatpayBuyerNotification;
    }
    
    /**
     * @return string
     */
    public function setWechatpayBuyerNotification($wechatpayBuyerNotification)
    {
        $this->wechatpayBuyerNotification = $wechatpayBuyerNotification;
        return $this;
    }
    
    /**
     * @return integer
     */
    public function getTrustlyTestMode()
    {
        return $this->trustlyTestMode;
    }

    /**
     * @param integer $trustlyTestMode
     *
     * @return NovalnetSettings
     */
    public function setTrustlyTestMode($trustlyTestMode)
    {
        $this->trustlyTestMode = $trustlyTestMode;

        return $this;
    }

    /**
     * @return string
     */
    public function getTrustlyBuyerNotification()
    {
        return $this->trustlyBuyerNotification;
    }
    
    /**
     * @return string
     */
    public function setTrustlyBuyerNotification($trustlyBuyerNotification)
    {
        $this->trustlyBuyerNotification = $trustlyBuyerNotification;
        return $this;
    }
    
    /**
     * @return integer
     */
    public function getOnlinebanktransferTestMode()
    {
        return $this->onlinebanktransferTestMode;
    }

    /**
     * @param integer $onlinebanktransferTestMode
     *
     * @return NovalnetSettings
     */
    public function setOnlinebanktransferTestMode($onlinebanktransferTestMode)
    {
        $this->onlinebanktransferTestMode = $onlinebanktransferTestMode;

        return $this;
    }

    /**
     * @return string
     */
    public function getOnlinebanktransferBuyerNotification()
    {
        return $this->onlinebanktransferBuyerNotification;
    }
    
    /**
     * @return string
     */
    public function setOnlinebanktransferBuyerNotification($onlinebanktransferBuyerNotification)
    {
        $this->onlinebanktransferBuyerNotification = $onlinebanktransferBuyerNotification;
        return $this;
    }
    
    /**
     * @return integer
     */
    public function getGuaranteedSepaTestMode()
    {
        return $this->guaranteedSepaTestMode;
    }

    /**
     * @param integer $guaranteedSepaTestMode
     *
     * @return NovalnetSettings
     */
    public function setGuaranteedSepaTestMode($guaranteedSepaTestMode)
    {
        $this->guaranteedSepaTestMode = $guaranteedSepaTestMode;

        return $this;
    }

    /**
     * @return string
     */
    public function getGuaranteedSepaBuyerNotification()
    {
        return $this->guaranteedSepaBuyerNotification;
    }

    /**
     * @param string $guaranteedSepaBuyerNotification
     *
     * @return NovalnetSettings
     */
    public function setGuaranteedSepaBuyerNotification($guaranteedSepaBuyerNotification)
    {
        $this->guaranteedSepaBuyerNotification = $guaranteedSepaBuyerNotification;

        return $this;
    }

    /**
     * @return integer
     */
    public function getGuaranteedSepaMinAmount()
    {
        return $this->guaranteedSepaMinAmount;
    }

    /**
     * @param string $guaranteedSepaMinAmount
     *
     * @return NovalnetSettings
     */
    public function setGuaranteedSepaMinAmount($guaranteedSepaMinAmount)
    {
        $this->guaranteedSepaMinAmount = $guaranteedSepaMinAmount;

        return $this;
    }

    /**
     * @return integer
     */
    public function getGuaranteedSepaOnholdAmount()
    {
        return $this->guaranteedSepaOnholdAmount;
    }

    /**
     * @param string $guaranteedSepaOnholdAmount
     *
     * @return NovalnetSettings
     */
    public function setGuaranteedSepaOnholdAmount($guaranteedSepaOnholdAmount)
    {
        $this->guaranteedSepaOnholdAmount = $guaranteedSepaOnholdAmount;

        return $this;
    }

    /**
     * @return string
     */
    public function getGuaranteedSepaPaymentAction()
    {
        return $this->guaranteedSepaPaymentAction;
    }

    /**
     * @param string $guaranteedSepaPaymentAction
     *
     * @return NovalnetSettings
     */
    public function setGuaranteedSepaPaymentAction($guaranteedSepaPaymentAction)
    {
        $this->guaranteedSepaPaymentAction = $guaranteedSepaPaymentAction;

        return $this;
    }


    /**
     * @return integer
     */
    public function getGuaranteedSepaOneclick()
    {
        return $this->guaranteedSepaOneclick;
    }

    /**
     * @param integer $guaranteedSepaOneclick
     *
     * @return NovalnetSettings
     */
    public function setGuaranteedSepaOneclick($guaranteedSepaOneclick)
    {
        $this->guaranteedSepaOneclick = $guaranteedSepaOneclick;

        return $this;
    }




    /**
     * @return integer
     */
    public function getGuaranteedInvoiceTestMode()
    {
        return $this->guaranteedInvoiceTestMode;
    }

    /**
     * @param int $guaranteedInvoiceTestMode
     *
     * @return NovalnetSettings
     */
    public function setGuaranteedInvoiceTestMode($guaranteedInvoiceTestMode)
    {
        $this->guaranteedInvoiceTestMode = $guaranteedInvoiceTestMode;

        return $this;
    }

    /**
     * @return string
     */
    public function getGuaranteedInvoiceBuyerNotification()
    {
        return $this->guaranteedInvoiceBuyerNotification;
    }

    /**
     * @param string $guaranteedInvoiceBuyerNotification
     *
     * @return NovalnetSettings
     */
    public function setGuaranteedInvoiceBuyerNotification($guaranteedInvoiceBuyerNotification)
    {
        $this->guaranteedInvoiceBuyerNotification = $guaranteedInvoiceBuyerNotification;

        return $this;
    }

    /**
     * @return integer
     */
    public function getGuaranteedInvoiceMinAmount()
    {
        return $this->guaranteedInvoiceMinAmount;
    }

    /**
     * @param string $guaranteedInvoiceMinAmount
     *
     * @return NovalnetSettings
     */
    public function setGuaranteedInvoiceMinAmount($guaranteedInvoiceMinAmount)
    {
        $this->guaranteedInvoiceMinAmount = $guaranteedInvoiceMinAmount;

        return $this;
    }

    /**
     * @return integer
     */
    public function getGuaranteedInvoiceOnholdAmount()
    {
        return $this->guaranteedInvoiceOnholdAmount;
    }

    /**
     * @param string $guaranteedInvoiceOnholdAmount
     *
     * @return NovalnetSettings
     */
    public function setGuaranteedInvoiceOnholdAmount($guaranteedInvoiceOnholdAmount)
    {
        $this->guaranteedInvoiceOnholdAmount = $guaranteedInvoiceOnholdAmount;

        return $this;
    }

    /**
     * @return string
     */
    public function getGuaranteedInvoicePaymentAction()
    {
        return $this->guaranteedInvoicePaymentAction;
    }

    /**
     * @param string $guaranteedInvoicePaymentAction
     *
     * @return NovalnetSettings
     */
    public function setGuaranteedInvoicePaymentAction($guaranteedInvoicePaymentAction)
    {
        $this->guaranteedInvoicePaymentAction = $guaranteedInvoicePaymentAction;

        return $this;
    }

    /**
     * @return integer
     */
    public function getEpsTestMode()
    {
        return $this->epsTestMode;
    }

    /**
     * @param integer $epsTestMode
     *
     * @return NovalnetSettings
     */
    public function setEpsTestMode($epsTestMode)
    {
        $this->epsTestMode = $epsTestMode;

        return $this;
    }

    /**
     * @return string
     */
    public function getEpsBuyerNotification()
    {
        return $this->epsBuyerNotification;
    }

    /**
     * @param string $epsBuyerNotification
     *
     * @return NovalnetSettings
     */
    public function setEpsBuyerNotification($epsBuyerNotification)
    {
        $this->epsBuyerNotification = $epsBuyerNotification;

        return $this;
    }



    /**
     * @return integer
     */
    public function getPrzelewyTestMode()
    {
        return $this->przelewyTestMode;
    }

    /**
     * @param integer $przelewyTestMode
     *
     * @return NovalnetSettings
     */
    public function setPrzelewyTestMode($przelewyTestMode)
    {
        $this->przelewyTestMode = $przelewyTestMode;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrzelewyBuyerNotification()
    {
        return $this->przelewyBuyerNotification;
    }

    /**
     * @param string $przelewyBuyerNotification
     *
     * @return NovalnetSettings
     */
    public function setPrzelewyBuyerNotification($przelewyBuyerNotification)
    {
        $this->przelewyBuyerNotification = $przelewyBuyerNotification;

        return $this;
    }

    /**
     * @return integer
     */
    public function getPostfinanceTestMode()
    {
        return $this->postfinanceTestMode;
    }

    /**
     * @param integer $postfinanceTestMode
     *
     * @return NovalnetSettings
     */
    public function setPostfinanceTestMode($postfinanceTestMode)
    {
        $this->postfinanceTestMode = $postfinanceTestMode;

        return $this;
    }

    /**
     * @return string
     */
    public function getPostfinanceBuyerNotification()
    {
        return $this->postfinanceBuyerNotification;
    }

    /**
     * @param string $postfinanceBuyerNotification
     *
     * @return NovalnetSettings
     */
    public function setPostfinanceBuyerNotification($postfinanceBuyerNotification)
    {
        $this->postfinanceBuyerNotification = $postfinanceBuyerNotification;

        return $this;
    }

    /**
     * @return integer
     */
    public function getPostfinanceCardTestMode()
    {
        return $this->postfinanceCardTestMode;
    }

    /**
     * @param integer $postfinanceCardTestMode
     *
     * @return NovalnetSettings
     */
    public function setPostfinanceCardTestMode($postfinanceCardTestMode)
    {
        $this->postfinanceCardTestMode = $postfinanceCardTestMode;

        return $this;
    }

    /**
     * @return string
     */
    public function getPostfinanceCardBuyerNotification()
    {
        return $this->postfinanceCardBuyerNotification;
    }

    /**
     * @param string $postfinanceCardBuyerNotification
     *
     * @return NovalnetSettings
     */
    public function setPostfinanceCardBuyerNotification($postfinanceCardBuyerNotification)
    {
        $this->postfinanceCardBuyerNotification = $postfinanceCardBuyerNotification;

        return $this;
    }

    /**
     * @return integer
     */
    public function getMultibancoTestMode()
    {
        return $this->multibancoTestMode;
    }

    /**
     * @param integer $multibancoTestMode
     *
     * @return NovalnetSettings
     */
    public function setMultibancoTestMode($multibancoTestMode)
    {
        $this->multibancoTestMode = $multibancoTestMode;

        return $this;
    }

    /**
     * @return string
     */
    public function getMultibancoBuyerNotification()
    {
        return $this->multibancoBuyerNotification;
    }

    /**
     * @param string $multibancoBuyerNotification
     *
     * @return NovalnetSettings
     */
    public function setMultibancoBuyerNotification($multibancoBuyerNotification)
    {
        $this->multibancoBuyerNotification = $multibancoBuyerNotification;

        return $this;
    }

    /**
     * @return integer
     */
    public function getBancontactTestMode()
    {
        return $this->bancontactTestMode;
    }

    /**
     * @param integer $bancontactTestMode
     *
     * @return NovalnetSettings
     */
    public function setBancontactTestMode($bancontactTestMode)
    {
        $this->bancontactTestMode = $bancontactTestMode;

        return $this;
    }

    /**
     * @return string
     */
    public function getBancontactBuyerNotification()
    {
        return $this->bancontactBuyerNotification;
    }

    /**
     * @param string $bancontactBuyerNotification
     *
     * @return NovalnetSettings
     */
    public function setBancontactBuyerNotification($bancontactBuyerNotification)
    {
        $this->bancontactBuyerNotification = $bancontactBuyerNotification;

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
                    'tariff' => $this->getTariff(),
                    'payment_access_key' => $this->getPaymentAccessKey(),
                    'product_activation_key' => $this->getProductActivationKey(),
                    'callback_test_mode' => $this->getCallbackTestMode(),
                    'callback_email_to' => $this->getCallbackEmailTo(),
                    'client_key' => $this->getClientKey(),
                    'creditcard_labels' => $this->getCreditCardLabel(),
                    'creditcard_short_labels' => $this->getCreditCardShortLabel(),
                    'creditcard_test_mode' => $this->getCreditCardTestMode(),
                    'creditcard_enforce_3d' => $this->creditCardEnforce3d(),
                    'creditcard_onhold_amount' => $this->getCreditCardOnholdAmount(),
                    'creditcard_oneclick' => $this->getCreditCardOneclick(),
                    'creditcard_logo' => $this->getCreditCardLogo(),
                    'creditcard_payment_action' => $this->getCreditCardPaymentAction(),
                    'creditcard_inline_form' => $this->getCreditCardInlineForm(),
                    'creditcard_buyer_notification' => $this->getCreditCardBuyerNotification(),
                    'creditcard_input_style' => $this->getCreditCardInputStyle(),
                    'creditcard_label_style' => $this->getCreditCardLabelStyle(),
                    'creditcard_container_style' => $this->getCreditCardContainerStyle(),
                    'sepa_labels' => $this->getSepaLabel(),
                    'sepa_short_labels' => $this->getSepaShortLabel(),
                    'sepa_test_mode' => $this->getSepaTestMode(),
                    'sepa_duedate' => $this->getSepaDuedate(),
                    'sepa_payment_action' => $this->getSepaPaymentAction(),
                    'sepa_onhold_amount' => $this->getSepaOnholdAmount(),
                    'sepa_buyer_notification' => $this->getSepaBuyerNotification(),
                    'guaranteed_sepa_labels' => $this->getGuaranteedSepaLabel(),
                    'guaranteed_sepa_short_labels' => $this->getGuaranteedSepaShortLabel(),
                    'guaranteed_sepa_test_mode' => $this->getGuaranteedSepaTestMode(),
                    'guaranteed_sepa_buyer_notification' => $this->getGuaranteedSepaBuyerNotification(),
                    'guaranteed_sepa_payment_action' => $this->getGuaranteedSepaPaymentAction(),
                    'guaranteed_sepa_onhold_amount' => $this->getGuaranteedSepaOnholdAmount(),
                    'guaranteed_sepa_min_amount' => $this->getGuaranteedSepaMinAmount(),
                    'guaranteed_sepa_oneclick' => $this->getGuaranteedSepaOneclick(),
                    'guaranteed_invoice_labels' => $this->getGuaranteedInvoiceLabel(),
                    'guaranteed_invoice_short_labels' => $this->getGuaranteedInvoiceShortLabel(),
                    'guaranteed_invoice_test_mode' => $this->getGuaranteedInvoiceTestMode(),
                    'guaranteed_invoice_buyer_notification' => $this->getGuaranteedInvoiceBuyerNotification(),
                    'guaranteed_invoice_payment_action' => $this->getGuaranteedInvoicePaymentAction(),
                    'guaranteed_invoice_onhold_amount' => $this->getGuaranteedInvoiceOnholdAmount(),
                    'guaranteed_invoice_min_amount' => $this->getGuaranteedInvoiceMinAmount(),
                    'invoice_labels' => $this->getInvoiceLabel(),
                    'invoice_short_labels' => $this->getInvoiceShortLabel(),
                    'invoice_test_mode' => $this->getInvoiceTestMode(),
                    'invoice_duedate' => $this->getInvoiceDuedate(),
                    'invoice_payment_action' => $this->getInvoicePaymentAction(),
                    'invoice_onhold_amount' => $this->getInvoiceOnholdAmount(),
                    'invoice_buyer_notification' => $this->getInvoiceBuyerNotification(),
                    'instalment_invoice_labels' => $this->getInstalmentInvoiceLabel(),
                    'instalment_invoice_short_labels' => $this->getInstalmentInvoiceShortLabel(),
                    'instalment_invoice_test_mode' => $this->getInstalmentInvoiceTestMode(),
                    'instalment_invoice_payment_action' => $this->getInstalmentInvoicePaymentAction(),
                    'instalment_invoice_min_amount' => $this->getInstalmentInvoiceMinAmount(),
                    'instalment_invoice_onhold_amount' => $this->getInstalmentInvoiceOnholdAmount(),
                    'instalment_invoice_buyer_notification' => $this->getInstalmentInvoiceBuyerNotification(),
                    'instalment_invoice_cycle' => $this->getInstalmentInvoiceCycle(),
                    'instalment_sepa_labels' => $this->getInstalmentSepaLabel(),
                    'instalment_sepa_short_labels' => $this->getInstalmentSepaShortLabel(),
                    'instalment_sepa_test_mode' => $this->getInstalmentSepaTestMode(),
                    'instalment_sepa_payment_action' => $this->getInstalmentSepaPaymentAction(),
                    'instalment_sepa_min_amount' => $this->getInstalmentSepaMinAmount(),
                    'instalment_sepa_onhold_amount' => $this->getInstalmentSepaOnholdAmount(),
                    'instalment_sepa_buyer_notification' => $this->getInstalmentSepaBuyerNotification(),
                    'instalment_sepa_cycle' => $this->getInstalmentSepaCycle(),
                    'instalment_sepa_oneclick' => $this->getInstalmentSepaOneclick(),
                    'prepayment_labels' => $this->getPrepaymentLabel(),
                    'prepayment_short_labels' => $this->getPrepaymentShortLabel(),
                    'prepayment_test_mode' => $this->getPrepaymentTestMode(),
                    'prepayment_due_date' => $this->getPrepaymentDuedate(),
                    'prepayment_buyer_notification' => $this->getPrepaymentBuyerNotification(),
                    'paypal_labels' => $this->getPaypalLabel(),
                    'paypal_short_labels' => $this->getPaypalShortLabel(),
                    'paypal_test_mode' => $this->getPaypalTestMode(),
                    'paypal_payment_action' => $this->getPaypalPaymentAction(),
                    'paypal_onhold_amount' => $this->getPaypalOnholdAmount(),
                    'paypal_buyer_notification' => $this->getPaypalBuyerNotification(),
                    'ideal_labels' => $this->getIdealLabel(),
                    'ideal_short_labels' => $this->getIdealShortLabel(),
                    'ideal_test_mode' => $this->getIdealTestMode(),
                    'ideal_buyer_notification' => $this->getIdealBuyerNotification(),
                    'eps_labels' => $this->getEpsLabel(),
                    'eps_short_labels' => $this->getEpsShortLabel(),
                    'eps_test_mode' => $this->getEpsTestMode(),
                    'eps_buyer_notification' => $this->getEpsBuyerNotification(),
                    'przelewy_labels' => $this->getPrzelewyLabel(),
                    'przelewy_short_labels' => $this->getPrzelewyShortLabel(),
                    'przelewy_test_mode' => $this->getPrzelewyTestMode(),
                    'przelewy_buyer_notification' => $this->getPrzelewyBuyerNotification(),
                    'postfinance_labels' => $this->getPostfinanceLabel(),
                    'postfinance_short_labels' => $this->getPostfinanceShortLabel(),
                    'postfinance_test_mode' => $this->getPostfinanceTestMode(),
                    'postfinance_buyer_notification' => $this->getPostfinanceBuyerNotification(),
                    'postfinance_card_labels' => $this->getPostfinanceCardLabel(),
                    'postfinance_card_short_labels' => $this->getPostfinanceCardShortLabel(),
                    'postfinance_card_test_mode' => $this->getPostfinanceCardTestMode(),
                    'postfinance_card_buyer_notification' => $this->getPostfinanceCardBuyerNotification(),
                    'multibanco_labels' => $this->getMultibancoLabel(),
                    'multibanco_short_labels' => $this->getMultibancoShortLabel(),
                    'multibanco_test_mode' => $this->getMultibancoTestMode(),
                    'multibanco_buyer_notification' => $this->getMultibancoBuyerNotification(),
                    'bancontact_labels' => $this->getBancontactLabel(),
                    'bancontact_short_labels' => $this->getBancontactShortLabel(),
                    'bancontact_test_mode' => $this->getBancontactTestMode(),
                    'bancontact_buyer_notification' => $this->getBancontactBuyerNotification(),
                    'naverpay_labels' => $this->getNaverpayLabel(),
                    'naverpay_short_labels' => $this->getNaverpayShortLabel(),
                    'naverpay_test_mode' => $this->getNaverpayTestMode(),
                    'naverpay_buyer_notification' => $this->getNaverpayBuyerNotification(),
                    'blik_labels' => $this->getBlikLabel(),
                    'blik_short_labels' => $this->getBlikShortLabel(),
                    'blik_test_mode' => $this->getBlikTestMode(),
                    'blik_buyer_notification' => $this->getBlikBuyerNotification(),
                    'kakaopay_labels' => $this->getKakaopayLabel(),
                    'kakaopay_short_labels' => $this->getKakaopayShortLabel(),
                    'kakaopay_test_mode' => $this->getKakaopayTestMode(),
                    'kakaopay_buyer_notification' => $this->getKakaopayBuyerNotification(),
                    'mbway_labels' => $this->getMbwayLabel(),
                    'mbway_short_labels' => $this->getMbwayShortLabel(),
                    'mbway_test_mode' => $this->getMbwayTestMode(),
                    'mbway_buyer_notification' => $this->getMbwayBuyerNotification(),
                    'payconiq_labels' => $this->getPayconiqLabel(),
                    'payconiq_short_labels' => $this->getPayconiqShortLabel(),
                    'payconiq_test_mode' => $this->getPayconiqTestMode(),
                    'payconiq_buyer_notification' => $this->getPayconiqBuyerNotification(),
                    'twint_labels' => $this->getTwintLabel(),
                    'twint_short_labels' => $this->getTwintShortLabel(),
                    'twint_test_mode' => $this->getTwintTestMode(),
                    'twint_buyer_notification' => $this->getTwintBuyerNotification(),
                    'ach_labels' => $this->getAchLabel(),
                    'ach_short_labels' => $this->getAchShortLabel(),
                    'ach_test_mode' => $this->getAchTestMode(),
                    'ach_buyer_notification' => $this->getAchBuyerNotification(),
                    'ach_oneclick' => $this->getAchOneclick(),
                ]
            );
        }

        return $this->settings;
    }
}
