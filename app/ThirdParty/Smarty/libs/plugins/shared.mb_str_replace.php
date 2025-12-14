<?php
if (!function_exists('smarty_mb_str_replace')) {
    function smarty_mb_str_replace($search, $replace, $subject, &$count = 0)
    {
        if (!is_array($search) && is_array($replace)) {
            return false;
        }
        if (is_array($subject)) {
            foreach ($subject as &$string) {
                $string = smarty_mb_str_replace($search, $replace, $string, $c);
                $count += $c;
            }
        } elseif (is_array($search)) {
            if (!is_array($replace)) {
                foreach ($search as &$string) {
                    $subject = smarty_mb_str_replace($string, $replace, $subject, $c);
                    $count += $c;
                }
            } else {
                $n = max(count($search), count($replace));
                while ($n--) {
                    $subject = smarty_mb_str_replace(current($search), current($replace), $subject, $c);
                    $count += $c;
                    next($search);
                    next($replace);
                }
            }
        } else {
            $mb_reg_charset = mb_regex_encoding();
            $reg_is_unicode = !strcasecmp($mb_reg_charset, "UTF-8");
            if (!$reg_is_unicode) {
                mb_regex_encoding("UTF-8");
            }
            $current_charset = mb_regex_encoding();
            $convert_result = (bool)strcasecmp(Smarty::$_CHARSET, $current_charset);
            if ($convert_result) {
                $subject = mb_convert_encoding($subject, $current_charset, Smarty::$_CHARSET);
                $search = mb_convert_encoding($search, $current_charset, Smarty::$_CHARSET);
                $replace = mb_convert_encoding($replace, $current_charset, Smarty::$_CHARSET);
            }
            $parts = mb_split(preg_quote($search), $subject ?? "") ?: array();
            if (!$reg_is_unicode) {
                mb_regex_encoding($mb_reg_charset);
            }
            if ($parts === false) {
                throw new SmartyException("Source string is not a valid $current_charset sequence (probably)");
            }
            $count = count($parts) - 1;
            $subject = implode($replace, $parts);
            if ($convert_result) {
                $subject = mb_convert_encoding($subject, Smarty::$_CHARSET, $current_charset);
            }
        }
        return $subject;
    }
}