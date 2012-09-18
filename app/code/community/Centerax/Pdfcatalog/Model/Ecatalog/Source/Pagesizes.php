<?php

class Centerax_Pdfcatalog_Model_Ecatalog_Source_Pagesizes
{
    public function getOptionArray()
    {
		$opts = array();
		$opts[] = array('value'=>'595:842:', 'label'=>'A4');
		$opts[] = array('value'=>'842:595:', 'label'=>'A4 Landscape');
		$opts[] = array('value'=>'612:792:', 'label'=>'Letter');
		$opts[] = array('value'=>'792:612:', 'label'=>'Letter Landscape');

		return $opts;
    }

    public function getOptions()
    {
    	$opts = $this->getOptionArray();

    	$gopts = array();
    	foreach($opts as $v){
    		$gopts[$v['value']] = $v['label'];
    	}

    	return $gopts;
    }
}