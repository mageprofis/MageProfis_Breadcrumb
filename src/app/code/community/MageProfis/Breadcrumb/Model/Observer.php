<?php

class MageProfis_Breadcrumb_Model_Observer
extends Mage_Core_Model_Abstract
{
    /**
     * @mageEvent catalog_controller_product_init
     * @param $event Varien_Object
     */
    public function onProductInitEvent($event)
    {
        if (!Mage::registry('current_category'))
        {
            $product = $event->getProduct();
            /* @var $product Mage_Catalog_Model_Product */
            $this->setCategory($product);
            Mage::dispatchEvent('mp_breadcrumb_after', array(
                'product'    => $product,
                'model'      => $this
            ));
        }
    }    

    /**
     * get Root Category Id
     * 
     * @return int
     */
    public function getRootCategoryId()
    {
        return (int) Mage::app()->getStore()->getRootCategoryId();
    }

    /**
     * get Root Category Path for Collection
     * 
     * with caching Model!
     * 
     * @return string
     */
    public function getRootCategoryPath()
    {
        $cache = $this->getCacheModel()->load($this->getCacheRootPathKey());
        if ($cache && Mage::app()->useCache('config'))
        {
            return $cache;
        }
        $category = Mage::getModel('catalog/category')->load($this->getRootCategoryId());
        /* @var $category Mage_Catalog_Model_Category */
        $path = $category->getPath();
        $tags = array(
            'config',
            'store'
        );
        // 604800 = 1 week
        $this->getCacheModel()->save($path, $this->getCacheRootPathKey(), $tags, 604800);
        return $path;
    }

    /**
     * 
     * @param Mage_Catalog_Model_Product $product
     */
    public function setCategory($product)
    {
        $collection = Mage::getModel('catalog/category')->getCollection()
                ->addAttributeToFilter('entity_id', array('in' => $product->getCategoryIds()))
                ->addAttributeToFilter('path', array('like' => $this->getRootCategoryPath().'/%'))
                ->addAttributeToFilter('is_active', 1)
                ->addOrder('include_in_menu', Varien_Data_Collection_Db::SORT_ORDER_DESC)
                ->addOrder('level', Varien_Data_Collection_Db::SORT_ORDER_DESC)
        ;
        if (!$product->getSkipEvent())
        {
            Mage::dispatchEvent('mp_breadcrumb_category_collection', array(
                'product'    => $product,
                'collection' => $collection
            ));
        }
        $categoryIds = $collection->getAllIds();
        if (count($categoryIds))
        {
            $id = array_shift($categoryIds);
            unset($categoryIds);
            if ($product->canBeShowInCategory($id)) {
                $category = Mage::getModel('catalog/category')->load($id);
                /* @var $category Mage_Catalog_Model_Category */
                Mage::register('current_category', $category);
                $product->canBeShowInCategory($category->getId());
            }
        }
    }


    /**
     * @return Zend_Cache_Core
     */
    protected function getCacheModel()
    {
        return Mage::app()->getCache();
    }

    /**
     * 
     * @return string
     */
    public function getCacheRootPathKey()
    {
        $key = array(
            Mage::app()->getStore()->getStoreId(),
            Mage::app()->getStore()->getWebsiteId(),
            'rootpath',
        );
        return implode('_', $key);
    }
}