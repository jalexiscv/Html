<?php

class Smarty_Internal_ParseTree_Text extends Smarty_Internal_ParseTree
{
    private $toBeStripped = false;

    public function __construct($data, $toBeStripped = false)
    {
        $this->data = $data;
        $this->toBeStripped = $toBeStripped;
    }

    public function isToBeStripped()
    {
        return $this->toBeStripped;
    }

    public function to_smarty_php(Smarty_Internal_Templateparser $parser)
    {
        return $this->data;
    }
}