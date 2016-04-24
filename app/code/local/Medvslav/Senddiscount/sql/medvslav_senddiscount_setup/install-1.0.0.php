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
 * Senddiscount module install script
 *
 * @category    Medvslav
 * @package     Medvslav_Senddiscount
 * @author      Medved Yaroslav
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('medvslav_senddiscount/sdcustomer'))
    ->addColumn(
        'entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
        ), 'Customer for sending discount ID'
    )
    ->addColumn(
        'customer_registered', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default' => '0',
        ), 'If customer registered in the store')
    ->addColumn(
        'customer_ip', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false,
        ), 'Customer IP'
    )
    ->addColumn(
        'first_name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false,
        ), 'First name'
    )
    ->addColumn(
        'surname', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false,
        ), 'Surname'
    )
    ->addColumn(
        'email', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false,
        ), 'Email'
    )
    ->addColumn(
        'phone', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false,
        ), 'Phone'
    )
    ->addColumn(
        'customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => true,
        'default' => '0',
        ), 'Customer id')
    ->addColumn(
        'sku', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false,
        ), 'SKU'
    )
    ->addColumn(
        'product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable' => false,
        'unsigned' => true,
        ), 'Product ID'
    )
    ->addColumn(
        'price', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable' => false,
        'default' => '0.0000',
        ), 'Price amount')
    ->addColumn(
        'website_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default' => '0',
        ), 'Website id')
    ->addColumn(
        'last_send_date', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(),'Product alert last send date')
    ->addColumn(
        'send_count', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default' => '0',
        ), 'Product alert send count')
    ->addColumn(
        'customerstatus', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable' => false,
        ), 'Customer Status'
    )
    ->addColumn(
        'updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Customer for sending discount Modification Time'
    )
    ->addColumn(
        'created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Customer for sending discount Creation Time'
    )
    ->addIndex(
        $this->getIdxName(
            'medvslav_senddiscount/sdcustomer', array('customer_id')
        ), array('customer_id'))
    ->addIndex(
        $this->getIdxName(
            'medvslav_senddiscount/sdcustomer', array('email')
        ), array('email'))
    ->addIndex(
        $this->getIdxName(
            'medvslav_senddiscount/sdcustomer', array('product_id')
        ), array('product_id')
    )
    ->addIndex(
        $this->getIdxName(
            'medvslav_senddiscount/sdcustomer', array('website_id')
        ), array('website_id')
    )
    ->addForeignKey(
        $this->getFkName('medvslav_senddiscount/sdcustomer', 'product_id', 'catalog/product', 'entity_id'), 'product_id', $this->getTable('catalog/product'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    //->addForeignKey(
    //    $this->getFkName('medvslav_senddiscount/sdcustomer', 'customer_id', 'customer/entity', 'entity_id'), 'customer_id', $this->getTable('customer/entity'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
    //)
    ->addForeignKey(
        $this->getFkName('medvslav_senddiscount/sdcustomer', 'website_id', 'core/website', 'website_id'), 'website_id', $this->getTable('core/website'), 'website_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->setComment('Customer for sending discount Table');
$this->getConnection()->createTable($table);
$this->endSetup();
