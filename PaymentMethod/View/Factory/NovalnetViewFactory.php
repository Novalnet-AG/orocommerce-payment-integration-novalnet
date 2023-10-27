<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Symfony\Component\Form\FormFactoryInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetHelper;
use Symfony\Contracts\Translation\TranslatorInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Oro\Bundle\FrontendLocalizationBundle\Manager\UserLocalizationManagerInterface;

/**
 * Novalnet payment method view factory
 */
abstract class NovalnetViewFactory
{

    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var NovalnetHelper */
    protected $novalnetHelper;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var Registry
     */
    protected $doctrine;

    /**
     * @var UserLocalizationManager
     */
    protected $userLocalizationManager;

    /**
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        NovalnetHelper $novalnetHelper,
        TranslatorInterface $translator,
        Registry $doctrine,
        UserLocalizationManagerInterface $userLocalizationManager
    ) {
        $this->formFactory = $formFactory;
        $this->novalnetHelper = $novalnetHelper;
        $this->translator = $translator;
        $this->doctrine = $doctrine;
        $this->userLocalizationManager = $userLocalizationManager;
    }
}
