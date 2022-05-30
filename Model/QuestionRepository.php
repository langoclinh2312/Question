<?php

/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace AHT\Question\Model;

use AHT\Question\Model\QuestionFactory;
use AHT\Question\Api\Data\QuestionSearchResultsInterfaceFactory;

use AHT\Question\Model\ResourceModel\Question as ResourceQuestion;
use AHT\Question\Model\ResourceModel\Question\CollectionFactory as QuestionCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class QuestionRepository
{

    /**
     * @var ResourceQuestion
     */
    protected $resource;

    /**
     * @var QuestionCollectionFactory
     */
    protected $_questionCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var QuestionFactory
     */
    protected $_questionFactory;

    /**
     * @var Question
     */
    protected $searchResultsFactory;


    /**
     * @param \AHT\Question\Model\ResourceModel\Question\Collection
     */
    private $_collection;

    /**
     * @param ResourceQuestion $resource
     * @param QuestionFactory $_questionFactory
     * @param QuestionCollectionFactory $_questionCollectionFactory
     * @param QuestionSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceQuestion $resource,
        QuestionFactory $questionFactory,
        QuestionCollectionFactory $questionCollectionFactory,
        QuestionSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor,
        \AHT\Question\Model\ResourceModel\Question\Collection $collection
    ) {
        $this->resource = $resource;
        $this->_questionFactory = $questionFactory;
        $this->_questionCollectionFactory = $questionCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->_collection = $collection;
    }

    /**
     * @inheritDoc
     */
    public function save(\Magento\Framework\Model\AbstractModel $question)
    {
        try {
            $this->resource->save($question);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the Question: %1',
                $exception->getMessage()
            ));
        }
        return $question;
    }


    /**
     * @inheritDoc
     */
    public function get($questionId)
    {
        $question = $this->_questionFactory->create();
        $this->resource->load($question, $questionId);
        if (!$question->getId()) {
            throw new NoSuchEntityException(__('Question with id "%1" does not exist.', $questionId));
        }
        return $question;
    }

    /**
     * get data with product id
     */
    public function getProductId($productId)
    {
        $question = $this->_collection->whereProductSelect($productId);
        return $question;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->_questionCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(Question $question)
    {
        try {
            $questionModel = $this->_questionFactory->create();
            $this->resource->load($questionModel, $question->getId());
            $this->resource->delete($questionModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Question: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($questionId)
    {
        return $this->delete($this->get($questionId));
    }
}
