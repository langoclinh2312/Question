<?php

/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace AHT\Question\Api\Data;

interface QuestionInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const QUESTION = 'aht_question';
    const QUESTION_ID = 'id';
}
