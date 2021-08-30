<?php

namespace Magelearn\CashDate\Plugin;

class QuotePaymentPlugin{

    /**
     * Import data array to payment method object,
     * Method calls quote totals collect because payment method availability
     * can be related to quote totals
	 * 
     * @param \Magento\Quote\Model\Quote\Payment $subject
     * @param array $data
     * @return array
     */
    public function beforeImportData(\Magento\Quote\Model\Quote\Payment $subject, array $data){
        if (array_key_exists('additional_data', $data)) {
            $subject->setAdditionalInformation('cash_date',$data['additional_data']['cash_date']);
            $subject->setData('cash_date',$data['additional_data']['cash_date']);
			$subject->setAdditionalData(NULL);
        }
        return [$data];
    }

}