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
 * Customer for sending discount admin edit form
 *
 * @category    Medvslav
 * @package     Medvslav_Senddiscount
 * @author      Medved Yaroslav
 */
class Medvslav_Senddiscount_Block_Adminhtml_Sdcustomer_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Medved Yaroslav
     */
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'medvslav_senddiscount';
        $this->_controller = 'adminhtml_sdcustomer';
        $this->_updateButton(
            'save',
            'label',
            Mage::helper('medvslav_senddiscount')->__('Save Customer for sending discount')
        );
        $this->_updateButton(
            'delete',
            'label',
            Mage::helper('medvslav_senddiscount')->__('Delete Customer for sending discount')
        );
        $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('medvslav_senddiscount')->__('Save And Continue Edit'),
                'onclick' => 'saveAndContinueEdit()',
                'class'   => 'save',
            ),
            -100
        );
        $this->_formScripts[] = "
            function saveAndContinueEdit() {
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * get the edit form header
     *
     * @access public
     * @return string
     * @author Medved Yaroslav
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_sdcustomer') && Mage::registry('current_sdcustomer')->getId()) {
            return Mage::helper('medvslav_senddiscount')->__(
                "Edit Customer for sending discount '%s'",
                $this->escapeHtml(Mage::registry('current_sdcustomer')->getEmail())
            );
        } else {
            return Mage::helper('medvslav_senddiscount')->__('Add Customer for sending discount');
        }
    }
}
