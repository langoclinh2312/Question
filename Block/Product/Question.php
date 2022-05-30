<?php

namespace AHT\Question\Block\Product;

class Question extends \Magento\Framework\View\Element\Template
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @param \AHT\Question\Model\QuestionRepository
     */
    private $_questionRepository;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Magento\Framework\View\Element\Template\Context $context,
        \AHT\Question\Model\QuestionRepository $questionRepository,
        array $data = []
    ) {
        $this->_questionRepository = $questionRepository;
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);

        $this->setTabTitle();
    }

    /**
     * Get current product id
     *
     * @return null|int
     */
    public function getProductId()
    {
        $product = $this->_coreRegistry->registry('product');
        return $product ? $product->getId() : null;
    }

    /**
     * Get data  product id
     *
     * @return $data
     */
    public function getQuestionProductId()
    {
        $product = $this->_coreRegistry->registry('product');
        if ($product->getId()) {
            $data = $this->_questionRepository->getProductId($product->getId());
            if (!empty($data)) {
                return $data;
            } else {
                return "Question with product id " . $product->getId() . " does not exist.";
            }
        }
    }

    /**
     * Set tab title
     *
     * @return void
     */
    public function setTabTitle()
    {
        $title = $this->getCollectionSize()
            ? __('Questions %1', '<span class="counter">' . $this->getCollectionSize() . '</span>')
            : __('Questions');
        $this->setTitle($title);
    }

    /**
     * Get size of question collection
     *
     * @return int
     */
    public function getCollectionSize()
    {
        // $collection = $this->_reviewsColFactory->create()->addStoreFilter(
        //     $this->_storeManager->getStore()->getId()
        // )->addStatusFilter(
        //     \Magento\Review\Model\Review::STATUS_APPROVED
        // )->addEntityFilter(
        //     'product',
        //     $this->getProductId()
        // );

        // return $collection->getSize();
    }
}
