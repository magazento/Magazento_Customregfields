<?php

class Magazento_CustomReg_Block_Customer_Attribute extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {
        Mage::log ('Magazento_CustomReg_Block_Customer_Attribute');
        $this->_blockGroup = 'customreg';
        $this->_controller = 'customer_attribute';
        $this->_headerText = Mage::helper('catalog')->__('Manage Attributes');
        $this->_addButtonLabel = Mage::helper('catalog')->__('Add New Attribute');
        parent::__construct();
    }

}
