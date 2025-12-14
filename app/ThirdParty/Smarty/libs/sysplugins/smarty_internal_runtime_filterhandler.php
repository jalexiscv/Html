<?php

class Smarty_Internal_Runtime_FilterHandler
{
    public function runFilter($type, $content, Smarty_Internal_Template $template)
    {
        if (!empty($template->smarty->autoload_filters[$type])) {
            foreach ((array)$template->smarty->autoload_filters[$type] as $name) {
                $plugin_name = "Smarty_{$type}filter_{$name}";
                if (function_exists($plugin_name)) {
                    $callback = $plugin_name;
                } elseif (class_exists($plugin_name, false) && is_callable(array($plugin_name, 'execute'))) {
                    $callback = array($plugin_name, 'execute');
                } elseif ($template->smarty->loadPlugin($plugin_name, false)) {
                    if (function_exists($plugin_name)) {
                        $callback = $plugin_name;
                    } elseif (class_exists($plugin_name, false) && is_callable(array($plugin_name, 'execute'))) {
                        $callback = array($plugin_name, 'execute');
                    } else {
                        throw new SmartyException("Auto load {$type}-filter plugin method '{$plugin_name}::execute' not callable");
                    }
                } else {
                    throw new SmartyException("Unable to auto load {$type}-filter plugin '{$plugin_name}'");
                }
                $content = call_user_func($callback, $content, $template);
            }
        }
        if (!empty($template->smarty->registered_filters[$type])) {
            foreach ($template->smarty->registered_filters[$type] as $key => $name) {
                $content = call_user_func($template->smarty->registered_filters[$type][$key], $content, $template);
            }
        }
        return $content;
    }
}