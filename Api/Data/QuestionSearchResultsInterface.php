<?php

/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace AHT\Question\Api\Data;

interface QuestionSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get question list.
     * @return \AHT\Question\Api\Data\QuestionInterface[]
     */
    public function getItems();

    /**
     * Set question list.
     * @param \AHT\Question\Api\Data\QuestionInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
