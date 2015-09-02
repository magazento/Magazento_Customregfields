<?php

class Magazento_CustomReg_Block_Customer_Attribute_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    public function __construct()
    {
                parent::__construct();
        $this->_objectId = 'attribute_id';
        $this->_controller = 'attribute';
        $this->_blockGroup = 'customreg';

        

        if($this->getRequest()->getParam('popup')) {
            $this->_removeButton('back');
            $this->_addButton(
                'close',
                array(
                    'label'     => Mage::helper('catalog')->__('Close Window'),
                    'class'     => 'cancel',
                    'onclick'   => 'window.close()',
                    'level'     => -1
                )
            );
        } else {
        }

        $this->_updateButton('save', 'label', Mage::helper('catalog')->__('Save Attribute'));
        $this->_updateButton('save', 'onclick', 'saveAttribute()');
        

        if (! Mage::registry('entity_attribute')->getIsUserDefined()) {
            $this->_removeButton('delete');
        } else {
            $this->_updateButton('delete', 'label', Mage::helper('catalog')->__('Delete Attribute'));
        }
    }

    public function getHeaderText()
    {
        if (Mage::registry('entity_attribute')->getId()) {
            $frontendLabel = Mage::registry('entity_attribute')->getFrontendLabel();
            if (is_array($frontendLabel)) {
                $frontendLabel = $frontendLabel[0];
            }
            return Mage::helper('catalog')->__('Edit Customer Attribute "%s"', $this->htmlEscape($frontendLabel));
        }
        else {
            return Mage::helper('catalog')->__('New Customer Attribute');
        }
    }

    public function getValidationUrl()
    {
        return $this->getUrl('*/*/validate', array('_current'=>true));
    }

    public function getSaveUrl()
    {
        return $this->getUrl('*/'.$this->_controller.'/save', array('_current'=>true, 'back'=>null));
    }
}
