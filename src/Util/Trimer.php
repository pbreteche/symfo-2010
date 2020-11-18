<?php

namespace App\Util;

class Trimer
{

    private $charList;

    public function __construct(string $charList)
    {
        $this->charList = $charList;
    }

    public function trim(string $string)
    {
        return trim($string, $this->charList);
    }
}
