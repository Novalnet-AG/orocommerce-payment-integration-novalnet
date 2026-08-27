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
                'tooltip' => 'novalnet.settings.payment_label.tooltip'
            ])
            ->add('creditCardShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_short_label.tooltip'
            ])
            ->add('creditCardTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.test_mode.tooltip'
            ])
            ->add('creditCardEnforce3d', CheckboxType::class, [
                'label' => 'novalnet.settings.credit_card_enforce_3d.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.credit_card_enforce_3d.tooltip'
            ])
            ->add('creditCardPaymentAction', ChoiceType::class, [
                'choices' => $this->novalnetSettingsDataProvider->getPaymentActions(),
                'choice_label' => function ($action) {
                    return $this->translator->trans(
                        sprintf('novalnet.settings.%s', $action)
                    );
                },
                'label' => 'novalnet.settings.payment_action.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.payment_action.tooltip'
            ])
            ->add('creditCardOnholdAmount', IntegerType::class, [
                'label' => 'novalnet.settings.onhold_amount.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.onhold_amount.tooltip'
            ])
            ->add('creditCardOneclick', CheckboxType::class, [
                'label' => 'novalnet.settings.oneclick.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.oneclick.tooltip'
            ])
            ->add('creditCardInlineForm', CheckboxType::class, [
                'label' => 'novalnet.settings.credit_card_inline_form.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.credit_card_inline_form.tooltip'
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
                'required' => false,
                'tooltip' => 'novalnet.settings.credit_card_logo.tooltip'
            ])
            ->add('creditCardBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.buyer_notification.tooltip'
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
                'required' => false,
            ])
            ->add('sepaLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_label.tooltip'
            ])
            ->add('sepaShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_short_label.tooltip'
            ])
            ->add('sepaTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.test_mode.tooltip'
            ])
            ->add('sepaOneclick', CheckboxType::class, [
                'label' => 'novalnet.settings.oneclick.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.oneclick.tooltip'
            ])
            ->add('sepaDuedate', IntegerType::class, [
                'label' => 'novalnet.settings.sepa_duedate.label',
                'required' => false,
                'constraints' => [new NumericRange(['min' => 3, 'max' => 14])],
                'tooltip' => 'novalnet.settings.sepa_duedate.tooltip'
            ])
            ->add('sepaPaymentAction', ChoiceType::class, [
                'choices' => $this->novalnetSettingsDataProvider->getPaymentActions(),
                'choice_label' => function ($action) {
                    return $this->translator->trans(
                        sprintf('novalnet.settings.%s', $action)
                    );
                },
                'label' => 'novalnet.settings.payment_action.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.payment_action.tooltip'
            ])
            ->add('sepaOnholdAmount', IntegerType::class, [
                'label' => 'novalnet.settings.onhold_amount.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.onhold_amount.tooltip'
            ])
            ->add('sepaBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.buyer_notification.tooltip'
            ])
            ->add('guaranteedSepaLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_label.tooltip'
            ])
            ->add('guaranteedSepaShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_short_label.tooltip'
            ])
            ->add('guaranteedInvoiceLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_label.tooltip'
            ])
            ->add('guaranteedInvoiceShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_short_label.tooltip'
            ])
            ->add('guaranteedSepaTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.test_mode.tooltip'
            ])
            ->add('guaranteedSepaBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.buyer_notification.tooltip'
            ])
            ->add('guaranteedSepaMinAmount', IntegerType::class, [
                'label' => 'novalnet.settings.min_amount.label',
                'required' => false,
                'constraints' => [new NumericRange(['min' => 999])],
                'tooltip' => 'novalnet.settings.min_amount.tooltip'
            ])
            ->add('guaranteedSepaPaymentAction', ChoiceType::class, [
                'choices' => $this->novalnetSettingsDataProvider->getPaymentActions(),
                'choice_label' => function ($action) {
                    return $this->translator->trans(
                        sprintf('novalnet.settings.%s', $action)
                    );
                },
                'label' => 'novalnet.settings.payment_action.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.payment_action.tooltip'
            ])
            ->add('guaranteedSepaOnholdAmount', IntegerType::class, [
                'label' => 'novalnet.settings.onhold_amount.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.onhold_amount.tooltip'
            ])
            ->add('guaranteedSepaOneclick', CheckboxType::class, [
                'label' => 'novalnet.settings.oneclick.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.oneclick.tooltip'
            ])
            ->add('guaranteedInvoiceTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.test_mode.tooltip'
            ])
            ->add('guaranteedInvoiceBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.buyer_notification.tooltip'
            ])
            ->add('guaranteedInvoiceMinAmount', IntegerType::class, [
                'label' => 'novalnet.settings.min_amount.label',
                'required' => false,
                'constraints' => [new NumericRange(['min' => 999])],
                'tooltip' => 'novalnet.settings.min_amount.tooltip'
            ])
            ->add('guaranteedInvoicePaymentAction', ChoiceType::class, [
                'choices' => $this->novalnetSettingsDataProvider->getPaymentActions(),
                'choice_label' => function ($action) {
                    return $this->translator->trans(
                        sprintf('novalnet.settings.%s', $action)
                    );
                },
                'label' => 'novalnet.settings.payment_action.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.payment_action.tooltip'
            ])
            ->add('guaranteedInvoiceOnholdAmount', IntegerType::class, [
                'label' => 'novalnet.settings.onhold_amount.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.onhold_amount.tooltip'
            ])
            ->add('invoiceLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_label.tooltip'
            ])
            ->add('invoiceShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_short_label.tooltip'
            ])
            ->add('invoiceTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.test_mode.tooltip'
            ])
            ->add('invoiceDuedate', IntegerType::class, [
                'label' => 'novalnet.settings.invoice_duedate.label',
                'required' => false,
                'constraints' => [new NumericRange(['min' => 7])],
                'tooltip' => 'novalnet.settings.invoice_duedate.tooltip'
            ])
            ->add('invoicePaymentAction', ChoiceType::class, [
                'choices' => $this->novalnetSettingsDataProvider->getPaymentActions(),
                'choice_label' => function ($action) {
                    return $this->translator->trans(
                        sprintf('novalnet.settings.%s', $action)
                    );
                },
                'label' => 'novalnet.settings.payment_action.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.payment_action.tooltip'
            ])
            ->add('invoiceOnholdAmount', IntegerType::class, [
                'label' => 'novalnet.settings.onhold_amount.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.onhold_amount.tooltip'
            ])
            ->add('invoiceBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.buyer_notification.tooltip'
            ])
            ->add('instalmentInvoiceLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_label.tooltip'
            ])
            ->add('instalmentInvoiceShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_short_label.tooltip'
            ])
            ->add('instalmentInvoiceTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.test_mode.tooltip'
            ])
            ->add('instalmentInvoicePaymentAction', ChoiceType::class, [
                'choices' => $this->novalnetSettingsDataProvider->getPaymentActions(),
                'choice_label' => function ($action) {
                    return $this->translator->trans(
                        sprintf('novalnet.settings.%s', $action)
                    );
                },
                'label' => 'novalnet.settings.payment_action.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.payment_action.tooltip'
            ])
            ->add('instalmentInvoiceOnholdAmount', IntegerType::class, [
                'label' => 'novalnet.settings.onhold_amount.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.onhold_amount.tooltip'
            ])
            ->add('instalmentInvoiceMinAmount', IntegerType::class, [
                'label' => 'novalnet.settings.min_amount.label',
                'required' => false,
                'constraints' => [new NumericRange(['min' => 1998])],
                'tooltip' => 'novalnet.settings.instalment_min_amount.tooltip'
            ])
            ->add('instalmentInvoiceCycle', HiddenType::class, [
				'label' => 'novalnet.settings.instalment_cycle.label',
				'required' => false,
				'tooltip' => 'novalnet.settings.instalment_cycle.tooltip'
            ])
            ->add('instalmentInvoiceBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.buyer_notification.tooltip'
            ])
            ->add('instalmentSepaLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_label.tooltip'
            ])
            ->add('instalmentSepaShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_short_label.tooltip'
            ])
            ->add('instalmentSepaTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.test_mode.tooltip'
            ])
            ->add('instalmentSepaPaymentAction', ChoiceType::class, [
                'choices' => $this->novalnetSettingsDataProvider->getPaymentActions(),
                'choice_label' => function ($action) {
                    return $this->translator->trans(
                        sprintf('novalnet.settings.%s', $action)
                    );
                },
                'label' => 'novalnet.settings.payment_action.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.payment_action.tooltip'
            ])
            ->add('instalmentSepaOnholdAmount', IntegerType::class, [
                'label' => 'novalnet.settings.onhold_amount.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.onhold_amount.tooltip'
            ])
            ->add('instalmentSepaMinAmount', IntegerType::class, [
                'label' => 'novalnet.settings.min_amount.label',
                'required' => false,
                'constraints' => [new NumericRange(['min' => 1998])],
                'tooltip' => 'novalnet.settings.instalment_min_amount.tooltip'
            ])
            ->add('instalmentSepaCycle', HiddenType::class, [
				'label' => 'novalnet.settings.instalment_cycle.label',
				'required' => false,
				'tooltip' => 'novalnet.settings.instalment_cycle.tooltip'
            ])
            ->add('instalmentSepaBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.buyer_notification.tooltip'
            ])
            ->add('instalmentSepaOneclick', CheckboxType::class, [
                'label' => 'novalnet.settings.oneclick.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.oneclick.tooltip'
            ])
            ->add('prepaymentLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_label.tooltip'
            ])
            ->add('prepaymentShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_short_label.tooltip'
            ])
            ->add('prepaymentTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.test_mode.tooltip'
            ])
            ->add('prepaymentDuedate', IntegerType::class, [
                'label' => 'novalnet.settings.prepayment_duedate.label',
                'required' => false,
                'constraints' => [new NumericRange(['min' => 7, 'max' => 28])],
                'tooltip' => 'novalnet.settings.prepayment_duedate.tooltip'
            ])
            ->add('prepaymentBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.buyer_notification.tooltip'
            ])

            ->add('paypalLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_label.tooltip'
            ])
            ->add('paypalShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_short_label.tooltip'
            ])
            ->add('paypalTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.test_mode.tooltip'
            ])
            ->add('paypalPaymentAction', ChoiceType::class, [
                'choices' => $this->novalnetSettingsDataProvider->getPaymentActions(),
                'choice_label' => function ($action) {
                    return $this->translator->trans(
                        sprintf('novalnet.settings.%s', $action)
                    );
                },
                'label' => 'novalnet.settings.payment_action.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.payment_action.tooltip'
            ])
            ->add('paypalOnholdAmount', IntegerType::class, [
                'label' => 'novalnet.settings.onhold_amount.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.onhold_amount.tooltip'
            ])
            ->add('paypalBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.buyer_notification.tooltip'
            ])
            ->add('idealLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_label.tooltip'
            ])
            ->add('idealShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_short_label.tooltip'
            ])
            ->add('idealTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.test_mode.tooltip'
            ])
            ->add('idealBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.buyer_notification.tooltip'
            ])
            ->add('alipayLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_label.tooltip'
            ])
            ->add('alipayShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_short_label.tooltip'
            ])
            ->add('alipayTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.test_mode.tooltip'
            ])
            ->add('alipayBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.buyer_notification.tooltip'
            ])
            ->add('wechatpayLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_label.tooltip'
            ])
            ->add('wechatpayShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_short_label.tooltip'
            ])
            ->add('wechatpayTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.test_mode.tooltip'
            ])
            ->add('wechatpayBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.buyer_notification.tooltip'
            ])
            ->add('onlinebanktransferLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_label.tooltip'
            ])
            ->add('onlinebanktransferShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_short_label.tooltip'
            ])
            ->add('onlinebanktransferTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.test_mode.tooltip'
            ])
            ->add('onlinebanktransferBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.buyer_notification.tooltip'
            ])
            ->add('trustlyLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_label.tooltip'
            ])
            ->add('trustlyShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_short_label.tooltip'
            ])
            ->add('trustlyTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.test_mode.tooltip'
            ])
            ->add('trustlyBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.buyer_notification.tooltip'
            ])

            ->add('epsLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_label.tooltip'
            ])
            ->add('epsShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_short_label.tooltip'
            ])
            ->add('epsTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.test_mode.tooltip'
            ])
            ->add('epsBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.buyer_notification.tooltip'
            ])
            ->add('przelewyLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_label.tooltip'
            ])
            ->add('przelewyShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_short_label.tooltip'
            ])
            ->add('przelewyTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.test_mode.tooltip'
            ])
            ->add('przelewyBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.buyer_notification.tooltip'
            ])
            ->add('postfinanceLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_label.tooltip'
            ])
            ->add('postfinanceShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_short_label.tooltip'
            ])
            ->add('postfinanceTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.test_mode.tooltip'
            ])
            ->add('postfinanceBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.buyer_notification.tooltip'
            ])
            ->add('postfinanceCardLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_label.tooltip'
            ])
            ->add('postfinanceCardShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_short_label.tooltip'
            ])
            ->add('postfinanceCardTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.test_mode.tooltip'
            ])
            ->add('postfinanceCardBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.buyer_notification.tooltip'
            ])
            ->add('multibancoLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_label.tooltip'
            ])
            ->add('multibancoShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_short_label.tooltip'
            ])
            ->add('multibancoTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.test_mode.tooltip'
            ])
            ->add('multibancoBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.buyer_notification.tooltip'
            ])
            ->add('bancontactLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_label.tooltip'
            ])
            ->add('bancontactShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_short_label.tooltip'
            ])
            ->add('bancontactTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.test_mode.tooltip'
            ])
            ->add('bancontactBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.buyer_notification.tooltip'
            ])
            ->add('naverpayLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_label.tooltip'
            ])
            ->add('naverpayShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_short_label.tooltip'
            ])
            ->add('naverpayTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.test_mode.tooltip'
            ])
            ->add('naverpayBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.buyer_notification.tooltip'
            ])
            ->add('blikLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_label.tooltip'
            ])
            ->add('blikShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_short_label.tooltip'
            ])
            ->add('blikTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.test_mode.tooltip'
            ])
            ->add('blikBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.buyer_notification.tooltip'
            ])
            ->add('kakaopayLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_label.tooltip'
            ])
            ->add('kakaopayShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_short_label.tooltip'
            ])
            ->add('kakaopayTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.test_mode.tooltip'
            ])
            ->add('kakaopayBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.buyer_notification.tooltip'
            ])
            ->add('mbwayLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_label.tooltip'
            ])
            ->add('mbwayShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_short_label.tooltip'
            ])
            ->add('mbwayTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.test_mode.tooltip'
            ])
            ->add('mbwayBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.buyer_notification.tooltip'
            ])
            ->add('twintLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_label.tooltip'
            ])
            ->add('twintShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_short_label.tooltip'
            ])
            ->add('twintTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.test_mode.tooltip'
            ])
            ->add('twintBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.buyer_notification.tooltip'
            ])
            ->add('achLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_label.tooltip'
            ])
            ->add('achShortLabel', TextType::class, [
                'label' => 'novalnet.settings.payment_short_label.label',
                'required' => true,
                'tooltip' => 'novalnet.settings.payment_short_label.tooltip'
            ])
            ->add('achTestMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.test_mode.tooltip'
            ])
            ->add('achOneclick', CheckboxType::class, [
                'label' => 'novalnet.settings.oneclick.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.oneclick.tooltip'
            ])
            ->add('achBuyerNotification', TextType::class, [
                'label' => 'novalnet.settings.buyer_notification.label',
                'required' => false,
                'tooltip' => 'novalnet.settings.buyer_notification.tooltip'
            ])
            ->add('clientKey', HiddenType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('tariff', HiddenType::class, [
                    'label' => 'novalnet.settings.tariff.label',
                    'required' => true,
                    'tooltip' => 'novalnet.settings.tariff.tooltip'
            ])
            ->add('paymentAccessKey', TextType::class, [
                    'label' => 'novalnet.settings.payment_access_key.label',
                    'required' => true,
                    'tooltip' => 'novalnet.settings.payment_access_key.tooltip'
            ])
            ->add('productActivationKey', TextType::class, [
                    'label' => 'novalnet.settings.product_activation_key.label',
                    'required' => true,
                    'tooltip' => 'novalnet.settings.product_activation_key.tooltip'
            ])
            ->add('displayPaymentLogo', CheckboxType::class, [
                    'label' => 'novalnet.settings.display_payment_logo.label',
                    'required' => false,
                    'tooltip' => 'novalnet.settings.display_payment_logo.tooltip'
            ])
            ->add('callbackEmailTo', TextType::class, [
                    'label' => 'novalnet.settings.callback_email_to.label',
                    'required' => false,
                    'tooltip' => 'novalnet.settings.callback_email_to.tooltip'
            ])
            ->add('callbackTestMode', CheckboxType::class, [
                    'label' => 'novalnet.settings.callback_test_mode.label',
                    'required' => false,
                    'tooltip' => 'novalnet.settings.callback_test_mode.tooltip'
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
                'Paypal' => 'PayPal',
                'Ideal' => 'iDEAL | Wero',
                'Alipay' => 'Alipay',
                'Wechatpay' => 'WeChat Pay',
                'Trustly' => 'Trustly',
                'Onlinebanktransfer' => 'Online bank transfer',
                'Eps' => 'eps',
                'Przelewy' => 'Przelewy24',
                'PostfinanceCard' => 'PostFinance Card',
                'Postfinance' => 'PostFinance E-Finance',
                'Multibanco' => 'Multibanco',
                'Bancontact' => 'Bancontact',
                'NaverPay' => 'Naver Pay',
                'Blik' => 'Blik',
                'Kakaopay' => 'Kakaopay',
                'Mbway' => 'MB Way',
                'Twint' => 'TWINT',
                'Ach' => 'Direct Debit ACH',
                'InstalmentInvoice' => 'Instalment by Invoice',
                'InstalmentSepa' => 'Instalment by Direct Debit SEPA',
                'GuaranteedSepa' => 'Direct debit SEPA with payment guarantee',
                'GuaranteedInvoice' => 'Invoice with payment guarantee',
            ];

            foreach ($paymentTitle as $code => $title) {
                $getLabel = 'get' . $code . 'Label';
                $getOneclick = 'get' . $code . 'Oneclick';
                if (in_array($code, ['Sepa', 'CreditCard', 'GuaranteedSepa', 'InstalmentSepa', 'Ach']) && is_null($data->$getOneclick())) {
                        $setOneclick = 'set' . $code . 'Oneclick';
                        $data->$setOneclick(true);
                }
                if (empty($data->$getLabel())) {
                    $addLabel = 'set' . $code . 'Label';
                    $data->$addLabel($title);
                    $addShortLabel = 'set' . $code . 'ShortLabel';
                    $data->$addShortLabel($title);
                }
                if(in_array($code, ['CreditCard', 'Sepa', 'GuaranteedSepa', 'InstalmentSepa', 'Invoice', 'GuaranteedInvoice', 'InstalmentInvoice', 'Paypal'])) {
			$getAction = 'get' . $code . 'PaymentAction';
			$setAction = 'set' . $code . 'PaymentAction';
			if(is_null($data->$getAction())) {
			    $data->$setAction('capture');
			}
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
