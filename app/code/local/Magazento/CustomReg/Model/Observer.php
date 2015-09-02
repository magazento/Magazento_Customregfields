<?php
/**
 * Description of Observer
 *
 * @author kurisu
 */
class Magazento_CustomReg_Model_Observer {
    
    public function Add_CustomFields_toQuote($observer){
        $target=$observer->getTarget(); //quote
        $source=$observer->getSource(); // customer
      
        $sourceIsArray = is_array($source);
        $targetIsArray = is_array($target);
        $aspect='to_quote';
        $model=Mage::getModel('customreg/attribute');
        $fields=$model->getCustomFieldsForQuote();
      //  var_dump($fields);
        $result = false;
        foreach ($fields as $code => $node) {
            if (empty($node->$aspect)) {
                continue;
            }

            if ($sourceIsArray) {
                $value = isset($source[$code]) ? $source[$code] : null;
            } else {
                $value = $source->getDataUsingMethod($code);
            }
       //     var_dump($code);
       //     var_dump($value);
            $targetCode = (string) $node->$aspect;
            $targetCode = $targetCode == '*' ? $code : $targetCode;
        //    var_dump($targetCode);
            if ($targetIsArray) {
                $target[$targetCode] = $value;
            } else {
                $target->setDataUsingMethod($targetCode, $value);
            }

            $result = true;
        }
    }
     public function Add_CustomFields_toCustomer($observer) {
         $target = $observer->getTarget(); //quote
        $source = $observer->getSource(); // customer
         Mage::log('in observer',null,'magazeto.log');
          $sourceIsArray = is_array($source);
        $targetIsArray = is_array($target);
        $aspect='to_customer';
        $model=Mage::getModel('customreg/attribute');
        $fields=$model->getCustomFieldsForCustomer();
        Mage::log($fields,  null, 'magazeto.log');
        $result = false;
        foreach ($fields as $code => $node) {
            if (empty($node->$aspect)) {
                continue;
            }

            if ($sourceIsArray) {
                $value = isset($source[$code]) ? $source[$code] : null;
            } else {
                $value = $source->getDataUsingMethod($code);
            }
Mage::log($code,  null, 'magazeto.log');
Mage::log($value,  null, 'magazeto.log');
            $targetCode = (string) $node->$aspect;
            $targetCode = $targetCode == '*' ? $code : $targetCode;
Mage::log($targetCode,  null, 'magazeto.log');
            if ($targetIsArray) {
                $target[$targetCode] = $value;
            } else {
                $target->setDataUsingMethod($targetCode, $value);
            }

            $result = true;
            
            }
     }
}

?>
