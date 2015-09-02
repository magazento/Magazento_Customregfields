<?php

class Magazento_CustomReg_AttributeController extends Mage_Adminhtml_Controller_Action {

    protected $_entityTypeId;

    public function preDispatch() {
        parent::preDispatch();
        $this->_entityTypeId = Mage::getModel('eav/entity')->setType('customer')->getTypeId();
    }

    protected function _initAction() {
        $this->_title($this->__('Customer'))
                ->_title($this->__('Attributes'))
                ->_title($this->__('Manage Attributes'));

        if ($this->getRequest()->getParam('popup')) {
            $this->loadLayout('popup');
        } else {
            $this->loadLayout()
                    ->_setActiveMenu('customer/attributes')
                    ->_addBreadcrumb(Mage::helper('customer')->__('Customer'), Mage::helper('customer')->__('Customer'))
                    ->_addBreadcrumb(
                            Mage::helper('customer')->__('Manage Customer Attributes'), Mage::helper('customer')->__('Manage Customer Attributes'))
            ;
        }
        return $this;
    }

    public function indexAction() {

        $this->_initAction()
                ->_addContent($this->getLayout()->createBlock('customreg/customer_attribute'))
                ->renderLayout();
    }

    public function newAction() {
        $this->_forward('edit');
    }

    public function editAction() {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('customer/attribute');

        if ($id) {
            $model->load($id);

            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                        Mage::helper('customer')->__('This attribute no longer exists'));
                $this->_redirect('*/*/');
                return;
            }

