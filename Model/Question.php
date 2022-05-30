<?php

/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace AHT\Question\Model;

use AHT\Question\Api\Data\QuestionInterface;
use AHT\Question\Api\Data\QuestionInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;

class Question extends \Magento\Framework\Model\AbstractModel implements QuestionInterface
{

    protected $QuestionDataFactory;

    protected $dataObjectHelper;

    protected $_eventPrefix = 'aht_question';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param QuestionInterfaceFactory $QuestionDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \AHT\Question\Model\ResourceModel\Question $resource
     * @param \AHT\Question\Model\ResourceModel\Question\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        QuestionInterfaceFactory $questionDataFactory,
        DataObjectHelper $dataObjectHelper,
        \AHT\Question\Model\ResourceModel\Question $resource,
        \AHT\Question\Model\ResourceModel\Question\Collection $resourceCollection,
        array $data = []
    ) {
        $this->_questionDataFactory = $questionDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve Question model with Question data
     * @return QuestionInterface
     */
    public function getDataModel()
    {
        $questionData = $this->getData();

        $questionDataObject = $this->_questionDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $questionDataObject,
            $questionData,
            QuestionInterface::class
        );

        return $questionDataObject;
    }
}
