<?php

$installer = $this;

$installer->startSetup();

$installer->getConnection()->addColumn(
        $this->getTable('customer/eav_attribute'), 
        'position',      
        'int(11) NOT NULL DEFAULT 0' 
        );


$installer->getConnection()->addColumn(
        $this->getTable('customer/eav_attribute'), 
        'description',      
        'VARCHAR(200)' 
        );
        $installer->getConnection()->addColumn(
$this->getTable('customer/eav_attribute'),
'is_altview',
                'BOOLEAN NULL DEFAULT NULL COMMENT "use alternative view for input"');
//       ALTER TABLE `customer_eav_attribute` ADD `is_altview` BOOLEAN NULL DEFAULT NULL COMMENT 'use alternative view for input'
$installer->endSetup();