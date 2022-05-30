<?php

/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace AHT\Question\Block\Widget;

class Question extends \Magento\Framework\View\Element\Template
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @param \AHT\Question\Model\ResourceModel\Question\CollectionFactory
     */
    private $_collection;

    /**
     * @param Magento\Catalog\Api\ProductRepositoryInterface
     */
    private $_productRepository;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Magento\Framework\View\Element\Template\Context $context,
        \AHT\Question\Model\ResourceModel\Question\CollectionFactory $collection,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        array $data = []
    ) {
        $this->_collection = $collection;
        $this->_productRepository = $productRepository;
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Get data question
     *
     *a
     */
    public function getList()
    {

        return $this->_collection->create();
    }

    /**
     * Get current product id
     *
     * @return null|string
     */
    public function getProductName($productId)
    {
        $product = $this->_productRepository->getById($productId);
        return $product->getName();
    }
}
