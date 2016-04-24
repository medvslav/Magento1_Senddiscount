<?php
/**
 * Medvslav_Senddiscount extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Medvslav
 * @package        Medvslav_Senddiscount
 * @copyright      Copyright (c) 2016
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Customer for sending discount admin grid block
 *
 * @category    Medvslav
 * @package     Medvslav_Senddiscount
 * @author      Medved Yaroslav
 */
class Medvslav_Senddiscount_Block_Adminhtml_Sdcustomer_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * constructor
     *
     * @access public
     * @author Medved Yaroslav
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('sdcustomerGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * prepare collection
     *
     * @access protected
     * @return Medvslav_Senddiscount_Block_Adminhtml_Sdcustomer_Grid
     * @author Medved Yaroslav
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('medvslav_senddiscount/sdcustomer')
            ->getCollection();
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * prepare grid collection
     *
     * @access protected
     * @return Medvslav_Senddiscount_Block_Adminhtml_Sdcustomer_Grid
     * @author Medved Yaroslav
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('medvslav_senddiscount')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            )
        );
        $this->addColumn(
            'email',
            array(
                'header'    => Mage::helper('medvslav_senddiscount')->__('Email'),
                'align'     => 'left',
                'index'     => 'email',
            )
        );
        

        $this->addColumn(
            'customer_ip',
            array(
                'header' => Mage::helper('medvslav_senddiscount')->__('Customer IP'),
                'index'  => 'customer_ip',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'first_name',
            array(
                'header' => Mage::helper('medvslav_senddiscount')->__('First name'),
                'index'  => 'first_name',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'surname',
            array(
                'header' => Mage::helper('medvslav_senddiscount')->__('Surname'),
                'index'  => 'surname',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'phone',
            array(
                'header' => Mage::helper('medvslav_senddiscount')->__('Phone'),
                'index'  => 'phone',
                'type'=> 'text',

            )
        );
        $this->addColumn(
            'sku',
            array(
                'header' => Mage::helper('medvslav_senddiscount')->__('Product SKU'),
                'index'  => 'sku',
                'type'=> 'text',

            )
        );
		
        $this->addColumn(
            'product_id',
            array(
                'header'  =>  Mage::helper('medvslav_senddiscount')->__('Product ID'),
                'type'    => 'action',                
                'actions' => array(
                    array(                        
						'caption' => '$product_id',
						'url'     => Mage::helper('adminhtml')->getUrl('adminhtml/catalog_product/edit', array('id' => '$product_id'))
                    )
                ),
                'filter'    => false,
                'is_system' => true,
                'sortable'  => false,
            )
        );
        $this->addColumn(
            'customerstatus',
            array(
                'header' => Mage::helper('medvslav_senddiscount')->__('Customer Status'),
                'index'  => 'customerstatus',
                'type'  => 'options',
                'options' => Mage::helper('medvslav_senddiscount')->convertOptions(
                    Mage::getModel('medvslav_senddiscount/sdcustomer_attribute_source_customerstatus')->getAllOptions(false)
                )

            )
        );
        $this->addColumn(
            'created_at',
            array(
                'header' => Mage::helper('medvslav_senddiscount')->__('Created at'),
                'index'  => 'created_at',
                'width'  => '120px',
                'type'   => 'datetime',
            )
        );
        $this->addColumn(
            'action',
            array(
                'header'  =>  Mage::helper('medvslav_senddiscount')->__('Action'),
                'width'   => '100',
                'type'    => 'action',
                'getter'  => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('medvslav_senddiscount')->__('Edit'),
                        'url'     => array('base'=> '*/*/edit'),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'is_system' => true,
                'sortable'  => false,
            )
        );
        $this->addExportType('*/*/exportCsv', Mage::helper('medvslav_senddiscount')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('medvslav_senddiscount')->__('Excel'));
        $this->addExportType('*/*/exportXml', Mage::helper('medvslav_senddiscount')->__('XML'));
        return parent::_prepareColumns();
    }

    /**
     * prepare mass action
     *
     * @access protected
     * @return Medvslav_Senddiscount_Block_Adminhtml_Sdcustomer_Grid
     * @author Medved Yaroslav
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('sdcustomer');
        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label'=> Mage::helper('medvslav_senddiscount')->__('Delete'),
                'url'  => $this->getUrl('*/*/massDelete'),
                'confirm'  => Mage::helper('medvslav_senddiscount')->__('Are you sure?')
            )
        );

        $this->getMassactionBlock()->addItem(
            'customerstatus',
            array(
                'label'      => Mage::helper('medvslav_senddiscount')->__('Change Customer Status'),
                'url'        => $this->getUrl('*/*/massCustomerstatus', array('_current'=>true)),
                'additional' => array(
                    'flag_customerstatus' => array(
                        'name'   => 'flag_customerstatus',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => Mage::helper('medvslav_senddiscount')->__('Customer Status'),
                        'values' => Mage::getModel('medvslav_senddiscount/sdcustomer_attribute_source_customerstatus')
                            ->getAllOptions(true),

                    )
                )
            )
        );
        return $this;
    }

    /**
     * get the row url
     *
     * @access public
     * @param Medvslav_Senddiscount_Model_Sdcustomer
     * @return string
     * @author Medved Yaroslav
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    /**
     * get the grid url
     *
     * @access public
     * @return string
     * @author Medved Yaroslav
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    /**
     * after collection load
     *
     * @access protected
     * @return Medvslav_Senddiscount_Block_Adminhtml_Sdcustomer_Grid
     * @author Medved Yaroslav
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
