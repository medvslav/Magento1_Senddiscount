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
 * ProductAlert email price changed grid
 *
 * @category   Medvslav
 * @package    Medvslav_Senddiscount
 * @author      Medved Yaroslav
 */
class Medvslav_Senddiscount_Block_Email_Price extends Mage_ProductAlert_Block_Email_Abstract
{
    
     /**
     * Current Customer email
     *
     * @var string
     */
    protected $_email;
    
    /**
     * Constructor
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('email/productalert/price.phtml');
    }

    /**
     * Retrive unsubscribe url for product
     *
     * @param int $productId
     * @return string
     */
    public function getProductUnsubscribeUrl($productId)
    {
        $params = $this->_getUrlParams();
        $params['product'] = $productId;
        $params['email'] = $this->getEmail();
        $params['price'] = 1;
        return $this->getUrl('productalert/unsubscribe/price', $params);
    }

    /**
     * Retrieve unsubscribe url for all products
     *
     * @return string
     */
    public function getUnsubscribeUrl()
    {
        $params = $this->_getUrlParams();
        $params['email'] = $this->getEmail();
        $params['price'] = 1;
        return $this->getUrl('productalert/unsubscribe/priceAll', $params);
    }
    
    /**
     * Set email of customer
     *
     * @param string $email
     * 
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * Retrieve email of customer
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }
}
