<?php
 
namespace Magelearn\CashDate\Model;
 
use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Authorization\Model\UserContextInterface;
 
class CashDateConfigProvider implements ConfigProviderInterface
{
    /**
     *  Config Paths
     */
    const XPATH_REQUIRED_CASH_DATE  = 'magelearn_cashdate/general/required_cash_date';
	
	/**
     * @var \Magento\Authorization\Model\UserContextInterface
     */
    private $userContext;
	
	 /**
     * @var \Magento\Framework\App\Action\Context
     */
    private $context;
	
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
 
    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
    	UserContextInterface $userContext,
    	\Magento\Checkout\Model\Session $session,
        ScopeConfigInterface $scopeConfig
    )
    {
    	$this->userContext = $userContext;
        $this->scopeConfig = $scopeConfig;
        $this->session = $session;
    }
 
    public function isCashDateRequired()
    {
        return $this->scopeConfig->getValue(
            self::XPATH_REQUIRED_CASH_DATE,
            ScopeInterface::SCOPE_STORE
        );
    }
	
    public function getConfig()
    {
        $show_cash_date = $this->isCashDateRequired();
        return [
            'show_cash_date' => $show_cash_date
        ];
    }
}