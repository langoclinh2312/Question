<?php

namespace AHT\Question\Model\ResourceModel\Question\Grid;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \AHT\Question\Model\Question::class,
            \AHT\Question\Model\ResourceModel\Question::class
        );
    }
}
