<?php

namespace AHT\Question\Controller\Adminhtml\Question;

class Answer extends \AHT\Question\Controller\Adminhtml\Question
{
    const ADMIN_RESOURCE = 'AHT_Question::question_answer';

    const PAGE_TITLE = 'Answer the Question';

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    ) {
        $this->_pageFactory = $pageFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        // Build form
        /** @var \Magento\Backend\Model\View\Result\Page $_PageFactory */
        $resultPage = $this->_pageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(__('Answer the Question'), __('Answer the Question'));
        $resultPage->getConfig()->getTitle()->prepend(__('Answer'));
        $resultPage->getConfig()->getTitle()->prepend(__('Answer the Question'));
        return $resultPage;
    }

    /**
     * Is the user allowed to view the page.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(static::ADMIN_RESOURCE);
    }
}
