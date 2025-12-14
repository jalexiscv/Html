<?php

use Higgs\Validation\Exceptions\ValidationException;
use Config\Services;

if (!function_exists('form_open')) {
    function form_open(string $action = '', $attributes = [], array $hidden = []): string
    {
        if (!$action) {
            $action = current_url(true);
        } elseif (strpos($action, '://') === false) {
            if (strpos($action, '{locale}') !== false) {
                $action = str_replace('{locale}', Services::request()->getLocale(), $action);
            }
            $action = site_url($action);
        }
        if (is_array($attributes) && array_key_exists('csrf_id', $attributes)) {
            $csrfId = $attributes['csrf_id'];
            unset($attributes['csrf_id']);
        }
        $attributes = stringify_attributes($attributes);
        if (stripos($attributes, 'method=') === false) {
            $attributes .= ' method="post"';
        }
        if (stripos($attributes, 'accept-charset=') === false) {
            $config = config('App');
            $attributes .= ' accept-charset="' . strtolower($config->charset) . '"';
        }
        $form = '<form action="' . $action . '"' . $attributes . ">\n";
        $before = Services::filters()->getFilters()['before'];
        if ((in_array('csrf', $before, true) || array_key_exists('csrf', $before)) && strpos($action, base_url()) !== false && !stripos($form, 'method="get"')) {
            $form .= csrf_field($csrfId ?? null);
        }
        foreach ($hidden as $name => $value) {
            $form .= form_hidden($name, $value);
        }
        return $form;
    }
}
if (!function_exists('form_open_multipart')) {
    function form_open_multipart(string $action = '', $attributes = [], array $hidden = []): string
    {
        if (is_string($attributes)) {
            $attributes .= ' enctype="' . esc('multipart/form-data') . '"';
        } else {
            $attributes['enctype'] = 'multipart/form-data';
        }
        return form_open($action, $attributes, $hidden);
    }
}
if (!function_exists('form_hidden')) {
    function form_hidden($name, $value = '', bool $recursing = false): string
    {
        static $form;
        if ($recursing === false) {
            $form = "\n";
        }
        if (is_array($name)) {
            foreach ($name as $key => $val) {
                form_hidden($key, $val, true);
            }
            return $form;
        }
        if (!is_array($value)) {
            $form .= form_input($name, $value, '', 'hidden');
        } else {
            foreach ($value as $k => $v) {
                $k = is_int($k) ? '' : $k;
                form_hidden($name . '[' . $k . ']', $v, true);
            }
        }
        return $form;
    }
}
if (!function_exists('form_input')) {
    function form_input($data = '', string $value = '', $extra = '', string $type = 'text'): string
    {
        $defaults = ['type' => $type, 'name' => is_array($data) ? '' : $data, 'value' => $value,];
        return '<input ' . parse_form_attributes($data, $defaults) . stringify_attributes($extra) . _solidus() . ">\n";
    }
}
if (!function_exists('form_password')) {
    function form_password($data = '', string $value = '', $extra = ''): string
    {
        if (!is_array($data)) {
            $data = ['name' => $data];
        }
        $data['type'] = 'password';
        return form_input($data, $value, $extra);
    }
}
if (!function_exists('form_upload')) {
    function form_upload($data = '', string $value = '', $extra = ''): string
    {
        $defaults = ['type' => 'file', 'name' => '',];
        if (!is_array($data)) {
            $data = ['name' => $data];
        }
        $data['type'] = 'file';
        return '<input ' . parse_form_attributes($data, $defaults) . stringify_attributes($extra) . _solidus() . ">\n";
    }
}
if (!function_exists('form_textarea')) {
    function form_textarea($data = '', string $value = '', $extra = ''): string
    {
        $defaults = ['name' => is_array($data) ? '' : $data, 'cols' => '40', 'rows' => '10',];
        if (!is_array($data) || !isset($data['value'])) {
            $val = $value;
        } else {
            $val = $data['value'];
            unset($data['value']);
        }
        if ((is_array($extra) && array_key_exists('rows', $extra)) || (is_string($extra) && stripos(preg_replace('/\s+/', '', $extra), 'rows=') !== false)) {
            unset($defaults['rows']);
        }
        if ((is_array($extra) && array_key_exists('cols', $extra)) || (is_string($extra) && stripos(preg_replace('/\s+/', '', $extra), 'cols=') !== false)) {
            unset($defaults['cols']);
        }
        return '<textarea ' . rtrim(parse_form_attributes($data, $defaults)) . stringify_attributes($extra) . '>' . htmlspecialchars($val) . "</textarea>\n";
    }
}
if (!function_exists('form_multiselect')) {
    function form_multiselect($name = '', array $options = [], array $selected = [], $extra = ''): string
    {
        $extra = stringify_attributes($extra);
        if (stripos($extra, 'multiple') === false) {
            $extra .= ' multiple="multiple"';
        }
        return form_dropdown($name, $options, $selected, $extra);
    }
}
if (!function_exists('form_dropdown')) {
    function form_dropdown($data = '', $options = [], $selected = [], $extra = ''): string
    {
        $defaults = [];
        if (is_array($data)) {
            if (isset($data['selected'])) {
                $selected = $data['selected'];
                unset($data['selected']);
            }
            if (isset($data['options'])) {
                $options = $data['options'];
                unset($data['options']);
            }
        } else {
            $defaults = ['name' => $data];
        }
        if (!is_array($selected)) {
            $selected = [$selected];
        }
        if (!is_array($options)) {
            $options = [$options];
        }
        if (empty($selected)) {
            if (is_array($data)) {
                if (isset($data['name'], $_POST[$data['name']])) {
                    $selected = [$_POST[$data['name']]];
                }
            } elseif (isset($_POST[$data])) {
                $selected = [$_POST[$data]];
            }
        }
        foreach ($selected as $key => $item) {
            $selected[$key] = (string)$item;
        }
        $extra = stringify_attributes($extra);
        $multiple = (count($selected) > 1 && stripos($extra, 'multiple') === false) ? ' multiple="multiple"' : '';
        $form = '<select ' . rtrim(parse_form_attributes($data, $defaults)) . $extra . $multiple . ">\n";
        foreach ($options as $key => $val) {
            $key = (string)$key;
            if (is_array($val)) {
                if (empty($val)) {
                    continue;
                }
                $form .= '<optgroup label="' . $key . "\">\n";
                foreach ($val as $optgroupKey => $optgroupVal) {
                    $optgroupKey = (string)$optgroupKey;
                    $sel = in_array($optgroupKey, $selected, true) ? ' selected="selected"' : '';
                    $form .= '<option value="' . htmlspecialchars($optgroupKey) . '"' . $sel . '>' . $optgroupVal . "</option>\n";
                }
                $form .= "</optgroup>\n";
            } else {
                $form .= '<option value="' . htmlspecialchars($key) . '"' . (in_array($key, $selected, true) ? ' selected="selected"' : '') . '>' . $val . "</option>\n";
            }
        }
        return $form . "</select>\n";
    }
}
if (!function_exists('form_checkbox')) {
    function form_checkbox($data = '', string $value = '', bool $checked = false, $extra = ''): string
    {
        $defaults = ['type' => 'checkbox', 'name' => (!is_array($data) ? $data : ''), 'value' => $value,];
        if (is_array($data) && array_key_exists('checked', $data)) {
            $checked = $data['checked'];
            if ($checked === false) {
                unset($data['checked']);
            } else {
                $data['checked'] = 'checked';
            }
        }
        if ($checked === true) {
            $defaults['checked'] = 'checked';
        }
        return '<input ' . parse_form_attributes($data, $defaults) . stringify_attributes($extra) . _solidus() . ">\n";
    }
}
if (!function_exists('form_radio')) {
    function form_radio($data = '', string $value = '', bool $checked = false, $extra = ''): string
    {
        if (!is_array($data)) {
            $data = ['name' => $data];
        }
        $data['type'] = 'radio';
        return form_checkbox($data, $value, $checked, $extra);
    }
}
if (!function_exists('form_submit')) {
    function form_submit($data = '', string $value = '', $extra = ''): string
    {
        return form_input($data, $value, $extra, 'submit');
    }
}
if (!function_exists('form_reset')) {
    function form_reset($data = '', string $value = '', $extra = ''): string
    {
        return form_input($data, $value, $extra, 'reset');
    }
}
if (!function_exists('form_button')) {
    function form_button($data = '', string $content = '', $extra = ''): string
    {
        $defaults = ['name' => is_array($data) ? '' : $data, 'type' => 'button',];
        if (is_array($data) && isset($data['content'])) {
            $content = $data['content'];
            unset($data['content']);
        }
        return '<button ' . parse_form_attributes($data, $defaults) . stringify_attributes($extra) . '>' . $content . "</button>\n";
    }
}
if (!function_exists('form_label')) {
    function form_label(string $labelText = '', string $id = '', array $attributes = []): string
    {
        $label = '<label';
        if ($id !== '') {
            $label .= ' for="' . $id . '"';
        }
        if (is_array($attributes) && $attributes) {
            foreach ($attributes as $key => $val) {
                $label .= ' ' . $key . '="' . $val . '"';
            }
        }
        return $label . '>' . $labelText . '</label>';
    }
}
if (!function_exists('form_datalist')) {
    function form_datalist(string $name, string $value, array $options): string
    {
        $data = ['type' => 'text', 'name' => $name, 'list' => $name . '_list', 'value' => $value,];
        $out = form_input($data) . "\n";
        $out .= "<datalist id='" . $name . "_list'>";
        foreach ($options as $option) {
            $out .= "<option value='{$option}'>\n";
        }
        return $out . ("</datalist>\n");
    }
}
if (!function_exists('form_fieldset')) {
    function form_fieldset(string $legendText = '', array $attributes = []): string
    {
        $fieldset = '<fieldset' . stringify_attributes($attributes) . ">\n";
        if ($legendText !== '') {
            return $fieldset . '<legend>' . $legendText . "</legend>\n";
        }
        return $fieldset;
    }
}
if (!function_exists('form_fieldset_close')) {
    function form_fieldset_close(string $extra = ''): string
    {
        return '</fieldset>' . $extra;
    }
}
if (!function_exists('form_close')) {
    function form_close(string $extra = ''): string
    {
        return '</form>' . $extra;
    }
}
if (!function_exists('set_value')) {
    function set_value(string $field, $default = '', bool $htmlEscape = true)
    {
        $request = Services::request();
        $value = $request->getOldInput($field);
        if ($value === null) {
            $value = $request->getPost($field) ?? $default;
        }
        return ($htmlEscape) ? esc($value) : $value;
    }
}
if (!function_exists('set_select')) {
    function set_select(string $field, string $value = '', bool $default = false): string
    {
        $request = Services::request();
        $input = $request->getOldInput($field);
        if ($input === null) {
            $input = $request->getPost($field);
        }
        if ($input === null) {
            return ($default === true) ? ' selected="selected"' : '';
        }
        if (is_array($input)) {
            foreach ($input as &$v) {
                if ($value === $v) {
                    return ' selected="selected"';
                }
            }
            return '';
        }
        return ($input === $value) ? ' selected="selected"' : '';
    }
}
if (!function_exists('set_checkbox')) {
    function set_checkbox(string $field, string $value = '', bool $default = false): string
    {
        $request = Services::request();
        $input = $request->getOldInput($field);
        if ($input === null) {
            $input = $request->getPost($field);
        }
        if (is_array($input)) {
            foreach ($input as &$v) {
                if ($value === $v) {
                    return ' checked="checked"';
                }
            }
            return '';
        }
        if ((string)$input === '0' || !empty($request->getPost()) || !empty(old($field))) {
            return ($input === $value) ? ' checked="checked"' : '';
        }
        return ($default === true) ? ' checked="checked"' : '';
    }
}
if (!function_exists('set_radio')) {
    function set_radio(string $field, string $value = '', bool $default = false): string
    {
        $request = Services::request();
        $oldInput = $request->getOldInput($field);
        $postInput = $request->getPost($field);
        if ($oldInput !== null) {
            $input = $oldInput;
        } elseif ($postInput !== null) {
            $input = $postInput;
        } else {
            $input = $default;
        }
        if (is_array($input)) {
            foreach ($input as $v) {
                if ($value === $v) {
                    return ' checked="checked"';
                }
            }
            return '';
        }
        if ($oldInput !== null || $postInput !== null) {
            return ((string)$input === $value) ? ' checked="checked"' : '';
        }
        return ($default === true) ? ' checked="checked"' : '';
    }
}
if (!function_exists('validation_errors')) {
    function validation_errors()
    {
        session();
        if (isset($_SESSION['_ci_validation_errors']) && (ENVIRONMENT === 'testing' || !is_cli())) {
            return $_SESSION['_ci_validation_errors'];
        }
        $validation = Services::validation();
        return $validation->getErrors();
    }
}
if (!function_exists('validation_list_errors')) {
    function validation_list_errors(string $template = 'list'): string
    {
        $config = config('Validation');
        $view = Services::renderer();
        if (!array_key_exists($template, $config->templates)) {
            throw ValidationException::forInvalidTemplate($template);
        }
        return $view->setVar('errors', validation_errors())->render($config->templates[$template]);
    }
}
if (!function_exists('validation_show_error')) {
    function validation_show_error(string $field, string $template = 'single'): string
    {
        $config = config('Validation');
        $view = Services::renderer();
        $errors = validation_errors();
        if (!array_key_exists($field, $errors)) {
            return '';
        }
        if (!array_key_exists($template, $config->templates)) {
            throw ValidationException::forInvalidTemplate($template);
        }
        return $view->setVar('error', $errors[$field])->render($config->templates[$template]);
    }
}
if (!function_exists('parse_form_attributes')) {
    function parse_form_attributes($attributes, array $default): string
    {
        if (is_array($attributes)) {
            foreach (array_keys($default) as $key) {
                if (isset($attributes[$key])) {
                    $default[$key] = $attributes[$key];
                    unset($attributes[$key]);
                }
            }
            if (!empty($attributes)) {
                $default = array_merge($default, $attributes);
            }
        }
        $att = '';
        foreach ($default as $key => $val) {
            if (!is_bool($val)) {
                if ($key === 'value') {
                    $val = esc($val);
                } elseif ($key === 'name' && !strlen($default['name'])) {
                    continue;
                }
                $att .= $key . '="' . $val . '"' . ($key === array_key_last($default) ? '' : ' ');
            } else {
                $att .= $key . ' ';
            }
        }
        return $att;
    }
}