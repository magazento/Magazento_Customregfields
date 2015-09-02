<?php
class Magazento_Customreg_Block_Widget_Additional extends Mage_Customer_Block_Widget_Abstract
{
    protected $FormType;
    public function _construct()
    {
        parent::_construct();
     
        $this->setTemplate('magazento_customreg/widget/additional.phtml');
    }

    public function isEnabled($formType)
    { $result=false;
      $this->setFormType($formType);
        //return (bool)$this->_getAttribute('privacy')->getIsVisible();
      $model = Mage::getModel('customreg/attribute');
             if ($model->getCntUserAttr($formType)>0) {$result=true;}
        return $result;
    }

    public function isRequired()
    {
      //  return (bool)$this->_getAttribute('privacy')->getIsRequired();
      return (bool)$this->getAttr()->getIsRequired();
     //   return true;
    }
    
    public function isChecked()
    {
       // return (bool)$this->getPrivacy();
         return true;
    }

    public function getCustomer()
    {
        return Mage::getSingleton('customer/session')->getCustomer();
    }
    
    public function getFormType(){
        return $this->FormType;
    }
    public function setFormType($type){
        $this->FormType=$type;
    }

    public function getAllFields() {
        //   Mage::log('in getAllFields');
      //  $this->setFormType($formType);
        $model = Mage::getModel('customreg/attribute');
        //   $customer = Mage::getSingleton('customer/session')->getCustomer();
        $AttrCollection = $model->getUserAttr($this->getFormType());
        $atrArr = array();
        foreach ($AttrCollection as $attr) {
            //   Mage::log($attr);
            $data = $attr->getData();
            $atrArr[] = $attr;
        }
        return $atrArr;
    }
}
