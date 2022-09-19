<?php

namespace Novalnet\Bundle\NovalnetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * {@inheritdoc}
 */
class InstalmentInvoiceCycleType extends AbstractType
{
    const BLOCK_PREFIX = 'novalnet_instalment_invoice_form_type';
    
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
        $builder
            ->add(
                'instalmentInvoiceCycle',
                ChoiceType::class,
                [
                    'label' => sprintf($this->translator->trans('novalnet.instalment_cycle.form.label'), $options['instalment_invoice_cycles']['netAmount']),
                    'choices' => array_flip($options['instalment_invoice_cycles']['dropdownData']),
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
            'instalment_invoice_cycles' => [],
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
