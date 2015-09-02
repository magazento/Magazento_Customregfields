<?php
class Magazento_CustomReg_Block_Customer_Attribute_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form
{    
    protected $_attribute = null;

    public function setAttributeObject($attribute)
    {
        $this->_attribute = $attribute;
        return $this;
    }

    public function getAttributeObject()
    {
        if (null === $this->_attribute) {
            return Mage::registry('entity_attribute');
        }
        return $this->_attribute;
    }

    /**
     * Preparing default form elements for editing attribute
     *
     * @return Mage_Eav_Block_Adminhtml_Attribute_Edit_Main_Abstract
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'text', 'label' => Mage::helper('eav')->__('Text Field')),
            array('value' => 'textarea', 'label' => Mage::helper('eav')->__('Text Area')),
            array('value' => 'date', 'label' => Mage::helper('eav')->__('Date')),
            array('value' => 'boolean', 'label' => Mage::helper('eav')->__('Yes/No')),
            array('value' => 'multiselect', 'label' => Mage::helper('eav')->__('Multiple Select')),
            array('value' => 'select', 'label' => Mage::helper('eav')->__('Dropdown')),
	    array('value' => 'checkboxes', 'label' => Mage::helper('eav')->__('Checkboxes')),
            array('value' => 'radios', 'label' => Mage::helper('eav')->__('Radios')),
            array('value' => 'label', 'label' => Mage::helper('eav')->__('Label'))        
        );
    }
    
    protected function _prepareForm()
    {
        $attributeObject = $this->getAttributeObject();
    ///   var_dump($attributeObject->getUsedInForms());
    //    var_dump($attributeObject->getData('used_in_forms'));
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getData('action'),
            'method' => 'post'
        ));

        $fieldset = $form->addFieldset('base_fieldset',
            array('legend'=>Mage::helper('eav')->__('Attribute Properties'))
        );
        if ($attributeObject->getAttributeId()) {
            $fieldset->addField('attribute_id', 'hidden', array(
                'name' => 'attribute_id',
            ));
//            $fieldset->addField('attribute_code', 'hidden', array(
//                'name' => 'sattribute_code',
//            ));
        }

        $this->_addElementTypes($fieldset);

        $yesno = Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray();
 if (version_compare(Mage::getVersion(), '1.6.0', '>=')) {
        $maxCodeLength=  Mage_Eav_Model_Entity_Attribute::ATTRIBUTE_CODE_MAX_LENGTH;
 }
 else     $maxCodeLength=30;
        $validateClass = sprintf('validate-code validate-length maximum-length-%d',
            $maxCodeLength);
        $fieldset->addField('attribute_code', 'text', array(
            'name'  => 'attribute_code',
            'label' => Mage::helper('eav')->__('Attribute Code'),
            'title' => Mage::helper('eav')->__('Attribute Code'),
            'note'  => Mage::helper('eav')->__('For internal use. Must be unique with no spaces. Maximum length of attribute code must be less then %s symbols', $maxCodeLength),
            'class' => $validateClass,
            'required' => true,
        ));

        $inputTypes = $this->toOptionArray();

        $fieldset->addField('frontend_input', 'select', array(
            'name' => 'frontend_input',
            'label' => Mage::helper('eav')->__('Catalog Input Type for Store Owner'),
            'title' => Mage::helper('eav')->__('Catalog Input Type for Store Owner'),
            'value' => 'text',
            'values'=> $inputTypes
        ));

         $fieldset->addField('note', 'text', array(
            'name' => 'note',
            'label' => Mage::helper('eav')->__('Note'),
            'title' => Mage::helper('eav')->__('Note'),
            'value' => $attributeObject->getNote(),
        ));
         $fieldset->addField('position', 'text', array(
            'name' => 'position',
            'label' => Mage::helper('eav')->__('Position'),
            'title' => Mage::helper('eav')->__('Position'),
            'value' => $attributeObject->getPosition(),
        ));
         
           $fieldset->addField('description', 'text', array(
            'name' => 'description',
            'label' => Mage::helper('eav')->__('Description'),
            'title' => Mage::helper('eav')->__('Description'),
            'value' => $attributeObject->getDecription(),
        ));

        
        $fieldset->addField('default_value_text', 'text', array(
            'name' => 'default_value_text',
            'label' => Mage::helper('eav')->__('Default Value'),
            'title' => Mage::helper('eav')->__('Default Value'),
            'value' => $attributeObject->getDefaultValue(),
        ));


     

        $fieldset->addField('is_required', 'select', array(
            'name' => 'is_required',
            'label' => Mage::helper('eav')->__('Values Required'),
            'title' => Mage::helper('eav')->__('Values Required'),
            'values' => $yesno,
        ));

        $fieldset->addField('frontend_class', 'select', array(
            'name'  => 'frontend_class',
            'label' => Mage::helper('eav')->__('Input Validation for Store Owner'),
            'title' => Mage::helper('eav')->__('Input Validation for Store Owner'),
            'values' => Mage::helper('eav')->getFrontendClasses($attributeObject['entity_type_id'])
         //   'values'=> Mage::helper('eav')->getFrontendClasses($attributeObject->getEntityType()->getEntityTypeCode())
        ));

        if ($attributeObject->getId()) {
            $form->getElement('attribute_code')->setDisabled(1);
            $form->getElement('frontend_input')->setDisabled(1);           
        }
         $fieldset = $form->addFieldset('front_fieldset', array('legend' => Mage::helper('catalog')->__('Frontend Properties')));


        $fieldset->addField('adminhtml_customer', 'checkbox', array(
            'name' => 'used_in_forms[]',
            'label' => Mage::helper('catalog')->__('Adminhtml Customer'),
            'value' => 'adminhtml_customer',
            'checked' =>  in_array('adminhtml_customer', $attributeObject->getUsedInForms()) ? 'checked' : '',
        ));
        $fieldset->addField('customer_account_create', 'checkbox', array(
            'name' => 'used_in_forms[]',
            'label' => Mage::helper('catalog')->__('Customer Account Create'),
            'value' => 'customer_account_create',
            'checked' => in_array('customer_account_create',$attributeObject->getUsedInForms())? 'checked' : '',
        ));
        $fieldset->addField('customer_account_edit', 'checkbox', array(
            'name' => 'used_in_forms[]',
            'label' => Mage::helper('catalog')->__('Customer Account Edit'),
            'value' => 'customer_account_edit',
            'checked' => in_array('customer_account_edit', $attributeObject->getUsedInForms()) ? 'checked' : '',
        ));
        $fieldset->addField('checkout_register', 'checkbox', array(
            'name' => 'used_in_forms[]',
            'label' => Mage::helper('catalog')->__('Checkout Register'),
            'value' => 'checkout_register',
            'checked' => in_array('checkout_register', $attributeObject->getUsedInForms()) ? 'checked' : '',
        ));

        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Initialize form fileds values
     *
     * @return Mage_Eav_Block_Adminhtml_Attribute_Edit_Main_Abstract
     */
    protected function _initFormValues()
    {
        Mage::dispatchEvent('adminhtml_block_eav_attribute_edit_form_init', array('form' => $this->getForm()));
        $this->getForm()
            ->addValues($this->getAttributeObject()->getData());
        return parent::_initFormValues();
    }

    /**
     * This method is called before rendering HTML
     *
     * @return Mage_Eav_Block_Adminhtml_Attribute_Edit_Main_Abstract
     */
    protected function _beforeToHtml()
    {
        parent::_beforeToHtml();
        $attributeObject = $this->getAttributeObject();
        if ($attributeObject->getId()) {
            $form = $this->getForm();
            $disableAttributeFields = Mage::helper('eav')
                ->getAttributeLockedFields($attributeObject->getEntityType()->getEntityTypeCode());
            if (isset($disableAttributeFields[$attributeObject->getAttributeCode()])) {
                foreach ($disableAttributeFields[$attributeObject->getAttributeCode()] as $field) {
                    if ($elm = $form->getElement($field)) {
                        $elm->setDisabled(1);
                        $elm->setReadonly(1);
                    }
                }
            }
        }
        return $this;
    }

    /**
     * Processing block html after rendering
     * Adding js block to the end of this block
     *
     * @param   string $html
     * @return  string
     */
    protected function _afterToHtml($html)
    {
        $jsScripts = $this->getLayout()
            ->createBlock('eav/adminhtml_attribute_edit_js')->toHtml();
        return $html.$jsScripts;
    }

}
