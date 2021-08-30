<?php

namespace Magelearn\CashDate\Block\Info;

class Cashondelivery extends \Magento\Payment\Block\Info
{
	/**
     * Payment rendered specific information
     *
     * @var \Magento\Framework\DataObject
     */
    protected $_paymentSpecificInformation;
	/**
     * Instructions text
     *
     * @var string
     */
    protected $_instructions;
    /**
     * @var string
     */
    protected $_cashDate;


    protected $_template = 'Magelearn_CashDate::info/cashondelivery.phtml';
	
	/**
     * Get instructions text from order payment
     * (or from config, if instructions are missed in payment)
     *
     * @return string
     */
    public function getInstructions()
    {
        if ($this->_instructions === null) {
            $this->_instructions = $this->getInfo()->getAdditionalInformation(
                'instructions'
            ) ?: trim($this->getMethod()->getConfigData('instructions'));
        }
        return $this->_instructions;
    }
	
    /**
     * Enter description here...
     *
     * @return string
     */
    public function getCashDate()
    {
        if ($this->_cashDate === null) {
            $this->_convertAdditionalData();
           // $this->_cashDate=$this->getInfo()->getCashDate();
        }
        return $this->_cashDate;
    }

    protected function _convertAdditionalData(){

        $this->_cashDate = $this->getInfo()->getAdditionalInformation('cash_date');
        return $this;
    }
	/**
     * Retrieve info model
     *
     * @return \Magento\Payment\Model\InfoInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getInfo()
    {
        $info = $this->getData('info');
        if (!$info instanceof \Magento\Payment\Model\InfoInterface) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('We cannot retrieve the payment info model object.')
            );
        }
        return $info;
    }

    /**
     * Retrieve payment method model
     *
     * @return \Magento\Payment\Model\MethodInterface
     */
    public function getMethod()
    {
        return $this->getInfo()->getMethodInstance();
    }
    /**
     * @return string
     */
    public function toPdf()
    {
        $this->setTemplate('Magelearn_CashDate::info/pdf/cashondelivery.phtml');
        return $this->toHtml();
    }
	/**
     * Getter for children PDF, as array. Analogue of $this->getChildHtml()
     *
     * Children must have toPdf() callable
     * Known issue: not sorted
     * @return array
     */
    public function getChildPdfAsArray()
    {
        $result = [];
        foreach ($this->getLayout()->getChildBlocks($this->getNameInLayout()) as $child) {
            if (method_exists($child, 'toPdf') && is_callable([$child, 'toPdf'])) {
                $result[] = $child->toPdf();
            }
        }
        return $result;
    }

    /**
     * Get some specific information in format of array($label => $value)
     *
     * @return array
     */
    public function getSpecificInformation()
    {
        return $this->_prepareSpecificInformation()->getData();
    }

    /**
     * Render the value as an array
     *
     * @param mixed $value
     * @param bool $escapeHtml
     * @return array
     */
    public function getValueAsArray($value, $escapeHtml = false)
    {
        if (empty($value)) {
            return [];
        }
        if (!is_array($value)) {
            $value = [$value];
        }
        if ($escapeHtml) {
            foreach ($value as $_key => $_val) {
                $value[$_key] = $this->escapeHtml($_val);
            }
        }
        return $value;
    }

    /**
     * Prepare information specific to current payment method
     *
     * @param null|\Magento\Framework\DataObject|array $transport
     * @return \Magento\Framework\DataObject
     */
    protected function _prepareSpecificInformation($transport = null)
    {
        if (null === $this->_paymentSpecificInformation) {
            if (null === $transport) {
                $transport = new \Magento\Framework\DataObject();
            } elseif (is_array($transport)) {
                $transport = new \Magento\Framework\DataObject($transport);
            }
            $this->_paymentSpecificInformation = $transport;
        }
        return $this->_paymentSpecificInformation;
    }
}