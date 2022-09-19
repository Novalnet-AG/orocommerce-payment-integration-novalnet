<?php

namespace Novalnet\Bundle\NovalnetBundle\Form\Type;

use Novalnet\Bundle\NovalnetBundle\Settings\DataProvider\NovalnetSettingsDataProviderInterface;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\Exception\AccessException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\InvalidOptionsException;
use Symfony\Component\Validator\Exception\MissingOptionsException;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Oro\Bundle\ValidationBundle\Validator\Constraints\NumericRange;
use Oro\Bundle\ValidationBundle\Validator\Constraints\GreaterThanZero;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Form type for Novalnet integration settings
 */
class NovalnetSettingsType extends AbstractType
{
    const BLOCK_PREFIX = 'novalnet_settings';

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var NovalnetSettingsDataProviderInterface
     */
    protected $novalnetSettingsDataProvider;


    /**
     * @param RouterInterface $routerInterface
     */
    public function __construct(
        TranslatorInterface $translator,
        NovalnetSettingsDataProviderInterface $novalnetSettingsDataProvider
    ) {
        $this->translator = $translator;
        $this->novalnetSettingsDataProvider = $novalnetSettingsDataProvider;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     *
     * @throws ConstraintDefinitionException
     * @throws InvalidOptionsException
     * @throws MissingOptionsException
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('creditCardLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
            ])
            ->add('creditCardShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
            ])
            ->add('creditCardTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false
            ])
            ->add('creditCardEnforce3d', CheckboxType::class, [
                'label' => 'novalnet.settings.credit_card_enforce_3d.label',
                'required' => false
            ])
            ->add('creditCardPaymentAction', ChoiceType::class, [
                'choices' => $this->novalnetSettingsDataProvider->getPaymentActions(),
                'choice_label' => function ($action) {
                    return $this->translator->trans(
                        sprintf('novalnet.settings.%s', $action)
                    );
                },
                'label' => 'novalnet.settings.payment_action.label',
                'required' => false
            ])
            ->add('creditCardOnholdAmount', IntegerType::class, [
                'label' => 'novalnet.settings.onhold_amount.label',
                'required' => false
            ])
            ->add('creditCardOneclick', CheckboxType::class, [
                'label' => 'novalnet.settings.oneclick.label',
                'required' => false
            ])
            ->add('creditCardInlineForm', CheckboxType::class, [
                'label' => 'novalnet.settings.credit_card_inline_form.label',
                'required' => false
            ])
            ->add('creditCardLogo', ChoiceType::class, [
                'choices' => $this->novalnetSettingsDataProvider->getCreditCardLogos(),
                'choice_label' => function ($logo) {
                    return $this->translator->trans(
                        sprintf('novalnet.settings.%s', $logo)
                    );
                },
                'label' => 'novalnet.settings.credit_card_logo.label',
                'multiple' => true,
                'required' => false
            ])
            ->add('creditCardBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false
            ])
            ->add('creditCardInputStyle', TextType::class, [
                'label' => 'novalnet.settings.credit_card_input_style.label',
                'required' => false
            ])
            ->add('creditCardLabelStyle', TextType::class, [
                'label' => 'novalnet.settings.credit_card_label_style.label',
                'required' => false
            ])
            ->add('creditCardContainerStyle', TextType::class, [
                'label' => 'novalnet.settings.credit_card_container_style.label',
                'required' => false
            ])
            ->add('sepaLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
            ])
            ->add('sepaShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
            ])
            ->add('sepaTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
            ])
            ->add('sepaOneclick', CheckboxType::class, [
                'label' => 'novalnet.settings.oneclick.label',
                'required' => false,
            ])
            ->add('sepaDuedate', IntegerType::class, [
                'label' => 'novalnet.settings.sepa_duedate.label',
                'required' => false,
                'constraints' => [new NumericRange(['min' => 2, 'max' => 14])]
            ])
            ->add('sepaPaymentAction', ChoiceType::class, [
                'choices' => $this->novalnetSettingsDataProvider->getPaymentActions(),
                'choice_label' => function ($action) {
                    return $this->translator->trans(
                        sprintf('novalnet.settings.%s', $action)
                    );
                },
                'label' => 'novalnet.settings.payment_action.label',
                'required' => false
            ])
            ->add('sepaOnholdAmount', IntegerType::class, [
                'label' => 'novalnet.settings.onhold_amount.label',
                'required' => false
            ])
            ->add('sepaBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false
            ])
            ->add('guaranteedSepaLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
            ])
            ->add('guaranteedSepaShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
            ])
            ->add('guaranteedInvoiceLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
            ])
            ->add('guaranteedInvoiceShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
            ])
            ->add('guaranteedSepaTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
            ])
            ->add('guaranteedSepaBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false
            ])
            ->add('guaranteedSepaMinAmount', IntegerType::class, [
                'label' => 'novalnet.settings.min_amount.label',
                'required' => false,
                'constraints' => [new NumericRange(['min' => 999])]
            ])
            ->add('guaranteedSepaPaymentAction', ChoiceType::class, [
                'choices' => $this->novalnetSettingsDataProvider->getPaymentActions(),
                'choice_label' => function ($action) {
                    return $this->translator->trans(
                        sprintf('novalnet.settings.%s', $action)
                    );
                },
                'label' => 'novalnet.settings.payment_action.label',
                'required' => false
            ])
            ->add('guaranteedSepaOnholdAmount', IntegerType::class, [
                'label' => 'novalnet.settings.onhold_amount.label',
                'required' => false
            ])
            ->add('guaranteedSepaDuedate', IntegerType::class, [
                'label' => 'novalnet.settings.sepa_duedate.label',
                'required' => false,
                'constraints' => [new NumericRange(['min' => 2, 'max' => 14])]
            ])
            ->add('guaranteedSepaOneclick', CheckboxType::class, [
                'label' => 'novalnet.settings.oneclick.label',
                'required' => false,
            ])
            ->add('guaranteedInvoiceTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
            ])
            ->add('guaranteedInvoiceBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false
            ])
            ->add('guaranteedInvoiceMinAmount', IntegerType::class, [
                'label' => 'novalnet.settings.min_amount.label',
                'required' => false,
                'constraints' => [new NumericRange(['min' => 999])]
            ])
            ->add('guaranteedInvoicePaymentAction', ChoiceType::class, [
                'choices' => $this->novalnetSettingsDataProvider->getPaymentActions(),
                'choice_label' => function ($action) {
                    return $this->translator->trans(
                        sprintf('novalnet.settings.%s', $action)
                    );
                },
                'label' => 'novalnet.settings.payment_action.label',
                'required' => false
            ])
            ->add('guaranteedInvoiceOnholdAmount', IntegerType::class, [
                'label' => 'novalnet.settings.onhold_amount.label',
                'required' => false
            ])
            ->add('invoiceLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
            ])
            ->add('invoiceShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
            ])
            ->add('invoiceTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
            ])
            ->add('invoiceDuedate', IntegerType::class, [
                'label' => 'novalnet.settings.invoice_duedate.label',
                'required' => false,
                'constraints' => [new NumericRange(['min' => 7])]
            ])
            ->add('invoicePaymentAction', ChoiceType::class, [
                'choices' => $this->novalnetSettingsDataProvider->getPaymentActions(),
                'choice_label' => function ($action) {
                    return $this->translator->trans(
                        sprintf('novalnet.settings.%s', $action)
                    );
                },
                'label' => 'novalnet.settings.payment_action.label',
                'required' => false
            ])
            ->add('invoiceOnholdAmount', IntegerType::class, [
                'label' => 'novalnet.settings.onhold_amount.label',
                'required' => false
            ])
            ->add('invoiceBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false
            ])
            ->add('instalmentInvoiceLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
            ])
            ->add('instalmentInvoiceShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
            ])
            ->add('instalmentInvoiceTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
            ])
            ->add('instalmentInvoicePaymentAction', ChoiceType::class, [
                'choices' => $this->novalnetSettingsDataProvider->getPaymentActions(),
                'choice_label' => function ($action) {
                    return $this->translator->trans(
                        sprintf('novalnet.settings.%s', $action)
                    );
                },
                'label' => 'novalnet.settings.payment_action.label',
                'required' => false
            ])
            ->add('instalmentInvoiceOnholdAmount', IntegerType::class, [
                'label' => 'novalnet.settings.onhold_amount.label',
                'required' => false
            ])
            ->add('instalmentInvoiceMinAmount', IntegerType::class, [
                'label' => 'novalnet.settings.min_amount.label',
                'required' => false,
                'constraints' => [new NumericRange(['min' => 1998])]
            ])
            ->add('instalmentInvoiceCycle', HiddenType::class, [
				'label' => 'novalnet.settings.instalment_cycle.label',
				'required' => false
            ])
            ->add('instalmentInvoiceBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false
            ])
            ->add('instalmentSepaLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
            ])
            ->add('instalmentSepaShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
            ])
            ->add('instalmentSepaTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
            ])
            ->add('instalmentSepaDuedate', IntegerType::class, [
                'label' => 'novalnet.settings.instalment_sepa_duedate.label',
                'required' => false,
                'constraints' => [new NumericRange(['min' => 2, 'max' => 14])]
            ])
            ->add('instalmentSepaPaymentAction', ChoiceType::class, [
                'choices' => $this->novalnetSettingsDataProvider->getPaymentActions(),
                'choice_label' => function ($action) {
                    return $this->translator->trans(
                        sprintf('novalnet.settings.%s', $action)
                    );
                },
                'label' => 'novalnet.settings.payment_action.label',
                'required' => false
            ])
            ->add('instalmentSepaOnholdAmount', IntegerType::class, [
                'label' => 'novalnet.settings.onhold_amount.label',
                'required' => false
            ])
            ->add('instalmentSepaMinAmount', IntegerType::class, [
                'label' => 'novalnet.settings.min_amount.label',
                'required' => false,
                'constraints' => [new NumericRange(['min' => 1998])]
            ])
            ->add('instalmentSepaCycle', HiddenType::class, [
				'label' => 'novalnet.settings.instalment_cycle.label',
				'required' => false
            ])
            ->add('instalmentSepaBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false
            ])
            ->add('instalmentSepaOneclick', CheckboxType::class, [
                'label' => 'novalnet.settings.oneclick.label',
                'required' => false,
            ])
            ->add('prepaymentLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
            ])
            ->add('prepaymentShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
            ])
            ->add('prepaymentTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
            ])
            ->add('prepaymentDuedate', IntegerType::class, [
                'label' => 'novalnet.settings.prepayment_duedate.label',
                'required' => false,
                'constraints' => [new NumericRange(['min' => 7])]
            ])
            ->add('prepaymentBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false
            ])
            ->add('cashpaymentLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
            ])
            ->add('cashpaymentShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
            ])
            ->add('cashpaymentTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
            ])
            ->add('cashpaymentDuedate', IntegerType::class, [
                'label' => 'novalnet.settings.cashpayment_duedate.label',
                'required' => false,
                'constraints' => [new GreaterThanZero()]
            ])
            ->add('cashpaymentBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false
            ])
            ->add('paypalLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
            ])
            ->add('paypalShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
            ])
            ->add('paypalTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
            ])
            ->add('paypalPaymentAction', ChoiceType::class, [
                'choices' => $this->novalnetSettingsDataProvider->getPaymentActions(),
                'choice_label' => function ($action) {
                    return $this->translator->trans(
                        sprintf('novalnet.settings.%s', $action)
                    );
                },
                'label' => 'novalnet.settings.payment_action.label',
                'required' => false
            ])
            ->add('paypalOnholdAmount', IntegerType::class, [
                'label' => 'novalnet.settings.onhold_amount.label',
                'required' => false
            ])
            ->add('paypalBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false
            ])
            ->add('paypalOneclick', CheckboxType::class, [
                'label' => 'novalnet.settings.oneclick.label',
                'required' => false,
            ])
            ->add('banktransferLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
            ])
            ->add('banktransferShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
            ])
            ->add('banktransferTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
            ])
            ->add('banktransferBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false
            ])
            ->add('idealLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
            ])
            ->add('idealShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
            ])
            ->add('idealTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
            ])
            ->add('idealBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false
            ])
            ->add('alipayLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
            ])
            ->add('alipayShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
            ])
            ->add('alipayTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
            ])
            ->add('alipayBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false
            ])
            ->add('wechatpayLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
            ])
            ->add('wechatpayShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
            ])
            ->add('wechatpayTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
            ])
            ->add('wechatpayBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false
            ])
            ->add('onlinebanktransferLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
            ])
            ->add('onlinebanktransferShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
            ])
            ->add('onlinebanktransferTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
            ])
            ->add('onlinebanktransferBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false
            ])
            ->add('trustlyLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
            ])
            ->add('trustlyShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
            ])
            ->add('trustlyTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
            ])
            ->add('trustlyBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false
            ])
            ->add('giropayLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
            ])
            ->add('giropayShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
            ])
            ->add('giropayTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
            ])
            ->add('giropayBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false
            ])
            ->add('epsLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
            ])
            ->add('epsShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
            ])
            ->add('epsTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
            ])
            ->add('epsBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false
            ])
            ->add('przelewyLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
            ])
            ->add('przelewyShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
            ])
            ->add('przelewyTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
            ])
            ->add('przelewyBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false
            ])
            ->add('postfinanceLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
            ])
            ->add('postfinanceShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
            ])
            ->add('postfinanceTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
            ])
            ->add('postfinanceBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false
            ])
            ->add('postfinanceCardLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
            ])
            ->add('postfinanceCardShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
            ])
            ->add('postfinanceCardTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
            ])
            ->add('postfinanceCardBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false
            ])
            ->add('multibancoLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
            ])
            ->add('multibancoShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
            ])
            ->add('multibancoTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
            ])
            ->add('multibancoBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false
            ])
            ->add('bancontactLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
            ])
            ->add('bancontactShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
            ])
            ->add('bancontactTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false
            ])
            ->add('bancontactBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false
            ])
            ->add('clientKey', HiddenType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('tariff', HiddenType::class, [
                    'label' => 'novalnet.settings.tariff.label',
                    'required' => true,
            ])
            ->add('paymentAccessKey', TextType::class, [
                    'label' => 'novalnet.settings.payment_access_key.label',
                    'required' => true,
            ])
            ->add('productActivationKey', TextType::class, [
                    'label' => 'novalnet.settings.product_activation_key.label',
                    'required' => true,
            ])
            ->add('displayPaymentLogo', CheckboxType::class, [
                    'label' => 'novalnet.settings.display_payment_logo.label',
                    'required' => false
            ])
            ->add('callbackEmailTo', TextType::class, [
                    'label' => 'novalnet.settings.callback_email_to.label',
                    'required' => false,
            ])
            ->add('callbackTestMode', CheckboxType::class, [
                    'label' => 'novalnet.settings.callback_test_mode.label',
                    'required' => false,
            ]);
        $builder->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'preSetData']);
    }

    /**
     * @param FormEvent $event
     */
    public function preSetData(FormEvent $event)
    {
        /** @var NovalnetSettings|null $data */
        $data = $event->getData();

        if ($data)
        {
            if(is_null($data->getDisplayPaymentLogo())) {
                $data->setDisplayPaymentLogo(true);
            }
            $paymentTitle = [
                'CreditCard' => 'Credit/Debit Cards',
                'Sepa' => 'Direct Debit SEPA',
                'Prepayment' => 'Prepayment',
                'Invoice' => 'Invoice',
                'Banktransfer' => 'Sofort',
                'Paypal' => 'PayPal',
                'Ideal' => 'iDEAL',
                'Alipay' => 'Alipay',
                'Wechatpay' => 'Wechat Pay',
                'Trustly' => 'Trustly',
                'Onlinebanktransfer' => 'Online bank transfer',
                'Eps' => 'eps',
                'Cashpayment' => 'Barzahlen/viacash',
                'Giropay' => 'giropay',
                'Przelewy' => 'Przelewy24',
                'PostfinanceCard' => 'PostfinanceCard',
                'Postfinance' => 'Postfinance',
                'Multibanco' => 'Multibanco',
                'Bancontact' => 'Bancontact',
                'InstalmentInvoice' => 'Instalment by Invoice',
                'InstalmentSepa' => 'Instalment by Sepa',
                'GuaranteedSepa' => 'SEPA direct debit with payment guarantee',
                'GuaranteedInvoice' => 'Invoice with payment guarantee',
            ];

            foreach ($paymentTitle as $code => $title) {
                $getLabel = 'get' . $code . 'Label';
                $getOneclick = 'get' . $code . 'Oneclick';
                if (in_array($code, ['Sepa', 'CreditCard', 'GuaranteedSepa', 'InstalmentSepa']) && is_null($data->$getOneclick())) {
                        $setOneclick = 'set' . $code . 'Oneclick';
                        $data->$setOneclick(true);
                }
                if (empty($data->$getLabel())) {
                    $addLabel = 'set' . $code . 'Label';
                    $data->$addLabel($title);
                    $addShortLabel = 'set' . $code . 'ShortLabel';
                    $data->$addShortLabel($title);
                }
                if($code == 'CreditCard') {
                    if(is_null($data->getCreditCardLogo())) {
                        $data->setCreditCardLogo($this->novalnetSettingsDataProvider->getCreditCardLogos());
                    }
                    if(is_null($data->getCreditCardInlineForm())) {
                        $data->setCreditCardInlineForm(true);
                    }
                }
                else if(in_array($code, ['InstalmentInvoice', 'InstalmentSepa', 'GuaranteedSepa', 'GuaranteedInvoice'])) {
                    $getMinAmount = 'get' . $code . 'MinAmount';
                    $setMinAmount = 'set' . $code . 'MinAmount';
                    $minAmount = 999;
                    if(in_array($code, ['InstalmentInvoice', 'InstalmentSepa'])) {
                        $minAmount = 1998;
                    }
                    
                    if(is_null($data->$getMinAmount())) {
                        $data->$setMinAmount($minAmount);
                    }
                }
            }
        }
    }

    /**
     * @param OptionsResolver $resolver
     *
     * @throws AccessException
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => NovalnetSettings::class,
            ]
        );
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return self::BLOCK_PREFIX;
    }
}
