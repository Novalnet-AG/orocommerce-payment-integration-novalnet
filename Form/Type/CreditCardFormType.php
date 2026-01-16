<?php

namespace Novalnet\Bundle\NovalnetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * CreditCard Payment Form
 */
class CreditCardFormType extends AbstractType
{
    const BLOCK_PREFIX = 'novalnet_credit_card_form_type';

	/**
     * @var TranslatorInterface
     */
    protected $translator;

	/**
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        if (!empty($options['masked_data'])) {
            $builder->add('creditCardSavedCardDetails', CreditCardSavedCardDetailsType::class, [
                'label' => false,
                'masked_data' => $options['masked_data']
            ]);
        }
        $builder
            ->add(
                'panhash',
                HiddenType::class,
                [
                    'label' => 'false',
                ]
            )
            ->add(
                'uniqueId',
                HiddenType::class,
                [
                    'label' => 'false',
                ]
            )
            ->add(
                'clientKey',
                HiddenType::class,
                [
                    'label' => 'false',
                    'data' => $options['client_key'],
                ]
            )
            ->add(
                'doRedirect',
                HiddenType::class,
                [
                    'label' => 'false',
                ]
            )
            ->add(
                'customerDetails',
                HiddenType::class,
                [
                    'label' => 'false',
                    'data' => $options['customer_details'],
                ]
            )
            ->add(
                'labelStyle',
                HiddenType::class,
                [
                    'label' => 'false',
                    'data' => $options['label_style'],
                ]
            )
            ->add(
                'inputStyle',
                HiddenType::class,
                [
                    'label' => 'false',
                    'data' => $options['input_style'],
                ]
            )
            ->add(
                'inlineForm',
                HiddenType::class,
                [
                    'label' => 'false',
                    'data' => $options['inline_form'],
                ]
            )
            ->add(
                'enforce3d',
                HiddenType::class,
                [
                    'label' => 'false',
                    'data' => $options['enforce_3d'],
                ]
            )
            ->add(
                'saveCardDetails',
                CheckboxType::class,
                [
                    'label' => $this->translator->trans('novalnet.credit_card.save_card_details'),
                    'attr' => ['checked' => true]
                ]
            )
            ->add(
                'containerStyle',
                HiddenType::class,
                [
                    'label' => 'false',
                    'data' => $options['container_style'],
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'client_key' => '',
            'customer_details' => '',
            'label_style' => '',
            'input_style' => '',
            'container_style' => '',
            'inline_form' => '',
            'enforce_3d' => '',
            'masked_data' => [],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return self::BLOCK_PREFIX;
    }
}
