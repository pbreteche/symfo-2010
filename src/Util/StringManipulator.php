<?php

namespace App\Util;

class StringManipulator
{
    public function cleanUserInput(string $input)
    {
        return trim($input);
    }
}
