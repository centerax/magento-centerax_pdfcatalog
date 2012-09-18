<?php

	$installer = $this;
	/* @var $installer Mage_Core_Model_Resource_Setup */

	$installer->startSetup();

	$installer->run("

	DROP TABLE IF EXISTS `{$this->getTable('pdfcatalog_entity')}`;
	CREATE TABLE `{$this->getTable('pdfcatalog_entity')}` (
	  `entity_id` int(10) unsigned NOT NULL auto_increment,
	  `entity_type_id` smallint(8) unsigned NOT NULL default '0',
	  `attribute_set_id` smallint(5) unsigned NOT NULL default '0',
	  `increment_id` varchar(50) NOT NULL default '',
	  `parent_id` int(10) unsigned default NULL,
	  `store_id` smallint(5) unsigned NOT NULL default '0',
	  `created_at` datetime NOT NULL default '0000-00-00 00:00:00',
	  `updated_at` datetime NOT NULL default '0000-00-00 00:00:00',
	  `is_active` tinyint(1) unsigned NOT NULL default '1',
	  PRIMARY KEY  (`entity_id`),
	  KEY `FK_pdfcatalog_ENTITY_ENTITY_TYPE` (`entity_type_id`),
	  KEY `FK_pdfcatalog_ENTITY_STORE` (`store_id`),
	  KEY `FK_SERVICEPROVIDER_ENTITY_PARENT_ENTITY` (`parent_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='pdfcatalog Entityies';

	DROP TABLE IF EXISTS `{$this->getTable('pdfcatalog_entity_datetime')}`;
	CREATE TABLE `{$this->getTable('pdfcatalog_entity_datetime')}` (
	  `value_id` int(11) NOT NULL auto_increment,
	  `entity_type_id` smallint(8) unsigned NOT NULL default '0',
	  `attribute_id` smallint(5) unsigned NOT NULL default '0',
	  `store_id` smallint(5) unsigned NOT NULL default '0',
	  `entity_id` int(10) unsigned NOT NULL default '0',
	  `value` datetime NOT NULL default '0000-00-00 00:00:00',
	  PRIMARY KEY  (`value_id`),
	  KEY `FK_pdfcatalog_DATETIME_ENTITY_TYPE` (`entity_type_id`),
	  KEY `FK_pdfcatalog_DATETIME_ATTRIBUTE` (`attribute_id`),
	  KEY `FK_pdfcatalog_DATETIME_STORE` (`store_id`),
	  KEY `FK_pdfcatalog_DATETIME_ENTITY` (`entity_id`),
	  CONSTRAINT `FK_pdfcatalog_DATETIME_ATTRIBUTE` FOREIGN KEY (`attribute_id`) REFERENCES `{$this->getTable('eav_attribute')}` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	  CONSTRAINT `FK_pdfcatalog_DATETIME_ENTITY` FOREIGN KEY (`entity_id`) REFERENCES `{$this->getTable('pdfcatalog_entity')}` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	  CONSTRAINT `FK_pdfcatalog_DATETIME_ENTITY_TYPE` FOREIGN KEY (`entity_type_id`) REFERENCES `{$this->getTable('eav_entity_type')}` (`entity_type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	  CONSTRAINT `FK_pdfcatalog_DATETIME_STORE` FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core_store')}` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	DROP TABLE IF EXISTS `{$this->getTable('pdfcatalog_entity_decimal')}`;
	CREATE TABLE `{$this->getTable('pdfcatalog_entity_decimal')}` (
	  `value_id` int(11) NOT NULL auto_increment,
	  `entity_type_id` smallint(8) unsigned NOT NULL default '0',
	  `attribute_id` smallint(5) unsigned NOT NULL default '0',
	  `store_id` smallint(5) unsigned NOT NULL default '0',
	  `entity_id` int(10) unsigned NOT NULL default '0',
	  `value` decimal(12,4) NOT NULL default '0.0000',
	  PRIMARY KEY  (`value_id`),
	  KEY `FK_pdfcatalog_DECIMAL_ENTITY_TYPE` (`entity_type_id`),
	  KEY `FK_pdfcatalog_DECIMAL_ATTRIBUTE` (`attribute_id`),
	  KEY `FK_pdfcatalog_DECIMAL_STORE` (`store_id`),
	  KEY `FK_pdfcatalog_DECIMAL_ENTITY` (`entity_id`),
	  CONSTRAINT `FK_pdfcatalog_DECIMAL_ATTRIBUTE` FOREIGN KEY (`attribute_id`) REFERENCES `{$this->getTable('eav_attribute')}` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	  CONSTRAINT `FK_pdfcatalog_DECIMAL_ENTITY` FOREIGN KEY (`entity_id`) REFERENCES `{$this->getTable('pdfcatalog_entity')}` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	  CONSTRAINT `FK_pdfcatalog_DECIMAL_ENTITY_TYPE` FOREIGN KEY (`entity_type_id`) REFERENCES `{$this->getTable('eav_entity_type')}` (`entity_type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	  CONSTRAINT `FK_pdfcatalog_DECIMAL_STORE` FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core_store')}` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	DROP TABLE IF EXISTS `{$this->getTable('pdfcatalog_entity_int')}`;
	CREATE TABLE `{$this->getTable('pdfcatalog_entity_int')}` (
	  `value_id` int(11) NOT NULL auto_increment,
	  `entity_type_id` smallint(8) unsigned NOT NULL default '0',
	  `attribute_id` smallint(5) unsigned NOT NULL default '0',
	  `store_id` smallint(5) unsigned NOT NULL default '0',
	  `entity_id` int(10) unsigned NOT NULL default '0',
	  `value` int(11) NOT NULL default '0',
	  PRIMARY KEY  (`value_id`),
	  KEY `FK_pdfcatalog_INT_ENTITY_TYPE` (`entity_type_id`),
	  KEY `FK_pdfcatalog_INT_ATTRIBUTE` (`attribute_id`),
	  KEY `FK_pdfcatalog_INT_STORE` (`store_id`),
	  KEY `FK_pdfcatalog_INT_ENTITY` (`entity_id`),
	  CONSTRAINT `FK_pdfcatalog_INT_ATTRIBUTE` FOREIGN KEY (`attribute_id`) REFERENCES `{$this->getTable('eav_attribute')}` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	  CONSTRAINT `FK_pdfcatalog_INT_ENTITY` FOREIGN KEY (`entity_id`) REFERENCES `{$this->getTable('pdfcatalog_entity')}` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	  CONSTRAINT `FK_pdfcatalog_INT_ENTITY_TYPE` FOREIGN KEY (`entity_type_id`) REFERENCES `{$this->getTable('eav_entity_type')}` (`entity_type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	  CONSTRAINT `FK_pdfcatalog_INT_STORE` FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core_store')}` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	DROP TABLE IF EXISTS `{$this->getTable('pdfcatalog_entity_text')}`;
	CREATE TABLE `{$this->getTable('pdfcatalog_entity_text')}` (
	  `value_id` int(11) NOT NULL auto_increment,
	  `entity_type_id` smallint(8) unsigned NOT NULL default '0',
	  `attribute_id` smallint(5) unsigned NOT NULL default '0',
	  `store_id` smallint(5) unsigned NOT NULL default '0',
	  `entity_id` int(10) unsigned NOT NULL default '0',
	  `value` text NOT NULL,
	  PRIMARY KEY  (`value_id`),
	  KEY `FK_pdfcatalog_TEXT_ENTITY_TYPE` (`entity_type_id`),
	  KEY `FK_pdfcatalog_TEXT_ATTRIBUTE` (`attribute_id`),
	  KEY `FK_pdfcatalog_TEXT_STORE` (`store_id`),
	  KEY `FK_pdfcatalog_TEXT_ENTITY` (`entity_id`),
	  CONSTRAINT `FK_pdfcatalog_TEXT_ATTRIBUTE` FOREIGN KEY (`attribute_id`) REFERENCES `{$this->getTable('eav_attribute')}` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	  CONSTRAINT `FK_pdfcatalog_TEXT_ENTITY` FOREIGN KEY (`entity_id`) REFERENCES `{$this->getTable('pdfcatalog_entity')}` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	  CONSTRAINT `FK_pdfcatalog_TEXT_ENTITY_TYPE` FOREIGN KEY (`entity_type_id`) REFERENCES `{$this->getTable('eav_entity_type')}` (`entity_type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	  CONSTRAINT `FK_pdfcatalog_TEXT_STORE` FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core_store')}` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	DROP TABLE IF EXISTS `{$this->getTable('pdfcatalog_entity_varchar')}`;
	CREATE TABLE `{$this->getTable('pdfcatalog_entity_varchar')}` (
	  `value_id` int(11) NOT NULL auto_increment,
	  `entity_type_id` smallint(8) unsigned NOT NULL default '0',
	  `attribute_id` smallint(5) unsigned NOT NULL default '0',
	  `store_id` smallint(5) unsigned NOT NULL default '0',
	  `entity_id` int(10) unsigned NOT NULL default '0',
	  `value` varchar(255) NOT NULL default '',
	  PRIMARY KEY  (`value_id`),
	  KEY `FK_pdfcatalog_VARCHAR_ENTITY_TYPE` (`entity_type_id`),
	  KEY `FK_pdfcatalog_VARCHAR_ATTRIBUTE` (`attribute_id`),
	  KEY `FK_pdfcatalog_VARCHAR_STORE` (`store_id`),
	  KEY `FK_pdfcatalog_VARCHAR_ENTITY` (`entity_id`),
	  CONSTRAINT `FK_pdfcatalog_VARCHAR_ATTRIBUTE` FOREIGN KEY (`attribute_id`) REFERENCES `{$this->getTable('eav_attribute')}` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	  CONSTRAINT `FK_pdfcatalog_VARCHAR_ENTITY` FOREIGN KEY (`entity_id`) REFERENCES `{$this->getTable('pdfcatalog_entity')}` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	  CONSTRAINT `FK_pdfcatalog_VARCHAR_ENTITY_TYPE` FOREIGN KEY (`entity_type_id`) REFERENCES `{$this->getTable('eav_entity_type')}` (`entity_type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	  CONSTRAINT `FK_pdfcatalog_VARCHAR_STORE` FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core_store')}` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");


	$installer->endSetup();

	$installer->installEntities();