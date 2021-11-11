<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Symfony\Component\Form\FormFactoryInterface;

/**
 * Novalnet payment method view factory
 */
abstract class NovalnetViewFactory
{
    /** @var FormFactoryInterface */
    protected $formFactory;

    public function __construct(
        FormFactoryInterface $formFactory
    ) {
        $this->formFactory = $formFactory;
    }
}
