<?php
require_once 'cacheresource.pdo.php';

class Smarty_CacheResource_Pdo_Gzip extends Smarty_CacheResource_Pdo
{
    protected function inputContent($content)
    {
        return gzdeflate($content);
    }

    protected function outputContent($content)
    {
        return gzinflate($content);
    }
}