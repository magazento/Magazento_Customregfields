<?php

class Magazento_CustomReg_Block_Edit extends Mage_Core_Block_Template {

    public function getHtml() {

//        $customer_id = Mage::getSingleton('customer/session')->getCustomer()->getId();
//        $customer_data = Mage::getModel('customer/customer')->load($customer_id);
//        $absmodel = Mage::getModel('customreg/abstract');
//        $results = $absmodel->getSCollection();
//
//        foreach ($results as $row) {
//
//            if ($row['attribute_code'] == 'gender')
//                break;
//
//            if ($row['frontend_input'] == 'text') {
//                $em_req = '';
//                $class_req = '';
//                $inpclass_req = '';
//                if ($row['is_required']) {
//                    $em_req = '<em>*</em>';
//                    $class_req = 'class="required"';
//                    $inpclass_req = 'required-entry';
//                }
//
//                $shtml = $shtml . '<li><label  ' . $class_req . '>' . $em_req . $row['frontend_label'] . '</label>'
//                        . '<div class="input-box">'
//                        . '<input type="text" name="' . $row['attribute_code'] . '" id="' . $row['attribute_code'] . '" value="' . $customer_data[$row['attribute_code']] . '" title="' . $row['frontend_label'] . '" class="input-text ' . $inpclass_req . '">'
//                        . '</div></li>';
//
//                continue;
//            }
//
//            if ($row['frontend_input'] == 'textarea') {
//
//                $shtml = $shtml . '<li><label >' . $row['frontend_label'] . '</label>'
//                        . '<div class="input-box">'
//                        . '<textarea rows="5" name="' . $row['attribute_code'] . '" id="' . $row['attribute_code'] . '" title="' . $row['frontend_label'] . '" >' . $customer_data[$row['attribute_code']] . ' </textarea>'
//                        . '</div></li>';
//
//                continue;
//            }
//
//
//            if ($row['frontend_input'] == 'date') {
//
//                $shtml = $shtml . '<li><label >' . $row['frontend_label'] . ' (DD-MM-YYYY)</label>'
//                        . '<div class="input-box">'
//                        . '<input type="text" name="' . $row['attribute_code'] . '" id="' . $row['attribute_code'] . '" value="' . $customer_data[$row['attribute_code']] . '"  title="' . $row['frontend_label'] . '" class="input-text">'
//                        . '</div></li>';
//
//                continue;
//            }
//
//            if ($row['frontend_input'] == 'boolean') {
//
//                if ($customer_data[$row['attribute_code']] == 0)
//                    $s1 = 'selected="selected"';
//                else
//                    $s2 = 'selected="selected"';
//
//                $shtml = $shtml . '<li><label >' . $row['frontend_label'] . '</label>'
//                        . '<div class="input-box">'
//                        . '<select id="' . $row['attribute_code'] . '" name="' . $row['attribute_code'] . '" title=""><option value="" selected="selected"></option><option value="1" ' . $s2 . '>Yes</option><option value="0" ' . $s1 . '>No</option></select>'
//                        . '</div></li>';
//
//                continue;
//            }
//            
//            if ($row['frontend_input'] == 'label') {
//
//                $shtml = $shtml . '<li><label >' . $row['frontend_label'] . '</label></li>';
//
//                continue;
//            }
//
//
//            if ($row['frontend_input'] == 'select') {
//
//                $shtml = $shtml . '<li><label >' . $row['frontend_label'] . '</label>'
//                        . '<div class="input-box">'
//                        . '<select id="' . $row['attribute_code'] . '" name="' . $row['attribute_code'] . '" title=""><option value="" selected="selected">...</option>';
//
//                $sResults = $absmodel->getAtrCollection($row['attribute_id']);
//
//                for ($j = 0; $j < count($sResults); $j++) {
//                    $s = '';
//
//                    $s1 = ' ' . $customer_data[$row['attribute_code']];
//                    $s2 = $sResults[$j]["option_id"];
//                    if (strpos($s1, $s2))
//                        $s = 'selected="selected"';
//                    $shtml = $shtml . '<option value="' . $sResults[$j]["option_id"] . '" ' . $s . '>' . $sResults[$j]["value"] . '</option>';
//                }
//                $shtml = $shtml . '</select></div></li>';
//                continue;
//            }
//
//
//            if ($row['frontend_input'] == 'multiselect') {
//
//                $shtml = $shtml . '<li><label >' . $row['frontend_label'] . '</label>'
//                        . '<div class="input-box">';
//
//                $sResults = $absmodel->getAtrCollection($row['attribute_id']);
//
//                $shtml = $shtml . '<select id="' . $row['attribute_code'] . '" name="' . $row['attribute_code'] . '[]" class=" select multiselect" size="' . count($sResults) . '" multiple="multiple">';
//
//
//                for ($j = 0; $j < count($sResults); $j++) {
//
//                    $s = '';
//                    $s1 = ' ' . $customer_data[$row['attribute_code']];
//                    $s2 = $sResults[$j]["option_id"];
//                    if (strpos($s1, $s2))
//                        $s = 'selected="selected"';
//
//                    $shtml = $shtml . '<option value="' . $sResults[$j]["option_id"] . '" ' . $s . '>' . $sResults[$j]["value"] . '</option>';
//                }
//                $shtml = $shtml . '</select></div></li>';
//                continue;
//            }
//            
//            
//            
//             if ($row['frontend_input'] == 'checkboxes') {
//
//                $shtml = $shtml . '<li>'
//                        . '<br/><table>';
//                $name = $row['attribute_code'];
//                
//                $sResults = $absmodel->getAtrCollection($row['attribute_id']);
//
//                for ($j = 0; $j < count($sResults); $j++) {  
//                    
//                    $s = '';
//                    $s1 = ' ' . $customer_data[$row['attribute_code']];
//                    $s2 = $sResults[$j]["option_id"];
//                    if (strpos($s1, $s2))
//                        $s = 'checked="checked"';
//                    
//                    $shtml = $shtml .'<tr><td width="20"><input name="'.$name.'" value="' . $sResults[$j]["option_id"] . '" class="clicks" onclick="setCheckboxes(' . $sResults[$j]["option_id"] . ')" type="checkbox"  ' . $s . '></td><td > <label >' . $sResults[$j]["value"] . '</label></td></tr>';
//                }
//                $shtml = $shtml . '<tr><td><input name="'.$name.'" value="" id="shd" class="sss" type="hidden"></td></tr></table></li>';
//                continue;
//            }
//
//            
//             if ($row['frontend_input'] == 'radios') {
//
//             $shtml = $shtml . '<li><label >' . $row['frontend_label'] . '</label>'
//                        . '<br/><table><tr>';
//                
//              $name = $row['attribute_code'];
//              
//                $sResults = $absmodel->getAtrCollection($row['attribute_id']);
//
//                for ($j = 0; $j < count($sResults); $j++) { 
//                      
//                    $s = '';
//                    $s1 = ' ' . $customer_data[$row['attribute_code']];
//                    $s2 = $sResults[$j]["option_id"];
//                    if (strpos($s1, $s2))
//                        $s = 'checked="checked"';
//                    
//                    $shtml = $shtml .'<td><input  name="'.$name.'" value="' . $sResults[$j]["option_id"] . '"  type="radio"  ' . $s . '></td><td> <label style="margin-right:5px;">' . $sResults[$j]["value"] . '</label></td>';
//                }
//                $shtml = $shtml . '</tr></table></li>';
//                continue;
//            }
//
//            
//            
//            
//        }
//
        return $shtml;
    }

}
