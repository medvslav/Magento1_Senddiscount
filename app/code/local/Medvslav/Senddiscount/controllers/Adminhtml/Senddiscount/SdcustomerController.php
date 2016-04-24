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
 * Customer for sending discount admin controller
 *
 * @category    Medvslav
 * @package     Medvslav_Senddiscount
 * @author      Medved Yaroslav
 */
class Medvslav_Senddiscount_Adminhtml_Senddiscount_SdcustomerController extends Medvslav_Senddiscount_Controller_Adminhtml_Senddiscount
{
    /**
     * init the customer for sending discount
     *
     * @access protected
     * @return Medvslav_Senddiscount_Model_Sdcustomer
     */
    protected function _initSdcustomer()
    {
        $sdcustomerId  = (int) $this->getRequest()->getParam('id');
        $sdcustomer    = Mage::getModel('medvslav_senddiscount/sdcustomer');
        if ($sdcustomerId) {
            $sdcustomer->load($sdcustomerId);
        }
		//Mage::unregister('current_sdcustomer');
        Mage::register('current_sdcustomer', $sdcustomer);
        return $sdcustomer;
    }

    /**
     * default action
     *
     * @access public
     * @return void
     * @author Medved Yaroslav
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_title(Mage::helper('medvslav_senddiscount')->__('Potential Customer'))
             ->_title(Mage::helper('medvslav_senddiscount')->__('Customers for sending discount'));
        $this->renderLayout();
    }

    /**
     * grid action
     *
     * @access public
     * @return void
     * @author Medved Yaroslav
     */
    public function gridAction()
    {
        $this->loadLayout()->renderLayout();
    }

    /**
     * edit customer for sending discount - action
     *
     * @access public
     * @return void
     * @author Medved Yaroslav
     */
    public function editAction()
    {
        $sdcustomerId    = $this->getRequest()->getParam('id');
        $sdcustomer      = $this->_initSdcustomer();
        if ($sdcustomerId && !$sdcustomer->getId()) {
            $this->_getSession()->addError(
                Mage::helper('medvslav_senddiscount')->__('This customer for sending discount no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getSdcustomerData(true);
        if (!empty($data)) {
            $sdcustomer->setData($data);
        }
        Mage::register('sdcustomer_data', $sdcustomer);
        $this->loadLayout();
        $this->_title(Mage::helper('medvslav_senddiscount')->__('Potential Customer'))
             ->_title(Mage::helper('medvslav_senddiscount')->__('Customers for sending discount'));
        if ($sdcustomer->getId()) {
            $this->_title($sdcustomer->getEmail());
        } else {
            $this->_title(Mage::helper('medvslav_senddiscount')->__('Add customer for sending discount'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new customer for sending discount action
     *
     * @access public
     * @return void
     * @author Medved Yaroslav
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * save customer for sending discount - action
     *
     * @access public
     * @return void
     * @author Medved Yaroslav
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('sdcustomer')) {
			
            try {
                $sdcustomer = $this->_initSdcustomer();				
                $sdcustomer->addData($data);				
                $sdcustomer->save();
				
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('medvslav_senddiscount')->__('Customer for sending discount was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $sdcustomer->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setSdcustomerData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('medvslav_senddiscount')->__('There was a problem saving the customer for sending discount.')
                );
                Mage::getSingleton('adminhtml/session')->setSdcustomerData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('medvslav_senddiscount')->__('Unable to find customer for sending discount to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete customer for sending discount - action
     *
     * @access public
     * @return void
     * @author Medved Yaroslav
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $sdcustomer = Mage::getModel('medvslav_senddiscount/sdcustomer');
                $sdcustomer->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('medvslav_senddiscount')->__('Customer for sending discount was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('medvslav_senddiscount')->__('There was an error deleting customer for sending discount.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('medvslav_senddiscount')->__('Could not find customer for sending discount to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete customer for sending discount - action
     *
     * @access public
     * @return void
     * @author Medved Yaroslav
     */
    public function massDeleteAction()
    {
        $sdcustomerIds = $this->getRequest()->getParam('sdcustomer');
        if (!is_array($sdcustomerIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('medvslav_senddiscount')->__('Please select customers for sending discount to delete.')
            );
        } else {
            try {
                foreach ($sdcustomerIds as $sdcustomerId) {
                    $sdcustomer = Mage::getModel('medvslav_senddiscount/sdcustomer');
                    $sdcustomer->setId($sdcustomerId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('medvslav_senddiscount')->__('Total of %d customers for sending discount were successfully deleted.', count($sdcustomerIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('medvslav_senddiscount')->__('There was an error deleting customers for sending discount.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }



    /**
     * mass Customer Status change - action
     *
     * @access public
     * @return void
     * @author Medved Yaroslav
     */
    public function massCustomerstatusAction()
    {
        $sdcustomerIds = $this->getRequest()->getParam('sdcustomer');
        if (!is_array($sdcustomerIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('medvslav_senddiscount')->__('Please select customers for sending discount.')
            );
        } else {
            try {
                foreach ($sdcustomerIds as $sdcustomerId) {
                $sdcustomer = Mage::getSingleton('medvslav_senddiscount/sdcustomer')->load($sdcustomerId)
                    ->setCustomerstatus($this->getRequest()->getParam('flag_customerstatus'))
                    ->setIsMassupdate(true)
                    ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d customers for sending discount were successfully updated.', count($sdcustomerIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('medvslav_senddiscount')->__('There was an error updating customers for sending discount.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * export as csv - action
     *
     * @access public
     * @return void
     * @author Medved Yaroslav
     */
    public function exportCsvAction()
    {
        $fileName   = 'sdcustomer.csv';
        $content    = $this->getLayout()->createBlock('medvslav_senddiscount/adminhtml_sdcustomer_grid')
            ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as MsExcel - action
     *
     * @access public
     * @return void
     * @author Medved Yaroslav
     */
    public function exportExcelAction()
    {
        $fileName   = 'sdcustomer.xls';
        $content    = $this->getLayout()->createBlock('medvslav_senddiscount/adminhtml_sdcustomer_grid')
            ->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as xml - action
     *
     * @access public
     * @return void
     * @author Medved Yaroslav
     */
    public function exportXmlAction()
    {
        $fileName   = 'sdcustomer.xml';
        $content    = $this->getLayout()->createBlock('medvslav_senddiscount/adminhtml_sdcustomer_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Check if admin has permissions to visit related pages
     *
     * @access protected
     * @return boolean
     * @author Medved Yaroslav
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('sales/medvslav_senddiscount/sdcustomer');
    }
}
