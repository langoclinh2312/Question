<?php

namespace AHT\Question\Ui\Component\Listing\Column;

class ListOptionForm implements \Magento\Framework\Option\ArrayInterface
{
    protected $_questionFactory;
    protected $_loadedData;

    public function toOptionArray()
    {
        $questions = array(
            "1"  => array(
                'values' => 'approve'
            ),
            "2"  => array(
                'values' => 'deny'
            )
        );
        $optionArray = [];
        foreach ($questions as $question) {
            array_push($optionArray, [
                'value'  => $question['values'],
                'label'  => $question['values']
            ]);
        }
        return $optionArray;
    }
}
