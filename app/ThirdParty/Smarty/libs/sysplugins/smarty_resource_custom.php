<?php

abstract class Smarty_Resource_Custom extends Smarty_Resource
{
    public function populate(Smarty_Template_Source $source, Smarty_Internal_Template $_template = null)
    {
        $source->filepath = $source->type . ':' . $this->generateSafeName($source->name);
        $source->uid = sha1($source->type . ':' . $source->name);
        $mtime = $this->fetchTimestamp($source->name);
        if ($mtime !== null) {
            $source->timestamp = $mtime;
        } else {
            $this->fetch($source->name, $content, $timestamp);
            $source->timestamp = isset($timestamp) ? $timestamp : false;
            if (isset($content)) {
                $source->content = $content;
            }
        }
        $source->exists = !!$source->timestamp;
    }

    private function generateSafeName($name): string
    {
        return substr(preg_replace('/[^A-Za-z0-9._]/', '', (string)$name), 0, 127);
    }

    protected function fetchTimestamp($name)
    {
        return null;
    }

    abstract protected function fetch($name, &$source, &$mtime);

    public function getContent(Smarty_Template_Source $source)
    {
        $this->fetch($source->name, $content, $timestamp);
        if (isset($content)) {
            return $content;
        }
        throw new SmartyException("Unable to read template {$source->type} '{$source->name}'");
    }

    public function getBasename(Smarty_Template_Source $source)
    {
        return basename($this->generateSafeName($source->name));
    }
}