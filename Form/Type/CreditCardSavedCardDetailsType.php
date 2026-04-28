<?php

namespace Novalnet\Bundle\NovalnetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * CreditCard Payment Form (shows saved card details)
 */
class CreditCardSavedCardDetailsType extends AbstractType
{
    const NAME = 'novalnet_credit_card_saved_card_data';

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
                $cardNo = substr($value['card_number'], -4);
                $label = sprintf($this->translator->trans('novalnet.credit_card_saved_details_label'), $value['card_brand'], $cardNo, $value['card_expiry_month'], $value['card_expiry_year']);
                $choices[$key][$label] = $value['token'];
            }

            $label = $this->translator->trans('novalnet.add_new_card_details');

            $choices[$label] = 'new_account_details';

            $builder->add('paymentData', ChoiceType::class, [
                'choices'  => $choices,
                'expanded' => true,
                'multiple' => false,
                'data' => 'new_account_details'
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
