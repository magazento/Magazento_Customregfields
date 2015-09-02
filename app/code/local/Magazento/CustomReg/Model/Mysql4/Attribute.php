<?php
class Magazento_CustomReg_Model_Mysql4_Attribute extends Mage_Customer_Model_Entity_Attribute//Mage_Customer_Model_Resource_Attribute
{
    
  
     public function loadAllUsersAttributes($object=null)
    {
        $attributeCodes = Mage::getSingleton('eav/config')
            ->getEntityAttributeCodes('customer', $object);
//$Arr=array();
//                foreach ($attributeCodes as $code) {
//            $this->getAttribute($code);
//        }

        return $attributeCodes;
    }
    public function clearUsedInFormAttr($attrId){
    $adapter = $this->_getWriteAdapter();
    $where = array('attribute_id=?' => $attrId);
   // $adapter->delete($this->_getFormAttributeTable(), $where);
   $adapter->delete($this->getTable('customer/form_attribute'),$where);
    }
    
    
}

?>
