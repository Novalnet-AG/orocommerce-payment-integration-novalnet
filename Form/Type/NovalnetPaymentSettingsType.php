<?php

namespace Oro\Bundle\NovalnetPaymentBundle\Form\Type;

use Oro\Bundle\LocaleBundle\Form\Type\LocalizedFallbackValueCollectionType;
use Oro\Bundle\NovalnetPaymentBundle\Entity\NovalnetPaymentSettings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
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

class NovalnetPaymentSettingsType extends AbstractType
{
    const BLOCK_PREFIX = 'oro_novalnet_payment_settings';
  
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
     * @param array                $options
     *
     * @throws ConstraintDefinitionException
     * @throws InvalidOptionsException
     * @throws MissingOptionsException
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'labels',
                LocalizedFallbackValueCollectionType::class,
                [
                    'label' => 'oro.novalnet_payment.settings.labels.label',
                    'required' => true,
                    'entry_options' => ['constraints' => [new NotBlank()]],
                ]
            )
            ->add(
                'shortLabels',
                LocalizedFallbackValueCollectionType::class,
                [
                    'label' => 'oro.novalnet_payment.settings.short_labels.label',
                    'required' => true,
                    'entry_options' => ['constraints' => [new NotBlank()]],
                ]
            )
            ->add(
                'vendorId',
                TextType::class,
                [
                    'label' => 'oro.novalnet_payment.settings.vendor_id.label',
                    'required' => true,
                ]
            )            
            ->add(
                'authcode',
                TextType::class,
                [
                    'label' => 'oro.novalnet_payment.settings.authcode.label',
                    'required' => true,
                ]
            )
            ->add(
                'product',
                TextType::class,
                [
                    'label' => 'oro.novalnet_payment.settings.product.label',
                    'required' => true,
                ]
            )
            ->add(
                'tariff',
                TextType::class,
                [
                    'label' => 'oro.novalnet_payment.settings.tariff.label',
                    'required' => true,
                ]
            )
            ->add(
                'paymentAccessKey',
                TextType::class,
                [
                    'label' => 'oro.novalnet_payment.settings.payment_access_key.label',
                    'required' => true,
                ]
            )
            ->add(
                'referrerId',
                TextType::class,
                [
                    'label' => 'oro.novalnet_payment.settings.referrer_id.label',
                    'required' => false,
                ]
            )            
            ->add(
                'testMode',
                CheckboxType::class,
                [
                    'label' => 'oro.novalnet_payment.settings.test_mode.label',
                    'required' => false,
                ]
            )
            ->add(
                'gatewayTimeout',
                IntegerType::class,
                [
                    'label' => 'oro.novalnet_payment.settings.gateway_timeout.label',
                    'required' => false,
                ]
            )
            ->add(
                'invoiceDuedate',
                IntegerType::class,
                [
                    'label' => 'oro.novalnet_payment.settings.invoice_duedate.label',
                    'required' => false,
                    'constraints' => [new NumericRange(['min' => 7, 'max' => 14])]
                ]
            )
            ->add(
                'sepaDuedate',
                IntegerType::class,
                [
                    'label' => 'oro.novalnet_payment.settings.sepa_duedate.label',
                    'required' => false,
                    'constraints' => [new NumericRange(['min' => 2, 'max' => 14])]
                ]
            )
            ->add(
                'cashpaymentDuedate',
                IntegerType::class,
                [
                    'label' => 'oro.novalnet_payment.settings.cashpayment_duedate.label',
                    'required' => false,
                ]
            )
            ->add(
                'cc3d',
                CheckboxType::class,
                [
                    'label' => 'oro.novalnet_payment.settings.cc_3d.label',
                    'required' => false,
                ]
            )
            ->add(
                'onholdAmount',
                IntegerType::class,
                [
                    'label' => 'oro.novalnet_payment.settings.onhold_amount.label',
                    'required' => false,
                ]
            )
            ->add(
                'callbackTestmode',
                CheckboxType::class,
                [
                    'label' => 'oro.novalnet_payment.settings.callback_testmode.label',
                    'required' => false,
                ]
            )
            ->add(
                'emailNotification',
                CheckboxType::class,
                [
                    'label' => 'oro.novalnet_payment.settings.email_notification.label',
                    'required' => false,
                ]
            )
            ->add(
                'emailTo',
                TextType::class,
                [
                    'label' => 'oro.novalnet_payment.settings.email_to.label',
                    'required' => false,
                ]
            )
            ->add(
                'emailBcc',
                TextType::class,
                [
                    'label' => 'oro.novalnet_payment.settings.email_bcc.label',
                    'required' => false,
                ]
            )
            ->add(
                'notifyUrl',
                TextType::class,
                [
                    'label' => 'oro.novalnet_payment.settings.notify_url.label',
                    'required' => false,
                    'data' => $this->getNotifyUrl(),
                ]);
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
                'data_class' => NovalnetPaymentSettings::class,
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
    
    /**
     * Get Notification Url
     * 
     * @return string
     */
    public function getNotifyUrl()
    {
		return $this->router->generate('oro_novalnet_payment_frontend_novalnet_callback', [], UrlGeneratorInterface::ABSOLUTE_URL);
	}
}
