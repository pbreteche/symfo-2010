<?php

namespace App\Util;

class StringManipulator
{

    private $trimer;

    public function __construct(Trimer $trimer)
    {
        $this->trimer = $trimer;
    }

    public function cleanUserInput(string $input)
    {
        return $this->trimer->trim($input);
    }
}
