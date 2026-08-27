<?php

namespace Novalnet\Bundle\NovalnetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * {@inheritdoc}
 */
class GuaranteedSepaFormType extends AbstractType
{
    const BLOCK_PREFIX = 'novalnet_guaranteed_sepa_form_type';
    
    
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
        $builder->add('guaranteedSepaSavedAccountDetails', GuaranteedSepaSavedAccountDetailsType::class, [
            'label' => false,
            'masked_data' => $options['masked_data']
        ]);
        $builder
			->add(
                'guaranteedSepaaccountholder',
                TextType::class,
                [
                    'label' => 'novalnet.accountholder.form.label',
                    'required' => true,
                    'attr' => [
                        'autocomplete' => 'off',
                        'placeholder' => 'novalnet.accountholder.form.label'
                    ],
                    'constraints' => [
                        new NotBlank(),
                    ],
                ]
            )
            ->add(
                'guaranteedSepaiban',
                TextType::class,
                [
                    'label' => 'novalnet.sepa.iban.form.label',
                    'required' => true,
                    'attr' => [
                        'autocomplete' => 'off',
                        'style' => 'text-transform:uppercase;',
                    ],
                    'constraints' => [
                        new NotBlank(),
                    ],
                ]
            )
            ->add(
                'guaranteedSepabic',
                TextType::class,
                [
                    'label' => 'novalnet.sepa.bic.form.label',
                    'required' => false,
                    'attr' => [
                        'autocomplete' => 'off',
                        'style' => 'display:none;',
                    ],
                ]
            )
            ->add(
                'guaranteedSepaSaveAccountDetails',
                CheckboxType::class,
                [
                    'label' => $this->translator->trans('novalnet.save_account_details'),
                    'attr' => ['checked' => true]
                ]
            )
            ->add(
                'guaranteedSepaErrorMsg',
                HiddenType::class,
                [
                    'data' => $options['guaranteed_sepa_error_msg'],
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
            'guaranteed_sepa_error_msg' => '',
            'masked_data' => []
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