            // entity type check
            if ($model->getEntityTypeId() != $this->_entityTypeId) {
                Mage::getSingleton('adminhtml/session')->addError(
                        Mage::helper('customer')->__('This attribute cannot be edited.'));
                $this->_redirect('*/*/');
                return;
            }
            if (($model->getFrontendInput()=='multiselect')&&($model->getIsAltview()==true)) $model->setFrontendInput('checkboxes');
             if (($model->getFrontendInput() == 'text') && ($model->getIsAltview() == true))
                $model->setFrontendInput('label');
              if (($model->getFrontendInput() == 'select') && ($model->getIsAltview() == true))
                $model->setFrontendInput('radios');
        }

        // set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getAttributeData(true);
        if (!empty($data)) {
            $model->addData($data);
        }

        Mage::register('entity_attribute', $model);

        $this->_initAction();

        $this->_title($id ? $model->getName() : $this->__('New Attribute'));

        $item = $id ? Mage::helper('customer')->__('Edit Customer Attribute') : Mage::helper('customer')->__('New Customer Attribute');

        $this->_addBreadcrumb($item, $item);

        $this->getLayout(); //->getBlock('attribute_edit_js')
        //->setIsPopup((bool)$this->getRequest()->getParam('popup'));


        $this->renderLayout();
    }

    public function validateAction() {
        $response = new Varien_Object();
        $response->setError(false);
        $this->getResponse()->setBody($response->toJson());
    }

    /**
     * Filter post data
     *
     * @param array $data
     * @return array
     */
    protected function _filterPostData($data) {
        if ($data) {
            /** @var $helperCatalog Mage_Catalog_Helper_Data */
            $helperCatalog = Mage::helper('customer');
            //labels
            foreach ($data['frontend_label'] as & $value) {
                if ($value) {
                    $value = $helperCatalog->stripTags($value);
                }
            }
        }
        return $data;
    }

    public function saveAction() {

        $data = $this->getRequest()->getPost();
        $id = $this->getRequest()->getParam('attribute_id');
        $model = Mage::getModel('customer/attribute');

        if ($data) {
            /** @var $session Mage_Admin_Model_Session */
            $session = Mage::getSingleton('adminhtml/session');

            $redirectBack = $this->getRequest()->getParam('back', false);

            $helper = Mage::helper('customreg/data'); //
            //validate attribute_code
            if (isset($data['attribute_code'])) {
                $validatorAttrCode = new Zend_Validate_Regex(array('pattern' => '/^[a-z][a-z_0-9]{1,254}$/'));
                if (!$validatorAttrCode->isValid($data['attribute_code'])) {
                    $session->addError(
                            Mage::helper('catalog')->__('Attribute code is invalid. Please use only letters (a-z), numbers (0-9) or underscore(_) in this field, first character should be a letter.')
                    );
                    $this->_redirect('*/*/edit', array('attribute_id' => $id, '_current' => true));
                    return;
                }
            }

            if (version_compare(Mage::getVersion(), '1.6.0', '>=')) {
                //validate frontend_input
                if (isset($data['frontend_input'])) {
                    /** @var $validatorInputType Mage_Eav_Model_Adminhtml_System_Config_Source_Inputtype_Validator */
                    $validatorInputType = Mage::getModel('eav/adminhtml_system_config_source_inputtype_validator');
                    if (!$validatorInputType->isValid($data['frontend_input'])) {
                        foreach ($validatorInputType->getMessages() as $message) {
                            $session->addError($message);
                        }
                        $this->_redirect('*/*/edit', array('attribute_id' => $id, '_current' => true));
                        return;
                    }
                }
            }
            if ($data['frontend_input']=='checkboxes'){
                $data['frontend_input']='multiselect';
                $data['is_altview']=true;
            }
             if ($data['frontend_input'] == 'radios') {
                $data['frontend_input'] = 'select';
                $data['is_altview'] = true;
            }
             if ($data['frontend_input'] == 'label') {
                $data['frontend_input'] = 'text';
                $data['is_altview'] = true;
                //$data['used_in_forms']=
           //     unset($data['used_in_forms'][array_search('adminhtml_customer',$data['used_in_forms'])]);
            }
            if ($id) {
                $model->load($id);

                if (!$model->getId()) {
                    $session->addError(
                            Mage::helper('catalog')->__('This Attribute no longer exists'));
                    $this->_redirect('*/*/');
                    return;
                }

                // entity type check
                if ($model->getEntityTypeId() != $this->_entityTypeId) {
                    $session->addError(
                            Mage::helper('catalog')->__('This attribute cannot be updated.'));
                    $session->setAttributeData($data);
                    $this->_redirect('*/*/');
                    return;
                }
                if (!isset($data['used_in_forms[]'])){
                    $resmodel=Mage::getResourceModel('customreg/attribute');
                    $resmodel->clearUsedInFormAttr($id);
                    
                }

                $data['attribute_code'] = $model->getAttributeCode();
//                $data['is_user_defined'] = $model->getIsUserDefined();
               $data['frontend_input'] = $model->getFrontendInput();
            } else {
                /**
                 * @todo add to helper and specify all relations for properties
                 */
                $data['source_model'] = $helper->getAttributeSourceModelByInputType($data['frontend_input']);
                $data['backend_model'] = $helper->getAttributeBackendModelByInputType($data['frontend_input']);
                //плохо-плохо, убери в resource и допиши нормально типы
                if ($data['frontend_input']=='select')
                    $type='INT';
                    else
                $type=  'varchar(255) NULL DEFAULT NULL';
                $setup = new Mage_Sales_Model_Mysql4_Setup('sales_setup');
                $setup->getConnection()->addColumn(
                        $setup->getTable('sales_flat_quote'), 'customer_'.$data['attribute_code'], $type
                );
            }

//            if (!isset($data['is_configurable'])) {
//                $data['is_configurable'] = 0;
//            }
//            if (!isset($data['is_filterable'])) {
//                $data['is_filterable'] = 0;
//            }
//            if (!isset($data['is_filterable_in_search'])) {
//                $data['is_filterable_in_search'] = 0;
//            }

            if (is_null($model->getIsUserDefined()) || $model->getIsUserDefined() != 0) {
                $data['backend_type'] = $model->getBackendTypeByInput($data['frontend_input']);
            }

            $defaultValueField = $model->getDefaultValueByInput($data['frontend_input']);
            if ($defaultValueField) {
                $data['default_value'] = $this->getRequest()->getParam($defaultValueField);
            }

//            if (!isset($data['apply_to'])) {
//                $data['apply_to'] = array();
//            }
            //filter
            $data = $this->_filterPostData($data);
            $model->addData($data);

            if (!$id) {
                $model->setEntityTypeId($this->_entityTypeId);
                $model->setIsUserDefined(1);
            }


            if ($this->getRequest()->getParam('set') && $this->getRequest()->getParam('group')) {
                // For creating product attribute on product page we need specify attribute set and group
                $model->setAttributeSetId($this->getRequest()->getParam('set'));
                $model->setAttributeGroupId($this->getRequest()->getParam('group'));
            }

            try {
                $model->save();

                $session->addSuccess(
                        Mage::helper('catalog')->__('The customer attribute has been saved.'));

                /**
                 * Clear translation cache because attribute labels are stored in translation
                 */
                Mage::app()->cleanCache(array(Mage_Core_Model_Translate::CACHE_TAG));
                $session->setAttributeData(false);

                if ($redirectBack) {
                    $this->_redirect('*/*/edit', array('attribute_id' => $model->getId(), '_current' => true));
                } else {
                   $this->_redirect('*/*/', array());
                }
                return;
            } catch (Exception $e) {
                $session->addError($e->getMessage());
                $session->setAttributeData($data);
                $this->_redirect('*/*/edit', array('attribute_id' => $id, '_current' => true));
                return;
            }
        }
       $this->_redirect('*/*/');
    }

    public function deleteAction() {
        if ($id = $this->getRequest()->getParam('id')) {
            //    $model = Mage::getModel('catalog/resource_eav_attribute');
            $model = Mage::getModel('customer/attribute');

            // entity type check
            $model->load($id);
            if ($model->getEntityTypeId() != $this->_entityTypeId) {
                Mage::getSingleton('adminhtml/session')->addError(
                        Mage::helper('catalog')->__('This attribute cannot be deleted.'));
                $this->_redirect('*/*/');
                return;
            }

            try {
                $setup = new Mage_Sales_Model_Mysql4_Setup('sales_setup');
                $setup->getConnection()->dropColumn(
                        $setup->getTable('sales_flat_quote'), 'customer_' . $data['attribute_code'], $type
                );
                $model->delete();
                
                
                Mage::getSingleton('adminhtml/session')->addSuccess(
                        Mage::helper('catalog')->__('The customer attribute has been deleted.'));
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('attribute_id' => $this->getRequest()->getParam('attribute_id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('catalog')->__('Unable to find an attribute to delete.'));
        $this->_redirect('*/*/');
    }

    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('catalog/attributes/attributes');
    }

}
