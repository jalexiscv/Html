<?php

class Smarty_Internal_ParseTree_Tag extends Smarty_Internal_ParseTree
{
    public $saved_block_nesting;

    public function __construct(Smarty_Internal_Templateparser $parser, $data)
    {
        $this->data = $data;
        $this->saved_block_nesting = $parser->block_nesting_level;
    }

    public function to_smarty_php(Smarty_Internal_Templateparser $parser)
    {
        return $this->data;
    }

    public function assign_to_var(Smarty_Internal_Templateparser $parser)
    {
        $var = $parser->compiler->getNewPrefixVariable();
        $tmp = $parser->compiler->appendCode('<?php ob_start();?>', $this->data);
        $tmp = $parser->compiler->appendCode($tmp, "<?php {$var}=ob_get_clean();?>");
        $parser->compiler->prefix_code[] = sprintf('%s', $tmp);
        return $var;
    }
}