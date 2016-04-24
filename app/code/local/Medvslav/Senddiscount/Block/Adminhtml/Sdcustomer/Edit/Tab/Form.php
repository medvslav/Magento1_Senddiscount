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
 * Customer for sending discount edit form tab
 *
 * @category    Medvslav
 * @package     Medvslav_Senddiscount
 * @author      Medved Yaroslav
 */
class Medvslav_Senddiscount_Block_Adminhtml_Sdcustomer_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return Medvslav_Senddiscount_Block_Adminhtml_Sdcustomer_Edit_Tab_Form
     * @author Medved Yaroslav
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('sdcustomer_');
        $form->setFieldNameSuffix('sdcustomer');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'sdcustomer_form',
            array('legend' => Mage::helper('medvslav_senddiscount')->__('Customer for sending discount'))
        );

        $fieldset->addField(
            'customer_ip',
            'text',
            array(
                'label' => Mage::helper('medvslav_senddiscount')->__('Customer IP'),
                'name'  => 'customer_ip',
            'required'  => true,
            'class' => 'required-entry',
			'disabled' => true,
           )
        );

        $fieldset->addField(
            'first_name',
            'text',
            array(
                'label' => Mage::helper('medvslav_senddiscount')->__('First name'),
                'name'  => 'first_name',
            'required'  => true,
            'class' => 'required-entry',
			'disabled' => true,
           )
        );

        $fieldset->addField(
            'surname',
            'text',
            array(
                'label' => Mage::helper('medvslav_senddiscount')->__('Surname'),
                'name'  => 'surname',
            'required'  => true,
            'class' => 'required-entry',
			'disabled' => true,
           )
        );

        $fieldset->addField(
            'email',
            'text',
            array(
                'label' => Mage::helper('medvslav_senddiscount')->__('Email'),
                'name'  => 'email',
            'required'  => true,
            'class' => 'required-entry',
			'disabled' => true,
           )
        );

        $fieldset->addField(
            'phone',
            'text',
            array(
                'label' => Mage::helper('medvslav_senddiscount')->__('Phone'),
                'name'  => 'phone',
            'required'  => true,
            'class' => 'required-entry',
			'disabled' => true,
           )
        );

        $fieldset->addField(
            'customerstatus',
            'select',
            array(
                'label' => Mage::helper('medvslav_senddiscount')->__('Customer Status'),
                'name'  => 'customerstatus',
            'required'  => true,
            'class' => 'required-entry',

            'values'=> Mage::getModel('medvslav_senddiscount/sdcustomer_attribute_source_customerstatus')->getAllOptions(true),
           )
        );
		
		
        $fieldset->addField(
            'sku',
            'hidden',
            array(
                'label' => Mage::helper('medvslav_senddiscount')->__('SKU'),
                'name'  => 'sku',
            'required'  => true,
            'class' => 'required-entry',
           )
        );

        $fieldset->addField(
            'product_id',
            'hidden',
            array(
                'label' => Mage::helper('medvslav_senddiscount')->__('Product ID'),
                'name'  => 'product_id',
            'required'  => true,
            'class' => 'required-entry',
           )
        );

        
        $formValues = Mage::registry('current_sdcustomer')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getSdcustomerData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getSdcustomerData());
            Mage::getSingleton('adminhtml/session')->setSdcustomerData(null);
        } elseif (Mage::registry('current_sdcustomer')) {
            $formValues = array_merge($formValues, Mage::registry('current_sdcustomer')->getData());
        }
		
		$fieldset->addType('my_field', 'Medvslav_Senddiscount_Block_Adminhtml_Sdcustomer_Edit_Tab_Field_Myfield');
		$fieldset->addField('label1', 'my_field', array(
          'label'     => Mage::helper('medvslav_senddiscount')->__('SKU'),
		  'sku'   => (isset($formValues['sku']) and !empty($formValues['sku'])) ? $formValues['sku'] : '',
		  'productid'   => (isset($formValues['product_id']) and !empty($formValues['product_id'])) ? $formValues['product_id'] : '',
        ));
		
		
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
