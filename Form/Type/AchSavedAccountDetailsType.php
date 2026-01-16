<?php

namespace Novalnet\Bundle\NovalnetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Ach Payment Form(saved account details)
 */
class AchSavedAccountDetailsType extends AbstractType
{
    const NAME = 'novalnet_ach_saved_account_data';

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
                $choices[$key][$this->translator->trans('novalnet.ach.accountnumber.form.label') . ' ' .$value['account_number']] = $value['token'];
            }

            $label = $this->translator->trans('novalnet.add_new_account_details');
            $choices[$label] = 'new_account_details';

            $builder->add('paymentData', ChoiceType::class, [
                'choices'  => $choices,
                'expanded' => true,
                'multiple' => false,
                'data' => $options['masked_data'][0]['token']
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'masked_data' => '',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return self::NAME;
    }
}
