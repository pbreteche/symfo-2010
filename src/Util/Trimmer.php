<?php

namespace App\Util;

class Trimmer implements TrimmerInterface
{

    private $charList;

    public function __construct(string $charList)
    {
        $this->charList = $charList;
    }

    public function trim(string $string): string
    {
        return trim($string, $this->charList);
    }
}
