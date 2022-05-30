<?php

namespace AHT\Question\Controller\Adminhtml\Question;

class MassDelete extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'AHT_Question::question_delete_answer';

    /**
     * @var \Magento\Framework\View\Result\RedirectFactory
     */
    protected $_redirectFactory;

    /**
     * @param \AHT\Question\Model\ResourceModel\Question\CollectionFactory
     */
    private $_collectionFactory;

    /**
     * @param \AHT\Question\Model\QuestionRepository
     */
    private $_questionRepository;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Backend\Model\View\Result\RedirectFactory $redirectFactory,
        \AHT\Question\Model\ResourceModel\Question\CollectionFactory $collectionFactory,
        \AHT\Question\Model\QuestionRepository $questionRepository
    ) {
        $this->_redirectFactory = $redirectFactory;
        $this->_collectionFactory = $collectionFactory;
        $this->_questionRepository = $questionRepository;
        return parent::__construct($context);
    }

    /**
     * delete action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->_redirectFactory->create();

        /** @var \AHT\Question\Model\ResourceModel\Question\Collection $CustomData */
        $CustomData = $this->_collectionFactory->create();
        foreach ($CustomData as $value) {
            $templateId[] = $value['id'];
        }

        // get id url
        $parameterData = $this->getRequest()->getParams('id');
        $selectedAppsid = $this->getRequest()->getParams('id');

        if (array_key_exists("selected", $parameterData)) {
            $selectedAppsid = $parameterData['selected'];
        }

        if (array_key_exists("excluded", $parameterData)) {
            if ($parameterData['excluded'] == 'false') {
                $selectedAppsid = $templateId;
            } else {
                $selectedAppsid = array_diff($templateId, $parameterData['excluded']);
            }
        }

        if (!is_array($selectedAppsid)) {
            $this->messageManager->addErrorMessage(__('Please select item(s).'));
        } else {
            try {
                // delete mass item
                foreach ($selectedAppsid as $id) {
                    $this->_questionRepository->deleteById($id);
                }
                $this->messageManager->addSuccessMessage(__('Total of %1 record(s) were successfully deleted.', count($selectedAppsid)));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }
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
