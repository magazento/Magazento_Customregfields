<?php

class Magazento_CustomReg_Model_Attribute extends Mage_Customer_Model_Attribute //extends Mage_Eav_Model_Attribute   {
{ 
/**
     * Name of the module
     */

    const MODULE_NAME = 'Magazento_CustomReg';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'customer_entity_attribute';

    /**
     * Prefix of model events object
     *
     * @var string
     */
    protected $_eventObject = 'attribute';

    /**
     * Init resource model
     */
    protected function _construct() {
        //     $this->_init('customer/attribute');
        $this->_init('customreg/attribute');
    }

    public function getUserAttr($formType) {
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        $customerForm = Mage::getModel('customer/form');

        $customerForm->setEntity($customer)
                ->setFormCode($formType)
                ->initDefaultValues();
        $attributes = $customerForm->getUserAttributes();

        usort($attributes, array('Magazento_CustomReg_Model_Attribute', 'cmp'));

        return $attributes;
    }

    function cmp($a, $b) {

        if ($a->getPosition() == $b->getPosition()) {
            return 0;
        }
        return ($a->getPosition() < $b->getPosition()) ? -1 : 1;
    }
    public function getCustomFieldsForQuote(){
        $fieldArray= $this->getUserAttr('checkout_register');
        $result=array();
        foreach ($fieldArray as $field){
            
            $nodeObj=  (object) array('to_quote'=> 'customer_'.$field->getAttributeCode());
    //        $nodeObj->setData('to_quote','customer_'.$field->getCode());
            
            $result[$field->getAttributeCode()]=$nodeObj;
            
        }
        return $result;
    }
    public function getCustomFieldsForCustomer() {
        $fieldArray = $this->getUserAttr('checkout_register');
        $result = array();
        foreach ($fieldArray as $field) {

            $nodeObj = (object) array('to_customer' => $field->getAttributeCode());
            //        $nodeObj->setData('to_quote','customer_'.$field->getCode());

            $result['customer_'.$field->getAttributeCode()] = $nodeObj;
        }
        return $result;
    }
    
    public function getCntUserAttr($formType) {
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        $customerForm = Mage::getModel('customer/form');

        $customerForm->setEntity($customer)
                ->setFormCode($formType)
                ->initDefaultValues();
        $cnt = count($customerForm->getUserAttributes());

        return $cnt;
    }

}
