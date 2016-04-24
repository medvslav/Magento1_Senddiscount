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
 * Contrller for subscription customer for price change of product
 *
 * @category    Medvslav
 * @package     Medvslav_Senddiscoun
 * @author      Medved Yaroslav
 */
class Medvslav_Senddiscount_indexController extends Mage_Core_Controller_Front_Action
{

    /**
      * default action
      *
      * @access public
      * @return void
      * @author Medved Yaroslav
      */
    public function saveAction()
    {
        if ($this->getRequest()->isPost()) {
            $data_raw = $this->getRequest()->getPost();
            
            $data = array();
            //filtering POST-data
            foreach($data_raw as $data_key=>$data_value){
                $data[$data_key]=trim(strip_tags($data_value));
            }
            
            $errors = array();            
            //make server side validators
            $validatorChain_str = new Zend_Validate();            
            $validatorChain_str->addValidator(new Zend_Validate_NotEmpty())
                           ->addValidator(new Zend_Validate_Alpha());
            
            $validatorChain_phone = new Zend_Validate();
            $validatorChain_phone->addValidator(new Zend_Validate_Digits());
            
            $validatorChain_email = new Zend_Validate();
            $validatorChain_email->addValidator(new Zend_Validate_NotEmpty())
                           ->addValidator(new Zend_Validate_EmailAddress());
            
            $validatorChain_productid = new Zend_Validate();
            $validatorChain_productid->addValidator(new Zend_Validate_NotEmpty())
                           ->addValidator(new Zend_Validate_Digits());

            //make server side validation data
            if (!$validatorChain_str->isValid($data['first_name']) 
                 or !$validatorChain_str->isValid($data['surname'])
                 or !$validatorChain_email->isValid($data['email'])
                 or (!$validatorChain_phone->isValid($data['phone']) and !empty($data['phone'])) 
                 or !$validatorChain_productid->isValid($data['product_id'])
                 ) {
                foreach ($validatorChain_str->getMessages() as $message) {
                    $errors[] = "$message";
                }
                foreach ($validatorChain_email->getMessages() as $message) {
                    $errors[] = "$message";
                }
                foreach ($validatorChain_phone->getMessages() as $message) {
                    $errors[] = "$message";
                }
                foreach ($validatorChain_productid->getMessages() as $message) {
                    $errors[] = "$message";
                }
                
            }
            
            //check if customer have already subscribed for this products
            $collection_count = Mage::getModel('medvslav_senddiscount/sdcustomer')
                                     ->getCollection()
                                     ->addFieldToFilter('email',$data['email'])
                                     ->addFieldToFilter('product_id',$data['product_id'])
                                     ->count();
            
            if($collection_count > 0){
                $errors[] = Mage::helper('medvslav_senddiscount')->__('You have already subscribed for this products.');
            }
            
            $result = array();
            if(count($errors)>0){
               $result['errors'] = $errors;
               $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
               return;
            }
            
            if (!isset($result['errors'])) {
                try{
                    //check if customer registered with this email
                    $website_id = Mage::app()->getStore()->getWebsiteId();
                    $customer = Mage::getModel('customer/customer');           
                    $customer->setWebsiteId($website_id);                    
                    $customer->loadByEmail($data['email']);
                    
                    $price = 0;
                    $sku = '';
                    $customer_registered = 0;
                    $customer_id = 0;
                    if ($customer->getId()) {//if sustomer registered                        
                        $customer_registered = 1;
                        $customer_id = $customer->getId();                        
                        $product = Mage::getModel('catalog/product')
                                    ->setCustomerGroupId($customer->getGroupId())
                                    ->load($data['product_id']); 
                    }else{
                        $product = Mage::getModel('catalog/product')->load($data['product_id']);                        
                    }
                    
                    if ($product->getId()) {
                        $price = $product->getFinalPrice();
                        $sku = $product->getSku(); 
                    }
                    
                    
                    //enter data of customer
                    $data['customer_registered'] = $customer_registered;
                    $data['customer_id'] = $customer_id;
                    $data['price'] = $price;
                    $data['sku'] = $sku;
                    $data['website_id'] = $website_id;
                    $data['customer_ip'] = Mage::helper('core/http')->getRemoteAddr();
                    $data['customerstatus'] = 1;
                    
                    $sdcustomer    = Mage::getModel('medvslav_senddiscount/sdcustomer');
                    $sdcustomer->addData($data);				
                    $sdcustomer->save();
                    
                    $textBlock = strip_tags(Mage::app()->getLayout()->createBlock('cms/block')->setBlockId('block_senddiscount')->toHtml());
                    $result['success'] = array('Yes',Mage::helper('medvslav_senddiscount')->__($textBlock));
                    $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
                    return;
                }catch (Mage_Core_Exception $e) {
                    $result['errors'] = array($e->getMessage());
                    $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
                    return;
                } catch (Exception $e) {
                    $result['errors'] = array($e->getMessage());
                    $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
                    return;
                }
            }

            
        }else{
            $result['errors'] = array(Mage::helper('medvslav_senddiscount')->__('There was a problem saving the customer for sending discount.'));
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
        }
    }

 
}
