<?php

/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace AHT\Question\Controller\Adminhtml\Question;

class DeleteAnswer extends \AHT\Question\Controller\Adminhtml\Question
{

    const ADMIN_RESOURCE = 'AHT_Question::question_delete_answer';

    /**
     * @param \Magento\Backend\Model\View\Result\RedirectFactory
     */
    private $_resultRedirectFactory;

    /**
     * @param \AHT\Question\Model\QuestionRepository
     */
    private $_questionRepository;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory,
        \AHT\Question\Model\QuestionRepository $questionRepository
    ) {
        $this->_resultRedirectFactory = $resultRedirectFactory;
        $this->_questionRepository = $questionRepository;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->_resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $this->_questionRepository->deleteById($id);
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Question.'));
                // go to grid
                return $resultRedirect->setPath('*/index/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/answer', ['id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Question to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/index/');
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
