<?php

namespace Oro\Bundle\NovalnetPaymentBundle\PaymentMethod;

use Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\Config\NovalnetPaymentConfigInterface;
use Oro\Bundle\PaymentBundle\Context\PaymentContextInterface;
use Oro\Bundle\PaymentBundle\Entity\PaymentTransaction;
use Oro\Bundle\PaymentBundle\Method\Action\PurchaseActionInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Symfony\Component\Routing\RouterInterface;
use Oro\Bundle\OrderBundle\Entity\Order;
use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;

/**
 * Implements Novalnet Payment payment method
 */
class NovalnetPayment implements PaymentMethodInterface
{
    /**
     * @var NovalnetPaymentConfigInterface
     */
    protected $config;

    /**
     * @var Router
     */
    protected $router;
    
    /**
     * @var Order
     */
    protected $order;
    
    /**
     * @var DoctrineHelper
     */
    private $novalnetHelper;
    
    /**
     * @var DoctrineHelper
     */
    private $doctrineHelper;

    /**
     * @param NovalnetPaymentConfigInterface $config
     * @param RouterInterface $router
     * @param DoctrineHelper $doctrineHelper
     */
    public function __construct(NovalnetPaymentConfigInterface $config, RouterInterface $routerInterface, DoctrineHelper $doctrineHelper)
    {		
        $this->config = $config;
        $this->router = $routerInterface;
        $this->doctrineHelper = $doctrineHelper;
        $this->novalnetHelper = new NovalnetHelper();       
        
    }

    /**
     * {@inheritdoc}
     */
    public function execute($action, PaymentTransaction $paymentTransaction)
    {
		
        if (!method_exists($this, $action)) {
            throw new \InvalidArgumentException(
                sprintf('"%s" payment method "%s" action is not supported', $this->getIdentifier(), $action)
            );
        }
        return $this->$action($paymentTransaction);
    }


    /**
     * {@inheritdoc}
     */
    public function getIdentifier()
    {
        return $this->config->getPaymentMethodIdentifier();
    }

    /**
     * {@inheritdoc}
     */
    public function isApplicable(PaymentContextInterface $context)
    {
		
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($actionName)
    {
		return $actionName === self::PURCHASE;
    }
    
    public function purchase($paymentTransaction) {
		
		$paymentTransaction
                ->setSuccessful(false)
                ->setActive(true);     
       
        $order = $this->doctrineHelper->getEntity(
            $paymentTransaction->getEntityClass(),
            $paymentTransaction->getEntityIdentifier()
        );
        
        $params = $this->novalnetHelper->getBasicParams($order, $this->config, $this->router, $paymentTransaction);
        $response = $this->novalnetHelper->performCurlRequest($this->config, $params);
        parse_str($response, $result);
        $novalnetRedirectUrl = [];
       
        if($result['status'] == '100' && !empty($result['url'])) {	
			$novalnetRedirectUrl['purchaseRedirectUrl'] = $result['url'];	
		}
        
        return $novalnetRedirectUrl;
	
	}
    

}
