<?php

namespace Novalnet\Bundle\NovalnetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

/**
 * {@inheritdoc}
 */
class PaypalFormType extends AbstractType
{
    const BLOCK_PREFIX = 'novalnet_paypal_form_type';

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
		$choices = [];
        if (!empty($options['masked_data'])) {
            foreach ($options['masked_data'] as $key => $value) {
                $choices[$key][$value['paypal_account']] = $value['token'];
            }

            $label = $this->translator->trans('novalnet.add_new_account_details');
            $choices[$label] = 'new_account_details';

            $builder->add('paymentData', ChoiceType::class, [
                'choices'  => $choices,
                'expanded' => true,
                'multiple' => false,
                'data' => 'new_account_details'
            ]);
        }
        $builder->add(
                'paypalSaveAccountDetails',
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
