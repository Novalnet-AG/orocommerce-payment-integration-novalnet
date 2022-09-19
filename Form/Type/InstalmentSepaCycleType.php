<?php

namespace Novalnet\Bundle\NovalnetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * {@inheritdoc}
 */
class InstalmentSepaCycleType extends AbstractType
{
    const BLOCK_PREFIX = 'novalnet_instalment_sepa_form_type';
    
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
        $builder->add('instalmentSepaSavedAccountDetails', InstalmentSepaSavedAccountDetailsType::class, [
            'label' => false,
            'masked_data' => $options['masked_data']
        ]);

        $builder
            ->add(
                'instalmentSepaiban',
                TextType::class,
                [
                    'label' => 'novalnet.sepa.iban.form.label',
                    'required' => true,
                    'attr' => [
                        'autocomplete' => 'off',
                    ],
                    'constraints' => [
                        new NotBlank(),
                    ],
                ]
            )
            ->add(
                'instalmentSepaCycle',
                ChoiceType::class,
                [
                    'label' => sprintf($this->translator->trans('novalnet.instalment_cycle.form.label'), $options['instalment_sepa_cycles']['netAmount']),
                    'choices' => array_flip($options['instalment_sepa_cycles']['dropdownData']),
                ]
            )
            ->add(
                'instlSepaSaveAccountDetails',
                CheckboxType::class,
                [
                    'label' => $this->translator->trans('novalnet.save_account_details'),
                    'attr' => ['checked' => true]
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
            'instalment_sepa_cycles' => [],
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
