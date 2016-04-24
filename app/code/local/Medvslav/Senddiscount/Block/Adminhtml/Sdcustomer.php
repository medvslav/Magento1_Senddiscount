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
 * Customer for sending discount admin block
 *
 * @category    Medvslav
 * @package     Medvslav_Senddiscount
 * @author      Medved Yaroslav
 */
class Medvslav_Senddiscount_Block_Adminhtml_Sdcustomer extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_sdcustomer';
        $this->_blockGroup         = 'medvslav_senddiscount';
        parent::__construct();
        $this->_headerText         = Mage::helper('medvslav_senddiscount')->__('Customer for sending discount');
        //$this->_updateButton('add', 'label', Mage::helper('medvslav_senddiscount')->__('Add Customer for sending discount'));
		$this->_removeButton('add');

    }
}
