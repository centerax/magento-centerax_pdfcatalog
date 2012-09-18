<?php

class Centerax_Pdfcatalog_Model_Entity_Ecatalog_Ecatalog extends Mage_Eav_Model_Entity_Abstract
{

    public function __construct()
    {
        $resource = Mage::getSingleton('core/resource');
        $this->setType('ecatalog_ecatalog');
        $read = $resource->getConnection('pdfcatalog_read');
        $write = $resource->getConnection('pdfcatalog_write');
        $this->setConnection($read, $write);
    }

}