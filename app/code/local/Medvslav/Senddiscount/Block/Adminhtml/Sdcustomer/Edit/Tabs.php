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
 * Customer for sending discount admin edit tabs
 *
 * @category    Medvslav
 * @package     Medvslav_Senddiscount
 * @author      Medved Yaroslav
 */
class Medvslav_Senddiscount_Block_Adminhtml_Sdcustomer_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     *
     * @access public
     * @author Medved Yaroslav
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('sdcustomer_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('medvslav_senddiscount')->__('Customer for sending discount'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return Medvslav_Senddiscount_Block_Adminhtml_Sdcustomer_Edit_Tabs
     * @author Medved Yaroslav
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_sdcustomer',
            array(
                'label'   => Mage::helper('medvslav_senddiscount')->__('Customer for sending discount'),
                'title'   => Mage::helper('medvslav_senddiscount')->__('Customer for sending discount'),
                'content' => $this->getLayout()->createBlock(
                    'medvslav_senddiscount/adminhtml_sdcustomer_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve customer for sending discount entity
     *
     * @access public
     * @return Medvslav_Senddiscount_Model_Sdcustomer
     * @author Medved Yaroslav
     */
    public function getSdcustomer()
    {
        return Mage::registry('current_sdcustomer');
    }
}
