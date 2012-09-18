<?php

class Centerax_Pdfcatalog_Block_Index_List extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_controller = 'index';
        $this->_blockGroup = 'pdfcatalog';
        $this->_headerText = Mage::helper('pdfcatalog')->__('E-Catalogs');
        $this->_addButtonLabel = Mage::helper('pdfcatalog')->__('Create New Catalog');
        parent::__construct();
    }

    public function getCreateUrl()
    {
        return $this->getUrl('*/index/create');
    }

    public function getHeaderCssClass()
    {
        return 'icon-head head-newsletter-list';
    }
}