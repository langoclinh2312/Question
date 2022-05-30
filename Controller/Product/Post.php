<?php

/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace AHT\Question\Controller\Product;

class Post extends \Magento\Framework\App\Action\Action
{

    protected $_resultPageFactory;

    /**
     * @param \AHT\Question\Model\QuestionFactory
     */
    private $_questionFactory;

    /**
     * @param \AHT\Question\Model\QuestionRepository
     */
    private $_questionRepository;

    /**
     * @param \Magento\Backend\Model\View\Result\RedirectFactory
     */
    private $_redirectFactory;

    /**
     * @param \Magento\Framework\Session\Generic
     */
    private $generic;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \AHT\Question\Model\QuestionFactory $questionFactory,
        \AHT\Question\Model\QuestionRepository $questionRepository,
        \Magento\Backend\Model\View\Result\RedirectFactory $redirectFactory,
        \Magento\Framework\Session\Generic $generic
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_questionFactory = $questionFactory;
        $this->_questionRepository = $questionRepository;
        $this->_redirectFactory = $redirectFactory;
        $this->generic = $generic;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $requests = ($this->_request->getPostValue());
        extract($requests);
        $questions = $this->_questionFactory->create();

        $questions->setName($name);
        $questions->setEmail($email);
        $questions->setQuestion($question);
        $questions->setEntity_id($entity_id);

        if ($this->_questionRepository->save($questions)) {
            $this->messageManager->addSuccessMessage(__('We post your questions success.'));
        } else {
            $this->messageManager->addErrorMessage(__('We can\'t post your questions right now.'));
        }
        $redirectUrl = $this->generic->getRedirectUrl(true);
        $resultRedirect = $this->_redirectFactory->create();
        $resultRedirect->setUrl($redirectUrl ?: $this->_redirect->getRedirectUrl());
        return $resultRedirect;
    }
}
