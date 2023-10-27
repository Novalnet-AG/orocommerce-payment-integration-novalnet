<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetHelper;
use Symfony\Contracts\Translation\TranslatorInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Oro\Bundle\FrontendLocalizationBundle\Manager\UserLocalizationManagerInterface;

/**
 * Abstract payment method view
 */
abstract class NovalnetView implements PaymentMethodViewInterface
{
    /**
     * @var NovalnetConfigInterface
     */
    protected $config;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var NovalnetHelper
     */
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
     * @param NovalnetHelper $novalnetHelper
     * @param TranslatorInterface $translator
     * @param Registry $doctrine
     * @param UserLocalizationManagerInterface $userLocalizationManager
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        NovalnetHelper $novalnetHelper,
        TranslatorInterface $translator,
        Registry $doctrine,
        UserLocalizationManagerInterface $userLocalizationManager,
        NovalnetConfigInterface $config
    ) {
        $this->formFactory = $formFactory;
        $this->novalnetHelper = $novalnetHelper;
        $this->translator = $translator;
        $this->doctrine = $doctrine;
        $this->userLocalizationManager = $userLocalizationManager;
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return $this->config->getLabel();
    }

    /**
     * {@inheritdoc}
     */
    public function getShortLabel()
    {
        return $this->config->getShortLabel();
    }

    /**
     * {@inheritdoc}
     */
    public function getAdminLabel()
    {
        return $this->config->getAdminLabel();
    }

    /**
     * {@inheritdoc}
     */
    public function getPaymentMethodIdentifier()
    {
        return $this->config->getPaymentMethodIdentifier();
    }

    public function getInstalmentDetails($orderAmount)
    {
        $cycles = $this->config->getInstalmentCycle();
        $cycles = json_decode($cycles[0]);
        $instalmentDetails = ['netAmount' => sprintf('%.2f', ($orderAmount/100)) . ' €'];
        asort($cycles);
        foreach ($cycles as $key => $values) {
            $instalmentAmount = $orderAmount / $values;
            if (($instalmentAmount) >= 999) {
				
                $instalmentDetails['dropdownData'][$values] = sprintf($this->translator->trans('novalnet.checkout.instalment_detail'), $values, sprintf('%.2f', ($instalmentAmount/100)) . ' €');
                $lastCycleAmount = sprintf('%.2f', ($orderAmount/100)) - sprintf('%.2f', ($instalmentAmount/100)) * ($values - 1);
                $instalmentDetails['tableData'][] = ['cycles' => $values,
                                                     'amount' => sprintf('%.2f', ($instalmentAmount/100)),
                                                     'currency' => '€',
                                                     'lastCycleAmount' => sprintf('%.2f', ($lastCycleAmount)),
                                                    ];
            }
        }
        return $instalmentDetails;
    }
}
