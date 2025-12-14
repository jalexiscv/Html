<?php
function smarty_function_html_select_date($params, Smarty_Internal_Template $template)
{
    $template->_checkPlugins(array(array('function' => 'smarty_function_escape_special_chars', 'file' => SMARTY_PLUGINS_DIR . 'shared.escape_special_chars.php')));
    static $_month_timestamps = null;
    static $_current_year = null;
    if ($_month_timestamps === null) {
        $_current_year = date('Y');
        $_month_timestamps = array();
        for ($i = 1; $i <= 12; $i++) {
            $_month_timestamps[$i] = mktime(0, 0, 0, $i, 1, 2000);
        }
    }
    $prefix = 'Date_';
    $start_year = null;
    $end_year = null;
    $display_days = true;
    $display_months = true;
    $display_years = true;
    $month_format = '%B';
    $month_value_format = '%m';
    $day_format = '%02d';
    $day_value_format = '%d';
    $year_as_text = false;
    $reverse_years = false;
    $field_array = null;
    $day_size = null;
    $month_size = null;
    $year_size = null;
    $all_extra = null;
    $day_extra = null;
    $month_extra = null;
    $year_extra = null;
    $field_order = 'MDY';
    $field_separator = "\n";
    $option_separator = "\n";
    $time = null;
    $extra_attrs = '';
    $all_id = null;
    $day_id = null;
    $month_id = null;
    $year_id = null;
    foreach ($params as $_key => $_value) {
        switch ($_key) {
            case 'time':
                $$_key = $_value;
                break;
            case 'month_names':
                if (is_array($_value) && count($_value) === 12) {
                    $$_key = $_value;
                } else {
                    trigger_error('html_select_date: month_names must be an array of 12 strings', E_USER_NOTICE);
                }
                break;
            case 'prefix':
            case 'field_array':
            case 'start_year':
            case 'end_year':
            case 'day_format':
            case 'day_value_format':
            case 'month_format':
            case 'month_value_format':
            case 'day_size':
            case 'month_size':
            case 'year_size':
            case 'all_extra':
            case 'day_extra':
            case 'month_extra':
            case 'year_extra':
            case 'field_order':
            case 'field_separator':
            case 'option_separator':
            case 'all_empty':
            case 'month_empty':
            case 'day_empty':
            case 'year_empty':
            case 'all_id':
            case 'month_id':
            case 'day_id':
            case 'year_id':
                $$_key = (string)$_value;
                break;
            case 'display_days':
            case 'display_months':
            case 'display_years':
            case 'year_as_text':
            case 'reverse_years':
                $$_key = (bool)$_value;
                break;
            default:
                if (!is_array($_value)) {
                    $extra_attrs .= ' ' . $_key . '="' . smarty_function_escape_special_chars($_value) . '"';
                } else {
                    trigger_error("html_select_date: extra attribute '{$_key}' cannot be an array", E_USER_NOTICE);
                }
                break;
        }
    }
    if (isset($time) && is_array($time)) {
        if (isset($time[$prefix . 'Year'])) {
            foreach (['Y' => 'Year', 'm' => 'Month', 'd' => 'Day'] as $_elementKey => $_elementName) {
                $_variableName = '_' . strtolower($_elementName);
                $$_variableName = isset($time[$prefix . $_elementName]) ? $time[$prefix . $_elementName] : date($_elementKey);
            }
        } elseif (isset($time[$field_array][$prefix . 'Year'])) {
            foreach (['Y' => 'Year', 'm' => 'Month', 'd' => 'Day'] as $_elementKey => $_elementName) {
                $_variableName = '_' . strtolower($_elementName);
                $$_variableName = isset($time[$field_array][$prefix . $_elementName]) ? $time[$field_array][$prefix . $_elementName] : date($_elementKey);
            }
        } else {
            [$_year, $_month, $_day] = explode('-', date('Y-m-d'));
        }
    } elseif (isset($time) && preg_match("/(\d*)-(\d*)-(\d*)/", $time, $matches)) {
        $_year = $_month = $_day = null;
        if ($matches[1] > '') $_year = (int)$matches[1];
        if ($matches[2] > '') $_month = (int)$matches[2];
        if ($matches[3] > '') $_day = (int)$matches[3];
    } elseif ($time === null) {
        if (array_key_exists('time', $params)) {
            $_year = $_month = $_day = null;
        } else {
            [$_year, $_month, $_day] = explode('-', date('Y-m-d'));
        }
    } else {
        $template->_checkPlugins(array(array('function' => 'smarty_make_timestamp', 'file' => SMARTY_PLUGINS_DIR . 'shared.make_timestamp.php')));
        $time = smarty_make_timestamp($time);
        [$_year, $_month, $_day] = explode('-', date('Y-m-d', $time));
    }
    foreach (array('start', 'end') as $key) {
        $key .= '_year';
        $t = $$key;
        if ($t === null) {
            $$key = (int)$_current_year;
        } elseif ($t[0] === '+') {
            $$key = (int)($_current_year + (int)trim(substr($t, 1)));
        } elseif ($t[0] === '-') {
            $$key = (int)($_current_year - (int)trim(substr($t, 1)));
        } else {
            $$key = (int)$$key;
        }
    }
    if (($start_year > $end_year && !$reverse_years) || ($start_year < $end_year && $reverse_years)) {
        $t = $end_year;
        $end_year = $start_year;
        $start_year = $t;
    }
    if ($display_years) {
        $_extra = '';
        $_name = $field_array ? ($field_array . '[' . $prefix . 'Year]') : ($prefix . 'Year');
        if ($all_extra) {
            $_extra .= ' ' . $all_extra;
        }
        if ($year_extra) {
            $_extra .= ' ' . $year_extra;
        }
        if ($year_as_text) {
            $_html_years = '<input type="text" name="' . $_name . '" value="' . $_year . '" size="4" maxlength="4"' . $_extra . $extra_attrs . ' />';
        } else {
            $_html_years = '<select name="' . $_name . '"';
            if ($year_id !== null || $all_id !== null) {
                $_html_years .= ' id="' . smarty_function_escape_special_chars($year_id !== null ? ($year_id ? $year_id : $_name) : ($all_id ? ($all_id . $_name) : $_name)) . '"';
            }
            if ($year_size) {
                $_html_years .= ' size="' . $year_size . '"';
            }
            $_html_years .= $_extra . $extra_attrs . '>' . $option_separator;
            if (isset($year_empty) || isset($all_empty)) {
                $_html_years .= '<option value="">' . (isset($year_empty) ? $year_empty : $all_empty) . '</option>' . $option_separator;
            }
            $op = $start_year > $end_year ? -1 : 1;
            for ($i = $start_year; $op > 0 ? $i <= $end_year : $i >= $end_year; $i += $op) {
                $_html_years .= '<option value="' . $i . '"' . ($_year == $i ? ' selected="selected"' : '') . '>' . $i . '</option>' . $option_separator;
            }
            $_html_years .= '</select>';
        }
    }
    if ($display_months) {
        $_extra = '';
        $_name = $field_array ? ($field_array . '[' . $prefix . 'Month]') : ($prefix . 'Month');
        if ($all_extra) {
            $_extra .= ' ' . $all_extra;
        }
        if ($month_extra) {
            $_extra .= ' ' . $month_extra;
        }
        $_html_months = '<select name="' . $_name . '"';
        if ($month_id !== null || $all_id !== null) {
            $_html_months .= ' id="' . smarty_function_escape_special_chars($month_id !== null ? ($month_id ? $month_id : $_name) : ($all_id ? ($all_id . $_name) : $_name)) . '"';
        }
        if ($month_size) {
            $_html_months .= ' size="' . $month_size . '"';
        }
        $_html_months .= $_extra . $extra_attrs . '>' . $option_separator;
        if (isset($month_empty) || isset($all_empty)) {
            $_html_months .= '<option value="">' . (isset($month_empty) ? $month_empty : $all_empty) . '</option>' . $option_separator;
        }
        for ($i = 1; $i <= 12; $i++) {
            $_val = sprintf('%02d', $i);
            $_text = isset($month_names) ? smarty_function_escape_special_chars($month_names[$i]) : ($month_format === '%m' ? $_val : @strftime($month_format, $_month_timestamps[$i]));
            $_value = $month_value_format === '%m' ? $_val : @strftime($month_value_format, $_month_timestamps[$i]);
            $_html_months .= '<option value="' . $_value . '"' . ($_val == $_month ? ' selected="selected"' : '') . '>' . $_text . '</option>' . $option_separator;
        }
        $_html_months .= '</select>';
    }
    if ($display_days) {
        $_extra = '';
        $_name = $field_array ? ($field_array . '[' . $prefix . 'Day]') : ($prefix . 'Day');
        if ($all_extra) {
            $_extra .= ' ' . $all_extra;
        }
        if ($day_extra) {
            $_extra .= ' ' . $day_extra;
        }
        $_html_days = '<select name="' . $_name . '"';
        if ($day_id !== null || $all_id !== null) {
            $_html_days .= ' id="' . smarty_function_escape_special_chars($day_id !== null ? ($day_id ? $day_id : $_name) : ($all_id ? ($all_id . $_name) : $_name)) . '"';
        }
        if ($day_size) {
            $_html_days .= ' size="' . $day_size . '"';
        }
        $_html_days .= $_extra . $extra_attrs . '>' . $option_separator;
        if (isset($day_empty) || isset($all_empty)) {
            $_html_days .= '<option value="">' . (isset($day_empty) ? $day_empty : $all_empty) . '</option>' . $option_separator;
        }
        for ($i = 1; $i <= 31; $i++) {
            $_val = sprintf('%02d', $i);
            $_text = $day_format === '%02d' ? $_val : sprintf($day_format, $i);
            $_value = $day_value_format === '%02d' ? $_val : sprintf($day_value_format, $i);
            $_html_days .= '<option value="' . $_value . '"' . ($_val == $_day ? ' selected="selected"' : '') . '>' . $_text . '</option>' . $option_separator;
        }
        $_html_days .= '</select>';
    }
    $_html = '';
    for ($i = 0; $i <= 2; $i++) {
        switch ($field_order[$i]) {
            case 'Y':
            case 'y':
                if (isset($_html_years)) {
                    if ($_html) {
                        $_html .= $field_separator;
                    }
                    $_html .= $_html_years;
                }
                break;
            case 'm':
            case 'M':
                if (isset($_html_months)) {
                    if ($_html) {
                        $_html .= $field_separator;
                    }
                    $_html .= $_html_months;
                }
                break;
            case 'd':
            case 'D':
                if (isset($_html_days)) {
                    if ($_html) {
                        $_html .= $field_separator;
                    }
                    $_html .= $_html_days;
                }
                break;
        }
    }
    return $_html;
}