<?php

class Centerax_Pdfcatalog_Model_Ecatalog_Ecatalog extends Mage_Core_Model_Abstract
{

    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('pdfcatalog/ecatalog_ecatalog');
    }

	public function saveNew($data)
	{
		try{
				unset($data['page']);unset($data['limit']);unset($data['chooser_name']);unset($data['chooser_sku']);unset($data['form_key']);
				unset($data['entity_id']);unset($data['in_products']);unset($data['_change_type_flag']);unset($data['_save_as_flag']);
		}catch(Exception $e){
			Mage::logException($e);
		}
		$pname = Mage::helper('pdfcatalog')->sanitizeFilename($data['pdfname']);
		$data['pdfname'] = $pname;

		$this->setExtra(serialize($data))
		->setFilename($pname)
		->setFontsize($data['font_size'])
		->setFonttype($data['font_type'])
		->setPagesize($data['page_size'])
		->save();
	}

    public function loadByAttribute($attribute, $value)
    {
        $collection = $this->getCollection()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter($attribute, $value)
            ->load()
                ->getItems();
        if (sizeof($collection)) {
            reset($collection);
            $order = current($collection);
            $this->setData($order->getData());
        }
        return $this;
    }

}