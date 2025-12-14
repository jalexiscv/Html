<?php
function smarty_function_mailto($params)
{
    static $_allowed_encoding = ['javascript' => true, 'javascript_charcode' => true, 'hex' => true, 'none' => true];
    $extra = '';
    if (empty($params['address'])) {
        trigger_error("mailto: missing 'address' parameter", E_USER_WARNING);
        return;
    } else {
        $address = $params['address'];
    }
    $text = $address;
    $mail_parms = [];
    foreach ($params as $var => $value) {
        switch ($var) {
            case 'cc':
            case 'bcc':
            case 'followupto':
                if (!empty($value)) {
                    $mail_parms[] = $var . '=' . str_replace(['%40', '%2C'], ['@', ','], rawurlencode($value));
                }
                break;
            case 'subject':
            case 'newsgroups':
                $mail_parms[] = $var . '=' . rawurlencode($value);
                break;
            case 'extra':
            case 'text':
                $$var = $value;
            default:
        }
    }
    if ($mail_parms) {
        $address .= '?' . join('&', $mail_parms);
    }
    $encode = (empty($params['encode'])) ? 'none' : $params['encode'];
    if (!isset($_allowed_encoding[$encode])) {
        trigger_error("mailto: 'encode' parameter must be none, javascript, javascript_charcode or hex", E_USER_WARNING);
        return;
    }
    $string = '<a href="mailto:' . htmlspecialchars($address, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, Smarty::$_CHARSET) . '" ' . $extra . '>' . htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, Smarty::$_CHARSET) . '</a>';
    if ($encode === 'javascript') {
        $js_encode = '';
        for ($x = 0, $_length = strlen($string); $x < $_length; $x++) {
            $js_encode .= '%' . bin2hex($string[$x]);
        }
        return '<script type="text/javascript">document.write(unescape(\'' . $js_encode . '\'))</script>';
    } elseif ($encode === 'javascript_charcode') {
        for ($x = 0, $_length = strlen($string); $x < $_length; $x++) {
            $ord[] = ord($string[$x]);
        }
        return '<script type="text/javascript">document.write(String.fromCharCode(' . implode(',', $ord) . '))</script>';
    } elseif ($encode === 'hex') {
        preg_match('!^(.*)(\?.*)$!', $address, $match);
        if (!empty($match[2])) {
            trigger_error("mailto: hex encoding does not work with extra attributes. Try javascript.", E_USER_WARNING);
            return;
        }
        $address_encode = '';
        for ($x = 0, $_length = strlen($address); $x < $_length; $x++) {
            if (preg_match('!\w!' . Smarty::$_UTF8_MODIFIER, $address[$x])) {
                $address_encode .= '%' . bin2hex($address[$x]);
            } else {
                $address_encode .= $address[$x];
            }
        }
        $text_encode = '';
        for ($x = 0, $_length = strlen($text); $x < $_length; $x++) {
            $text_encode .= '&#x' . bin2hex($text[$x]) . ';';
        }
        $mailto = "&#109;&#97;&#105;&#108;&#116;&#111;&#58;";
        return '<a href="' . $mailto . $address_encode . '" ' . $extra . '>' . $text_encode . '</a>';
    } else {
        return $string;
    }
}