<?php

class Smarty_Internal_Runtime_Capture
{
    public $isPrivateExtension = true;
    private $captureStack = array();
    private $captureCount = 0;
    private $countStack = array();
    private $namedBuffer = array();
    private $isRegistered = false;

    public function open(Smarty_Internal_Template $_template, $buffer, $assign, $append)
    {
        if (!$this->isRegistered) {
            $this->register($_template);
        }
        $this->captureStack[] = array($buffer, $assign, $append);
        $this->captureCount++;
        ob_start();
    }

    private function register(Smarty_Internal_Template $_template)
    {
        $_template->startRenderCallbacks[] = array($this, 'startRender');
        $_template->endRenderCallbacks[] = array($this, 'endRender');
        $this->startRender($_template);
        $this->isRegistered = true;
    }

    public function startRender(Smarty_Internal_Template $_template)
    {
        $this->countStack[] = $this->captureCount;
        $this->captureCount = 0;
    }

    public function close(Smarty_Internal_Template $_template)
    {
        if ($this->captureCount) {
            list($buffer, $assign, $append) = array_pop($this->captureStack);
            $this->captureCount--;
            if (isset($assign)) {
                $_template->assign($assign, ob_get_contents());
            }
            if (isset($append)) {
                $_template->append($append, ob_get_contents());
            }
            $this->namedBuffer[$buffer] = ob_get_clean();
        } else {
            $this->error($_template);
        }
    }

    public function error(Smarty_Internal_Template $_template)
    {
        throw new SmartyException("Not matching {capture}{/capture} in '{$_template->template_resource}'");
    }

    public function getBuffer(Smarty_Internal_Template $_template, $name = null)
    {
        if (isset($name)) {
            return isset($this->namedBuffer[$name]) ? $this->namedBuffer[$name] : null;
        } else {
            return $this->namedBuffer;
        }
    }

    public function endRender(Smarty_Internal_Template $_template)
    {
        if ($this->captureCount) {
            $this->error($_template);
        } else {
            $this->captureCount = array_pop($this->countStack);
        }
    }
}