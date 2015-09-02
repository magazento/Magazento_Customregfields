<?php

class Magazento_CustomReg_Block_Customer_Attribute_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('magageAttrGrid');
        $this->setDefaultSort('set_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    /**
     * Prepare product attributes grid collection object
     *
     * @return Mage_Adminhtml_Block_Catalog_Product_Attribute_Grid
     */
    protected function _prepareCollection() {
        //  $collection = Mage::getResourceModel('customer/attribute_collection');
//        $type = 'customer';
//        $collection = Mage::getResourceModel('eav/entity_attribute_collection')
//                ->setEntityTypeFilter(Mage::getModel('eav/entity')->setType($type)->getTypeId());
       $collection=Mage::getModel('customer/attribute')->getCollection();
    //    $collection = Mage::getModel('customer/entity_attribute_collection');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare product attributes grid columns
     *
     * @return Mage_Adminhtml_Block_Catalog_Product_Attribute_Grid
     */
    protected function _prepareColumns() {
         
        $this->addColumn('attribute_code', array(
            'header' => Mage::helper('eav')->__('Attribute Code'),
            'sortable' => true,
            'index' => 'attribute_code'
        ));

        $this->addColumn('frontend_label', array(
            'header' => Mage::helper('eav')->__('Attribute Label'),
            'sortable' => true,
            'index' => 'frontend_label'
        ));

        $this->addColumn('is_required', array(
            'header' => Mage::helper('eav')->__('Required'),
            'sortable' => true,
            'index' => 'is_required',
            'type' => 'options',
            'options' => array(
                '1' => Mage::helper('eav')->__('Yes'),
                '0' => Mage::helper('eav')->__('No'),
            ),
            'align' => 'center',
        ));

        $this->addColumn('is_user_defined', array(
            'header' => Mage::helper('eav')->__('System'),
            'sortable' => true,
            'index' => 'is_user_defined',
            'type' => 'options',
            'align' => 'center',
            'options' => array(
                '0' => Mage::helper('eav')->__('Yes'), // intended reverted use
                '1' => Mage::helper('eav')->__('No'), // intended reverted use
            ),
        ));

        parent::_prepareColumns();
        // return $this;
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
