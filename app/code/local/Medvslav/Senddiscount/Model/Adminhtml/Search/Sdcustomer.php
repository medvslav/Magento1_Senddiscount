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
 * Admin search model
 *
 * @category    Medvslav
 * @package     Medvslav_Senddiscount
 * @author      Medved Yaroslav
 */
class Medvslav_Senddiscount_Model_Adminhtml_Search_Sdcustomer extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return Medvslav_Senddiscount_Model_Adminhtml_Search_Sdcustomer
     * @author Medved Yaroslav
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('medvslav_senddiscount/sdcustomer_collection')
            ->addFieldToFilter('email', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $sdcustomer) {
            $arr[] = array(
                'id'          => 'sdcustomer/1/'.$sdcustomer->getId(),
                'type'        => Mage::helper('medvslav_senddiscount')->__('Customer for sending discount'),
                'name'        => $sdcustomer->getEmail(),
                'description' => $sdcustomer->getEmail(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/senddiscount_sdcustomer/edit',
                    array('id'=>$sdcustomer->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
