<?php

namespace BroSolutions\CustomOffer\Model\ResourceModel\Offer;

/**
 * Class Collection
 *
 * @package BroSolutions\CustomOffer\Model\ResourceModel\Offer
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'offer_id';

    /**
     * @inheritdoc
     */
    protected function _construct() //@codingStandardsIgnoreLine
    {
        $this->_init(\BroSolutions\CustomOffer\Model\Offer::class,
            \BroSolutions\CustomOffer\Model\ResourceModel\Offer::class);
    }


//    protected function _initSelect()
//    {
//        parent::_initSelect();
//
//        $this->getSelect()->joinLeft(
//            ['secondTable' => $this->getTable('catalog_product_entity')], //2nd table name by which you want to join mail table
//            'main_table.product_id = secondTable.entity_id', // common column which available in both table
//        'sku' // '*' define that you want all column of 2nd table. if you want some particular column then you can define as ['column1','column2']
//        );
//    }

    public function _initSelect()
    {
        parent::_initSelect();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $productPriceAttributeId = $objectManager->create('Magento\Eav\Model\Config')
            ->getAttribute(\Magento\Catalog\Model\Product::ENTITY, \Magento\Catalog\Api\Data\ProductInterface::PRICE)
            ->getAttributeId();
        $this->getSelect()->joinLeft(
            ['product_decimal' => $this->getTable('catalog_product_entity_decimal')],
            "main_table.product_id = product_decimal.entity_id AND product_decimal.attribute_id = $productPriceAttributeId",
            [])
            ->columns(['product_price' => 'product_decimal.value']);

        $productStatusAttributeId = $objectManager
            ->create('Magento\Eav\Model\Config')
            ->getAttribute(\Magento\Catalog\Model\Product::ENTITY, \Magento\Catalog\Api\Data\ProductInterface::STATUS)
            ->getAttributeId();
        $this->getSelect()->joinLeft(
            ['product_int' => $this->getTable('catalog_product_entity_int')],
            "main_table.product_id = product_int.entity_id AND product_int.attribute_id = $productStatusAttributeId",
            []
        )->columns(['product_status' => 'product_int.value']);

        $this->getSelect()->joinLeft(
            ['product_entity' => $this->getTable('catalog_product_entity')],
            "main_table.product_id = product_entity.entity_id",
            []
        )->columns(['product_sku' => 'product_entity.sku']);

        $this->getSelect()->joinLeft(
            ['product_var' => $this->getTable('catalog_product_entity_varchar')],
            "main_table.product_id = product_var.entity_id AND product_var.attribute_id = 73",
            []
        )->columns(['product_name' => 'product_var.value']);

        $this->getSelect()->joinLeft(
            ['product_img' => $this->getTable('catalog_product_entity_varchar')],
            "main_table.product_id = product_img.entity_id AND product_img.attribute_id = 89",
            []
        )->columns(['product_image' => 'product_img.value']);

        $this->getSelect()->joinLeft(
            ['product_qty' => $this->getTable('cataloginventory_stock_item')],
            "main_table.product_id = product_qty.product_id",
            []
        )->columns(['product_qty' => 'product_qty.qty']);

//        $this->getSelect()->joinLeft(
//            ['coupon' => $this->getTable('salesrule_coupon')],
//            "main_table.product_id",
//            []
//        )->columns(['coupon' => 'coupon.code']);

        $this->getSelect()->columns(['price_difference' => "(((product_decimal.value - main_table.your_price) / product_decimal.value) * 100)"]);

        return $this;

    }
}
