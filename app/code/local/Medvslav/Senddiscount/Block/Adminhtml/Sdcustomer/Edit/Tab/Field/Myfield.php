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
class Medvslav_Senddiscount_Block_Adminhtml_Sdcustomer_Edit_Tab_Field_Myfield extends Varien_Data_Form_Element_Abstract{
     
    /**
     * Initialize my field
     *
     * @access public
     * @author Medved Yaroslav
     */
    public function __construct($attributes=array())
    {
        parent::__construct($attributes);
    }
    
     /**
     * get my element html
     *
     * @access public
     * @return string
     * @author Medved Yaroslav
     */
    public function getElementHtml()
    {
        $sku = $this->getSku();
        $product_id = $this->getProductid();
        $html = '<a href="'.Mage::helper('adminhtml')->getUrl('adminhtml/catalog_product/edit', array('id' => $product_id)).'">'.$sku.'</a>';        
        
        return $html;
    }
}
