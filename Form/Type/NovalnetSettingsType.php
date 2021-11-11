<?php

namespace Novalnet\Bundle\NovalnetBundle\Form\Type;

use Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue;
use Oro\Bundle\LocaleBundle\Form\Type\LocalizedFallbackValueCollectionType;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Oro\Bundle\ValidationBundle\Validator\Constraints\NumericRange;
use Oro\Bundle\ValidationBundle\Validator\Constraints\GreaterThanZero;

/**
 * Form type for Novalnet integration settings
 */
class NovalnetSettingsType extends AbstractType
{
    const BLOCK_PREFIX = 'novalnet_settings';

    /**
     * @var TranslatorInterface
     */
    protected $routerInterface;

    /**
     * @param RouterInterface $routerInterface
     */
    public function __construct(
        RouterInterface $routerInterface
    ) {
        $this->router = $routerInterface;
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
            ->add('creditCardLabels', LocalizedFallbackValueCollectionType::class, [
                'label' => 'novalnet.settings.credit_card_label.label',
                'required' => true,
                'entry_options' => ['constraints' => [new NotBlank()]],
            ])
            ->add('creditCardShortLabels', LocalizedFallbackValueCollectionType::class, [
                'label' => 'novalnet.settings.credit_card_short_label.label',
                'required' => true,
                'entry_options' => ['constraints' => [new NotBlank()]],
            ])
            ->add('sepaLabels', LocalizedFallbackValueCollectionType::class, [
                'label' => 'novalnet.settings.sepa_label.label',
                'required' => true,
                'entry_options' => ['constraints' => [new NotBlank()]],
            ])
            ->add('sepaShortLabels', LocalizedFallbackValueCollectionType::class, [
                'label' => 'novalnet.settings.sepa_short_label.label',
                'required' => true,
                'entry_options' => ['constraints' => [new NotBlank()]],
            ])
            ->add('sepaPaymentGuarantee', CheckboxType::class, [
                'label' => 'novalnet.settings.sepa_payment_guarantee.label',
                'required' => false
            ])
            ->add('sepaGuaranteeMinAmount', IntegerType::class, [
                'label' => 'novalnet.settings.sepa_guarantee_min_amount.label',
                'required' => false,
                'constraints' => [new NumericRange(['min' => 999])]
            ])
            ->add('sepaForceNonGuarantee', CheckboxType::class, [
                'label' => 'novalnet.settings.sepa_force_non_guarantee.label',
                'required' => false
            ])
            ->add('invoiceLabels', LocalizedFallbackValueCollectionType::class, [
                'label' => 'novalnet.settings.invoice_label.label',
                'required' => true,
                'entry_options' => ['constraints' => [new NotBlank()]],
            ])
            ->add('invoiceShortLabels', LocalizedFallbackValueCollectionType::class, [
                'label' => 'novalnet.settings.invoice_short_label.label',
                'required' => true,
                'entry_options' => ['constraints' => [new NotBlank()]],
            ])
            ->add('invoiceLabels', LocalizedFallbackValueCollectionType::class, [
                'label' => 'novalnet.settings.invoice_label.label',
                'required' => true,
                'entry_options' => ['constraints' => [new NotBlank()]],
            ])
            ->add('invoiceShortLabels', LocalizedFallbackValueCollectionType::class, [
                'label' => 'novalnet.settings.invoice_short_label.label',
                'required' => true,
                'entry_options' => ['constraints' => [new NotBlank()]],
            ])
            ->add('invoicePaymentGuarantee', CheckboxType::class, [
                'label' => 'novalnet.settings.invoice_payment_guarantee.label',
                'required' => false
            ])
            ->add('invoiceGuaranteeMinAmount', IntegerType::class, [
                'label' => 'novalnet.settings.invoice_guarantee_min_amount.label',
                'required' => false,
                'constraints' => [new NumericRange(['min' => 999])]
            ])
            ->add('invoiceForceNonGuarantee', CheckboxType::class, [
                'label' => 'novalnet.settings.invoice_force_non_guarantee.label',
                'required' => false
            ])
            ->add('prepaymentLabels', LocalizedFallbackValueCollectionType::class, [
                'label' => 'novalnet.settings.prepayment_label.label',
                'required' => true,
                'entry_options' => ['constraints' => [new NotBlank()]],
            ])
            ->add('prepaymentShortLabels', LocalizedFallbackValueCollectionType::class, [
                'label' => 'novalnet.settings.prepayment_short_label.label',
                'required' => true,
                'entry_options' => ['constraints' => [new NotBlank()]],
            ])
            ->add('cashpaymentLabels', LocalizedFallbackValueCollectionType::class, [
                'label' => 'novalnet.settings.cashpayment_label.label',
                'required' => true,
                'entry_options' => ['constraints' => [new NotBlank()]],
            ])
            ->add('cashpaymentShortLabels', LocalizedFallbackValueCollectionType::class, [
                'label' => 'novalnet.settings.cashpayment_short_label.label',
                'required' => true,
                'entry_options' => ['constraints' => [new NotBlank()]],
            ])
            ->add('paypalLabels', LocalizedFallbackValueCollectionType::class, [
                'label' => 'novalnet.settings.paypal_label.label',
                'required' => true,
                'entry_options' => ['constraints' => [new NotBlank()]],
            ])
            ->add('paypalShortLabels', LocalizedFallbackValueCollectionType::class, [
                'label' => 'novalnet.settings.paypal_short_label.label',
                'required' => true,
                'entry_options' => ['constraints' => [new NotBlank()]],
            ])
            ->add('banktransferLabels', LocalizedFallbackValueCollectionType::class, [
                'label' => 'novalnet.settings.banktransfer_label.label',
                'required' => true,
                'entry_options' => ['constraints' => [new NotBlank()]],
            ])
            ->add('banktransferShortLabels', LocalizedFallbackValueCollectionType::class, [
                'label' => 'novalnet.settings.banktransfer_short_label.label',
                'required' => true,
                'entry_options' => ['constraints' => [new NotBlank()]],
            ])
            ->add('idealLabels', LocalizedFallbackValueCollectionType::class, [
                'label' => 'novalnet.settings.ideal_label.label',
                'required' => true,
                'entry_options' => ['constraints' => [new NotBlank()]],
            ])
            ->add('idealShortLabels', LocalizedFallbackValueCollectionType::class, [
                'label' => 'novalnet.settings.ideal_short_label.label',
                'required' => true,
                'entry_options' => ['constraints' => [new NotBlank()]],
            ])
            ->add('giropayLabels', LocalizedFallbackValueCollectionType::class, [
                'label' => 'novalnet.settings.giropay_label.label',
                'required' => true,
                'entry_options' => ['constraints' => [new NotBlank()]],
            ])
            ->add('giropayShortLabels', LocalizedFallbackValueCollectionType::class, [
                'label' => 'novalnet.settings.giropay_short_label.label',
                'required' => true,
                'entry_options' => ['constraints' => [new NotBlank()]],
            ])
            ->add('epsLabels', LocalizedFallbackValueCollectionType::class, [
                'label' => 'novalnet.settings.eps_label.label',
                'required' => true,
                'entry_options' => ['constraints' => [new NotBlank()]],
            ])
            ->add('epsShortLabels', LocalizedFallbackValueCollectionType::class, [
                'label' => 'novalnet.settings.eps_short_label.label',
                'required' => true,
                'entry_options' => ['constraints' => [new NotBlank()]],
            ])
            ->add('przelewyLabels', LocalizedFallbackValueCollectionType::class, [
                'label' => 'novalnet.settings.przelewy_label.label',
                'required' => true,
                'entry_options' => ['constraints' => [new NotBlank()]],
            ])
            ->add('przelewyShortLabels', LocalizedFallbackValueCollectionType::class, [
                'label' => 'novalnet.settings.przelewy_short_label.label',
                'required' => true,
                'entry_options' => ['constraints' => [new NotBlank()]],
            ])
            ->add('vendorId', TextType::class, [
                'label' => 'novalnet.settings.vendor_id.label',
                'required' => true
            ])
            ->add('authcode', TextType::class, [
                'label' => 'novalnet.settings.authcode.label',
                'required' => true,
            ])
            ->add('product', TextType::class, [
                'label' => 'novalnet.settings.product.label',
                'required' => true
            ])
            ->add(
                'tariff',
                TextType::class,
                [
                    'label' => 'novalnet.settings.tariff.label',
                    'required' => true
                ]
            )
            ->add(
                'paymentAccessKey',
                TextType::class,
                [
                    'label' => 'novalnet.settings.payment_access_key.label',
                    'required' => true,
                ]
            )
            ->add('referrerId', TextType::class, [
                'label' => 'novalnet.settings.referrer_id.label',
                'required' => false
            ])
            ->add('testMode', CheckboxType::class, [
                'label' => 'novalnet.settings.test_mode.label',
                'required' => false,
            ])
            ->add('gatewayTimeout', TextType::class, [
                'label' => 'novalnet.settings.gateway_timeout.label',
                'required' => false
            ])
            ->add('invoiceDuedate', IntegerType::class, [
                'label' => 'novalnet.settings.invoice_duedate.label',
                'required' => false,
                'constraints' => [new NumericRange(['min' => 7])]
            ])
            ->add('sepaDuedate', IntegerType::class, [
                'label' => 'novalnet.settings.sepa_duedate.label',
                'required' => false,
                'constraints' => [new NumericRange(['min' => 2, 'max' => 14])]
            ])
            ->add('cashpaymentDuedate', IntegerType::class, [
                'label' => 'novalnet.settings.cashpayment_duedate.label',
                'required' => false,
                'constraints' => [new GreaterThanZero()]
            ])
            ->add('cc3d', CheckboxType::class, [
                'label' => 'novalnet.settings.cc_3d.label',
                'required' => false,
            ])
            ->add('onholdAmount', TextType::class, [
                'label' => 'novalnet.settings.onhold_amount.label',
                'required' => false
            ])
            ->add('callbackTestmode', CheckboxType::class, [
                'label' => 'novalnet.settings.callback_testmode.label',
                'required' => false,
            ])
            ->add('emailNotification', CheckboxType::class, [
                'label' => 'novalnet.settings.email_notification.label',
                'required' => false,
            ])
            ->add('emailTo', TextType::class, [
                'label' => 'novalnet.settings.email_to.label',
                'required' => false,
            ])
            ->add('emailBcc', TextType::class, [
                'label' => 'novalnet.settings.email_bcc.label',
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

        if ($data && !$data->getGatewayTimeout()) {
            $data->setGatewayTimeout(240);
        }

        if ($data && is_null($data->getInvoiceForceNonGuarantee())) {
            $data->setInvoiceForceNonGuarantee(true);
        }

        if ($data && is_null($data->getSepaForceNonGuarantee())) {
            $data->setSepaForceNonGuarantee(true);
        }

        $paymentTitle = [
            'CreditCard' => 'Credit Card',
            'Sepa' => 'Direct Debit SEPA',
            'Prepayment' => 'Prepayment',
            'Invoice' => 'Invoice',
            'Banktransfer' => 'Instant Bank Transfer',
            'Paypal' => 'PayPal',
            'Ideal' => 'iDEAL',
            'Eps' => 'eps',
            'Cashpayment' => 'Barzahlen',
            'Giropay' => 'giropay',
            'Przelewy' => 'Przelewy24',
        ];

        foreach ($paymentTitle as $code => $title) {
            $getLabels = 'get' . $code . 'Labels';
            if ($data && $data->$getLabels()->isEmpty()) {
                $title = (new LocalizedFallbackValue())->setString($title);
                $addLabel = 'add' . $code . 'Label';
                $data->$addLabel($title);
                $addShortLabel = 'add' . $code . 'ShortLabel';
                $data->$addShortLabel($title);
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
