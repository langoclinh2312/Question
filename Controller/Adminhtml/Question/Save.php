<?php

/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace AHT\Question\Controller\Adminhtml\Question;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'AHT_Question::question_answer';

    protected $_dataPersistor;

    /**
     * @param \Magento\Backend\Model\View\Result\RedirectFactory
     */
    private $_resultRedirectFactory;

    /**
     * @param \AHT\Question\Model\QuestionFactory
     */
    private $_questionFactory;

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
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory,
        \AHT\Question\Model\QuestionFactory $questionFactory,
        \AHT\Question\Model\QuestionRepository $questionRepository
    ) {
        $this->_dataPersistor = $dataPersistor;
        $this->_resultRedirectFactory = $resultRedirectFactory;
        $this->_questionFactory = $questionFactory;
        $this->_questionRepository = $questionRepository;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->_resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            /** @var \AHT\Question\Model\Question $model */
            $model = $this->_questionFactory->create();
            $model->setData($data);

            try {
                $this->_questionRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the Answer.'));
                $this->_dataPersistor->clear('aht_question');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/answer', ['id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/index/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Answer.'));
            }

            $this->_dataPersistor->set('aht_question', $data);
            return $resultRedirect->setPath('*/*/answer', ['id' => $model->getId()]);
        }
        return $resultRedirect->setPath('*/index/');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(static::ADMIN_RESOURCE);
    }
}
