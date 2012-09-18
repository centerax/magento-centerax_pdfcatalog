<?php

class Centerax_Pdfcatalog_Helper_Data extends Mage_Core_Helper_Abstract
{

	public function sanitizeFilename($filename)
	{
        if(method_exists(new Zend_Filter, 'filterStatic')){
            return Zend_Filter::filterStatic($filename, 'Alnum');
        }else{// Compat with ZF < 1.9 (Magento 1.3.2.4 or lower)
            return Zend_Filter::get($filename, 'Alnum');
        }
	}

}