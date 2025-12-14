<?php
function smarty_modifier_mb_wordwrap($str, $width = 75, $break = "\n", $cut = false)
{
    $tokens = preg_split('!(\s)!S' . Smarty::$_UTF8_MODIFIER, $str, -1, PREG_SPLIT_NO_EMPTY + PREG_SPLIT_DELIM_CAPTURE);
    $length = 0;
    $t = '';
    $_previous = false;
    $_space = false;
    foreach ($tokens as $_token) {
        $token_length = mb_strlen($_token, Smarty::$_CHARSET);
        $_tokens = array($_token);
        if ($token_length > $width) {
            if ($cut) {
                $_tokens = preg_split('!(.{' . $width . '})!S' . Smarty::$_UTF8_MODIFIER, $_token, -1, PREG_SPLIT_NO_EMPTY + PREG_SPLIT_DELIM_CAPTURE);
            }
        }
        foreach ($_tokens as $token) {
            $_space = !!preg_match('!^\s$!S' . Smarty::$_UTF8_MODIFIER, $token);
            $token_length = mb_strlen($token, Smarty::$_CHARSET);
            $length += $token_length;
            if ($length > $width) {
                if ($_previous) {
                    $t = mb_substr($t, 0, -1, Smarty::$_CHARSET);
                }
                if (!$_space) {
                    if (!empty($t)) {
                        $t .= $break;
                    }
                    $length = $token_length;
                }
            } elseif ($token === "\n") {
                $length = 0;
            }
            $_previous = $_space;
            $t .= $token;
        }
    }
    return $t;
}