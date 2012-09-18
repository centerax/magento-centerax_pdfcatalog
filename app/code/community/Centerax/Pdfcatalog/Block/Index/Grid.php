<?php

class Centerax_Pdfcatalog_Block_Index_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('pdfcatalog_ecatalogs');
        $this->setUseAjax(true);
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {

        $collection = Mage::getResourceModel('pdfcatalog/ecatalog_ecatalog_collection')
            			  ->addAttributeToSelect('*');
        $this->setCollection($collection);

        return parent::_prepareCollection();

    }

    protected function _prepareColumns()
    {

        $this->addColumn('entity_id', array(
            'header'=> Mage::helper('pdfcatalog')->__('ID'),
            'width' => '80px',
            'type'  => 'text',
            'index' => 'entity_id',
        ));

        $this->addColumn('filename', array(
            'header' => Mage::helper('pdfcatalog')->__('Filename'),
            'index' => 'filename',
            'type' => 'text',
            'width' => '300px',
        ));

        $this->addColumn('pagesize', array(
            'header' => Mage::helper('pdfcatalog')->__('Page Size'),
            'index' => 'pagesize',
            'type' => 'text',
			'type'  => 'options',
            'options' => Mage::getModel('pdfcatalog/ecatalog_source_pagesizes')->getOptions(),
            'width' => '100px'
        ));

        $this->addColumn('fonttype', array(
            'header' => Mage::helper('pdfcatalog')->__('Font Type'),
            'index' => 'fonttype',
			'type'  => 'options',
            'options' => Mage::getModel('pdfcatalog/ecatalog_source_fonts')->getOptions(),
            'width' => '100px'
        ));

        $this->addColumn('fontsize', array(
            'header' => Mage::helper('pdfcatalog')->__('Font Size'),
            'index' => 'fontsize',
            'type' => 'number',
            'width' => '70px',
        ));

        $this->addColumn('created_at', array(
            'header' => Mage::helper('pdfcatalog')->__('Created On'),
            'index' => 'created_at',
            'type' => 'datetime',
            'width' => '100px',
        ));

        $this->addColumn('action',
            array(
                'header'    => Mage::helper('pdfcatalog')->__('Action'),
                'width'     => '100px',
                'type'      => 'action',
                'getter'     => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('pdfcatalog')->__('Use as template'),
                        'url'     => array('base'=>'*/*/create'),
                        'field'   => 'template_id'
                    ),
                    array(
                        'caption' => Mage::helper('pdfcatalog')->__('Download'),
                        'url'     => array('base'=>'*/*/download'),
                        'field'   => 'id'
                    ),
                    array(
                        'caption' => Mage::helper('pdfcatalog')->__('Delete'),
                        'url'     => array('base'=>'*/*/delete'),
                        'field'   => 'id',
                        'confirm'   => Mage::helper('pdfcatalog')->__('Are you sure you want to do this?')
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/download', array(
            'id'=>$row->getId())
        );
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/listGrid', array('_current'=>true));
    }

}