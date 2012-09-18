<?php

class Centerax_Pdfcatalog_Model_Ecatalog_Source_Fonts
{
    public function getOptionArray()
    {
			$opts = array();
			$opts[] = array('value'=>'Courier', 'label'=>'Courier');
			$opts[] = array('value'=>'Courier-Bold', 'label'=>'Courier Bold');
			$opts[] = array('value'=>'Courier-Oblique', 'label'=>'Courier Oblique');
			$opts[] = array('value'=>'Courier-BoldOblique', 'label'=>'Courier Bold Oblique');
			$opts[] = array('value'=>'Helvetica', 'label'=>'Helvetica');
			$opts[] = array('value'=>'Helvetica-Bold', 'label'=>'Helvetica Bold');
			$opts[] = array('value'=>'Helvetica-Oblique', 'label'=>'Helvetica Oblique');
			$opts[] = array('value'=>'Helvetica-BoldOblique', 'label'=>'Helvetica Bold Oblique');
			$opts[] = array('value'=>'Symbol', 'label'=>'Symbol');
			$opts[] = array('value'=>'Times-Roman', 'label'=>'Times Roman');
			$opts[] = array('value'=>'Times-Bold', 'label'=>'Times Bold');
			$opts[] = array('value'=>'Times-Italic', 'label'=>'Times Italic');
			$opts[] = array('value'=>'Times-BoldItalic', 'label'=>'Times BoldItalic');
			$opts[] = array('value'=>'ZapfDingbats', 'label'=>'ZapfDingbats');

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