<?php

namespace AHT\Question\Block;

class Form extends \Magento\Framework\View\Element\Template
{

    /**
     * @param \Magento\Catalog\Api\ProductRepositoryInterface
     */
    private $productRepository;


    /**
     * @var array
     */
    protected $jsLayout;

    /**
     * @param \Magento\Customer\Model\Session
     */
    private $_customerSession;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Customer\Model\Session $customerSession,
        array $data = []
    ) {
        $this->productRepository = $productRepository;
        $this->_customerSession = $customerSession;
        parent::__construct($context, $data);
        $this->setTemplate('AHT_Question::form.phtml');
    }

    /**
     * Get question product post action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->getUrl(
            'question/product/post',
            [
                '_secure' => $this->getRequest()->isSecure(),
                'id' => $this->getProductId(),
            ]
        );
    }

    /**
     * Get product info
     *
     * @return \Magento\Catalog\Api\Data\ProductInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductInfo()
    {
        return $this->productRepository->getById(
            $this->getProductId(),
            false,
            $this->_storeManager->getStore()->getId()
        );
    }

    /**
     * Get question product id
     *
     * @return int
     */
    protected function getProductId()
    {
        return $this->getRequest()->getParam('id', false);
    }

    /**
     * Get data customer
     *
     */
    public function getDataCustomer()
    {
        if ($this->_customerSession->isLoggedIn()) {
            echo '123';
        } else {
            echo '456';
        }
    }
}
