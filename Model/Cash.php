<?php

namespace Magelearn\CashDate\Model;

/**
* Cash on delivery payment method model
*
 * @method \Magento\Quote\Api\Data\PaymentMethodExtensionInterface getExtensionAttributes()
*
 * @api
* @since 100.0.2
*/

class Cash  extends \Magento\Payment\Model\Method\AbstractMethod
{
    const PAYMENT_METHOD_CASHONDELIVERY_CODE = 'cashondelivery';

    /**
     * Payment method code
     *
     * @var string
     */
    protected $_code = self::PAYMENT_METHOD_CASHONDELIVERY_CODE;

    /**
     * Cash On Delivery payment block paths
     *
     * @var string
     */
    protected $_formBlockType = \Magento\OfflinePayments\Block\Form\Cash::class;

    /**
     * Info  block path
     *
     * @var string
     */
    protected $_infoBlockType = \Magelearn\CashDate\Block\Info\Cashondelivery::class;

    /**
     * Availability option
     *
     * @var bool
     */
    protected $_isOffline = true;

    /**
     * Get instructions text from config
     *
     * @return string
     */

    public function getInstructions(){
        return trim($this->getConfigData('instructions'));
    }

}