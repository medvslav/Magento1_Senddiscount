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
 * ProductAlert unsubscribe controller
 *
 * @category   Medvslav
 * @package    Medvslav_Senddiscount
 * @author     Medved Yaroslav
 */
class Medvslav_Senddiscount_UnsubscribeController extends Mage_Core_Controller_Front_Action
{
     /**
     * init the customer for unsubscribing from email about discount
     *
     * @access public
     * 
     */
    public function preDispatch()
    {
        parent::preDispatch();
        
        if(isset($_GET['price']) and ((int)$this->getRequest()->getParam('price') !== 1)){
            if (!Mage::getSingleton('customer/session')->authenticate($this)) {
                $this->setFlag('', 'no-dispatch', true);
                if(!Mage::getSingleton('customer/session')->getBeforeUrl()) {
                    Mage::getSingleton('customer/session')->setBeforeUrl($this->_getRefererUrl());
                }
            }
        }
    }

     /**
     * action for unsubscribe customer for price change email of one product
     *
     * @access public
     * @author Medved Yaroslav
     */
    public function priceAction()
    {        
        $productId  = (int) $this->getRequest()->getParam('product');
        $email  = urldecode(trim(strip_tags($this->getRequest()->getParam('email'))));

        if (!$productId) {
            $this->_redirect('');
            return;
        }
        $session    = Mage::getSingleton('catalog/session');

        /* @var $session Mage_Catalog_Model_Session */
        $product = Mage::getModel('catalog/product')->load($productId);
        if (!$product->getId() || !$product->isVisibleInCatalog()) {
            /* @var $product Mage_Catalog_Model_Product */
            $session->addError($this->__('The product is not found.'));
            $this->_redirect('');
            return ;
        }
       
       try {
            $model  = Mage::getModel('medvslav_senddiscount/sdcustomer');
            $model = $model->getCdcustomerRow($email, $productId, Mage::app()->getStore()->getWebsiteId());
                        
            if (($model != false) and $model->getId()) {
                $model->delete();
                $session->addSuccess($this->__('The alert subscription has been deleted.'));
            }
            
        }
        catch (Exception $e) {
            $session->addException($e, $this->__('Unable to update the alert subscription.'));
        }
        $this->_redirectUrl($product->getProductUrl());
    }

     /**
     * action for unsubscribe customer for price change emails for all products
     *
     * @access public
     * @author Medved Yaroslav
     */
    public function priceAllAction()
    {
        $session = Mage::getSingleton("core/session");
        $email  = urldecode(trim(strip_tags($this->getRequest()->getParam('email'))));

        try {
            $collection  = Mage::getModel('medvslav_senddiscount/sdcustomer')
                ->getCollection()
                ->addFieldToFilter('email',$email);
            
                foreach ($collection as $model) {
                    $model->delete();
                }
                
            $session->addSuccess($this->__('You will no longer receive price alerts for this product.'));
        }
        catch (Exception $e) {
            $session->addException($e, $this->__('Unable to update the alert subscription.'));
        }
        $this->_redirect('');
    }

     /**
     * action for unsubscribe customer for appear in the stock email of one product
     *
     * @access public
     * @author Medved Yaroslav
     */
    public function stockAction()
    {
        $productId  = (int) $this->getRequest()->getParam('product');

        if (!$productId) {
            $this->_redirect('');
            return;
        }

        $session = Mage::getSingleton('catalog/session');
        /* @var $session Mage_Catalog_Model_Session */
        $product = Mage::getModel('catalog/product')->load($productId);
        /* @var $product Mage_Catalog_Model_Product */
        if (!$product->getId() || !$product->isVisibleInCatalog()) {
            Mage::getSingleton('customer/session')->addError($this->__('The product was not found.'));
            $this->_redirect('customer/account/');
            return ;
        }

        try {
            $model  = Mage::getModel('productalert/stock')
                ->setCustomerId(Mage::getSingleton('customer/session')->getCustomerId())
                ->setProductId($product->getId())
                ->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                ->loadByParam();
            if ($model->getId()) {
                $model->delete();
            }
            $session->addSuccess($this->__('You will no longer receive stock alerts for this product.'));
        }
        catch (Exception $e) {
            $session->addException($e, $this->__('Unable to update the alert subscription.'));
        }
        $this->_redirectUrl($product->getProductUrl());
    }

     /**
     * action for unsubscribe customer for appear in the stock emails for all products
     *
     * @access public
     * @author Medved Yaroslav
     */
    public function stockAllAction()
    {
        $session = Mage::getSingleton('customer/session');
        /* @var $session Mage_Customer_Model_Session */

        try {
            Mage::getModel('productalert/stock')->deleteCustomer(
                $session->getCustomerId(),
                Mage::app()->getStore()->getWebsiteId()
            );
            $session->addSuccess($this->__('You will no longer receive stock alerts.'));
        }
        catch (Exception $e) {
            $session->addException($e, $this->__('Unable to update the alert subscription.'));
        }
        $this->_redirect('customer/account/');
    }
}
