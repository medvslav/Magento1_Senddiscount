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
 * @copyright      Copyright (c) 2015
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
 /*
 * @category    Medvslav
 * @package     Medvslav_Senddiscount
 * @author      Medved Yaroslav
 */



if(Mage::getModel('cms/block')->load('block_senddiscount', 'identifier')){    
    Mage::getModel('cms/block')->load('block_senddiscount', 'identifier')->delete();
}

$content = 'We are going to send you an email or give a call when this product will be discounted';

$block = Mage::getModel('cms/block');
$block->setTitle('For the message of module "Send Discount"');
$block->setIdentifier('block_senddiscount');
$block->setStores(array(0));
$block->setIsActive(1);
$block->setContent($content);
$block->save();