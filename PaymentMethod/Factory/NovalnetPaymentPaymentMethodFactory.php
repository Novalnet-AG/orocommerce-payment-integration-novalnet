<?php

namespace Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\Factory;

use Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\NovalnetPayment;
use Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\Config\NovalnetPaymentConfigInterface;
use Symfony\Component\Routing\RouterInterface;
use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;

/**
 * Factory creates payment method instances based on configuration
 */
class NovalnetPaymentPaymentMethodFactory implements NovalnetPaymentPaymentMethodFactoryInterface
{
	/**
     * @var Router
     */
    protected $routerInterface;
    
    /**
     * @var DoctrineHelper
     */
    private $doctrineHelper;
    
    /**
     * @param RouterInterface $routerInterface
     * @param DoctrineHelper $doctrineHelper
     */
    public function __construct(
        RouterInterface $routerInterface,
        DoctrineHelper $doctrineHelper
    ) {
        $this->routerInterface = $routerInterface;
        $this->doctrineHelper = $doctrineHelper;
        
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetPaymentConfigInterface $config)
    {
        return new NovalnetPayment($config, $this->routerInterface, $this->doctrineHelper);
    }
}
