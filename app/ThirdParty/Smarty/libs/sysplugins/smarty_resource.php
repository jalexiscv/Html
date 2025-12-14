<?php

abstract class Smarty_Resource
{
    public static $sysplugins = array('file' => 'smarty_internal_resource_file.php', 'string' => 'smarty_internal_resource_string.php', 'extends' => 'smarty_internal_resource_extends.php', 'stream' => 'smarty_internal_resource_stream.php', 'eval' => 'smarty_internal_resource_eval.php', 'php' => 'smarty_internal_resource_php.php');
    public $uncompiled = false;
    public $recompiled = false;
    public $hasCompiledHandler = false;

    public static function getUniqueTemplateName($obj, $template_resource)
    {
        $smarty = $obj->_getSmartyObj();
        list($name, $type) = self::parseResourceName($template_resource, $smarty->default_resource_type);
        $resource = Smarty_Resource::load($smarty, $type);
        $_file_is_dotted = $name[0] === '.' && ($name[1] === '.' || $name[1] === '/');
        if ($obj->_isTplObj() && $_file_is_dotted && ($obj->source->type === 'file' || $obj->parent->source->type === 'extends')) {
            $name = $smarty->_realpath(dirname($obj->parent->source->filepath) . DIRECTORY_SEPARATOR . $name);
        }
        return $resource->buildUniqueResourceName($smarty, $name);
    }

    public static function parseResourceName($resource_name, $default_resource)
    {
        if (preg_match('/^([A-Za-z0-9_\-]{2,})[:]/', $resource_name, $match)) {
            $type = $match[1];
            $name = substr($resource_name, strlen($match[0]));
        } else {
            $type = $default_resource;
            $name = $resource_name;
        }
        return array($name, $type);
    }

    public static function load(Smarty $smarty, $type)
    {
        if (isset($smarty->_cache['resource_handlers'][$type])) {
            return $smarty->_cache['resource_handlers'][$type];
        }
        if (isset($smarty->registered_resources[$type])) {
            return $smarty->_cache['resource_handlers'][$type] = $smarty->registered_resources[$type];
        }
        if (isset(self::$sysplugins[$type])) {
            $_resource_class = 'Smarty_Internal_Resource_' . smarty_ucfirst_ascii($type);
            return $smarty->_cache['resource_handlers'][$type] = new $_resource_class();
        }
        $_resource_class = 'Smarty_Resource_' . smarty_ucfirst_ascii($type);
        if ($smarty->loadPlugin($_resource_class)) {
            if (class_exists($_resource_class, false)) {
                return $smarty->_cache['resource_handlers'][$type] = new $_resource_class();
            } else {
                $smarty->registerResource($type, array("smarty_resource_{$type}_source", "smarty_resource_{$type}_timestamp", "smarty_resource_{$type}_secure", "smarty_resource_{$type}_trusted"));
                return self::load($smarty, $type);
            }
        }
        $_known_stream = stream_get_wrappers();
        if (in_array($type, $_known_stream)) {
            if (is_object($smarty->security_policy)) {
                $smarty->security_policy->isTrustedStream($type);
            }
            return $smarty->_cache['resource_handlers'][$type] = new Smarty_Internal_Resource_Stream();
        }
        throw new SmartyException("Unknown resource type '{$type}'");
    }

    public function buildUniqueResourceName(Smarty $smarty, $resource_name, $isConfig = false)
    {
        if ($isConfig) {
            if (!isset($smarty->_joined_config_dir)) {
                $smarty->getTemplateDir(null, true);
            }
            return get_class($this) . '#' . $smarty->_joined_config_dir . '#' . $resource_name;
        } else {
            if (!isset($smarty->_joined_template_dir)) {
                $smarty->getTemplateDir();
            }
            return get_class($this) . '#' . $smarty->_joined_template_dir . '#' . $resource_name;
        }
    }

    public static function source(Smarty_Internal_Template $_template = null, Smarty $smarty = null, $template_resource = null)
    {
        return Smarty_Template_Source::load($_template, $smarty, $template_resource);
    }

    abstract public function getContent(Smarty_Template_Source $source);

    abstract public function populate(Smarty_Template_Source $source, Smarty_Internal_Template $_template = null);

    public function populateTimestamp(Smarty_Template_Source $source)
    {
    }

    public function getBasename(Smarty_Template_Source $source)
    {
        return basename(preg_replace('![^\w]+!', '_', $source->name));
    }

    public function checkTimestamps()
    {
        return true;
    }
}