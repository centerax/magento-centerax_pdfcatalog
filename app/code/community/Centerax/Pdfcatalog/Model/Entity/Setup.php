<?php

class Centerax_Pdfcatalog_Model_Entity_Setup extends Mage_Eav_Model_Entity_Setup
{

    public function getDefaultEntities()
    {

        return array(
        	'ecatalog_ecatalog' => array(
                'entity_model'      => 'ecatalog/ecatalog',
                'table'=>'pdfcatalog/entity',
                'attributes' => array(
               		'entity_id'        => array('type'=>'static'),
               		'filename'         => array('type'=>'varchar'),
                    'pagesize'        => array('type'=>'varchar'),
                    'fonttype'        => array('type'=>'varchar'),
                    'fontsize'    => array('type'=>'int'),
                    'extra'    => array('type'=>'text')
                )
            )
        );

    }

}