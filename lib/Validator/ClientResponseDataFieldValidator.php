<?php

namespace DCG\Cinema\Validator;

class ClientResponseDataFieldValidator
{
    /**
     * @param array $data
     * @param string[] $expectedDataFields
     * @return bool
     */
    public function validate(array $data, array $expectedDataFields)
    {
        foreach ($expectedDataFields as $expectedField) {
            if (!array_key_exists($expectedField, $data)) {
                return false;
            }
        }
        return true;
    }
}
