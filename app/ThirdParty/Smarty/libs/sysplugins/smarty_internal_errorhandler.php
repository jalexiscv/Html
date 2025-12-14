<?php

class Smarty_Internal_ErrorHandler
{
    public $allowUndefinedVars = true;
    public $allowUndefinedArrayKeys = true;
    public $allowDereferencingNonObjects = true;
    private $previousErrorHandler = null;

    public function activate()
    {
        $this->previousErrorHandler = set_error_handler([$this, 'handleError']);
    }

    public function deactivate()
    {
        restore_error_handler();
        $this->previousErrorHandler = null;
    }

    public function handleError($errno, $errstr, $errfile, $errline, $errcontext = [])
    {
        if ($this->allowUndefinedVars && preg_match('/^(Attempt to read property "value" on null|Trying to get property (\'value\' )?of non-object)/', $errstr)) {
            return;
        }
        if ($this->allowUndefinedArrayKeys && preg_match('/^(Undefined index|Undefined array key|Trying to access array offset on value of type)/', $errstr)) {
            return;
        }
        if ($this->allowDereferencingNonObjects && preg_match('/^Attempt to read property ".+?" on/', $errstr)) {
            return;
        }
        return $this->previousErrorHandler ? call_user_func($this->previousErrorHandler, $errno, $errstr, $errfile, $errline, $errcontext) : false;
    }
}