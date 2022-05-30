<?php

/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace AHT\Question\Model\ResourceModel\Question;

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

    public function whereProductSelect($productId)
    {
        $this->getSelect()
            ->where("entity_id = $productId");
        return $this;
    }
}
