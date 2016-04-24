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


/**
 * Senddiscount observer
 *
 * @category   Medvslav
 * @package    Medvslav_Senddiscount
 * @author     Medved Yaroslav
 */
class Medvslav_Senddiscount_Model_Observer extends Mage_ProductAlert_Model_Observer
{
    /**
     * Error email template configuration
     */
    const XML_PATH_ERROR_TEMPLATE   = 'catalog/productalert_cron/error_email_template';

    /**
     * Error email identity configuration
     */
    const XML_PATH_ERROR_IDENTITY   = 'catalog/productalert_cron/error_email_identity';

    /**
     * 'Send error emails to' configuration
     */
    const XML_PATH_ERROR_RECIPIENT  = 'catalog/productalert_cron/error_email';

    /**
     * Allow price alert
     *
     */
    const XML_PATH_PRICE_ALLOW      = 'catalog/productalert/allow_price';

    /**
     * Allow stock alert
     *
     */
    const XML_PATH_STOCK_ALLOW      = 'catalog/productalert/allow_stock';

    /**
     * Website collection array
     *
     * @var array
     */
    protected $_websites;

    /**
     * Warning (exception) errors array
     *
     * @var array
     */
    protected $_errors = array();


    /**
     * Process price emails
     *
     * @param Mage_ProductAlert_Model_Email $email
     * @return Mage_ProductAlert_Model_Observer
     */
    protected function _processPrice(Mage_ProductAlert_Model_Email $email)
    {
        $email->setType('price');
        foreach ($this->_getWebsites() as $website) {
            /* @var $website Mage_Core_Model_Website */

            if (!$website->getDefaultGroup() || !$website->getDefaultGroup()->getDefaultStore()) {
                continue;
            }
            if (!Mage::getStoreConfig(
                self::XML_PATH_PRICE_ALLOW,
                $website->getDefaultGroup()->getDefaultStore()->getId()
            )) {
                continue;
            }
            try {
                $collection = Mage::getModel('medvslav_senddiscount/sdcustomer')
                    ->getCollection()
                    ->addFieldToFilter('customerstatus',1)
                    ->addFieldToFilter('website_id',$website->getId());
            }
            catch (Exception $e) {
                $this->_errors[] = $e->getMessage();
                return $this;
            }

            $previousCustomer = null;
            $email->setWebsite($website);
            foreach ($collection as $sdcustomer) {
                try {
                    if (!$previousCustomer || $previousCustomer->getId() != $sdcustomer->getCustomerId()) {
                        if($sdcustomer->getCustomerRegistered() == 1){
                            $customer = Mage::getModel('customer/customer')->load($sdcustomer->getCustomerId());
                        }else{
                            $customer = $sdcustomer;
                        }
                        
                        if ($previousCustomer) {
                            $email->send();
                        }
                        
                        if (!$customer) {
                            continue;
                        }
                        $previousCustomer = $customer;
                        $email->clean();
                        $email->setCustomer($customer);
                    }
                    else {
                        $customer = $previousCustomer;
                    }

                    $product = Mage::getModel('catalog/product')
                        ->setStoreId($website->getDefaultStore()->getId())
                        ->load($sdcustomer->getProductId());
                    if (!$product) {
                        continue;
                    }
                    
                    if($sdcustomer->getCustomerRegistered() == 1){
                        $product->setCustomerGroupId($customer->getGroupId());
                    }
                    
                    if ($sdcustomer->getPrice() > $product->getFinalPrice()) {
                        $productPrice = $product->getFinalPrice();
                        $product->setFinalPrice(Mage::helper('tax')->getPrice($product, $productPrice));
                        $product->setPrice(Mage::helper('tax')->getPrice($product, $product->getPrice()));
                        $email->addPriceProduct($product);

                        $sdcustomer->setPrice($productPrice);
                        $sdcustomer->setLastSendDate(Mage::getModel('core/date')->gmtDate());
                        $sdcustomer->setSendCount($sdcustomer->getSendCount() + 1);
                        $sdcustomer->setCustomerstatus(2);
                        $sdcustomer->save();
                    }
                }
                catch (Exception $e) {
                    $this->_errors[] = $e->getMessage();
                }
            }
            if ($previousCustomer) {
                try {
                    $email->send();
                }
                catch (Exception $e) {
                    $this->_errors[] = $e->getMessage();
                }
            }
        }
        return $this;
    }


}
