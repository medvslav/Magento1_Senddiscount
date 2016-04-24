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
 * Customer for sending discount model
 *
 * @category    Medvslav
 * @package     Medvslav_Senddiscount
 * @author      Medved Yaroslav
 */
class Medvslav_Senddiscount_Model_Sdcustomer extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'medvslav_senddiscount_sdcustomer';
    const CACHE_TAG = 'medvslav_senddiscount_sdcustomer';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'medvslav_senddiscount_sdcustomer';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'sdcustomer';

    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Medved Yaroslav
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('medvslav_senddiscount/sdcustomer');
    }

    /**
     * before save customer for sending discount
     *
     * @access protected
     * @return Medvslav_Senddiscount_Model_Sdcustomer
     * @author Medved Yaroslav
     */
    protected function _beforeSave()
    {
        parent::_beforeSave();
        $now = Mage::getSingleton('core/date')->gmtDate();
        if ($this->isObjectNew()) {
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
        return $this;
    }

    /**
     * save customer for sending discount relation
     *
     * @access public
     * @return Medvslav_Senddiscount_Model_Sdcustomer
     * @author Medved Yaroslav
     */
    protected function _afterSave()
    {
        return parent::_afterSave();
    }

    /**
     * get default values
     *
     * @access public
     * @return array
     * @author Medved Yaroslav
     */
    public function getDefaultValues()
    {
        $values = array();
        $values['customerstatus'] = '1';

        return $values;
    }
 
     /**
     * get one row of model by customer email, product ID, wedsite ID
     *
     * @access public
     * @param string $email
     * @param int $productId
     * @param int $websiteId
     * @return Medvslav_Senddiscount_Model_Sdcustomer or false
     * @author Medved Yaroslav
     */
    public function getCdcustomerRow($email, $productId, $wedsiteId)    {
        
        $adapter = Mage::getSingleton('core/resource')->getConnection('core_read');
        if ($email && $productId && $wedsiteId) {
            $select = $adapter->select()
                ->from($this->getResource()->getTable('medvslav_senddiscount/sdcustomer'))
                ->where('email = :email')
                ->where('product_id  = :product_id')
                ->where('website_id  = :website_id');
            $bind = array(
                ':email'       => $email,
                ':product_id'  => $productId,
                ':website_id'  => $wedsiteId
            );
            $row = $adapter->fetchRow($select, $bind);
            if ($row) {
                $this->setData($row);
            }
            
            return $this;
        }
        return false;
    }
    
}
