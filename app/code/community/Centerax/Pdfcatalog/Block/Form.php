<?php

class Centerax_Pdfcatalog_Block_Form extends Mage_Adminhtml_Block_Widget_Form
{

     /**
     * Constructor
     *
     * Initialize form
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Prepare form for render
     */
    public function renderPrepare($template = false)
    {

        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset(
										'base_fieldset', array(
															'legend'=>Mage::helper('pdfcatalog')->__('Catalog information'),
															'class' => 'fieldset-wide'
															  )
									   );

        $fieldset->addField('pdfname', 'text', array(
            'name'=>'pdfname',
            'label' => Mage::helper('pdfcatalog')->__('File Name'),
            'title' => Mage::helper('pdfcatalog')->__('File Name'),
            'class' => 'required-entry',
            'required' => true
        ));

        $fieldset->addField('page_size', 'select', array(
            'name'=>'page_size',
            'label' => Mage::helper('pdfcatalog')->__('Page Size'),
            'title' => Mage::helper('pdfcatalog')->__('Page Size'),
            'class' => 'required-entry',
            'values'=>$this->_getPageSizeOptions(),
            'required' => true
        ));

        $fieldset->addField('font_type', 'select', array(
            'name'=>'font_type',
            'label' => Mage::helper('pdfcatalog')->__('Font Type'),
            'title' => Mage::helper('pdfcatalog')->__('Font Type'),
            'class' => 'required-entry',
            'values'=>$this->_getFontOptions(),
            'required' => true
        ));
        $fieldset->addField('font_size', 'text', array(
            'name'=>'font_size',
            'label' => Mage::helper('pdfcatalog')->__('Font Size'),
            'title' => Mage::helper('pdfcatalog')->__('Font Size'),
            'class' => 'required-entry',
            'required' => true
        ));

		$productAttributes = $this->_getProductAttributesOptions();
        $fieldset->addField('attribs', 'multiselect', array(
            'name'=>'attribs[]',
            'label' => Mage::helper('pdfcatalog')->__('Attributes to Add'),
            'title' => Mage::helper('pdfcatalog')->__('Attributes to Add'),
            'class' => 'required-entry',
            'values'=>$productAttributes,
            'required' => true
        ));

        $fieldset->addField('image_width', 'text', array(
            'name'=>'image_width',
            'label' => Mage::helper('pdfcatalog')->__('Image Width'),
            'title' => Mage::helper('pdfcatalog')->__('Image Width'),
            //'disabled'=>'disabled'
        ));
        $fieldset->addField('image_height', 'text', array(
            'name'=>'image_height',
            'label' => Mage::helper('pdfcatalog')->__('Image Height'),
            'title' => Mage::helper('pdfcatalog')->__('Image Height'),
            //'disabled'=>'disabled'
        ));

        $fieldset->addField('trigger', 'button', array(
            'name'=>'trigger',
            'label' => Mage::helper('pdfcatalog')->__('Choose Products'),
            'value' => Mage::helper('pdfcatalog')->__('Choose Products'),
            'class'=>'rule-chooser-trigger',
            'onclick'=>'getProductChooser(\''.Mage::getUrl('adminhtml/promo_widget/chooser/attribute/sku/form/rule_conditions_fieldset').'?isAjax=true\'); return false;'
        ));

        $fieldset->addField('skus', 'text', array(
            'name'=>'skus',
            'label' => Mage::helper('pdfcatalog')->__('Products Skus'),
            'title' => Mage::helper('pdfcatalog')->__('Products Skus'),
            'class'=>'required-entry',
            'required'=>true
        ));

		$tid = $this->getRequest()->getParam('template_id');
		if(!is_null($tid)){
			$templateData = Mage::getModel('pdfcatalog/ecatalog_ecatalog')->load($tid);
			$extra = $templateData->getExtra();
			if($extra){
				$extra = unserialize($extra);
				$extra['trigger'] = $this->__('Choose Products');
				$extra['pdfname'] = uniqid(mt_rand());

				$form->setValues($extra);
			}
		}else{
			$form->setValues($this->getDefVals());
		}

        $this->setForm($form);

        return $this;
    }

	public function getDefVals()
	{
		$def = array();

		$def['image_width'] = 600;
		$def['image_height'] = 234;
		$def['font_type'] = 'Helvetica';
		$def['font_size'] = 15;
		$def['attribs'] = array('name', 'short_description', 'price', 'image');
		$def['trigger'] = $this->__('Choose Products');

		return $def;
	}

	protected function _getProductAttributesOptions()
	{
		$productCondition = Mage::getModel('catalogrule/rule_condition_product');
        $productAttributes = $productCondition->loadAttributeOptions()->getAttributeOption();

		$formatted = array();
		foreach($productAttributes as $k=>$v){
			$formatted[] = array('value'=>$k, 'label'=>$v);
		}
		$formatted[] = array('value'=>'image', 'label'=>'Main Image');

        return $formatted;

	}

	protected function _getPageSizeOptions()
	{
		$opts = array();
		$opts[] = array('value'=>'595:842:', 'label'=>'A4');
		$opts[] = array('value'=>'842:595:', 'label'=>'A4 Landscape');
		$opts[] = array('value'=>'612:792:', 'label'=>'Letter');
		$opts[] = array('value'=>'792:612:', 'label'=>'Letter Landscape');

		return $opts;
	}

	protected function _getFontOptions()
	{

		return Mage::getModel('pdfcatalog/ecatalog_source_fonts')->getOptionArray();
	}

}
