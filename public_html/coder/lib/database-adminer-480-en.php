<?php
/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */
function
adminer_errors($_c, $Bc)
{
    return !!preg_match('~^(Trying to access array offset on value of type null|Undefined array key)~', $Bc);
}

error_reporting(6135);
set_error_handler('adminer_errors', 2);
$Xc = !preg_match('~^(unsafe_raw)?$~', ini_get("filter.default"));
if ($Xc || ini_get("filter.default_flags")) {
    foreach (array('_GET', '_POST', '_COOKIE', '_SERVER') as $X) {
        $Ei = filter_input_array(constant("INPUT$X"), FILTER_UNSAFE_RAW);
        if ($Ei) $$X = $Ei;
    }
}
if (function_exists("mb_internal_encoding")) mb_internal_encoding("8bit");
function
connection()
{
    global $f;
    return $f;
}

function
adminer()
{
    global $b;
    return $b;
}

function
version()
{
    global $ia;
    return $ia;
}

function
idf_unescape($v)
{
    $me = substr($v, -1);
    return
        str_replace($me . $me, $me, substr($v, 1, -1));
}

function
escape_string($X)
{
    return
        substr(q($X), 1, -1);
}

function
number($X)
{
    return
        preg_replace('~[^0-9]+~', '', $X);
}

function
number_type()
{
    return '((?<!o)int(?!er)|numeric|real|float|double|decimal|money)';
}

function
remove_slashes($pg, $Xc = false)
{
    if (function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc()) {
        while (list($z, $X) = each($pg)) {
            foreach ($X
                     as $ee => $W) {
                unset($pg[$z][$ee]);
                if (is_array($W)) {
                    $pg[$z][stripslashes($ee)] = $W;
                    $pg[] =& $pg[$z][stripslashes($ee)];
                } else$pg[$z][stripslashes($ee)] = ($Xc ? $W : stripslashes($W));
            }
        }
    }
}

function
bracket_escape($v, $Ma = false)
{
    static $qi = array(':' => ':1', ']' => ':2', '[' => ':3', '"' => ':4');
    return
        strtr($v, ($Ma ? array_flip($qi) : $qi));
}

function
min_version($Vi, $_e = "", $g = null)
{
    global $f;
    if (!$g) $g = $f;
    $jh = $g->server_info;
    if ($_e && preg_match('~([\d.]+)-MariaDB~', $jh, $C)) {
        $jh = $C[1];
        $Vi = $_e;
    }
    return (version_compare($jh, $Vi) >= 0);
}

function
charset($f)
{
    return (min_version("5.5.3", 0, $f) ? "utf8mb4" : "utf8");
}

function
script($uh, $pi = "\n")
{
    return "<script" . nonce() . ">$uh</script>$pi";
}

function
script_src($Ji)
{
    return "<script src='" . h($Ji) . "'" . nonce() . "></script>\n";
}

function
nonce()
{
    return ' nonce="' . get_nonce() . '"';
}

function
target_blank()
{
    return ' target="_blank" rel="noreferrer noopener"';
}

function
h($P)
{
    return
        str_replace("\0", "&#0;", htmlspecialchars($P, ENT_QUOTES, 'utf-8'));
}

function
nl_br($P)
{
    return
        str_replace("\n", "<br>", $P);
}

function
checkbox($D, $Y, $cb, $je = "", $qf = "", $gb = "", $ke = "")
{
    $I = "<input type='checkbox' name='$D' value='" . h($Y) . "'" . ($cb ? " checked" : "") . ($ke ? " aria-labelledby='$ke'" : "") . ">" . ($qf ? script("qsl('input').onclick = function () { $qf };", "") : "");
    return ($je != "" || $gb ? "<label" . ($gb ? " class='$gb'" : "") . ">$I" . h($je) . "</label>" : $I);
}

function
optionlist($wf, $ch = null, $Ni = false)
{
    $I = "";
    foreach ($wf
             as $ee => $W) {
        $xf = array($ee => $W);
        if (is_array($W)) {
            $I .= '<optgroup label="' . h($ee) . '">';
            $xf = $W;
        }
        foreach ($xf
                 as $z => $X) $I .= '<option' . ($Ni || is_string($z) ? ' value="' . h($z) . '"' : '') . (($Ni || is_string($z) ? (string)$z : $X) === $ch ? ' selected' : '') . '>' . h($X);
        if (is_array($W)) $I .= '</optgroup>';
    }
    return $I;
}

function
html_select($D, $wf, $Y = "", $pf = true, $ke = "")
{
    if ($pf) return "<select name='" . h($D) . "'" . ($ke ? " aria-labelledby='$ke'" : "") . ">" . optionlist($wf, $Y) . "</select>" . (is_string($pf) ? script("qsl('select').onchange = function () { $pf };", "") : "");
    $I = "";
    foreach ($wf
             as $z => $X) $I .= "<label><input type='radio' name='" . h($D) . "' value='" . h($z) . "'" . ($z == $Y ? " checked" : "") . ">" . h($X) . "</label>";
    return $I;
}

function
select_input($Ha, $wf, $Y = "", $pf = "", $bg = "")
{
    $Uh = ($wf ? "select" : "input");
    return "<$Uh$Ha" . ($wf ? "><option value=''>$bg" . optionlist($wf, $Y, true) . "</select>" : " size='10' value='" . h($Y) . "' placeholder='$bg'>") . ($pf ? script("qsl('$Uh').onchange = $pf;", "") : "");
}

function
confirm($Je = "", $dh = "qsl('input')")
{
    return
        script("$dh.onclick = function () { return confirm('" . ($Je ? js_escape($Je) : 'Are you sure?') . "'); };", "");
}

function
print_fieldset($u, $re, $Yi = false)
{
    echo "<fieldset><legend>", "<a href='#fieldset-$u'>$re</a>", script("qsl('a').onclick = partial(toggle, 'fieldset-$u');", ""), "</legend>", "<div id='fieldset-$u'" . ($Yi ? "" : " class='hidden'") . ">\n";
}

function
bold($Ta, $gb = "")
{
    return ($Ta ? " class='active $gb'" : ($gb ? " class='$gb'" : ""));
}

function
odd($I = ' class="odd"')
{
    static $t = 0;
    if (!$I) $t = -1;
    return ($t++ % 2 ? $I : '');
}

function
js_escape($P)
{
    return
        addcslashes($P, "\r\n'\\/");
}

function
json_row($z, $X = null)
{
    static $Yc = true;
    if ($Yc) echo "{";
    if ($z != "") {
        echo ($Yc ? "" : ",") . "\n\t\"" . addcslashes($z, "\r\n\t\"\\/") . '": ' . ($X !== null ? '"' . addcslashes($X, "\r\n\"\\/") . '"' : 'null');
        $Yc = false;
    } else {
        echo "\n}\n";
        $Yc = true;
    }
}

function
ini_bool($Rd)
{
    $X = ini_get($Rd);
    return (preg_match('~^(on|true|yes)$~i', $X) || (int)$X);
}

function
sid()
{
    static $I;
    if ($I === null) $I = (SID && !($_COOKIE && ini_bool("session.use_cookies")));
    return $I;
}

function
set_password($Ui, $M, $V, $F)
{
    $_SESSION["pwds"][$Ui][$M][$V] = ($_COOKIE["adminer_key"] && is_string($F) ? array(encrypt_string($F, $_COOKIE["adminer_key"])) : $F);
}

function
get_password()
{
    $I = get_session("pwds");
    if (is_array($I)) $I = ($_COOKIE["adminer_key"] ? decrypt_string($I[0], $_COOKIE["adminer_key"]) : false);
    return $I;
}

function
q($P)
{
    global $f;
    return $f->quote($P);
}

function
get_vals($G, $d = 0)
{
    global $f;
    $I = array();
    $H = $f->query($G);
    if (is_object($H)) {
        while ($J = $H->fetch_row()) $I[] = $J[$d];
    }
    return $I;
}

function
get_key_vals($G, $g = null, $mh = true)
{
    global $f;
    if (!is_object($g)) $g = $f;
    $I = array();
    $H = $g->query($G);
    if (is_object($H)) {
        while ($J = $H->fetch_row()) {
            if ($mh) $I[$J[0]] = $J[1]; else$I[] = $J[0];
        }
    }
    return $I;
}

function
get_rows($G, $g = null, $m = "<p class='error'>")
{
    global $f;
    $wb = (is_object($g) ? $g : $f);
    $I = array();
    $H = $wb->query($G);
    if (is_object($H)) {
        while ($J = $H->fetch_assoc()) $I[] = $J;
    } elseif (!$H && !is_object($g) && $m && defined("PAGE_HEADER")) echo $m . error() . "\n";
    return $I;
}

function
unique_array($J, $x)
{
    foreach ($x
             as $w) {
        if (preg_match("~PRIMARY|UNIQUE~", $w["type"])) {
            $I = array();
            foreach ($w["columns"] as $z) {
                if (!isset($J[$z])) continue
                2;
                $I[$z] = $J[$z];
            }
            return $I;
        }
    }
}

function
escape_key($z)
{
    if (preg_match('(^([\w(]+)(' . str_replace("_", ".*", preg_quote(idf_escape("_"))) . ')([ \w)]+)$)', $z, $C)) return $C[1] . idf_escape(idf_unescape($C[2])) . $C[3];
    return
        idf_escape($z);
}

function
where($Z, $o = array())
{
    global $f, $y;
    $I = array();
    foreach ((array)$Z["where"] as $z => $X) {
        $z = bracket_escape($z, 1);
        $d = escape_key($z);
        $I[] = $d . ($y == "sql" && is_numeric($X) && preg_match('~\.~', $X) ? " LIKE " . q($X) : ($y == "mssql" ? " LIKE " . q(preg_replace('~[_%[]~', '[\0]', $X)) : " = " . unconvert_field($o[$z], q($X))));
        if ($y == "sql" && preg_match('~char|text~', $o[$z]["type"]) && preg_match("~[^ -@]~", $X)) $I[] = "$d = " . q($X) . " COLLATE " . charset($f) . "_bin";
    }
    foreach ((array)$Z["null"] as $z) $I[] = escape_key($z) . " IS NULL";
    return
        implode(" AND ", $I);
}

function
where_check($X, $o = array())
{
    parse_str($X, $ab);
    remove_slashes(array(&$ab));
    return
        where($ab, $o);
}

function
where_link($t, $d, $Y, $sf = "=")
{
    return "&where%5B$t%5D%5Bcol%5D=" . urlencode($d) . "&where%5B$t%5D%5Bop%5D=" . urlencode(($Y !== null ? $sf : "IS NULL")) . "&where%5B$t%5D%5Bval%5D=" . urlencode($Y);
}

function
convert_fields($e, $o, $L = array())
{
    $I = "";
    foreach ($e
             as $z => $X) {
        if ($L && !in_array(idf_escape($z), $L)) continue;
        $Fa = convert_field($o[$z]);
        if ($Fa) $I .= ", $Fa AS " . idf_escape($z);
    }
    return $I;
}

function
cookie($D, $Y, $ue = 2592000)
{
    global $ba;
    return
        header("Set-Cookie: $D=" . urlencode($Y) . ($ue ? "; expires=" . gmdate("D, d M Y H:i:s", time() + $ue) . " GMT" : "") . "; path=" . preg_replace('~\?.*~', '', $_SERVER["REQUEST_URI"]) . ($ba ? "; secure" : "") . "; HttpOnly; SameSite=lax", false);
}

function
restart_session()
{
    if (!ini_bool("session.use_cookies")) session_start();
}

function
stop_session($dd = false)
{
    $Mi = ini_bool("session.use_cookies");
    if (!$Mi || $dd) {
        session_write_close();
        if ($Mi && @ini_set("session.use_cookies", false) === false) session_start();
    }
}

function&get_session($z)
{
    return $_SESSION[$z][DRIVER][SERVER][$_GET["username"]];
}

function
set_session($z, $X)
{
    $_SESSION[$z][DRIVER][SERVER][$_GET["username"]] = $X;
}

function
auth_url($Ui, $M, $V, $k = null)
{
    global $hc;
    preg_match('~([^?]*)\??(.*)~', remove_from_uri(implode("|", array_keys($hc)) . "|username|" . ($k !== null ? "db|" : "") . session_name()), $C);
    return "$C[1]?" . (sid() ? SID . "&" : "") . ($Ui != "server" || $M != "" ? urlencode($Ui) . "=" . urlencode($M) . "&" : "") . "username=" . urlencode($V) . ($k != "" ? "&db=" . urlencode($k) : "") . ($C[2] ? "&$C[2]" : "");
}

function
is_ajax()
{
    return ($_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest");
}

function
redirect($B, $Je = null)
{
    if ($Je !== null) {
        restart_session();
        $_SESSION["messages"][preg_replace('~^[^?]*~', '', ($B !== null ? $B : $_SERVER["REQUEST_URI"]))][] = $Je;
    }
    if ($B !== null) {
        if ($B == "") $B = ".";
        header("Location: $B");
        exit;
    }
}

function
query_redirect($G, $B, $Je, $_g = true, $Gc = true, $Qc = false, $ci = "")
{
    global $f, $m, $b;
    if ($Gc) {
        $Bh = microtime(true);
        $Qc = !$f->query($G);
        $ci = format_time($Bh);
    }
    $xh = "";
    if ($G) $xh = $b->messageQuery($G, $ci, $Qc);
    if ($Qc) {
        $m = error() . $xh . script("messagesPrint();");
        return
            false;
    }
    if ($_g) redirect($B, $Je . $xh);
    return
        true;
}

function
queries($G)
{
    global $f;
    static $ug = array();
    static $Bh;
    if (!$Bh) $Bh = microtime(true);
    if ($G === null) return
        array(implode("\n", $ug), format_time($Bh));
    $ug[] = (preg_match('~;$~', $G) ? "DELIMITER ;;\n$G;\nDELIMITER " : $G) . ";";
    return $f->query($G);
}

function
apply_queries($G, $S, $Cc = 'table')
{
    foreach ($S
             as $Q) {
        if (!queries("$G " . $Cc($Q))) return
            false;
    }
    return
        true;
}

function
queries_redirect($B, $Je, $_g)
{
    list($ug, $ci) = queries(null);
    return
        query_redirect($ug, $B, $Je, $_g, false, !$_g, $ci);
}

function
format_time($Bh)
{
    return
        sprintf('%.3f s', max(0, microtime(true) - $Bh));
}

function
relative_uri()
{
    return
        str_replace(":", "%3a", preg_replace('~^[^?]*/([^?]*)~', '\1', $_SERVER["REQUEST_URI"]));
}

function
remove_from_uri($Mf = "")
{
    return
        substr(preg_replace("~(?<=[?&])($Mf" . (SID ? "" : "|" . session_name()) . ")=[^&]*&~", '', relative_uri() . "&"), 0, -1);
}

function
pagination($E, $Nb)
{
    return " " . ($E == $Nb ? $E + 1 : '<a href="' . h(remove_from_uri("page") . ($E ? "&page=$E" . ($_GET["next"] ? "&next=" . urlencode($_GET["next"]) : "") : "")) . '">' . ($E + 1) . "</a>");
}

function
get_file($z, $Vb = false)
{
    $Wc = $_FILES[$z];
    if (!$Wc) return
        null;
    foreach ($Wc
             as $z => $X) $Wc[$z] = (array)$X;
    $I = '';
    foreach ($Wc["error"] as $z => $m) {
        if ($m) return $m;
        $D = $Wc["name"][$z];
        $ki = $Wc["tmp_name"][$z];
        $Bb = file_get_contents($Vb && preg_match('~\.gz$~', $D) ? "compress.zlib://$ki" : $ki);
        if ($Vb) {
            $Bh = substr($Bb, 0, 3);
            if (function_exists("iconv") && preg_match("~^\xFE\xFF|^\xFF\xFE~", $Bh, $Fg)) $Bb = iconv("utf-16", "utf-8", $Bb); elseif ($Bh == "\xEF\xBB\xBF") $Bb = substr($Bb, 3);
            $I .= $Bb . "\n\n";
        } else$I .= $Bb;
    }
    return $I;
}

function
upload_error($m)
{
    $Ge = ($m == UPLOAD_ERR_INI_SIZE ? ini_get("upload_max_filesize") : 0);
    return ($m ? 'Unable to upload a file.' . ($Ge ? " " . sprintf('Maximum allowed file size is %sB.', $Ge) : "") : 'File does not exist.');
}

function
repeat_pattern($Yf, $se)
{
    return
        str_repeat("$Yf{0,65535}", $se / 65535) . "$Yf{0," . ($se % 65535) . "}";
}

function
is_utf8($X)
{
    return (preg_match('~~u', $X) && !preg_match('~[\0-\x8\xB\xC\xE-\x1F]~', $X));
}

function
shorten_utf8($P, $se = 80, $Ih = "")
{
    if (!preg_match("(^(" . repeat_pattern("[\t\r\n -\x{10FFFF}]", $se) . ")($)?)u", $P, $C)) preg_match("(^(" . repeat_pattern("[\t\r\n -~]", $se) . ")($)?)", $P, $C);
    return
        h($C[1]) . $Ih . (isset($C[2]) ? "" : "<i>…</i>");
}

function
format_number($X)
{
    return
        strtr(number_format($X, 0, ".", ','), preg_split('~~u', '0123456789', -1, PREG_SPLIT_NO_EMPTY));
}

function
friendly_url($X)
{
    return
        preg_replace('~[^a-z0-9_]~i', '-', $X);
}

function
hidden_fields($pg, $Gd = array(), $hg = '')
{
    $I = false;
    foreach ($pg
             as $z => $X) {
        if (!in_array($z, $Gd)) {
            if (is_array($X)) hidden_fields($X, array(), $z); else {
                $I = true;
                echo '<input type="hidden" name="' . h($hg ? $hg . "[$z]" : $z) . '" value="' . h($X) . '">';
            }
        }
    }
    return $I;
}

function
hidden_fields_get()
{
    echo(sid() ? '<input type="hidden" name="' . session_name() . '" value="' . h(session_id()) . '">' : ''), (SERVER !== null ? '<input type="hidden" name="' . DRIVER . '" value="' . h(SERVER) . '">' : ""), '<input type="hidden" name="username" value="' . h($_GET["username"]) . '">';
}

function
table_status1($Q, $Rc = false)
{
    $I = table_status($Q, $Rc);
    return ($I ? $I : array("Name" => $Q));
}

function
column_foreign_keys($Q)
{
    global $b;
    $I = array();
    foreach ($b->foreignKeys($Q) as $q) {
        foreach ($q["source"] as $X) $I[$X][] = $q;
    }
    return $I;
}

function
enum_input($T, $Ha, $n, $Y, $wc = null)
{
    global $b;
    preg_match_all("~'((?:[^']|'')*)'~", $n["length"], $Be);
    $I = ($wc !== null ? "<label><input type='$T'$Ha value='$wc'" . ((is_array($Y) ? in_array($wc, $Y) : $Y === 0) ? " checked" : "") . "><i>" . 'empty' . "</i></label>" : "");
    foreach ($Be[1] as $t => $X) {
        $X = stripcslashes(str_replace("''", "'", $X));
        $cb = (is_int($Y) ? $Y == $t + 1 : (is_array($Y) ? in_array($t + 1, $Y) : $Y === $X));
        $I .= " <label><input type='$T'$Ha value='" . ($t + 1) . "'" . ($cb ? ' checked' : '') . '>' . h($b->editVal($X, $n)) . '</label>';
    }
    return $I;
}

function
input($n, $Y, $s)
{
    global $U, $b, $y;
    $D = h(bracket_escape($n["field"]));
    echo "<td class='function'>";
    if (is_array($Y) && !$s) {
        $Da = array($Y);
        if (version_compare(PHP_VERSION, 5.4) >= 0) $Da[] = JSON_PRETTY_PRINT;
        $Y = call_user_func_array('json_encode', $Da);
        $s = "json";
    }
    $Jg = ($y == "mssql" && $n["auto_increment"]);
    if ($Jg && !$_POST["save"]) $s = null;
    $ld = (isset($_GET["select"]) || $Jg ? array("orig" => 'original') : array()) + $b->editFunctions($n);
    $Ha = " name='fields[$D]'";
    if ($n["type"] == "enum") echo
        h($ld[""]) . "<td>" . $b->editInput($_GET["edit"], $n, $Ha, $Y); else {
        $vd = (in_array($s, $ld) || isset($ld[$s]));
        echo (count($ld) > 1 ? "<select name='function[$D]'>" . optionlist($ld, $s === null || $vd ? $s : "") . "</select>" . on_help("getTarget(event).value.replace(/^SQL\$/, '')", 1) . script("qsl('select').onchange = functionChange;", "") : h(reset($ld))) . '<td>';
        $Td = $b->editInput($_GET["edit"], $n, $Ha, $Y);
        if ($Td != "") echo $Td; elseif (preg_match('~bool~', $n["type"])) echo "<input type='hidden'$Ha value='0'>" . "<input type='checkbox'" . (preg_match('~^(1|t|true|y|yes|on)$~i', $Y) ? " checked='checked'" : "") . "$Ha value='1'>";
        elseif ($n["type"] == "set") {
            preg_match_all("~'((?:[^']|'')*)'~", $n["length"], $Be);
            foreach ($Be[1] as $t => $X) {
                $X = stripcslashes(str_replace("''", "'", $X));
                $cb = (is_int($Y) ? ($Y >> $t) & 1 : in_array($X, explode(",", $Y), true));
                echo " <label><input type='checkbox' name='fields[$D][$t]' value='" . (1 << $t) . "'" . ($cb ? ' checked' : '') . ">" . h($b->editVal($X, $n)) . '</label>';
            }
        } elseif (preg_match('~blob|bytea|raw|file~', $n["type"]) && ini_bool("file_uploads")) echo "<input type='file' name='fields-$D'>";
        elseif (($ai = preg_match('~text|lob|memo~i', $n["type"])) || preg_match("~\n~", $Y)) {
            if ($ai && $y != "sqlite") $Ha .= " cols='50' rows='12'"; else {
                $K = min(12, substr_count($Y, "\n") + 1);
                $Ha .= " cols='30' rows='$K'" . ($K == 1 ? " style='height: 1.2em;'" : "");
            }
            echo "<textarea$Ha>" . h($Y) . '</textarea>';
        } elseif ($s == "json" || preg_match('~^jsonb?$~', $n["type"])) echo "<textarea$Ha cols='50' rows='12' class='jush-js'>" . h($Y) . '</textarea>';
        else {
            $Ie = (!preg_match('~int~', $n["type"]) && preg_match('~^(\d+)(,(\d+))?$~', $n["length"], $C) ? ((preg_match("~binary~", $n["type"]) ? 2 : 1) * $C[1] + ($C[3] ? 1 : 0) + ($C[2] && !$n["unsigned"] ? 1 : 0)) : ($U[$n["type"]] ? $U[$n["type"]] + ($n["unsigned"] ? 0 : 1) : 0));
            if ($y == 'sql' && min_version(5.6) && preg_match('~time~', $n["type"])) $Ie += 7;
            echo "<input" . ((!$vd || $s === "") && preg_match('~(?<!o)int(?!er)~', $n["type"]) && !preg_match('~\[\]~', $n["full_type"]) ? " type='number'" : "") . " value='" . h($Y) . "'" . ($Ie ? " data-maxlength='$Ie'" : "") . (preg_match('~char|binary~', $n["type"]) && $Ie > 20 ? " size='40'" : "") . "$Ha>";
        }
        echo $b->editHint($_GET["edit"], $n, $Y);
        $Yc = 0;
        foreach ($ld
                 as $z => $X) {
            if ($z === "" || !$X) break;
            $Yc++;
        }
        if ($Yc) echo
        script("mixin(qsl('td'), {onchange: partial(skipOriginal, $Yc), oninput: function () { this.onchange(); }});");
    }
}

function
process_input($n)
{
    global $b, $l;
    $v = bracket_escape($n["field"]);
    $s = $_POST["function"][$v];
    $Y = $_POST["fields"][$v];
    if ($n["type"] == "enum") {
        if ($Y == -1) return
            false;
        if ($Y == "") return "NULL";
        return +$Y;
    }
    if ($n["auto_increment"] && $Y == "") return
        null;
    if ($s == "orig") return (preg_match('~^CURRENT_TIMESTAMP~i', $n["on_update"]) ? idf_escape($n["field"]) : false);
    if ($s == "NULL") return "NULL";
    if ($n["type"] == "set") return
        array_sum((array)$Y);
    if ($s == "json") {
        $s = "";
        $Y = json_decode($Y, true);
        if (!is_array($Y)) return
            false;
        return $Y;
    }
    if (preg_match('~blob|bytea|raw|file~', $n["type"]) && ini_bool("file_uploads")) {
        $Wc = get_file("fields-$v");
        if (!is_string($Wc)) return
            false;
        return $l->quoteBinary($Wc);
    }
    return $b->processInput($n, $Y, $s);
}

function
fields_from_edit()
{
    global $l;
    $I = array();
    foreach ((array)$_POST["field_keys"] as $z => $X) {
        if ($X != "") {
            $X = bracket_escape($X);
            $_POST["function"][$X] = $_POST["field_funs"][$z];
            $_POST["fields"][$X] = $_POST["field_vals"][$z];
        }
    }
    foreach ((array)$_POST["fields"] as $z => $X) {
        $D = bracket_escape($z, 1);
        $I[$D] = array("field" => $D, "privileges" => array("insert" => 1, "update" => 1), "null" => 1, "auto_increment" => ($z == $l->primary),);
    }
    return $I;
}

function
search_tables()
{
    global $b, $f;
    $_GET["where"][0]["val"] = $_POST["query"];
    $fh = "<ul>\n";
    foreach (table_status('', true) as $Q => $R) {
        $D = $b->tableName($R);
        if (isset($R["Engine"]) && $D != "" && (!$_POST["tables"] || in_array($Q, $_POST["tables"]))) {
            $H = $f->query("SELECT" . limit("1 FROM " . table($Q), " WHERE " . implode(" AND ", $b->selectSearchProcess(fields($Q), array())), 1));
            if (!$H || $H->fetch_row()) {
                $lg = "<a href='" . h(ME . "select=" . urlencode($Q) . "&where[0][op]=" . urlencode($_GET["where"][0]["op"]) . "&where[0][val]=" . urlencode($_GET["where"][0]["val"])) . "'>$D</a>";
                echo "$fh<li>" . ($H ? $lg : "<p class='error'>$lg: " . error()) . "\n";
                $fh = "";
            }
        }
    }
    echo ($fh ? "<p class='message'>" . 'No tables.' : "</ul>") . "\n";
}

function
dump_headers($Dd, $Re = false)
{
    global $b;
    $I = $b->dumpHeaders($Dd, $Re);
    $If = $_POST["output"];
    if ($If != "text") header("Content-Disposition: attachment; filename=" . $b->dumpFilename($Dd) . ".$I" . ($If != "file" && preg_match('~^[0-9a-z]+$~', $If) ? ".$If" : ""));
    session_write_close();
    ob_flush();
    flush();
    return $I;
}

function
dump_csv($J)
{
    foreach ($J
             as $z => $X) {
        if (preg_match('~["\n,;\t]|^0|\.\d*0$~', $X) || $X === "") $J[$z] = '"' . str_replace('"', '""', $X) . '"';
    }
    echo
        implode(($_POST["format"] == "csv" ? "," : ($_POST["format"] == "tsv" ? "\t" : ";")), $J) . "\r\n";
}

function
apply_sql_function($s, $d)
{
    return ($s ? ($s == "unixepoch" ? "DATETIME($d, '$s')" : ($s == "count distinct" ? "COUNT(DISTINCT " : strtoupper("$s(")) . "$d)") : $d);
}

function
get_temp_dir()
{
    $I = ini_get("upload_tmp_dir");
    if (!$I) {
        if (function_exists('sys_get_temp_dir')) $I = sys_get_temp_dir(); else {
            $p = @tempnam("", "");
            if (!$p) return
                false;
            $I = dirname($p);
            unlink($p);
        }
    }
    return $I;
}

function
file_open_lock($p)
{
    $r = @fopen($p, "r+");
    if (!$r) {
        $r = @fopen($p, "w");
        if (!$r) return;
        chmod($p, 0660);
    }
    flock($r, LOCK_EX);
    return $r;
}

function
file_write_unlock($r, $Pb)
{
    rewind($r);
    fwrite($r, $Pb);
    ftruncate($r, strlen($Pb));
    flock($r, LOCK_UN);
    fclose($r);
}

function
password_file($h)
{
    $p = get_temp_dir() . "/adminer.key";
    $I = @file_get_contents($p);
    if ($I || !$h) return $I;
    $r = @fopen($p, "w");
    if ($r) {
        chmod($p, 0660);
        $I = rand_string();
        fwrite($r, $I);
        fclose($r);
    }
    return $I;
}

function
rand_string()
{
    return
        md5(uniqid(mt_rand(), true));
}

function
select_value($X, $A, $n, $bi)
{
    global $b;
    if (is_array($X)) {
        $I = "";
        foreach ($X
                 as $ee => $W) $I .= "<tr>" . ($X != array_values($X) ? "<th>" . h($ee) : "") . "<td>" . select_value($W, $A, $n, $bi);
        return "<table cellspacing='0'>$I</table>";
    }
    if (!$A) $A = $b->selectLink($X, $n);
    if ($A === null) {
        if (is_mail($X)) $A = "mailto:$X";
        if (is_url($X)) $A = $X;
    }
    $I = $b->editVal($X, $n);
    if ($I !== null) {
        if (!is_utf8($I)) $I = "\0"; elseif ($bi != "" && is_shortable($n)) $I = shorten_utf8($I, max(0, +$bi));
        else$I = h($I);
    }
    return $b->selectVal($I, $A, $n, $X);
}

function
is_mail($tc)
{
    $Ga = '[-a-z0-9!#$%&\'*+/=?^_`{|}~]';
    $gc = '[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';
    $Yf = "$Ga+(\\.$Ga+)*@($gc?\\.)+$gc";
    return
        is_string($tc) && preg_match("(^$Yf(,\\s*$Yf)*\$)i", $tc);
}

function
is_url($P)
{
    $gc = '[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';
    return
        preg_match("~^(https?)://($gc?\\.)+$gc(:\\d+)?(/.*)?(\\?.*)?(#.*)?\$~i", $P);
}

function
is_shortable($n)
{
    return
        preg_match('~char|text|json|lob|geometry|point|linestring|polygon|string|bytea~', $n["type"]);
}

function
count_rows($Q, $Z, $Zd, $od)
{
    global $y;
    $G = " FROM " . table($Q) . ($Z ? " WHERE " . implode(" AND ", $Z) : "");
    return ($Zd && ($y == "sql" || count($od) == 1) ? "SELECT COUNT(DISTINCT " . implode(", ", $od) . ")$G" : "SELECT COUNT(*)" . ($Zd ? " FROM (SELECT 1$G GROUP BY " . implode(", ", $od) . ") x" : $G));
}

function
slow_query($G)
{
    global $b, $mi, $l;
    $k = $b->database();
    $di = $b->queryTimeout();
    $rh = $l->slowQuery($G, $di);
    if (!$rh && support("kill") && is_object($g = connect()) && ($k == "" || $g->select_db($k))) {
        $he = $g->result(connection_id());
        echo '<script', nonce(), '>
var timeout = setTimeout(function () {
	ajax(\'', js_escape(ME), 'script=kill\', function () {
	}, \'kill=', $he, '&token=', $mi, '\');
}, ', 1000 * $di, ');
</script>
';
    } else$g = null;
    ob_flush();
    flush();
    $I = @get_key_vals(($rh ? $rh : $G), $g, false);
    if ($g) {
        echo
        script("clearTimeout(timeout);");
        ob_flush();
        flush();
    }
    return $I;
}

function
get_token()
{
    $xg = rand(1, 1e6);
    return ($xg ^ $_SESSION["token"]) . ":$xg";
}

function
verify_token()
{
    list($mi, $xg) = explode(":", $_POST["token"]);
    return ($xg ^ $_SESSION["token"]) == $mi;
}

function
lzw_decompress($Qa)
{
    $dc = 256;
    $Ra = 8;
    $ib = array();
    $Lg = 0;
    $Mg = 0;
    for ($t = 0; $t < strlen($Qa); $t++) {
        $Lg = ($Lg << 8) + ord($Qa[$t]);
        $Mg += 8;
        if ($Mg >= $Ra) {
            $Mg -= $Ra;
            $ib[] = $Lg >> $Mg;
            $Lg &= (1 << $Mg) - 1;
            $dc++;
            if ($dc >> $Ra) $Ra++;
        }
    }
    $cc = range("\0", "\xFF");
    $I = "";
    foreach ($ib
             as $t => $hb) {
        $sc = $cc[$hb];
        if (!isset($sc)) $sc = $jj . $jj[0];
        $I .= $sc;
        if ($t) $cc[] = $jj . $sc[0];
        $jj = $sc;
    }
    return $I;
}

function
on_help($pb, $oh = 0)
{
    return
        script("mixin(qsl('select, input'), {onmouseover: function (event) { helpMouseover.call(this, event, $pb, $oh) }, onmouseout: helpMouseout});", "");
}

function
edit_form($Q, $o, $J, $Hi)
{
    global $b, $y, $mi, $m;
    $Nh = $b->tableName(table_status1($Q, true));
    page_header(($Hi ? 'Edit' : 'Insert'), $m, array("select" => array($Q, $Nh)), $Nh);
    $b->editRowPrint($Q, $o, $J, $Hi);
    if ($J === false) echo "<p class='error'>" . 'No rows.' . "\n";
    echo '<form action="" method="post" enctype="multipart/form-data" id="form">
';
    if (!$o) echo "<p class='error'>" . 'You have no privileges to update this table.' . "\n"; else {
        echo "<table cellspacing='0' class='layout'>" . script("qsl('table').onkeydown = editingKeydown;");
        foreach ($o
                 as $D => $n) {
            echo "<tr><th>" . $b->fieldName($n);
            $Wb = $_GET["set"][bracket_escape($D)];
            if ($Wb === null) {
                $Wb = $n["default"];
                if ($n["type"] == "bit" && preg_match("~^b'([01]*)'\$~", $Wb, $Fg)) $Wb = $Fg[1];
            }
            $Y = ($J !== null ? ($J[$D] != "" && $y == "sql" && preg_match("~enum|set~", $n["type"]) ? (is_array($J[$D]) ? array_sum($J[$D]) : +$J[$D]) : (is_bool($J[$D]) ? +$J[$D] : $J[$D])) : (!$Hi && $n["auto_increment"] ? "" : (isset($_GET["select"]) ? false : $Wb)));
            if (!$_POST["save"] && is_string($Y)) $Y = $b->editVal($Y, $n);
            $s = ($_POST["save"] ? (string)$_POST["function"][$D] : ($Hi && preg_match('~^CURRENT_TIMESTAMP~i', $n["on_update"]) ? "now" : ($Y === false ? null : ($Y !== null ? '' : 'NULL'))));
            if (!$_POST && !$Hi && $Y == $n["default"] && preg_match('~^[\w.]+\(~', $Y)) $s = "SQL";
            if (preg_match("~time~", $n["type"]) && preg_match('~^CURRENT_TIMESTAMP~i', $Y)) {
                $Y = "";
                $s = "now";
            }
            input($n, $Y, $s);
            echo "\n";
        }
        if (!support("table")) echo "<tr>" . "<th><input name='field_keys[]'>" . script("qsl('input').oninput = fieldChange;") . "<td class='function'>" . html_select("field_funs[]", $b->editFunctions(array("null" => isset($_GET["select"])))) . "<td><input name='field_vals[]'>" . "\n";
        echo "</table>\n";
    }
    echo "<p>\n";
    if ($o) {
        echo "<input type='submit' value='" . 'Save' . "'>\n";
        if (!isset($_GET["select"])) {
            echo "<input type='submit' name='insert' value='" . ($Hi ? 'Save and continue edit' : 'Save and insert next') . "' title='Ctrl+Shift+Enter'>\n", ($Hi ? script("qsl('input').onclick = function () { return !ajaxForm(this.form, '" . 'Saving' . "…', this); };") : "");
        }
    }
    echo($Hi ? "<input type='submit' name='delete' value='" . 'Delete' . "'>" . confirm() . "\n" : ($_POST || !$o ? "" : script("focus(qsa('td', qs('#form'))[1].firstChild);")));
    if (isset($_GET["select"])) hidden_fields(array("check" => (array)$_POST["check"], "clone" => $_POST["clone"], "all" => $_POST["all"]));
    echo '<input type="hidden" name="referer" value="', h(isset($_POST["referer"]) ? $_POST["referer"] : $_SERVER["HTTP_REFERER"]), '">
<input type="hidden" name="save" value="1">
<input type="hidden" name="token" value="', $mi, '">
</form>
';
}

if (isset($_GET["file"])) {
    if ($_SERVER["HTTP_IF_MODIFIED_SINCE"]) {
        header("HTTP/1.1 304 Not Modified");
        exit;
    }
    header("Expires: " . gmdate("D, d M Y H:i:s", time() + 365 * 24 * 60 * 60) . " GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: immutable");
    if ($_GET["file"] == "favicon.ico") {
        header("Content-Type: image/x-icon");
        echo
        lzw_decompress("\0\0\0` \0�\0\n @\0�C��\"\0`E�Q����?�tvM'�Jd�d\\�b0\0�\"��fӈ��s5����A�XPaJ�0���8�#R�T��z`�#.��c�X��Ȁ?�-\0�Im?�.�M��\0ȯ(̉��/(%�\0");
    } elseif ($_GET["file"] == "default.css") {
        header("Content-Type: text/css; charset=utf-8");
        echo
        lzw_decompress("\n1̇�ٌ�l7��B1�4vb0��fs���n2B�ѱ٘�n:�#(�b.\rDc)��a7E����l�ñ��i1̎s���-4��f�	��i7�����t4���y�Zf4��i�AT�VV��f:Ϧ,:1�Qݼ�b2`�#�>:7G�1���s��L�XD*bv<܌#�e@�:4�!fo���t:<��咾�o��\ni���',�a_�:�i�Bv�|N�4.5Nf�i�vp�h��l��֚�O����= �OFQ��k\$��i����d2T�p��6�����-�Z�����6����h:�a�,����2�#8А�#��6n����J��h�t�����4O42��ok��*r���@p@�!������?�6��r[��L���:2B�j�!Hb��P�=!1V�\"��0��\nS���D7��Dڛ�C!�!��Gʌ� �+�=tC�.C��:+��=�������%�c�1MR/�EȒ4���2�䱠�`�8(�ӹ[W��=�yS�b�=�-ܹBS+ɯ�����@pL4Yd��q�����6�3Ĭ��Ac܌�Ψ�k�[&>���Z�pkm]�u-c:���Nt�δpҝ��8�=�#��[.��ޯ�~���m�y�PP�|I֛���Q�9v[�Q��\n��r�'g�+��T�2��V��z�4��8��(	�Ey*#j�2]��R����)��[N�R\$�<>:�>\$;�>��\r���H��T�\nw�N �wأ��<��Gw����\\Y�_�Rt^�>�\r}��S\rz�4=�\nL�%J��\",Z�8����i�0u�?�����s3#�ى�:���㽖��E]x���s^8��K^��*0��w����~���:��i���v2w����^7���7�c��u+U%�{P�*4̼�LX./!��1C��qx!H��Fd��L���Ġ�`6��5��f��Ć�=H�l �V1��\0a2�;��6����_ه�\0&�Z�S�d)KE'��n��[X��\0ZɊ�F[P�ޘ@��!��Y�,`�\"ڷ��0Ee9yF>��9b����F5:���\0}Ĵ��(\$����37H��� M�A��6R��{Mq�7G��C�C�m2�(�Ct>[�-t�/&C�]�etG�̬4@r>���<�Sq�/���Q�hm���������L��#��K�|���6fKP�\r%t��V=\"�SH\$�} ��)w�,W\0F��u@�b�9�\rr�2�#�D��X���yOI�>��n��Ǣ%���'��_��t\rτz�\\1�hl�]Q5Mp6k���qh�\$�H~�|��!*4����`S���S t�PP\\g��7�\n-�:袪p����l�B���7Өc�(wO0\\:��w���p4���{T��jO�6HÊ�r���q\n��%%�y']\$��a�Z�.fc�q*-�FW��k��z���j���lg�:�\$\"�N�\r#�d�Â���sc�̠��\"j�\r�����Ւ�Ph�1/��DA)���[�kn�p76�Y��R{�M�P���@\n-�a�6��[�zJH,�dl�B�h�o�����+�#Dr^�^��e��E��� ĜaP���JG�z��t�2�X�����V�����ȳ��B_%K=E��b弾�§kU(.!ܮ8����I.@�K�xn���:�P�32��m�H		C*�:v�T�\nR�����0u�����ҧ]�����P/�JQd�{L�޳:Y��2b��T ��3�4���c�V=���L4��r�!�B�Y�6��MeL������i�o�9< G��ƕЙMhm^�U�N����Tr5HiM�/�n�흳T��[-<__�3/Xr(<���������uҖGNX20�\r\$^��:'9�O��;�k����f��N'a����b�,�V��1��HI!%6@��\$�EGڜ�1�(mU��rս���`��iN+Ü�)���0l��f0��[U��V��-:I^��\$�s�b\re��ug�h�~9�߈�b�����f�+0�� hXrݬ�!\$�e,�w+����3��_�A�k��\nk�r�ʛcuWdY�\\�={.�č���g��p8�t\rRZ�v�J:�>��Y|+�@����C�t\r��jt��6��%�?��ǎ�>�/�����9F`ו��v~K�����R�W��z��lm�wL�9Y�*q�x�z��Se�ݛ����~�D�����x���ɟi7�2���Oݻ��_{��53��t���_��z�3�d)�C��\$?KӪP�%��T&��&\0P�NA�^�~���p� �Ϝ���\r\$�����b*+D6궦ψ��J\$(�ol��h&��KBS>���;z��x�oz>��o�Z�\nʋ[�v���Ȝ��2�OxِV�0f�����2Bl�bk�6Zk�hXcd�0*�KT�H=��π�p0�lV����\r���n�m��)(�(�:#����E��:C�C���\r�G\ré0��i����:`Z1Q\n:��\r\0���q���:`�-�M#}1;����q�#|�S���hl�D�\0fiDp�L��``����0y��1���\r�=�MQ\\��%oq��\0��1�21�1�� ���ќbi:��\r�/Ѣ� `)��0��@���I1�N�C�����O��Z��1���q1 ����,�\rdI�Ǧv�j�1 t�B���⁒0:�0��1�A2V���0���%�fi3!&Q�Rc%�q&w%��\r��V�#���Qw`�% ���m*r��y&i�+r{*��(rg(�#(2�(��)R@i�-�� ���1\"\0��R���.e.r��,�ry(2�C��b�!Bޏ3%ҵ,R�1��&��t��b�a\rL��-3�����\0��Bp�1�94�O'R�3*��=\$�[�^iI;/3i�5�&�}17�# ѹ8��\"�7��8�9*�23�!�!1\\\0�8��rk9�;S�23��ړ*�:q]5S<��#3�83�#e�=�>~9S螳�r�)��T*a�@і�bes���:-���*;,�ؙ3!i���LҲ�#1 �+n� �*��@�3i7�1���_�F�S;3�F�\rA��3�>�x:� \r�0��@�-�/��w��7��S�J3� �.F�\$O�B���%4�+t�'g�Lq\rJt�J��M2\r��7��T@���)ⓣd��2�P>ΰ��Fi಴�\nr\0��b�k(�D���KQ����1�\"2t����P�\r��,\$KCt�5��#��)��P#Pi.�U2�C�~�\"�");
    } elseif ($_GET["file"] == "functions.js") {
        header("Content-Type: text/javascript; charset=utf-8");
        echo
        lzw_decompress("f:��gCI��\n8��3)��7���81��x:\nOg#)��r7\n\"��`�|2�gSi�H)N�S��\r��\"0��@�)�`(\$s6O!��V/=��' T4�=��iS��6IO�G#�X�VC��s��Z1.�hp8,�[�H�~Cz���2�l�c3���s���I�b�4\n�F8T��I���U*fz��r0�E����y���f�Y.:��I��(�c��΋!�_l��^�^(��N{S��)r�q�Y��l٦3�3�\n�+G���y���i���xV3w�uh�^r����a۔���c��\r���(.��Ch�<\r)�ѣ�`�7���43'm5���\n�P�:2�P����q ���C�}ī�����38�B�0�hR��r(�0��b\\0�Hr44��B�!�p�\$�rZZ�2܉.Ƀ(\\�5�|\nC(�\"��P���.��N�RT�Γ��>�HN��8HP�\\�7Jp~���2%��OC�1�.��C8·H��*�j����S(�/��6KU����<2�pOI���`���ⳈdO�H��5�-��4��pX25-Ң�ۈ�z7��\"(�P�\\32:]U����߅!]�<�A�ۤ���iڰ�l\r�\0v��#J8��wm��ɤ�<�ɠ��%m;p#�`X�D���iZ��N0����9��占��`��wJ�D��2�9t��*��y��NiIh\\9����:����xﭵyl*�Ȉ��Y�����8�W��?���ޛ3���!\"6�n[��\r�*\$�Ƨ�nzx�9\r�|*3ףp�ﻶ�:(p\\;��mz���9����8N���j2����\r�H�H&��(�z��7i�k� ����c��e���t���2:SH�Ƞ�/)�x�@��t�ri9����8����yҷ���V�+^Wڦ��kZ�Y�l�ʣ���4��Ƌ������\\E�{�7\0�p���D��i�-T����0l�%=���˃9(�5�\n\n�n,4�\0�a}܃.��Rs\02B\\�b1�S�\0003,�XPHJsp�d�K� CA!�2*W����2\$�+�f^\n�1����zE� Iv�\\�2��.*A���E(d���b��܄��9����Dh�&��?�H�s�Q�2�x~nÁJ�T2�&��eR���G�Q��Tw�ݑ��P���\\�)6�����sh\\3�\0R	�'\r+*;R�H�.�!�[�'~�%t< �p�K#�!�l���Le����,���&�\$	��`��CX��ӆ0֭����:M�h	�ڜG��!&3�D�<!�23��?h�J�e ��h�\r�m���Ni�������N�Hl7��v��WI�.��-�5֧ey�\rEJ\ni*�\$@�RU0,\$U�E����ªu)@(t�SJk�p!�~���d`�>��\n�;#\rp9�jɹ�]&Nc(r���TQU��S��\08n`��y�b���L�O5��,��>���x���f䴒���+��\"�I�{kM�[\r%�[	�e�a�1! ���Ԯ�F@�b)R��72��0�\nW���L�ܜҮtd�+���0wgl�0n@��ɢ�i�M��\nA�M5n�\$E�ױN��l�����%�1 A������k�r�iFB���ol,muNx-�_�֤C( ��f�l\r1p[9x(i�BҖ��zQl��8C�	��XU Tb��I�`�p+V\0��;�Cb��X�+ϒ�s��]H��[�k�x�G*�]�awn�!�6�����mS�I��K�~/�ӥ7��eeN��S�/;d�A�>}l~��� �%^�f�آpڜDE��a��t\nx=�kЎ�*d���T����j2��j��\n��� ,�e=��M84���a�j@�T�s���nf��\n�6�\rd��0���Y�'%ԓ��~	�Ҩ�<���AH�G��8���΃\$z��{���u2*��a��>�(w�K.bP�{��o��´�z�#�2�8=�8>���A,�e���+�C�x�*���-b=m���,�a��lzk���\$W�,�m�Ji�ʧ���+���0�[��.R�sK���X��ZL��2�`�(�C�vZ������\$�׹,�D?H��NxX��)��M��\$�,��*\nѣ\$<q�şh!��S����xsA!�:�K��}�������R��A2k�X�p\n<�����l���3�����VV�}�g&Yݍ!�+�;<�Y��YE3r�َ��C�o5����ճ�kk�����ۣ��t��U���)�[����}��u��l�:D��+Ϗ _o��h140���0��b�K�㬒�����lG��#��������|Ud�IK���7�^��@��O\0H��Hi�6\r����\\cg\0���2�B�*e��\n��	�zr�!�nWz&� {H��'\$X �w@�8�DGr*���H�'p#�Į���\nd���,���,�;g~�\0�#����E��\r�I`��'��%E�.�]`�Л��%&��m��\r��%4S�v�#\n��fH\$%�-�#���qB�����Q-�c2���&���]�� �qh\r�l]�s���h�7�n#����-�jE�Fr�l&d����z�F6����\"���|���s@����z)0rpڏ\0�X\0���|DL<!��o�*�D�{.B<E���0nB(� �|\r\n�^���� h�!���r\$��(^�~����/p�q��B��O����,\\��#RR��%���d�Hj�`����̭ V� bS�d�i�E���oh�r<i/k\$-�\$o��+�ŋ��l��O�&evƒ�i�jMPA'u'���( M(h/+��WD�So�.n�.�n���(�(\"���h�&p��/�/1D̊�j娸E��&⦀�,'l\$/.,�d���W�bbO3�B�sH�:J`!�.���������,F��7(��Կ��1�l�s �Ҏ���Ţq�X\r����~R鰱`�Ҟ�Y*�:R��rJ��%L�+n�\"��\r��͇H!qb�2�Li�%����Wj#9��ObE.I:�6�7\0�6+�%�.����a7E8VS�?(DG�ӳB�%;���/<�����\r ��>�M��@���H�Ds��Z[tH�Enx(���R�x��@��GkjW�>���#T/8�c8�Q0��_�IIGII�!���YEd�E�^�td�th�`DV!C�8��\r���b�3�!3�@�33N}�ZB�3	�3�30��M(�>��}�\\�t�f�f���I\r���337 X�\"td�,\nbtNO`P�;�ܕҭ���\$\n����Zѭ5U5WU�^ho���t�PM/5K4Ej�KQ&53GX�Xx)�<5D��\r�V�\n�r�5b܀\\J\">��1S\r[-��Du�\r���)00�Y��ˢ�k{\n��#��\r�^��|�uܻU�_n�U4�U�~Yt�\rI��@䏳�R �3:�uePMS�0T�wW�X���D��KOU����;U�\n�OY��Y�Q,M[\0�_�D���W��J*�\rg(]�\r\"ZC��6u�+�Y��Y6ô�0�q�(��8}��3AX3T�h9j�j�f�Mt�PJbqMP5>������Y�k%&\\�1d��E4� �Yn���\$<�U]Ӊ1�mbֶ�^�����\"NV��p��p��eM���W�ܢ�\\�)\n �\nf7\n�2��r8��=Ek7tV����7P��L��a6��v@'�6i��j&>��;��`��a	\0pڨ(�J��)�\\��n��Ĭm\0��2��eqJ��P��t��fj��\"[\0����X,<\\������+md��~�����s%o��mn�),ׄ�ԇ�\r4��8\r����mE�H]�����HW�M0D�߀��~�ˁ�K��E}����|f�^���\r>�-z]2s�xD�d[s�t�S��\0Qf-K`���t���wT�9��Z��	�\nB�9 Nb��<�B�I5o�oJ�p��JNd��\r�hލ��2�\"�x�HC�ݍ�:���9Yn16��zr+z���\\�����m ��T ���@Y2lQ<2O+�%��.Ӄh�0A���Z��2R��1��/�hH\r�X��aNB&� �M@�[x��ʮ���8&L�V͜v�*�j�ۚGH��\\ٮ	���&s�\0Q��\\\"�b��	��\rBs��w��	���BN`�7�Co(���\nè���1�9�*E� �S��U�0U� t�'|�m���?h[�\$.#�5	 �	p��yB�@R�]���@|��{���P\0x�/� w�%�EsBd���CU�~O׷�P�@X�]����Z3��1��{�eLY���ڐ�\\�(*R`�	�\n������QCF�*�����霬�p�X|`N���\$�[���@�U������Z�`Zd\"\\\"����)��I�:�t��oD�\0[�����-���g���*`hu%�,����I�7ī�H�m�6�}��N�ͳ\$�M�UYf&1����e]pz���I��m�G/� �w �!�\\#5�4I�d�E�hq���Ѭk�x|�k�qD�b�z?���>���:��[�L�ƬZ�X��:�������j�w5	�Y��0 ���\$\0C��dSg����{�@�\n`�	���C ���M�����# t}x�N����{�۰)��C��FKZ�j��\0PFY�B�pFk��0<�>�D<JE��g\r�.�2��8�U@*�5fk��JD���4��TDU76�/��@��K+���J�����@�=��WIOD�85M��N�\$R�\0�5�\r��_���E���I�ϳN�l���y\\����qU��Q���\n@���ۺ�p���P۱�7ԽN\r�R{*�qm�\$\0R��ԓ���q�È+U@�B��Of*�Cˬ�MC��`_ ���˵N��T�5٦C׻� ��\\W�e&_X�_؍h���B�3���%�FW���|�Gޛ'�[�ł����V��#^\r��GR����P��Fg�����Yi ���z\n��+�^/�������\\�6��b�dmh��@q���Ah�),J��W��cm�em]�ӏe�kZb0�����Y�]ym��f�e�B;���O��w�apDW�����{�\0��-2/bN�sֽ޾Ra�Ϯh&qt\n\"�i�Rm�hz�e����FS7��PP�䖤��:B����sm��Y d���7}3?*�t����lT�}�~�����=c������	��3�;T�L�5*	�~#�A����s�x-7��f5`�#\"N�b��G����@�e�[�����s����-��M6��qq� h�e5�\0Ң���*�b�IS���Fή9}�p�-��`{��ɖkP�0T<��Z9�0<՚\r��;!��g�\r\nK�\n��\0��*�\nb7(�_�@,�e2\r�]�K�+\0��p C\\Ѣ,0�^�MЧ����@�;X\r��?\$\r�j�+�/��B��P�����J{\"a�6�䉜�|�\n\0��\\5���	156�� .�[�Uد\0d��8Y�:!���=��X.�uC����!S���o�p�B���7��ů�Rh�\\h�E=�y:< :u��2�80�si��TsB�@\$ ��@�u	�Q���.��T0M\\/�d+ƃ\n��=��d���A���)\r@@�h3���8.eZa|.�7�Yk�c���'D#��Y�@X�q�=M��44�B AM��dU\"�Hw4�(>��8���C�?e_`��X:�A9ø���p�G��Gy6��F�Xr��l�1��ػ�B�Å9Rz��hB�{����\0��^��-�0�%D�5F\"\"�����i�`��nAf� \"tDZ\"_�V\$��!/�D�ᚆ������٦�̀F,25�j�T��y\0�N�x\r�Yl��#��Eq\n��B2�\n��6���4���!/�\n��Q��*�;)bR�Z0\0�CDo�˞�48������e�\n�S%\\�PIk��(0��u/��G������\\�}�4Fp��G�_�G?)g�ot��[v��\0��?b�;��`(�ی�NS)\n�x=��+@��7��j�0��,�1Åz����>0��Gc��L�VX�����%����Q+���o�F���ܶ�>Q-�c���l����w��z5G��@(h�c�H��r?��Nb�@�������lx3�U`�rw���U���t�8�=�l#���l�䨉8�E\"����O6\n��1e�`\\hKf�V/зPaYK�O�� ��x�	�Oj���r7�F;��B����̒��>�Ц�V\rĖ�|�'J�z����#�PB��Y5\0NC�^\n~LrR��[̟Rì�g�eZ\0x�^�i<Q�/)�%@ʐ��fB�Hf�{%P�\"\"���@���)���DE(iM2�S�*�y�S�\"���e̒1��ט\n4`ʩ>��Q*��y�n����T�u�����~%�+W��XK���Q�[ʔ��l�PYy#D٬D<�FL���@�6']Ƌ��\rF�`�!�%\n�0�c���˩%c8WrpG�.T�Do�UL2�*�|\$�:�Xt5�XY�I�p#� �^\n��:�#D�@�1\r*�K7�@D\0��C�C�xBh�EnK�,1\"�*y[�#!�י�ٙ���l_�/��x�\0���5�Z��4\0005J�h\"2���%Y���a�a1S�O�4��%ni��P��ߴq�_ʽ6���~��I\\���d���d������D�����3g^��@^6����_�HD�.ksL��@��Ɉ�n�I���~�\r�b�@�Ӏ�N�t\0s���]:u��X�b@^�1\0���2?�T��6dLNe��+�\0�:�Ё�l��z6q=̺x���N6��O,%@s�0\n�\\)�L<�C�|���P��b����A>I���\"	��^K4��gIX�i@P�jE�&/1@�f�	�N�x0coaߧ����,C'�y#6F@�Р��H0�{z3t�|cXMJ.*B�)ZDQ���\0��T-v�X�a*��,*�<b���#xј�d�P��KG8�� y�K	\\#=�)�gȑh�&�8])�C�\nô��9�z�W\\�g�M 7��!��������,��9���\$T\"�,��%.F!˚ A�-�����-�g��\0002R>KE�'�U�_I���9�˼�j(�Q��@�@�4/�7���'J.�RT�\0]KS�D���Ap5�\r�H0!�´e	d@Rҝ�ิ�9�S�;7�H�B�bx�J��_�vi�U`@���SAM��X��G�Xi��U*��������'��:V�WJv�D���N'\$�zh\$d_y���Z]����Y���8ؔ���]�P�*h���֧e;��pe��\$k�w��*7N�DTx_�ԧ�Gi�&P�Ԇ�t͆�b�\\E�H\$i�E\"cr��0l�?>��C(�W@3���22a���I����{�B`�ڳiŸGo^6E\r��G�M�p1i�I��X�\0003�2�K�����zl&ֆ�'IL�\\�\"�7�>�j(>�j�FG_��& 10I�A31=h q\0�F����ķ��_�J���ԳVΖ��܆q�՚��	��(/�dOC�_sm�<g�x\0��\"��\n@EkH\0�J���8�(���km[����S4�\nY40��+L\n������#Bӫb��%R֖��׭��R:�<\$!ۥr�;���	%|ʨ�(�|�H�\0�������]�cҡ=0��Z�\"\"=�X��)�f�N��6V}F��=[���ৢhu�-��\0t��bW~��Q��iJ���L�5׭q#kb���Wn���Q�T�!���e�nc�S�[+ִE�<-��a]Ń��Yb�\n\nJ~�|JɃ8� �Lp����o� �N�ܨ�J.��ŃS��2c9�j�y�-`a\0��*�ֈ@\0+��mg��6�1��Me\0��Q �_�}!I��GL�f)�X�o,�Shx�\0000\"h�+L�M�� �ј��Z	j�\0���/��\$��>u*�Z9��Z�e��+J����tz������R�Kԯ���Dy���q�0C�-f��m����BI�|��HB��sQl�X��.����|�c���[��ZhZ��l���x�@'��ml�KrQ�26��]�ҷn�d[��񎩇d���\"GJ9u��B�o��Zߖ�a��n@��n�lW|*gX�\nn2�F�|x`Dk��uPP�!Q\rr��`W/���	1�[-o,71bUs����N�7����Gq�.\\Q\"CCT\"�����*?u�ts�����]�٩Pz[�[YFϹ��FD3�\"����]�u۝)wz�:#���Iiw��pɛ��{�o�0n��;��\\�x���\0q��m���&�~��7����9[�H�qdL�O�2�v�|B�t��\\Ƥ�Hd���H�\" ��N\n\0��G�g�F��F�}\"�&QEK��{}\ryǎ��rכt������7�Nuó[A�gh;S�.Ҡ���¥|y��[Ն_b�Ȩ�!+R��ZX�@0N����P���%�jD�¯z	���[�U\"�{e�8��>�EL4Jн�0����7 ��d�� �Q^`0`�����]c�<g@��hy8��p.ef\n��eh��aX����mS��jBژQ\"�\r���K3�=>ǪAX�[,,\"'<���%�a��Ӵ��.\$�\0�%\0�sV���p�M\$�@j���>���}Ve�\$@�̈́#���(3:�`�U�Y��u�������@�V#E�G/��XD\$�h��av��xS\"]k18a�я�9dJROӊs�`EJ����Uo�m{l�B8���(\n}ei�b��, �;�N��͇�Q�\\�ǸI5yR�\$!>\\ʉ�g�uj*?n�M�޲h��\r%���U(d��N�d#}�pA:����-\\�A�*�4�2I���\r�֣�� 0h@\\Ե��8�3�rq]���d8\"�Q����ƙ:c��y�4	�ᑚda�Π6>U�A����:��@�2���\$�eh2���F��əN�+���\r�Ԁ(�Ar��d*�\0[�#cj����>!(�S���L�e�T��M	9\0W:�BD���3J���_@s��rue������ +�'B��}\"B\"�z2��r��l�xF[�L�˲Ea9��cdb��^,�UC=/2�����/\$�C�#��8�}D���6�`^;6B0U7�_=	,�1�j1V[�.	H9(1���ҏLz�C�	�\$.A�fh㖫����DrY	�H�e~o�r19��م\\�߄P�)\"�Q��,�e��L��w0�\0������;w�X�ǝ���qo���~�����>9�>}��dc�\0��g��f��q�&9���-�J#����3^4m/���\0\0006��n8��>䈴.ӗ��cph��������_A@[��7�|9\$pMh�>���5�K���E=h��A�t�^�V�	�\"�	c�B;���i��QҠt����@,\n�)���s�`����;�4����I������y��-�0yeʨ�U��B�v��3H�P�G�5��s|��\r���\$0����1��l3��(*oF~PK��.�,'�J/�Ӳ�t���d�:��n�\n��j��Y�z�(����w���Z�#Z�	Io�@1�λ\$��=VWz�	n�B�a���A��q�@��I�p	@�5Ӗ�lH{U��oX��f��ӿ\\z��.���,-\\ڗ^y n^���Bq����zX㉡�\$�*J72�D4.����!�M0��D��F����G��L�m�c*m�cI��5Ɍ�^�t���jl�7替S�Q��.i����h��L�ڱB6Ԅh�&�J��l\\��We�c�f%kj�� �p�R=��i�@.��(�2�klHUW\"�o�j���p!S5��pL'`\0�O *�Q3X��lJ\08\n�\r���*�a��떞��r�`<�&�XBh�8!x��&�Bht�\$���]�n߆���cL��[Ƶ�d��<`���\0���ς�aw�O%;���BC��Q�\r̭�����p����PQ�Z���Z�Au=N&�ia\n�mK6I}��n	��t\nd)����bp��\"��g'�0�7�u�&@�7�8X�N��x������\$B��ZB/�M�gB�i��ѧ�\\�m�mI�Ā��;5=#&4����P�Ս����q�A��\\�,q�cޟ\nc�B�����w\0BgjD�@;�=0m�k��\rĲ�`��'5���k-�{��\0�_�Mu����2��׆����q����>)9�W\n�d+��ԧ�G\r��n4���O�:5���8��1�:Κ?��(yGgWK�\r�7����m5.��e�H�hJ�Ak#��L�..�\\�=��U�Є����:�>7�W+^yD���b��G��OZ�4�r�(|x���Pr��,y���8qaܩO2��k�n��#p2��ǈ�ؔ.��c��U�c����łj�\$��8Ĭ~��7ZR:�׆8�9Ψw(a�L�%�-,��쿌#�f�%8��|�c������%X�W�\n}6��H����˞��#�&J,'z�M�M�����ຑ܆� ���/y6YQ���ںdәd����:����E��p2g�g�/�,����Ո'8�^;�UWN�����{�OC�����z�iKX��ڔN�dG�RCJY����i���y#>zS�MUc�������RORԾ�0�)�0��]:=Ϟ�t�����'\$�s�rF���67	=\$B��!qs	1\"���v��%��I�l<�b!ۮ6(Cd-�^<H`~2�K��zK�ٜ�Ա���y,qA�*�\0}��C�pb�\\�S�5����'(����|�M����W��5;\$5�T|��;k���t���@��;9�)��;i�.�;���_����F�=�D�M`H���\0�	 N @�%w��d��Pb�\$H|k�[��dCI!:l��,���<��u�t���NeϝW^�w�'6���D��f�u �ihI�Z:��~��ϣ�r���z�3�+�uoC�s2�b�ua�X��wWK�	HԶ27>�W���y����M�J��rpT��L��|`f��:���A�t�d|i��[w��j���W� 7���au�����e��A5�Q' ʐ\0��3�Ҿ\$����\rk)�a;���H=��֐~�IG�I�<���\"���I1'蠙�Gcm\0P\n�w��#�>���xB\"��Em|��2�\$}<3P�YX�go�d߶�<�����qE\"`���4�g�8r�]\n����:��qVb�T��m���9K&ғĤ�m�7)@��Qz���=��ߵű�H\n���}O�i}�\r٣.��v��p�JW&�u�55�0	�5��P�I��\n�����{ \r�m�@�@ �P� x�4i4�+@\0,͛\\�C1ӎ誕L���>n�\0���	 #������#@]/4JR� IR��r�<�ǯ��j��?1Mv�\n�Z�`v\0a�-�b�ψ��+��-�yA[|�7\r��\$���ZʭR�t�ޓ�����CErL	��r�g�e�R/�`�J	7�~�%Xo�4�di\"�Qr��I�:QD������QQM~\0Q��)ة�*,i\0�_(,�^�+c����&�S����~o�p��C���������@��g�ր�B���A~s�֤�\0]���/���z���Ã(_�zF��Oڿ\\\r�vE��K0�<?���?����P���=�`���D�^��=����v*��|\n���@�����-��\\?�k�Di4�����?���0��l#{�%\r3�F�����<�P<�k�4��*@��}?F� ���\0];���?�[\r:\0؜�d�����N�D�2���?\\���h��U�\0/֢�����	?�Q4�c�2o��5+�\r��L��?�����N�(����ڌ�(\0��|�>����A[?�[�/ɿ���;�]/�\\����}s�o��`2���vh]0�\0!PAX�J��l<\r�/\"�(��D� \\T�va���R�O���.#�PE�H#��C�*�)��>tk���\n�P���.0E���IH�\$��f%P�0]%�ɻ�XFA@4[���\0�	�)�P A�M`�h��\0�pd@��~�A@���A���kA�\n�o@H�֡r\n�\$�C�C�;\0��-����)�8�������s5@/\0z�C~ �� �eB^����\"P�\0X��K1�^{�\n�	!l����Z���QR���41�j�Z��ߟ�㩋á�,gI�<�����HO���f�\"�H,R��^���y��B`҉����~���ڴ}��ۖ� N፩q�:�~�M>^k�'\$��ʈj�\n\"	#;`�`Pq�ǿ\\\\+�<�:��ca`�\n��dd\n�@jn5����p�2���p��@�0���&0r������.H���h\r��wȴ��B�	@�|~�\r\0C\0�1�:CQ1\\pӑ�Y[���(Б.RG�Ѝ�0\"8�P��<%�<#�BX73�₤����5B�	t(��b���4<&\r������V\0G\n;��\\�");
    } elseif ($_GET["file"] == "jush.js") {
        header("Content-Type: text/javascript; charset=utf-8");
        echo
        lzw_decompress("v0��F����==��FS	��_6MƳ���r:�E�CI��o:�C��Xc��\r�؄J(:=�E���a28�x�?�'�i�SANN���xs�NB��Vl0���S	��Ul�(D|҄��P��>�E�㩶yHch��-3Eb�� �b��pE�p�9.����~\n�?Kb�iw|�`��d.�x8EN��!��2��3���\r���Y���y6GFmY�8o7\n\r�0��\0�Dbc�!�Q7Шd8���~��N)�Eг`�Ns��`�S)�O���/�<�x�9�o�����3n��2�!r�:;�+�9�CȨ���\n<�`��b�\\�?�`�4\r#`�<�Be�B#�N ��\r.D`��j�4���p�ar��㢺�>�8�\$�c��1�c���c����{n7����A�N�RLi\r1���!�(�j´�+��62�X�8+����.\r����!x���h�'��6S�\0R����O�\n��1(W0���7q��:N�E:68n+��մ5_(�s�\r��/m�6P�@�EQ���9\n�V-���\"�.:�J��8we�q�|؇�X�]��Y X�e�zW�� �7��Z1��hQf��u�j�4Z{p\\AU�J<��k��@�ɍ��@�}&���L7U�wuYh��2��@�u� P�7�A�h����3Û��XEͅZ�]�l�@Mplv�)� ��HW���y>�Y�-�Y��/�������hC�[*��F�#~�!�`�\r#0P�C˝�f������\\���^�%B<�\\�f�ޱ�����&/�O��L\\jF��jZ�1�\\:ƴ>�N��XaF�A�������f�h{\"s\n�64������?�8�^p�\"띰�ȸ\\�e(�P�N��q[g��r�&�}Ph���W��*��r_s�P�h���\n���om������#���.�\0@�pdW �\$Һ�Q۽Tl0� ��HdH�)��ۏ��)P���H�g��U����B�e\r�t:��\0)\"�t�,�����[�(D�O\nR8!�Ƭ֚��lA�V��4�h��Sq<��@}���gK�]���]�=90��'����wA<����a�~��W��D|A���2�X�U2��yŊ��=�p)�\0P	�s��n�3�r�f\0�F���v��G��I@�%���+��_I`����\r.��N���KI�[�ʖSJ���aUf�Sz���M��%��\"Q|9��Bc�a�q\0�8�#�<a��:z1Uf��>�Z�l������e5#U@iUG��n�%Ұs���;gxL�pP�?B��Q�\\�b��龒Q�=7�:��ݡQ�\r:�t�:y(� �\n�d)���\n�X;����CaA�\r���P�GH�!���@�9\n\nAl~H���V\ns��ի�Ư�bBr���������3�\r�P�%�ф\r}b/�Α\$�5�P�C�\"w�B_��U�gAt��夅�^Q��U���j���Bvh졄4�)��+�)<�j^�<L��4U*���Bg�����*n�ʖ�-����	9O\$��طzyM�3�\\9���.o�����E(i������7	tߚ�-&�\nj!\r��y�y�D1g���]��yR�7\"������~����)TZ0E9M�YZtXe!�f�@�{Ȭyl	8�;���R{��8�Į�e�+UL�'�F�1���8PE5-	�_!�7��[2�J��;�HR��ǹ�8p痲݇@��0,ծpsK0\r�4��\$sJ���4�DZ��I��'\$cL�R��MpY&����i�z3G�zҚJ%��P�-��[�/x�T�{p��z�C�v���:�V'�\\��KJa��M�&���Ӿ\"�e�o^Q+h^��iT��1�OR�l�,5[ݘ\$��)��jLƁU`�S�`Z^�|��r�=��n登��TU	1Hyk��t+\0v�D�\r	<��ƙ��jG���t�*3%k�YܲT*�|\"C��lhE�(�\r�8r��{��0����D�_��.6и�;����rBj�O'ۜ���>\$��`^6��9�#����4X��mh8:��c��0��;�/ԉ����;�\\'(��t�'+�����̷�^�]��N�v��#�,�v���O�i�ϖ�>��<S�A\\�\\��!�3*tl`�u�\0p'�7�P�9�bs�{�v�{��7�\"{��r�a�(�^��E����g��/���U�9g���/��`�\nL\n�)���(A�a�\" ���	�&�P��@O\n師0�(M&�FJ'�! �0�<�H�������*�|��*�OZ�m*n/b�/�������.��o\0��dn�)����i�:R���P2�m�\0/v�OX���Fʳψ���\"�����0�0�����0b��gj��\$�n�0}�	�@�=MƂ0n�P�/p�ot������.�̽�g\0�)o�\n0���\rF����b�i��o}\n�̯�	NQ�'�x�Fa�J���L������\r��\r����0��'��d	oep��4D��ʐ�q(~�� �\r�E��pr�QVFH�l��Kj���N&�j!�H`�_bh\r1���n!�Ɏ�z�����\\��\r���`V_k��\"\\ׂ'V��\0ʾ`AC������V�`\r%�����\r����k@N����B�횙� �!�\n�\0Z�6�\$d��,%�%la�H�\n�#�S\$!\$@��2���I\$r�{!��J�2H�ZM\\��hb,�'||cj~g�r�`�ļ�\$���+�A1�E���� <�L��\$�Y%-FD��d�L焳��\n@�bVf�;2_(��L�п��<%@ڜ,\"�d��N�er�\0�`��Z��4�'ld9-�#`��Ŗ����j6�ƣ�v���N�͐f��@܆�&�B\$�(�Z&���278I ��P\rk\\���2`�\rdLb@E��2`P( B'�����0�&��{���:��dB�1�^؉*\r\0c<K�|�5sZ�`���O3�5=@�5�C>@�W*	=\0N<g�6s67Sm7u?	{<&L�.3~D��\rŚ�x��),r�in�/��O\0o{0k�]3>m��1\0�I@�9T34+ԙ@e�GFMC�\rE3�Etm!�#1�D @�H(��n ��<g,V`R]@����3Cr7s~�GI�i@\0v��5\rV�'������P��\r�\$<b�%(�Dd��PW����b�fO �x\0�} ��lb�&�vj4�LS��ִԶ5&dsF M�4��\".H�M0�1uL�\"��/J`�{�����xǐYu*\"U.I53Q�3Q��J��g��5�s���&jь��u�٭ЪGQMTmGB�tl-c�*��\r��Z7���*hs/RUV����B�Nˈ�����Ԋ�i�Lk�.���t�龩�rYi���-S��3�\\�T�OM^�G>�ZQj���\"���i��MsS�S\$Ib	f���u����:�SB|i��Y¦��8	v�#�D�4`��.��^�H�M�_ռ�u��U�z`Z�J	e��@Ce��a�\"m�b�6ԯJR���T�?ԣXMZ��І��p����Qv�j�jV�{���C�\r��7�Tʞ� ��5{P��]�\r�?Q�AA������2񾠓V)Ji��-N99f�l Jm��;u�@�<F�Ѡ�e�j��Ħ�I�<+CW@�����Z�l�1�<2�iF�7`KG�~L&+N��YtWH飑w	����l��s'g��q+L�zbiz���Ţ�.Њ�zW�� �zd�W����(�y)v�E4,\0�\"d��\$B�{��!)1U�5bp#�}m=��@�w�	P\0�\r�����`O|���	�ɍ����Y��JՂ�E��Ou�_�\n`F`�}M�.#1��f�*�ա��  �z�uc���� xf�8kZR�s2ʂ-���Z2�+�ʷ�(�sU�cD�ѷ���X!��u�&-vP�ر\0'L�X �L����o	��>�Վ�\r@�P�\rxF��E��ȭ�%����=5N֜��?�7�N�Å�w�`�hX�98 �����q��z��d%6̂t�/������L��l��,�Ka�N~�����,�'�ǀM\rf9�w��!x��x[�ϑ�G�8;�xA��-I�&5\$�D\$���%��xѬ���´���]����&o�-3�9�L��z���y6�;u�zZ ��8�_�ɐx\0D?�X7����y�OY.#3�8��ǀ�e�Q�=؀*��G�wm ���Y�����]YOY�F���)�z#\$e��)�/�z?�z;����^��F�Zg�����������`^�e����#�������?��e��M��3u�偃0�>�\"?��@חXv�\"������*Ԣ\r6v~��OV~�&ר�^g���đٞ�'��f6:-Z~��O6;zx��;&!�+{9M�ٳd� \r,9���W��ݭ:�\r�ٜ��@睂+��]��-�[g��ۇ[s�[i��i�q��y��x�+�|7�{7�|w�}����E��W��Wk�|J؁��xm��q xwyj���#��e��(�������ߞþ��� {��ڏ�y���M���@��ɂ��Y�(g͚-��������J(���@�;�y�#S���Y��p@�%�s��o�9;�������+��	�;����ZNٯº��� k�V��u�[�x��|q��ON?���	�`u��6�|�|X����س|O�x!�:���ϗY]�����c���\r�h�9n�������8'������\rS.1��USȸ��X��+��z]ɵ��?����C�\r��\\����\$�`��)U�|ˤ|Ѩx'՜����<�̙e�|�ͳ����L���M�y�(ۧ�l�к�O]{Ѿ�FD���}�yu��Ē�,XL\\�x��;U��Wt�v��\\OxWJ9Ȓ�R5�WiMi[�K��f(\0�dĚ�迩�\r�M����7�;��������6�KʦI�\r���xv\r�V3���ɱ.��R������|��^2�^0߾\$�Q��[�D��ܣ�>1'^X~t�1\"6L���+��A��e�����I��~����@����pM>�m<��SK��-H���T76�SMfg�=��GPʰ�P�\r��>�����2Sb\$�C[���(�)��%Q#G`u��Gwp\rk�Ke�zhj��zi(��rO�������T=�7���~�4\"ef�~�d���V�Z���U�-�b'V�J�Z7���)T��8.<�RM�\$�����'�by�\n5����_��w����U�`ei޿J�b�g�u�S��?��`���+��� M�g�7`���\0�_�-���_��?�F�\0����X���[��J�8&~D#��{P���4ܗ��\"�\0��������@ғ��\0F ?*��^��w�О:���u��3xK�^�w���߯�y[Ԟ(���#�/zr_�g��?�\0?�1wMR&M���?�St�T]ݴG�:I����)��B�� v����1�<�t��6�:�W{���x:=��ޚ��:�!!\0x�����q&��0}z\"]��o�z���j�w�����6��J�P۞[\\ }��`S�\0�qHM�/7B��P���]FT��8S5�/I�\r�\n ��O�0aQ\n�>�2�j�;=ڬ�dA=�p�VL)X�\n¦`e\$�TƦQJ��k�7�*O�� .����ġ�\r���\$#p�WT>!��v|��}�נ.%��,;�������f*?�焘��\0��pD��! ��#:MRc��B/06���	7@\0V�vg����hZ\nR\"@��F	����+ʚ�E�I�\n8&2�bX�PĬ�ͤ=h[���+�ʉ\r:��F�\0:*��\r}#��!\"�c;hŦ/0��ޒ�Ej�����]�Z�����\0�@iW_���h�;�V��Rb��P%!��b]SB����Ul	����r��\r�-\0��\"�Q=�Ih����	 F���L��FxR�э@�\0*�j5���k\0�0'�	@El�O���H�Cx�@\"G41�`ϼP(G91��\0��\"f:Qʍ�@�`'�>7�Ȏ�d�����R41�>�rI�H�Gt\n�R�H	��bҏ��71���f�h)D��8�B`���(�V<Q�8c? 2���E�4j\0�9��\r�͐�@�\0'F�D��,�!��H�=�*��E�(���?Ѫ&xd_H�ǢE�6�~�u��G\0R�X��Z~P'U=���@����l+A�\n�h�IiƔ���PG�Z`\$�P������.�;�E�\0�}� ��Q�����%���jA�W�إ\$�!��3r1� {Ӊ%i=IfK�!�e\$���8�0!�h#\\�HF|�i8�tl\$���l����l�i*(�G���L	 �\$��x�.�q\"�Wzs{8d`&�W��\0&E����15�jW�b��ć��V�R����-#{\0�Xi���g*��7�VF3�`妏�p@��#7�	�0��[Ү���[�éh˖\\�o{���T���]��Ŧᑀ8l`f@�reh��\n��W2�*@\0�`K(�L�̷\0vT��\0�c'L����:�� 0��@L1�T0b��h�W�|\\�-���DN��\ns3��\"����`Ǣ�肒�2��&��\r�U+�^��R�eS�n�i0�u˚b	J����2s��p�s^n<���♱�Fl�a�\0���\0�mA2�`|؟6	��nr���\0Dټ��7�&m�ߧ-)���\\���݌\n=���;*���b��蓈�T��y7c��|o�/����:���t�P�<��Y:��K�&C��'G/�@��Q�*�8�v�/��&���W�6p.\0�u3����Bq:(eOP�p	�駲���\r���0�(ac>�N�|��	�t��\n6v�_��e�;y���6f���gQ;y�β[S�	��g�ǰ�O�ud�dH�H�=�Z\r�'���qC*�)����g��E�O�� \"��!k�('�`�\nkhT��*�s��5R�E�a\n#�!1�����\0�;��S�iȼ@(�l���I� �v\r�nj~��63��Έ�I:h����\n.��2pl�9Bt�0\$b��p+�ǀ*�tJ����s�JQ8;4P(��ҧѶ!��.Ppk@�)6�5��!�(��\n+��{`=��H,Ɂ\\Ѵ�4�\"[�C���1���-���luo��4�[���E�%�\"��w] �(� ʏTe��)�K�A�E={ \n�`;?���-�G�5I���.%�����q%E���s���gF��s	�����K�G��n4i/,�i0�u�x)73�Szg���V[��h�Dp'�L<TM��jP*o�≴�\nH���\n�4�M-W�N�A/@�8mH��Rp�t�p�V�=h*0��	�1;\0uG��T6�@s�\0)�6��ƣT�\\�(\"���U,�C:��5i�K�l���ۧ�E*�\"�r����.@jR�J�Q��/��L@�SZ���P�)(jj�J������L*���\0���\r�-��Q*�Qڜg��9�~P@���H���\n-e�\0�Qw%^ ET�< 2H�@޴�e�\0� e#;��I�T�l���+A+C*�Y���h/�D\\�!鬚8�»3�AЙ��E��E�/}0t�J|���1Qm��n%(�p��!\n��±U�)\rsEX���5u%B- ��w]�*��E�)<+��qyV�@�mFH ���BN#�]�YQ1��:��V#�\$������<&�X������x��t�@]G��Զ��j)-@�q��L\nc�I�Y?qC�\r�v(@��X\0Ov�<�R�3X���Q�J����9�9�lxCuīd�� vT�Zkl\r�J��\\o�&?�o6E�q������\r���'3��ɪ�J�6�'Y@�6�FZ50�V�T�y���C`\0��VS!���&�6�6���rD�f`ꛨJvqz���F�����@�ݵ��҅Z.\$kXkJ�\\�\"�\"�֝i��:�E���\roX�\0>P��P�mi]\0�����aV��=���I6�����jK3���Z�Q�m�E���b�0:�32�V4N6����!�l�^ڦ�@h�hU��>:�	��E�>j�����0g�\\|�Sh�7y�ބ�\$��,5aė7&��:[WX4��q� ���J���ׂ�c8!�H���VD�Ď�+�D�:����9,DUa!�X\$��Я�ڋG�܌�B�t9-+o�t��L��}ĭ�qK��x6&��%x��tR�����\"�π�R�IWA`c���}l6��~�*�0vk�p���6��8z+�q�X��w*�E��IN�����*qPKFO\0�,�(��|�����k *YF5���;�<6�@�QU�\"��\rb�OAXÎv��v�)H��o`ST�pbj1+ŋ�e��� ʀQx8@�����5\\Q�,���ĉN��ޘb#Y�H��p1����kB�8N�o�X3,#Uک�'�\"�销�eeH#z��q^rG[��:�\r�m�ng����5��V�]��-(�W�0���~kh\\��Z��`��l����k �o�j�W�!�.�hF���[t�A�w�e�M૫��3!����nK_SF�j���-S�[r�̀w��0^�h�f�-����?���X�5�/������IY �V7�a�d �8�bq��b�n\n1YR�vT���,�+!����N�T��2I�߷�����������K`K\"�����O)\nY��4!}K�^����D@��na�\$@� ��\$A��j����\\�D[=�	bHp�SOAG�ho!F@l�U��`Xn\$\\�͈_��˘`���HB��]�2���\"z0i1�\\�����w�.�fy޻K)����� p�0���X�S>1	*,]��\r\"���<cQ��\$t��q��.��	<��+t,�]L�!�{�g���X��\$��6v����� ����%G�H������E����X��*��0ۊ)q�nC�)I���\"�����툳�`�KF����@�d�5��A��p�{�\\���pɾN�r�'�S(+5�Њ+�\"�Ā�U0�iː����!nM��brK���6ú�r���|a����@�x|��ka�9WR4\"?�5��p�ۓ��k�rĘ����ߒ����7Hp��5�YpW���G#�rʶAWD+`��=�\"�}�@H�\\�p���Ѐ�ߋ�)C3�!�sO:)��_F/\r4���<A��\nn�/T�3f7P1�6����OYлϲ���q��;�؁���a�XtS<��9�nws�x@1Ξxs�?��3Ş@���54��o�ȃ0����pR\0���������yq��L&S^:��Q�>\\4OIn��Z�n��v�3�3�+P��L(�������.x�\$�«C��Cn�A�k�c:L�6���r�w���h����nr�Z��=�=j�ђ���6}M�G�u~�3���bg4���s6s�Q��#:�3g~v3���<�+�<���a}ϧ=�e�8�'n)ӞcC�z��4L=h��{i����J�^~��wg�D�jL���^����=6ΧN�Ӕ����\\��D���N���E�?h�:S�*>��+�u�hh҅�W�E1j�x����t�'�t�[��wS���9��T��[�,�j�v����t��A#T���枂9��j�K-��ޠ���Y�i�Qe?��4Ӟ���_Wz����@JkWY�h��pu����j|z4���	�i��m�	�O5�\0>�|�9�ז��轠��gVy��u���=}gs_���V�sծ{�k�@r�^���(�w����H'��a�=i��N�4����_{�6�tϨ��ϗe�[�h-��Ul?J��0O\0^�Hl�\0.��Z������xu���\"<	�/7���� ���i:��\nǠ���;��!�3���_0�`�\0H`���2\0��H�#h�[�P<��עg����m@~�(��\0ߵk�Y�v���#>���\nz\n�@�Q�\n(�G��\n����'k����5�n�5ۨ�@_`Ї_l�1���wp�P�w���\0��c��oEl{�ݾ�7����o0����Ibϝ�n�z����﷛� ���{�8�w�=��|�/y�3a�߼#xq����@��ka�!�\08d�m��R[wvǋRGp8���v�\$Z���m��t��������������ǽ����u�o�p�`2��m|;#x�m�n�~;��V�E�������3O�\r�,~o�w[��N��}�� �cly��O����;��?�~�^j\"�Wz�:�'xW��.�	�u�(��Ý�q��<g��v�hWq��\\;ߟ8��)M\\��5vڷx=h�i�b-���|b���py�DЕHh\rce��y7�p��x��G�@D=� ����1��!4Ra\r�9�!\0'�Y����@>iS>����o��o��fsO 9�.����\"�F��l��20��E!Q���ːD9d�BW4��\0��y`RoF>F�a��0�����0	�2�<�I�P'�\\���I�\0\$��\n R�aU�.�sЄ��\"���1І�e�Y砢�Z�q��1�|��#�G!�P�P\0|�H�Fnp>W�:��`YP%�ď�\n�a8��P>�����`]��4�`<�r\0�Î������z�4����8�����4�`m�h:�Ϊ�HD���j�+p>*����8�ՠ0�8�A��:���с�]w�ú�z>9\n+�������:����ii�PoG0���1��)�Z�ږ�n�����eR֖��g�M�����gs�LC�r�8Ѐ�!�����3R)��0�0��s�I��J�VPpK\n|9e[���ˑ��D0����z4ϑ�o������,N8n��s�#{蓷z3�>�BS�\";�e5VD0���[\$7z0������=8�	T 3���Q�'R������n��L�yŋ��'�\0o��,��\0:[}(���|���X�>xvqW�?tB�E1wG;�!�݋5΀|�0��JI@��#���uņI��\\p8�!'�]߮��l-�l�S�B��,ӗ���]��1�ԕH��N�8%%�	��/�;�FGS���h�\\ل�c�t����2|�W�\$t��<�h�O��+#�B�aN1��{��y�w���2�\\Z&)�d�b'��,Xxm�~�H��@:d	>=-��lK��܏�J�\0���́�@�rϥ�@\"�(A����Z�7�h>����\\����#>���\0��Xr�Y��Yxŝ�q=:��Թ�\rl�o�m�gb��������D_�Tx�C���0.��y��R]�_���Z�ǻW�I��G��	Mɪ(��|@\0SO��s� {��@k}��FXS�b8��=��_����l�\0�=�g��{�H��yG���� s�_�J\$hk�F�q������d4ω����'���>vϏ��!_7�Vq��@1z�uSe��jKdyu���S�.�2�\"�{��K���?�s��˦h��R�d��`:y����Gھ\nQ�����ow��'��hS��>���L�X}��e���G��@9��퟈�W�|��Ϲ�@�_��uZ=��,���!}���\0�I@��#��\"�'�Y`��\\?��p��,G����ל_��'�G����	�T��#�o��H\r��\"���o�}��?��O鼔7�|'���=8�M��Q�y�a�H�?��߮� ���\0���bUd�67���I O����\"-�2_�0�\r�?�������hO׿�t\0\0002�~�° 4���K,��oh��	Pc���z`@��\"�����H; ,=��'S�.b��S����Cc���욌�R,~��X�@ '��8Z0�&�(np<pȣ�32(��.@R3��@^\r�+�@�,���\$	ϟ��E���t�B,���⪀ʰh\r�><6]#���;��C�.Ҏ����8�P�3��;@��L,+>���p(#�-�f1�z���,8�ߠ��ƐP�:9����R�۳����)e\0ڢR��!�\nr{��e����GA@*��n�D��6��������N�\r�R���8QK�0��颽��>PN���IQ=r<�;&��f�NGJ;�UA�����A�P�&������`�����);��!�s\0���p�p\r�����n(��@�%&	S�dY����uC�,��8O�#�����o���R�v,��#�|7�\"Cp����B�`�j�X3�~R�@��v�����9B#���@\n�0�>T�����-�5��/�=� ���E����\n��d\"!�;��p*n��Z�\08/�jX�\r��>F	Pϐe>��O��L����O0�\0�)�k���㦃[	��ϳ���'L��	����1 1\0��C�1T�`����Rʐz�Ě����p��������< .�>�5��\0���>� Bnˊ<\"he�>к�î��s�!�H�{ܐ�!\r�\r�\"��|��>R�1d���\"U@�D6����3���>o\r����v�L:K�2�+�0쾁�>��\0�� ���B�{!r*H��y;�`8\0��د��d����\r�0���2A����?��+�\0�Å\0A����wS��l����\r[ԡ�6�co�=����0�z/J+�ꆌ�W[��~C0��e�30HQP�DPY�}�4#YD���p)	�|�@���&�-��/F�	�T�	����aH5�#��H.�A>��0;.���Y�ġ	�*�D2�=3�	pBnuDw\n�!�z�C�Q \0��HQ4D�*��7\0�J��%ıp�uD�(�O=!�>�u,7��1��TM��+�3�1:\"P�����RQ?���P���+�11= �M\$Z��lT7�,Nq%E!�S�2�&��U*>GDS&����ozh8881\\:��Z0h���T �C+#ʱA%��D!\0�����XDA�3\0�!\\�#�h���9b��T�!d�����Y�j2��S����\nA+ͽ��H�wD`�(AB*��+%�E��X.ˠB�#��ȿ��&��Xe�Eo�\"��|�r��8�W�2�@8Da�|�������N�h����J8[�۳����W�z�{Z\"L\0�\0��Ȇ8�x�۶X@�� �E����h;�af��1��;n��hZ3�E����0|� 옑��A���t�B,~�W�8^�Ǡ׃��<2/	�8�+��۔���O+�%P#ή\n?�߉?��e˔�O\\]�7(#��D۾�(!c)�N����MF�E�#DX�g�)�0�A�\0�:�rB��``  ��Q��H>!\rB��\0��V%ce�HFH��m2�B�2I����`#���D>���n\n:L���9C���0��\0��x(ޏ�(\n����L�\"G�\n@���`[���\ni'\0��)������y)&��(p\0�N�	�\"��N:8��.\r!��'4|ל~����ʀ���\"�c��Dlt����0c��5kQQר+�Z��Gk�!F��c�4��Rx@�&>z=��\$(?���(\n쀨>�	�ҵ���Cqی��t-}�G,t�GW �xq�Hf�b\0�\0z���T9zwЅ�Dmn'�ccb�H\0z���3�!����� H��Hz׀�Iy\",�-�\0�\"<�2���'�#H`�d-�#cl�jĞ`��i(�_���dgȎ�ǂ*�j\r�\0�>� 6���6�2�kj�<�Cq��9�Đ��I\r\$C�AI\$x\r�H��7�8 ܀Z�pZrR����_�U\0�l\r��IR�Xi\0<����r�~�x�S��%��^�%j@^��T3�3ɀGH�z��&\$�(��q\0��f&8+�\rɗ%�2hC�x���I��lbɀ�(h�S�Y&��B������`�f��x�v�n.L+��/\"=I�0�d�\$4�7r����A���(4�2gJ(D��=F�����(����-'Ġ�XG�2�9Z=���,��r`);x\"��8;��>�&�����',�@��2�pl���:0�lI��\rr�JD���������hA�z22p�`O2h��8H��Ąwt�BF���g`7���2{�,Kl���߰%C%�om���������+X����41򹸎\n�2p��	ZB!�=V�ܨ�Ȁ�+H6���*��\0�k���%<� �K',3�r�I�;��8\0Z�+Eܭ�`������+l����W+�Yҵ-t��f�b�Q��_-Ӏޅ�+�� 95�LjJ.Gʩ,\\��ԅ.\$�2�J�\\�-��1�-c���ˇ.l�f�xBqK�,d��ˀ�8�A�Ko-��������3K��r��/|����/\\�r���,��HϤ�!�Y�1�0�@�.�&|����+��J\0�0P3J�-ZQ�	�\r&����\n�L�*���j�ĉ|�����#Ծ�\"˺���A��/���8�)1#�7\$\"�6\n>\n���7L�1���h9�\0�B�Z�d�#�b:\0+A���22��'̕\nt���̜�O��2lʳ.L��HC\0��2���+L�\\��r�Kk+���˳.ꌒ�;(Dƀ���1s����d�s9�����P4�쌜��@�.���A��nhJ�1�3�K�0��3J\$\0��2�Lk3��Q�;3��n\0\0�,�sI�@��u/VA�1���UM�<�Le4D�2��V�% �Ap\nȬ2��35���A-��T�u5�3�۹1+fL~�\n���	��->�� �ҡM�4XL�S��dٲ�͟*\\�@ͨ��Y�k����SDM�5 Xf����D�s���Us%	�̱p+K�6��/���ݒ�8X�ނ=K�6pH����%�3�ͫ7l�I�K0���L��D��u���`��P\r��SO͙&(;�L@��ψN>S��2��8(���`J�E��r�F	2��SE��M��M��\$q�E��\$�ã/I\$\\���ID�\"��\n䱺�w.t�S	���ђP��#\nW��-\0Cҵ�:j�R��^S���8;d�`���5Ԫ�aʖ��E��+(Xr�M�;��3�;���B,��*1&����2X�S���)<� �L9;�RSN����gIs+��ӰK�<��s�LY-Z�:A<���OO*��2v�W7��+|���˻<T���9�h����y\$<��#ρ;����v�\$��O�\0� �,Hk��-���Ϛ\r����ϣ;���O�>�����7>��3@O{.4�pO�?T�b���.�.~O�4��S���>1SS��*4�Pȣ�>�����3�\0�W�>��2��><���P?4��@��t\nN����A�xp��%=P@��C�@�R�˟?x��\n���0N�w�O?�TJC@��#�	.d���M��t�&=�\\�4��A��:L����\$���N��:��\r��I'���A�rግ;\r�/��C���B�Ӯ�i>L��7:9�����|�C\$��)�����z@�tl�:>��C�\n�Bi0G��,\0�FD%p)�o\0����\n>��`)QZI�KG�%M\0#\0�D���Q.H�'\$�E\n �\$ܐ%4I�D�3o�:L�\$��m ��0�	�B�\\(����8��通�h��D��C�sDX4TK���{��x�`\n�,��\nE��:�p\n�'��>��o\0���tI��` -\0�D��/��KP�`/���H�\$\n=���>��U�FP0���UG}4B\$?E����%�T�WD} *�H0�T�\0t������\"!o\0�E�7��R.���tfRFu!ԐD�\n�\0�F-4V�QH�%4��0uN\0�D�QRuE�	)��I\n�&Q�m�)ǚ�m �#\\����D��(\$̓x4��WFM&ԜR5H�%q��[F�+���IF \nT�R3D�L�o���y4TQ/E��[ў<�t^��F��)Q��+4�Q�I�#���IF�'TiѪX��!ѱF�*�nR�>�5�p��Km+�s��������I���R�E�+ԩ��M\0��(R�?�+HҀ�J�\"T�D���\$���	4wQ�}Tz\0�G�8|�x���R��6�R�	4XR6\n�4y�mN��Q�NM�&R�H&�2Q/�7#�қ�{�'�ҍ,|����\n�	.�\0�>�{�o#1D�;��?U��ҕJ�9�*����j����F�N��щJ� #�~%-?C���L�3�@EP�{`>Q�Ȕ��%O�)4�R%I�@��%,�\"���I�<�����\$ԉTP>�\n�\0QP5D��kOF�TY�<�o�Q�=T�\0��x	5�D�,�0?�i�?x�  �mE}>�|����[��\0����&RL���H�S9�G�I��1䀖��M4V�H�oT-S�)Q�G�F [��TQRjN��#x]N(�U�8\nuU\n?5,TmԞ?����?��@�U\n�u-��R�9��U/S \nU3�IESt�QYJu.�Q��F�o\$&���i	��KPC�6�>�5�G\0uR��u)U'R�0�Ѐ�DuIU�J@	��:�V8*�Rf%&�\\�R��MU9R��fUAU[T�UQSe[��\0�KeZUa��Uh��mS<���,R�s�`&Tj@��G�!\\x�^�0>��\0&��p�΂Q�Q�)T�U�Ps�@%\0�W�	`\$��(1�Q?�\$C�Qp\n�O�J��X�#��V7X�u;�!YB��S�c��+V����#MU�W�H��U�R�ǅU-+��VmY}\\���OK�M��\$�S�eToV���HT��!!<{�R��ZA5�R�!=3U��(�{@*Ratz\0)Q�P5H؏���հ�N5+���P�[��9�V%\"����\n����G�SL�����9�����l����\rV�ؤ�[�ou�UIY�R_T�Y�p5O֧\\�q`�U�[�Bu'Uw\\mRU�ԭ\\Es5�K\\���V�\\�S�{�AZ%O��\$��F���>�5E�WVm`��Wd]& \$�Ό����!R�Z}ԅ]}v5���ZUg��Q^y` �!^=F��R�^�v�U�Kex@+��r5�#�@?=�u�Γs���ץY�N�sS!^c�5�\$.�u`��\0�XE~1�9��J�UZ�@�#1_[�4J�2�\n�\$VI�4n�\0�?�4a�R�!U~)&��B>t�R�I�0��_EkTUS��|��Uk_�8�&��E��(‘?�@���J�5���JU�BQT}HV��j��Qx\ne�VsU=���V�N�4ղؗ\\x����R34�G�D\":	KQ�>�[�\r�Y_�#!�#][j<6خX	���c���#KL}>`'\0��5�X�cU�[\0��(���Wt|t�R]p�/�]H2I�QO��1�S�Qj�Z����H���m���)d�^SXCY\r�tu@J�p��%��M������?�UQ�\n�=R�ar:ԿE���-G�\0\$��d���]�meh*��Q�Wt��c��`��A�Y=S\r���	m-���=Mw�H�]J�\"䴏������f�\"�{#9Te����M�c��N�I����D������U�6��g��2��ݝ�e�a�L��Q&&uT�X�51Y�>����S�֊Q#�I���j�\0����W�P��?ub5FU�Ln�)V5R�@��\$!%o��P��'��E�U��P�-����B�p\n�F\$�S4�t�UF|{�q�ȓ0���Umjs�������\$�ڛj��c�ڐ��֫��aZI5X��j�26��&>v��\n\r)2�_k�G��TJ��eQ-c�Z�VM�ֽ�z>�]�a�c��c��`t��H��j�6��+k�M�\0�>���##3l=�'���^6�\0�èv�Z9Se��\"���bΡ�B>�)�/T�=�9\0�`P�\$\0�]�/0ڪ��䵏�k-�6��{k���[�F\r|�SѿJ��MQ�D=�/�WX���V�a�'���a�to��l冶�Xj}C@\"�KP����om�3\0#HV���v��~�{���?gx	n|[�?U��[r�h��G�`�3#Gk%L��\0�I�`C�D��	 \"\0��ŧ��#cN�6�ڹf���zێ�;Ѥ�eeF�7�/N\r:��Q�G�9	\$��I�ռ��]��T��WGs��dW�M�I����f�Bc�ۤ����!#cnu&(�S�_�w��Sf�&T�Z:��0C�S�LN`ܳYj=��>Ų��Z!=�rV]g��	ӣr���Xl��-.�U�'uJuJ\0�s�J�'W%���\\>?�B��V�j4���J}I/-ҝrRL�S�3\0,Rgqӭ��Tf>�1��\0�_���\\V8��Z�t��c耆�<^\\�ll�j\0���T�]C��w�ΓzI��ZwN���pVW�jv�Y�>�2�	o\$|U�W�L%{toX3_���R�J5~6\"��Zl}�`�kc����eR=^UԎ��1�ѽw7e�d��v��b�=��\0�f��,��m�)��Gp��-Ӽ�)9L���>|�� \"�@���5�`�:��\0�,��t@��x���l�J���b�6������a��A\0ػAR�[A���0\$qo�A��S��@���<@�y��\"as.����V^��讥^�����\0��H���[H@�bK����)z�\r����=��^�z�B\0�����N�o<̇t<�x�\0ڬ0*R��I{��^�E�:�{KՐ�1E�0��Y����/��c��\"\0��4���F�7'���\n�0��`U�T��?MP���l��4��r(	��Z�|���&��t\"I����L�w+�m}����Wi\r>�U__u��63�y[�8�T-��V�}�x��_~�%�7��{jM�o_�E�����~]�P\$�J�CaXG�9�\0007Ń5�A#�\0.���\r˴��_������%����\n�\r#<M�x�J���|��2�\0��;o�^a+F���笀Lk��;�_���#��M\\����pr@��õ�����OR���~z��A�NE�Y�O	(1N׉�R��8��C�����n?O)��1�A�Do\0�\r�Ǣ?�kJ��\"�,�OF��a����-b�6]PS�)ƙ�5xC�=@j����L�����L�:\"胻Ί�l#���B�k��������@��N��:�>�|B����9�	���:N��\$��S� �CB:j6����ΉJk��uK�_�W�͢ØI�=@Tv��\n0^o�\\�Ӡ?/��&u�.��_��\r��C��+��c�~�J�b�6���e\0�y�ѡ\0wx�h��8j%S���VH@N'�\\ۯ��N�`n\r��u�n�K�qU�B�+�f>G��\r���=@G���d���\n�)��FO� hʷ��ÈfC�ɅX|��I�]��3auy�Ui^�9y�\no^rt\r8��͇#����N	V��Y�;�c*�%V�<��#�h9r�\rxc�v(\ra���(xja�`g�0�V̼���Q��x(���glհ{��gh`sW<Kj�'�;)�Gnq\$�p�+�Ɍ_��d��^& ���D�x�!b�v�!EjPV�'����(�=�b�\r�\"�b��L�\0���bt�\n>J���1;�����ۈ�4^s�Q�p`�fr`7���x��E<l���	8s��'PT��ֺ�˃��z_�T[>��:��`�1.���;7�@��[��>��6!�*\$`��\0���`,�������@����?�m�>�>\0�LCǸ�R��n��/+�`;C����\0�*�<F���+���q M���;1�K\n�:b�3j1��l�:c>�Y���h���ގ�#�;���3ֺ�8�5�:�\\��\0XH���a�����M1�\\�L[YC��vN��\0+\0��t#�\$�����!@*�l��	F�dhd���F���&��Ƙf�)=��0��4�x\0004ED�6K��䢣���\0�nN�];q�4sj-�=-8���\0�sǨ���D�f5p4����J�^���'Ӕ[��H^�NR F�Kw�z�� ��E����gF|!�c���o�db����x�\0�-��6�,E��_���3u�p ��/�wz�(��ex�Ra�H�Y�ce��5�9d\0�0@2@Ґ�Y�fey��Y�cMו�h����[�ez\rv\\0�e���\\�cʃ��[�ue��NY`��ۖ�]9h姗~^Yqe���]�qe_|6!���u�`�f��J�{�7��M{�Yه��j�e��C��S6\0DuasFL}�\$ȇ�(��Mb���Ƥ,0Buί���т2�gxFљ{�a�n:i\rPj�e��r�r��G�BY��M+q��iY�d˙�`0��,>6�fo�0���o�� �Xf����\0�V�L!��f��l��6� �/��1e��\0�>kbf�\r�!�uf�<%�(r˛�a&	����Y��!���mBg=@��\r�; \r�5phI�9bm�\$BYˋ���g�x�#�@QEO��m9���0\"���!�t���ˉ��Ї�O* ���\0��>%�\$�o�rN&s9�f��4���g��~jM�f�wy�g�y�\\`X1y5x����^z�_,& k���|����1x��A�6� \n�o蔻�&x��gg�{r�?緛�-����|t�3�����}gHgK�9����J�<C�C��1��9�7��g����h6!0H���cdy�f��DA;��9�T���0��\0�p�����!� 6^�.�S²?���E(P�Έ .���5��h���EPJv��.���+�\$�5��>P+�?~��g�6\r��h��p�z(�W��`��\"y���:�FadŬ�6:��f��i\0����A;�e�����^��w�f� >y�����`-\r����\0�hr\r�r�8i\"_�	����9�CI��fXˈ2���\"�Ţ����h�L~�\"���%V�:!%��xy�izyg�vx�]���}qg����Zi��|��`�+ _�g�����٣������譞6PA�ʀ\$�=�9�����h��|p��������!��.�!�����i�^���iˢ�8zVC����Z\"����(�����9�U)��!DgU\0�j��?`��4�LTo@�B����N�a�{�r�:\n̟�E��8æ&=�E�*Z:\n?��g���̊��h��.����N�5(�S�h��i2�*c�f�@����7��z\"�|��rP�.ǀ�L8T'��k���:(�q2&��ED�2~���ر�����9���v���8������@��^X=X`��qZ��Q�֮`9j�5^���@竸�n�qv����3����(I6�j�dT���\\� ��3�,��h�k�3�(�3���P�u�V�|\0阮U�k;��JQ���.��	:J\r��1��n�BI\r\0ɬh@��?�N�\nsh���\"��;�r~7O�\$��(�5�R���	�ʽj����FYF��ܔ��~�x޾�f��\"�vۓo��˨��º#��a�����P���<��h�-3麝/G�x����n�i@\"�G�?��,�Zp�xX`v�4X������[�I��7�åXc	��!�b�}�j�_��9�5qti�6f������ٞ5���Fƹ�iѱ�pX'�2��r���0�ƺ��D,#G�U2��؏�I��\rl(�� �챣��=�A�a�쩳-8�dbS����4~���H;���0�6��b��{��޺R���s3z�����N�ބ��`�ˆ+���4<�^a�y���	}r���y������k�&4@��?~���cE����@�LS@���z^�qqN��</H�j^sC�`��sbgGy����^\n�N�\n:G�N}�c\n���� +���=�p�1��N�TB[d������Ћ��ܹ�`�n�oj;�jěwh����c9��p̡[y4���05�͋N��+ο��`Xda��/zn*�P�����#t�赸~�9W�	�V��~=�#��n)����	2��;�j:��J�k�C�!>x��5��==�2���.��|�'���[��'�;��v�������������;:SA	�&�[�me���n������˵���<��6ma�=Y.神��:g����腀����;�I߻x�[��I�J\0�~�zaY������wT\\`��V\n�~P)�zJ�������Q@��[�{rʉ�D�B�v��|i-�E��K�;^n�{���:Nh;���2��ƀp�Ѵ6����罘9�9����X�hQ�~���iA�@D �j���}�ozLV���ѳ~���	8B?�#F}F�Td����e��zc��F���g�7Η���� 6�#.E£����£��S�.J3��5��Kɥ�J���;���n5��:yS��C�voս.�{��	d\\0�?W\0!)�'����Eg�;�+��\0�Y�Nt�bp+��c�����\0�B=\"�c�T�:B������c��������P�I��D��V0��!ROl�O�N~aF�|%�ߺ�����)O��	�W�o����Q�w��:ٟl�0h@:���օ8�Q�&�[�n�F��p,�æ�@��JT�w�9��(���<�{�ƐO\r�	���ڂ\$m�/HnP\$o^�U��\"���{Ė�<.���n�q8\r�\0;�n������硟�+�޳3��n{�D\$7�,Ez7\0��l!{��8��x҂�.s8�PA�Fx�r����Qۮ���1̅�p+@�d��9OP5�lK�/�����\\m����s�q���v�Q�/���	�!���z�7�o��Eǆ�:q�V�5�?G�HO��O�\$�l��+�,�\r;�����~�Ač錳�{�`7|��Ă���r'��Ji\rc+�|�#+<&қ�<W,��>��^�P�&n�Jh�e�%d������C�i�zX�A�'D�>��Έ�Ek���@�B�w(�.��\n99A�hN�c�kN��d`���p`��%2���3H��b2&�<�9�R(���t�TH�	�z��'�� �o���>4?�\rZ�w�ӂ��4�`��Ї鍆��N���Ӏ�'-I����0(S�r�w,�����K�r��'-2Hlo-�U����_�'W#'/��H֟���j6�̉�����ȫ��\0�<������j1�E�Q�T�T���r�Bcm�16�͈g٫:w6ͯ�h@1�I:������2�p�L/����w�:�ő���K<��E<��J�76Ӏ�s�.̲sZ��/\$�AsEyϜ�r�r:w?Չ�!�?���Ǚ�Z��M�9�՝\0��1?ARͦ%�7>�M�ARr}s��r)\\t-8=����ЎU��,WOCsՆ��#w�5��ERlM*�D��1��>]��gK��V�\n�\\���s�܇8͹seͧ9��so�~����w4x�����f@���D��9����6��\0	@.���@�9\0�C;K��y+�J��٥��u<\\�`�c{Ӌ�E�>�y��J=l����/�-�7����Z46�uC5��P�Ω�RV�������ʳlV��aNx�`մ?U�7(HP�}jV�J�zNQJ�S����s-gQ!a�V�_SwR�O�3am�ZXwZ�o�'�wa���O�oZ���!�[\n<�Z��O�Ҷ'��Omo�[��a�=Q��>�:��T�\n����\0�=��m�j��AT�R�bu(�I���:��\$v�W�����u�S�\\V8��v�\\���g!Mж�u��_�&�is�\\C�R�VM�]tX�T7\\UoT��o_ԯݛS?a�l�S�-LutZGe���i`	}XZ�i}Q�yW[i��T��Yo���(ZE\\�}nٍi�f��ڋ��W�d�%T�pu3u�T�f5)v��]�UR3VEY]�X�\n�^��VqS�S�}X�iGf��v>�S��v�JMQ��vڕ�����\\�g]�QYE��ݵ#1V�l5U�EK]��\0���S��U?\\�BwS�U�7���mZ�V5\\��Wf��է[�eUr�{G\\��U��,�����W�[]x��V�j5mT�V�j�~u7�\0�V�U��'t��w?ms�����5V��vݏq}����u-Uq�]ݗc]�W���]Tt:�f�M�k���e]�[-p}^�I[�XD���Y�V�d���O]	seN����Z�WY�[�t��V?�3�ǵ�M���ݙ`��t^w�d�:qT�L�@@>]�j\rF�qv��-Lv�G�Kwi�LwIPMo��ǹMgv���[��Uss��~	���w:B�A���NE�{�!-��d���o\0��}&����hX��A��5�%٣fzL�H�5d�� Y�_%�v�ә!m��]������%������=B�>E [#^}�hYF�a���>{�gS���p[�F���Da�6n�����x9��8L�I㈫N�a=�S�@�bPk�.��N��H��l\0��:���2#�Θ;��v�O}�9ik]	&�{�� �����2|a��&�������Q��������)��oف�Ǹ:�&.\0�5q\0J�L��64hy�3�ޢ���a�ރ��Iz��O�����ﮈ\"�yB�ʳ{�3�%�5r(m������x.7r�b%���^�e�M���2�\0x��!�b}.��Y6\$qS��\"^|xE����a�������Xǡ5�9��'T�R	�c9���W�1���AΔP��؏h6'�o�-���p��T(\nn\r�Ő��1���R�RUg�������x��Pe#��*��kT<�<�>b;��\0�����gL�.�<k�Zv������z���8~��y7�Y��ȁ��7w��Odn�>�<���E�3��wS�ۆ�@��� o�W�1����Һ�z�e�޽��1��z�\0f=��c㊤g��{��>n�p\0���Α:H�Bn�6F��B�r�W=��C>M.1~@3�G�9�8�q<S�|�Y�8QP��`L[���qz�۫P���N�<{_-ٮ�d�O��d-�NB7��4��B�N��.V���9ƨ�Q�3��{IcP\$���h��<R yy��?��G��:n�����g����;Ah!����&��+>�ˀ�;M�ˌ�	������6S�N��ڌ=#����`�T�#+�n�;��r,�����X|#��\r�#���?\n�D>�|V�S����eϗ~J�m99��\ns�{S|r],~�˹��� �q�I�?\"|w���%|�j�\0rE�,kSn�����qƕ�d8B.��1����\"��/|���؃]�������E�Ϝ�N�l����x��I��� Ic�Ÿ.|\$8D��F������P�K��3��\\j��xU��C/��җ�A{������e�����������ܾ�����\rp�U\n�՟Wlo­Y�{����`]'���s���/|�o����3���r��}��;��[�n��������O�M7���ߣؼq��q(��_l�q�s�N��y������;�i�g�t����:�����ՙ�qk�����{���?z��������Mȗ�o��'�j������c�y�߄���g��gk�w��f8�Vc�7fA��Y���+Kx�=�gKAk�T,95rd�+�G����ٯ����[��%��A�w柞�����7���ଅ�%��{�m��8%_��m��q��V�˨_���%�!�E���i�~���h��~��C�߭~���%�������_�������rLkD�y����~�?p1O!?��v�\\��Pm�\"��<������E�6� �E��V����zk����9�z����~�/��պ��!Q�>��O��Nm��3r�� F��l���e;�M�߷���Ͻ�_a��!~C��f����b}3� K�f���. 	��}.����DX	i5�|��?��=\0��?�?��?��@��Õ��fu~a�^��n��y�Q;�q�����)�s�S�,\"G�\nu%��U�Y�AKl\n��B�I�86VCcO\0�`}.x���,-N�@~��T�G����'��d�J�����y1�zl��æf�g����AB�a�!��M\\<�gʃ�z4ƿ��@/��C�Â�@�	�Qq���)��x��/�.7inD�#=��� *79c�F���d2(��.�V��3����\$g`�A᧋rl|�m����b��/�qE���ô!�bU@��9i�;pp�d���פ=�1�y�x�x�	�=�v=��(v��s_��Bo�ɂ�ց#�K\r n����\\�# �f�PX�u-3&�	��J&,F�(9��v�0�&@khZ�y�g�Cԋ�z ��Á�hi=�s9T�� eT>g��3�d�tF��2b&:��\0�P���B��-�Q��8~�LS�M���ڷcg���Th'�f(���\$�.E���VL����A�I���ߌ���r���g�\r���0�����T��1P`1�d�����\r�4���=6@F���� F���=�ɂ6�A���>�N�AV�	���(\$�A/������;����?�g�f^	�\n�&�KO��n�{]���g˛�8�c��ў���Ϸ�����\n��7L����t:�Ѡ�hF�VO\r��J�)b�(\"OB�m�	o��\$]T�SH�Z^��K����w�\\[A9('�لcۑ���b0���� K�����srB�x\n�*Ba�z6o�\ry&tX1p'���^�M��<�Cg�`�4�8GH��zd?gX��.@,�7w��۞:+�TiUX16��L��s�:�\r�L�6�����f�r\r`�t��67~g�x�gH9�J��O=-\$�4?r٪4����O���:��z��{��D`����21�F�ܵ��(D�M��;����&����́��ڭ��U>�I�6��c���߸@\r/�/��ԕ��_H��\n7z�� ������7�a�ɻ[9D�'����}B��O�R��ݟ�B#s��]z!(D���@L^��	��x��@o��u�O����D���!�e`\na�k>�0`����-*���8E�Z6=f��%����c㛰�K=���F�\r���Sh�yN�[v*v�\r���@�#߸퉁�Ah*�L\$���A�A\\�����%�*	��p�\r*==8�\$W�\r� [��Jx0y��Z�+&Y�HA~A\n,\\(��p�!F����<6S�&IP`6Xz�+�df�\r��J£���i�s�+�&5��/rE���M^\$R(R�Q��Ew3��lH*m\0Bq�a��r��LB����Q��z6~l���B��\rI®G��XٸXVbs�mB�H�����c�_K�\$p�-:8��Nj:�х��-#�F�	\0�aiB�s\\�)�<.�!��\\��N��bIw8�͹t���PjW�`���y\0��&0�i?���Ҕ:�Ia)=��C�,a&�M�apƃ\$�I�IFc���\0!���Y�xa)~�C1�P�ZL3T�j�C\0y����`�\\�W��\\t\$�2�\n�+a�\0aKb���\n��]�C@��?I\r�HヮKs%�N����^���9CL/��=%ۨ�h��:?&P��EY�>5���n[Gْ�%V��*�w<����gJ�]�*�wd�]�B�5^�֢�OQ>%�s{�ԅ畫;�W����z�Gi���*��Rn��G9�E����,(u*��Ւ×��X�s��R���:�5�;��)�R���N���vK�(�R��M���b����_�{�F<<3�:%��HV�YS\n�%L+{�o.>Z(�Qk���N�!��,�:rH}nR�NkI		��[���ӧg��֤;mYҳ�g�%�9V~-J_��g�����\\�ɮ�Q\n��!�t�\\UY-tZn��d:B��ʽ�*�]')t���w���ɫ[BUm*�r4�ؖ�*yv���vZ�չ+GH��Zn�P�܅|\nT� %#\\�AX\0}5b+w�r�Xwܲ1u��%Cg=I��v`�cr�e�0`..<���h�+�H̝^\\j�yF��%�]�B�\0��r��+�>�%Zx�� �%C.����`Vn�1KS���k\r���X|��[�;�6H	U@�D:޻Mj	Ε��?��]ڤ��b�A+��G�\0thxb��L`���64Mޛ��Y#�hfD=e��w=�c�+H��:�.%��^\$�DZrAzj�fLl�7�o�����\0��-���Ed�މyz'V ��Ӟ�W�	Z��K�+�d(A�fy�P?�xR�^h���'���A\0���:p\r�d(V�����d�t	S�FcHȟ��]r�r�CHY	X_�/f���ͽ 4 7e�6D�{,�����<<Z^��j\"	�\n+ƀM�Y9��A�(<Pl�lp	�,>Ѐ�{E9�&�Gh�h{(���Agg8�(@�jT�n�g�Z��Ű�J����x�����@ic��Ջ�(p�'oJ0MnĀ�&���\r'\0Ց��\rq�F�4���)��cL���_�oJ�}5��c�o���|6�m�}Q���4Q��b����[�x�m( �&�@�;�+򘥮��f|I����R�48� {	`���k`u�r`��W㸱`\"��)fI\n��;�8Zj���g�~��AΈ�!j��%��T��E\\�\r3E�j�j��FXZ	��Ay�kH��Xd��gCQ�����΀�0�d����������t�	��zk�`@\0001\0n����H��\0�4\0g&.�\0���\0O(��P@\r��E�\0l\0��X��\r��E��8�x���@�ԋ�\0��^���z@E���\0�.�^��Qq\"�����Y��D_p&���3\0mZ.Pp�\r�Eϋ��s��v\"����0�`��w���,���_�`\rc���/�]x�q���3\0q�.p��q���\0002�_�i���ъ��E�\0a�1�b��wJ \0l\0�1,`��1y\0�9#?0T^��q��\$F6���/\$d�����FD�yJ0b��\0	��W��\0�.�c�{c E�\0s�3l]@\rb�F�\"\0�2�`����\"�7���/�\0������a	^04e��Q{c<�ь�j/_��ѐc\0001��*28BA��\0000�xƔiؾ1��F�5�0ljH���\"�F�30\\_��q�\0�f��T�l_0т�BEČ#3�]���s�ƽ���64_X�1�\0ƽ����d`��`\r�S�_JMV/f����1\0005I6tf���4F����34f����F-���6�d��\"��4�k��\$h�±�#E�̌�\0�6�_01�c@F���/d]X�Q�#G\n���5�g�q��EF\n�m\\�Dn��q��YFv�1/4`��q���4�=�8b�q|�\0004���3�mX�1��e��\0��.�\\��Q�cI�	��.7�\\x�`\"��\0i^3�(籒��\"�Ev4l_��q��\$F���oȾ�\r#UE䍩^9�t�������.�\0�3|r��1�\0����69l^x�ѼPF-�]\n0�v��Qy\"�G��2,sx�Qq#�F+�\0�/Di��q}���8�[6,j��\0cm�o��N5�eh�Qv��GL��H<T_�Q��?Fɋ�..\$f���y�E��C2�l��1s#�E�D�loh�Ѳ�j����8�e�ű�b�F!���9�`x�q�����C�7�hx�٣�Ŏ��7�^x���K<�h���	,u�鱑�G)��;lu��#�Eߎ��<�k���b���\0sR.�w�ֱ�#z�~�w�2|x(����\0001�'�:�v�\0001��G挿�?|`������� .2�X��#�G��8K�@<z�1��ƹ�\"9|j�����	G��/�6�q�����G��s�7�/\0001�b��ߍ��:|�8�Q�#~F��W�4�g���#<F\r�� �2��X�Q�#�Fv�k�7�x�1�#��Ǝ��@�rh�����F���Z;�f��rc�y��!\r	�_x�1�\"�H1���0Tw�ٲc\rF�1 \n8d�X�r���Ԍ��2Db���{d4H��rA<~��1�dBHI�[J?������q�~�k�0�t���#�F\r�#�0\\h��\r�G����Ett���c7�U��!�=D_���cN�\0�y�6a��� Fg��!v1�q��1��KǇ���@�e��ѳcGo��\n/���Ʋ�E��\"�3t`���#cH���<�c��q���F�%�?Tb蹱�d)��� r0����qc�E���>3\$tyQң���E�Cl`9)�VFH�MJ7�f���\$HHQ�� ;�ri�7#F��-F�H�Q�#\0G��!�1�^��&4�vG&��7�g�ృ\$\0G�\rr/�d�R�(��s6@���'RA�Ǭ������&�����g\0k z=�|Hٱ������^J�]��sd��,�\$�1����<cqǦ���J�_���b�G��QvJ���ر��H5��F�p��Ic��[���@�r���vH�%��3D����c<I\$�M.d��r1c=F���.4�c��2b�G.��!�L|{X�ѳ�{I��NF�dx�qsc��ݍ�#�E�a)��#�G����J�m�.��\$=Gh�AN=�s��ŤE͑G�G\\a1�0��H���F.tg8�ä[����Idn���8�F����.T����F3�E�6riq��sF���6�x�r���L�=nFT��od��>�-�3�|�2\$�0��= �:�xc�H�I\"NP\$b��Q�\$F�� �DĂ�����}F�%�?�(����G�3\$�O\$^x�2T������0���R���#�D�:��E�|i/2��XG����8���-�\$H�v���=d�� ��`���:lax�����I���:�X�RJ����R�mx�J#\nGG�9!N���{cI���&�I���R=��I\r��&j:�8��g#�H��'3�_x��b��H}��>7����c��ُ\"&K<x��2���H���\"6@db�뱭e;�)�!�.�]�/�d���m*f6,v��ɪ����L��(q��AI8�7d�9Ttc����UL�X��%H��I*z:�|IXqs��-�B���q^(�R��aq(~e���9J�U�+-eq*nT��>�\$�ѫer��α�p\n�ռ�\$es+�V��I���b��eq:�#]�cc�7r\n�f,gY��TC�%��	�}�\0���\\*�EWP�a�:�E�,&W��p)���xl�M���3\0t\0�/Iip�D'\0	k\$T��F��]f��dM�ȀK\$���H(@�ɔ��(�z�nWҤ�_�Mݔ*�\0�e�lF�^H	W*B���ZPe��֘��R/�dRRʅ\0Ku�,yH)�\"S�XI'��Z�=�L�R�3����\n�'�[k��6@;}R���I����_�)�w�[�� �\n���n����ʓbBr�l,\$v����԰����H����\\���s*����.Qt�B��d�b���@�?3�S�`a@�K�\\.����~�f���)����,?|&ӶK���Z9.�X�+S��|����\0Pʼ��E���e�/�\0V��^K�\0\n-	:��Sز)ת�0j�9TX��B���K\"�ů��²,2�'�2����P,�x���p���Kꗪ����\"�D�#TV��D��1�Ao;ؕ�/9TH%V`WJ<9��aeʰ�K/V^/�Q���\nB�Z\"9���XүM~\$�5����\$0d�I�U���2�^X\n�*�E7I\nV3���+�a��Ii��N�KK�g0�a���z*�V���#bJyMҦe��Z� �V���`����U1�C��.\rF��-j�&LU�p�9s�鹊+Q&1��Rm��ӱgZ���	,.XryZ첰0���3�2�A1�ւ�e�N������(?Al ��,N�ue��\$|r��_%��E05E}�\$���X2�%�Z�e �\n\";<9a�h㶥�a]���8���*�u����L����dR��0����+�Qm.�,G����M��_�2�e�dB��ݸ,�S�2��>U���԰�4vl�~e2��2�eĵ�Yg2nf�=��\$�%��ٖ�Ffa�)����fTƶ�G���g2�W,[����X>)t�A]���R*�&Z��6j2|��\0��(�p	�9� ��uҪ�?��`n��-lZn�!H9����zL��9VLϹy��ݢZ�JhR��g�EfL�U��~`4�Y���x)\$B�QR#ÕS������,6i#�Y��,;C��r��i�&�X��]��\nw54�K�x�\n*&��T���W�������+SлqNc�y��IW��\0W5c��ɫ��&+����Vr�)����Kg����?� ����|�gR���hR�%K��)Z#�5�,ֵ�k�漻`��l:��LsC�[M�UB�6ld�ѓJ������1nl:���j���Lߖ�\0�h� *)�p/��ާ5\\�<9��V��/��ޫ�hT�dj��rMbx\n�]R��W�R� MaU�3=��`0�o��,Z���l��}��m�월�l����mL�S6�\\�tΙ���L���\\�%�J���K��7oѩ��ef�M���oC�Y��v慭NV�4=R��sJ������*h���hn��-m��4��4�y��H�M��|��is�U=����A\$ڭ�i�ϙ������>����p�p��Qf������q,��5s�UL���8}ݬ�٪���#�XH�����I����9U�8�c:�I���f����7�kl�5}��f�LY���N2ް�}&�	i���c,�I�3���R��6r�؉�3b��͍��6>lXY��f�L�)+�S,ى�*�el���U\"ed��\"Z��ږ�6�ZD�E9��%�΂�Y9rmt�E��'.M�[4��^��ɷ�;M�w�5���9���a��v+70l����d%��<��3�_<�lN���(�v+7YRl΅Ӫ]�.��4�I��)��=փN�T�]۹'U^�?�S���7�XC�ũӨ�1�u�9�E�ߙ�k�L;���Nh���S�qNXk;1[����LgpV�B�1_����gs����;�Rl��E���N�T�8�w,���s��1�Pxr�q���3���(��;�Z��	yӾ'{O	_���r�ȪMg|�I��92eL���f�O\rY��nk��u���SN�v9Vk�	�3ǧ.̛v9zyd�)����N�Y�&s\$���jd'6͔�Q<�V��)�e�+���:�ج�Yjt���p�u<��ʖ��3�]qM��Y:9X�S��gI�Ý*�m���C����v�G���R@�֯�jT�=��:�e���(\0_Vn�,?p�	3�'Π���������\r�����|\"�i��gT�n��P皤�\nӔ�q,�Sf�.Y��Q A��A�,Z��eS���sE���\r��v�T��Q�Z�\"p�I�s�UAϛ\0��vZ�}�r��K�tf�P�f9疮�{��^J���ς�������\n0%��NGګ*~l�D.���Ke��6�[,�%����O՘�-�~쵕����j��RO;��@	˨en�b_�%sK�Ŝ����Y����Y�0���L�W���jr�Ր��φ��!B����Pv��fwګ�����M�R2�2�z�4r�h;�#M@�}�\0�|��M�\0�=ځ=��f�-!�6p��g[P4��������C�[5:��\r�Ct��àu@�ۺ<��if��Nu��n[�!u8j{&9Ku�FQlR�i�(�C��A�䮙s4��\0Y��;f�B<�{�嘼R_I�~��6��|MWTA�]4�e@J�e�P|[���r5*���OΠ�Bt�)��%�-\0P�j�m	u�s�}И��Bi^��*��z�0YK.�`[�Y�2��Ы�|�XB�����(?З�.\$�l���,��X�D��\n��j�OD�->_<���֝��\0�������s�h\\����ea\\�\0��e䑙Y�`���7U�\"e��CYT���zt:V9P�_���a�ЕF�;݀\0M�����2�e��HC���Z�?�V��'����}c�Y�a�脬��?Qh8	�0�Q�CM`����6��,���J�eZ�Z\"G�W��u��u\r�>49�K���I%L����V9����։��Z�{VEO�X;�����o�agP�\$\n�RX@}!-Si��R���qz�	��ITH.���\nk\n��\ndϮ�T����>�\n���?�E�`��5D+f�?#z��IZ�7T[��Qs#�D���\$���P���I�	�3��*�:�9YI��H���H��X�0�D�!u7J��m��YB}E������简��r�8Q��\n}'P�S�	Q���������\$��`R�)^��(O�P\0�aK����m�3��\$H.��X�����)�V��`���9 �.�Y��18���eU��`X�9���	����\\Lc�j�IE N鍫��6�W�D�XB�	Z�:�|Ϥ:	E-P-�&���)����*���l�)P�u��y|R���Lh�.p���_*�QA��@ �?,Ƨ�Y��)t�ч�<��P*���j�VuQ�:2\0�L�?J����,TPHL���E%���\0��yP(Y�JZ���TH�X\r	�Q4�hO�;\\�vV�#��T�Ww��\\`��Oҡ��?�JR2��=�F��]����I5TMjI�9�,(ƤDv|t�)��Wy-�]z��e���a,pQ6\$�I-g=%�S�W#�TP�ܐ��)�T&]���X15j��B8���V�ӥ\n�em y���h�*������d�4ς�bd!0��gR�J\\� �Mt��1R\n\n���x�����.�_��u�+Ƽ�;���*4�θ)]�\\�l�(m\"�Q�nT���(*\0�`�1H�@2	6h��Y�c���H_���f�?��a��7=KKde�t�H��2\0/\0�62@b~��`�\0.��\0�v�) !~��JPĝT������������O�{t��\0005���/ீ\r���J^��0�a!�)�8�%KޘPP4��~�H����������\r+�Lb��/24)���GK�e0�e��S1�B�	-0jf���S�wLΙ�i�d ����L��\r1�h�ȩ�S ��MJJ�ht�)��+?L��e5n���|FH��MN��5�j�ɩ�SH��L���4�=T���D��Mn��6Zm@I@S`�)'���7f�z��Sz�x~OU1k����SF��MOU4�p�٣2\0000���7�6�k�#xSl�'K�7�7\nl���xSu�LR7�7�st��xS}�GM7�8*qt�#xS��OM\"7�8�u��)�ӏ\0����9�r�)�Sr��2��;���)��7��Nj�m/�x��ӿ�sNڞ:jy4���S��gO:1�=\ncT���Sͧ����;�{��Sȧ/ORH\r=�tT��Iݧ�O���\\zx4��S�M���>j|T�i�S���O�����~��\$l���O����}t��٧�O��z��*�%�]PP���vU\"��ݧ�K��@\no�j�H�;P�>��1���Fd�P.5Bظ��\r��3�uB�<�L#�<�QPE�Cʁu*\n�ۨyPN��l���\r�6��?K��mBZi�j�H��O2�}1J����M�_M��mD����&�K��Q6��Fzv���6ӹ��Qj��;j��j)�*����mEʌ�9Fd��Qv5eG�ɵd�Ԅ�EM\0+�D�\"j)SD�QҤpZf��Ƃ�mR&��H��U�ہ%�{Rv0m0z��䧟Lƥ@��'���ER�?eJ�>�ԝ��M���I����YT���R�/�Bʕ.�UT��YRΡ�L:�jNԅ��R���L��5ji&,��O�mJD�5,�9����Q����1�hTf��N����ޥQ�'��7��Lih��\rcjԝ��Sz�u��\0n�Ժ�g���9�@c��\rT�%L��A�fT��MT9uQ\n��)��U��S��uD:���j�U	��ƨ�Pږq�*�EڪKSb�l\\ڤ�F���ŪGTz�gJ��H�SF�	\"��Q:�1����;���RꦵL*~EߪoTҦ\\z������:���]Sꕱ����B��U�^J�uR*kE��	��T�Qt��R�g2��Uj��V\$��_��S��mPH�U\\��T��[Uʫ5Jhٵ\\��Up�����V�7a_*����=R�>\0I*����V��X:hU8j�T�KZ��\\:��)j�T��8��	�WZ�Ub��J8�R�=Y�UV�U��R��\\:��-j��ѫiV.��[z��Ҫ��-�{T���Z��uoj�U��3 ��[���>����E �%\\���h#bՅ��WZ�-\\���C�����W>��]ںg4#����KTr��Zʤwj��\$��z�-Rj��tj�U*��W��tp\n�4����'�N�M����xU��X32[x�+���\$B�US*��q�UͪqXZ�}S���x���@�-W\n5�XZ�Յ���J��U2�=\\����F+��V�0]XX�U����0����-VJ��+�/�����Zʮ5sj��D��U޲%b�ɵ������V�%Y�^u@d�բ��W�愔�ŲRk&���YR��\\�ŒRk�Y�cV�O-\\��	kd���KoX��K��/�9�]��V�O-U�<��@��嬥Vγ[����6U�����=e�ϵo�4TݭY�0�eH�դ�\r��9����6�(󮝕+��7�yb�rI �|�\0�:Fz���\n��|��s<�R�%J���]��F�3����j�Σ�Y��Z��^<5�X�IJ��M`�nO\\�B&�r���s��Q�uz��x���	�T���Vw�J5�g	�?v�qF4�9�ӝ����6�zj����OV��\r�u�=�@ʒfT͚����y��	�֫pKaXU9�m����\n�ekMo��5\nhT��ꦦ�V���v���:��s���\\p>��L�:��)�O=nk}j�S��&�֮��~���y��e��ܚ�Zֵ�)j���t�VR�V��s�r�:+a�o��,!T�l�Uϕ�*n��5��\\�U�dv+�M\\�)]B�|�J���l;4��5�pL��ӵئ7Li�[~bmt��Se�\"���B��v��d��@ͧS�4)ؒ�Z���\$)��5ic!������Ό���\\R�*�SD���w\$�9�tS�\n�Gf�Pԛ��ʸ����*�	K���D�Vy��5�uȦJב�\\��C��\$��W,�M\\������5�����k^�V�s��5�k�ֻ�M^��{�u��ϤwFQ��J�H�gWN�k8�����ʉ+�����1br���˕���V�X�]�dL�j�YT��v��6�twy˕�k����vx=�5�h������8�]����˷x\"c|�ufU����\0�ҧ5�jȩ}�Pkn̚Rl��f٪�+���ۣ��>c4��W+T�Do����q���SX���b}}�hn�&<�?�/3��-áh���qn���	�p�%)S�yP\r��͵�m-�f�5���[�\\�=�T�}�y )��Yd�ؤ46#Y>�3��נ�m��\n09h;�4���0��+�a�e\nȃİȞ!�����)�@�x�x}�\$����AF��Ñ�0N� R�	���ӄ�iܥ��U�?���b5�!+׭\0G���w{��Ӥ��lI �)�w-4;p8��ؤ;@\r\n\r���N5�ƅF\\ӹhgPE il0��X�%�)\n��Lk��^���2��<5F��d�I�<�F�j�bM�d'�	�ƲD��Bma������OY�Xgg�8��ZV�%mf��%�F�-�,�\n���a��F�wf��s���0G乑�Z�\n	1�;J��1�\"iP�B�y�C�����t�zӉ���;l�4��ҡ��J��mLX�+lᘪ�{�8�\"�\n�V�����(�\$Y\0�d\\݆6�D9B�H�d%���1����6f �\"�T�J��`/��>�C=�c�쨱��?e!�k*�3l~���i��,�A��z/d���Mo���ڲn�\"ɽ������zTr}eٌ{M�aC�7�fiT����/6W���P����8�Fa`��5��M�f2V]�['}cn4]h���e���Z�ŧ\r��2���XllGa`(����(����\0�����_�lO��f&f�1c8�D{�Q��	S6�p\0�Y�����\0\r�q�3m&*f�;�p�6r^c�ϳ��`ɵ&z�n^ڱ�;D��S�oj^�=�L'g�5���&���Ef&���|\nK 6?bX*�.fψE���~&9�!��d�k@�v\"F�G�x\\�=�E�7�XP2[:��\0�׎��X~��7���X6�4���(�\";B�\n��X��hy��&�Dֈ�Z�l\nKC�������p���`mS�	2�U�;G���8��{��-��WBm��\$F��\r�l&B�Y2\r��mA�ő�w�Z�6�RВ��%d�����_��T�5�``Ba��G��c�XK�\r��\0��gN��\\���;N����s^\n��u����ѲVwz�U�F\"\0T-�,^��\0�����2 /� ����EW�/\0¼��ľ�4;\"�K-NZ���McλRVNe�Z�wj�6��a��ÿ���KV�lN?���jt2���T/[�N���j|0t% #�����\0��`��5F<����X@\nӢ���ZF\\-m���cd2�p5G�v'B�'�7{k�*'�L�A�Z|I�k�\n-.C�6����k�-����S����k�]��_\$��+G�נ[^���z]k��8�\\��F|��?B���^��B��̎|��@����B��zP�W/R?[!bB��k��Ѡ'	(�e:xf�r�7\r_��q�Ma�\0#��7|�Q&\0Ɂ@)���1�뮆LA[Pt�\0���`�6�\\e���zx��S݀vՈπU:�ڱ�T����ϗ>f�\nq�l��+K(|�\\��ѠG��U؋��@(�*�iS�%F�\rR\$��C��L����;�d��ļg�-\$m?�lhʝ��3?P�Y�\0");
    } else {
        header("Content-Type: image/gif");
        switch ($_GET["file"]) {
            case"plus.gif":
                echo "GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0!�����M��*)�o��) q��e���#��L�\0;";
                break;
            case"cross.gif":
                echo "GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0#�����#\na�Fo~y�.�_wa��1�J�G�L�6]\0\0;";
                break;
            case"up.gif":
                echo "GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0 �����MQN\n�}��a8�y�aŶ�\0��\0;";
                break;
            case"down.gif":
                echo "GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0 �����M��*)�[W�\\��L&ٜƶ�\0��\0;";
                break;
            case"arrow.gif":
                echo "GIF89a\0\n\0�\0\0������!�\0\0\0,\0\0\0\0\0\n\0\0�i������Ӳ޻\0\0;";
                break;
        }
    }
    exit;
}
if ($_GET["script"] == "version") {
    $r = file_open_lock(get_temp_dir() . "/adminer.version");
    if ($r) file_write_unlock($r, serialize(array("signature" => $_POST["signature"], "version" => $_POST["version"])));
    exit;
}
global $b, $f, $l, $hc, $pc, $zc, $m, $ld, $rd, $ba, $Sd, $y, $ca, $le, $of, $ag, $Fh, $wd, $mi, $si, $U, $Gi, $ia;
if (!$_SERVER["REQUEST_URI"]) $_SERVER["REQUEST_URI"] = $_SERVER["ORIG_PATH_INFO"];
if (!strpos($_SERVER["REQUEST_URI"], '?') && $_SERVER["QUERY_STRING"] != "") $_SERVER["REQUEST_URI"] .= "?$_SERVER[QUERY_STRING]";
if ($_SERVER["HTTP_X_FORWARDED_PREFIX"]) $_SERVER["REQUEST_URI"] = $_SERVER["HTTP_X_FORWARDED_PREFIX"] . $_SERVER["REQUEST_URI"];
$ba = ($_SERVER["HTTPS"] && strcasecmp($_SERVER["HTTPS"], "off")) || ini_bool("session.cookie_secure");
@ini_set("session.use_trans_sid", false);
if (!defined("SID")) {
    session_cache_limiter("");
    session_name("adminer_sid");
    $Nf = array(0, preg_replace('~\?.*~', '', $_SERVER["REQUEST_URI"]), "", $ba);
    if (version_compare(PHP_VERSION, '5.2.0') >= 0) $Nf[] = true;
    call_user_func_array('session_set_cookie_params', $Nf);
    session_start();
}
remove_slashes(array(&$_GET, &$_POST, &$_COOKIE), $Xc);
if (function_exists("get_magic_quotes_runtime") && get_magic_quotes_runtime()) set_magic_quotes_runtime(false);
@set_time_limit(0);
@ini_set("zend.ze1_compatibility_mode", false);
@ini_set("precision", 15);
function
get_lang()
{
    return 'en';
}

function
lang($ri, $df = null)
{
    if (is_array($ri)) {
        $dg = ($df == 1 ? 0 : 1);
        $ri = $ri[$dg];
    }
    $ri = str_replace("%d", "%s", $ri);
    $df = format_number($df);
    return
        sprintf($ri, $df);
}

if (extension_loaded('pdo')) {
    class
    Min_PDO
    {
        var $_result, $server_info, $affected_rows, $errno, $error, $pdo;

        function
        __construct()
        {
            global $b;
            $dg = array_search("SQL", $b->operators);
            if ($dg !== false) unset($b->operators[$dg]);
        }

        function
        dsn($mc, $V, $F, $wf = array())
        {
            try {
                $this->pdo = new
                PDO($mc, $V, $F, $wf);
            } catch (Exception$Ec) {
                auth_error(h($Ec->getMessage()));
            }
            $this->pdo->setAttribute(3, 1);
            $this->pdo->setAttribute(13, array('Min_PDOStatement'));
            $this->server_info = @$this->pdo->getAttribute(4);
        }

        function
        quote($P)
        {
            return $this->pdo->quote($P);
        }

        function
        query($G, $Ai = false)
        {
            $H = $this->pdo->query($G);
            $this->error = "";
            if (!$H) {
                list(, $this->errno, $this->error) = $this->pdo->errorInfo();
                if (!$this->error) $this->error = 'Unknown error.';
                return
                    false;
            }
            $this->store_result($H);
            return $H;
        }

        function
        multi_query($G)
        {
            return $this->_result = $this->query($G);
        }

        function
        store_result($H = null)
        {
            if (!$H) {
                $H = $this->_result;
                if (!$H) return
                    false;
            }
            if ($H->columnCount()) {
                $H->num_rows = $H->rowCount();
                return $H;
            }
            $this->affected_rows = $H->rowCount();
            return
                true;
        }

        function
        next_result()
        {
            if (!$this->_result) return
                false;
            $this->_result->_offset = 0;
            return @$this->_result->nextRowset();
        }

        function
        result($G, $n = 0)
        {
            $H = $this->query($G);
            if (!$H) return
                false;
            $J = $H->fetch();
            return $J[$n];
        }
    }

    class
    Min_PDOStatement
        extends
        PDOStatement
    {
        var $_offset = 0, $num_rows;

        function
        fetch_assoc()
        {
            return $this->fetch(2);
        }

        function
        fetch_row()
        {
            return $this->fetch(3);
        }

        function
        fetch_field()
        {
            $J = (object)$this->getColumnMeta($this->_offset++);
            $J->orgtable = $J->table;
            $J->orgname = $J->name;
            $J->charsetnr = (in_array("blob", (array)$J->flags) ? 63 : 0);
            return $J;
        }
    }
}
$hc = array();
function
add_driver($u, $D)
{
    global $hc;
    $hc[$u] = $D;
}

class
Min_SQL
{
    var $_conn;

    function
    __construct($f)
    {
        $this->_conn = $f;
    }

    function
    select($Q, $L, $Z, $od, $yf = array(), $_ = 1, $E = 0, $lg = false)
    {
        global $b, $y;
        $Zd = (count($od) < count($L));
        $G = $b->selectQueryBuild($L, $Z, $od, $yf, $_, $E);
        if (!$G) $G = "SELECT" . limit(($_GET["page"] != "last" && $_ != "" && $od && $Zd && $y == "sql" ? "SQL_CALC_FOUND_ROWS " : "") . implode(", ", $L) . "\nFROM " . table($Q), ($Z ? "\nWHERE " . implode(" AND ", $Z) : "") . ($od && $Zd ? "\nGROUP BY " . implode(", ", $od) : "") . ($yf ? "\nORDER BY " . implode(", ", $yf) : ""), ($_ != "" ? +$_ : null), ($E ? $_ * $E : 0), "\n");
        $Bh = microtime(true);
        $I = $this->_conn->query($G);
        if ($lg) echo $b->selectQuery($G, $Bh, !$I);
        return $I;
    }

    function
    delete($Q, $vg, $_ = 0)
    {
        $G = "FROM " . table($Q);
        return
            queries("DELETE" . ($_ ? limit1($Q, $G, $vg) : " $G$vg"));
    }

    function
    update($Q, $N, $vg, $_ = 0, $gh = "\n")
    {
        $Si = array();
        foreach ($N
                 as $z => $X) $Si[] = "$z = $X";
        $G = table($Q) . " SET$gh" . implode(",$gh", $Si);
        return
            queries("UPDATE" . ($_ ? limit1($Q, $G, $vg, $gh) : " $G$vg"));
    }

    function
    insert($Q, $N)
    {
        return
            queries("INSERT INTO " . table($Q) . ($N ? " (" . implode(", ", array_keys($N)) . ")\nVALUES (" . implode(", ", $N) . ")" : " DEFAULT VALUES"));
    }

    function
    insertUpdate($Q, $K, $jg)
    {
        return
            false;
    }

    function
    begin()
    {
        return
            queries("BEGIN");
    }

    function
    commit()
    {
        return
            queries("COMMIT");
    }

    function
    rollback()
    {
        return
            queries("ROLLBACK");
    }

    function
    slowQuery($G, $di)
    {
    }

    function
    convertSearch($v, $X, $n)
    {
        return $v;
    }

    function
    value($X, $n)
    {
        return (method_exists($this->_conn, 'value') ? $this->_conn->value($X, $n) : (is_resource($X) ? stream_get_contents($X) : $X));
    }

    function
    quoteBinary($Wg)
    {
        return
            q($Wg);
    }

    function
    warnings()
    {
        return '';
    }

    function
    tableHelp($D)
    {
    }
}

$hc["sqlite"] = "SQLite 3";
$hc["sqlite2"] = "SQLite 2";
if (isset($_GET["sqlite"]) || isset($_GET["sqlite2"])) {
    define("DRIVER", (isset($_GET["sqlite"]) ? "sqlite" : "sqlite2"));
    if (class_exists(isset($_GET["sqlite"]) ? "SQLite3" : "SQLiteDatabase")) {
        if (isset($_GET["sqlite"])) {
            class
            Min_SQLite
            {
                var $extension = "SQLite3", $server_info, $affected_rows, $errno, $error, $_link;

                function
                __construct($p)
                {
                    $this->_link = new
                    SQLite3($p);
                    $Vi = $this->_link->version();
                    $this->server_info = $Vi["versionString"];
                }

                function
                query($G)
                {
                    $H = @$this->_link->query($G);
                    $this->error = "";
                    if (!$H) {
                        $this->errno = $this->_link->lastErrorCode();
                        $this->error = $this->_link->lastErrorMsg();
                        return
                            false;
                    } elseif ($H->numColumns()) return
                        new
                        Min_Result($H);
                    $this->affected_rows = $this->_link->changes();
                    return
                        true;
                }

                function
                quote($P)
                {
                    return (is_utf8($P) ? "'" . $this->_link->escapeString($P) . "'" : "x'" . reset(unpack('H*', $P)) . "'");
                }

                function
                store_result()
                {
                    return $this->_result;
                }

                function
                result($G, $n = 0)
                {
                    $H = $this->query($G);
                    if (!is_object($H)) return
                        false;
                    $J = $H->_result->fetchArray();
                    return $J[$n];
                }
            }

            class
            Min_Result
            {
                var $_result, $_offset = 0, $num_rows;

                function
                __construct($H)
                {
                    $this->_result = $H;
                }

                function
                fetch_assoc()
                {
                    return $this->_result->fetchArray(SQLITE3_ASSOC);
                }

                function
                fetch_row()
                {
                    return $this->_result->fetchArray(SQLITE3_NUM);
                }

                function
                fetch_field()
                {
                    $d = $this->_offset++;
                    $T = $this->_result->columnType($d);
                    return (object)array("name" => $this->_result->columnName($d), "type" => $T, "charsetnr" => ($T == SQLITE3_BLOB ? 63 : 0),);
                }

                function
                __desctruct()
                {
                    return $this->_result->finalize();
                }
            }
        } else {
            class
            Min_SQLite
            {
                var $extension = "SQLite", $server_info, $affected_rows, $error, $_link;

                function
                __construct($p)
                {
                    $this->server_info = sqlite_libversion();
                    $this->_link = new
                    SQLiteDatabase($p);
                }

                function
                query($G, $Ai = false)
                {
                    $Oe = ($Ai ? "unbufferedQuery" : "query");
                    $H = @$this->_link->$Oe($G, SQLITE_BOTH, $m);
                    $this->error = "";
                    if (!$H) {
                        $this->error = $m;
                        return
                            false;
                    } elseif ($H === true) {
                        $this->affected_rows = $this->changes();
                        return
                            true;
                    }
                    return
                        new
                        Min_Result($H);
                }

                function
                quote($P)
                {
                    return "'" . sqlite_escape_string($P) . "'";
                }

                function
                store_result()
                {
                    return $this->_result;
                }

                function
                result($G, $n = 0)
                {
                    $H = $this->query($G);
                    if (!is_object($H)) return
                        false;
                    $J = $H->_result->fetch();
                    return $J[$n];
                }
            }

            class
            Min_Result
            {
                var $_result, $_offset = 0, $num_rows;

                function
                __construct($H)
                {
                    $this->_result = $H;
                    if (method_exists($H, 'numRows')) $this->num_rows = $H->numRows();
                }

                function
                fetch_assoc()
                {
                    $J = $this->_result->fetch(SQLITE_ASSOC);
                    if (!$J) return
                        false;
                    $I = array();
                    foreach ($J
                             as $z => $X) $I[($z[0] == '"' ? idf_unescape($z) : $z)] = $X;
                    return $I;
                }

                function
                fetch_row()
                {
                    return $this->_result->fetch(SQLITE_NUM);
                }

                function
                fetch_field()
                {
                    $D = $this->_result->fieldName($this->_offset++);
                    $Yf = '(\[.*]|"(?:[^"]|"")*"|(.+))';
                    if (preg_match("~^($Yf\\.)?$Yf\$~", $D, $C)) {
                        $Q = ($C[3] != "" ? $C[3] : idf_unescape($C[2]));
                        $D = ($C[5] != "" ? $C[5] : idf_unescape($C[4]));
                    }
                    return (object)array("name" => $D, "orgname" => $D, "orgtable" => $Q,);
                }
            }
        }
    } elseif (extension_loaded("pdo_sqlite")) {
        class
        Min_SQLite
            extends
            Min_PDO
        {
            var $extension = "PDO_SQLite";

            function
            __construct($p)
            {
                $this->dsn(DRIVER . ":$p", "", "");
            }
        }
    }
    if (class_exists("Min_SQLite")) {
        class
        Min_DB
            extends
            Min_SQLite
        {
            function
            __construct()
            {
                parent::__construct(":memory:");
                $this->query("PRAGMA foreign_keys = 1");
            }

            function
            select_db($p)
            {
                if (is_readable($p) && $this->query("ATTACH " . $this->quote(preg_match("~(^[/\\\\]|:)~", $p) ? $p : dirname($_SERVER["SCRIPT_FILENAME"]) . "/$p") . " AS a")) {
                    parent::__construct($p);
                    $this->query("PRAGMA foreign_keys = 1");
                    $this->query("PRAGMA busy_timeout = 500");
                    return
                        true;
                }
                return
                    false;
            }

            function
            multi_query($G)
            {
                return $this->_result = $this->query($G);
            }

            function
            next_result()
            {
                return
                    false;
            }
        }
    }

    class
    Min_Driver
        extends
        Min_SQL
    {
        function
        insertUpdate($Q, $K, $jg)
        {
            $Si = array();
            foreach ($K
                     as $N) $Si[] = "(" . implode(", ", $N) . ")";
            return
                queries("REPLACE INTO " . table($Q) . " (" . implode(", ", array_keys(reset($K))) . ") VALUES\n" . implode(",\n", $Si));
        }

        function
        tableHelp($D)
        {
            if ($D == "sqlite_sequence") return "fileformat2.html#seqtab";
            if ($D == "sqlite_master") return "fileformat2.html#$D";
        }
    }

    function
    idf_escape($v)
    {
        return '"' . str_replace('"', '""', $v) . '"';
    }

    function
    table($v)
    {
        return
            idf_escape($v);
    }

    function
    connect()
    {
        global $b;
        list(, , $F) = $b->credentials();
        if ($F != "") return 'Database does not support password.';
        return
            new
            Min_DB;
    }

    function
    get_databases()
    {
        return
            array();
    }

    function
    limit($G, $Z, $_, $gf = 0, $gh = " ")
    {
        return " $G$Z" . ($_ !== null ? $gh . "LIMIT $_" . ($gf ? " OFFSET $gf" : "") : "");
    }

    function
    limit1($Q, $G, $Z, $gh = "\n")
    {
        global $f;
        return (preg_match('~^INTO~', $G) || $f->result("SELECT sqlite_compileoption_used('ENABLE_UPDATE_DELETE_LIMIT')") ? limit($G, $Z, 1, 0, $gh) : " $G WHERE rowid = (SELECT rowid FROM " . table($Q) . $Z . $gh . "LIMIT 1)");
    }

    function
    db_collation($k, $mb)
    {
        global $f;
        return $f->result("PRAGMA encoding");
    }

    function
    engines()
    {
        return
            array();
    }

    function
    logged_user()
    {
        return
            get_current_user();
    }

    function
    tables_list()
    {
        return
            get_key_vals("SELECT name, type FROM sqlite_master WHERE type IN ('table', 'view') ORDER BY (name = 'sqlite_sequence'), name");
    }

    function
    count_tables($j)
    {
        return
            array();
    }

    function
    table_status($D = "")
    {
        global $f;
        $I = array();
        foreach (get_rows("SELECT name AS Name, type AS Engine, 'rowid' AS Oid, '' AS Auto_increment FROM sqlite_master WHERE type IN ('table', 'view') " . ($D != "" ? "AND name = " . q($D) : "ORDER BY name")) as $J) {
            $J["Rows"] = $f->result("SELECT COUNT(*) FROM " . idf_escape($J["Name"]));
            $I[$J["Name"]] = $J;
        }
        foreach (get_rows("SELECT * FROM sqlite_sequence", null, "") as $J) $I[$J["name"]]["Auto_increment"] = $J["seq"];
        return ($D != "" ? $I[$D] : $I);
    }

    function
    is_view($R)
    {
        return $R["Engine"] == "view";
    }

    function
    fk_support($R)
    {
        global $f;
        return !$f->result("SELECT sqlite_compileoption_used('OMIT_FOREIGN_KEY')");
    }

    function
    fields($Q)
    {
        global $f;
        $I = array();
        $jg = "";
        foreach (get_rows("PRAGMA table_info(" . table($Q) . ")") as $J) {
            $D = $J["name"];
            $T = strtolower($J["type"]);
            $Wb = $J["dflt_value"];
            $I[$D] = array("field" => $D, "type" => (preg_match('~int~i', $T) ? "integer" : (preg_match('~char|clob|text~i', $T) ? "text" : (preg_match('~blob~i', $T) ? "blob" : (preg_match('~real|floa|doub~i', $T) ? "real" : "numeric")))), "full_type" => $T, "default" => (preg_match("~'(.*)'~", $Wb, $C) ? str_replace("''", "'", $C[1]) : ($Wb == "NULL" ? null : $Wb)), "null" => !$J["notnull"], "privileges" => array("select" => 1, "insert" => 1, "update" => 1), "primary" => $J["pk"],);
            if ($J["pk"]) {
                if ($jg != "") $I[$jg]["auto_increment"] = false; elseif (preg_match('~^integer$~i', $T)) $I[$D]["auto_increment"] = true;
                $jg = $D;
            }
        }
        $xh = $f->result("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = " . q($Q));
        preg_match_all('~(("[^"]*+")+|[a-z0-9_]+)\s+text\s+COLLATE\s+(\'[^\']+\'|\S+)~i', $xh, $Be, PREG_SET_ORDER);
        foreach ($Be
                 as $C) {
            $D = str_replace('""', '"', preg_replace('~^"|"$~', '', $C[1]));
            if ($I[$D]) $I[$D]["collation"] = trim($C[3], "'");
        }
        return $I;
    }

    function
    indexes($Q, $g = null)
    {
        global $f;
        if (!is_object($g)) $g = $f;
        $I = array();
        $xh = $g->result("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = " . q($Q));
        if (preg_match('~\bPRIMARY\s+KEY\s*\((([^)"]+|"[^"]*"|`[^`]*`)++)~i', $xh, $C)) {
            $I[""] = array("type" => "PRIMARY", "columns" => array(), "lengths" => array(), "descs" => array());
            preg_match_all('~((("[^"]*+")+|(?:`[^`]*+`)+)|(\S+))(\s+(ASC|DESC))?(,\s*|$)~i', $C[1], $Be, PREG_SET_ORDER);
            foreach ($Be
                     as $C) {
                $I[""]["columns"][] = idf_unescape($C[2]) . $C[4];
                $I[""]["descs"][] = (preg_match('~DESC~i', $C[5]) ? '1' : null);
            }
        }
        if (!$I) {
            foreach (fields($Q) as $D => $n) {
                if ($n["primary"]) $I[""] = array("type" => "PRIMARY", "columns" => array($D), "lengths" => array(), "descs" => array(null));
            }
        }
        $_h = get_key_vals("SELECT name, sql FROM sqlite_master WHERE type = 'index' AND tbl_name = " . q($Q), $g);
        foreach (get_rows("PRAGMA index_list(" . table($Q) . ")", $g) as $J) {
            $D = $J["name"];
            $w = array("type" => ($J["unique"] ? "UNIQUE" : "INDEX"));
            $w["lengths"] = array();
            $w["descs"] = array();
            foreach (get_rows("PRAGMA index_info(" . idf_escape($D) . ")", $g) as $Vg) {
                $w["columns"][] = $Vg["name"];
                $w["descs"][] = null;
            }
            if (preg_match('~^CREATE( UNIQUE)? INDEX ' . preg_quote(idf_escape($D) . ' ON ' . idf_escape($Q), '~') . ' \((.*)\)$~i', $_h[$D], $Fg)) {
                preg_match_all('/("[^"]*+")+( DESC)?/', $Fg[2], $Be);
                foreach ($Be[2] as $z => $X) {
                    if ($X) $w["descs"][$z] = '1';
                }
            }
            if (!$I[""] || $w["type"] != "UNIQUE" || $w["columns"] != $I[""]["columns"] || $w["descs"] != $I[""]["descs"] || !preg_match("~^sqlite_~", $D)) $I[$D] = $w;
        }
        return $I;
    }

    function
    foreign_keys($Q)
    {
        $I = array();
        foreach (get_rows("PRAGMA foreign_key_list(" . table($Q) . ")") as $J) {
            $q =& $I[$J["id"]];
            if (!$q) $q = $J;
            $q["source"][] = $J["from"];
            $q["target"][] = $J["to"];
        }
        return $I;
    }

    function
    view($D)
    {
        global $f;
        return
            array("select" => preg_replace('~^(?:[^`"[]+|`[^`]*`|"[^"]*")* AS\s+~iU', '', $f->result("SELECT sql FROM sqlite_master WHERE name = " . q($D))));
    }

    function
    collations()
    {
        return (isset($_GET["create"]) ? get_vals("PRAGMA collation_list", 1) : array());
    }

    function
    information_schema($k)
    {
        return
            false;
    }

    function
    error()
    {
        global $f;
        return
            h($f->error);
    }

    function
    check_sqlite_name($D)
    {
        global $f;
        $Nc = "db|sdb|sqlite";
        if (!preg_match("~^[^\\0]*\\.($Nc)\$~", $D)) {
            $f->error = sprintf('Please use one of the extensions %s.', str_replace("|", ", ", $Nc));
            return
                false;
        }
        return
            true;
    }

    function
    create_database($k, $lb)
    {
        global $f;
        if (file_exists($k)) {
            $f->error = 'File exists.';
            return
                false;
        }
        if (!check_sqlite_name($k)) return
            false;
        try {
            $A = new
            Min_SQLite($k);
        } catch (Exception$Ec) {
            $f->error = $Ec->getMessage();
            return
                false;
        }
        $A->query('PRAGMA encoding = "UTF-8"');
        $A->query('CREATE TABLE adminer (i)');
        $A->query('DROP TABLE adminer');
        return
            true;
    }

    function
    drop_databases($j)
    {
        global $f;
        $f->__construct(":memory:");
        foreach ($j
                 as $k) {
            if (!@unlink($k)) {
                $f->error = 'File exists.';
                return
                    false;
            }
        }
        return
            true;
    }

    function
    rename_database($D, $lb)
    {
        global $f;
        if (!check_sqlite_name($D)) return
            false;
        $f->__construct(":memory:");
        $f->error = 'File exists.';
        return @rename(DB, $D);
    }

    function
    auto_increment()
    {
        return " PRIMARY KEY" . (DRIVER == "sqlite" ? " AUTOINCREMENT" : "");
    }

    function
    alter_table($Q, $D, $o, $ed, $rb, $xc, $lb, $Ka, $Sf)
    {
        global $f;
        $Li = ($Q == "" || $ed);
        foreach ($o
                 as $n) {
            if ($n[0] != "" || !$n[1] || $n[2]) {
                $Li = true;
                break;
            }
        }
        $c = array();
        $Gf = array();
        foreach ($o
                 as $n) {
            if ($n[1]) {
                $c[] = ($Li ? $n[1] : "ADD " . implode($n[1]));
                if ($n[0] != "") $Gf[$n[0]] = $n[1][0];
            }
        }
        if (!$Li) {
            foreach ($c
                     as $X) {
                if (!queries("ALTER TABLE " . table($Q) . " $X")) return
                    false;
            }
            if ($Q != $D && !queries("ALTER TABLE " . table($Q) . " RENAME TO " . table($D))) return
                false;
        } elseif (!recreate_table($Q, $D, $c, $Gf, $ed, $Ka)) return
            false;
        if ($Ka) {
            queries("BEGIN");
            queries("UPDATE sqlite_sequence SET seq = $Ka WHERE name = " . q($D));
            if (!$f->affected_rows) queries("INSERT INTO sqlite_sequence (name, seq) VALUES (" . q($D) . ", $Ka)");
            queries("COMMIT");
        }
        return
            true;
    }

    function
    recreate_table($Q, $D, $o, $Gf, $ed, $Ka, $x = array())
    {
        global $f;
        if ($Q != "") {
            if (!$o) {
                foreach (fields($Q) as $z => $n) {
                    if ($x) $n["auto_increment"] = 0;
                    $o[] = process_field($n, $n);
                    $Gf[$z] = idf_escape($z);
                }
            }
            $kg = false;
            foreach ($o
                     as $n) {
                if ($n[6]) $kg = true;
            }
            $kc = array();
            foreach ($x
                     as $z => $X) {
                if ($X[2] == "DROP") {
                    $kc[$X[1]] = true;
                    unset($x[$z]);
                }
            }
            foreach (indexes($Q) as $fe => $w) {
                $e = array();
                foreach ($w["columns"] as $z => $d) {
                    if (!$Gf[$d]) continue
                    2;
                    $e[] = $Gf[$d] . ($w["descs"][$z] ? " DESC" : "");
                }
                if (!$kc[$fe]) {
                    if ($w["type"] != "PRIMARY" || !$kg) $x[] = array($w["type"], $fe, $e);
                }
            }
            foreach ($x
                     as $z => $X) {
                if ($X[0] == "PRIMARY") {
                    unset($x[$z]);
                    $ed[] = "  PRIMARY KEY (" . implode(", ", $X[2]) . ")";
                }
            }
            foreach (foreign_keys($Q) as $fe => $q) {
                foreach ($q["source"] as $z => $d) {
                    if (!$Gf[$d]) continue
                    2;
                    $q["source"][$z] = idf_unescape($Gf[$d]);
                }
                if (!isset($ed[" $fe"])) $ed[] = " " . format_foreign_key($q);
            }
            queries("BEGIN");
        }
        foreach ($o
                 as $z => $n) $o[$z] = "  " . implode($n);
        $o = array_merge($o, array_filter($ed));
        $Xh = ($Q == $D ? "adminer_$D" : $D);
        if (!queries("CREATE TABLE " . table($Xh) . " (\n" . implode(",\n", $o) . "\n)")) return
            false;
        if ($Q != "") {
            if ($Gf && !queries("INSERT INTO " . table($Xh) . " (" . implode(", ", $Gf) . ") SELECT " . implode(", ", array_map('idf_escape', array_keys($Gf))) . " FROM " . table($Q))) return
                false;
            $yi = array();
            foreach (triggers($Q) as $wi => $ei) {
                $vi = trigger($wi);
                $yi[] = "CREATE TRIGGER " . idf_escape($wi) . " " . implode(" ", $ei) . " ON " . table($D) . "\n$vi[Statement]";
            }
            $Ka = $Ka ? 0 : $f->result("SELECT seq FROM sqlite_sequence WHERE name = " . q($Q));
            if (!queries("DROP TABLE " . table($Q)) || ($Q == $D && !queries("ALTER TABLE " . table($Xh) . " RENAME TO " . table($D))) || !alter_indexes($D, $x)) return
                false;
            if ($Ka) queries("UPDATE sqlite_sequence SET seq = $Ka WHERE name = " . q($D));
            foreach ($yi
                     as $vi) {
                if (!queries($vi)) return
                    false;
            }
            queries("COMMIT");
        }
        return
            true;
    }

    function
    index_sql($Q, $T, $D, $e)
    {
        return "CREATE $T " . ($T != "INDEX" ? "INDEX " : "") . idf_escape($D != "" ? $D : uniqid($Q . "_")) . " ON " . table($Q) . " $e";
    }

    function
    alter_indexes($Q, $c)
    {
        foreach ($c
                 as $jg) {
            if ($jg[0] == "PRIMARY") return
                recreate_table($Q, $Q, array(), array(), array(), 0, $c);
        }
        foreach (array_reverse($c) as $X) {
            if (!queries($X[2] == "DROP" ? "DROP INDEX " . idf_escape($X[1]) : index_sql($Q, $X[0], $X[1], "(" . implode(", ", $X[2]) . ")"))) return
                false;
        }
        return
            true;
    }

    function
    truncate_tables($S)
    {
        return
            apply_queries("DELETE FROM", $S);
    }

    function
    drop_views($Xi)
    {
        return
            apply_queries("DROP VIEW", $Xi);
    }

    function
    drop_tables($S)
    {
        return
            apply_queries("DROP TABLE", $S);
    }

    function
    move_tables($S, $Xi, $Vh)
    {
        return
            false;
    }

    function
    trigger($D)
    {
        global $f;
        if ($D == "") return
            array("Statement" => "BEGIN\n\t;\nEND");
        $v = '(?:[^`"\s]+|`[^`]*`|"[^"]*")+';
        $xi = trigger_options();
        preg_match("~^CREATE\\s+TRIGGER\\s*$v\\s*(" . implode("|", $xi["Timing"]) . ")\\s+([a-z]+)(?:\\s+OF\\s+($v))?\\s+ON\\s*$v\\s*(?:FOR\\s+EACH\\s+ROW\\s)?(.*)~is", $f->result("SELECT sql FROM sqlite_master WHERE type = 'trigger' AND name = " . q($D)), $C);
        $ff = $C[3];
        return
            array("Timing" => strtoupper($C[1]), "Event" => strtoupper($C[2]) . ($ff ? " OF" : ""), "Of" => ($ff[0] == '`' || $ff[0] == '"' ? idf_unescape($ff) : $ff), "Trigger" => $D, "Statement" => $C[4],);
    }

    function
    triggers($Q)
    {
        $I = array();
        $xi = trigger_options();
        foreach (get_rows("SELECT * FROM sqlite_master WHERE type = 'trigger' AND tbl_name = " . q($Q)) as $J) {
            preg_match('~^CREATE\s+TRIGGER\s*(?:[^`"\s]+|`[^`]*`|"[^"]*")+\s*(' . implode("|", $xi["Timing"]) . ')\s*(.*?)\s+ON\b~i', $J["sql"], $C);
            $I[$J["name"]] = array($C[1], $C[2]);
        }
        return $I;
    }

    function
    trigger_options()
    {
        return
            array("Timing" => array("BEFORE", "AFTER", "INSTEAD OF"), "Event" => array("INSERT", "UPDATE", "UPDATE OF", "DELETE"), "Type" => array("FOR EACH ROW"),);
    }

    function
    begin()
    {
        return
            queries("BEGIN");
    }

    function
    last_id()
    {
        global $f;
        return $f->result("SELECT LAST_INSERT_ROWID()");
    }

    function
    explain($f, $G)
    {
        return $f->query("EXPLAIN QUERY PLAN $G");
    }

    function
    found_rows($R, $Z)
    {
    }

    function
    types()
    {
        return
            array();
    }

    function
    schemas()
    {
        return
            array();
    }

    function
    get_schema()
    {
        return "";
    }

    function
    set_schema($Zg)
    {
        return
            true;
    }

    function
    create_sql($Q, $Ka, $Gh)
    {
        global $f;
        $I = $f->result("SELECT sql FROM sqlite_master WHERE type IN ('table', 'view') AND name = " . q($Q));
        foreach (indexes($Q) as $D => $w) {
            if ($D == '') continue;
            $I .= ";\n\n" . index_sql($Q, $w['type'], $D, "(" . implode(", ", array_map('idf_escape', $w['columns'])) . ")");
        }
        return $I;
    }

    function
    truncate_sql($Q)
    {
        return "DELETE FROM " . table($Q);
    }

    function
    use_sql($i)
    {
    }

    function
    trigger_sql($Q)
    {
        return
            implode(get_vals("SELECT sql || ';;\n' FROM sqlite_master WHERE type = 'trigger' AND tbl_name = " . q($Q)));
    }

    function
    show_variables()
    {
        global $f;
        $I = array();
        foreach (array("auto_vacuum", "cache_size", "count_changes", "default_cache_size", "empty_result_callbacks", "encoding", "foreign_keys", "full_column_names", "fullfsync", "journal_mode", "journal_size_limit", "legacy_file_format", "locking_mode", "page_size", "max_page_count", "read_uncommitted", "recursive_triggers", "reverse_unordered_selects", "secure_delete", "short_column_names", "synchronous", "temp_store", "temp_store_directory", "schema_version", "integrity_check", "quick_check") as $z) $I[$z] = $f->result("PRAGMA $z");
        return $I;
    }

    function
    show_status()
    {
        $I = array();
        foreach (get_vals("PRAGMA compile_options") as $vf) {
            list($z, $X) = explode("=", $vf, 2);
            $I[$z] = $X;
        }
        return $I;
    }

    function
    convert_field($n)
    {
    }

    function
    unconvert_field($n, $I)
    {
        return $I;
    }

    function
    support($Sc)
    {
        return
            preg_match('~^(columns|database|drop_col|dump|indexes|descidx|move_col|sql|status|table|trigger|variables|view|view_trigger)$~', $Sc);
    }

    function
    driver_config()
    {
        return
            array('possible_drivers' => array((isset($_GET["sqlite"]) ? "SQLite3" : "SQLite"), "PDO_SQLite"), 'jush' => "sqlite", 'types' => array("integer" => 0, "real" => 0, "numeric" => 0, "text" => 0, "blob" => 0), 'structured_types' => array_keys($U), 'unsigned' => array(), 'operators' => array("=", "<", ">", "<=", ">=", "!=", "LIKE", "LIKE %%", "IN", "IS NULL", "NOT LIKE", "NOT IN", "IS NOT NULL", "SQL"), 'functions' => array("hex", "length", "lower", "round", "unixepoch", "upper"), 'grouping' => array("avg", "count", "count distinct", "group_concat", "max", "min", "sum"), 'edit_functions' => array(array(), array("integer|real|numeric" => "+/-", "text" => "||",)),);
    }
}
$hc["pgsql"] = "PostgreSQL";
if (isset($_GET["pgsql"])) {
    define("DRIVER", "pgsql");
    if (extension_loaded("pgsql")) {
        class
        Min_DB
        {
            var $extension = "PgSQL", $_link, $_result, $_string, $_database = true, $server_info, $affected_rows, $error, $timeout;

            function
            _error($_c, $m)
            {
                if (ini_bool("html_errors")) $m = html_entity_decode(strip_tags($m));
                $m = preg_replace('~^[^:]*: ~', '', $m);
                $this->error = $m;
            }

            function
            connect($M, $V, $F)
            {
                global $b;
                $k = $b->database();
                set_error_handler(array($this, '_error'));
                $this->_string = "host='" . str_replace(":", "' port='", addcslashes($M, "'\\")) . "' user='" . addcslashes($V, "'\\") . "' password='" . addcslashes($F, "'\\") . "'";
                $this->_link = @pg_connect("$this->_string dbname='" . ($k != "" ? addcslashes($k, "'\\") : "postgres") . "'", PGSQL_CONNECT_FORCE_NEW);
                if (!$this->_link && $k != "") {
                    $this->_database = false;
                    $this->_link = @pg_connect("$this->_string dbname='postgres'", PGSQL_CONNECT_FORCE_NEW);
                }
                restore_error_handler();
                if ($this->_link) {
                    $Vi = pg_version($this->_link);
                    $this->server_info = $Vi["server"];
                    pg_set_client_encoding($this->_link, "UTF8");
                }
                return (bool)$this->_link;
            }

            function
            quote($P)
            {
                return "'" . pg_escape_string($this->_link, $P) . "'";
            }

            function
            value($X, $n)
            {
                return ($n["type"] == "bytea" && $X !== null ? pg_unescape_bytea($X) : $X);
            }

            function
            quoteBinary($P)
            {
                return "'" . pg_escape_bytea($this->_link, $P) . "'";
            }

            function
            select_db($i)
            {
                global $b;
                if ($i == $b->database()) return $this->_database;
                $I = @pg_connect("$this->_string dbname='" . addcslashes($i, "'\\") . "'", PGSQL_CONNECT_FORCE_NEW);
                if ($I) $this->_link = $I;
                return $I;
            }

            function
            close()
            {
                $this->_link = @pg_connect("$this->_string dbname='postgres'");
            }

            function
            query($G, $Ai = false)
            {
                $H = @pg_query($this->_link, $G);
                $this->error = "";
                if (!$H) {
                    $this->error = pg_last_error($this->_link);
                    $I = false;
                } elseif (!pg_num_fields($H)) {
                    $this->affected_rows = pg_affected_rows($H);
                    $I = true;
                } else$I = new
                Min_Result($H);
                if ($this->timeout) {
                    $this->timeout = 0;
                    $this->query("RESET statement_timeout");
                }
                return $I;
            }

            function
            multi_query($G)
            {
                return $this->_result = $this->query($G);
            }

            function
            store_result()
            {
                return $this->_result;
            }

            function
            next_result()
            {
                return
                    false;
            }

            function
            result($G, $n = 0)
            {
                $H = $this->query($G);
                if (!$H || !$H->num_rows) return
                    false;
                return
                    pg_fetch_result($H->_result, 0, $n);
            }

            function
            warnings()
            {
                return
                    h(pg_last_notice($this->_link));
            }
        }

        class
        Min_Result
        {
            var $_result, $_offset = 0, $num_rows;

            function
            __construct($H)
            {
                $this->_result = $H;
                $this->num_rows = pg_num_rows($H);
            }

            function
            fetch_assoc()
            {
                return
                    pg_fetch_assoc($this->_result);
            }

            function
            fetch_row()
            {
                return
                    pg_fetch_row($this->_result);
            }

            function
            fetch_field()
            {
                $d = $this->_offset++;
                $I = new
                stdClass;
                if (function_exists('pg_field_table')) $I->orgtable = pg_field_table($this->_result, $d);
                $I->name = pg_field_name($this->_result, $d);
                $I->orgname = $I->name;
                $I->type = pg_field_type($this->_result, $d);
                $I->charsetnr = ($I->type == "bytea" ? 63 : 0);
                return $I;
            }

            function
            __destruct()
            {
                pg_free_result($this->_result);
            }
        }
    } elseif (extension_loaded("pdo_pgsql")) {
        class
        Min_DB
            extends
            Min_PDO
        {
            var $extension = "PDO_PgSQL", $timeout;

            function
            connect($M, $V, $F)
            {
                global $b;
                $k = $b->database();
                $this->dsn("pgsql:host='" . str_replace(":", "' port='", addcslashes($M, "'\\")) . "' client_encoding=utf8 dbname='" . ($k != "" ? addcslashes($k, "'\\") : "postgres") . "'", $V, $F);
                return
                    true;
            }

            function
            select_db($i)
            {
                global $b;
                return ($b->database() == $i);
            }

            function
            quoteBinary($Wg)
            {
                return
                    q($Wg);
            }

            function
            query($G, $Ai = false)
            {
                $I = parent::query($G, $Ai);
                if ($this->timeout) {
                    $this->timeout = 0;
                    parent::query("RESET statement_timeout");
                }
                return $I;
            }

            function
            warnings()
            {
                return '';
            }

            function
            close()
            {
            }
        }
    }

    class
    Min_Driver
        extends
        Min_SQL
    {
        function
        insertUpdate($Q, $K, $jg)
        {
            global $f;
            foreach ($K
                     as $N) {
                $Hi = array();
                $Z = array();
                foreach ($N
                         as $z => $X) {
                    $Hi[] = "$z = $X";
                    if (isset($jg[idf_unescape($z)])) $Z[] = "$z = $X";
                }
                if (!(($Z && queries("UPDATE " . table($Q) . " SET " . implode(", ", $Hi) . " WHERE " . implode(" AND ", $Z)) && $f->affected_rows) || queries("INSERT INTO " . table($Q) . " (" . implode(", ", array_keys($N)) . ") VALUES (" . implode(", ", $N) . ")"))) return
                    false;
            }
            return
                true;
        }

        function
        slowQuery($G, $di)
        {
            $this->_conn->query("SET statement_timeout = " . (1000 * $di));
            $this->_conn->timeout = 1000 * $di;
            return $G;
        }

        function
        convertSearch($v, $X, $n)
        {
            return (preg_match('~char|text' . (!preg_match('~LIKE~', $X["op"]) ? '|date|time(stamp)?|boolean|uuid|' . number_type() : '') . '~', $n["type"]) ? $v : "CAST($v AS text)");
        }

        function
        quoteBinary($Wg)
        {
            return $this->_conn->quoteBinary($Wg);
        }

        function
        warnings()
        {
            return $this->_conn->warnings();
        }

        function
        tableHelp($D)
        {
            $ve = array("information_schema" => "infoschema", "pg_catalog" => "catalog",);
            $A = $ve[$_GET["ns"]];
            if ($A) return "$A-" . str_replace("_", "-", $D) . ".html";
        }
    }

    function
    idf_escape($v)
    {
        return '"' . str_replace('"', '""', $v) . '"';
    }

    function
    table($v)
    {
        return
            idf_escape($v);
    }

    function
    connect()
    {
        global $b, $U, $Fh;
        $f = new
        Min_DB;
        $Kb = $b->credentials();
        if ($f->connect($Kb[0], $Kb[1], $Kb[2])) {
            if (min_version(9, 0, $f)) {
                $f->query("SET application_name = 'Adminer'");
                if (min_version(9.2, 0, $f)) {
                    $Fh['Strings'][] = "json";
                    $U["json"] = 4294967295;
                    if (min_version(9.4, 0, $f)) {
                        $Fh['Strings'][] = "jsonb";
                        $U["jsonb"] = 4294967295;
                    }
                }
            }
            return $f;
        }
        return $f->error;
    }

    function
    get_databases()
    {
        return
            get_vals("SELECT datname FROM pg_database WHERE has_database_privilege(datname, 'CONNECT') ORDER BY datname");
    }

    function
    limit($G, $Z, $_, $gf = 0, $gh = " ")
    {
        return " $G$Z" . ($_ !== null ? $gh . "LIMIT $_" . ($gf ? " OFFSET $gf" : "") : "");
    }

    function
    limit1($Q, $G, $Z, $gh = "\n")
    {
        return (preg_match('~^INTO~', $G) ? limit($G, $Z, 1, 0, $gh) : " $G" . (is_view(table_status1($Q)) ? $Z : " WHERE ctid = (SELECT ctid FROM " . table($Q) . $Z . $gh . "LIMIT 1)"));
    }

    function
    db_collation($k, $mb)
    {
        global $f;
        return $f->result("SELECT datcollate FROM pg_database WHERE datname = " . q($k));
    }

    function
    engines()
    {
        return
            array();
    }

    function
    logged_user()
    {
        global $f;
        return $f->result("SELECT user");
    }

    function
    tables_list()
    {
        $G = "SELECT table_name, table_type FROM information_schema.tables WHERE table_schema = current_schema()";
        if (support('materializedview')) $G .= "
UNION ALL
SELECT matviewname, 'MATERIALIZED VIEW'
FROM pg_matviews
WHERE schemaname = current_schema()";
        $G .= "
ORDER BY 1";
        return
            get_key_vals($G);
    }

    function
    count_tables($j)
    {
        return
            array();
    }

    function
    table_status($D = "")
    {
        $I = array();
        foreach (get_rows("SELECT c.relname AS \"Name\", CASE c.relkind WHEN 'r' THEN 'table' WHEN 'm' THEN 'materialized view' ELSE 'view' END AS \"Engine\", pg_relation_size(c.oid) AS \"Data_length\", pg_total_relation_size(c.oid) - pg_relation_size(c.oid) AS \"Index_length\", obj_description(c.oid, 'pg_class') AS \"Comment\", " . (min_version(12) ? "''" : "CASE WHEN c.relhasoids THEN 'oid' ELSE '' END") . " AS \"Oid\", c.reltuples as \"Rows\", n.nspname
FROM pg_class c
JOIN pg_namespace n ON(n.nspname = current_schema() AND n.oid = c.relnamespace)
WHERE relkind IN ('r', 'm', 'v', 'f', 'p')
" . ($D != "" ? "AND relname = " . q($D) : "ORDER BY relname")) as $J) $I[$J["Name"]] = $J;
        return ($D != "" ? $I[$D] : $I);
    }

    function
    is_view($R)
    {
        return
            in_array($R["Engine"], array("view", "materialized view"));
    }

    function
    fk_support($R)
    {
        return
            true;
    }

    function
    fields($Q)
    {
        $I = array();
        $Ba = array('timestamp without time zone' => 'timestamp', 'timestamp with time zone' => 'timestamptz',);
        $Ed = min_version(10) ? 'a.attidentity' : '0';
        foreach (get_rows("SELECT a.attname AS field, format_type(a.atttypid, a.atttypmod) AS full_type, pg_get_expr(d.adbin, d.adrelid) AS default, a.attnotnull::int, col_description(c.oid, a.attnum) AS comment, $Ed AS identity
FROM pg_class c
JOIN pg_namespace n ON c.relnamespace = n.oid
JOIN pg_attribute a ON c.oid = a.attrelid
LEFT JOIN pg_attrdef d ON c.oid = d.adrelid AND a.attnum = d.adnum
WHERE c.relname = " . q($Q) . "
AND n.nspname = current_schema()
AND NOT a.attisdropped
AND a.attnum > 0
ORDER BY a.attnum") as $J) {
            preg_match('~([^([]+)(\((.*)\))?([a-z ]+)?((\[[0-9]*])*)$~', $J["full_type"], $C);
            list(, $T, $se, $J["length"], $wa, $Ea) = $C;
            $J["length"] .= $Ea;
            $bb = $T . $wa;
            if (isset($Ba[$bb])) {
                $J["type"] = $Ba[$bb];
                $J["full_type"] = $J["type"] . $se . $Ea;
            } else {
                $J["type"] = $T;
                $J["full_type"] = $J["type"] . $se . $wa . $Ea;
            }
            if (in_array($J['identity'], array('a', 'd'))) $J['default'] = 'GENERATED ' . ($J['identity'] == 'd' ? 'BY DEFAULT' : 'ALWAYS') . ' AS IDENTITY';
            $J["null"] = !$J["attnotnull"];
            $J["auto_increment"] = $J['identity'] || preg_match('~^nextval\(~i', $J["default"]);
            $J["privileges"] = array("insert" => 1, "select" => 1, "update" => 1);
            if (preg_match('~(.+)::[^,)]+(.*)~', $J["default"], $C)) $J["default"] = ($C[1] == "NULL" ? null : (($C[1][0] == "'" ? idf_unescape($C[1]) : $C[1]) . $C[2]));
            $I[$J["field"]] = $J;
        }
        return $I;
    }

    function
    indexes($Q, $g = null)
    {
        global $f;
        if (!is_object($g)) $g = $f;
        $I = array();
        $Oh = $g->result("SELECT oid FROM pg_class WHERE relnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema()) AND relname = " . q($Q));
        $e = get_key_vals("SELECT attnum, attname FROM pg_attribute WHERE attrelid = $Oh AND attnum > 0", $g);
        foreach (get_rows("SELECT relname, indisunique::int, indisprimary::int, indkey, indoption, (indpred IS NOT NULL)::int as indispartial FROM pg_index i, pg_class ci WHERE i.indrelid = $Oh AND ci.oid = i.indexrelid", $g) as $J) {
            $Gg = $J["relname"];
            $I[$Gg]["type"] = ($J["indispartial"] ? "INDEX" : ($J["indisprimary"] ? "PRIMARY" : ($J["indisunique"] ? "UNIQUE" : "INDEX")));
            $I[$Gg]["columns"] = array();
            foreach (explode(" ", $J["indkey"]) as $Od) $I[$Gg]["columns"][] = $e[$Od];
            $I[$Gg]["descs"] = array();
            foreach (explode(" ", $J["indoption"]) as $Pd) $I[$Gg]["descs"][] = ($Pd & 1 ? '1' : null);
            $I[$Gg]["lengths"] = array();
        }
        return $I;
    }

    function
    foreign_keys($Q)
    {
        global $of;
        $I = array();
        foreach (get_rows("SELECT conname, condeferrable::int AS deferrable, pg_get_constraintdef(oid) AS definition
FROM pg_constraint
WHERE conrelid = (SELECT pc.oid FROM pg_class AS pc INNER JOIN pg_namespace AS pn ON (pn.oid = pc.relnamespace) WHERE pc.relname = " . q($Q) . " AND pn.nspname = current_schema())
AND contype = 'f'::char
ORDER BY conkey, conname") as $J) {
            if (preg_match('~FOREIGN KEY\s*\((.+)\)\s*REFERENCES (.+)\((.+)\)(.*)$~iA', $J['definition'], $C)) {
                $J['source'] = array_map('trim', explode(',', $C[1]));
                if (preg_match('~^(("([^"]|"")+"|[^"]+)\.)?"?("([^"]|"")+"|[^"]+)$~', $C[2], $Ae)) {
                    $J['ns'] = str_replace('""', '"', preg_replace('~^"(.+)"$~', '\1', $Ae[2]));
                    $J['table'] = str_replace('""', '"', preg_replace('~^"(.+)"$~', '\1', $Ae[4]));
                }
                $J['target'] = array_map('trim', explode(',', $C[3]));
                $J['on_delete'] = (preg_match("~ON DELETE ($of)~", $C[4], $Ae) ? $Ae[1] : 'NO ACTION');
                $J['on_update'] = (preg_match("~ON UPDATE ($of)~", $C[4], $Ae) ? $Ae[1] : 'NO ACTION');
                $I[$J['conname']] = $J;
            }
        }
        return $I;
    }

    function
    constraints($Q)
    {
        global $of;
        $I = array();
        foreach (get_rows("SELECT conname, consrc
FROM pg_catalog.pg_constraint
INNER JOIN pg_catalog.pg_namespace ON pg_constraint.connamespace = pg_namespace.oid
INNER JOIN pg_catalog.pg_class ON pg_constraint.conrelid = pg_class.oid AND pg_constraint.connamespace = pg_class.relnamespace
WHERE pg_constraint.contype = 'c'
AND conrelid != 0 -- handle only CONSTRAINTs here, not TYPES
AND nspname = current_schema()
AND relname = " . q($Q) . "
ORDER BY connamespace, conname") as $J) $I[$J['conname']] = $J['consrc'];
        return $I;
    }

    function
    view($D)
    {
        global $f;
        return
            array("select" => trim($f->result("SELECT pg_get_viewdef(" . $f->result("SELECT oid FROM pg_class WHERE relnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema()) AND relname = " . q($D)) . ")")));
    }

    function
    collations()
    {
        return
            array();
    }

    function
    information_schema($k)
    {
        return ($k == "information_schema");
    }

    function
    error()
    {
        global $f;
        $I = h($f->error);
        if (preg_match('~^(.*\n)?([^\n]*)\n( *)\^(\n.*)?$~s', $I, $C)) $I = $C[1] . preg_replace('~((?:[^&]|&[^;]*;){' . strlen($C[3]) . '})(.*)~', '\1<b>\2</b>', $C[2]) . $C[4];
        return
            nl_br($I);
    }

    function
    create_database($k, $lb)
    {
        return
            queries("CREATE DATABASE " . idf_escape($k) . ($lb ? " ENCODING " . idf_escape($lb) : ""));
    }

    function
    drop_databases($j)
    {
        global $f;
        $f->close();
        return
            apply_queries("DROP DATABASE", $j, 'idf_escape');
    }

    function
    rename_database($D, $lb)
    {
        return
            queries("ALTER DATABASE " . idf_escape(DB) . " RENAME TO " . idf_escape($D));
    }

    function
    auto_increment()
    {
        return "";
    }

    function
    alter_table($Q, $D, $o, $ed, $rb, $xc, $lb, $Ka, $Sf)
    {
        $c = array();
        $ug = array();
        if ($Q != "" && $Q != $D) $ug[] = "ALTER TABLE " . table($Q) . " RENAME TO " . table($D);
        foreach ($o
                 as $n) {
            $d = idf_escape($n[0]);
            $X = $n[1];
            if (!$X) $c[] = "DROP $d"; else {
                $Ri = $X[5];
                unset($X[5]);
                if ($n[0] == "") {
                    if (isset($X[6])) $X[1] = ($X[1] == " bigint" ? " big" : ($X[1] == " smallint" ? " small" : " ")) . "serial";
                    $c[] = ($Q != "" ? "ADD " : "  ") . implode($X);
                    if (isset($X[6])) $c[] = ($Q != "" ? "ADD" : " ") . " PRIMARY KEY ($X[0])";
                } else {
                    if ($d != $X[0]) $ug[] = "ALTER TABLE " . table($D) . " RENAME $d TO $X[0]";
                    $c[] = "ALTER $d TYPE$X[1]";
                    if (!$X[6]) {
                        $c[] = "ALTER $d " . ($X[3] ? "SET$X[3]" : "DROP DEFAULT");
                        $c[] = "ALTER $d " . ($X[2] == " NULL" ? "DROP NOT" : "SET") . $X[2];
                    }
                }
                if ($n[0] != "" || $Ri != "") $ug[] = "COMMENT ON COLUMN " . table($D) . ".$X[0] IS " . ($Ri != "" ? substr($Ri, 9) : "''");
            }
        }
        $c = array_merge($c, $ed);
        if ($Q == "") array_unshift($ug, "CREATE TABLE " . table($D) . " (\n" . implode(",\n", $c) . "\n)"); elseif ($c) array_unshift($ug, "ALTER TABLE " . table($Q) . "\n" . implode(",\n", $c));
        if ($Q != "" || $rb != "") $ug[] = "COMMENT ON TABLE " . table($D) . " IS " . q($rb);
        if ($Ka != "") {
        }
        foreach ($ug
                 as $G) {
            if (!queries($G)) return
                false;
        }
        return
            true;
    }

    function
    alter_indexes($Q, $c)
    {
        $h = array();
        $ic = array();
        $ug = array();
        foreach ($c
                 as $X) {
            if ($X[0] != "INDEX") $h[] = ($X[2] == "DROP" ? "\nDROP CONSTRAINT " . idf_escape($X[1]) : "\nADD" . ($X[1] != "" ? " CONSTRAINT " . idf_escape($X[1]) : "") . " $X[0] " . ($X[0] == "PRIMARY" ? "KEY " : "") . "(" . implode(", ", $X[2]) . ")"); elseif ($X[2] == "DROP") $ic[] = idf_escape($X[1]);
            else$ug[] = "CREATE INDEX " . idf_escape($X[1] != "" ? $X[1] : uniqid($Q . "_")) . " ON " . table($Q) . " (" . implode(", ", $X[2]) . ")";
        }
        if ($h) array_unshift($ug, "ALTER TABLE " . table($Q) . implode(",", $h));
        if ($ic) array_unshift($ug, "DROP INDEX " . implode(", ", $ic));
        foreach ($ug
                 as $G) {
            if (!queries($G)) return
                false;
        }
        return
            true;
    }

    function
    truncate_tables($S)
    {
        return
            queries("TRUNCATE " . implode(", ", array_map('table', $S)));
        return
            true;
    }

    function
    drop_views($Xi)
    {
        return
            drop_tables($Xi);
    }

    function
    drop_tables($S)
    {
        foreach ($S
                 as $Q) {
            $O = table_status($Q);
            if (!queries("DROP " . strtoupper($O["Engine"]) . " " . table($Q))) return
                false;
        }
        return
            true;
    }

    function
    move_tables($S, $Xi, $Vh)
    {
        foreach (array_merge($S, $Xi) as $Q) {
            $O = table_status($Q);
            if (!queries("ALTER " . strtoupper($O["Engine"]) . " " . table($Q) . " SET SCHEMA " . idf_escape($Vh))) return
                false;
        }
        return
            true;
    }

    function
    trigger($D, $Q = null)
    {
        if ($D == "") return
            array("Statement" => "EXECUTE PROCEDURE ()");
        if ($Q === null) $Q = $_GET['trigger'];
        $K = get_rows('SELECT t.trigger_name AS "Trigger", t.action_timing AS "Timing", (SELECT STRING_AGG(event_manipulation, \' OR \') FROM information_schema.triggers WHERE event_object_table = t.event_object_table AND trigger_name = t.trigger_name ) AS "Events", t.event_manipulation AS "Event", \'FOR EACH \' || t.action_orientation AS "Type", t.action_statement AS "Statement" FROM information_schema.triggers t WHERE t.event_object_table = ' . q($Q) . ' AND t.trigger_name = ' . q($D));
        return
            reset($K);
    }

    function
    triggers($Q)
    {
        $I = array();
        foreach (get_rows("SELECT * FROM information_schema.triggers WHERE trigger_schema = current_schema() AND event_object_table = " . q($Q)) as $J) $I[$J["trigger_name"]] = array($J["action_timing"], $J["event_manipulation"]);
        return $I;
    }

    function
    trigger_options()
    {
        return
            array("Timing" => array("BEFORE", "AFTER"), "Event" => array("INSERT", "UPDATE", "DELETE"), "Type" => array("FOR EACH ROW", "FOR EACH STATEMENT"),);
    }

    function
    routine($D, $T)
    {
        $K = get_rows('SELECT routine_definition AS definition, LOWER(external_language) AS language, *
FROM information_schema.routines
WHERE routine_schema = current_schema() AND specific_name = ' . q($D));
        $I = $K[0];
        $I["returns"] = array("type" => $I["type_udt_name"]);
        $I["fields"] = get_rows('SELECT parameter_name AS field, data_type AS type, character_maximum_length AS length, parameter_mode AS inout
FROM information_schema.parameters
WHERE specific_schema = current_schema() AND specific_name = ' . q($D) . '
ORDER BY ordinal_position');
        return $I;
    }

    function
    routines()
    {
        return
            get_rows('SELECT specific_name AS "SPECIFIC_NAME", routine_type AS "ROUTINE_TYPE", routine_name AS "ROUTINE_NAME", type_udt_name AS "DTD_IDENTIFIER"
FROM information_schema.routines
WHERE routine_schema = current_schema()
ORDER BY SPECIFIC_NAME');
    }

    function
    routine_languages()
    {
        return
            get_vals("SELECT LOWER(lanname) FROM pg_catalog.pg_language");
    }

    function
    routine_id($D, $J)
    {
        $I = array();
        foreach ($J["fields"] as $n) $I[] = $n["type"];
        return
            idf_escape($D) . "(" . implode(", ", $I) . ")";
    }

    function
    last_id()
    {
        return
            0;
    }

    function
    explain($f, $G)
    {
        return $f->query("EXPLAIN $G");
    }

    function
    found_rows($R, $Z)
    {
        global $f;
        if (preg_match("~ rows=([0-9]+)~", $f->result("EXPLAIN SELECT * FROM " . idf_escape($R["Name"]) . ($Z ? " WHERE " . implode(" AND ", $Z) : "")), $Fg)) return $Fg[1];
        return
            false;
    }

    function
    types()
    {
        return
            get_vals("SELECT typname
FROM pg_type
WHERE typnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema())
AND typtype IN ('b','d','e')
AND typelem = 0");
    }

    function
    schemas()
    {
        return
            get_vals("SELECT nspname FROM pg_namespace ORDER BY nspname");
    }

    function
    get_schema()
    {
        global $f;
        return $f->result("SELECT current_schema()");
    }

    function
    set_schema($Yg, $g = null)
    {
        global $f, $U, $Fh;
        if (!$g) $g = $f;
        $I = $g->query("SET search_path TO " . idf_escape($Yg));
        foreach (types() as $T) {
            if (!isset($U[$T])) {
                $U[$T] = 0;
                $Fh['User types'][] = $T;
            }
        }
        return $I;
    }

    function
    foreign_keys_sql($Q)
    {
        $I = "";
        $O = table_status($Q);
        $bd = foreign_keys($Q);
        ksort($bd);
        foreach ($bd
                 as $ad => $Zc) $I .= "ALTER TABLE ONLY " . idf_escape($O['nspname']) . "." . idf_escape($O['Name']) . " ADD CONSTRAINT " . idf_escape($ad) . " $Zc[definition] " . ($Zc['deferrable'] ? 'DEFERRABLE' : 'NOT DEFERRABLE') . ";\n";
        return ($I ? "$I\n" : $I);
    }

    function
    create_sql($Q, $Ka, $Gh)
    {
        global $f;
        $I = '';
        $Og = array();
        $ih = array();
        $O = table_status($Q);
        if (is_view($O)) {
            $Wi = view($Q);
            return
                rtrim("CREATE VIEW " . idf_escape($Q) . " AS $Wi[select]", ";");
        }
        $o = fields($Q);
        $x = indexes($Q);
        ksort($x);
        $Ab = constraints($Q);
        if (!$O || empty($o)) return
            false;
        $I = "CREATE TABLE " . idf_escape($O['nspname']) . "." . idf_escape($O['Name']) . " (\n    ";
        foreach ($o
                 as $Uc => $n) {
            $Pf = idf_escape($n['field']) . ' ' . $n['full_type'] . default_value($n) . ($n['attnotnull'] ? " NOT NULL" : "");
            $Og[] = $Pf;
            if (preg_match('~nextval\(\'([^\']+)\'\)~', $n['default'], $Be)) {
                $hh = $Be[1];
                $wh = reset(get_rows(min_version(10) ? "SELECT *, cache_size AS cache_value FROM pg_sequences WHERE schemaname = current_schema() AND sequencename = " . q($hh) : "SELECT * FROM $hh"));
                $ih[] = ($Gh == "DROP+CREATE" ? "DROP SEQUENCE IF EXISTS $hh;\n" : "") . "CREATE SEQUENCE $hh INCREMENT $wh[increment_by] MINVALUE $wh[min_value] MAXVALUE $wh[max_value]" . ($Ka && $wh['last_value'] ? " START $wh[last_value]" : "") . " CACHE $wh[cache_value];";
            }
        }
        if (!empty($ih)) $I = implode("\n\n", $ih) . "\n\n$I";
        foreach ($x
                 as $Jd => $w) {
            switch ($w['type']) {
                case'UNIQUE':
                    $Og[] = "CONSTRAINT " . idf_escape($Jd) . " UNIQUE (" . implode(', ', array_map('idf_escape', $w['columns'])) . ")";
                    break;
                case'PRIMARY':
                    $Og[] = "CONSTRAINT " . idf_escape($Jd) . " PRIMARY KEY (" . implode(', ', array_map('idf_escape', $w['columns'])) . ")";
                    break;
            }
        }
        foreach ($Ab
                 as $xb => $zb) $Og[] = "CONSTRAINT " . idf_escape($xb) . " CHECK $zb";
        $I .= implode(",\n    ", $Og) . "\n) WITH (oids = " . ($O['Oid'] ? 'true' : 'false') . ");";
        foreach ($x
                 as $Jd => $w) {
            if ($w['type'] == 'INDEX') {
                $e = array();
                foreach ($w['columns'] as $z => $X) $e[] = idf_escape($X) . ($w['descs'][$z] ? " DESC" : "");
                $I .= "\n\nCREATE INDEX " . idf_escape($Jd) . " ON " . idf_escape($O['nspname']) . "." . idf_escape($O['Name']) . " USING btree (" . implode(', ', $e) . ");";
            }
        }
        if ($O['Comment']) $I .= "\n\nCOMMENT ON TABLE " . idf_escape($O['nspname']) . "." . idf_escape($O['Name']) . " IS " . q($O['Comment']) . ";";
        foreach ($o
                 as $Uc => $n) {
            if ($n['comment']) $I .= "\n\nCOMMENT ON COLUMN " . idf_escape($O['nspname']) . "." . idf_escape($O['Name']) . "." . idf_escape($Uc) . " IS " . q($n['comment']) . ";";
        }
        return
            rtrim($I, ';');
    }

    function
    truncate_sql($Q)
    {
        return "TRUNCATE " . table($Q);
    }

    function
    trigger_sql($Q)
    {
        $O = table_status($Q);
        $I = "";
        foreach (triggers($Q) as $ui => $ti) {
            $vi = trigger($ui, $O['Name']);
            $I .= "\nCREATE TRIGGER " . idf_escape($vi['Trigger']) . " $vi[Timing] $vi[Events] ON " . idf_escape($O["nspname"]) . "." . idf_escape($O['Name']) . " $vi[Type] $vi[Statement];;\n";
        }
        return $I;
    }

    function
    use_sql($i)
    {
        return "\connect " . idf_escape($i);
    }

    function
    show_variables()
    {
        return
            get_key_vals("SHOW ALL");
    }

    function
    process_list()
    {
        return
            get_rows("SELECT * FROM pg_stat_activity ORDER BY " . (min_version(9.2) ? "pid" : "procpid"));
    }

    function
    show_status()
    {
    }

    function
    convert_field($n)
    {
    }

    function
    unconvert_field($n, $I)
    {
        return $I;
    }

    function
    support($Sc)
    {
        return
            preg_match('~^(database|table|columns|sql|indexes|descidx|comment|view|' . (min_version(9.3) ? 'materializedview|' : '') . 'scheme|routine|processlist|sequence|trigger|type|variables|drop_col|kill|dump)$~', $Sc);
    }

    function
    kill_process($X)
    {
        return
            queries("SELECT pg_terminate_backend(" . number($X) . ")");
    }

    function
    connection_id()
    {
        return "SELECT pg_backend_pid()";
    }

    function
    max_connections()
    {
        global $f;
        return $f->result("SHOW max_connections");
    }

    function
    driver_config()
    {
        $U = array();
        $Fh = array();
        foreach (array('Numbers' => array("smallint" => 5, "integer" => 10, "bigint" => 19, "boolean" => 1, "numeric" => 0, "real" => 7, "double precision" => 16, "money" => 20), 'Date and time' => array("date" => 13, "time" => 17, "timestamp" => 20, "timestamptz" => 21, "interval" => 0), 'Strings' => array("character" => 0, "character varying" => 0, "text" => 0, "tsquery" => 0, "tsvector" => 0, "uuid" => 0, "xml" => 0), 'Binary' => array("bit" => 0, "bit varying" => 0, "bytea" => 0), 'Network' => array("cidr" => 43, "inet" => 43, "macaddr" => 17, "txid_snapshot" => 0), 'Geometry' => array("box" => 0, "circle" => 0, "line" => 0, "lseg" => 0, "path" => 0, "point" => 0, "polygon" => 0),) as $z => $X) {
            $U += $X;
            $Fh[$z] = array_keys($X);
        }
        return
            array('possible_drivers' => array("PgSQL", "PDO_PgSQL"), 'jush' => "pgsql", 'types' => $U, 'structured_types' => $Fh, 'unsigned' => array(), 'operators' => array("=", "<", ">", "<=", ">=", "!=", "~", "!~", "LIKE", "LIKE %%", "ILIKE", "ILIKE %%", "IN", "IS NULL", "NOT LIKE", "NOT IN", "IS NOT NULL"), 'functions' => array("char_length", "lower", "round", "to_hex", "to_timestamp", "upper"), 'grouping' => array("avg", "count", "count distinct", "max", "min", "sum"), 'edit_functions' => array(array("char" => "md5", "date|time" => "now",), array(number_type() => "+/-", "date|time" => "+ interval/- interval", "char|text" => "||",)),);
    }
}
$hc["oracle"] = "Oracle (beta)";
if (isset($_GET["oracle"])) {
    define("DRIVER", "oracle");
    if (extension_loaded("oci8")) {
        class
        Min_DB
        {
            var $extension = "oci8", $_link, $_result, $server_info, $affected_rows, $errno, $error;
            var $_current_db;

            function
            _error($_c, $m)
            {
                if (ini_bool("html_errors")) $m = html_entity_decode(strip_tags($m));
                $m = preg_replace('~^[^:]*: ~', '', $m);
                $this->error = $m;
            }

            function
            connect($M, $V, $F)
            {
                $this->_link = @oci_new_connect($V, $F, $M, "AL32UTF8");
                if ($this->_link) {
                    $this->server_info = oci_server_version($this->_link);
                    return
                        true;
                }
                $m = oci_error();
                $this->error = $m["message"];
                return
                    false;
            }

            function
            quote($P)
            {
                return "'" . str_replace("'", "''", $P) . "'";
            }

            function
            select_db($i)
            {
                $this->_current_db = $i;
                return
                    true;
            }

            function
            query($G, $Ai = false)
            {
                $H = oci_parse($this->_link, $G);
                $this->error = "";
                if (!$H) {
                    $m = oci_error($this->_link);
                    $this->errno = $m["code"];
                    $this->error = $m["message"];
                    return
                        false;
                }
                set_error_handler(array($this, '_error'));
                $I = @oci_execute($H);
                restore_error_handler();
                if ($I) {
                    if (oci_num_fields($H)) return
                        new
                        Min_Result($H);
                    $this->affected_rows = oci_num_rows($H);
                    oci_free_statement($H);
                }
                return $I;
            }

            function
            multi_query($G)
            {
                return $this->_result = $this->query($G);
            }

            function
            store_result()
            {
                return $this->_result;
            }

            function
            next_result()
            {
                return
                    false;
            }

            function
            result($G, $n = 1)
            {
                $H = $this->query($G);
                if (!is_object($H) || !oci_fetch($H->_result)) return
                    false;
                return
                    oci_result($H->_result, $n);
            }
        }

        class
        Min_Result
        {
            var $_result, $_offset = 1, $num_rows;

            function
            __construct($H)
            {
                $this->_result = $H;
            }

            function
            _convert($J)
            {
                foreach ((array)$J
                         as $z => $X) {
                    if (is_a($X, 'OCI-Lob')) $J[$z] = $X->load();
                }
                return $J;
            }

            function
            fetch_assoc()
            {
                return $this->_convert(oci_fetch_assoc($this->_result));
            }

            function
            fetch_row()
            {
                return $this->_convert(oci_fetch_row($this->_result));
            }

            function
            fetch_field()
            {
                $d = $this->_offset++;
                $I = new
                stdClass;
                $I->name = oci_field_name($this->_result, $d);
                $I->orgname = $I->name;
                $I->type = oci_field_type($this->_result, $d);
                $I->charsetnr = (preg_match("~raw|blob|bfile~", $I->type) ? 63 : 0);
                return $I;
            }

            function
            __destruct()
            {
                oci_free_statement($this->_result);
            }
        }
    } elseif (extension_loaded("pdo_oci")) {
        class
        Min_DB
            extends
            Min_PDO
        {
            var $extension = "PDO_OCI";
            var $_current_db;

            function
            connect($M, $V, $F)
            {
                $this->dsn("oci:dbname=//$M;charset=AL32UTF8", $V, $F);
                return
                    true;
            }

            function
            select_db($i)
            {
                $this->_current_db = $i;
                return
                    true;
            }
        }
    }

    class
    Min_Driver
        extends
        Min_SQL
    {
        function
        begin()
        {
            return
                true;
        }

        function
        insertUpdate($Q, $K, $jg)
        {
            global $f;
            foreach ($K
                     as $N) {
                $Hi = array();
                $Z = array();
                foreach ($N
                         as $z => $X) {
                    $Hi[] = "$z = $X";
                    if (isset($jg[idf_unescape($z)])) $Z[] = "$z = $X";
                }
                if (!(($Z && queries("UPDATE " . table($Q) . " SET " . implode(", ", $Hi) . " WHERE " . implode(" AND ", $Z)) && $f->affected_rows) || queries("INSERT INTO " . table($Q) . " (" . implode(", ", array_keys($N)) . ") VALUES (" . implode(", ", $N) . ")"))) return
                    false;
            }
            return
                true;
        }
    }

    function
    idf_escape($v)
    {
        return '"' . str_replace('"', '""', $v) . '"';
    }

    function
    table($v)
    {
        return
            idf_escape($v);
    }

    function
    connect()
    {
        global $b;
        $f = new
        Min_DB;
        $Kb = $b->credentials();
        if ($f->connect($Kb[0], $Kb[1], $Kb[2])) return $f;
        return $f->error;
    }

    function
    get_databases()
    {
        return
            get_vals("SELECT tablespace_name FROM user_tablespaces ORDER BY 1");
    }

    function
    limit($G, $Z, $_, $gf = 0, $gh = " ")
    {
        return ($gf ? " * FROM (SELECT t.*, rownum AS rnum FROM (SELECT $G$Z) t WHERE rownum <= " . ($_ + $gf) . ") WHERE rnum > $gf" : ($_ !== null ? " * FROM (SELECT $G$Z) WHERE rownum <= " . ($_ + $gf) : " $G$Z"));
    }

    function
    limit1($Q, $G, $Z, $gh = "\n")
    {
        return " $G$Z";
    }

    function
    db_collation($k, $mb)
    {
        global $f;
        return $f->result("SELECT value FROM nls_database_parameters WHERE parameter = 'NLS_CHARACTERSET'");
    }

    function
    engines()
    {
        return
            array();
    }

    function
    logged_user()
    {
        global $f;
        return $f->result("SELECT USER FROM DUAL");
    }

    function
    get_current_db()
    {
        global $f;
        $k = $f->_current_db ? $f->_current_db : DB;
        unset($f->_current_db);
        return $k;
    }

    function
    where_owner($hg, $Jf = "owner")
    {
        if (!$_GET["ns"]) return '';
        return "$hg$Jf = sys_context('USERENV', 'CURRENT_SCHEMA')";
    }

    function
    views_table($e)
    {
        $Jf = where_owner('');
        return "(SELECT $e FROM all_views WHERE " . ($Jf ? $Jf : "rownum < 0") . ")";
    }

    function
    tables_list()
    {
        $Wi = views_table("view_name");
        $Jf = where_owner(" AND ");
        return
            get_key_vals("SELECT table_name, 'table' FROM all_tables WHERE tablespace_name = " . q(DB) . "$Jf
UNION SELECT view_name, 'view' FROM $Wi
ORDER BY 1");
    }

    function
    count_tables($j)
    {
        global $f;
        $I = array();
        foreach ($j
                 as $k) $I[$k] = $f->result("SELECT COUNT(*) FROM all_tables WHERE tablespace_name = " . q($k));
        return $I;
    }

    function
    table_status($D = "")
    {
        $I = array();
        $ah = q($D);
        $k = get_current_db();
        $Wi = views_table("view_name");
        $Jf = where_owner(" AND ");
        foreach (get_rows('SELECT table_name "Name", \'table\' "Engine", avg_row_len * num_rows "Data_length", num_rows "Rows" FROM all_tables WHERE tablespace_name = ' . q($k) . $Jf . ($D != "" ? " AND table_name = $ah" : "") . "
UNION SELECT view_name, 'view', 0, 0 FROM $Wi" . ($D != "" ? " WHERE view_name = $ah" : "") . "
ORDER BY 1") as $J) {
            if ($D != "") return $J;
            $I[$J["Name"]] = $J;
        }
        return $I;
    }

    function
    is_view($R)
    {
        return $R["Engine"] == "view";
    }

    function
    fk_support($R)
    {
        return
            true;
    }

    function
    fields($Q)
    {
        $I = array();
        $Jf = where_owner(" AND ");
        foreach (get_rows("SELECT * FROM all_tab_columns WHERE table_name = " . q($Q) . "$Jf ORDER BY column_id") as $J) {
            $T = $J["DATA_TYPE"];
            $se = "$J[DATA_PRECISION],$J[DATA_SCALE]";
            if ($se == ",") $se = $J["CHAR_COL_DECL_LENGTH"];
            $I[$J["COLUMN_NAME"]] = array("field" => $J["COLUMN_NAME"], "full_type" => $T . ($se ? "($se)" : ""), "type" => strtolower($T), "length" => $se, "default" => $J["DATA_DEFAULT"], "null" => ($J["NULLABLE"] == "Y"), "privileges" => array("insert" => 1, "select" => 1, "update" => 1),);
        }
        return $I;
    }

    function
    indexes($Q, $g = null)
    {
        $I = array();
        $Jf = where_owner(" AND ", "aic.table_owner");
        foreach (get_rows("SELECT aic.*, ac.constraint_type
FROM all_ind_columns aic
LEFT JOIN all_constraints ac ON aic.index_name = ac.constraint_name AND aic.table_name = ac.table_name AND aic.index_owner = ac.owner
WHERE aic.table_name = " . q($Q) . "$Jf
ORDER BY ac.constraint_type, aic.column_position", $g) as $J) {
            $Jd = $J["INDEX_NAME"];
            $I[$Jd]["type"] = ($J["CONSTRAINT_TYPE"] == "P" ? "PRIMARY" : ($J["CONSTRAINT_TYPE"] == "U" ? "UNIQUE" : "INDEX"));
            $I[$Jd]["columns"][] = $J["COLUMN_NAME"];
            $I[$Jd]["lengths"][] = ($J["CHAR_LENGTH"] && $J["CHAR_LENGTH"] != $J["COLUMN_LENGTH"] ? $J["CHAR_LENGTH"] : null);
            $I[$Jd]["descs"][] = ($J["DESCEND"] ? '1' : null);
        }
        return $I;
    }

    function
    view($D)
    {
        $Wi = views_table("view_name, text");
        $K = get_rows('SELECT text "select" FROM ' . $Wi . ' WHERE view_name = ' . q($D));
        return
            reset($K);
    }

    function
    collations()
    {
        return
            array();
    }

    function
    information_schema($k)
    {
        return
            false;
    }

    function
    error()
    {
        global $f;
        return
            h($f->error);
    }

    function
    explain($f, $G)
    {
        $f->query("EXPLAIN PLAN FOR $G");
        return $f->query("SELECT * FROM plan_table");
    }

    function
    found_rows($R, $Z)
    {
    }

    function
    auto_increment()
    {
        return "";
    }

    function
    alter_table($Q, $D, $o, $ed, $rb, $xc, $lb, $Ka, $Sf)
    {
        $c = $ic = array();
        $Df = ($Q ? fields($Q) : array());
        foreach ($o
                 as $n) {
            $X = $n[1];
            if ($X && $n[0] != "" && idf_escape($n[0]) != $X[0]) queries("ALTER TABLE " . table($Q) . " RENAME COLUMN " . idf_escape($n[0]) . " TO $X[0]");
            $Cf = $Df[$n[0]];
            if ($X && $Cf) {
                $if = process_field($Cf, $Cf);
                if ($X[2] == $if[2]) $X[2] = "";
            }
            if ($X) $c[] = ($Q != "" ? ($n[0] != "" ? "MODIFY (" : "ADD (") : "  ") . implode($X) . ($Q != "" ? ")" : ""); else$ic[] = idf_escape($n[0]);
        }
        if ($Q == "") return
            queries("CREATE TABLE " . table($D) . " (\n" . implode(",\n", $c) . "\n)");
        return (!$c || queries("ALTER TABLE " . table($Q) . "\n" . implode("\n", $c))) && (!$ic || queries("ALTER TABLE " . table($Q) . " DROP (" . implode(", ", $ic) . ")")) && ($Q == $D || queries("ALTER TABLE " . table($Q) . " RENAME TO " . table($D)));
    }

    function
    alter_indexes($Q, $c)
    {
        $h = array();
        $ic = array();
        $ug = array();
        foreach ($c
                 as $X) {
            $X[2] = preg_replace('~ DESC$~', '', $X[2]);
            if ($X[0] != "INDEX") $h[] = ($X[2] == "DROP" ? "\nDROP CONSTRAINT " . idf_escape($X[1]) : "\nADD" . ($X[1] != "" ? " CONSTRAINT " . idf_escape($X[1]) : "") . " $X[0] " . ($X[0] == "PRIMARY" ? "KEY " : "") . "(" . implode(", ", $X[2]) . ")"); elseif ($X[2] == "DROP") $ic[] = idf_escape($X[1]);
            else$ug[] = "CREATE INDEX " . idf_escape($X[1] != "" ? $X[1] : uniqid($Q . "_")) . " ON " . table($Q) . " (" . implode(", ", $X[2]) . ")";
        }
        if ($h) array_unshift($ug, "ALTER TABLE " . table($Q) . implode(",", $h));
        if ($ic) array_unshift($ug, "DROP INDEX " . implode(", ", $ic));
        foreach ($ug
                 as $G) {
            if (!queries($G)) return
                false;
        }
        return
            true;
    }

    function
    foreign_keys($Q)
    {
        $I = array();
        $G = "SELECT c_list.CONSTRAINT_NAME as NAME,
c_src.COLUMN_NAME as SRC_COLUMN,
c_dest.OWNER as DEST_DB,
c_dest.TABLE_NAME as DEST_TABLE,
c_dest.COLUMN_NAME as DEST_COLUMN,
c_list.DELETE_RULE as ON_DELETE
FROM ALL_CONSTRAINTS c_list, ALL_CONS_COLUMNS c_src, ALL_CONS_COLUMNS c_dest
WHERE c_list.CONSTRAINT_NAME = c_src.CONSTRAINT_NAME
AND c_list.R_CONSTRAINT_NAME = c_dest.CONSTRAINT_NAME
AND c_list.CONSTRAINT_TYPE = 'R'
AND c_src.TABLE_NAME = " . q($Q);
        foreach (get_rows($G) as $J) $I[$J['NAME']] = array("db" => $J['DEST_DB'], "table" => $J['DEST_TABLE'], "source" => array($J['SRC_COLUMN']), "target" => array($J['DEST_COLUMN']), "on_delete" => $J['ON_DELETE'], "on_update" => null,);
        return $I;
    }

    function
    truncate_tables($S)
    {
        return
            apply_queries("TRUNCATE TABLE", $S);
    }

    function
    drop_views($Xi)
    {
        return
            apply_queries("DROP VIEW", $Xi);
    }

    function
    drop_tables($S)
    {
        return
            apply_queries("DROP TABLE", $S);
    }

    function
    last_id()
    {
        return
            0;
    }

    function
    schemas()
    {
        $I = get_vals("SELECT DISTINCT owner FROM dba_segments WHERE owner IN (SELECT username FROM dba_users WHERE default_tablespace NOT IN ('SYSTEM','SYSAUX')) ORDER BY 1");
        return ($I ? $I : get_vals("SELECT DISTINCT owner FROM all_tables WHERE tablespace_name = " . q(DB) . " ORDER BY 1"));
    }

    function
    get_schema()
    {
        global $f;
        return $f->result("SELECT sys_context('USERENV', 'SESSION_USER') FROM dual");
    }

    function
    set_schema($Zg, $g = null)
    {
        global $f;
        if (!$g) $g = $f;
        return $g->query("ALTER SESSION SET CURRENT_SCHEMA = " . idf_escape($Zg));
    }

    function
    show_variables()
    {
        return
            get_key_vals('SELECT name, display_value FROM v$parameter');
    }

    function
    process_list()
    {
        return
            get_rows('SELECT sess.process AS "process", sess.username AS "user", sess.schemaname AS "schema", sess.status AS "status", sess.wait_class AS "wait_class", sess.seconds_in_wait AS "seconds_in_wait", sql.sql_text AS "sql_text", sess.machine AS "machine", sess.port AS "port"
FROM v$session sess LEFT OUTER JOIN v$sql sql
ON sql.sql_id = sess.sql_id
WHERE sess.type = \'USER\'
ORDER BY PROCESS
');
    }

    function
    show_status()
    {
        $K = get_rows('SELECT * FROM v$instance');
        return
            reset($K);
    }

    function
    convert_field($n)
    {
    }

    function
    unconvert_field($n, $I)
    {
        return $I;
    }

    function
    support($Sc)
    {
        return
            preg_match('~^(columns|database|drop_col|indexes|descidx|processlist|scheme|sql|status|table|variables|view)$~', $Sc);
    }

    function
    driver_config()
    {
        $U = array();
        $Fh = array();
        foreach (array('Numbers' => array("number" => 38, "binary_float" => 12, "binary_double" => 21), 'Date and time' => array("date" => 10, "timestamp" => 29, "interval year" => 12, "interval day" => 28), 'Strings' => array("char" => 2000, "varchar2" => 4000, "nchar" => 2000, "nvarchar2" => 4000, "clob" => 4294967295, "nclob" => 4294967295), 'Binary' => array("raw" => 2000, "long raw" => 2147483648, "blob" => 4294967295, "bfile" => 4294967296),) as $z => $X) {
            $U += $X;
            $Fh[$z] = array_keys($X);
        }
        return
            array('possible_drivers' => array("OCI8", "PDO_OCI"), 'jush' => "oracle", 'types' => $U, 'structured_types' => $Fh, 'unsigned' => array(), 'operators' => array("=", "<", ">", "<=", ">=", "!=", "LIKE", "LIKE %%", "IN", "IS NULL", "NOT LIKE", "NOT REGEXP", "NOT IN", "IS NOT NULL", "SQL"), 'functions' => array("length", "lower", "round", "upper"), 'grouping' => array("avg", "count", "count distinct", "max", "min", "sum"), 'edit_functions' => array(array("date" => "current_date", "timestamp" => "current_timestamp",), array("number|float|double" => "+/-", "date|timestamp" => "+ interval/- interval", "char|clob" => "||",)),);
    }
}
$hc["mssql"] = "MS SQL (beta)";
if (isset($_GET["mssql"])) {
    define("DRIVER", "mssql");
    if (extension_loaded("sqlsrv")) {
        class
        Min_DB
        {
            var $extension = "sqlsrv", $_link, $_result, $server_info, $affected_rows, $errno, $error;

            function
            _get_error()
            {
                $this->error = "";
                foreach (sqlsrv_errors() as $m) {
                    $this->errno = $m["code"];
                    $this->error .= "$m[message]\n";
                }
                $this->error = rtrim($this->error);
            }

            function
            connect($M, $V, $F)
            {
                global $b;
                $k = $b->database();
                $yb = array("UID" => $V, "PWD" => $F, "CharacterSet" => "UTF-8");
                if ($k != "") $yb["Database"] = $k;
                $this->_link = @sqlsrv_connect(preg_replace('~:~', ',', $M), $yb);
                if ($this->_link) {
                    $Qd = sqlsrv_server_info($this->_link);
                    $this->server_info = $Qd['SQLServerVersion'];
                } else$this->_get_error();
                return (bool)$this->_link;
            }

            function
            quote($P)
            {
                return "'" . str_replace("'", "''", $P) . "'";
            }

            function
            select_db($i)
            {
                return $this->query("USE " . idf_escape($i));
            }

            function
            query($G, $Ai = false)
            {
                $H = sqlsrv_query($this->_link, $G);
                $this->error = "";
                if (!$H) {
                    $this->_get_error();
                    return
                        false;
                }
                return $this->store_result($H);
            }

            function
            multi_query($G)
            {
                $this->_result = sqlsrv_query($this->_link, $G);
                $this->error = "";
                if (!$this->_result) {
                    $this->_get_error();
                    return
                        false;
                }
                return
                    true;
            }

            function
            store_result($H = null)
            {
                if (!$H) $H = $this->_result;
                if (!$H) return
                    false;
                if (sqlsrv_field_metadata($H)) return
                    new
                    Min_Result($H);
                $this->affected_rows = sqlsrv_rows_affected($H);
                return
                    true;
            }

            function
            next_result()
            {
                return $this->_result ? sqlsrv_next_result($this->_result) : null;
            }

            function
            result($G, $n = 0)
            {
                $H = $this->query($G);
                if (!is_object($H)) return
                    false;
                $J = $H->fetch_row();
                return $J[$n];
            }
        }

        class
        Min_Result
        {
            var $_result, $_offset = 0, $_fields, $num_rows;

            function
            __construct($H)
            {
                $this->_result = $H;
            }

            function
            _convert($J)
            {
                foreach ((array)$J
                         as $z => $X) {
                    if (is_a($X, 'DateTime')) $J[$z] = $X->format("Y-m-d H:i:s");
                }
                return $J;
            }

            function
            fetch_assoc()
            {
                return $this->_convert(sqlsrv_fetch_array($this->_result, SQLSRV_FETCH_ASSOC));
            }

            function
            fetch_row()
            {
                return $this->_convert(sqlsrv_fetch_array($this->_result, SQLSRV_FETCH_NUMERIC));
            }

            function
            fetch_field()
            {
                if (!$this->_fields) $this->_fields = sqlsrv_field_metadata($this->_result);
                $n = $this->_fields[$this->_offset++];
                $I = new
                stdClass;
                $I->name = $n["Name"];
                $I->orgname = $n["Name"];
                $I->type = ($n["Type"] == 1 ? 254 : 0);
                return $I;
            }

            function
            seek($gf)
            {
                for ($t = 0; $t < $gf; $t++) sqlsrv_fetch($this->_result);
            }

            function
            __destruct()
            {
                sqlsrv_free_stmt($this->_result);
            }
        }
    } elseif (extension_loaded("mssql")) {
        class
        Min_DB
        {
            var $extension = "MSSQL", $_link, $_result, $server_info, $affected_rows, $error;

            function
            connect($M, $V, $F)
            {
                $this->_link = @mssql_connect($M, $V, $F);
                if ($this->_link) {
                    $H = $this->query("SELECT SERVERPROPERTY('ProductLevel'), SERVERPROPERTY('Edition')");
                    if ($H) {
                        $J = $H->fetch_row();
                        $this->server_info = $this->result("sp_server_info 2", 2) . " [$J[0]] $J[1]";
                    }
                } else$this->error = mssql_get_last_message();
                return (bool)$this->_link;
            }

            function
            quote($P)
            {
                return "'" . str_replace("'", "''", $P) . "'";
            }

            function
            select_db($i)
            {
                return
                    mssql_select_db($i);
            }

            function
            query($G, $Ai = false)
            {
                $H = @mssql_query($G, $this->_link);
                $this->error = "";
                if (!$H) {
                    $this->error = mssql_get_last_message();
                    return
                        false;
                }
                if ($H === true) {
                    $this->affected_rows = mssql_rows_affected($this->_link);
                    return
                        true;
                }
                return
                    new
                    Min_Result($H);
            }

            function
            multi_query($G)
            {
                return $this->_result = $this->query($G);
            }

            function
            store_result()
            {
                return $this->_result;
            }

            function
            next_result()
            {
                return
                    mssql_next_result($this->_result->_result);
            }

            function
            result($G, $n = 0)
            {
                $H = $this->query($G);
                if (!is_object($H)) return
                    false;
                return
                    mssql_result($H->_result, 0, $n);
            }
        }

        class
        Min_Result
        {
            var $_result, $_offset = 0, $_fields, $num_rows;

            function
            __construct($H)
            {
                $this->_result = $H;
                $this->num_rows = mssql_num_rows($H);
            }

            function
            fetch_assoc()
            {
                return
                    mssql_fetch_assoc($this->_result);
            }

            function
            fetch_row()
            {
                return
                    mssql_fetch_row($this->_result);
            }

            function
            num_rows()
            {
                return
                    mssql_num_rows($this->_result);
            }

            function
            fetch_field()
            {
                $I = mssql_fetch_field($this->_result);
                $I->orgtable = $I->table;
                $I->orgname = $I->name;
                return $I;
            }

            function
            seek($gf)
            {
                mssql_data_seek($this->_result, $gf);
            }

            function
            __destruct()
            {
                mssql_free_result($this->_result);
            }
        }
    } elseif (extension_loaded("pdo_dblib")) {
        class
        Min_DB
            extends
            Min_PDO
        {
            var $extension = "PDO_DBLIB";

            function
            connect($M, $V, $F)
            {
                $this->dsn("dblib:charset=utf8;host=" . str_replace(":", ";unix_socket=", preg_replace('~:(\d)~', ';port=\1', $M)), $V, $F);
                return
                    true;
            }

            function
            select_db($i)
            {
                return $this->query("USE " . idf_escape($i));
            }
        }
    }

    class
    Min_Driver
        extends
        Min_SQL
    {
        function
        insertUpdate($Q, $K, $jg)
        {
            foreach ($K
                     as $N) {
                $Hi = array();
                $Z = array();
                foreach ($N
                         as $z => $X) {
                    $Hi[] = "$z = $X";
                    if (isset($jg[idf_unescape($z)])) $Z[] = "$z = $X";
                }
                if (!queries("MERGE " . table($Q) . " USING (VALUES(" . implode(", ", $N) . ")) AS source (c" . implode(", c", range(1, count($N))) . ") ON " . implode(" AND ", $Z) . " WHEN MATCHED THEN UPDATE SET " . implode(", ", $Hi) . " WHEN NOT MATCHED THEN INSERT (" . implode(", ", array_keys($N)) . ") VALUES (" . implode(", ", $N) . ");")) return
                    false;
            }
            return
                true;
        }

        function
        begin()
        {
            return
                queries("BEGIN TRANSACTION");
        }
    }

    function
    idf_escape($v)
    {
        return "[" . str_replace("]", "]]", $v) . "]";
    }

    function
    table($v)
    {
        return ($_GET["ns"] != "" ? idf_escape($_GET["ns"]) . "." : "") . idf_escape($v);
    }

    function
    connect()
    {
        global $b;
        $f = new
        Min_DB;
        $Kb = $b->credentials();
        if ($f->connect($Kb[0], $Kb[1], $Kb[2])) return $f;
        return $f->error;
    }

    function
    get_databases()
    {
        return
            get_vals("SELECT name FROM sys.databases WHERE name NOT IN ('master', 'tempdb', 'model', 'msdb')");
    }

    function
    limit($G, $Z, $_, $gf = 0, $gh = " ")
    {
        return ($_ !== null ? " TOP (" . ($_ + $gf) . ")" : "") . " $G$Z";
    }

    function
    limit1($Q, $G, $Z, $gh = "\n")
    {
        return
            limit($G, $Z, 1, 0, $gh);
    }

    function
    db_collation($k, $mb)
    {
        global $f;
        return $f->result("SELECT collation_name FROM sys.databases WHERE name = " . q($k));
    }

    function
    engines()
    {
        return
            array();
    }

    function
    logged_user()
    {
        global $f;
        return $f->result("SELECT SUSER_NAME()");
    }

    function
    tables_list()
    {
        return
            get_key_vals("SELECT name, type_desc FROM sys.all_objects WHERE schema_id = SCHEMA_ID(" . q(get_schema()) . ") AND type IN ('S', 'U', 'V') ORDER BY name");
    }

    function
    count_tables($j)
    {
        global $f;
        $I = array();
        foreach ($j
                 as $k) {
            $f->select_db($k);
            $I[$k] = $f->result("SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES");
        }
        return $I;
    }

    function
    table_status($D = "")
    {
        $I = array();
        foreach (get_rows("SELECT ao.name AS Name, ao.type_desc AS Engine, (SELECT value FROM fn_listextendedproperty(default, 'SCHEMA', schema_name(schema_id), 'TABLE', ao.name, null, null)) AS Comment FROM sys.all_objects AS ao WHERE schema_id = SCHEMA_ID(" . q(get_schema()) . ") AND type IN ('S', 'U', 'V') " . ($D != "" ? "AND name = " . q($D) : "ORDER BY name")) as $J) {
            if ($D != "") return $J;
            $I[$J["Name"]] = $J;
        }
        return $I;
    }

    function
    is_view($R)
    {
        return $R["Engine"] == "VIEW";
    }

    function
    fk_support($R)
    {
        return
            true;
    }

    function
    fields($Q)
    {
        $tb = get_key_vals("SELECT objname, cast(value as varchar(max)) FROM fn_listextendedproperty('MS_DESCRIPTION', 'schema', " . q(get_schema()) . ", 'table', " . q($Q) . ", 'column', NULL)");
        $I = array();
        foreach (get_rows("SELECT c.max_length, c.precision, c.scale, c.name, c.is_nullable, c.is_identity, c.collation_name, t.name type, CAST(d.definition as text) [default]
FROM sys.all_columns c
JOIN sys.all_objects o ON c.object_id = o.object_id
JOIN sys.types t ON c.user_type_id = t.user_type_id
LEFT JOIN sys.default_constraints d ON c.default_object_id = d.parent_column_id
WHERE o.schema_id = SCHEMA_ID(" . q(get_schema()) . ") AND o.type IN ('S', 'U', 'V') AND o.name = " . q($Q)) as $J) {
            $T = $J["type"];
            $se = (preg_match("~char|binary~", $T) ? $J["max_length"] : ($T == "decimal" ? "$J[precision],$J[scale]" : ""));
            $I[$J["name"]] = array("field" => $J["name"], "full_type" => $T . ($se ? "($se)" : ""), "type" => $T, "length" => $se, "default" => $J["default"], "null" => $J["is_nullable"], "auto_increment" => $J["is_identity"], "collation" => $J["collation_name"], "privileges" => array("insert" => 1, "select" => 1, "update" => 1), "primary" => $J["is_identity"], "comment" => $tb[$J["name"]],);
        }
        return $I;
    }

    function
    indexes($Q, $g = null)
    {
        $I = array();
        foreach (get_rows("SELECT i.name, key_ordinal, is_unique, is_primary_key, c.name AS column_name, is_descending_key
FROM sys.indexes i
INNER JOIN sys.index_columns ic ON i.object_id = ic.object_id AND i.index_id = ic.index_id
INNER JOIN sys.columns c ON ic.object_id = c.object_id AND ic.column_id = c.column_id
WHERE OBJECT_NAME(i.object_id) = " . q($Q), $g) as $J) {
            $D = $J["name"];
            $I[$D]["type"] = ($J["is_primary_key"] ? "PRIMARY" : ($J["is_unique"] ? "UNIQUE" : "INDEX"));
            $I[$D]["lengths"] = array();
            $I[$D]["columns"][$J["key_ordinal"]] = $J["column_name"];
            $I[$D]["descs"][$J["key_ordinal"]] = ($J["is_descending_key"] ? '1' : null);
        }
        return $I;
    }

    function
    view($D)
    {
        global $f;
        return
            array("select" => preg_replace('~^(?:[^[]|\[[^]]*])*\s+AS\s+~isU', '', $f->result("SELECT VIEW_DEFINITION FROM INFORMATION_SCHEMA.VIEWS WHERE TABLE_SCHEMA = SCHEMA_NAME() AND TABLE_NAME = " . q($D))));
    }

    function
    collations()
    {
        $I = array();
        foreach (get_vals("SELECT name FROM fn_helpcollations()") as $lb) $I[preg_replace('~_.*~', '', $lb)][] = $lb;
        return $I;
    }

    function
    information_schema($k)
    {
        return
            false;
    }

    function
    error()
    {
        global $f;
        return
            nl_br(h(preg_replace('~^(\[[^]]*])+~m', '', $f->error)));
    }

    function
    create_database($k, $lb)
    {
        return
            queries("CREATE DATABASE " . idf_escape($k) . (preg_match('~^[a-z0-9_]+$~i', $lb) ? " COLLATE $lb" : ""));
    }

    function
    drop_databases($j)
    {
        return
            queries("DROP DATABASE " . implode(", ", array_map('idf_escape', $j)));
    }

    function
    rename_database($D, $lb)
    {
        if (preg_match('~^[a-z0-9_]+$~i', $lb)) queries("ALTER DATABASE " . idf_escape(DB) . " COLLATE $lb");
        queries("ALTER DATABASE " . idf_escape(DB) . " MODIFY NAME = " . idf_escape($D));
        return
            true;
    }

    function
    auto_increment()
    {
        return " IDENTITY" . ($_POST["Auto_increment"] != "" ? "(" . number($_POST["Auto_increment"]) . ",1)" : "") . " PRIMARY KEY";
    }

    function
    alter_table($Q, $D, $o, $ed, $rb, $xc, $lb, $Ka, $Sf)
    {
        $c = array();
        $tb = array();
        foreach ($o
                 as $n) {
            $d = idf_escape($n[0]);
            $X = $n[1];
            if (!$X) $c["DROP"][] = " COLUMN $d"; else {
                $X[1] = preg_replace("~( COLLATE )'(\\w+)'~", '\1\2', $X[1]);
                $tb[$n[0]] = $X[5];
                unset($X[5]);
                if ($n[0] == "") $c["ADD"][] = "\n  " . implode("", $X) . ($Q == "" ? substr($ed[$X[0]], 16 + strlen($X[0])) : ""); else {
                    unset($X[6]);
                    if ($d != $X[0]) queries("EXEC sp_rename " . q(table($Q) . ".$d") . ", " . q(idf_unescape($X[0])) . ", 'COLUMN'");
                    $c["ALTER COLUMN " . implode("", $X)][] = "";
                }
            }
        }
        if ($Q == "") return
            queries("CREATE TABLE " . table($D) . " (" . implode(",", (array)$c["ADD"]) . "\n)");
        if ($Q != $D) queries("EXEC sp_rename " . q(table($Q)) . ", " . q($D));
        if ($ed) $c[""] = $ed;
        foreach ($c
                 as $z => $X) {
            if (!queries("ALTER TABLE " . idf_escape($D) . " $z" . implode(",", $X))) return
                false;
        }
        foreach ($tb
                 as $z => $X) {
            $rb = substr($X, 9);
            queries("EXEC sp_dropextendedproperty @name = N'MS_Description', @level0type = N'Schema', @level0name = " . q(get_schema()) . ", @level1type = N'Table', @level1name = " . q($D) . ", @level2type = N'Column', @level2name = " . q($z));
            queries("EXEC sp_addextendedproperty @name = N'MS_Description', @value = " . $rb . ", @level0type = N'Schema', @level0name = " . q(get_schema()) . ", @level1type = N'Table', @level1name = " . q($D) . ", @level2type = N'Column', @level2name = " . q($z));
        }
        return
            true;
    }

    function
    alter_indexes($Q, $c)
    {
        $w = array();
        $ic = array();
        foreach ($c
                 as $X) {
            if ($X[2] == "DROP") {
                if ($X[0] == "PRIMARY") $ic[] = idf_escape($X[1]); else$w[] = idf_escape($X[1]) . " ON " . table($Q);
            } elseif (!queries(($X[0] != "PRIMARY" ? "CREATE $X[0] " . ($X[0] != "INDEX" ? "INDEX " : "") . idf_escape($X[1] != "" ? $X[1] : uniqid($Q . "_")) . " ON " . table($Q) : "ALTER TABLE " . table($Q) . " ADD PRIMARY KEY") . " (" . implode(", ", $X[2]) . ")")) return
                false;
        }
        return (!$w || queries("DROP INDEX " . implode(", ", $w))) && (!$ic || queries("ALTER TABLE " . table($Q) . " DROP " . implode(", ", $ic)));
    }

    function
    last_id()
    {
        global $f;
        return $f->result("SELECT SCOPE_IDENTITY()");
    }

    function
    explain($f, $G)
    {
        $f->query("SET SHOWPLAN_ALL ON");
        $I = $f->query($G);
        $f->query("SET SHOWPLAN_ALL OFF");
        return $I;
    }

    function
    found_rows($R, $Z)
    {
    }

    function
    foreign_keys($Q)
    {
        $I = array();
        foreach (get_rows("EXEC sp_fkeys @fktable_name = " . q($Q)) as $J) {
            $q =& $I[$J["FK_NAME"]];
            $q["db"] = $J["PKTABLE_QUALIFIER"];
            $q["table"] = $J["PKTABLE_NAME"];
            $q["source"][] = $J["FKCOLUMN_NAME"];
            $q["target"][] = $J["PKCOLUMN_NAME"];
        }
        return $I;
    }

    function
    truncate_tables($S)
    {
        return
            apply_queries("TRUNCATE TABLE", $S);
    }

    function
    drop_views($Xi)
    {
        return
            queries("DROP VIEW " . implode(", ", array_map('table', $Xi)));
    }

    function
    drop_tables($S)
    {
        return
            queries("DROP TABLE " . implode(", ", array_map('table', $S)));
    }

    function
    move_tables($S, $Xi, $Vh)
    {
        return
            apply_queries("ALTER SCHEMA " . idf_escape($Vh) . " TRANSFER", array_merge($S, $Xi));
    }

    function
    trigger($D)
    {
        if ($D == "") return
            array();
        $K = get_rows("SELECT s.name [Trigger],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(s.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(s.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing],
c.text
FROM sysobjects s
JOIN syscomments c ON s.id = c.id
WHERE s.xtype = 'TR' AND s.name = " . q($D));
        $I = reset($K);
        if ($I) $I["Statement"] = preg_replace('~^.+\s+AS\s+~isU', '', $I["text"]);
        return $I;
    }

    function
    triggers($Q)
    {
        $I = array();
        foreach (get_rows("SELECT sys1.name,
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing]
FROM sysobjects sys1
JOIN sysobjects sys2 ON sys1.parent_obj = sys2.id
WHERE sys1.xtype = 'TR' AND sys2.name = " . q($Q)) as $J) $I[$J["name"]] = array($J["Timing"], $J["Event"]);
        return $I;
    }

    function
    trigger_options()
    {
        return
            array("Timing" => array("AFTER", "INSTEAD OF"), "Event" => array("INSERT", "UPDATE", "DELETE"), "Type" => array("AS"),);
    }

    function
    schemas()
    {
        return
            get_vals("SELECT name FROM sys.schemas");
    }

    function
    get_schema()
    {
        global $f;
        if ($_GET["ns"] != "") return $_GET["ns"];
        return $f->result("SELECT SCHEMA_NAME()");
    }

    function
    set_schema($Yg)
    {
        return
            true;
    }

    function
    use_sql($i)
    {
        return "USE " . idf_escape($i);
    }

    function
    show_variables()
    {
        return
            array();
    }

    function
    show_status()
    {
        return
            array();
    }

    function
    convert_field($n)
    {
    }

    function
    unconvert_field($n, $I)
    {
        return $I;
    }

    function
    support($Sc)
    {
        return
            preg_match('~^(comment|columns|database|drop_col|indexes|descidx|scheme|sql|table|trigger|view|view_trigger)$~', $Sc);
    }

    function
    driver_config()
    {
        $U = array();
        $Fh = array();
        foreach (array('Numbers' => array("tinyint" => 3, "smallint" => 5, "int" => 10, "bigint" => 20, "bit" => 1, "decimal" => 0, "real" => 12, "float" => 53, "smallmoney" => 10, "money" => 20), 'Date and time' => array("date" => 10, "smalldatetime" => 19, "datetime" => 19, "datetime2" => 19, "time" => 8, "datetimeoffset" => 10), 'Strings' => array("char" => 8000, "varchar" => 8000, "text" => 2147483647, "nchar" => 4000, "nvarchar" => 4000, "ntext" => 1073741823), 'Binary' => array("binary" => 8000, "varbinary" => 8000, "image" => 2147483647),) as $z => $X) {
            $U += $X;
            $Fh[$z] = array_keys($X);
        }
        return
            array('possible_drivers' => array("SQLSRV", "MSSQL", "PDO_DBLIB"), 'jush' => "mssql", 'types' => $U, 'structured_types' => $Fh, 'unsigned' => array(), 'operators' => array("=", "<", ">", "<=", ">=", "!=", "LIKE", "LIKE %%", "IN", "IS NULL", "NOT LIKE", "NOT IN", "IS NOT NULL"), 'functions' => array("len", "lower", "round", "upper"), 'grouping' => array("avg", "count", "count distinct", "max", "min", "sum"), 'edit_functions' => array(array("date|time" => "getdate",), array("int|decimal|real|float|money|datetime" => "+/-", "char|text" => "+",)),);
    }
}
$hc["mongo"] = "MongoDB (alpha)";
if (isset($_GET["mongo"])) {
    define("DRIVER", "mongo");
    if (class_exists('MongoDB')) {
        class
        Min_DB
        {
            var $extension = "Mongo", $server_info = MongoClient::VERSION, $error, $last_id, $_link, $_db;

            function
            connect($Ii, $wf)
            {
                try {
                    $this->_link = new
                    MongoClient($Ii, $wf);
                    if ($wf["password"] != "") {
                        $wf["password"] = "";
                        try {
                            new
                            MongoClient($Ii, $wf);
                            $this->error = 'Database does not support password.';
                        } catch (Exception$oc) {
                        }
                    }
                } catch (Exception$oc) {
                    $this->error = $oc->getMessage();
                }
            }

            function
            query($G)
            {
                return
                    false;
            }

            function
            select_db($i)
            {
                try {
                    $this->_db = $this->_link->selectDB($i);
                    return
                        true;
                } catch (Exception$Ec) {
                    $this->error = $Ec->getMessage();
                    return
                        false;
                }
            }

            function
            quote($P)
            {
                return $P;
            }
        }

        class
        Min_Result
        {
            var $num_rows, $_rows = array(), $_offset = 0, $_charset = array();

            function
            __construct($H)
            {
                foreach ($H
                         as $ce) {
                    $J = array();
                    foreach ($ce
                             as $z => $X) {
                        if (is_a($X, 'MongoBinData')) $this->_charset[$z] = 63;
                        $J[$z] = (is_a($X, 'MongoId') ? "ObjectId(\"$X\")" : (is_a($X, 'MongoDate') ? gmdate("Y-m-d H:i:s", $X->sec) . " GMT" : (is_a($X, 'MongoBinData') ? $X->bin : (is_a($X, 'MongoRegex') ? "$X" : (is_object($X) ? get_class($X) : $X)))));
                    }
                    $this->_rows[] = $J;
                    foreach ($J
                             as $z => $X) {
                        if (!isset($this->_rows[0][$z])) $this->_rows[0][$z] = null;
                    }
                }
                $this->num_rows = count($this->_rows);
            }

            function
            fetch_assoc()
            {
                $J = current($this->_rows);
                if (!$J) return $J;
                $I = array();
                foreach ($this->_rows[0] as $z => $X) $I[$z] = $J[$z];
                next($this->_rows);
                return $I;
            }

            function
            fetch_row()
            {
                $I = $this->fetch_assoc();
                if (!$I) return $I;
                return
                    array_values($I);
            }

            function
            fetch_field()
            {
                $ge = array_keys($this->_rows[0]);
                $D = $ge[$this->_offset++];
                return (object)array('name' => $D, 'charsetnr' => $this->_charset[$D],);
            }
        }

        class
        Min_Driver
            extends
            Min_SQL
        {
            public $jg = "_id";

            function
            select($Q, $L, $Z, $od, $yf = array(), $_ = 1, $E = 0, $lg = false)
            {
                $L = ($L == array("*") ? array() : array_fill_keys($L, true));
                $th = array();
                foreach ($yf
                         as $X) {
                    $X = preg_replace('~ DESC$~', '', $X, 1, $Gb);
                    $th[$X] = ($Gb ? -1 : 1);
                }
                return
                    new
                    Min_Result($this->_conn->_db->selectCollection($Q)->find(array(), $L)->sort($th)->limit($_ != "" ? +$_ : 0)->skip($E * $_));
            }

            function
            insert($Q, $N)
            {
                try {
                    $I = $this->_conn->_db->selectCollection($Q)->insert($N);
                    $this->_conn->errno = $I['code'];
                    $this->_conn->error = $I['err'];
                    $this->_conn->last_id = $N['_id'];
                    return !$I['err'];
                } catch (Exception$Ec) {
                    $this->_conn->error = $Ec->getMessage();
                    return
                        false;
                }
            }
        }

        function
        get_databases($cd)
        {
            global $f;
            $I = array();
            $Ub = $f->_link->listDBs();
            foreach ($Ub['databases'] as $k) $I[] = $k['name'];
            return $I;
        }

        function
        count_tables($j)
        {
            global $f;
            $I = array();
            foreach ($j
                     as $k) $I[$k] = count($f->_link->selectDB($k)->getCollectionNames(true));
            return $I;
        }

        function
        tables_list()
        {
            global $f;
            return
                array_fill_keys($f->_db->getCollectionNames(true), 'table');
        }

        function
        drop_databases($j)
        {
            global $f;
            foreach ($j
                     as $k) {
                $Kg = $f->_link->selectDB($k)->drop();
                if (!$Kg['ok']) return
                    false;
            }
            return
                true;
        }

        function
        indexes($Q, $g = null)
        {
            global $f;
            $I = array();
            foreach ($f->_db->selectCollection($Q)->getIndexInfo() as $w) {
                $bc = array();
                foreach ($w["key"] as $d => $T) $bc[] = ($T == -1 ? '1' : null);
                $I[$w["name"]] = array("type" => ($w["name"] == "_id_" ? "PRIMARY" : ($w["unique"] ? "UNIQUE" : "INDEX")), "columns" => array_keys($w["key"]), "lengths" => array(), "descs" => $bc,);
            }
            return $I;
        }

        function
        fields($Q)
        {
            return
                fields_from_edit();
        }

        function
        found_rows($R, $Z)
        {
            global $f;
            return $f->_db->selectCollection($_GET["select"])->count($Z);
        }

        $tf = array("=");
    } elseif (class_exists('MongoDB\Driver\Manager')) {
        class
        Min_DB
        {
            var $extension = "MongoDB", $server_info = MONGODB_VERSION, $affected_rows, $error, $last_id;
            var $_link;
            var $_db, $_db_name;

            function
            connect($Ii, $wf)
            {
                $gb = 'MongoDB\Driver\Manager';
                $this->_link = new$gb($Ii, $wf);
                $this->executeCommand('admin', array('ping' => 1));
            }

            function
            executeCommand($k, $pb)
            {
                $gb = 'MongoDB\Driver\Command';
                try {
                    return $this->_link->executeCommand($k, new$gb($pb));
                } catch (Exception$oc) {
                    $this->error = $oc->getMessage();
                    return
                        array();
                }
            }

            function
            executeBulkWrite($Ve, $Wa, $Hb)
            {
                try {
                    $Ng = $this->_link->executeBulkWrite($Ve, $Wa);
                    $this->affected_rows = $Ng->$Hb();
                    return
                        true;
                } catch (Exception$oc) {
                    $this->error = $oc->getMessage();
                    return
                        false;
                }
            }

            function
            query($G)
            {
                return
                    false;
            }

            function
            select_db($i)
            {
                $this->_db_name = $i;
                return
                    true;
            }

            function
            quote($P)
            {
                return $P;
            }
        }

        class
        Min_Result
        {
            var $num_rows, $_rows = array(), $_offset = 0, $_charset = array();

            function
            __construct($H)
            {
                foreach ($H
                         as $ce) {
                    $J = array();
                    foreach ($ce
                             as $z => $X) {
                        if (is_a($X, 'MongoDB\BSON\Binary')) $this->_charset[$z] = 63;
                        $J[$z] = (is_a($X, 'MongoDB\BSON\ObjectID') ? 'MongoDB\BSON\ObjectID("' . "$X\")" : (is_a($X, 'MongoDB\BSON\UTCDatetime') ? $X->toDateTime()->format('Y-m-d H:i:s') : (is_a($X, 'MongoDB\BSON\Binary') ? $X->getData() : (is_a($X, 'MongoDB\BSON\Regex') ? "$X" : (is_object($X) || is_array($X) ? json_encode($X, 256) : $X)))));
                    }
                    $this->_rows[] = $J;
                    foreach ($J
                             as $z => $X) {
                        if (!isset($this->_rows[0][$z])) $this->_rows[0][$z] = null;
                    }
                }
                $this->num_rows = count($this->_rows);
            }

            function
            fetch_assoc()
            {
                $J = current($this->_rows);
                if (!$J) return $J;
                $I = array();
                foreach ($this->_rows[0] as $z => $X) $I[$z] = $J[$z];
                next($this->_rows);
                return $I;
            }

            function
            fetch_row()
            {
                $I = $this->fetch_assoc();
                if (!$I) return $I;
                return
                    array_values($I);
            }

            function
            fetch_field()
            {
                $ge = array_keys($this->_rows[0]);
                $D = $ge[$this->_offset++];
                return (object)array('name' => $D, 'charsetnr' => $this->_charset[$D],);
            }
        }

        class
        Min_Driver
            extends
            Min_SQL
        {
            public $jg = "_id";

            function
            select($Q, $L, $Z, $od, $yf = array(), $_ = 1, $E = 0, $lg = false)
            {
                global $f;
                $L = ($L == array("*") ? array() : array_fill_keys($L, 1));
                if (count($L) && !isset($L['_id'])) $L['_id'] = 0;
                $Z = where_to_query($Z);
                $th = array();
                foreach ($yf
                         as $X) {
                    $X = preg_replace('~ DESC$~', '', $X, 1, $Gb);
                    $th[$X] = ($Gb ? -1 : 1);
                }
                if (isset($_GET['limit']) && is_numeric($_GET['limit']) && $_GET['limit'] > 0) $_ = $_GET['limit'];
                $_ = min(200, max(1, (int)$_));
                $qh = $E * $_;
                $gb = 'MongoDB\Driver\Query';
                try {
                    return
                        new
                        Min_Result($f->_link->executeQuery("$f->_db_name.$Q", new$gb($Z, array('projection' => $L, 'limit' => $_, 'skip' => $qh, 'sort' => $th))));
                } catch (Exception$oc) {
                    $f->error = $oc->getMessage();
                    return
                        false;
                }
            }

            function
            update($Q, $N, $vg, $_ = 0, $gh = "\n")
            {
                global $f;
                $k = $f->_db_name;
                $Z = sql_query_where_parser($vg);
                $gb = 'MongoDB\Driver\BulkWrite';
                $Wa = new$gb(array());
                if (isset($N['_id'])) unset($N['_id']);
                $Hg = array();
                foreach ($N
                         as $z => $Y) {
                    if ($Y == 'NULL') {
                        $Hg[$z] = 1;
                        unset($N[$z]);
                    }
                }
                $Hi = array('$set' => $N);
                if (count($Hg)) $Hi['$unset'] = $Hg;
                $Wa->update($Z, $Hi, array('upsert' => false));
                return $f->executeBulkWrite("$k.$Q", $Wa, 'getModifiedCount');
            }

            function
            delete($Q, $vg, $_ = 0)
            {
                global $f;
                $k = $f->_db_name;
                $Z = sql_query_where_parser($vg);
                $gb = 'MongoDB\Driver\BulkWrite';
                $Wa = new$gb(array());
                $Wa->delete($Z, array('limit' => $_));
                return $f->executeBulkWrite("$k.$Q", $Wa, 'getDeletedCount');
            }

            function
            insert($Q, $N)
            {
                global $f;
                $k = $f->_db_name;
                $gb = 'MongoDB\Driver\BulkWrite';
                $Wa = new$gb(array());
                if ($N['_id'] == '') unset($N['_id']);
                $Wa->insert($N);
                return $f->executeBulkWrite("$k.$Q", $Wa, 'getInsertedCount');
            }
        }

        function
        get_databases($cd)
        {
            global $f;
            $I = array();
            foreach ($f->executeCommand('admin', array('listDatabases' => 1)) as $Ub) {
                foreach ($Ub->databases
                         as $k) $I[] = $k->name;
            }
            return $I;
        }

        function
        count_tables($j)
        {
            $I = array();
            return $I;
        }

        function
        tables_list()
        {
            global $f;
            $nb = array();
            foreach ($f->executeCommand($f->_db_name, array('listCollections' => 1)) as $H) $nb[$H->name] = 'table';
            return $nb;
        }

        function
        drop_databases($j)
        {
            return
                false;
        }

        function
        indexes($Q, $g = null)
        {
            global $f;
            $I = array();
            foreach ($f->executeCommand($f->_db_name, array('listIndexes' => $Q)) as $w) {
                $bc = array();
                $e = array();
                foreach (get_object_vars($w->key) as $d => $T) {
                    $bc[] = ($T == -1 ? '1' : null);
                    $e[] = $d;
                }
                $I[$w->name] = array("type" => ($w->name == "_id_" ? "PRIMARY" : (isset($w->unique) ? "UNIQUE" : "INDEX")), "columns" => $e, "lengths" => array(), "descs" => $bc,);
            }
            return $I;
        }

        function
        fields($Q)
        {
            global $l;
            $o = fields_from_edit();
            if (!$o) {
                $H = $l->select($Q, array("*"), null, null, array(), 10);
                if ($H) {
                    while ($J = $H->fetch_assoc()) {
                        foreach ($J
                                 as $z => $X) {
                            $J[$z] = null;
                            $o[$z] = array("field" => $z, "type" => "string", "null" => ($z != $l->primary), "auto_increment" => ($z == $l->primary), "privileges" => array("insert" => 1, "select" => 1, "update" => 1,),);
                        }
                    }
                }
            }
            return $o;
        }

        function
        found_rows($R, $Z)
        {
            global $f;
            $Z = where_to_query($Z);
            $li = $f->executeCommand($f->_db_name, array('count' => $R['Name'], 'query' => $Z))->toArray();
            return $li[0]->n;
        }

        function
        sql_query_where_parser($vg)
        {
            $vg = preg_replace('~^\sWHERE \(?\(?(.+?)\)?\)?$~', '\1', $vg);
            $hj = explode(' AND ', $vg);
            $ij = explode(') OR (', $vg);
            $Z = array();
            foreach ($hj
                     as $fj) $Z[] = trim($fj);
            if (count($ij) == 1) $ij = array(); elseif (count($ij) > 1) $Z = array();
            return
                where_to_query($Z, $ij);
        }

        function
        where_to_query($dj = array(), $ej = array())
        {
            global $b;
            $Pb = array();
            foreach (array('and' => $dj, 'or' => $ej) as $T => $Z) {
                if (is_array($Z)) {
                    foreach ($Z
                             as $Kc) {
                        list($jb, $rf, $X) = explode(" ", $Kc, 3);
                        if ($jb == "_id" && preg_match('~^(MongoDB\\\\BSON\\\\ObjectID)\("(.+)"\)$~', $X, $C)) {
                            list(, $gb, $X) = $C;
                            $X = new$gb($X);
                        }
                        if (!in_array($rf, $b->operators)) continue;
                        if (preg_match('~^\(f\)(.+)~', $rf, $C)) {
                            $X = (float)$X;
                            $rf = $C[1];
                        } elseif (preg_match('~^\(date\)(.+)~', $rf, $C)) {
                            $Rb = new
                            DateTime($X);
                            $gb = 'MongoDB\BSON\UTCDatetime';
                            $X = new$gb($Rb->getTimestamp() * 1000);
                            $rf = $C[1];
                        }
                        switch ($rf) {
                            case'=':
                                $rf = '$eq';
                                break;
                            case'!=':
                                $rf = '$ne';
                                break;
                            case'>':
                                $rf = '$gt';
                                break;
                            case'<':
                                $rf = '$lt';
                                break;
                            case'>=':
                                $rf = '$gte';
                                break;
                            case'<=':
                                $rf = '$lte';
                                break;
                            case'regex':
                                $rf = '$regex';
                                break;
                            default:
                                continue
                                2;
                        }
                        if ($T == 'and') $Pb['$and'][] = array($jb => array($rf => $X)); elseif ($T == 'or') $Pb['$or'][] = array($jb => array($rf => $X));
                    }
                }
            }
            return $Pb;
        }

        $tf = array("=", "!=", ">", "<", ">=", "<=", "regex", "(f)=", "(f)!=", "(f)>", "(f)<", "(f)>=", "(f)<=", "(date)=", "(date)!=", "(date)>", "(date)<", "(date)>=", "(date)<=",);
    }
    function
    table($v)
    {
        return $v;
    }

    function
    idf_escape($v)
    {
        return $v;
    }

    function
    table_status($D = "", $Rc = false)
    {
        $I = array();
        foreach (tables_list() as $Q => $T) {
            $I[$Q] = array("Name" => $Q);
            if ($D == $Q) return $I[$Q];
        }
        return $I;
    }

    function
    create_database($k, $lb)
    {
        return
            true;
    }

    function
    last_id()
    {
        global $f;
        return $f->last_id;
    }

    function
    error()
    {
        global $f;
        return
            h($f->error);
    }

    function
    collations()
    {
        return
            array();
    }

    function
    logged_user()
    {
        global $b;
        $Kb = $b->credentials();
        return $Kb[1];
    }

    function
    connect()
    {
        global $b;
        $f = new
        Min_DB;
        list($M, $V, $F) = $b->credentials();
        $wf = array();
        if ($V . $F != "") {
            $wf["username"] = $V;
            $wf["password"] = $F;
        }
        $k = $b->database();
        if ($k != "") $wf["db"] = $k;
        if (($Ja = getenv("MONGO_AUTH_SOURCE"))) $wf["authSource"] = $Ja;
        $f->connect("mongodb://$M", $wf);
        if ($f->error) return $f->error;
        return $f;
    }

    function
    alter_indexes($Q, $c)
    {
        global $f;
        foreach ($c
                 as $X) {
            list($T, $D, $N) = $X;
            if ($N == "DROP") $I = $f->_db->command(array("deleteIndexes" => $Q, "index" => $D)); else {
                $e = array();
                foreach ($N
                         as $d) {
                    $d = preg_replace('~ DESC$~', '', $d, 1, $Gb);
                    $e[$d] = ($Gb ? -1 : 1);
                }
                $I = $f->_db->selectCollection($Q)->ensureIndex($e, array("unique" => ($T == "UNIQUE"), "name" => $D,));
            }
            if ($I['errmsg']) {
                $f->error = $I['errmsg'];
                return
                    false;
            }
        }
        return
            true;
    }

    function
    support($Sc)
    {
        return
            preg_match("~database|indexes|descidx~", $Sc);
    }

    function
    db_collation($k, $mb)
    {
    }

    function
    information_schema()
    {
    }

    function
    is_view($R)
    {
    }

    function
    convert_field($n)
    {
    }

    function
    unconvert_field($n, $I)
    {
        return $I;
    }

    function
    foreign_keys($Q)
    {
        return
            array();
    }

    function
    fk_support($R)
    {
    }

    function
    engines()
    {
        return
            array();
    }

    function
    alter_table($Q, $D, $o, $ed, $rb, $xc, $lb, $Ka, $Sf)
    {
        global $f;
        if ($Q == "") {
            $f->_db->createCollection($D);
            return
                true;
        }
    }

    function
    drop_tables($S)
    {
        global $f;
        foreach ($S
                 as $Q) {
            $Kg = $f->_db->selectCollection($Q)->drop();
            if (!$Kg['ok']) return
                false;
        }
        return
            true;
    }

    function
    truncate_tables($S)
    {
        global $f;
        foreach ($S
                 as $Q) {
            $Kg = $f->_db->selectCollection($Q)->remove();
            if (!$Kg['ok']) return
                false;
        }
        return
            true;
    }

    function
    driver_config()
    {
        global $tf;
        return
            array('possible_drivers' => array("mongo", "mongodb"), 'jush' => "mongo", 'operators' => $tf, 'functions' => array(), 'grouping' => array(), 'edit_functions' => array(array("json")),);
    }
}
$hc["elastic"] = "Elasticsearch (beta)";
if (isset($_GET["elastic"])) {
    define("DRIVER", "elastic");
    if (function_exists('json_decode') && ini_bool('allow_url_fopen')) {
        class
        Min_DB
        {
            var $extension = "JSON", $server_info, $errno, $error, $_url, $_db;

            function
            rootQuery($Wf, $Bb = array(), $Oe = 'GET')
            {
                @ini_set('track_errors', 1);
                $Wc = @file_get_contents("$this->_url/" . ltrim($Wf, '/'), false, stream_context_create(array('http' => array('method' => $Oe, 'content' => $Bb === null ? $Bb : json_encode($Bb), 'header' => 'Content-Type: application/json', 'ignore_errors' => 1,))));
                if (!$Wc) {
                    $this->error = $php_errormsg;
                    return $Wc;
                }
                if (!preg_match('~^HTTP/[0-9.]+ 2~i', $http_response_header[0])) {
                    $this->error = 'Invalid credentials.' . " $http_response_header[0]";
                    return
                        false;
                }
                $I = json_decode($Wc, true);
                if ($I === null) {
                    $this->errno = json_last_error();
                    if (function_exists('json_last_error_msg')) $this->error = json_last_error_msg(); else {
                        $_b = get_defined_constants(true);
                        foreach ($_b['json'] as $D => $Y) {
                            if ($Y == $this->errno && preg_match('~^JSON_ERROR_~', $D)) {
                                $this->error = $D;
                                break;
                            }
                        }
                    }
                }
                return $I;
            }

            function
            query($Wf, $Bb = array(), $Oe = 'GET')
            {
                return $this->rootQuery(($this->_db != "" ? "$this->_db/" : "/") . ltrim($Wf, '/'), $Bb, $Oe);
            }

            function
            connect($M, $V, $F)
            {
                preg_match('~^(https?://)?(.*)~', $M, $C);
                $this->_url = ($C[1] ? $C[1] : "http://") . "$V:$F@$C[2]";
                $I = $this->query('');
                if ($I) $this->server_info = $I['version']['number'];
                return (bool)$I;
            }

            function
            select_db($i)
            {
                $this->_db = $i;
                return
                    true;
            }

            function
            quote($P)
            {
                return $P;
            }
        }

        class
        Min_Result
        {
            var $num_rows, $_rows;

            function
            __construct($K)
            {
                $this->num_rows = count($K);
                $this->_rows = $K;
                reset($this->_rows);
            }

            function
            fetch_assoc()
            {
                $I = current($this->_rows);
                next($this->_rows);
                return $I;
            }

            function
            fetch_row()
            {
                return
                    array_values($this->fetch_assoc());
            }
        }
    }

    class
    Min_Driver
        extends
        Min_SQL
    {
        function
        select($Q, $L, $Z, $od, $yf = array(), $_ = 1, $E = 0, $lg = false)
        {
            global $b;
            $Pb = array();
            $G = "$Q/_search";
            if ($L != array("*")) $Pb["fields"] = $L;
            if ($yf) {
                $th = array();
                foreach ($yf
                         as $jb) {
                    $jb = preg_replace('~ DESC$~', '', $jb, 1, $Gb);
                    $th[] = ($Gb ? array($jb => "desc") : $jb);
                }
                $Pb["sort"] = $th;
            }
            if ($_) {
                $Pb["size"] = +$_;
                if ($E) $Pb["from"] = ($E * $_);
            }
            foreach ($Z
                     as $X) {
                list($jb, $rf, $X) = explode(" ", $X, 3);
                if ($jb == "_id") $Pb["query"]["ids"]["values"][] = $X; elseif ($jb . $X != "") {
                    $Yh = array("term" => array(($jb != "" ? $jb : "_all") => $X));
                    if ($rf == "=") $Pb["query"]["filtered"]["filter"]["and"][] = $Yh; else$Pb["query"]["filtered"]["query"]["bool"]["must"][] = $Yh;
                }
            }
            if ($Pb["query"] && !$Pb["query"]["filtered"]["query"] && !$Pb["query"]["ids"]) $Pb["query"]["filtered"]["query"] = array("match_all" => array());
            $Bh = microtime(true);
            $ah = $this->_conn->query($G, $Pb);
            if ($lg) echo $b->selectQuery("$G: " . json_encode($Pb), $Bh, !$ah);
            if (!$ah) return
                false;
            $I = array();
            foreach ($ah['hits']['hits'] as $Ad) {
                $J = array();
                if ($L == array("*")) $J["_id"] = $Ad["_id"];
                $o = $Ad['_source'];
                if ($L != array("*")) {
                    $o = array();
                    foreach ($L
                             as $z) $o[$z] = $Ad['fields'][$z];
                }
                foreach ($o
                         as $z => $X) {
                    if ($Pb["fields"]) $X = $X[0];
                    $J[$z] = (is_array($X) ? json_encode($X) : $X);
                }
                $I[] = $J;
            }
            return
                new
                Min_Result($I);
        }

        function
        update($T, $zg, $vg, $_ = 0, $gh = "\n")
        {
            $Uf = preg_split('~ *= *~', $vg);
            if (count($Uf) == 2) {
                $u = trim($Uf[1]);
                $G = "$T/$u";
                return $this->_conn->query($G, $zg, 'POST');
            }
            return
                false;
        }

        function
        insert($T, $zg)
        {
            $u = "";
            $G = "$T/$u";
            $Kg = $this->_conn->query($G, $zg, 'POST');
            $this->_conn->last_id = $Kg['_id'];
            return $Kg['created'];
        }

        function
        delete($T, $vg, $_ = 0)
        {
            $Fd = array();
            if (is_array($_GET["where"]) && $_GET["where"]["_id"]) $Fd[] = $_GET["where"]["_id"];
            if (is_array($_POST['check'])) {
                foreach ($_POST['check'] as $ab) {
                    $Uf = preg_split('~ *= *~', $ab);
                    if (count($Uf) == 2) $Fd[] = trim($Uf[1]);
                }
            }
            $this->_conn->affected_rows = 0;
            foreach ($Fd
                     as $u) {
                $G = "{$T}/{$u}";
                $Kg = $this->_conn->query($G, '{}', 'DELETE');
                if (is_array($Kg) && $Kg['found'] == true) $this->_conn->affected_rows++;
            }
            return $this->_conn->affected_rows;
        }
    }

    function
    connect()
    {
        global $b;
        $f = new
        Min_DB;
        list($M, $V, $F) = $b->credentials();
        if ($F != "" && $f->connect($M, $V, "")) return 'Database does not support password.';
        if ($f->connect($M, $V, $F)) return $f;
        return $f->error;
    }

    function
    support($Sc)
    {
        return
            preg_match("~database|table|columns~", $Sc);
    }

    function
    logged_user()
    {
        global $b;
        $Kb = $b->credentials();
        return $Kb[1];
    }

    function
    get_databases()
    {
        global $f;
        $I = $f->rootQuery('_aliases');
        if ($I) {
            $I = array_keys($I);
            sort($I, SORT_STRING);
        }
        return $I;
    }

    function
    collations()
    {
        return
            array();
    }

    function
    db_collation($k, $mb)
    {
    }

    function
    engines()
    {
        return
            array();
    }

    function
    count_tables($j)
    {
        global $f;
        $I = array();
        $H = $f->query('_stats');
        if ($H && $H['indices']) {
            $Nd = $H['indices'];
            foreach ($Nd
                     as $Md => $Ch) {
                $Ld = $Ch['total']['indexing'];
                $I[$Md] = $Ld['index_total'];
            }
        }
        return $I;
    }

    function
    tables_list()
    {
        global $f;
        if (min_version(6)) return
            array('_doc' => 'table');
        $I = $f->query('_mapping');
        if ($I) $I = array_fill_keys(array_keys($I[$f->_db]["mappings"]), 'table');
        return $I;
    }

    function
    table_status($D = "", $Rc = false)
    {
        global $f;
        $ah = $f->query("_search", array("size" => 0, "aggregations" => array("count_by_type" => array("terms" => array("field" => "_type")))), "POST");
        $I = array();
        if ($ah) {
            $S = $ah["aggregations"]["count_by_type"]["buckets"];
            foreach ($S
                     as $Q) {
                $I[$Q["key"]] = array("Name" => $Q["key"], "Engine" => "table", "Rows" => $Q["doc_count"],);
                if ($D != "" && $D == $Q["key"]) return $I[$D];
            }
        }
        return $I;
    }

    function
    error()
    {
        global $f;
        return
            h($f->error);
    }

    function
    information_schema()
    {
    }

    function
    is_view($R)
    {
    }

    function
    indexes($Q, $g = null)
    {
        return
            array(array("type" => "PRIMARY", "columns" => array("_id")),);
    }

    function
    fields($Q)
    {
        global $f;
        $ye = array();
        if (min_version(6)) {
            $H = $f->query("_mapping");
            if ($H) $ye = $H[$f->_db]['mappings']['properties'];
        } else {
            $H = $f->query("$Q/_mapping");
            if ($H) {
                $ye = $H[$Q]['properties'];
                if (!$ye) $ye = $H[$f->_db]['mappings'][$Q]['properties'];
            }
        }
        $I = array();
        if ($ye) {
            foreach ($ye
                     as $D => $n) {
                $I[$D] = array("field" => $D, "full_type" => $n["type"], "type" => $n["type"], "privileges" => array("insert" => 1, "select" => 1, "update" => 1),);
                if ($n["properties"]) {
                    unset($I[$D]["privileges"]["insert"]);
                    unset($I[$D]["privileges"]["update"]);
                }
            }
        }
        return $I;
    }

    function
    foreign_keys($Q)
    {
        return
            array();
    }

    function
    table($v)
    {
        return $v;
    }

    function
    idf_escape($v)
    {
        return $v;
    }

    function
    convert_field($n)
    {
    }

    function
    unconvert_field($n, $I)
    {
        return $I;
    }

    function
    fk_support($R)
    {
    }

    function
    found_rows($R, $Z)
    {
        return
            null;
    }

    function
    create_database($k)
    {
        global $f;
        return $f->rootQuery(urlencode($k), null, 'PUT');
    }

    function
    drop_databases($j)
    {
        global $f;
        return $f->rootQuery(urlencode(implode(',', $j)), array(), 'DELETE');
    }

    function
    alter_table($Q, $D, $o, $ed, $rb, $xc, $lb, $Ka, $Sf)
    {
        global $f;
        $rg = array();
        foreach ($o
                 as $Pc) {
            $Uc = trim($Pc[1][0]);
            $Vc = trim($Pc[1][1] ? $Pc[1][1] : "text");
            $rg[$Uc] = array('type' => $Vc);
        }
        if (!empty($rg)) $rg = array('properties' => $rg);
        return $f->query("_mapping/{$D}", $rg, 'PUT');
    }

    function
    drop_tables($S)
    {
        global $f;
        $I = true;
        foreach ($S
                 as $Q) $I = $I && $f->query(urlencode($Q), array(), 'DELETE');
        return $I;
    }

    function
    last_id()
    {
        global $f;
        return $f->last_id;
    }

    function
    driver_config()
    {
        $U = array();
        $Fh = array();
        foreach (array('Numbers' => array("long" => 3, "integer" => 5, "short" => 8, "byte" => 10, "double" => 20, "float" => 66, "half_float" => 12, "scaled_float" => 21), 'Date and time' => array("date" => 10), 'Strings' => array("string" => 65535, "text" => 65535), 'Binary' => array("binary" => 255),) as $z => $X) {
            $U += $X;
            $Fh[$z] = array_keys($X);
        }
        return
            array('possible_drivers' => array("json + allow_url_fopen"), 'jush' => "elastic", 'operators' => array("=", "query"), 'functions' => array(), 'grouping' => array(), 'edit_functions' => array(array("json")), 'types' => $U, 'structured_types' => $Fh,);
    }
}

class
Adminer
{
    var $operators;

    function
    credentials()
    {
        return
            array(SERVER, $_GET["username"], get_password());
    }

    function
    connectSsl()
    {
    }

    function
    permanentLogin($h = false)
    {
        return
            password_file($h);
    }

    function
    bruteForceKey()
    {
        return $_SERVER["REMOTE_ADDR"];
    }

    function
    database()
    {
        return
            DB;
    }

    function
    queryTimeout()
    {
        return
            2;
    }

    function
    headers()
    {
    }

    function
    csp()
    {
        return
            csp();
    }

    function
    head()
    {
        return
            true;
    }

    function
    css()
    {
        $I = array();
        $p = "../assets/css/database.css";
        if (file_exists($p)) $I[] = "$p?v=" . crc32(file_get_contents($p));
        return $I;
    }

    function
    loginForm()
    {
        global $hc;
        echo "<table cellspacing='0' class='layout'>\n", $this->loginFormField('driver', '<tr><th>' . 'System' . '<td>', html_select("auth[driver]", $hc, DRIVER, "loginDriver(this);") . "\n"), $this->loginFormField('server', '<tr><th>' . 'Server' . '<td>', '<input name="auth[server]" value="' . h(SERVER) . '" title="hostname[:port]" placeholder="localhost" autocapitalize="off">' . "\n"), $this->loginFormField('username', '<tr><th>' . 'Username' . '<td>', '<input name="auth[username]" id="username" value="' . h($_GET["username"]) . '" autocomplete="username" autocapitalize="off">' . script("focus(qs('#username')); qs('#username').form['auth[driver]'].onchange();")), $this->loginFormField('password', '<tr><th>' . 'Password' . '<td>', '<input type="password" name="auth[password]" autocomplete="current-password">' . "\n"), $this->loginFormField('db', '<tr><th>' . 'Database' . '<td>', '<input name="auth[db]" value="' . h($_GET["db"]) . '" autocapitalize="off">' . "\n"), "</table>\n", "<p><input type='submit' value='" . 'Login' . "'>\n", checkbox("auth[permanent]", 1, $_COOKIE["adminer_permanent"], 'Permanent login') . "\n";
    }

    function
    loginFormField($D, $yd, $Y)
    {
        return $yd . $Y;
    }

    function
    login($we, $F)
    {
        if ($F == "") return
            sprintf('Adminer does not support accessing a database without a password, <a href="https://www.adminer.org/en/password/"%s>more information</a>.', target_blank());
        return
            true;
    }

    function
    fieldName($n, $yf = 0)
    {
        return '<span title="' . h($n["full_type"]) . '">' . h($n["field"]) . '</span>';
    }

    function
    selectLinks($Mh, $N = "")
    {
        global $y, $l;
        echo '<p class="links">';
        $ve = array("select" => 'Select data');
        if (support("table") || support("indexes")) $ve["table"] = 'Show structure';
        if (support("table")) {
            if (is_view($Mh)) $ve["view"] = 'Alter view'; else$ve["create"] = 'Alter table';
        }
        if ($N !== null) $ve["edit"] = 'New item';
        $D = $Mh["Name"];
        foreach ($ve
                 as $z => $X) echo " <a href='" . h(ME) . "$z=" . urlencode($D) . ($z == "edit" ? $N : "") . "'" . bold(isset($_GET[$z])) . ">$X</a>";
        echo
        doc_link(array($y => $l->tableHelp($D)), "?"), "\n";
    }

    function
    foreignKeys($Q)
    {
        return
            foreign_keys($Q);
    }

    function
    backwardKeys($Q, $Lh)
    {
        return
            array();
    }

    function
    backwardKeysPrint($Na, $J)
    {
    }

    function
    selectQuery($G, $Bh, $Qc = false)
    {
        global $y, $l;
        $I = "</p>\n";
        if (!$Qc && ($aj = $l->warnings())) {
            $u = "warnings";
            $I = ", <a href='#$u'>" . 'Warnings' . "</a>" . script("qsl('a').onclick = partial(toggle, '$u');", "") . "$I<div id='$u' class='hidden'>\n$aj</div>\n";
        }
        return "<p><code class='jush-$y'>" . h(str_replace("\n", " ", $G)) . "</code> <span class='time'>(" . format_time($Bh) . ")</span>" . (support("sql") ? " <a href='" . h(ME) . "sql=" . urlencode($G) . "'>" . 'Edit' . "</a>" : "") . $I;
    }

    function
    sqlCommandQuery($G)
    {
        return
            shorten_utf8(trim($G), 1000);
    }

    function
    rowDescription($Q)
    {
        return "";
    }

    function
    rowDescriptions($K, $fd)
    {
        return $K;
    }

    function
    selectLink($X, $n)
    {
    }

    function
    selectVal($X, $A, $n, $Ff)
    {
        $I = ($X === null ? "<i>NULL</i>" : (preg_match("~char|binary|boolean~", $n["type"]) && !preg_match("~var~", $n["type"]) ? "<code>$X</code>" : $X));
        if (preg_match('~blob|bytea|raw|file~', $n["type"]) && !is_utf8($X)) $I = "<i>" . lang(array('%d byte', '%d bytes'), strlen($Ff)) . "</i>";
        if (preg_match('~json~', $n["type"])) $I = "<code class='jush-js'>$I</code>";
        return ($A ? "<a href='" . h($A) . "'" . (is_url($A) ? target_blank() : "") . ">$I</a>" : $I);
    }

    function
    editVal($X, $n)
    {
        return $X;
    }

    function
    tableStructurePrint($o)
    {
        echo "<div class='scrollable'>\n", "<table cellspacing='0' class='nowrap'>\n", "<thead><tr><th>" . 'Column' . "<td>" . 'Type' . (support("comment") ? "<td>" . 'Comment' : "") . "</thead>\n";
        foreach ($o
                 as $n) {
            echo "<tr" . odd() . "><th>" . h($n["field"]), "<td><span title='" . h($n["collation"]) . "'>" . h($n["full_type"]) . "</span>", ($n["null"] ? " <i>NULL</i>" : ""), ($n["auto_increment"] ? " <i>" . 'Auto Increment' . "</i>" : ""), (isset($n["default"]) ? " <span title='" . 'Default value' . "'>[<b>" . h($n["default"]) . "</b>]</span>" : ""), (support("comment") ? "<td>" . h($n["comment"]) : ""), "\n";
        }
        echo "</table>\n", "</div>\n";
    }

    function
    tableIndexesPrint($x)
    {
        echo "<table cellspacing='0'>\n";
        foreach ($x
                 as $D => $w) {
            ksort($w["columns"]);
            $lg = array();
            foreach ($w["columns"] as $z => $X) $lg[] = "<i>" . h($X) . "</i>" . ($w["lengths"][$z] ? "(" . $w["lengths"][$z] . ")" : "") . ($w["descs"][$z] ? " DESC" : "");
            echo "<tr title='" . h($D) . "'><th>$w[type]<td>" . implode(", ", $lg) . "\n";
        }
        echo "</table>\n";
    }

    function
    selectColumnsPrint($L, $e)
    {
        global $ld, $rd;
        print_fieldset("select", 'Select', $L);
        $t = 0;
        $L[""] = array();
        foreach ($L
                 as $z => $X) {
            $X = $_GET["columns"][$z];
            $d = select_input(" name='columns[$t][col]'", $e, $X["col"], ($z !== "" ? "selectFieldChange" : "selectAddRow"));
            echo "<div>" . ($ld || $rd ? "<select name='columns[$t][fun]'>" . optionlist(array(-1 => "") + array_filter(array('Functions' => $ld, 'Aggregation' => $rd)), $X["fun"]) . "</select>" . on_help("getTarget(event).value && getTarget(event).value.replace(/ |\$/, '(') + ')'", 1) . script("qsl('select').onchange = function () { helpClose();" . ($z !== "" ? "" : " qsl('select, input', this.parentNode).onchange();") . " };", "") . "($d)" : $d) . "</div>\n";
            $t++;
        }
        echo "</div></fieldset>\n";
    }

    function
    selectSearchPrint($Z, $e, $x)
    {
        print_fieldset("search", 'Search', $Z);
        foreach ($x
                 as $t => $w) {
            if ($w["type"] == "FULLTEXT") {
                echo "<div>(<i>" . implode("</i>, <i>", array_map('h', $w["columns"])) . "</i>) AGAINST", " <input type='search' name='fulltext[$t]' value='" . h($_GET["fulltext"][$t]) . "'>", script("qsl('input').oninput = selectFieldChange;", ""), checkbox("boolean[$t]", 1, isset($_GET["boolean"][$t]), "BOOL"), "</div>\n";
            }
        }
        $Ya = "this.parentNode.firstChild.onchange();";
        foreach (array_merge((array)$_GET["where"], array(array())) as $t => $X) {
            if (!$X || ("$X[col]$X[val]" != "" && in_array($X["op"], $this->operators))) {
                echo "<div>" . select_input(" name='where[$t][col]'", $e, $X["col"], ($X ? "selectFieldChange" : "selectAddRow"), "(" . 'anywhere' . ")"), html_select("where[$t][op]", $this->operators, $X["op"], $Ya), "<input type='search' name='where[$t][val]' value='" . h($X["val"]) . "'>", script("mixin(qsl('input'), {oninput: function () { $Ya }, onkeydown: selectSearchKeydown, onsearch: selectSearchSearch});", ""), "</div>\n";
            }
        }
        echo "</div></fieldset>\n";
    }

    function
    selectOrderPrint($yf, $e, $x)
    {
        print_fieldset("sort", 'Sort', $yf);
        $t = 0;
        foreach ((array)$_GET["order"] as $z => $X) {
            if ($X != "") {
                echo "<div>" . select_input(" name='order[$t]'", $e, $X, "selectFieldChange"), checkbox("desc[$t]", 1, isset($_GET["desc"][$z]), 'descending') . "</div>\n";
                $t++;
            }
        }
        echo "<div>" . select_input(" name='order[$t]'", $e, "", "selectAddRow"), checkbox("desc[$t]", 1, false, 'descending') . "</div>\n", "</div></fieldset>\n";
    }

    function
    selectLimitPrint($_)
    {
        echo "<fieldset><legend>" . 'Limit' . "</legend><div>";
        echo "<input type='number' name='limit' class='size' value='" . h($_) . "'>", script("qsl('input').oninput = selectFieldChange;", ""), "</div></fieldset>\n";
    }

    function
    selectLengthPrint($bi)
    {
        if ($bi !== null) {
            echo "<fieldset><legend>" . 'Text length' . "</legend><div>", "<input type='number' name='text_length' class='size' value='" . h($bi) . "'>", "</div></fieldset>\n";
        }
    }

    function
    selectActionPrint($x)
    {
        echo "<fieldset><legend>" . 'Action' . "</legend><div>", "<input type='submit' value='" . 'Select' . "'>", " <span id='noindex' title='" . 'Full table scan' . "'></span>", "<script" . nonce() . ">\n", "var indexColumns = ";
        $e = array();
        foreach ($x
                 as $w) {
            $Ob = reset($w["columns"]);
            if ($w["type"] != "FULLTEXT" && $Ob) $e[$Ob] = 1;
        }
        $e[""] = 1;
        foreach ($e
                 as $z => $X) json_row($z);
        echo ";\n", "selectFieldChange.call(qs('#form')['select']);\n", "</script>\n", "</div></fieldset>\n";
    }

    function
    selectCommandPrint()
    {
        return !information_schema(DB);
    }

    function
    selectImportPrint()
    {
        return !information_schema(DB);
    }

    function
    selectEmailPrint($uc, $e)
    {
    }

    function
    selectColumnsProcess($e, $x)
    {
        global $ld, $rd;
        $L = array();
        $od = array();
        foreach ((array)$_GET["columns"] as $z => $X) {
            if ($X["fun"] == "count" || ($X["col"] != "" && (!$X["fun"] || in_array($X["fun"], $ld) || in_array($X["fun"], $rd)))) {
                $L[$z] = apply_sql_function($X["fun"], ($X["col"] != "" ? idf_escape($X["col"]) : "*"));
                if (!in_array($X["fun"], $rd)) $od[] = $L[$z];
            }
        }
        return
            array($L, $od);
    }

    function
    selectSearchProcess($o, $x)
    {
        global $f, $l;
        $I = array();
        foreach ($x
                 as $t => $w) {
            if ($w["type"] == "FULLTEXT" && $_GET["fulltext"][$t] != "") $I[] = "MATCH (" . implode(", ", array_map('idf_escape', $w["columns"])) . ") AGAINST (" . q($_GET["fulltext"][$t]) . (isset($_GET["boolean"][$t]) ? " IN BOOLEAN MODE" : "") . ")";
        }
        foreach ((array)$_GET["where"] as $z => $X) {
            if ("$X[col]$X[val]" != "" && in_array($X["op"], $this->operators)) {
                $hg = "";
                $ub = " $X[op]";
                if (preg_match('~IN$~', $X["op"])) {
                    $Id = process_length($X["val"]);
                    $ub .= " " . ($Id != "" ? $Id : "(NULL)");
                } elseif ($X["op"] == "SQL") $ub = " $X[val]";
                elseif ($X["op"] == "LIKE %%") $ub = " LIKE " . $this->processInput($o[$X["col"]], "%$X[val]%");
                elseif ($X["op"] == "ILIKE %%") $ub = " ILIKE " . $this->processInput($o[$X["col"]], "%$X[val]%");
                elseif ($X["op"] == "FIND_IN_SET") {
                    $hg = "$X[op](" . q($X["val"]) . ", ";
                    $ub = ")";
                } elseif (!preg_match('~NULL$~', $X["op"])) $ub .= " " . $this->processInput($o[$X["col"]], $X["val"]);
                if ($X["col"] != "") $I[] = $hg . $l->convertSearch(idf_escape($X["col"]), $X, $o[$X["col"]]) . $ub; else {
                    $ob = array();
                    foreach ($o
                             as $D => $n) {
                        if ((preg_match('~^[-\d.' . (preg_match('~IN$~', $X["op"]) ? ',' : '') . ']+$~', $X["val"]) || !preg_match('~' . number_type() . '|bit~', $n["type"])) && (!preg_match("~[\x80-\xFF]~", $X["val"]) || preg_match('~char|text|enum|set~', $n["type"])) && (!preg_match('~date|timestamp~', $n["type"]) || preg_match('~^\d+-\d+-\d+~', $X["val"]))) $ob[] = $hg . $l->convertSearch(idf_escape($D), $X, $n) . $ub;
                    }
                    $I[] = ($ob ? "(" . implode(" OR ", $ob) . ")" : "1 = 0");
                }
            }
        }
        return $I;
    }

    function
    processInput($n, $Y, $s = "")
    {
        if ($s == "SQL") return $Y;
        $D = $n["field"];
        $I = q($Y);
        if (preg_match('~^(now|getdate|uuid)$~', $s)) $I = "$s()"; elseif (preg_match('~^current_(date|timestamp)$~', $s)) $I = $s;
        elseif (preg_match('~^([+-]|\|\|)$~', $s)) $I = idf_escape($D) . " $s $I";
        elseif (preg_match('~^[+-] interval$~', $s)) $I = idf_escape($D) . " $s " . (preg_match("~^(\\d+|'[0-9.: -]') [A-Z_]+\$~i", $Y) ? $Y : $I);
        elseif (preg_match('~^(addtime|subtime|concat)$~', $s)) $I = "$s(" . idf_escape($D) . ", $I)";
        elseif (preg_match('~^(md5|sha1|password|encrypt)$~', $s)) $I = "$s($I)";
        return
            unconvert_field($n, $I);
    }

    function
    selectOrderProcess($o, $x)
    {
        $I = array();
        foreach ((array)$_GET["order"] as $z => $X) {
            if ($X != "") $I[] = (preg_match('~^((COUNT\(DISTINCT |[A-Z0-9_]+\()(`(?:[^`]|``)+`|"(?:[^"]|"")+")\)|COUNT\(\*\))$~', $X) ? $X : idf_escape($X)) . (isset($_GET["desc"][$z]) ? " DESC" : "");
        }
        return $I;
    }

    function
    selectLimitProcess()
    {
        return (isset($_GET["limit"]) ? $_GET["limit"] : "50");
    }

    function
    selectLengthProcess()
    {
        return (isset($_GET["text_length"]) ? $_GET["text_length"] : "100");
    }

    function
    selectEmailProcess($Z, $fd)
    {
        return
            false;
    }

    function
    selectQueryBuild($L, $Z, $od, $yf, $_, $E)
    {
        return "";
    }

    function
    messageQuery($G, $ci, $Qc = false)
    {
        global $y, $l;
        restart_session();
        $zd =& get_session("queries");
        if (!$zd[$_GET["db"]]) $zd[$_GET["db"]] = array();
        if (strlen($G) > 1e6) $G = preg_replace('~[\x80-\xFF]+$~', '', substr($G, 0, 1e6)) . "\n…";
        $zd[$_GET["db"]][] = array($G, time(), $ci);
        $zh = "sql-" . count($zd[$_GET["db"]]);
        $I = "<a href='#$zh' class='toggle'>" . 'SQL command' . "</a>\n";
        if (!$Qc && ($aj = $l->warnings())) {
            $u = "warnings-" . count($zd[$_GET["db"]]);
            $I = "<a href='#$u' class='toggle'>" . 'Warnings' . "</a>, $I<div id='$u' class='hidden'>\n$aj</div>\n";
        }
        return " <span class='time'>" . @date("H:i:s") . "</span>" . " $I<div id='$zh' class='hidden'><pre><code class='jush-$y'>" . shorten_utf8($G, 1000) . "</code></pre>" . ($ci ? " <span class='time'>($ci)</span>" : '') . (support("sql") ? '<p><a href="' . h(str_replace("db=" . urlencode(DB), "db=" . urlencode($_GET["db"]), ME) . 'sql=&history=' . (count($zd[$_GET["db"]]) - 1)) . '">' . 'Edit' . '</a>' : '') . '</div>';
    }

    function
    editRowPrint($Q, $o, $J, $Hi)
    {
    }

    function
    editFunctions($n)
    {
        global $pc;
        $I = ($n["null"] ? "NULL/" : "");
        $Hi = isset($_GET["select"]) || where($_GET);
        foreach ($pc
                 as $z => $ld) {
            if (!$z || (!isset($_GET["call"]) && $Hi)) {
                foreach ($ld
                         as $Yf => $X) {
                    if (!$Yf || preg_match("~$Yf~", $n["type"])) $I .= "/$X";
                }
            }
            if ($z && !preg_match('~set|blob|bytea|raw|file|bool~', $n["type"])) $I .= "/SQL";
        }
        if ($n["auto_increment"] && !$Hi) $I = 'Auto Increment';
        return
            explode("/", $I);
    }

    function
    editInput($Q, $n, $Ha, $Y)
    {
        if ($n["type"] == "enum") return (isset($_GET["select"]) ? "<label><input type='radio'$Ha value='-1' checked><i>" . 'original' . "</i></label> " : "") . ($n["null"] ? "<label><input type='radio'$Ha value=''" . ($Y !== null || isset($_GET["select"]) ? "" : " checked") . "><i>NULL</i></label> " : "") . enum_input("radio", $Ha, $n, $Y, 0);
        return "";
    }

    function
    editHint($Q, $n, $Y)
    {
        return "";
    }

    function
    dumpOutput()
    {
        $I = array('text' => 'open', 'file' => 'save');
        if (function_exists('gzencode')) $I['gz'] = 'gzip';
        return $I;
    }

    function
    dumpFormat()
    {
        return
            array('sql' => 'SQL', 'csv' => 'CSV,', 'csv;' => 'CSV;', 'tsv' => 'TSV');
    }

    function
    dumpDatabase($k)
    {
    }

    function
    dumpTable($Q, $Gh, $be = 0)
    {
        if ($_POST["format"] != "sql") {
            echo "\xef\xbb\xbf";
            if ($Gh) dump_csv(array_keys(fields($Q)));
        } else {
            if ($be == 2) {
                $o = array();
                foreach (fields($Q) as $D => $n) $o[] = idf_escape($D) . " $n[full_type]";
                $h = "CREATE TABLE " . table($Q) . " (" . implode(", ", $o) . ")";
            } else$h = create_sql($Q, $_POST["auto_increment"], $Gh);
            set_utf8mb4($h);
            if ($Gh && $h) {
                if ($Gh == "DROP+CREATE" || $be == 1) echo "DROP " . ($be == 2 ? "VIEW" : "TABLE") . " IF EXISTS " . table($Q) . ";\n";
                if ($be == 1) $h = remove_definer($h);
                echo "$h;\n\n";
            }
        }
    }

    function
    dumpData($Q, $Gh, $G)
    {
        global $f, $y;
        $De = ($y == "sqlite" ? 0 : 1048576);
        if ($Gh) {
            if ($_POST["format"] == "sql") {
                if ($Gh == "TRUNCATE+INSERT") echo
                    truncate_sql($Q) . ";\n";
                $o = fields($Q);
            }
            $H = $f->query($G, 1);
            if ($H) {
                $Ud = "";
                $Va = "";
                $ge = array();
                $Ih = "";
                $Tc = ($Q != '' ? 'fetch_assoc' : 'fetch_row');
                while ($J = $H->$Tc()) {
                    if (!$ge) {
                        $Si = array();
                        foreach ($J
                                 as $X) {
                            $n = $H->fetch_field();
                            $ge[] = $n->name;
                            $z = idf_escape($n->name);
                            $Si[] = "$z = VALUES($z)";
                        }
                        $Ih = ($Gh == "INSERT+UPDATE" ? "\nON DUPLICATE KEY UPDATE " . implode(", ", $Si) : "") . ";\n";
                    }
                    if ($_POST["format"] != "sql") {
                        if ($Gh == "table") {
                            dump_csv($ge);
                            $Gh = "INSERT";
                        }
                        dump_csv($J);
                    } else {
                        if (!$Ud) $Ud = "INSERT INTO " . table($Q) . " (" . implode(", ", array_map('idf_escape', $ge)) . ") VALUES";
                        foreach ($J
                                 as $z => $X) {
                            $n = $o[$z];
                            $J[$z] = ($X !== null ? unconvert_field($n, preg_match(number_type(), $n["type"]) && !preg_match('~\[~', $n["full_type"]) && is_numeric($X) ? $X : q(($X === false ? 0 : $X))) : "NULL");
                        }
                        $Wg = ($De ? "\n" : " ") . "(" . implode(",\t", $J) . ")";
                        if (!$Va) $Va = $Ud . $Wg; elseif (strlen($Va) + 4 + strlen($Wg) + strlen($Ih) < $De) $Va .= ",$Wg";
                        else {
                            echo $Va . $Ih;
                            $Va = $Ud . $Wg;
                        }
                    }
                }
                if ($Va) echo $Va . $Ih;
            } elseif ($_POST["format"] == "sql") echo "-- " . str_replace("\n", " ", $f->error) . "\n";
        }
    }

    function
    dumpFilename($Dd)
    {
        return
            friendly_url($Dd != "" ? $Dd : (SERVER != "" ? SERVER : "localhost"));
    }

    function
    dumpHeaders($Dd, $Re = false)
    {
        $If = $_POST["output"];
        $Lc = (preg_match('~sql~', $_POST["format"]) ? "sql" : ($Re ? "tar" : "csv"));
        header("Content-Type: " . ($If == "gz" ? "application/x-gzip" : ($Lc == "tar" ? "application/x-tar" : ($Lc == "sql" || $If != "file" ? "text/plain" : "text/csv") . "; charset=utf-8")));
        if ($If == "gz") ob_start('ob_gzencode', 1e6);
        return $Lc;
    }

    function
    importServerPath()
    {
        return "adminer.sql";
    }

    function
    homepage()
    {
        echo '<p class="links">' . ($_GET["ns"] == "" && support("database") ? '<a href="' . h(ME) . 'database=">' . 'Alter database' . "</a>\n" : ""), (support("scheme") ? "<a href='" . h(ME) . "scheme='>" . ($_GET["ns"] != "" ? 'Alter schema' : 'Create schema') . "</a>\n" : ""), ($_GET["ns"] !== "" ? '<a href="' . h(ME) . 'schema=">' . 'Database schema' . "</a>\n" : ""), (support("privileges") ? "<a href='" . h(ME) . "privileges='>" . 'Privileges' . "</a>\n" : "");
        return
            true;
    }

    function
    navigation($Qe)
    {
        global $ia, $y, $hc, $f;
        echo '<h1>
', $this->name(), ' <span class="version">', $ia, '</span>
<a href="https://www.adminer.org/#download"', target_blank(), ' id="version">', (version_compare($ia, $_COOKIE["adminer_version"]) < 0 ? h($_COOKIE["adminer_version"]) : ""), '</a>
</h1>
';
        if ($Qe == "auth") {
            $If = "";
            foreach ((array)$_SESSION["pwds"] as $Ui => $kh) {
                foreach ($kh
                         as $M => $Pi) {
                    foreach ($Pi
                             as $V => $F) {
                        if ($F !== null) {
                            $Ub = $_SESSION["db"][$Ui][$M][$V];
                            foreach (($Ub ? array_keys($Ub) : array("")) as $k) $If .= "<li><a href='" . h(auth_url($Ui, $M, $V, $k)) . "'>($hc[$Ui]) " . h($V . ($M != "" ? "@" . $this->serverName($M) : "") . ($k != "" ? " - $k" : "")) . "</a>\n";
                        }
                    }
                }
            }
            if ($If) echo "<ul id='logins'>\n$If</ul>\n" . script("mixin(qs('#logins'), {onmouseover: menuOver, onmouseout: menuOut});");
        } else {
            if ($_GET["ns"] !== "" && !$Qe && DB != "") {
                $f->select_db(DB);
                $S = table_status('', true);
            }
            echo
            script_src(preg_replace("~\\?.*~", "", ME) . "?file=jush.js&version=4.8.0");
            if (support("sql")) {
                echo '<script', nonce(), '>
';
                if ($S) {
                    $ve = array();
                    foreach ($S
                             as $Q => $T) $ve[] = preg_quote($Q, '/');
                    echo "var jushLinks = { $y: [ '" . js_escape(ME) . (support("table") ? "table=" : "select=") . "\$&', /\\b(" . implode("|", $ve) . ")\\b/g ] };\n";
                    foreach (array("bac", "bra", "sqlite_quo", "mssql_bra") as $X) echo "jushLinks.$X = jushLinks.$y;\n";
                }
                $jh = $f->server_info;
                echo 'bodyLoad(\'', (is_object($f) ? preg_replace('~^(\d\.?\d).*~s', '\1', $jh) : ""), '\'', (preg_match('~MariaDB~', $jh) ? ", true" : ""), ');
</script>
';
            }
            $this->databasesPrint($Qe);
            if (DB == "" || !$Qe) {
                echo "<p class='links'>" . (support("sql") ? "<a href='" . h(ME) . "sql='" . bold(isset($_GET["sql"]) && !isset($_GET["import"])) . ">" . 'SQL command' . "</a>\n<a href='" . h(ME) . "import='" . bold(isset($_GET["import"])) . ">" . 'Import' . "</a>\n" : "") . "";
                if (support("dump")) echo "<a href='" . h(ME) . "dump=" . urlencode(isset($_GET["table"]) ? $_GET["table"] : $_GET["select"]) . "' id='dump'" . bold(isset($_GET["dump"])) . ">" . 'Export' . "</a>\n";
            }
            if ($_GET["ns"] !== "" && !$Qe && DB != "") {
                echo '<a href="' . h(ME) . 'create="' . bold($_GET["create"] === "") . ">" . 'Create table' . "</a>\n";
                if (!$S) echo "<p class='message'>" . 'No tables.' . "\n"; else$this->tablesPrint($S);
            }
        }
    }

    function
    name()
    {
        return "<a href='https://www.adminer.org/'" . target_blank() . " id='h1'>Adminer</a>";
    }

    function
    serverName($M)
    {
        return
            h($M);
    }

    function
    databasesPrint($Qe)
    {
        global $b, $f;
        $j = $this->databases();
        if (DB && $j && !in_array(DB, $j)) array_unshift($j, DB);
        echo '<form action="">
<p id="dbs">
';
        hidden_fields_get();
        $Sb = script("mixin(qsl('select'), {onmousedown: dbMouseDown, onchange: dbChange});");
        echo "<span title='" . 'database' . "'>" . 'DB' . "</span>: " . ($j ? "<select name='db'>" . optionlist(array("" => "") + $j, DB) . "</select>$Sb" : "<input name='db' value='" . h(DB) . "' autocapitalize='off'>\n"), "<input type='submit' value='" . 'Use' . "'" . ($j ? " class='hidden'" : "") . ">\n";
        if ($Qe != "db" && DB != "" && $f->select_db(DB)) {
            if (support("scheme")) {
                echo "<br>" . 'Schema' . ": <select name='ns'>" . optionlist(array("" => "") + $b->schemas(), $_GET["ns"]) . "</select>$Sb";
                if ($_GET["ns"] != "") set_schema($_GET["ns"]);
            }
        }
        foreach (array("import", "sql", "schema", "dump", "privileges") as $X) {
            if (isset($_GET[$X])) {
                echo "<input type='hidden' name='$X' value=''>";
                break;
            }
        }
        echo "</p></form>\n";
    }

    function
    databases($cd = true)
    {
        return
            get_databases($cd);
    }

    function
    schemas()
    {
        return
            schemas();
    }

    function
    tablesPrint($S)
    {
        echo "<ul id='tables'>" . script("mixin(qs('#tables'), {onmouseover: menuOver, onmouseout: menuOut});");
        foreach ($S
                 as $Q => $O) {
            $D = $this->tableName($O);
            if ($D != "") {
                echo '<li><a href="' . h(ME) . 'select=' . urlencode($Q) . '"' . bold($_GET["select"] == $Q || $_GET["edit"] == $Q, "select") . " title='" . 'Select data' . "'>" . 'select' . "</a> ", (support("table") || support("indexes") ? '<a href="' . h(ME) . 'table=' . urlencode($Q) . '"' . bold(in_array($Q, array($_GET["table"], $_GET["create"], $_GET["indexes"], $_GET["foreign"], $_GET["trigger"])), (is_view($O) ? "view" : "structure")) . " title='" . 'Show structure' . "'>$D</a>" : "<span>$D</span>") . "\n";
            }
        }
        echo "</ul>\n";
    }

    function
    tableName($Mh)
    {
        return
            h($Mh["Name"]);
    }
}

$b = (function_exists('adminer_object') ? adminer_object() : new
Adminer);
$hc = array("server" => "MySQL") + $hc;
if (!defined("DRIVER")) {
    define("DRIVER", "server");
    if (extension_loaded("mysqli")) {
        class
        Min_DB
            extends
            MySQLi
        {
            var $extension = "MySQLi";

            function
            __construct()
            {
                parent::init();
            }

            function
            connect($M = "", $V = "", $F = "", $i = null, $cg = null, $sh = null)
            {
                global $b;
                mysqli_report(MYSQLI_REPORT_OFF);
                list($Bd, $cg) = explode(":", $M, 2);
                $Ah = $b->connectSsl();
                if ($Ah) $this->ssl_set($Ah['key'], $Ah['cert'], $Ah['ca'], '', '');
                $I = @$this->real_connect(($M != "" ? $Bd : ini_get("mysqli.default_host")), ($M . $V != "" ? $V : ini_get("mysqli.default_user")), ($M . $V . $F != "" ? $F : ini_get("mysqli.default_pw")), $i, (is_numeric($cg) ? $cg : ini_get("mysqli.default_port")), (!is_numeric($cg) ? $cg : $sh), ($Ah ? 64 : 0));
                $this->options(MYSQLI_OPT_LOCAL_INFILE, false);
                return $I;
            }

            function
            set_charset($Za)
            {
                if (parent::set_charset($Za)) return
                    true;
                parent::set_charset('utf8');
                return $this->query("SET NAMES $Za");
            }

            function
            result($G, $n = 0)
            {
                $H = $this->query($G);
                if (!$H) return
                    false;
                $J = $H->fetch_array();
                return $J[$n];
            }

            function
            quote($P)
            {
                return "'" . $this->escape_string($P) . "'";
            }
        }
    } elseif (extension_loaded("mysql") && !((ini_bool("sql.safe_mode") || ini_bool("mysql.allow_local_infile")) && extension_loaded("pdo_mysql"))) {
        class
        Min_DB
        {
            var $extension = "MySQL", $server_info, $affected_rows, $errno, $error, $_link, $_result;

            function
            connect($M, $V, $F)
            {
                if (ini_bool("mysql.allow_local_infile")) {
                    $this->error = sprintf('Disable %s or enable %s or %s extensions.', "'mysql.allow_local_infile'", "MySQLi", "PDO_MySQL");
                    return
                        false;
                }
                $this->_link = @mysql_connect(($M != "" ? $M : ini_get("mysql.default_host")), ("$M$V" != "" ? $V : ini_get("mysql.default_user")), ("$M$V$F" != "" ? $F : ini_get("mysql.default_password")), true, 131072);
                if ($this->_link) $this->server_info = mysql_get_server_info($this->_link); else$this->error = mysql_error();
                return (bool)$this->_link;
            }

            function
            set_charset($Za)
            {
                if (function_exists('mysql_set_charset')) {
                    if (mysql_set_charset($Za, $this->_link)) return
                        true;
                    mysql_set_charset('utf8', $this->_link);
                }
                return $this->query("SET NAMES $Za");
            }

            function
            quote($P)
            {
                return "'" . mysql_real_escape_string($P, $this->_link) . "'";
            }

            function
            select_db($i)
            {
                return
                    mysql_select_db($i, $this->_link);
            }

            function
            query($G, $Ai = false)
            {
                $H = @($Ai ? mysql_unbuffered_query($G, $this->_link) : mysql_query($G, $this->_link));
                $this->error = "";
                if (!$H) {
                    $this->errno = mysql_errno($this->_link);
                    $this->error = mysql_error($this->_link);
                    return
                        false;
                }
                if ($H === true) {
                    $this->affected_rows = mysql_affected_rows($this->_link);
                    $this->info = mysql_info($this->_link);
                    return
                        true;
                }
                return
                    new
                    Min_Result($H);
            }

            function
            multi_query($G)
            {
                return $this->_result = $this->query($G);
            }

            function
            store_result()
            {
                return $this->_result;
            }

            function
            next_result()
            {
                return
                    false;
            }

            function
            result($G, $n = 0)
            {
                $H = $this->query($G);
                if (!$H || !$H->num_rows) return
                    false;
                return
                    mysql_result($H->_result, 0, $n);
            }
        }

        class
        Min_Result
        {
            var $num_rows, $_result, $_offset = 0;

            function
            __construct($H)
            {
                $this->_result = $H;
                $this->num_rows = mysql_num_rows($H);
            }

            function
            fetch_assoc()
            {
                return
                    mysql_fetch_assoc($this->_result);
            }

            function
            fetch_row()
            {
                return
                    mysql_fetch_row($this->_result);
            }

            function
            fetch_field()
            {
                $I = mysql_fetch_field($this->_result, $this->_offset++);
                $I->orgtable = $I->table;
                $I->orgname = $I->name;
                $I->charsetnr = ($I->blob ? 63 : 0);
                return $I;
            }

            function
            __destruct()
            {
                mysql_free_result($this->_result);
            }
        }
    } elseif (extension_loaded("pdo_mysql")) {
        class
        Min_DB
            extends
            Min_PDO
        {
            var $extension = "PDO_MySQL";

            function
            connect($M, $V, $F)
            {
                global $b;
                $wf = array(PDO::MYSQL_ATTR_LOCAL_INFILE => false);
                $Ah = $b->connectSsl();
                if ($Ah) {
                    if (!empty($Ah['key'])) $wf[PDO::MYSQL_ATTR_SSL_KEY] = $Ah['key'];
                    if (!empty($Ah['cert'])) $wf[PDO::MYSQL_ATTR_SSL_CERT] = $Ah['cert'];
                    if (!empty($Ah['ca'])) $wf[PDO::MYSQL_ATTR_SSL_CA] = $Ah['ca'];
                }
                $this->dsn("mysql:charset=utf8;host=" . str_replace(":", ";unix_socket=", preg_replace('~:(\d)~', ';port=\1', $M)), $V, $F, $wf);
                return
                    true;
            }

            function
            set_charset($Za)
            {
                $this->query("SET NAMES $Za");
            }

            function
            select_db($i)
            {
                return $this->query("USE " . idf_escape($i));
            }

            function
            query($G, $Ai = false)
            {
                $this->pdo->setAttribute(1000, !$Ai);
                return
                    parent::query($G, $Ai);
            }
        }
    }

    class
    Min_Driver
        extends
        Min_SQL
    {
        function
        insert($Q, $N)
        {
            return ($N ? parent::insert($Q, $N) : queries("INSERT INTO " . table($Q) . " ()\nVALUES ()"));
        }

        function
        insertUpdate($Q, $K, $jg)
        {
            $e = array_keys(reset($K));
            $hg = "INSERT INTO " . table($Q) . " (" . implode(", ", $e) . ") VALUES\n";
            $Si = array();
            foreach ($e
                     as $z) $Si[$z] = "$z = VALUES($z)";
            $Ih = "\nON DUPLICATE KEY UPDATE " . implode(", ", $Si);
            $Si = array();
            $se = 0;
            foreach ($K
                     as $N) {
                $Y = "(" . implode(", ", $N) . ")";
                if ($Si && (strlen($hg) + $se + strlen($Y) + strlen($Ih) > 1e6)) {
                    if (!queries($hg . implode(",\n", $Si) . $Ih)) return
                        false;
                    $Si = array();
                    $se = 0;
                }
                $Si[] = $Y;
                $se += strlen($Y) + 2;
            }
            return
                queries($hg . implode(",\n", $Si) . $Ih);
        }

        function
        slowQuery($G, $di)
        {
            if (min_version('5.7.8', '10.1.2')) {
                if (preg_match('~MariaDB~', $this->_conn->server_info)) return "SET STATEMENT max_statement_time=$di FOR $G"; elseif (preg_match('~^(SELECT\b)(.+)~is', $G, $C)) return "$C[1] /*+ MAX_EXECUTION_TIME(" . ($di * 1000) . ") */ $C[2]";
            }
        }

        function
        convertSearch($v, $X, $n)
        {
            return (preg_match('~char|text|enum|set~', $n["type"]) && !preg_match("~^utf8~", $n["collation"]) && preg_match('~[\x80-\xFF]~', $X['val']) ? "CONVERT($v USING " . charset($this->_conn) . ")" : $v);
        }

        function
        warnings()
        {
            $H = $this->_conn->query("SHOW WARNINGS");
            if ($H && $H->num_rows) {
                ob_start();
                select($H);
                return
                    ob_get_clean();
            }
        }

        function
        tableHelp($D)
        {
            $ze = preg_match('~MariaDB~', $this->_conn->server_info);
            if (information_schema(DB)) return
                strtolower(($ze ? "information-schema-$D-table/" : str_replace("_", "-", $D) . "-table.html"));
            if (DB == "mysql") return ($ze ? "mysql$D-table/" : "system-database.html");
        }
    }

    function
    idf_escape($v)
    {
        return "`" . str_replace("`", "``", $v) . "`";
    }

    function
    table($v)
    {
        return
            idf_escape($v);
    }

    function
    connect()
    {
        global $b, $U, $Fh;
        $f = new
        Min_DB;
        $Kb = $b->credentials();
        if ($f->connect($Kb[0], $Kb[1], $Kb[2])) {
            $f->set_charset(charset($f));
            $f->query("SET sql_quote_show_create = 1, autocommit = 1");
            if (min_version('5.7.8', 10.2, $f)) {
                $Fh['Strings'][] = "json";
                $U["json"] = 4294967295;
            }
            return $f;
        }
        $I = $f->error;
        if (function_exists('iconv') && !is_utf8($I) && strlen($Wg = iconv("windows-1250", "utf-8", $I)) > strlen($I)) $I = $Wg;
        return $I;
    }

    function
    get_databases($cd)
    {
        $I = get_session("dbs");
        if ($I === null) {
            $G = (min_version(5) ? "SELECT SCHEMA_NAME FROM information_schema.SCHEMATA ORDER BY SCHEMA_NAME" : "SHOW DATABASES");
            $I = ($cd ? slow_query($G) : get_vals($G));
            restart_session();
            set_session("dbs", $I);
            stop_session();
        }
        return $I;
    }

    function
    limit($G, $Z, $_, $gf = 0, $gh = " ")
    {
        return " $G$Z" . ($_ !== null ? $gh . "LIMIT $_" . ($gf ? " OFFSET $gf" : "") : "");
    }

    function
    limit1($Q, $G, $Z, $gh = "\n")
    {
        return
            limit($G, $Z, 1, 0, $gh);
    }

    function
    db_collation($k, $mb)
    {
        global $f;
        $I = null;
        $h = $f->result("SHOW CREATE DATABASE " . idf_escape($k), 1);
        if (preg_match('~ COLLATE ([^ ]+)~', $h, $C)) $I = $C[1]; elseif (preg_match('~ CHARACTER SET ([^ ]+)~', $h, $C)) $I = $mb[$C[1]][-1];
        return $I;
    }

    function
    engines()
    {
        $I = array();
        foreach (get_rows("SHOW ENGINES") as $J) {
            if (preg_match("~YES|DEFAULT~", $J["Support"])) $I[] = $J["Engine"];
        }
        return $I;
    }

    function
    logged_user()
    {
        global $f;
        return $f->result("SELECT USER()");
    }

    function
    tables_list()
    {
        return
            get_key_vals(min_version(5) ? "SELECT TABLE_NAME, TABLE_TYPE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME" : "SHOW TABLES");
    }

    function
    count_tables($j)
    {
        $I = array();
        foreach ($j
                 as $k) $I[$k] = count(get_vals("SHOW TABLES IN " . idf_escape($k)));
        return $I;
    }

    function
    table_status($D = "", $Rc = false)
    {
        $I = array();
        foreach (get_rows($Rc && min_version(5) ? "SELECT TABLE_NAME AS Name, ENGINE AS Engine, TABLE_COMMENT AS Comment FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() " . ($D != "" ? "AND TABLE_NAME = " . q($D) : "ORDER BY Name") : "SHOW TABLE STATUS" . ($D != "" ? " LIKE " . q(addcslashes($D, "%_\\")) : "")) as $J) {
            if ($J["Engine"] == "InnoDB") $J["Comment"] = preg_replace('~(?:(.+); )?InnoDB free: .*~', '\1', $J["Comment"]);
            if (!isset($J["Engine"])) $J["Comment"] = "";
            if ($D != "") return $J;
            $I[$J["Name"]] = $J;
        }
        return $I;
    }

    function
    is_view($R)
    {
        return $R["Engine"] === null;
    }

    function
    fk_support($R)
    {
        return
            preg_match('~InnoDB|IBMDB2I~i', $R["Engine"]) || (preg_match('~NDB~i', $R["Engine"]) && min_version(5.6));
    }

    function
    fields($Q)
    {
        $I = array();
        foreach (get_rows("SHOW FULL COLUMNS FROM " . table($Q)) as $J) {
            preg_match('~^([^( ]+)(?:\((.+)\))?( unsigned)?( zerofill)?$~', $J["Type"], $C);
            $I[$J["Field"]] = array("field" => $J["Field"], "full_type" => $J["Type"], "type" => $C[1], "length" => $C[2], "unsigned" => ltrim($C[3] . $C[4]), "default" => ($J["Default"] != "" || preg_match("~char|set~", $C[1]) ? (preg_match('~text~', $C[1]) ? stripslashes(preg_replace("~^'(.*)'\$~", '\1', $J["Default"])) : $J["Default"]) : null), "null" => ($J["Null"] == "YES"), "auto_increment" => ($J["Extra"] == "auto_increment"), "on_update" => (preg_match('~^on update (.+)~i', $J["Extra"], $C) ? $C[1] : ""), "collation" => $J["Collation"], "privileges" => array_flip(preg_split('~, *~', $J["Privileges"])), "comment" => $J["Comment"], "primary" => ($J["Key"] == "PRI"), "generated" => preg_match('~^(VIRTUAL|PERSISTENT|STORED)~', $J["Extra"]),);
        }
        return $I;
    }

    function
    indexes($Q, $g = null)
    {
        $I = array();
        foreach (get_rows("SHOW INDEX FROM " . table($Q), $g) as $J) {
            $D = $J["Key_name"];
            $I[$D]["type"] = ($D == "PRIMARY" ? "PRIMARY" : ($J["Index_type"] == "FULLTEXT" ? "FULLTEXT" : ($J["Non_unique"] ? ($J["Index_type"] == "SPATIAL" ? "SPATIAL" : "INDEX") : "UNIQUE")));
            $I[$D]["columns"][] = $J["Column_name"];
            $I[$D]["lengths"][] = ($J["Index_type"] == "SPATIAL" ? null : $J["Sub_part"]);
            $I[$D]["descs"][] = null;
        }
        return $I;
    }

    function
    foreign_keys($Q)
    {
        global $f, $of;
        static $Yf = '(?:`(?:[^`]|``)+`|"(?:[^"]|"")+")';
        $I = array();
        $Ib = $f->result("SHOW CREATE TABLE " . table($Q), 1);
        if ($Ib) {
            preg_match_all("~CONSTRAINT ($Yf) FOREIGN KEY ?\\(((?:$Yf,? ?)+)\\) REFERENCES ($Yf)(?:\\.($Yf))? \\(((?:$Yf,? ?)+)\\)(?: ON DELETE ($of))?(?: ON UPDATE ($of))?~", $Ib, $Be, PREG_SET_ORDER);
            foreach ($Be
                     as $C) {
                preg_match_all("~$Yf~", $C[2], $uh);
                preg_match_all("~$Yf~", $C[5], $Vh);
                $I[idf_unescape($C[1])] = array("db" => idf_unescape($C[4] != "" ? $C[3] : $C[4]), "table" => idf_unescape($C[4] != "" ? $C[4] : $C[3]), "source" => array_map('idf_unescape', $uh[0]), "target" => array_map('idf_unescape', $Vh[0]), "on_delete" => ($C[6] ? $C[6] : "RESTRICT"), "on_update" => ($C[7] ? $C[7] : "RESTRICT"),);
            }
        }
        return $I;
    }

    function
    view($D)
    {
        global $f;
        return
            array("select" => preg_replace('~^(?:[^`]|`[^`]*`)*\s+AS\s+~isU', '', $f->result("SHOW CREATE VIEW " . table($D), 1)));
    }

    function
    collations()
    {
        $I = array();
        foreach (get_rows("SHOW COLLATION") as $J) {
            if ($J["Default"]) $I[$J["Charset"]][-1] = $J["Collation"]; else$I[$J["Charset"]][] = $J["Collation"];
        }
        ksort($I);
        foreach ($I
                 as $z => $X) asort($I[$z]);
        return $I;
    }

    function
    information_schema($k)
    {
        return (min_version(5) && $k == "information_schema") || (min_version(5.5) && $k == "performance_schema");
    }

    function
    error()
    {
        global $f;
        return
            h(preg_replace('~^You have an error.*syntax to use~U', "Syntax error", $f->error));
    }

    function
    create_database($k, $lb)
    {
        return
            queries("CREATE DATABASE " . idf_escape($k) . ($lb ? " COLLATE " . q($lb) : ""));
    }

    function
    drop_databases($j)
    {
        $I = apply_queries("DROP DATABASE", $j, 'idf_escape');
        restart_session();
        set_session("dbs", null);
        return $I;
    }

    function
    rename_database($D, $lb)
    {
        $I = false;
        if (create_database($D, $lb)) {
            $Ig = array();
            foreach (tables_list() as $Q => $T) $Ig[] = table($Q) . " TO " . idf_escape($D) . "." . table($Q);
            $I = (!$Ig || queries("RENAME TABLE " . implode(", ", $Ig)));
            if ($I) queries("DROP DATABASE " . idf_escape(DB));
            restart_session();
            set_session("dbs", null);
        }
        return $I;
    }

    function
    auto_increment()
    {
        $La = " PRIMARY KEY";
        if ($_GET["create"] != "" && $_POST["auto_increment_col"]) {
            foreach (indexes($_GET["create"]) as $w) {
                if (in_array($_POST["fields"][$_POST["auto_increment_col"]]["orig"], $w["columns"], true)) {
                    $La = "";
                    break;
                }
                if ($w["type"] == "PRIMARY") $La = " UNIQUE";
            }
        }
        return " AUTO_INCREMENT$La";
    }

    function
    alter_table($Q, $D, $o, $ed, $rb, $xc, $lb, $Ka, $Sf)
    {
        $c = array();
        foreach ($o
                 as $n) $c[] = ($n[1] ? ($Q != "" ? ($n[0] != "" ? "CHANGE " . idf_escape($n[0]) : "ADD") : " ") . " " . implode($n[1]) . ($Q != "" ? $n[2] : "") : "DROP " . idf_escape($n[0]));
        $c = array_merge($c, $ed);
        $O = ($rb !== null ? " COMMENT=" . q($rb) : "") . ($xc ? " ENGINE=" . q($xc) : "") . ($lb ? " COLLATE " . q($lb) : "") . ($Ka != "" ? " AUTO_INCREMENT=$Ka" : "");
        if ($Q == "") return
            queries("CREATE TABLE " . table($D) . " (\n" . implode(",\n", $c) . "\n)$O$Sf");
        if ($Q != $D) $c[] = "RENAME TO " . table($D);
        if ($O) $c[] = ltrim($O);
        return ($c || $Sf ? queries("ALTER TABLE " . table($Q) . "\n" . implode(",\n", $c) . $Sf) : true);
    }

    function
    alter_indexes($Q, $c)
    {
        foreach ($c
                 as $z => $X) $c[$z] = ($X[2] == "DROP" ? "\nDROP INDEX " . idf_escape($X[1]) : "\nADD $X[0] " . ($X[0] == "PRIMARY" ? "KEY " : "") . ($X[1] != "" ? idf_escape($X[1]) . " " : "") . "(" . implode(", ", $X[2]) . ")");
        return
            queries("ALTER TABLE " . table($Q) . implode(",", $c));
    }

    function
    truncate_tables($S)
    {
        return
            apply_queries("TRUNCATE TABLE", $S);
    }

    function
    drop_views($Xi)
    {
        return
            queries("DROP VIEW " . implode(", ", array_map('table', $Xi)));
    }

    function
    drop_tables($S)
    {
        return
            queries("DROP TABLE " . implode(", ", array_map('table', $S)));
    }

    function
    move_tables($S, $Xi, $Vh)
    {
        $Ig = array();
        foreach (array_merge($S, $Xi) as $Q) $Ig[] = table($Q) . " TO " . idf_escape($Vh) . "." . table($Q);
        return
            queries("RENAME TABLE " . implode(", ", $Ig));
    }

    function
    copy_tables($S, $Xi, $Vh)
    {
        queries("SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");
        foreach ($S
                 as $Q) {
            $D = ($Vh == DB ? table("copy_$Q") : idf_escape($Vh) . "." . table($Q));
            if (($_POST["overwrite"] && !queries("\nDROP TABLE IF EXISTS $D")) || !queries("CREATE TABLE $D LIKE " . table($Q)) || !queries("INSERT INTO $D SELECT * FROM " . table($Q))) return
                false;
            foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($Q, "%_\\"))) as $J) {
                $vi = $J["Trigger"];
                if (!queries("CREATE TRIGGER " . ($Vh == DB ? idf_escape("copy_$vi") : idf_escape($Vh) . "." . idf_escape($vi)) . " $J[Timing] $J[Event] ON $D FOR EACH ROW\n$J[Statement];")) return
                    false;
            }
        }
        foreach ($Xi
                 as $Q) {
            $D = ($Vh == DB ? table("copy_$Q") : idf_escape($Vh) . "." . table($Q));
            $Wi = view($Q);
            if (($_POST["overwrite"] && !queries("DROP VIEW IF EXISTS $D")) || !queries("CREATE VIEW $D AS $Wi[select]")) return
                false;
        }
        return
            true;
    }

    function
    trigger($D)
    {
        if ($D == "") return
            array();
        $K = get_rows("SHOW TRIGGERS WHERE `Trigger` = " . q($D));
        return
            reset($K);
    }

    function
    triggers($Q)
    {
        $I = array();
        foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($Q, "%_\\"))) as $J) $I[$J["Trigger"]] = array($J["Timing"], $J["Event"]);
        return $I;
    }

    function
    trigger_options()
    {
        return
            array("Timing" => array("BEFORE", "AFTER"), "Event" => array("INSERT", "UPDATE", "DELETE"), "Type" => array("FOR EACH ROW"),);
    }

    function
    routine($D, $T)
    {
        global $f, $zc, $Sd, $U;
        $Ba = array("bool", "boolean", "integer", "double precision", "real", "dec", "numeric", "fixed", "national char", "national varchar");
        $vh = "(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";
        $_i = "((" . implode("|", array_merge(array_keys($U), $Ba)) . ")\\b(?:\\s*\\(((?:[^'\")]|$zc)++)\\))?\\s*(zerofill\\s*)?(unsigned(?:\\s+zerofill)?)?)(?:\\s*(?:CHARSET|CHARACTER\\s+SET)\\s*['\"]?([^'\"\\s,]+)['\"]?)?";
        $Yf = "$vh*(" . ($T == "FUNCTION" ? "" : $Sd) . ")?\\s*(?:`((?:[^`]|``)*)`\\s*|\\b(\\S+)\\s+)$_i";
        $h = $f->result("SHOW CREATE $T " . idf_escape($D), 2);
        preg_match("~\\(((?:$Yf\\s*,?)*)\\)\\s*" . ($T == "FUNCTION" ? "RETURNS\\s+$_i\\s+" : "") . "(.*)~is", $h, $C);
        $o = array();
        preg_match_all("~$Yf\\s*,?~is", $C[1], $Be, PREG_SET_ORDER);
        foreach ($Be
                 as $Mf) $o[] = array("field" => str_replace("``", "`", $Mf[2]) . $Mf[3], "type" => strtolower($Mf[5]), "length" => preg_replace_callback("~$zc~s", 'normalize_enum', $Mf[6]), "unsigned" => strtolower(preg_replace('~\s+~', ' ', trim("$Mf[8] $Mf[7]"))), "null" => 1, "full_type" => $Mf[4], "inout" => strtoupper($Mf[1]), "collation" => strtolower($Mf[9]),);
        if ($T != "FUNCTION") return
            array("fields" => $o, "definition" => $C[11]);
        return
            array("fields" => $o, "returns" => array("type" => $C[12], "length" => $C[13], "unsigned" => $C[15], "collation" => $C[16]), "definition" => $C[17], "language" => "SQL",);
    }

    function
    routines()
    {
        return
            get_rows("SELECT ROUTINE_NAME AS SPECIFIC_NAME, ROUTINE_NAME, ROUTINE_TYPE, DTD_IDENTIFIER FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = " . q(DB));
    }

    function
    routine_languages()
    {
        return
            array();
    }

    function
    routine_id($D, $J)
    {
        return
            idf_escape($D);
    }

    function
    last_id()
    {
        global $f;
        return $f->result("SELECT LAST_INSERT_ID()");
    }

    function
    explain($f, $G)
    {
        return $f->query("EXPLAIN " . (min_version(5.1) && !min_version(5.7) ? "PARTITIONS " : "") . $G);
    }

    function
    found_rows($R, $Z)
    {
        return ($Z || $R["Engine"] != "InnoDB" ? null : $R["Rows"]);
    }

    function
    types()
    {
        return
            array();
    }

    function
    schemas()
    {
        return
            array();
    }

    function
    get_schema()
    {
        return "";
    }

    function
    set_schema($Yg, $g = null)
    {
        return
            true;
    }

    function
    create_sql($Q, $Ka, $Gh)
    {
        global $f;
        $I = $f->result("SHOW CREATE TABLE " . table($Q), 1);
        if (!$Ka) $I = preg_replace('~ AUTO_INCREMENT=\d+~', '', $I);
        return $I;
    }

    function
    truncate_sql($Q)
    {
        return "TRUNCATE " . table($Q);
    }

    function
    use_sql($i)
    {
        return "USE " . idf_escape($i);
    }

    function
    trigger_sql($Q)
    {
        $I = "";
        foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($Q, "%_\\")), null, "-- ") as $J) $I .= "\nCREATE TRIGGER " . idf_escape($J["Trigger"]) . " $J[Timing] $J[Event] ON " . table($J["Table"]) . " FOR EACH ROW\n$J[Statement];;\n";
        return $I;
    }

    function
    show_variables()
    {
        return
            get_key_vals("SHOW VARIABLES");
    }

    function
    process_list()
    {
        return
            get_rows("SHOW FULL PROCESSLIST");
    }

    function
    show_status()
    {
        return
            get_key_vals("SHOW STATUS");
    }

    function
    convert_field($n)
    {
        if (preg_match("~binary~", $n["type"])) return "HEX(" . idf_escape($n["field"]) . ")";
        if ($n["type"] == "bit") return "BIN(" . idf_escape($n["field"]) . " + 0)";
        if (preg_match("~geometry|point|linestring|polygon~", $n["type"])) return (min_version(8) ? "ST_" : "") . "AsWKT(" . idf_escape($n["field"]) . ")";
    }

    function
    unconvert_field($n, $I)
    {
        if (preg_match("~binary~", $n["type"])) $I = "UNHEX($I)";
        if ($n["type"] == "bit") $I = "CONV($I, 2, 10) + 0";
        if (preg_match("~geometry|point|linestring|polygon~", $n["type"])) $I = (min_version(8) ? "ST_" : "") . "GeomFromText($I, SRID($n[field]))";
        return $I;
    }

    function
    support($Sc)
    {
        return !preg_match("~scheme|sequence|type|view_trigger|materializedview" . (min_version(8) ? "" : "|descidx" . (min_version(5.1) ? "" : "|event|partitioning" . (min_version(5) ? "" : "|routine|trigger|view"))) . "~", $Sc);
    }

    function
    kill_process($X)
    {
        return
            queries("KILL " . number($X));
    }

    function
    connection_id()
    {
        return "SELECT CONNECTION_ID()";
    }

    function
    max_connections()
    {
        global $f;
        return $f->result("SELECT @@max_connections");
    }

    function
    driver_config()
    {
        $U = array();
        $Fh = array();
        foreach (array('Numbers' => array("tinyint" => 3, "smallint" => 5, "mediumint" => 8, "int" => 10, "bigint" => 20, "decimal" => 66, "float" => 12, "double" => 21), 'Date and time' => array("date" => 10, "datetime" => 19, "timestamp" => 19, "time" => 10, "year" => 4), 'Strings' => array("char" => 255, "varchar" => 65535, "tinytext" => 255, "text" => 65535, "mediumtext" => 16777215, "longtext" => 4294967295), 'Lists' => array("enum" => 65535, "set" => 64), 'Binary' => array("bit" => 20, "binary" => 255, "varbinary" => 65535, "tinyblob" => 255, "blob" => 65535, "mediumblob" => 16777215, "longblob" => 4294967295), 'Geometry' => array("geometry" => 0, "point" => 0, "linestring" => 0, "polygon" => 0, "multipoint" => 0, "multilinestring" => 0, "multipolygon" => 0, "geometrycollection" => 0),) as $z => $X) {
            $U += $X;
            $Fh[$z] = array_keys($X);
        }
        return
            array('possible_drivers' => array("MySQLi", "MySQL", "PDO_MySQL"), 'jush' => "sql", 'types' => $U, 'structured_types' => $Fh, 'unsigned' => array("unsigned", "zerofill", "unsigned zerofill"), 'operators' => array("=", "<", ">", "<=", ">=", "!=", "LIKE", "LIKE %%", "REGEXP", "IN", "FIND_IN_SET", "IS NULL", "NOT LIKE", "NOT REGEXP", "NOT IN", "IS NOT NULL", "SQL"), 'functions' => array("char_length", "date", "from_unixtime", "lower", "round", "floor", "ceil", "sec_to_time", "time_to_sec", "upper"), 'grouping' => array("avg", "count", "count distinct", "group_concat", "max", "min", "sum"), 'edit_functions' => array(array("char" => "md5/sha1/password/encrypt/uuid", "binary" => "md5/sha1", "date|time" => "now",), array(number_type() => "+/-", "date" => "+ interval/- interval", "time" => "addtime/subtime", "char|text" => "concat",)),);
    }
}
$vb = driver_config();
$gg = $vb['possible_drivers'];
$y = $vb['jush'];
$U = $vb['types'];
$Fh = $vb['structured_types'];
$Gi = $vb['unsigned'];
$tf = $vb['operators'];
$ld = $vb['functions'];
$rd = $vb['grouping'];
$pc = $vb['edit_functions'];
if ($b->operators === null) $b->operators = $tf;
define("SERVER", $_GET[DRIVER]);
define("DB", $_GET["db"]);
define("ME", preg_replace('~\?.*~', '', relative_uri()) . '?' . (sid() ? SID . '&' : '') . (SERVER !== null ? DRIVER . "=" . urlencode(SERVER) . '&' : '') . (isset($_GET["username"]) ? "username=" . urlencode($_GET["username"]) . '&' : '') . (DB != "" ? 'db=' . urlencode(DB) . '&' . (isset($_GET["ns"]) ? "ns=" . urlencode($_GET["ns"]) . "&" : "") : ''));
$ia = "4.8.0";
function
page_header($fi, $m = "", $Ua = array(), $gi = "")
{
    global $ca, $ia, $b, $hc, $y;
    page_headers();
    if (is_ajax() && $m) {
        page_messages($m);
        exit;
    }
    $hi = $fi . ($gi != "" ? ": $gi" : "");
    $ii = strip_tags($hi . (SERVER != "" && SERVER != "localhost" ? h(" - " . SERVER) : "") . " - " . $b->name());
    echo '<!DOCTYPE html>
<html lang="en" dir="ltr">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex">
<title>', $ii, '</title>
<link rel="stylesheet" type="text/css" href="', h(preg_replace("~\\?.*~", "", ME) . "?file=default.css&version=4.8.0"), '">
', script_src(preg_replace("~\\?.*~", "", ME) . "?file=functions.js&version=4.8.0");
    if ($b->head()) {
        echo '<link rel="shortcut icon" type="image/x-icon" href="', h(preg_replace("~\\?.*~", "", ME) . "?file=favicon.ico&version=4.8.0"), '">
<link rel="apple-touch-icon" href="', h(preg_replace("~\\?.*~", "", ME) . "?file=favicon.ico&version=4.8.0"), '">
';
        foreach ($b->css() as $Mb) {
            echo '<link rel="stylesheet" type="text/css" href="', h($Mb), '">
';
        }
    }
    echo '
<body class="ltr nojs">
';
    $p = get_temp_dir() . "/adminer.version";
    if (!$_COOKIE["adminer_version"] && function_exists('openssl_verify') && file_exists($p) && filemtime($p) + 86400 > time()) {
        $Vi = unserialize(file_get_contents($p));
        $sg = "-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwqWOVuF5uw7/+Z70djoK
RlHIZFZPO0uYRezq90+7Amk+FDNd7KkL5eDve+vHRJBLAszF/7XKXe11xwliIsFs
DFWQlsABVZB3oisKCBEuI71J4kPH8dKGEWR9jDHFw3cWmoH3PmqImX6FISWbG3B8
h7FIx3jEaw5ckVPVTeo5JRm/1DZzJxjyDenXvBQ/6o9DgZKeNDgxwKzH+sw9/YCO
jHnq1cFpOIISzARlrHMa/43YfeNRAm/tsBXjSxembBPo7aQZLAWHmaj5+K19H10B
nCpz9Y++cipkVEiKRGih4ZEvjoFysEOdRLj6WiD/uUNky4xGeA6LaJqh5XpkFkcQ
fQIDAQAB
-----END PUBLIC KEY-----
";
        if (openssl_verify($Vi["version"], base64_decode($Vi["signature"]), $sg) == 1) $_COOKIE["adminer_version"] = $Vi["version"];
    }
    echo '<script', nonce(), '>
mixin(document.body, {onkeydown: bodyKeydown, onclick: bodyClick', (isset($_COOKIE["adminer_version"]) ? "" : ", onload: partial(verifyVersion, '$ia', '" . js_escape(ME) . "', '" . get_token() . "')"); ?>});
    document.body.className = document.body.className.replace(/ nojs/, ' js');
    var offlineMessage = '<?php echo
js_escape('You are offline.'), '\';
var thousandsSeparator = \'', js_escape(','), '\';
</script>

<div id="help" class="jush-', $y, ' jsonly hidden"></div>
', script("mixin(qs('#help'), {onmouseover: function () { helpOpen = 1; }, onmouseout: helpMouseout});"), '
<div id="content">
';
    if ($Ua !== null) {
        $A = substr(preg_replace('~\b(username|db|ns)=[^&]*&~', '', ME), 0, -1);
        echo '<p id="breadcrumb"><a href="' . h($A ? $A : ".") . '">' . $hc[DRIVER] . '</a> &raquo; ';
        $A = substr(preg_replace('~\b(db|ns)=[^&]*&~', '', ME), 0, -1);
        $M = $b->serverName(SERVER);
        $M = ($M != "" ? $M : 'Server');
        if ($Ua === false) echo "$M\n"; else {
            echo "<a href='" . h($A) . "' accesskey='1' title='Alt+Shift+1'>$M</a> &raquo; ";
            if ($_GET["ns"] != "" || (DB != "" && is_array($Ua))) echo '<a href="' . h($A . "&db=" . urlencode(DB) . (support("scheme") ? "&ns=" : "")) . '">' . h(DB) . '</a> &raquo; ';
            if (is_array($Ua)) {
                if ($_GET["ns"] != "") echo '<a href="' . h(substr(ME, 0, -1)) . '">' . h($_GET["ns"]) . '</a> &raquo; ';
                foreach ($Ua
                         as $z => $X) {
                    $ac = (is_array($X) ? $X[1] : h($X));
                    if ($ac != "") echo "<a href='" . h(ME . "$z=") . urlencode(is_array($X) ? $X[0] : $X) . "'>$ac</a> &raquo; ";
                }
            }
            echo "$fi\n";
        }
    }
    echo "<h2>$hi</h2>\n", "<div id='ajaxstatus' class='jsonly hidden'></div>\n";
    restart_session();
    page_messages($m);
    $j =& get_session("dbs");
    if (DB != "" && $j && !in_array(DB, $j, true)) $j = null;
    stop_session();
    define("PAGE_HEADER", 1);
}

function
page_headers()
{
    global $b;
    header("Content-Type: text/html; charset=utf-8");
    header("Cache-Control: no-cache");
    header("X-Frame-Options: deny");
    header("X-XSS-Protection: 0");
    header("X-Content-Type-Options: nosniff");
    header("Referrer-Policy: origin-when-cross-origin");
    foreach ($b->csp() as $Lb) {
        $xd = array();
        foreach ($Lb
                 as $z => $X) $xd[] = "$z $X";
        header("Content-Security-Policy: " . implode("; ", $xd));
    }
    $b->headers();
}

function
csp()
{
    return
        array(array("script-src" => "'self' 'unsafe-inline' 'nonce-" . get_nonce() . "' 'strict-dynamic'", "connect-src" => "'self'", "frame-src" => "https://www.adminer.org", "object-src" => "'none'", "base-uri" => "'none'", "form-action" => "'self'",),);
}

function
get_nonce()
{
    static $af;
    if (!$af) $af = base64_encode(rand_string());
    return $af;
}

function
page_messages($m)
{
    $Ii = preg_replace('~^[^?]*~', '', $_SERVER["REQUEST_URI"]);
    $Ne = $_SESSION["messages"][$Ii];
    if ($Ne) {
        echo "<div class='message'>" . implode("</div>\n<div class='message'>", $Ne) . "</div>" . script("messagesPrint();");
        unset($_SESSION["messages"][$Ii]);
    }
    if ($m) echo "<div class='error'>$m</div>\n";
}

function
page_footer($Qe = "")
{
    global $b, $mi;
    echo '</div>

';
    if ($Qe != "auth") {
        echo '<form action="" method="post">
<p class="logout">
<input type="submit" name="logout" value="Logout" id="logout">
<input type="hidden" name="token" value="', $mi, '">
</p>
</form>
';
    }
    echo '<div id="menu">
';
    $b->navigation($Qe);
    echo '</div>
', script("setupSubmitHighlight(document);");
}

function
int32($Te)
{
    while ($Te >= 2147483648) $Te -= 4294967296;
    while ($Te <= -2147483649) $Te += 4294967296;
    return (int)$Te;
}

function
long2str($W, $Zi)
{
    $Wg = '';
    foreach ($W
             as $X) $Wg .= pack('V', $X);
    if ($Zi) return
        substr($Wg, 0, end($W));
    return $Wg;
}

function
str2long($Wg, $Zi)
{
    $W = array_values(unpack('V*', str_pad($Wg, 4 * ceil(strlen($Wg) / 4), "\0")));
    if ($Zi) $W[] = strlen($Wg);
    return $W;
}

function
xxtea_mx($lj, $kj, $Jh, $ee)
{
    return
        int32((($lj >> 5 & 0x7FFFFFF) ^ $kj << 2) + (($kj >> 3 & 0x1FFFFFFF) ^ $lj << 4)) ^ int32(($Jh ^ $kj) + ($ee ^ $lj));
}

function
encrypt_string($Eh, $z)
{
    if ($Eh == "") return "";
    $z = array_values(unpack("V*", pack("H*", md5($z))));
    $W = str2long($Eh, true);
    $Te = count($W) - 1;
    $lj = $W[$Te];
    $kj = $W[0];
    $tg = floor(6 + 52 / ($Te + 1));
    $Jh = 0;
    while ($tg-- > 0) {
        $Jh = int32($Jh + 0x9E3779B9);
        $oc = $Jh >> 2 & 3;
        for ($Kf = 0; $Kf < $Te; $Kf++) {
            $kj = $W[$Kf + 1];
            $Se = xxtea_mx($lj, $kj, $Jh, $z[$Kf & 3 ^ $oc]);
            $lj = int32($W[$Kf] + $Se);
            $W[$Kf] = $lj;
        }
        $kj = $W[0];
        $Se = xxtea_mx($lj, $kj, $Jh, $z[$Kf & 3 ^ $oc]);
        $lj = int32($W[$Te] + $Se);
        $W[$Te] = $lj;
    }
    return
        long2str($W, false);
}

function
decrypt_string($Eh, $z)
{
    if ($Eh == "") return "";
    if (!$z) return
        false;
    $z = array_values(unpack("V*", pack("H*", md5($z))));
    $W = str2long($Eh, false);
    $Te = count($W) - 1;
    $lj = $W[$Te];
    $kj = $W[0];
    $tg = floor(6 + 52 / ($Te + 1));
    $Jh = int32($tg * 0x9E3779B9);
    while ($Jh) {
        $oc = $Jh >> 2 & 3;
        for ($Kf = $Te; $Kf > 0; $Kf--) {
            $lj = $W[$Kf - 1];
            $Se = xxtea_mx($lj, $kj, $Jh, $z[$Kf & 3 ^ $oc]);
            $kj = int32($W[$Kf] - $Se);
            $W[$Kf] = $kj;
        }
        $lj = $W[$Te];
        $Se = xxtea_mx($lj, $kj, $Jh, $z[$Kf & 3 ^ $oc]);
        $kj = int32($W[0] - $Se);
        $W[0] = $kj;
        $Jh = int32($Jh - 0x9E3779B9);
    }
    return
        long2str($W, true);
}

$f = '';
$wd = $_SESSION["token"];
if (!$wd) $_SESSION["token"] = rand(1, 1e6);
$mi = get_token();
$ag = array();
if ($_COOKIE["adminer_permanent"]) {
    foreach (explode(" ", $_COOKIE["adminer_permanent"]) as $X) {
        list($z) = explode(":", $X);
        $ag[$z] = $X;
    }
}
function
add_invalid_login()
{
    global $b;
    $r = file_open_lock(get_temp_dir() . "/adminer.invalid");
    if (!$r) return;
    $Xd = unserialize(stream_get_contents($r));
    $ci = time();
    if ($Xd) {
        foreach ($Xd
                 as $Yd => $X) {
            if ($X[0] < $ci) unset($Xd[$Yd]);
        }
    }
    $Wd =& $Xd[$b->bruteForceKey()];
    if (!$Wd) $Wd = array($ci + 30 * 60, 0);
    $Wd[1]++;
    file_write_unlock($r, serialize($Xd));
}

function
check_invalid_login()
{
    global $b;
    $Xd = unserialize(@file_get_contents(get_temp_dir() . "/adminer.invalid"));
    $Wd = $Xd[$b->bruteForceKey()];
    $Ze = ($Wd[1] > 29 ? $Wd[0] - time() : 0);
    if ($Ze > 0) auth_error(lang(array('Too many unsuccessful logins, try again in %d minute.', 'Too many unsuccessful logins, try again in %d minutes.'), ceil($Ze / 60)));
}

$Ia = $_POST["auth"];
if ($Ia) {
    session_regenerate_id();
    $Ui = $Ia["driver"];
    $M = $Ia["server"];
    $V = $Ia["username"];
    $F = (string)$Ia["password"];
    $k = $Ia["db"];
    set_password($Ui, $M, $V, $F);
    $_SESSION["db"][$Ui][$M][$V][$k] = true;
    if ($Ia["permanent"]) {
        $z = base64_encode($Ui) . "-" . base64_encode($M) . "-" . base64_encode($V) . "-" . base64_encode($k);
        $mg = $b->permanentLogin(true);
        $ag[$z] = "$z:" . base64_encode($mg ? encrypt_string($F, $mg) : "");
        cookie("adminer_permanent", implode(" ", $ag));
    }
    if (count($_POST) == 1 || DRIVER != $Ui || SERVER != $M || $_GET["username"] !== $V || DB != $k) redirect(auth_url($Ui, $M, $V, $k));
} elseif ($_POST["logout"] && (!$wd || verify_token())) {
    foreach (array("pwds", "db", "dbs", "queries") as $z) set_session($z, null);
    unset_permanent();
    redirect(substr(preg_replace('~\b(username|db|ns)=[^&]*&~', '', ME), 0, -1), 'Logout successful.' . ' ' . 'Thanks for using Adminer, consider <a href="https://www.adminer.org/en/donation/">donating</a>.');
} elseif ($ag && !$_SESSION["pwds"]) {
    session_regenerate_id();
    $mg = $b->permanentLogin();
    foreach ($ag
             as $z => $X) {
        list(, $fb) = explode(":", $X);
        list($Ui, $M, $V, $k) = array_map('base64_decode', explode("-", $z));
        set_password($Ui, $M, $V, decrypt_string(base64_decode($fb), $mg));
        $_SESSION["db"][$Ui][$M][$V][$k] = true;
    }
}
function
unset_permanent()
{
    global $ag;
    foreach ($ag
             as $z => $X) {
        list($Ui, $M, $V, $k) = array_map('base64_decode', explode("-", $z));
        if ($Ui == DRIVER && $M == SERVER && $V == $_GET["username"] && $k == DB) unset($ag[$z]);
    }
    cookie("adminer_permanent", implode(" ", $ag));
}

function
auth_error($m)
{
    global $b, $wd;
    $lh = session_name();
    if (isset($_GET["username"])) {
        header("HTTP/1.1 403 Forbidden");
        if (($_COOKIE[$lh] || $_GET[$lh]) && !$wd) $m = 'Session expired, please login again.'; else {
            restart_session();
            add_invalid_login();
            $F = get_password();
            if ($F !== null) {
                if ($F === false) $m .= ($m ? '<br>' : '') . sprintf('Master password expired. <a href="https://www.adminer.org/en/extension/"%s>Implement</a> %s method to make it permanent.', target_blank(), '<code>permanentLogin()</code>');
                set_password(DRIVER, SERVER, $_GET["username"], null);
            }
            unset_permanent();
        }
    }
    if (!$_COOKIE[$lh] && $_GET[$lh] && ini_bool("session.use_only_cookies")) $m = 'Session support must be enabled.';
    $Nf = session_get_cookie_params();
    cookie("adminer_key", ($_COOKIE["adminer_key"] ? $_COOKIE["adminer_key"] : rand_string()), $Nf["lifetime"]);
    page_header('Login', $m, null);
    echo "<form action='' method='post'>\n", "<div>";
    if (hidden_fields($_POST, array("auth"))) echo "<p class='message'>" . 'The action will be performed after successful login with the same credentials.' . "\n";
    echo "</div>\n";
    $b->loginForm();
    echo "</form>\n";
    page_footer("auth");
    exit;
}

if (isset($_GET["username"]) && !class_exists("Min_DB")) {
    unset($_SESSION["pwds"][DRIVER]);
    unset_permanent();
    page_header('No extension', sprintf('None of the supported PHP extensions (%s) are available.', implode(", ", $gg)), false);
    page_footer("auth");
    exit;
}
stop_session(true);
if (isset($_GET["username"]) && is_string(get_password())) {
    list($Bd, $cg) = explode(":", SERVER, 2);
    if (preg_match('~^\s*([-+]?\d+)~', $cg, $C) && ($C[1] < 1024 || $C[1] > 65535)) auth_error('Connecting to privileged ports is not allowed.');
    check_invalid_login();
    $f = connect();
    $l = new
    Min_Driver($f);
}
$we = null;
if (!is_object($f) || ($we = $b->login($_GET["username"], get_password())) !== true) {
    $m = (is_string($f) ? h($f) : (is_string($we) ? $we : 'Invalid credentials.'));
    auth_error($m . (preg_match('~^ | $~', get_password()) ? '<br>' . 'There is a space in the input password which might be the cause.' : ''));
}
if ($_POST["logout"] && $wd && !verify_token()) {
    page_header('Logout', 'Invalid CSRF token. Send the form again.');
    page_footer("db");
    exit;
}
if ($Ia && $_POST["token"]) $_POST["token"] = $mi;
$m = '';
if ($_POST) {
    if (!verify_token()) {
        $Rd = "max_input_vars";
        $He = ini_get($Rd);
        if (extension_loaded("suhosin")) {
            foreach (array("suhosin.request.max_vars", "suhosin.post.max_vars") as $z) {
                $X = ini_get($z);
                if ($X && (!$He || $X < $He)) {
                    $Rd = $z;
                    $He = $X;
                }
            }
        }
        $m = (!$_POST["token"] && $He ? sprintf('Maximum number of allowed fields exceeded. Please increase %s.', "'$Rd'") : 'Invalid CSRF token. Send the form again.' . ' ' . 'If you did not send this request from Adminer then close this page.');
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $m = sprintf('Too big POST data. Reduce the data or increase the %s configuration directive.', "'post_max_size'");
    if (isset($_GET["sql"])) $m .= ' ' . 'You can upload a big SQL file via FTP and import it from server.';
}
function
select($H, $g = null, $Af = array(), $_ = 0)
{
    global $y;
    $ve = array();
    $x = array();
    $e = array();
    $Sa = array();
    $U = array();
    $I = array();
    odd('');
    for ($t = 0; (!$_ || $t < $_) && ($J = $H->fetch_row()); $t++) {
        if (!$t) {
            echo "<div class='scrollable'>\n", "<table cellspacing='0' class='nowrap'>\n", "<thead><tr>";
            for ($de = 0; $de < count($J); $de++) {
                $n = $H->fetch_field();
                $D = $n->name;
                $_f = $n->orgtable;
                $zf = $n->orgname;
                $I[$n->table] = $_f;
                if ($Af && $y == "sql") $ve[$de] = ($D == "table" ? "table=" : ($D == "possible_keys" ? "indexes=" : null)); elseif ($_f != "") {
                    if (!isset($x[$_f])) {
                        $x[$_f] = array();
                        foreach (indexes($_f, $g) as $w) {
                            if ($w["type"] == "PRIMARY") {
                                $x[$_f] = array_flip($w["columns"]);
                                break;
                            }
                        }
                        $e[$_f] = $x[$_f];
                    }
                    if (isset($e[$_f][$zf])) {
                        unset($e[$_f][$zf]);
                        $x[$_f][$zf] = $de;
                        $ve[$de] = $_f;
                    }
                }
                if ($n->charsetnr == 63) $Sa[$de] = true;
                $U[$de] = $n->type;
                echo "<th" . ($_f != "" || $n->name != $zf ? " title='" . h(($_f != "" ? "$_f." : "") . $zf) . "'" : "") . ">" . h($D) . ($Af ? doc_link(array('sql' => "explain-output.html#explain_" . strtolower($D), 'mariadb' => "explain/#the-columns-in-explain-select",)) : "");
            }
            echo "</thead>\n";
        }
        echo "<tr" . odd() . ">";
        foreach ($J
                 as $z => $X) {
            $A = "";
            if (isset($ve[$z]) && !$e[$ve[$z]]) {
                if ($Af && $y == "sql") {
                    $Q = $J[array_search("table=", $ve)];
                    $A = ME . $ve[$z] . urlencode($Af[$Q] != "" ? $Af[$Q] : $Q);
                } else {
                    $A = ME . "edit=" . urlencode($ve[$z]);
                    foreach ($x[$ve[$z]] as $jb => $de) $A .= "&where" . urlencode("[" . bracket_escape($jb) . "]") . "=" . urlencode($J[$de]);
                }
            } elseif (is_url($X)) $A = $X;
            if ($X === null) $X = "<i>NULL</i>"; elseif ($Sa[$z] && !is_utf8($X)) $X = "<i>" . lang(array('%d byte', '%d bytes'), strlen($X)) . "</i>";
            else {
                $X = h($X);
                if ($U[$z] == 254) $X = "<code>$X</code>";
            }
            if ($A) $X = "<a href='" . h($A) . "'" . (is_url($A) ? target_blank() : '') . ">$X</a>";
            echo "<td>$X";
        }
    }
    echo ($t ? "</table>\n</div>" : "<p class='message'>" . 'No rows.') . "\n";
    return $I;
}

function
referencable_primary($eh)
{
    $I = array();
    foreach (table_status('', true) as $Nh => $Q) {
        if ($Nh != $eh && fk_support($Q)) {
            foreach (fields($Nh) as $n) {
                if ($n["primary"]) {
                    if ($I[$Nh]) {
                        unset($I[$Nh]);
                        break;
                    }
                    $I[$Nh] = $n;
                }
            }
        }
    }
    return $I;
}

function
adminer_settings()
{
    parse_str($_COOKIE["adminer_settings"], $nh);
    return $nh;
}

function
adminer_setting($z)
{
    $nh = adminer_settings();
    return $nh[$z];
}

function
set_adminer_settings($nh)
{
    return
        cookie("adminer_settings", http_build_query($nh + adminer_settings()));
}

function
textarea($D, $Y, $K = 10, $ob = 80)
{
    global $y;
    echo "<textarea name='$D' rows='$K' cols='$ob' class='sqlarea jush-$y' spellcheck='false' wrap='off'>";
    if (is_array($Y)) {
        foreach ($Y
                 as $X) echo
            h($X[0]) . "\n\n\n";
    } else
        echo
        h($Y);
    echo "</textarea>";
}

function
edit_type($z, $n, $mb, $gd = array(), $Oc = array())
{
    global $Fh, $U, $Gi, $of;
    $T = $n["type"];
    echo '<td><select name="', h($z), '[type]" class="type" aria-labelledby="label-type">';
    if ($T && !isset($U[$T]) && !isset($gd[$T]) && !in_array($T, $Oc)) $Oc[] = $T;
    if ($gd) $Fh['Foreign keys'] = $gd;
    echo
    optionlist(array_merge($Oc, $Fh), $T), '</select><td><input name="', h($z), '[length]" value="', h($n["length"]), '" size="3"', (!$n["length"] && preg_match('~var(char|binary)$~', $T) ? " class='required'" : "");
    echo ' aria-labelledby="label-length"><td class="options">', "<select name='" . h($z) . "[collation]'" . (preg_match('~(char|text|enum|set)$~', $T) ? "" : " class='hidden'") . '><option value="">(' . 'collation' . ')' . optionlist($mb, $n["collation"]) . '</select>', ($Gi ? "<select name='" . h($z) . "[unsigned]'" . (!$T || preg_match(number_type(), $T) ? "" : " class='hidden'") . '><option>' . optionlist($Gi, $n["unsigned"]) . '</select>' : ''), (isset($n['on_update']) ? "<select name='" . h($z) . "[on_update]'" . (preg_match('~timestamp|datetime~', $T) ? "" : " class='hidden'") . '>' . optionlist(array("" => "(" . 'ON UPDATE' . ")", "CURRENT_TIMESTAMP"), (preg_match('~^CURRENT_TIMESTAMP~i', $n["on_update"]) ? "CURRENT_TIMESTAMP" : $n["on_update"])) . '</select>' : ''), ($gd ? "<select name='" . h($z) . "[on_delete]'" . (preg_match("~`~", $T) ? "" : " class='hidden'") . "><option value=''>(" . 'ON DELETE' . ")" . optionlist(explode("|", $of), $n["on_delete"]) . "</select> " : " ");
}

function
process_length($se)
{
    global $zc;
    return (preg_match("~^\\s*\\(?\\s*$zc(?:\\s*,\\s*$zc)*+\\s*\\)?\\s*\$~", $se) && preg_match_all("~$zc~", $se, $Be) ? "(" . implode(",", $Be[0]) . ")" : preg_replace('~^[0-9].*~', '(\0)', preg_replace('~[^-0-9,+()[\]]~', '', $se)));
}

function
process_type($n, $kb = "COLLATE")
{
    global $Gi;
    return " $n[type]" . process_length($n["length"]) . (preg_match(number_type(), $n["type"]) && in_array($n["unsigned"], $Gi) ? " $n[unsigned]" : "") . (preg_match('~char|text|enum|set~', $n["type"]) && $n["collation"] ? " $kb " . q($n["collation"]) : "");
}

function
process_field($n, $zi)
{
    return
        array(idf_escape(trim($n["field"])), process_type($zi), ($n["null"] ? " NULL" : " NOT NULL"), default_value($n), (preg_match('~timestamp|datetime~', $n["type"]) && $n["on_update"] ? " ON UPDATE $n[on_update]" : ""), (support("comment") && $n["comment"] != "" ? " COMMENT " . q($n["comment"]) : ""), ($n["auto_increment"] ? auto_increment() : null),);
}

function
default_value($n)
{
    $Wb = $n["default"];
    return ($Wb === null ? "" : " DEFAULT " . (preg_match('~char|binary|text|enum|set~', $n["type"]) || preg_match('~^(?![a-z])~i', $Wb) ? q($Wb) : $Wb));
}

function
type_class($T)
{
    foreach (array('char' => 'text', 'date' => 'time|year', 'binary' => 'blob', 'enum' => 'set',) as $z => $X) {
        if (preg_match("~$z|$X~", $T)) return " class='$z'";
    }
}

function
edit_fields($o, $mb, $T = "TABLE", $gd = array())
{
    global $Sd;
    $o = array_values($o);
    $Xb = (($_POST ? $_POST["defaults"] : adminer_setting("defaults")) ? "" : " class='hidden'");
    $sb = (($_POST ? $_POST["comments"] : adminer_setting("comments")) ? "" : " class='hidden'");
    echo '<thead><tr>
';
    if ($T == "PROCEDURE") {
        echo '<td>';
    }
    echo '<th id="label-name">', ($T == "TABLE" ? 'Column name' : 'Parameter name'), '<td id="label-type">Type<textarea id="enum-edit" rows="4" cols="12" wrap="off" style="display: none;"></textarea>', script("qs('#enum-edit').onblur = editingLengthBlur;"), '<td id="label-length">Length
<td>', 'Options';
    if ($T == "TABLE") {
        echo '<td id="label-null">NULL
<td><input type="radio" name="auto_increment_col" value=""><acronym id="label-ai" title="Auto Increment">AI</acronym>', doc_link(array('sql' => "example-auto-increment.html", 'mariadb' => "auto_increment/", 'sqlite' => "autoinc.html", 'pgsql' => "datatype.html#DATATYPE-SERIAL", 'mssql' => "ms186775.aspx",)), '<td id="label-default"', $Xb, '>Default value
', (support("comment") ? "<td id='label-comment'$sb>" . 'Comment' : "");
    }
    echo '<td>', "<input type='image' class='icon' name='add[" . (support("move_col") ? 0 : count($o)) . "]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=plus.gif&version=4.8.0") . "' alt='+' title='" . 'Add next' . "'>" . script("row_count = " . count($o) . ";"), '</thead>
<tbody>
', script("mixin(qsl('tbody'), {onclick: editingClick, onkeydown: editingKeydown, oninput: editingInput});");
    foreach ($o
             as $t => $n) {
        $t++;
        $Bf = $n[($_POST ? "orig" : "field")];
        $ec = (isset($_POST["add"][$t - 1]) || (isset($n["field"]) && !$_POST["drop_col"][$t])) && (support("drop_col") || $Bf == "");
        echo '<tr', ($ec ? "" : " style='display: none;'"), '>
', ($T == "PROCEDURE" ? "<td>" . html_select("fields[$t][inout]", explode("|", $Sd), $n["inout"]) : ""), '<th>';
        if ($ec) {
            echo '<input name="fields[', $t, '][field]" value="', h($n["field"]), '" data-maxlength="64" autocapitalize="off" aria-labelledby="label-name">';
        }
        echo '<input type="hidden" name="fields[', $t, '][orig]" value="', h($Bf), '">';
        edit_type("fields[$t]", $n, $mb, $gd);
        if ($T == "TABLE") {
            echo '<td>', checkbox("fields[$t][null]", 1, $n["null"], "", "", "block", "label-null"), '<td><label class="block"><input type="radio" name="auto_increment_col" value="', $t, '"';
            if ($n["auto_increment"]) {
                echo ' checked';
            }
            echo ' aria-labelledby="label-ai"></label><td', $Xb, '>', checkbox("fields[$t][has_default]", 1, $n["has_default"], "", "", "", "label-default"), '<input name="fields[', $t, '][default]" value="', h($n["default"]), '" aria-labelledby="label-default">', (support("comment") ? "<td$sb><input name='fields[$t][comment]' value='" . h($n["comment"]) . "' data-maxlength='" . (min_version(5.5) ? 1024 : 255) . "' aria-labelledby='label-comment'>" : "");
        }
        echo "<td>", (support("move_col") ? "<input type='image' class='icon' name='add[$t]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=plus.gif&version=4.8.0") . "' alt='+' title='" . 'Add next' . "'> " . "<input type='image' class='icon' name='up[$t]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=up.gif&version=4.8.0") . "' alt='↑' title='" . 'Move up' . "'> " . "<input type='image' class='icon' name='down[$t]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=down.gif&version=4.8.0") . "' alt='↓' title='" . 'Move down' . "'> " : ""), ($Bf == "" || support("drop_col") ? "<input type='image' class='icon' name='drop_col[$t]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=cross.gif&version=4.8.0") . "' alt='x' title='" . 'Remove' . "'>" : "");
    }
}

function
process_fields(&$o)
{
    $gf = 0;
    if ($_POST["up"]) {
        $me = 0;
        foreach ($o
                 as $z => $n) {
            if (key($_POST["up"]) == $z) {
                unset($o[$z]);
                array_splice($o, $me, 0, array($n));
                break;
            }
            if (isset($n["field"])) $me = $gf;
            $gf++;
        }
    } elseif ($_POST["down"]) {
        $id = false;
        foreach ($o
                 as $z => $n) {
            if (isset($n["field"]) && $id) {
                unset($o[key($_POST["down"])]);
                array_splice($o, $gf, 0, array($id));
                break;
            }
            if (key($_POST["down"]) == $z) $id = $n;
            $gf++;
        }
    } elseif ($_POST["add"]) {
        $o = array_values($o);
        array_splice($o, key($_POST["add"]), 0, array(array()));
    } elseif (!$_POST["drop_col"]) return
        false;
    return
        true;
}

function
normalize_enum($C)
{
    return "'" . str_replace("'", "''", addcslashes(stripcslashes(str_replace($C[0][0] . $C[0][0], $C[0][0], substr($C[0], 1, -1))), '\\')) . "'";
}

function
grant($md, $og, $e, $nf)
{
    if (!$og) return
        true;
    if ($og == array("ALL PRIVILEGES", "GRANT OPTION")) return ($md == "GRANT" ? queries("$md ALL PRIVILEGES$nf WITH GRANT OPTION") : queries("$md ALL PRIVILEGES$nf") && queries("$md GRANT OPTION$nf"));
    return
        queries("$md " . preg_replace('~(GRANT OPTION)\([^)]*\)~', '\1', implode("$e, ", $og) . $e) . $nf);
}

function
drop_create($ic, $h, $jc, $Zh, $lc, $B, $Me, $Ke, $Le, $kf, $Xe)
{
    if ($_POST["drop"]) query_redirect($ic, $B, $Me); elseif ($kf == "") query_redirect($h, $B, $Le);
    elseif ($kf != $Xe) {
        $Jb = queries($h);
        queries_redirect($B, $Ke, $Jb && queries($ic));
        if ($Jb) queries($jc);
    } else
        queries_redirect($B, $Ke, queries($Zh) && queries($lc) && queries($ic) && queries($h));
}

function
create_trigger($nf, $J)
{
    global $y;
    $ei = " $J[Timing] $J[Event]" . ($J["Event"] == "UPDATE OF" ? " " . idf_escape($J["Of"]) : "");
    return "CREATE TRIGGER " . idf_escape($J["Trigger"]) . ($y == "mssql" ? $nf . $ei : $ei . $nf) . rtrim(" $J[Type]\n$J[Statement]", ";") . ";";
}

function
create_routine($Sg, $J)
{
    global $Sd, $y;
    $N = array();
    $o = (array)$J["fields"];
    ksort($o);
    foreach ($o
             as $n) {
        if ($n["field"] != "") $N[] = (preg_match("~^($Sd)\$~", $n["inout"]) ? "$n[inout] " : "") . idf_escape($n["field"]) . process_type($n, "CHARACTER SET");
    }
    $Yb = rtrim("\n$J[definition]", ";");
    return "CREATE $Sg " . idf_escape(trim($J["name"])) . " (" . implode(", ", $N) . ")" . (isset($_GET["function"]) ? " RETURNS" . process_type($J["returns"], "CHARACTER SET") : "") . ($J["language"] ? " LANGUAGE $J[language]" : "") . ($y == "pgsql" ? " AS " . q($Yb) : "$Yb;");
}

function
remove_definer($G)
{
    return
        preg_replace('~^([A-Z =]+) DEFINER=`' . preg_replace('~@(.*)~', '`@`(%|\1)', logged_user()) . '`~', '\1', $G);
}

function
format_foreign_key($q)
{
    global $of;
    $k = $q["db"];
    $bf = $q["ns"];
    return " FOREIGN KEY (" . implode(", ", array_map('idf_escape', $q["source"])) . ") REFERENCES " . ($k != "" && $k != $_GET["db"] ? idf_escape($k) . "." : "") . ($bf != "" && $bf != $_GET["ns"] ? idf_escape($bf) . "." : "") . table($q["table"]) . " (" . implode(", ", array_map('idf_escape', $q["target"])) . ")" . (preg_match("~^($of)\$~", $q["on_delete"]) ? " ON DELETE $q[on_delete]" : "") . (preg_match("~^($of)\$~", $q["on_update"]) ? " ON UPDATE $q[on_update]" : "");
}

function
tar_file($p, $ji)
{
    $I = pack("a100a8a8a8a12a12", $p, 644, 0, 0, decoct($ji->size), decoct(time()));
    $eb = 8 * 32;
    for ($t = 0; $t < strlen($I); $t++) $eb += ord($I[$t]);
    $I .= sprintf("%06o", $eb) . "\0 ";
    echo $I, str_repeat("\0", 512 - strlen($I));
    $ji->send();
    echo
    str_repeat("\0", 511 - ($ji->size + 511) % 512);
}

function
ini_bytes($Rd)
{
    $X = ini_get($Rd);
    switch (strtolower(substr($X, -1))) {
        case'g':
            $X *= 1024;
        case'm':
            $X *= 1024;
        case'k':
            $X *= 1024;
    }
    return $X;
}

function
doc_link($Xf, $ai = "<sup>?</sup>")
{
    global $y, $f;
    $jh = $f->server_info;
    $Vi = preg_replace('~^(\d\.?\d).*~s', '\1', $jh);
    $Ki = array('sql' => "https://dev.mysql.com/doc/refman/$Vi/en/", 'sqlite' => "https://www.sqlite.org/", 'pgsql' => "https://www.postgresql.org/docs/$Vi/", 'mssql' => "https://msdn.microsoft.com/library/", 'oracle' => "https://www.oracle.com/pls/topic/lookup?ctx=db" . preg_replace('~^.* (\d+)\.(\d+)\.\d+\.\d+\.\d+.*~s', '\1\2', $jh) . "&id=",);
    if (preg_match('~MariaDB~', $jh)) {
        $Ki['sql'] = "https://mariadb.com/kb/en/library/";
        $Xf['sql'] = (isset($Xf['mariadb']) ? $Xf['mariadb'] : str_replace(".html", "/", $Xf['sql']));
    }
    return ($Xf[$y] ? "<a href='$Ki[$y]$Xf[$y]'" . target_blank() . ">$ai</a>" : "");
}

function
ob_gzencode($P)
{
    return
        gzencode($P);
}

function
db_size($k)
{
    global $f;
    if (!$f->select_db($k)) return "?";
    $I = 0;
    foreach (table_status() as $R) $I += $R["Data_length"] + $R["Index_length"];
    return
        format_number($I);
}

function
set_utf8mb4($h)
{
    global $f;
    static $N = false;
    if (!$N && preg_match('~\butf8mb4~i', $h)) {
        $N = true;
        echo "SET NAMES " . charset($f) . ";\n\n";
    }
}

function
connect_error()
{
    global $b, $f, $mi, $m, $hc;
    if (DB != "") {
        header("HTTP/1.1 404 Not Found");
        page_header('Database' . ": " . h(DB), 'Invalid database.', true);
    } else {
        if ($_POST["db"] && !$m) queries_redirect(substr(ME, 0, -1), 'Databases have been dropped.', drop_databases($_POST["db"]));
        page_header('Select database', $m, false);
        echo "<p class='links'>\n";
        foreach (array('database' => 'Create database', 'privileges' => 'Privileges', 'processlist' => 'Process list', 'variables' => 'Variables', 'status' => 'Status',) as $z => $X) {
            if (support($z)) echo "<a href='" . h(ME) . "$z='>$X</a>\n";
        }
        echo "<p>" . sprintf('%s version: %s through PHP extension %s', $hc[DRIVER], "<b>" . h($f->server_info) . "</b>", "<b>$f->extension</b>") . "\n", "<p>" . sprintf('Logged as: %s', "<b>" . h(logged_user()) . "</b>") . "\n";
        $j = $b->databases();
        if ($j) {
            $Zg = support("scheme");
            $mb = collations();
            echo "<form action='' method='post'>\n", "<table cellspacing='0' class='checkable'>\n", script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"), "<thead><tr>" . (support("database") ? "<td>" : "") . "<th>" . 'Database' . " - <a href='" . h(ME) . "refresh=1'>" . 'Refresh' . "</a>" . "<td>" . 'Collation' . "<td>" . 'Tables' . "<td>" . 'Size' . " - <a href='" . h(ME) . "dbsize=1'>" . 'Compute' . "</a>" . script("qsl('a').onclick = partial(ajaxSetHtml, '" . js_escape(ME) . "script=connect');", "") . "</thead>\n";
            $j = ($_GET["dbsize"] ? count_tables($j) : array_flip($j));
            foreach ($j
                     as $k => $S) {
                $Rg = h(ME) . "db=" . urlencode($k);
                $u = h("Db-" . $k);
                echo "<tr" . odd() . ">" . (support("database") ? "<td>" . checkbox("db[]", $k, in_array($k, (array)$_POST["db"]), "", "", "", $u) : ""), "<th><a href='$Rg' id='$u'>" . h($k) . "</a>";
                $lb = h(db_collation($k, $mb));
                echo "<td>" . (support("database") ? "<a href='$Rg" . ($Zg ? "&amp;ns=" : "") . "&amp;database=' title='" . 'Alter database' . "'>$lb</a>" : $lb), "<td align='right'><a href='$Rg&amp;schema=' id='tables-" . h($k) . "' title='" . 'Database schema' . "'>" . ($_GET["dbsize"] ? $S : "?") . "</a>", "<td align='right' id='size-" . h($k) . "'>" . ($_GET["dbsize"] ? db_size($k) : "?"), "\n";
            }
            echo "</table>\n", (support("database") ? "<div class='footer'><div>\n" . "<fieldset><legend>" . 'Selected' . " <span id='selected'></span></legend><div>\n" . "<input type='hidden' name='all' value=''>" . script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^db/)); };") . "<input type='submit' name='drop' value='" . 'Drop' . "'>" . confirm() . "\n" . "</div></fieldset>\n" . "</div></div>\n" : ""), "<input type='hidden' name='token' value='$mi'>\n", "</form>\n", script("tableCheck();");
        }
    }
    page_footer("db");
}

if (isset($_GET["status"])) $_GET["variables"] = $_GET["status"];
if (isset($_GET["import"])) $_GET["sql"] = $_GET["import"];
if (!(DB != "" ? $f->select_db(DB) : isset($_GET["sql"]) || isset($_GET["dump"]) || isset($_GET["database"]) || isset($_GET["processlist"]) || isset($_GET["privileges"]) || isset($_GET["user"]) || isset($_GET["variables"]) || $_GET["script"] == "connect" || $_GET["script"] == "kill")) {
    if (DB != "" || $_GET["refresh"]) {
        restart_session();
        set_session("dbs", null);
    }
    connect_error();
    exit;
}
if (support("scheme") && DB != "" && $_GET["ns"] !== "") {
    if (!isset($_GET["ns"])) redirect(preg_replace('~ns=[^&]*&~', '', ME) . "ns=" . get_schema());
    if (!set_schema($_GET["ns"])) {
        header("HTTP/1.1 404 Not Found");
        page_header('Schema' . ": " . h($_GET["ns"]), 'Invalid schema.', true);
        page_footer("ns");
        exit;
    }
}
$of = "RESTRICT|NO ACTION|CASCADE|SET NULL|SET DEFAULT";

class
TmpFile
{
    var $handler;
    var $size;

    function
    __construct()
    {
        $this->handler = tmpfile();
    }

    function
    write($Cb)
    {
        $this->size += strlen($Cb);
        fwrite($this->handler, $Cb);
    }

    function
    send()
    {
        fseek($this->handler, 0);
        fpassthru($this->handler);
        fclose($this->handler);
    }
}

$zc = "'(?:''|[^'\\\\]|\\\\.)*'";
$Sd = "IN|OUT|INOUT";
if (isset($_GET["select"]) && ($_POST["edit"] || $_POST["clone"]) && !$_POST["save"]) $_GET["edit"] = $_GET["select"];
if (isset($_GET["callf"])) $_GET["call"] = $_GET["callf"];
if (isset($_GET["function"])) $_GET["procedure"] = $_GET["function"];
if (isset($_GET["download"])) {
    $a = $_GET["download"];
    $o = fields($a);
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=" . friendly_url("$a-" . implode("_", $_GET["where"])) . "." . friendly_url($_GET["field"]));
    $L = array(idf_escape($_GET["field"]));
    $H = $l->select($a, $L, array(where($_GET, $o)), $L);
    $J = ($H ? $H->fetch_row() : array());
    echo $l->value($J[0], $o[$_GET["field"]]);
    exit;
} elseif (isset($_GET["table"])) {
    $a = $_GET["table"];
    $o = fields($a);
    if (!$o) $m = error();
    $R = table_status1($a, true);
    $D = $b->tableName($R);
    page_header(($o && is_view($R) ? $R['Engine'] == 'materialized view' ? 'Materialized view' : 'View' : 'Table') . ": " . ($D != "" ? $D : h($a)), $m);
    $b->selectLinks($R);
    $rb = $R["Comment"];
    if ($rb != "") echo "<p class='nowrap'>" . 'Comment' . ": " . h($rb) . "\n";
    if ($o) $b->tableStructurePrint($o);
    if (!is_view($R)) {
        if (support("indexes")) {
            echo "<h3 id='indexes'>" . 'Indexes' . "</h3>\n";
            $x = indexes($a);
            if ($x) $b->tableIndexesPrint($x);
            echo '<p class="links"><a href="' . h(ME) . 'indexes=' . urlencode($a) . '">' . 'Alter indexes' . "</a>\n";
        }
        if (fk_support($R)) {
            echo "<h3 id='foreign-keys'>" . 'Foreign keys' . "</h3>\n";
            $gd = foreign_keys($a);
            if ($gd) {
                echo "<table cellspacing='0'>\n", "<thead><tr><th>" . 'Source' . "<td>" . 'Target' . "<td>" . 'ON DELETE' . "<td>" . 'ON UPDATE' . "<td></thead>\n";
                foreach ($gd
                         as $D => $q) {
                    echo "<tr title='" . h($D) . "'>", "<th><i>" . implode("</i>, <i>", array_map('h', $q["source"])) . "</i>", "<td><a href='" . h($q["db"] != "" ? preg_replace('~db=[^&]*~', "db=" . urlencode($q["db"]), ME) : ($q["ns"] != "" ? preg_replace('~ns=[^&]*~', "ns=" . urlencode($q["ns"]), ME) : ME)) . "table=" . urlencode($q["table"]) . "'>" . ($q["db"] != "" ? "<b>" . h($q["db"]) . "</b>." : "") . ($q["ns"] != "" ? "<b>" . h($q["ns"]) . "</b>." : "") . h($q["table"]) . "</a>", "(<i>" . implode("</i>, <i>", array_map('h', $q["target"])) . "</i>)", "<td>" . h($q["on_delete"]) . "\n", "<td>" . h($q["on_update"]) . "\n", '<td><a href="' . h(ME . 'foreign=' . urlencode($a) . '&name=' . urlencode($D)) . '">' . 'Alter' . '</a>';
                }
                echo "</table>\n";
            }
            echo '<p class="links"><a href="' . h(ME) . 'foreign=' . urlencode($a) . '">' . 'Add foreign key' . "</a>\n";
        }
    }
    if (support(is_view($R) ? "view_trigger" : "trigger")) {
        echo "<h3 id='triggers'>" . 'Triggers' . "</h3>\n";
        $yi = triggers($a);
        if ($yi) {
            echo "<table cellspacing='0'>\n";
            foreach ($yi
                     as $z => $X) echo "<tr valign='top'><td>" . h($X[0]) . "<td>" . h($X[1]) . "<th>" . h($z) . "<td><a href='" . h(ME . 'trigger=' . urlencode($a) . '&name=' . urlencode($z)) . "'>" . 'Alter' . "</a>\n";
            echo "</table>\n";
        }
        echo '<p class="links"><a href="' . h(ME) . 'trigger=' . urlencode($a) . '">' . 'Add trigger' . "</a>\n";
    }
} elseif (isset($_GET["schema"])) {
    page_header('Database schema', "", array(), h(DB . ($_GET["ns"] ? ".$_GET[ns]" : "")));
    $Ph = array();
    $Qh = array();
    $ea = ($_GET["schema"] ? $_GET["schema"] : $_COOKIE["adminer_schema-" . str_replace(".", "_", DB)]);
    preg_match_all('~([^:]+):([-0-9.]+)x([-0-9.]+)(_|$)~', $ea, $Be, PREG_SET_ORDER);
    foreach ($Be
             as $t => $C) {
        $Ph[$C[1]] = array($C[2], $C[3]);
        $Qh[] = "\n\t'" . js_escape($C[1]) . "': [ $C[2], $C[3] ]";
    }
    $ni = 0;
    $Pa = -1;
    $Yg = array();
    $Dg = array();
    $qe = array();
    foreach (table_status('', true) as $Q => $R) {
        if (is_view($R)) continue;
        $dg = 0;
        $Yg[$Q]["fields"] = array();
        foreach (fields($Q) as $D => $n) {
            $dg += 1.25;
            $n["pos"] = $dg;
            $Yg[$Q]["fields"][$D] = $n;
        }
        $Yg[$Q]["pos"] = ($Ph[$Q] ? $Ph[$Q] : array($ni, 0));
        foreach ($b->foreignKeys($Q) as $X) {
            if (!$X["db"]) {
                $oe = $Pa;
                if ($Ph[$Q][1] || $Ph[$X["table"]][1]) $oe = min(floatval($Ph[$Q][1]), floatval($Ph[$X["table"]][1])) - 1; else$Pa -= .1;
                while ($qe[(string)$oe]) $oe -= .0001;
                $Yg[$Q]["references"][$X["table"]][(string)$oe] = array($X["source"], $X["target"]);
                $Dg[$X["table"]][$Q][(string)$oe] = $X["target"];
                $qe[(string)$oe] = true;
            }
        }
        $ni = max($ni, $Yg[$Q]["pos"][0] + 2.5 + $dg);
    }
    echo '<div id="schema" style="height: ', $ni, 'em;">
<script', nonce(), '>
qs(\'#schema\').onselectstart = function () { return false; };
var tablePos = {', implode(",", $Qh) . "\n", '};
var em = qs(\'#schema\').offsetHeight / ', $ni, ';
document.onmousemove = schemaMousemove;
document.onmouseup = partialArg(schemaMouseup, \'', js_escape(DB), '\');
</script>
';
    foreach ($Yg
             as $D => $Q) {
        echo "<div class='table' style='top: " . $Q["pos"][0] . "em; left: " . $Q["pos"][1] . "em;'>", '<a href="' . h(ME) . 'table=' . urlencode($D) . '"><b>' . h($D) . "</b></a>", script("qsl('div').onmousedown = schemaMousedown;");
        foreach ($Q["fields"] as $n) {
            $X = '<span' . type_class($n["type"]) . ' title="' . h($n["full_type"] . ($n["null"] ? " NULL" : '')) . '">' . h($n["field"]) . '</span>';
            echo "<br>" . ($n["primary"] ? "<i>$X</i>" : $X);
        }
        foreach ((array)$Q["references"] as $Wh => $Eg) {
            foreach ($Eg
                     as $oe => $Ag) {
                $pe = $oe - $Ph[$D][1];
                $t = 0;
                foreach ($Ag[0] as $uh) echo "\n<div class='references' title='" . h($Wh) . "' id='refs$oe-" . ($t++) . "' style='left: $pe" . "em; top: " . $Q["fields"][$uh]["pos"] . "em; padding-top: .5em;'><div style='border-top: 1px solid Gray; width: " . (-$pe) . "em;'></div></div>";
            }
        }
        foreach ((array)$Dg[$D] as $Wh => $Eg) {
            foreach ($Eg
                     as $oe => $e) {
                $pe = $oe - $Ph[$D][1];
                $t = 0;
                foreach ($e
                         as $Vh) echo "\n<div class='references' title='" . h($Wh) . "' id='refd$oe-" . ($t++) . "' style='left: $pe" . "em; top: " . $Q["fields"][$Vh]["pos"] . "em; height: 1.25em; background: url(" . h(preg_replace("~\\?.*~", "", ME) . "?file=arrow.gif) no-repeat right center;&version=4.8.0") . "'><div style='height: .5em; border-bottom: 1px solid Gray; width: " . (-$pe) . "em;'></div></div>";
            }
        }
        echo "\n</div>\n";
    }
    foreach ($Yg
             as $D => $Q) {
        foreach ((array)$Q["references"] as $Wh => $Eg) {
            foreach ($Eg
                     as $oe => $Ag) {
                $Pe = $ni;
                $Fe = -10;
                foreach ($Ag[0] as $z => $uh) {
                    $eg = $Q["pos"][0] + $Q["fields"][$uh]["pos"];
                    $fg = $Yg[$Wh]["pos"][0] + $Yg[$Wh]["fields"][$Ag[1][$z]]["pos"];
                    $Pe = min($Pe, $eg, $fg);
                    $Fe = max($Fe, $eg, $fg);
                }
                echo "<div class='references' id='refl$oe' style='left: $oe" . "em; top: $Pe" . "em; padding: .5em 0;'><div style='border-right: 1px solid Gray; margin-top: 1px; height: " . ($Fe - $Pe) . "em;'></div></div>\n";
            }
        }
    }
    echo '</div>
<p class="links"><a href="', h(ME . "schema=" . urlencode($ea)), '" id="schema-link">Permanent link</a>
';
} elseif (isset($_GET["dump"])) {
    $a = $_GET["dump"];
    if ($_POST && !$m) {
        $Fb = "";
        foreach (array("output", "format", "db_style", "routines", "events", "table_style", "auto_increment", "triggers", "data_style") as $z) $Fb .= "&$z=" . urlencode($_POST[$z]);
        cookie("adminer_export", substr($Fb, 1));
        $S = array_flip((array)$_POST["tables"]) + array_flip((array)$_POST["data"]);
        $Lc = dump_headers((count($S) == 1 ? key($S) : DB), (DB == "" || count($S) > 1));
        $ae = preg_match('~sql~', $_POST["format"]);
        if ($ae) {
            echo "-- Adminer $ia " . $hc[DRIVER] . " " . str_replace("\n", " ", $f->server_info) . " dump\n\n";
            if ($y == "sql") {
                echo "SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
" . ($_POST["data_style"] ? "SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
" : "") . "
";
                $f->query("SET time_zone = '+00:00'");
                $f->query("SET sql_mode = ''");
            }
        }
        $Gh = $_POST["db_style"];
        $j = array(DB);
        if (DB == "") {
            $j = $_POST["databases"];
            if (is_string($j)) $j = explode("\n", rtrim(str_replace("\r", "", $j), "\n"));
        }
        foreach ((array)$j
                 as $k) {
            $b->dumpDatabase($k);
            if ($f->select_db($k)) {
                if ($ae && preg_match('~CREATE~', $Gh) && ($h = $f->result("SHOW CREATE DATABASE " . idf_escape($k), 1))) {
                    set_utf8mb4($h);
                    if ($Gh == "DROP+CREATE") echo "DROP DATABASE IF EXISTS " . idf_escape($k) . ";\n";
                    echo "$h;\n";
                }
                if ($ae) {
                    if ($Gh) echo
                        use_sql($k) . ";\n\n";
                    $Hf = "";
                    if ($_POST["routines"]) {
                        foreach (array("FUNCTION", "PROCEDURE") as $Sg) {
                            foreach (get_rows("SHOW $Sg STATUS WHERE Db = " . q($k), null, "-- ") as $J) {
                                $h = remove_definer($f->result("SHOW CREATE $Sg " . idf_escape($J["Name"]), 2));
                                set_utf8mb4($h);
                                $Hf .= ($Gh != 'DROP+CREATE' ? "DROP $Sg IF EXISTS " . idf_escape($J["Name"]) . ";;\n" : "") . "$h;;\n\n";
                            }
                        }
                    }
                    if ($_POST["events"]) {
                        foreach (get_rows("SHOW EVENTS", null, "-- ") as $J) {
                            $h = remove_definer($f->result("SHOW CREATE EVENT " . idf_escape($J["Name"]), 3));
                            set_utf8mb4($h);
                            $Hf .= ($Gh != 'DROP+CREATE' ? "DROP EVENT IF EXISTS " . idf_escape($J["Name"]) . ";;\n" : "") . "$h;;\n\n";
                        }
                    }
                    if ($Hf) echo "DELIMITER ;;\n\n$Hf" . "DELIMITER ;\n\n";
                }
                if ($_POST["table_style"] || $_POST["data_style"]) {
                    $Xi = array();
                    foreach (table_status('', true) as $D => $R) {
                        $Q = (DB == "" || in_array($D, (array)$_POST["tables"]));
                        $Pb = (DB == "" || in_array($D, (array)$_POST["data"]));
                        if ($Q || $Pb) {
                            if ($Lc == "tar") {
                                $ji = new
                                TmpFile;
                                ob_start(array($ji, 'write'), 1e5);
                            }
                            $b->dumpTable($D, ($Q ? $_POST["table_style"] : ""), (is_view($R) ? 2 : 0));
                            if (is_view($R)) $Xi[] = $D; elseif ($Pb) {
                                $o = fields($D);
                                $b->dumpData($D, $_POST["data_style"], "SELECT *" . convert_fields($o, $o) . " FROM " . table($D));
                            }
                            if ($ae && $_POST["triggers"] && $Q && ($yi = trigger_sql($D))) echo "\nDELIMITER ;;\n$yi\nDELIMITER ;\n";
                            if ($Lc == "tar") {
                                ob_end_flush();
                                tar_file((DB != "" ? "" : "$k/") . "$D.csv", $ji);
                            } elseif ($ae) echo "\n";
                        }
                    }
                    if (function_exists('foreign_keys_sql')) {
                        foreach (table_status('', true) as $D => $R) {
                            $Q = (DB == "" || in_array($D, (array)$_POST["tables"]));
                            if ($Q && !is_view($R)) echo
                            foreign_keys_sql($D);
                        }
                    }
                    foreach ($Xi
                             as $Wi) $b->dumpTable($Wi, $_POST["table_style"], 1);
                    if ($Lc == "tar") echo
                    pack("x512");
                }
            }
        }
        if ($ae) echo "-- " . $f->result("SELECT NOW()") . "\n";
        exit;
    }
    page_header('Export', $m, ($_GET["export"] != "" ? array("table" => $_GET["export"]) : array()), h(DB));
    echo '
<form action="" method="post">
<table cellspacing="0" class="layout">
';
    $Tb = array('', 'USE', 'DROP+CREATE', 'CREATE');
    $Rh = array('', 'DROP+CREATE', 'CREATE');
    $Qb = array('', 'TRUNCATE+INSERT', 'INSERT');
    if ($y == "sql") $Qb[] = 'INSERT+UPDATE';
    parse_str($_COOKIE["adminer_export"], $J);
    if (!$J) $J = array("output" => "text", "format" => "sql", "db_style" => (DB != "" ? "" : "CREATE"), "table_style" => "DROP+CREATE", "data_style" => "INSERT");
    if (!isset($J["events"])) {
        $J["routines"] = $J["events"] = ($_GET["dump"] == "");
        $J["triggers"] = $J["table_style"];
    }
    echo "<tr><th>" . 'Output' . "<td>" . html_select("output", $b->dumpOutput(), $J["output"], 0) . "\n";
    echo "<tr><th>" . 'Format' . "<td>" . html_select("format", $b->dumpFormat(), $J["format"], 0) . "\n";
    echo($y == "sqlite" ? "" : "<tr><th>" . 'Database' . "<td>" . html_select('db_style', $Tb, $J["db_style"]) . (support("routine") ? checkbox("routines", 1, $J["routines"], 'Routines') : "") . (support("event") ? checkbox("events", 1, $J["events"], 'Events') : "")), "<tr><th>" . 'Tables' . "<td>" . html_select('table_style', $Rh, $J["table_style"]) . checkbox("auto_increment", 1, $J["auto_increment"], 'Auto Increment') . (support("trigger") ? checkbox("triggers", 1, $J["triggers"], 'Triggers') : ""), "<tr><th>" . 'Data' . "<td>" . html_select('data_style', $Qb, $J["data_style"]), '</table>
<p><input type="submit" value="Export">
<input type="hidden" name="token" value="', $mi, '">

<table cellspacing="0">
', script("qsl('table').onclick = dumpClick;");
    $ig = array();
    if (DB != "") {
        $cb = ($a != "" ? "" : " checked");
        echo "<thead><tr>", "<th style='text-align: left;'><label class='block'><input type='checkbox' id='check-tables'$cb>" . 'Tables' . "</label>" . script("qs('#check-tables').onclick = partial(formCheck, /^tables\\[/);", ""), "<th style='text-align: right;'><label class='block'>" . 'Data' . "<input type='checkbox' id='check-data'$cb></label>" . script("qs('#check-data').onclick = partial(formCheck, /^data\\[/);", ""), "</thead>\n";
        $Xi = "";
        $Sh = tables_list();
        foreach ($Sh
                 as $D => $T) {
            $hg = preg_replace('~_.*~', '', $D);
            $cb = ($a == "" || $a == (substr($a, -1) == "%" ? "$hg%" : $D));
            $lg = "<tr><td>" . checkbox("tables[]", $D, $cb, $D, "", "block");
            if ($T !== null && !preg_match('~table~i', $T)) $Xi .= "$lg\n"; else
                echo "$lg<td align='right'><label class='block'><span id='Rows-" . h($D) . "'></span>" . checkbox("data[]", $D, $cb) . "</label>\n";
            $ig[$hg]++;
        }
        echo $Xi;
        if ($Sh) echo
        script("ajaxSetHtml('" . js_escape(ME) . "script=db');");
    } else {
        echo "<thead><tr><th style='text-align: left;'>", "<label class='block'><input type='checkbox' id='check-databases'" . ($a == "" ? " checked" : "") . ">" . 'Database' . "</label>", script("qs('#check-databases').onclick = partial(formCheck, /^databases\\[/);", ""), "</thead>\n";
        $j = $b->databases();
        if ($j) {
            foreach ($j
                     as $k) {
                if (!information_schema($k)) {
                    $hg = preg_replace('~_.*~', '', $k);
                    echo "<tr><td>" . checkbox("databases[]", $k, $a == "" || $a == "$hg%", $k, "", "block") . "\n";
                    $ig[$hg]++;
                }
            }
        } else
            echo "<tr><td><textarea name='databases' rows='10' cols='20'></textarea>";
    }
    echo '</table>
</form>
';
    $Yc = true;
    foreach ($ig
             as $z => $X) {
        if ($z != "" && $X > 1) {
            echo ($Yc ? "<p>" : " ") . "<a href='" . h(ME) . "dump=" . urlencode("$z%") . "'>" . h($z) . "</a>";
            $Yc = false;
        }
    }
} elseif (isset($_GET["privileges"])) {
    page_header('Privileges');
    echo '<p class="links"><a href="' . h(ME) . 'user=">' . 'Create user' . "</a>";
    $H = $f->query("SELECT User, Host FROM mysql." . (DB == "" ? "user" : "db WHERE " . q(DB) . " LIKE Db") . " ORDER BY Host, User");
    $md = $H;
    if (!$H) $H = $f->query("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', 1) AS User, SUBSTRING_INDEX(CURRENT_USER, '@', -1) AS Host");
    echo "<form action=''><p>\n";
    hidden_fields_get();
    echo "<input type='hidden' name='db' value='" . h(DB) . "'>\n", ($md ? "" : "<input type='hidden' name='grant' value=''>\n"), "<table cellspacing='0'>\n", "<thead><tr><th>" . 'Username' . "<th>" . 'Server' . "<th></thead>\n";
    while ($J = $H->fetch_assoc()) echo '<tr' . odd() . '><td>' . h($J["User"]) . "<td>" . h($J["Host"]) . '<td><a href="' . h(ME . 'user=' . urlencode($J["User"]) . '&host=' . urlencode($J["Host"])) . '">' . 'Edit' . "</a>\n";
    if (!$md || DB != "") echo "<tr" . odd() . "><td><input name='user' autocapitalize='off'><td><input name='host' value='localhost' autocapitalize='off'><td><input type='submit' value='" . 'Edit' . "'>\n";
    echo "</table>\n", "</form>\n";
} elseif (isset($_GET["sql"])) {
    if (!$m && $_POST["export"]) {
        dump_headers("sql");
        $b->dumpTable("", "");
        $b->dumpData("", "table", $_POST["query"]);
        exit;
    }
    restart_session();
    $_d =& get_session("queries");
    $zd =& $_d[DB];
    if (!$m && $_POST["clear"]) {
        $zd = array();
        redirect(remove_from_uri("history"));
    }
    page_header((isset($_GET["import"]) ? 'Import' : 'SQL command'), $m);
    if (!$m && $_POST) {
        $r = false;
        if (!isset($_GET["import"])) $G = $_POST["query"]; elseif ($_POST["webfile"]) {
            $yh = $b->importServerPath();
            $r = @fopen((file_exists($yh) ? $yh : "compress.zlib://$yh.gz"), "rb");
            $G = ($r ? fread($r, 1e6) : false);
        } else$G = get_file("sql_file", true);
        if (is_string($G)) {
            if (function_exists('memory_get_usage')) @ini_set("memory_limit", max(ini_bytes("memory_limit"), 2 * strlen($G) + memory_get_usage() + 8e6));
            if ($G != "" && strlen($G) < 1e6) {
                $tg = $G . (preg_match("~;[ \t\r\n]*\$~", $G) ? "" : ";");
                if (!$zd || reset(end($zd)) != $tg) {
                    restart_session();
                    $zd[] = array($tg, time());
                    set_session("queries", $_d);
                    stop_session();
                }
            }
            $vh = "(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";
            $Zb = ";";
            $gf = 0;
            $wc = true;
            $g = connect();
            if (is_object($g) && DB != "") {
                $g->select_db(DB);
                if ($_GET["ns"] != "") set_schema($_GET["ns"], $g);
            }
            $qb = 0;
            $Ac = array();
            $Of = '[\'"' . ($y == "sql" ? '`#' : ($y == "sqlite" ? '`[' : ($y == "mssql" ? '[' : ''))) . ']|/\*|-- |$' . ($y == "pgsql" ? '|\$[^$]*\$' : '');
            $oi = microtime(true);
            parse_str($_COOKIE["adminer_export"], $xa);
            $nc = $b->dumpFormat();
            unset($nc["sql"]);
            while ($G != "") {
                if (!$gf && preg_match("~^$vh*+DELIMITER\\s+(\\S+)~i", $G, $C)) {
                    $Zb = $C[1];
                    $G = substr($G, strlen($C[0]));
                } else {
                    preg_match('(' . preg_quote($Zb) . "\\s*|$Of)", $G, $C, PREG_OFFSET_CAPTURE, $gf);
                    list($id, $dg) = $C[0];
                    if (!$id && $r && !feof($r)) $G .= fread($r, 1e5); else {
                        if (!$id && rtrim($G) == "") break;
                        $gf = $dg + strlen($id);
                        if ($id && rtrim($id) != $Zb) {
                            while (preg_match('(' . ($id == '/*' ? '\*/' : ($id == '[' ? ']' : (preg_match('~^-- |^#~', $id) ? "\n" : preg_quote($id) . "|\\\\."))) . '|$)s', $G, $C, PREG_OFFSET_CAPTURE, $gf)) {
                                $Wg = $C[0][0];
                                if (!$Wg && $r && !feof($r)) $G .= fread($r, 1e5); else {
                                    $gf = $C[0][1] + strlen($Wg);
                                    if ($Wg[0] != "\\") break;
                                }
                            }
                        } else {
                            $wc = false;
                            $tg = substr($G, 0, $dg);
                            $qb++;
                            $lg = "<pre id='sql-$qb'><code class='jush-$y'>" . $b->sqlCommandQuery($tg) . "</code></pre>\n";
                            if ($y == "sqlite" && preg_match("~^$vh*+ATTACH\\b~i", $tg, $C)) {
                                echo $lg, "<p class='error'>" . 'ATTACH queries are not supported.' . "\n";
                                $Ac[] = " <a href='#sql-$qb'>$qb</a>";
                                if ($_POST["error_stops"]) break;
                            } else {
                                if (!$_POST["only_errors"]) {
                                    echo $lg;
                                    ob_flush();
                                    flush();
                                }
                                $Bh = microtime(true);
                                if ($f->multi_query($tg) && is_object($g) && preg_match("~^$vh*+USE\\b~i", $tg)) $g->query($tg);
                                do {
                                    $H = $f->store_result();
                                    if ($f->error) {
                                        echo($_POST["only_errors"] ? $lg : ""), "<p class='error'>" . 'Error in query' . ($f->errno ? " ($f->errno)" : "") . ": " . error() . "\n";
                                        $Ac[] = " <a href='#sql-$qb'>$qb</a>";
                                        if ($_POST["error_stops"]) break
                                        2;
                                    } else {
                                        $ci = " <span class='time'>(" . format_time($Bh) . ")</span>" . (strlen($tg) < 1000 ? " <a href='" . h(ME) . "sql=" . urlencode(trim($tg)) . "'>" . 'Edit' . "</a>" : "");
                                        $za = $f->affected_rows;
                                        $aj = ($_POST["only_errors"] ? "" : $l->warnings());
                                        $bj = "warnings-$qb";
                                        if ($aj) $ci .= ", <a href='#$bj'>" . 'Warnings' . "</a>" . script("qsl('a').onclick = partial(toggle, '$bj');", "");
                                        $Ic = null;
                                        $Jc = "explain-$qb";
                                        if (is_object($H)) {
                                            $_ = $_POST["limit"];
                                            $Af = select($H, $g, array(), $_);
                                            if (!$_POST["only_errors"]) {
                                                echo "<form action='' method='post'>\n";
                                                $cf = $H->num_rows;
                                                echo "<p>" . ($cf ? ($_ && $cf > $_ ? sprintf('%d / ', $_) : "") . lang(array('%d row', '%d rows'), $cf) : ""), $ci;
                                                if ($g && preg_match("~^($vh|\\()*+SELECT\\b~i", $tg) && ($Ic = explain($g, $tg))) echo ", <a href='#$Jc'>Explain</a>" . script("qsl('a').onclick = partial(toggle, '$Jc');", "");
                                                $u = "export-$qb";
                                                echo ", <a href='#$u'>" . 'Export' . "</a>" . script("qsl('a').onclick = partial(toggle, '$u');", "") . "<span id='$u' class='hidden'>: " . html_select("output", $b->dumpOutput(), $xa["output"]) . " " . html_select("format", $nc, $xa["format"]) . "<input type='hidden' name='query' value='" . h($tg) . "'>" . " <input type='submit' name='export' value='" . 'Export' . "'><input type='hidden' name='token' value='$mi'></span>\n" . "</form>\n";
                                            }
                                        } else {
                                            if (preg_match("~^$vh*+(CREATE|DROP|ALTER)$vh++(DATABASE|SCHEMA)\\b~i", $tg)) {
                                                restart_session();
                                                set_session("dbs", null);
                                                stop_session();
                                            }
                                            if (!$_POST["only_errors"]) echo "<p class='message' title='" . h($f->info) . "'>" . lang(array('Query executed OK, %d row affected.', 'Query executed OK, %d rows affected.'), $za) . "$ci\n";
                                        }
                                        echo($aj ? "<div id='$bj' class='hidden'>\n$aj</div>\n" : "");
                                        if ($Ic) {
                                            echo "<div id='$Jc' class='hidden'>\n";
                                            select($Ic, $g, $Af);
                                            echo "</div>\n";
                                        }
                                    }
                                    $Bh = microtime(true);
                                } while ($f->next_result());
                            }
                            $G = substr($G, $gf);
                            $gf = 0;
                        }
                    }
                }
            }
            if ($wc) echo "<p class='message'>" . 'No commands to execute.' . "\n"; elseif ($_POST["only_errors"]) {
                echo "<p class='message'>" . lang(array('%d query executed OK.', '%d queries executed OK.'), $qb - count($Ac)), " <span class='time'>(" . format_time($oi) . ")</span>\n";
            } elseif ($Ac && $qb > 1) echo "<p class='error'>" . 'Error in query' . ": " . implode("", $Ac) . "\n";
        } else
            echo "<p class='error'>" . upload_error($G) . "\n";
    }
    echo '
<form action="" method="post" enctype="multipart/form-data" id="form">
';
    $Gc = "<input type='submit' value='" . 'Execute' . "' title='Ctrl+Enter'>";
    if (!isset($_GET["import"])) {
        $tg = $_GET["sql"];
        if ($_POST) $tg = $_POST["query"]; elseif ($_GET["history"] == "all") $tg = $zd;
        elseif ($_GET["history"] != "") $tg = $zd[$_GET["history"]][0];
        echo "<p>";
        textarea("query", $tg, 20);
        echo
        script(($_POST ? "" : "qs('textarea').focus();\n") . "qs('#form').onsubmit = partial(sqlSubmit, qs('#form'), '" . js_escape(remove_from_uri("sql|limit|error_stops|only_errors|history")) . "');"), "<p>$Gc\n", 'Limit rows' . ": <input type='number' name='limit' class='size' value='" . h($_POST ? $_POST["limit"] : $_GET["limit"]) . "'>\n";
    } else {
        echo "<fieldset><legend>" . 'File upload' . "</legend><div>";
        $sd = (extension_loaded("zlib") ? "[.gz]" : "");
        echo(ini_bool("file_uploads") ? "SQL$sd (&lt; " . ini_get("upload_max_filesize") . "B): <input type='file' name='sql_file[]' multiple>\n$Gc" : 'File uploads are disabled.'), "</div></fieldset>\n";
        $Hd = $b->importServerPath();
        if ($Hd) {
            echo "<fieldset><legend>" . 'From server' . "</legend><div>", sprintf('Webserver file %s', "<code>" . h($Hd) . "$sd</code>"), ' <input type="submit" name="webfile" value="' . 'Run file' . '">', "</div></fieldset>\n";
        }
        echo "<p>";
    }
    echo
        checkbox("error_stops", 1, ($_POST ? $_POST["error_stops"] : isset($_GET["import"]) || $_GET["error_stops"]), 'Stop on error') . "\n", checkbox("only_errors", 1, ($_POST ? $_POST["only_errors"] : isset($_GET["import"]) || $_GET["only_errors"]), 'Show only errors') . "\n", "<input type='hidden' name='token' value='$mi'>\n";
    if (!isset($_GET["import"]) && $zd) {
        print_fieldset("history", 'History', $_GET["history"] != "");
        for ($X = end($zd); $X; $X = prev($zd)) {
            $z = key($zd);
            list($tg, $ci, $rc) = $X;
            echo '<a href="' . h(ME . "sql=&history=$z") . '">' . 'Edit' . "</a>" . " <span class='time' title='" . @date('Y-m-d', $ci) . "'>" . @date("H:i:s", $ci) . "</span>" . " <code class='jush-$y'>" . shorten_utf8(ltrim(str_replace("\n", " ", str_replace("\r", "", preg_replace('~^(#|-- ).*~m', '', $tg)))), 80, "</code>") . ($rc ? " <span class='time'>($rc)</span>" : "") . "<br>\n";
        }
        echo "<input type='submit' name='clear' value='" . 'Clear' . "'>\n", "<a href='" . h(ME . "sql=&history=all") . "'>" . 'Edit all' . "</a>\n", "</div></fieldset>\n";
    }
    echo '</form>
';
} elseif (isset($_GET["edit"])) {
    $a = $_GET["edit"];
    $o = fields($a);
    $Z = (isset($_GET["select"]) ? ($_POST["check"] && count($_POST["check"]) == 1 ? where_check($_POST["check"][0], $o) : "") : where($_GET, $o));
    $Hi = (isset($_GET["select"]) ? $_POST["edit"] : $Z);
    foreach ($o
             as $D => $n) {
        if (!isset($n["privileges"][$Hi ? "update" : "insert"]) || $b->fieldName($n) == "" || $n["generated"]) unset($o[$D]);
    }
    if ($_POST && !$m && !isset($_GET["select"])) {
        $B = $_POST["referer"];
        if ($_POST["insert"]) $B = ($Hi ? null : $_SERVER["REQUEST_URI"]); elseif (!preg_match('~^.+&select=.+$~', $B)) $B = ME . "select=" . urlencode($a);
        $x = indexes($a);
        $Ci = unique_array($_GET["where"], $x);
        $wg = "\nWHERE $Z";
        if (isset($_POST["delete"])) queries_redirect($B, 'Item has been deleted.', $l->delete($a, $wg, !$Ci)); else {
            $N = array();
            foreach ($o
                     as $D => $n) {
                $X = process_input($n);
                if ($X !== false && $X !== null) $N[idf_escape($D)] = $X;
            }
            if ($Hi) {
                if (!$N) redirect($B);
                queries_redirect($B, 'Item has been updated.', $l->update($a, $N, $wg, !$Ci));
                if (is_ajax()) {
                    page_headers();
                    page_messages($m);
                    exit;
                }
            } else {
                $H = $l->insert($a, $N);
                $ne = ($H ? last_id() : 0);
                queries_redirect($B, sprintf('Item%s has been inserted.', ($ne ? " $ne" : "")), $H);
            }
        }
    }
    $J = null;
    if ($_POST["save"]) $J = (array)$_POST["fields"]; elseif ($Z) {
        $L = array();
        foreach ($o
                 as $D => $n) {
            if (isset($n["privileges"]["select"])) {
                $Fa = convert_field($n);
                if ($_POST["clone"] && $n["auto_increment"]) $Fa = "''";
                if ($y == "sql" && preg_match("~enum|set~", $n["type"])) $Fa = "1*" . idf_escape($D);
                $L[] = ($Fa ? "$Fa AS " : "") . idf_escape($D);
            }
        }
        $J = array();
        if (!support("table")) $L = array("*");
        if ($L) {
            $H = $l->select($a, $L, array($Z), $L, array(), (isset($_GET["select"]) ? 2 : 1));
            if (!$H) $m = error(); else {
                $J = $H->fetch_assoc();
                if (!$J) $J = false;
            }
            if (isset($_GET["select"]) && (!$J || $H->fetch_assoc())) $J = null;
        }
    }
    if (!support("table") && !$o) {
        if (!$Z) {
            $H = $l->select($a, array("*"), $Z, array("*"));
            $J = ($H ? $H->fetch_assoc() : false);
            if (!$J) $J = array($l->primary => "");
        }
        if ($J) {
            foreach ($J
                     as $z => $X) {
                if (!$Z) $J[$z] = null;
                $o[$z] = array("field" => $z, "null" => ($z != $l->primary), "auto_increment" => ($z == $l->primary));
            }
        }
    }
    edit_form($a, $o, $J, $Hi);
} elseif (isset($_GET["create"])) {
    $a = $_GET["create"];
    $Qf = array();
    foreach (array('HASH', 'LINEAR HASH', 'KEY', 'LINEAR KEY', 'RANGE', 'LIST') as $z) $Qf[$z] = $z;
    $Cg = referencable_primary($a);
    $gd = array();
    foreach ($Cg
             as $Nh => $n) $gd[str_replace("`", "``", $Nh) . "`" . str_replace("`", "``", $n["field"])] = $Nh;
    $Df = array();
    $R = array();
    if ($a != "") {
        $Df = fields($a);
        $R = table_status($a);
        if (!$R) $m = 'No tables.';
    }
    $J = $_POST;
    $J["fields"] = (array)$J["fields"];
    if ($J["auto_increment_col"]) $J["fields"][$J["auto_increment_col"]]["auto_increment"] = true;
    if ($_POST) set_adminer_settings(array("comments" => $_POST["comments"], "defaults" => $_POST["defaults"]));
    if ($_POST && !process_fields($J["fields"]) && !$m) {
        if ($_POST["drop"]) queries_redirect(substr(ME, 0, -1), 'Table has been dropped.', drop_tables(array($a))); else {
            $o = array();
            $Ca = array();
            $Li = false;
            $ed = array();
            $Cf = reset($Df);
            $Aa = " FIRST";
            foreach ($J["fields"] as $z => $n) {
                $q = $gd[$n["type"]];
                $zi = ($q !== null ? $Cg[$q] : $n);
                if ($n["field"] != "") {
                    if (!$n["has_default"]) $n["default"] = null;
                    if ($z == $J["auto_increment_col"]) $n["auto_increment"] = true;
                    $qg = process_field($n, $zi);
                    $Ca[] = array($n["orig"], $qg, $Aa);
                    if (!$Cf || $qg != process_field($Cf, $Cf)) {
                        $o[] = array($n["orig"], $qg, $Aa);
                        if ($n["orig"] != "" || $Aa) $Li = true;
                    }
                    if ($q !== null) $ed[idf_escape($n["field"])] = ($a != "" && $y != "sqlite" ? "ADD" : " ") . format_foreign_key(array('table' => $gd[$n["type"]], 'source' => array($n["field"]), 'target' => array($zi["field"]), 'on_delete' => $n["on_delete"],));
                    $Aa = " AFTER " . idf_escape($n["field"]);
                } elseif ($n["orig"] != "") {
                    $Li = true;
                    $o[] = array($n["orig"]);
                }
                if ($n["orig"] != "") {
                    $Cf = next($Df);
                    if (!$Cf) $Aa = "";
                }
            }
            $Sf = "";
            if ($Qf[$J["partition_by"]]) {
                $Tf = array();
                if ($J["partition_by"] == 'RANGE' || $J["partition_by"] == 'LIST') {
                    foreach (array_filter($J["partition_names"]) as $z => $X) {
                        $Y = $J["partition_values"][$z];
                        $Tf[] = "\n  PARTITION " . idf_escape($X) . " VALUES " . ($J["partition_by"] == 'RANGE' ? "LESS THAN" : "IN") . ($Y != "" ? " ($Y)" : " MAXVALUE");
                    }
                }
                $Sf .= "\nPARTITION BY $J[partition_by]($J[partition])" . ($Tf ? " (" . implode(",", $Tf) . "\n)" : ($J["partitions"] ? " PARTITIONS " . (+$J["partitions"]) : ""));
            } elseif (support("partitioning") && preg_match("~partitioned~", $R["Create_options"])) $Sf .= "\nREMOVE PARTITIONING";
            $Je = 'Table has been altered.';
            if ($a == "") {
                cookie("adminer_engine", $J["Engine"]);
                $Je = 'Table has been created.';
            }
            $D = trim($J["name"]);
            queries_redirect(ME . (support("table") ? "table=" : "select=") . urlencode($D), $Je, alter_table($a, $D, ($y == "sqlite" && ($Li || $ed) ? $Ca : $o), $ed, ($J["Comment"] != $R["Comment"] ? $J["Comment"] : null), ($J["Engine"] && $J["Engine"] != $R["Engine"] ? $J["Engine"] : ""), ($J["Collation"] && $J["Collation"] != $R["Collation"] ? $J["Collation"] : ""), ($J["Auto_increment"] != "" ? number($J["Auto_increment"]) : ""), $Sf));
        }
    }
    page_header(($a != "" ? 'Alter table' : 'Create table'), $m, array("table" => $a), h($a));
    if (!$_POST) {
        $J = array("Engine" => $_COOKIE["adminer_engine"], "fields" => array(array("field" => "", "type" => (isset($U["int"]) ? "int" : (isset($U["integer"]) ? "integer" : "")), "on_update" => "")), "partition_names" => array(""),);
        if ($a != "") {
            $J = $R;
            $J["name"] = $a;
            $J["fields"] = array();
            if (!$_GET["auto_increment"]) $J["Auto_increment"] = "";
            foreach ($Df
                     as $n) {
                $n["has_default"] = isset($n["default"]);
                $J["fields"][] = $n;
            }
            if (support("partitioning")) {
                $kd = "FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = " . q(DB) . " AND TABLE_NAME = " . q($a);
                $H = $f->query("SELECT PARTITION_METHOD, PARTITION_ORDINAL_POSITION, PARTITION_EXPRESSION $kd ORDER BY PARTITION_ORDINAL_POSITION DESC LIMIT 1");
                list($J["partition_by"], $J["partitions"], $J["partition"]) = $H->fetch_row();
                $Tf = get_key_vals("SELECT PARTITION_NAME, PARTITION_DESCRIPTION $kd AND PARTITION_NAME != '' ORDER BY PARTITION_ORDINAL_POSITION");
                $Tf[""] = "";
                $J["partition_names"] = array_keys($Tf);
                $J["partition_values"] = array_values($Tf);
            }
        }
    }
    $mb = collations();
    $yc = engines();
    foreach ($yc
             as $xc) {
        if (!strcasecmp($xc, $J["Engine"])) {
            $J["Engine"] = $xc;
            break;
        }
    }
    echo '
<form action="" method="post" id="form">
<p>
';
    if (support("columns") || $a == "") {
        echo 'Table name: <input name="name" data-maxlength="64" value="', h($J["name"]), '" autocapitalize="off">
';
        if ($a == "" && !$_POST) echo
        script("focus(qs('#form')['name']);");
        echo($yc ? "<select name='Engine'>" . optionlist(array("" => "(" . 'engine' . ")") + $yc, $J["Engine"]) . "</select>" . on_help("getTarget(event).value", 1) . script("qsl('select').onchange = helpClose;") : ""), ' ', ($mb && !preg_match("~sqlite|mssql~", $y) ? html_select("Collation", array("" => "(" . 'collation' . ")") + $mb, $J["Collation"]) : ""), ' <input type="submit" value="Save">
';
    }
    echo '
';
    if (support("columns")) {
        echo '<div class="scrollable">
<table cellspacing="0" id="edit-fields" class="nowrap">
';
        edit_fields($J["fields"], $mb, "TABLE", $gd);
        echo '</table>
', script("editFields();"), '</div>
<p>
Auto Increment: <input type="number" name="Auto_increment" size="6" value="', h($J["Auto_increment"]), '">
', checkbox("defaults", 1, ($_POST ? $_POST["defaults"] : adminer_setting("defaults")), 'Default values', "columnShow(this.checked, 5)", "jsonly"), (support("comment") ? checkbox("comments", 1, ($_POST ? $_POST["comments"] : adminer_setting("comments")), 'Comment', "editingCommentsClick(this, true);", "jsonly") . ' <input name="Comment" value="' . h($J["Comment"]) . '" data-maxlength="' . (min_version(5.5) ? 2048 : 60) . '">' : ''), '<p>
<input type="submit" value="Save">
';
    }
    echo '
';
    if ($a != "") {
        echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', $a));
    }
    if (support("partitioning")) {
        $Rf = preg_match('~RANGE|LIST~', $J["partition_by"]);
        print_fieldset("partition", 'Partition by', $J["partition_by"]);
        echo '<p>
', "<select name='partition_by'>" . optionlist(array("" => "") + $Qf, $J["partition_by"]) . "</select>" . on_help("getTarget(event).value.replace(/./, 'PARTITION BY \$&')", 1) . script("qsl('select').onchange = partitionByChange;"), '(<input name="partition" value="', h($J["partition"]), '">)
Partitions: <input type="number" name="partitions" class="size', ($Rf || !$J["partition_by"] ? " hidden" : ""), '" value="', h($J["partitions"]), '">
<table cellspacing="0" id="partition-table"', ($Rf ? "" : " class='hidden'"), '>
<thead><tr><th>Partition name<th>Values</thead>
';
        foreach ($J["partition_names"] as $z => $X) {
            echo '<tr>', '<td><input name="partition_names[]" value="' . h($X) . '" autocapitalize="off">', ($z == count($J["partition_names"]) - 1 ? script("qsl('input').oninput = partitionNameChange;") : ''), '<td><input name="partition_values[]" value="' . h($J["partition_values"][$z]) . '">';
        }
        echo '</table>
</div></fieldset>
';
    }
    echo '<input type="hidden" name="token" value="', $mi, '">
</form>
';
} elseif (isset($_GET["indexes"])) {
    $a = $_GET["indexes"];
    $Kd = array("PRIMARY", "UNIQUE", "INDEX");
    $R = table_status($a, true);
    if (preg_match('~MyISAM|M?aria' . (min_version(5.6, '10.0.5') ? '|InnoDB' : '') . '~i', $R["Engine"])) $Kd[] = "FULLTEXT";
    if (preg_match('~MyISAM|M?aria' . (min_version(5.7, '10.2.2') ? '|InnoDB' : '') . '~i', $R["Engine"])) $Kd[] = "SPATIAL";
    $x = indexes($a);
    $jg = array();
    if ($y == "mongo") {
        $jg = $x["_id_"];
        unset($Kd[0]);
        unset($x["_id_"]);
    }
    $J = $_POST;
    if ($_POST && !$m && !$_POST["add"] && !$_POST["drop_col"]) {
        $c = array();
        foreach ($J["indexes"] as $w) {
            $D = $w["name"];
            if (in_array($w["type"], $Kd)) {
                $e = array();
                $te = array();
                $bc = array();
                $N = array();
                ksort($w["columns"]);
                foreach ($w["columns"] as $z => $d) {
                    if ($d != "") {
                        $se = $w["lengths"][$z];
                        $ac = $w["descs"][$z];
                        $N[] = idf_escape($d) . ($se ? "(" . (+$se) . ")" : "") . ($ac ? " DESC" : "");
                        $e[] = $d;
                        $te[] = ($se ? $se : null);
                        $bc[] = $ac;
                    }
                }
                if ($e) {
                    $Hc = $x[$D];
                    if ($Hc) {
                        ksort($Hc["columns"]);
                        ksort($Hc["lengths"]);
                        ksort($Hc["descs"]);
                        if ($w["type"] == $Hc["type"] && array_values($Hc["columns"]) === $e && (!$Hc["lengths"] || array_values($Hc["lengths"]) === $te) && array_values($Hc["descs"]) === $bc) {
                            unset($x[$D]);
                            continue;
                        }
                    }
                    $c[] = array($w["type"], $D, $N);
                }
            }
        }
        foreach ($x
                 as $D => $Hc) $c[] = array($Hc["type"], $D, "DROP");
        if (!$c) redirect(ME . "table=" . urlencode($a));
        queries_redirect(ME . "table=" . urlencode($a), 'Indexes have been altered.', alter_indexes($a, $c));
    }
    page_header('Indexes', $m, array("table" => $a), h($a));
    $o = array_keys(fields($a));
    if ($_POST["add"]) {
        foreach ($J["indexes"] as $z => $w) {
            if ($w["columns"][count($w["columns"])] != "") $J["indexes"][$z]["columns"][] = "";
        }
        $w = end($J["indexes"]);
        if ($w["type"] || array_filter($w["columns"], 'strlen')) $J["indexes"][] = array("columns" => array(1 => ""));
    }
    if (!$J) {
        foreach ($x
                 as $z => $w) {
            $x[$z]["name"] = $z;
            $x[$z]["columns"][] = "";
        }
        $x[] = array("columns" => array(1 => ""));
        $J["indexes"] = $x;
    }
    echo '
<form action="" method="post">
<div class="scrollable">
<table cellspacing="0" class="nowrap">
<thead><tr>
<th id="label-type">Index Type
<th><input type="submit" class="wayoff">Column (length)
<th id="label-name">Name
<th><noscript>', "<input type='image' class='icon' name='add[0]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=plus.gif&version=4.8.0") . "' alt='+' title='" . 'Add next' . "'>", '</noscript>
</thead>
';
    if ($jg) {
        echo "<tr><td>PRIMARY<td>";
        foreach ($jg["columns"] as $z => $d) {
            echo
            select_input(" disabled", $o, $d), "<label><input disabled type='checkbox'>" . 'descending' . "</label> ";
        }
        echo "<td><td>\n";
    }
    $de = 1;
    foreach ($J["indexes"] as $w) {
        if (!$_POST["drop_col"] || $de != key($_POST["drop_col"])) {
            echo "<tr><td>" . html_select("indexes[$de][type]", array(-1 => "") + $Kd, $w["type"], ($de == count($J["indexes"]) ? "indexesAddRow.call(this);" : 1), "label-type"), "<td>";
            ksort($w["columns"]);
            $t = 1;
            foreach ($w["columns"] as $z => $d) {
                echo "<span>" . select_input(" name='indexes[$de][columns][$t]' title='" . 'Column' . "'", ($o ? array_combine($o, $o) : $o), $d, "partial(" . ($t == count($w["columns"]) ? "indexesAddColumn" : "indexesChangeColumn") . ", '" . js_escape($y == "sql" ? "" : $_GET["indexes"] . "_") . "')"), ($y == "sql" || $y == "mssql" ? "<input type='number' name='indexes[$de][lengths][$t]' class='size' value='" . h($w["lengths"][$z]) . "' title='" . 'Length' . "'>" : ""), (support("descidx") ? checkbox("indexes[$de][descs][$t]", 1, $w["descs"][$z], 'descending') : ""), " </span>";
                $t++;
            }
            echo "<td><input name='indexes[$de][name]' value='" . h($w["name"]) . "' autocapitalize='off' aria-labelledby='label-name'>\n", "<td><input type='image' class='icon' name='drop_col[$de]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=cross.gif&version=4.8.0") . "' alt='x' title='" . 'Remove' . "'>" . script("qsl('input').onclick = partial(editingRemoveRow, 'indexes\$1[type]');");
        }
        $de++;
    }
    echo '</table>
</div>
<p>
<input type="submit" value="Save">
<input type="hidden" name="token" value="', $mi, '">
</form>
';
} elseif (isset($_GET["database"])) {
    $J = $_POST;
    if ($_POST && !$m && !isset($_POST["add_x"])) {
        $D = trim($J["name"]);
        if ($_POST["drop"]) {
            $_GET["db"] = "";
            queries_redirect(remove_from_uri("db|database"), 'Database has been dropped.', drop_databases(array(DB)));
        } elseif (DB !== $D) {
            if (DB != "") {
                $_GET["db"] = $D;
                queries_redirect(preg_replace('~\bdb=[^&]*&~', '', ME) . "db=" . urlencode($D), 'Database has been renamed.', rename_database($D, $J["collation"]));
            } else {
                $j = explode("\n", str_replace("\r", "", $D));
                $Hh = true;
                $me = "";
                foreach ($j
                         as $k) {
                    if (count($j) == 1 || $k != "") {
                        if (!create_database($k, $J["collation"])) $Hh = false;
                        $me = $k;
                    }
                }
                restart_session();
                set_session("dbs", null);
                queries_redirect(ME . "db=" . urlencode($me), 'Database has been created.', $Hh);
            }
        } else {
            if (!$J["collation"]) redirect(substr(ME, 0, -1));
            query_redirect("ALTER DATABASE " . idf_escape($D) . (preg_match('~^[a-z0-9_]+$~i', $J["collation"]) ? " COLLATE $J[collation]" : ""), substr(ME, 0, -1), 'Database has been altered.');
        }
    }
    page_header(DB != "" ? 'Alter database' : 'Create database', $m, array(), h(DB));
    $mb = collations();
    $D = DB;
    if ($_POST) $D = $J["name"]; elseif (DB != "") $J["collation"] = db_collation(DB, $mb);
    elseif ($y == "sql") {
        foreach (get_vals("SHOW GRANTS") as $md) {
            if (preg_match('~ ON (`(([^\\\\`]|``|\\\\.)*)%`\.\*)?~', $md, $C) && $C[1]) {
                $D = stripcslashes(idf_unescape("`$C[2]`"));
                break;
            }
        }
    }
    echo '
<form action="" method="post">
<p>
', ($_POST["add_x"] || strpos($D, "\n") ? '<textarea id="name" name="name" rows="10" cols="40">' . h($D) . '</textarea><br>' : '<input name="name" id="name" value="' . h($D) . '" data-maxlength="64" autocapitalize="off">') . "\n" . ($mb ? html_select("collation", array("" => "(" . 'collation' . ")") + $mb, $J["collation"]) . doc_link(array('sql' => "charset-charsets.html", 'mariadb' => "supported-character-sets-and-collations/", 'mssql' => "ms187963.aspx",)) : ""), script("focus(qs('#name'));"), '<input type="submit" value="Save">
';
    if (DB != "") echo "<input type='submit' name='drop' value='" . 'Drop' . "'>" . confirm(sprintf('Drop %s?', DB)) . "\n"; elseif (!$_POST["add_x"] && $_GET["db"] == "") echo "<input type='image' class='icon' name='add' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=plus.gif&version=4.8.0") . "' alt='+' title='" . 'Add next' . "'>\n";
    echo '<input type="hidden" name="token" value="', $mi, '">
</form>
';
} elseif (isset($_GET["scheme"])) {
    $J = $_POST;
    if ($_POST && !$m) {
        $A = preg_replace('~ns=[^&]*&~', '', ME) . "ns=";
        if ($_POST["drop"]) query_redirect("DROP SCHEMA " . idf_escape($_GET["ns"]), $A, 'Schema has been dropped.'); else {
            $D = trim($J["name"]);
            $A .= urlencode($D);
            if ($_GET["ns"] == "") query_redirect("CREATE SCHEMA " . idf_escape($D), $A, 'Schema has been created.'); elseif ($_GET["ns"] != $D) query_redirect("ALTER SCHEMA " . idf_escape($_GET["ns"]) . " RENAME TO " . idf_escape($D), $A, 'Schema has been altered.');
            else
                redirect($A);
        }
    }
    page_header($_GET["ns"] != "" ? 'Alter schema' : 'Create schema', $m);
    if (!$J) $J["name"] = $_GET["ns"];
    echo '
<form action="" method="post">
<p><input name="name" id="name" value="', h($J["name"]), '" autocapitalize="off">
', script("focus(qs('#name'));"), '<input type="submit" value="Save">
';
    if ($_GET["ns"] != "") echo "<input type='submit' name='drop' value='" . 'Drop' . "'>" . confirm(sprintf('Drop %s?', $_GET["ns"])) . "\n";
    echo '<input type="hidden" name="token" value="', $mi, '">
</form>
';
} elseif (isset($_GET["call"])) {
    $da = ($_GET["name"] ? $_GET["name"] : $_GET["call"]);
    page_header('Call' . ": " . h($da), $m);
    $Sg = routine($_GET["call"], (isset($_GET["callf"]) ? "FUNCTION" : "PROCEDURE"));
    $Id = array();
    $Hf = array();
    foreach ($Sg["fields"] as $t => $n) {
        if (substr($n["inout"], -3) == "OUT") $Hf[$t] = "@" . idf_escape($n["field"]) . " AS " . idf_escape($n["field"]);
        if (!$n["inout"] || substr($n["inout"], 0, 2) == "IN") $Id[] = $t;
    }
    if (!$m && $_POST) {
        $Xa = array();
        foreach ($Sg["fields"] as $z => $n) {
            if (in_array($z, $Id)) {
                $X = process_input($n);
                if ($X === false) $X = "''";
                if (isset($Hf[$z])) $f->query("SET @" . idf_escape($n["field"]) . " = $X");
            }
            $Xa[] = (isset($Hf[$z]) ? "@" . idf_escape($n["field"]) : $X);
        }
        $G = (isset($_GET["callf"]) ? "SELECT" : "CALL") . " " . table($da) . "(" . implode(", ", $Xa) . ")";
        $Bh = microtime(true);
        $H = $f->multi_query($G);
        $za = $f->affected_rows;
        echo $b->selectQuery($G, $Bh, !$H);
        if (!$H) echo "<p class='error'>" . error() . "\n"; else {
            $g = connect();
            if (is_object($g)) $g->select_db(DB);
            do {
                $H = $f->store_result();
                if (is_object($H)) select($H, $g); else
                    echo "<p class='message'>" . lang(array('Routine has been called, %d row affected.', 'Routine has been called, %d rows affected.'), $za) . " <span class='time'>" . @date("H:i:s") . "</span>\n";
            } while ($f->next_result());
            if ($Hf) select($f->query("SELECT " . implode(", ", $Hf)));
        }
    }
    echo '
<form action="" method="post">
';
    if ($Id) {
        echo "<table cellspacing='0' class='layout'>\n";
        foreach ($Id
                 as $z) {
            $n = $Sg["fields"][$z];
            $D = $n["field"];
            echo "<tr><th>" . $b->fieldName($n);
            $Y = $_POST["fields"][$D];
            if ($Y != "") {
                if ($n["type"] == "enum") $Y = +$Y;
                if ($n["type"] == "set") $Y = array_sum($Y);
            }
            input($n, $Y, (string)$_POST["function"][$D]);
            echo "\n";
        }
        echo "</table>\n";
    }
    echo '<p>
<input type="submit" value="Call">
<input type="hidden" name="token" value="', $mi, '">
</form>
';
} elseif (isset($_GET["foreign"])) {
    $a = $_GET["foreign"];
    $D = $_GET["name"];
    $J = $_POST;
    if ($_POST && !$m && !$_POST["add"] && !$_POST["change"] && !$_POST["change-js"]) {
        $Je = ($_POST["drop"] ? 'Foreign key has been dropped.' : ($D != "" ? 'Foreign key has been altered.' : 'Foreign key has been created.'));
        $B = ME . "table=" . urlencode($a);
        if (!$_POST["drop"]) {
            $J["source"] = array_filter($J["source"], 'strlen');
            ksort($J["source"]);
            $Vh = array();
            foreach ($J["source"] as $z => $X) $Vh[$z] = $J["target"][$z];
            $J["target"] = $Vh;
        }
        if ($y == "sqlite") queries_redirect($B, $Je, recreate_table($a, $a, array(), array(), array(" $D" => ($_POST["drop"] ? "" : " " . format_foreign_key($J))))); else {
            $c = "ALTER TABLE " . table($a);
            $ic = "\nDROP " . ($y == "sql" ? "FOREIGN KEY " : "CONSTRAINT ") . idf_escape($D);
            if ($_POST["drop"]) query_redirect($c . $ic, $B, $Je); else {
                query_redirect($c . ($D != "" ? "$ic," : "") . "\nADD" . format_foreign_key($J), $B, $Je);
                $m = 'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' . "<br>$m";
            }
        }
    }
    page_header('Foreign key', $m, array("table" => $a), h($a));
    if ($_POST) {
        ksort($J["source"]);
        if ($_POST["add"]) $J["source"][] = ""; elseif ($_POST["change"] || $_POST["change-js"]) $J["target"] = array();
    } elseif ($D != "") {
        $gd = foreign_keys($a);
        $J = $gd[$D];
        $J["source"][] = "";
    } else {
        $J["table"] = $a;
        $J["source"] = array("");
    }
    echo '
<form action="" method="post">
';
    $uh = array_keys(fields($a));
    if ($J["db"] != "") $f->select_db($J["db"]);
    if ($J["ns"] != "") set_schema($J["ns"]);
    $Bg = array_keys(array_filter(table_status('', true), 'fk_support'));
    $Vh = array_keys(fields(in_array($J["table"], $Bg) ? $J["table"] : reset($Bg)));
    $pf = "this.form['change-js'].value = '1'; this.form.submit();";
    echo "<p>" . 'Target table' . ": " . html_select("table", $Bg, $J["table"], $pf) . "\n";
    if ($y == "pgsql") echo 'Schema' . ": " . html_select("ns", $b->schemas(), $J["ns"] != "" ? $J["ns"] : $_GET["ns"], $pf); elseif ($y != "sqlite") {
        $Ub = array();
        foreach ($b->databases() as $k) {
            if (!information_schema($k)) $Ub[] = $k;
        }
        echo 'DB' . ": " . html_select("db", $Ub, $J["db"] != "" ? $J["db"] : $_GET["db"], $pf);
    }
    echo '<input type="hidden" name="change-js" value="">
<noscript><p><input type="submit" name="change" value="Change"></noscript>
<table cellspacing="0">
<thead><tr><th id="label-source">Source<th id="label-target">Target</thead>
';
    $de = 0;
    foreach ($J["source"] as $z => $X) {
        echo "<tr>", "<td>" . html_select("source[" . (+$z) . "]", array(-1 => "") + $uh, $X, ($de == count($J["source"]) - 1 ? "foreignAddRow.call(this);" : 1), "label-source"), "<td>" . html_select("target[" . (+$z) . "]", $Vh, $J["target"][$z], 1, "label-target");
        $de++;
    }
    echo '</table>
<p>
ON DELETE: ', html_select("on_delete", array(-1 => "") + explode("|", $of), $J["on_delete"]), ' ON UPDATE: ', html_select("on_update", array(-1 => "") + explode("|", $of), $J["on_update"]), doc_link(array('sql' => "innodb-foreign-key-constraints.html", 'mariadb' => "foreign-keys/", 'pgsql' => "sql-createtable.html#SQL-CREATETABLE-REFERENCES", 'mssql' => "ms174979.aspx", 'oracle' => "https://docs.oracle.com/cd/B19306_01/server.102/b14200/clauses002.htm#sthref2903",)), '<p>
<input type="submit" value="Save">
<noscript><p><input type="submit" name="add" value="Add column"></noscript>
';
    if ($D != "") {
        echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', $D));
    }
    echo '<input type="hidden" name="token" value="', $mi, '">
</form>
';
} elseif (isset($_GET["view"])) {
    $a = $_GET["view"];
    $J = $_POST;
    $Ef = "VIEW";
    if ($y == "pgsql" && $a != "") {
        $O = table_status($a);
        $Ef = strtoupper($O["Engine"]);
    }
    if ($_POST && !$m) {
        $D = trim($J["name"]);
        $Fa = " AS\n$J[select]";
        $B = ME . "table=" . urlencode($D);
        $Je = 'View has been altered.';
        $T = ($_POST["materialized"] ? "MATERIALIZED VIEW" : "VIEW");
        if (!$_POST["drop"] && $a == $D && $y != "sqlite" && $T == "VIEW" && $Ef == "VIEW") query_redirect(($y == "mssql" ? "ALTER" : "CREATE OR REPLACE") . " VIEW " . table($D) . $Fa, $B, $Je); else {
            $Xh = $D . "_adminer_" . uniqid();
            drop_create("DROP $Ef " . table($a), "CREATE $T " . table($D) . $Fa, "DROP $T " . table($D), "CREATE $T " . table($Xh) . $Fa, "DROP $T " . table($Xh), ($_POST["drop"] ? substr(ME, 0, -1) : $B), 'View has been dropped.', $Je, 'View has been created.', $a, $D);
        }
    }
    if (!$_POST && $a != "") {
        $J = view($a);
        $J["name"] = $a;
        $J["materialized"] = ($Ef != "VIEW");
        if (!$m) $m = error();
    }
    page_header(($a != "" ? 'Alter view' : 'Create view'), $m, array("table" => $a), h($a));
    echo '
<form action="" method="post">
<p>Name: <input name="name" value="', h($J["name"]), '" data-maxlength="64" autocapitalize="off">
', (support("materializedview") ? " " . checkbox("materialized", 1, $J["materialized"], 'Materialized view') : ""), '<p>';
    textarea("select", $J["select"]);
    echo '<p>
<input type="submit" value="Save">
';
    if ($a != "") {
        echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', $a));
    }
    echo '<input type="hidden" name="token" value="', $mi, '">
</form>
';
} elseif (isset($_GET["event"])) {
    $aa = $_GET["event"];
    $Vd = array("YEAR", "QUARTER", "MONTH", "DAY", "HOUR", "MINUTE", "WEEK", "SECOND", "YEAR_MONTH", "DAY_HOUR", "DAY_MINUTE", "DAY_SECOND", "HOUR_MINUTE", "HOUR_SECOND", "MINUTE_SECOND");
    $Dh = array("ENABLED" => "ENABLE", "DISABLED" => "DISABLE", "SLAVESIDE_DISABLED" => "DISABLE ON SLAVE");
    $J = $_POST;
    if ($_POST && !$m) {
        if ($_POST["drop"]) query_redirect("DROP EVENT " . idf_escape($aa), substr(ME, 0, -1), 'Event has been dropped.'); elseif (in_array($J["INTERVAL_FIELD"], $Vd) && isset($Dh[$J["STATUS"]])) {
            $Xg = "\nON SCHEDULE " . ($J["INTERVAL_VALUE"] ? "EVERY " . q($J["INTERVAL_VALUE"]) . " $J[INTERVAL_FIELD]" . ($J["STARTS"] ? " STARTS " . q($J["STARTS"]) : "") . ($J["ENDS"] ? " ENDS " . q($J["ENDS"]) : "") : "AT " . q($J["STARTS"])) . " ON COMPLETION" . ($J["ON_COMPLETION"] ? "" : " NOT") . " PRESERVE";
            queries_redirect(substr(ME, 0, -1), ($aa != "" ? 'Event has been altered.' : 'Event has been created.'), queries(($aa != "" ? "ALTER EVENT " . idf_escape($aa) . $Xg . ($aa != $J["EVENT_NAME"] ? "\nRENAME TO " . idf_escape($J["EVENT_NAME"]) : "") : "CREATE EVENT " . idf_escape($J["EVENT_NAME"]) . $Xg) . "\n" . $Dh[$J["STATUS"]] . " COMMENT " . q($J["EVENT_COMMENT"]) . rtrim(" DO\n$J[EVENT_DEFINITION]", ";") . ";"));
        }
    }
    page_header(($aa != "" ? 'Alter event' . ": " . h($aa) : 'Create event'), $m);
    if (!$J && $aa != "") {
        $K = get_rows("SELECT * FROM information_schema.EVENTS WHERE EVENT_SCHEMA = " . q(DB) . " AND EVENT_NAME = " . q($aa));
        $J = reset($K);
    }
    echo '
<form action="" method="post">
<table cellspacing="0" class="layout">
<tr><th>Name<td><input name="EVENT_NAME" value="', h($J["EVENT_NAME"]), '" data-maxlength="64" autocapitalize="off">
<tr><th title="datetime">Start<td><input name="STARTS" value="', h("$J[EXECUTE_AT]$J[STARTS]"), '">
<tr><th title="datetime">End<td><input name="ENDS" value="', h($J["ENDS"]), '">
<tr><th>Every<td><input type="number" name="INTERVAL_VALUE" value="', h($J["INTERVAL_VALUE"]), '" class="size"> ', html_select("INTERVAL_FIELD", $Vd, $J["INTERVAL_FIELD"]), '<tr><th>Status<td>', html_select("STATUS", $Dh, $J["STATUS"]), '<tr><th>Comment<td><input name="EVENT_COMMENT" value="', h($J["EVENT_COMMENT"]), '" data-maxlength="64">
<tr><th><td>', checkbox("ON_COMPLETION", "PRESERVE", $J["ON_COMPLETION"] == "PRESERVE", 'On completion preserve'), '</table>
<p>';
    textarea("EVENT_DEFINITION", $J["EVENT_DEFINITION"]);
    echo '<p>
<input type="submit" value="Save">
';
    if ($aa != "") {
        echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', $aa));
    }
    echo '<input type="hidden" name="token" value="', $mi, '">
</form>
';
} elseif (isset($_GET["procedure"])) {
    $da = ($_GET["name"] ? $_GET["name"] : $_GET["procedure"]);
    $Sg = (isset($_GET["function"]) ? "FUNCTION" : "PROCEDURE");
    $J = $_POST;
    $J["fields"] = (array)$J["fields"];
    if ($_POST && !process_fields($J["fields"]) && !$m) {
        $Bf = routine($_GET["procedure"], $Sg);
        $Xh = "$J[name]_adminer_" . uniqid();
        drop_create("DROP $Sg " . routine_id($da, $Bf), create_routine($Sg, $J), "DROP $Sg " . routine_id($J["name"], $J), create_routine($Sg, array("name" => $Xh) + $J), "DROP $Sg " . routine_id($Xh, $J), substr(ME, 0, -1), 'Routine has been dropped.', 'Routine has been altered.', 'Routine has been created.', $da, $J["name"]);
    }
    page_header(($da != "" ? (isset($_GET["function"]) ? 'Alter function' : 'Alter procedure') . ": " . h($da) : (isset($_GET["function"]) ? 'Create function' : 'Create procedure')), $m);
    if (!$_POST && $da != "") {
        $J = routine($_GET["procedure"], $Sg);
        $J["name"] = $da;
    }
    $mb = get_vals("SHOW CHARACTER SET");
    sort($mb);
    $Tg = routine_languages();
    echo '
<form action="" method="post" id="form">
<p>Name: <input name="name" value="', h($J["name"]), '" data-maxlength="64" autocapitalize="off">
', ($Tg ? 'Language' . ": " . html_select("language", $Tg, $J["language"]) . "\n" : ""), '<input type="submit" value="Save">
<div class="scrollable">
<table cellspacing="0" class="nowrap">
';
    edit_fields($J["fields"], $mb, $Sg);
    if (isset($_GET["function"])) {
        echo "<tr><td>" . 'Return type';
        edit_type("returns", $J["returns"], $mb, array(), ($y == "pgsql" ? array("void", "trigger") : array()));
    }
    echo '</table>
', script("editFields();"), '</div>
<p>';
    textarea("definition", $J["definition"]);
    echo '<p>
<input type="submit" value="Save">
';
    if ($da != "") {
        echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', $da));
    }
    echo '<input type="hidden" name="token" value="', $mi, '">
</form>
';
} elseif (isset($_GET["sequence"])) {
    $fa = $_GET["sequence"];
    $J = $_POST;
    if ($_POST && !$m) {
        $A = substr(ME, 0, -1);
        $D = trim($J["name"]);
        if ($_POST["drop"]) query_redirect("DROP SEQUENCE " . idf_escape($fa), $A, 'Sequence has been dropped.'); elseif ($fa == "") query_redirect("CREATE SEQUENCE " . idf_escape($D), $A, 'Sequence has been created.');
        elseif ($fa != $D) query_redirect("ALTER SEQUENCE " . idf_escape($fa) . " RENAME TO " . idf_escape($D), $A, 'Sequence has been altered.');
        else
            redirect($A);
    }
    page_header($fa != "" ? 'Alter sequence' . ": " . h($fa) : 'Create sequence', $m);
    if (!$J) $J["name"] = $fa;
    echo '
<form action="" method="post">
<p><input name="name" value="', h($J["name"]), '" autocapitalize="off">
<input type="submit" value="Save">
';
    if ($fa != "") echo "<input type='submit' name='drop' value='" . 'Drop' . "'>" . confirm(sprintf('Drop %s?', $fa)) . "\n";
    echo '<input type="hidden" name="token" value="', $mi, '">
</form>
';
} elseif (isset($_GET["type"])) {
    $ga = $_GET["type"];
    $J = $_POST;
    if ($_POST && !$m) {
        $A = substr(ME, 0, -1);
        if ($_POST["drop"]) query_redirect("DROP TYPE " . idf_escape($ga), $A, 'Type has been dropped.'); else
            query_redirect("CREATE TYPE " . idf_escape(trim($J["name"])) . " $J[as]", $A, 'Type has been created.');
    }
    page_header($ga != "" ? 'Alter type' . ": " . h($ga) : 'Create type', $m);
    if (!$J) $J["as"] = "AS ";
    echo '
<form action="" method="post">
<p>
';
    if ($ga != "") echo "<input type='submit' name='drop' value='" . 'Drop' . "'>" . confirm(sprintf('Drop %s?', $ga)) . "\n"; else {
        echo "<input name='name' value='" . h($J['name']) . "' autocapitalize='off'>\n";
        textarea("as", $J["as"]);
        echo "<p><input type='submit' value='" . 'Save' . "'>\n";
    }
    echo '<input type="hidden" name="token" value="', $mi, '">
</form>
';
} elseif (isset($_GET["trigger"])) {
    $a = $_GET["trigger"];
    $D = $_GET["name"];
    $xi = trigger_options();
    $J = (array)trigger($D) + array("Trigger" => $a . "_bi");
    if ($_POST) {
        if (!$m && in_array($_POST["Timing"], $xi["Timing"]) && in_array($_POST["Event"], $xi["Event"]) && in_array($_POST["Type"], $xi["Type"])) {
            $nf = " ON " . table($a);
            $ic = "DROP TRIGGER " . idf_escape($D) . ($y == "pgsql" ? $nf : "");
            $B = ME . "table=" . urlencode($a);
            if ($_POST["drop"]) query_redirect($ic, $B, 'Trigger has been dropped.'); else {
                if ($D != "") queries($ic);
                queries_redirect($B, ($D != "" ? 'Trigger has been altered.' : 'Trigger has been created.'), queries(create_trigger($nf, $_POST)));
                if ($D != "") queries(create_trigger($nf, $J + array("Type" => reset($xi["Type"]))));
            }
        }
        $J = $_POST;
    }
    page_header(($D != "" ? 'Alter trigger' . ": " . h($D) : 'Create trigger'), $m, array("table" => $a));
    echo '
<form action="" method="post" id="form">
<table cellspacing="0" class="layout">
<tr><th>Time<td>', html_select("Timing", $xi["Timing"], $J["Timing"], "triggerChange(/^" . preg_quote($a, "/") . "_[ba][iud]$/, '" . js_escape($a) . "', this.form);"), '<tr><th>Event<td>', html_select("Event", $xi["Event"], $J["Event"], "this.form['Timing'].onchange();"), (in_array("UPDATE OF", $xi["Event"]) ? " <input name='Of' value='" . h($J["Of"]) . "' class='hidden'>" : ""), '<tr><th>Type<td>', html_select("Type", $xi["Type"], $J["Type"]), '</table>
<p>Name: <input name="Trigger" value="', h($J["Trigger"]), '" data-maxlength="64" autocapitalize="off">
', script("qs('#form')['Timing'].onchange();"), '<p>';
    textarea("Statement", $J["Statement"]);
    echo '<p>
<input type="submit" value="Save">
';
    if ($D != "") {
        echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', $D));
    }
    echo '<input type="hidden" name="token" value="', $mi, '">
</form>
';
} elseif (isset($_GET["user"])) {
    $ha = $_GET["user"];
    $og = array("" => array("All privileges" => ""));
    foreach (get_rows("SHOW PRIVILEGES") as $J) {
        foreach (explode(",", ($J["Privilege"] == "Grant option" ? "" : $J["Context"])) as $Db) $og[$Db][$J["Privilege"]] = $J["Comment"];
    }
    $og["Server Admin"] += $og["File access on server"];
    $og["Databases"]["Create routine"] = $og["Procedures"]["Create routine"];
    unset($og["Procedures"]["Create routine"]);
    $og["Columns"] = array();
    foreach (array("Select", "Insert", "Update", "References") as $X) $og["Columns"][$X] = $og["Tables"][$X];
    unset($og["Server Admin"]["Usage"]);
    foreach ($og["Tables"] as $z => $X) unset($og["Databases"][$z]);
    $We = array();
    if ($_POST) {
        foreach ($_POST["objects"] as $z => $X) $We[$X] = (array)$We[$X] + (array)$_POST["grants"][$z];
    }
    $nd = array();
    $lf = "";
    if (isset($_GET["host"]) && ($H = $f->query("SHOW GRANTS FOR " . q($ha) . "@" . q($_GET["host"])))) {
        while ($J = $H->fetch_row()) {
            if (preg_match('~GRANT (.*) ON (.*) TO ~', $J[0], $C) && preg_match_all('~ *([^(,]*[^ ,(])( *\([^)]+\))?~', $C[1], $Be, PREG_SET_ORDER)) {
                foreach ($Be
                         as $X) {
                    if ($X[1] != "USAGE") $nd["$C[2]$X[2]"][$X[1]] = true;
                    if (preg_match('~ WITH GRANT OPTION~', $J[0])) $nd["$C[2]$X[2]"]["GRANT OPTION"] = true;
                }
            }
            if (preg_match("~ IDENTIFIED BY PASSWORD '([^']+)~", $J[0], $C)) $lf = $C[1];
        }
    }
    if ($_POST && !$m) {
        $mf = (isset($_GET["host"]) ? q($ha) . "@" . q($_GET["host"]) : "''");
        if ($_POST["drop"]) query_redirect("DROP USER $mf", ME . "privileges=", 'User has been dropped.'); else {
            $Ye = q($_POST["user"]) . "@" . q($_POST["host"]);
            $Vf = $_POST["pass"];
            if ($Vf != '' && !$_POST["hashed"] && !min_version(8)) {
                $Vf = $f->result("SELECT PASSWORD(" . q($Vf) . ")");
                $m = !$Vf;
            }
            $Jb = false;
            if (!$m) {
                if ($mf != $Ye) {
                    $Jb = queries((min_version(5) ? "CREATE USER" : "GRANT USAGE ON *.* TO") . " $Ye IDENTIFIED BY " . (min_version(8) ? "" : "PASSWORD ") . q($Vf));
                    $m = !$Jb;
                } elseif ($Vf != $lf) queries("SET PASSWORD FOR $Ye = " . q($Vf));
            }
            if (!$m) {
                $Pg = array();
                foreach ($We
                         as $ef => $md) {
                    if (isset($_GET["grant"])) $md = array_filter($md);
                    $md = array_keys($md);
                    if (isset($_GET["grant"])) $Pg = array_diff(array_keys(array_filter($We[$ef], 'strlen')), $md); elseif ($mf == $Ye) {
                        $jf = array_keys((array)$nd[$ef]);
                        $Pg = array_diff($jf, $md);
                        $md = array_diff($md, $jf);
                        unset($nd[$ef]);
                    }
                    if (preg_match('~^(.+)\s*(\(.*\))?$~U', $ef, $C) && (!grant("REVOKE", $Pg, $C[2], " ON $C[1] FROM $Ye") || !grant("GRANT", $md, $C[2], " ON $C[1] TO $Ye"))) {
                        $m = true;
                        break;
                    }
                }
            }
            if (!$m && isset($_GET["host"])) {
                if ($mf != $Ye) queries("DROP USER $mf"); elseif (!isset($_GET["grant"])) {
                    foreach ($nd
                             as $ef => $Pg) {
                        if (preg_match('~^(.+)(\(.*\))?$~U', $ef, $C)) grant("REVOKE", array_keys($Pg), $C[2], " ON $C[1] FROM $Ye");
                    }
                }
            }
            queries_redirect(ME . "privileges=", (isset($_GET["host"]) ? 'User has been altered.' : 'User has been created.'), !$m);
            if ($Jb) $f->query("DROP USER $Ye");
        }
    }
    page_header((isset($_GET["host"]) ? 'Username' . ": " . h("$ha@$_GET[host]") : 'Create user'), $m, array("privileges" => array('', 'Privileges')));
    if ($_POST) {
        $J = $_POST;
        $nd = $We;
    } else {
        $J = $_GET + array("host" => $f->result("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', -1)"));
        $J["pass"] = $lf;
        if ($lf != "") $J["hashed"] = true;
        $nd[(DB == "" || $nd ? "" : idf_escape(addcslashes(DB, "%_\\"))) . ".*"] = array();
    }
    echo '<form action="" method="post">
<table cellspacing="0" class="layout">
<tr><th>Server<td><input name="host" data-maxlength="60" value="', h($J["host"]), '" autocapitalize="off">
<tr><th>Username<td><input name="user" data-maxlength="80" value="', h($J["user"]), '" autocapitalize="off">
<tr><th>Password<td><input name="pass" id="pass" value="', h($J["pass"]), '" autocomplete="new-password">
';
    if (!$J["hashed"]) echo
    script("typePassword(qs('#pass'));");
    echo(min_version(8) ? "" : checkbox("hashed", 1, $J["hashed"], 'Hashed', "typePassword(this.form['pass'], this.checked);")), '</table>

';
    echo "<table cellspacing='0'>\n", "<thead><tr><th colspan='2'>" . 'Privileges' . doc_link(array('sql' => "grant.html#priv_level"));
    $t = 0;
    foreach ($nd
             as $ef => $md) {
        echo '<th>' . ($ef != "*.*" ? "<input name='objects[$t]' value='" . h($ef) . "' size='10' autocapitalize='off'>" : "<input type='hidden' name='objects[$t]' value='*.*' size='10'>*.*");
        $t++;
    }
    echo "</thead>\n";
    foreach (array("" => "", "Server Admin" => 'Server', "Databases" => 'Database', "Tables" => 'Table', "Columns" => 'Column', "Procedures" => 'Routine',) as $Db => $ac) {
        foreach ((array)$og[$Db] as $ng => $rb) {
            echo "<tr" . odd() . "><td" . ($ac ? ">$ac<td" : " colspan='2'") . ' lang="en" title="' . h($rb) . '">' . h($ng);
            $t = 0;
            foreach ($nd
                     as $ef => $md) {
                $D = "'grants[$t][" . h(strtoupper($ng)) . "]'";
                $Y = $md[strtoupper($ng)];
                if ($Db == "Server Admin" && $ef != (isset($nd["*.*"]) ? "*.*" : ".*")) echo "<td>"; elseif (isset($_GET["grant"])) echo "<td><select name=$D><option><option value='1'" . ($Y ? " selected" : "") . ">" . 'Grant' . "<option value='0'" . ($Y == "0" ? " selected" : "") . ">" . 'Revoke' . "</select>";
                else {
                    echo "<td align='center'><label class='block'>", "<input type='checkbox' name=$D value='1'" . ($Y ? " checked" : "") . ($ng == "All privileges" ? " id='grants-$t-all'>" : ">" . ($ng == "Grant option" ? "" : script("qsl('input').onclick = function () { if (this.checked) formUncheck('grants-$t-all'); };"))), "</label>";
                }
                $t++;
            }
        }
    }
    echo "</table>\n", '<p>
<input type="submit" value="Save">
';
    if (isset($_GET["host"])) {
        echo '<input type="submit" name="drop" value="Drop">', confirm(sprintf('Drop %s?', "$ha@$_GET[host]"));
    }
    echo '<input type="hidden" name="token" value="', $mi, '">
</form>
';
} elseif (isset($_GET["processlist"])) {
    if (support("kill") && $_POST && !$m) {
        $ie = 0;
        foreach ((array)$_POST["kill"] as $X) {
            if (kill_process($X)) $ie++;
        }
        queries_redirect(ME . "processlist=", lang(array('%d process has been killed.', '%d processes have been killed.'), $ie), $ie || !$_POST["kill"]);
    }
    page_header('Process list', $m);
    echo '
<form action="" method="post">
<div class="scrollable">
<table cellspacing="0" class="nowrap checkable">
', script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});");
    $t = -1;
    foreach (process_list() as $t => $J) {
        if (!$t) {
            echo "<thead><tr lang='en'>" . (support("kill") ? "<th>" : "");
            foreach ($J
                     as $z => $X) echo "<th>$z" . doc_link(array('sql' => "show-processlist.html#processlist_" . strtolower($z), 'pgsql' => "monitoring-stats.html#PG-STAT-ACTIVITY-VIEW", 'oracle' => "REFRN30223",));
            echo "</thead>\n";
        }
        echo "<tr" . odd() . ">" . (support("kill") ? "<td>" . checkbox("kill[]", $J[$y == "sql" ? "Id" : "pid"], 0) : "");
        foreach ($J
                 as $z => $X) echo "<td>" . (($y == "sql" && $z == "Info" && preg_match("~Query|Killed~", $J["Command"]) && $X != "") || ($y == "pgsql" && $z == "current_query" && $X != "<IDLE>") || ($y == "oracle" && $z == "sql_text" && $X != "") ? "<code class='jush-$y'>" . shorten_utf8($X, 100, "</code>") . ' <a href="' . h(ME . ($J["db"] != "" ? "db=" . urlencode($J["db"]) . "&" : "") . "sql=" . urlencode($X)) . '">' . 'Clone' . '</a>' : h($X));
        echo "\n";
    }
    echo '</table>
</div>
<p>
';
    if (support("kill")) {
        echo ($t + 1) . "/" . sprintf('%d in total', max_connections()), "<p><input type='submit' value='" . 'Kill' . "'>\n";
    }
    echo '<input type="hidden" name="token" value="', $mi, '">
</form>
', script("tableCheck();");
} elseif (isset($_GET["select"])) {
    $a = $_GET["select"];
    $R = table_status1($a);
    $x = indexes($a);
    $o = fields($a);
    $gd = column_foreign_keys($a);
    $hf = $R["Oid"];
    parse_str($_COOKIE["adminer_import"], $ya);
    $Qg = array();
    $e = array();
    $bi = null;
    foreach ($o
             as $z => $n) {
        $D = $b->fieldName($n);
        if (isset($n["privileges"]["select"]) && $D != "") {
            $e[$z] = html_entity_decode(strip_tags($D), ENT_QUOTES);
            if (is_shortable($n)) $bi = $b->selectLengthProcess();
        }
        $Qg += $n["privileges"];
    }
    list($L, $od) = $b->selectColumnsProcess($e, $x);
    $Zd = count($od) < count($L);
    $Z = $b->selectSearchProcess($o, $x);
    $yf = $b->selectOrderProcess($o, $x);
    $_ = $b->selectLimitProcess();
    if ($_GET["val"] && is_ajax()) {
        header("Content-Type: text/plain; charset=utf-8");
        foreach ($_GET["val"] as $Di => $J) {
            $Fa = convert_field($o[key($J)]);
            $L = array($Fa ? $Fa : idf_escape(key($J)));
            $Z[] = where_check($Di, $o);
            $I = $l->select($a, $L, $Z, $L);
            if ($I) echo
            reset($I->fetch_row());
        }
        exit;
    }
    $jg = $Fi = null;
    foreach ($x
             as $w) {
        if ($w["type"] == "PRIMARY") {
            $jg = array_flip($w["columns"]);
            $Fi = ($L ? $jg : array());
            foreach ($Fi
                     as $z => $X) {
                if (in_array(idf_escape($z), $L)) unset($Fi[$z]);
            }
            break;
        }
    }
    if ($hf && !$jg) {
        $jg = $Fi = array($hf => 0);
        $x[] = array("type" => "PRIMARY", "columns" => array($hf));
    }
    if ($_POST && !$m) {
        $gj = $Z;
        if (!$_POST["all"] && is_array($_POST["check"])) {
            $db = array();
            foreach ($_POST["check"] as $ab) $db[] = where_check($ab, $o);
            $gj[] = "((" . implode(") OR (", $db) . "))";
        }
        $gj = ($gj ? "\nWHERE " . implode(" AND ", $gj) : "");
        if ($_POST["export"]) {
            cookie("adminer_import", "output=" . urlencode($_POST["output"]) . "&format=" . urlencode($_POST["format"]));
            dump_headers($a);
            $b->dumpTable($a, "");
            $kd = ($L ? implode(", ", $L) : "*") . convert_fields($e, $o, $L) . "\nFROM " . table($a);
            $qd = ($od && $Zd ? "\nGROUP BY " . implode(", ", $od) : "") . ($yf ? "\nORDER BY " . implode(", ", $yf) : "");
            if (!is_array($_POST["check"]) || $jg) $G = "SELECT $kd$gj$qd"; else {
                $Bi = array();
                foreach ($_POST["check"] as $X) $Bi[] = "(SELECT" . limit($kd, "\nWHERE " . ($Z ? implode(" AND ", $Z) . " AND " : "") . where_check($X, $o) . $qd, 1) . ")";
                $G = implode(" UNION ALL ", $Bi);
            }
            $b->dumpData($a, "table", $G);
            exit;
        }
        if (!$b->selectEmailProcess($Z, $gd)) {
            if ($_POST["save"] || $_POST["delete"]) {
                $H = true;
                $za = 0;
                $N = array();
                if (!$_POST["delete"]) {
                    foreach ($e
                             as $D => $X) {
                        $X = process_input($o[$D]);
                        if ($X !== null && ($_POST["clone"] || $X !== false)) $N[idf_escape($D)] = ($X !== false ? $X : idf_escape($D));
                    }
                }
                if ($_POST["delete"] || $N) {
                    if ($_POST["clone"]) $G = "INTO " . table($a) . " (" . implode(", ", array_keys($N)) . ")\nSELECT " . implode(", ", $N) . "\nFROM " . table($a);
                    if ($_POST["all"] || ($jg && is_array($_POST["check"])) || $Zd) {
                        $H = ($_POST["delete"] ? $l->delete($a, $gj) : ($_POST["clone"] ? queries("INSERT $G$gj") : $l->update($a, $N, $gj)));
                        $za = $f->affected_rows;
                    } else {
                        foreach ((array)$_POST["check"] as $X) {
                            $cj = "\nWHERE " . ($Z ? implode(" AND ", $Z) . " AND " : "") . where_check($X, $o);
                            $H = ($_POST["delete"] ? $l->delete($a, $cj, 1) : ($_POST["clone"] ? queries("INSERT" . limit1($a, $G, $cj)) : $l->update($a, $N, $cj, 1)));
                            if (!$H) break;
                            $za += $f->affected_rows;
                        }
                    }
                }
                $Je = lang(array('%d item has been affected.', '%d items have been affected.'), $za);
                if ($_POST["clone"] && $H && $za == 1) {
                    $ne = last_id();
                    if ($ne) $Je = sprintf('Item%s has been inserted.', " $ne");
                }
                queries_redirect(remove_from_uri($_POST["all"] && $_POST["delete"] ? "page" : ""), $Je, $H);
                if (!$_POST["delete"]) {
                    edit_form($a, $o, (array)$_POST["fields"], !$_POST["clone"]);
                    page_footer();
                    exit;
                }
            } elseif (!$_POST["import"]) {
                if (!$_POST["val"]) $m = 'Ctrl+click on a value to modify it.'; else {
                    $H = true;
                    $za = 0;
                    foreach ($_POST["val"] as $Di => $J) {
                        $N = array();
                        foreach ($J
                                 as $z => $X) {
                            $z = bracket_escape($z, 1);
                            $N[idf_escape($z)] = (preg_match('~char|text~', $o[$z]["type"]) || $X != "" ? $b->processInput($o[$z], $X) : "NULL");
                        }
                        $H = $l->update($a, $N, " WHERE " . ($Z ? implode(" AND ", $Z) . " AND " : "") . where_check($Di, $o), !$Zd && !$jg, " ");
                        if (!$H) break;
                        $za += $f->affected_rows;
                    }
                    queries_redirect(remove_from_uri(), lang(array('%d item has been affected.', '%d items have been affected.'), $za), $H);
                }
            } elseif (!is_string($Wc = get_file("csv_file", true))) $m = upload_error($Wc);
            elseif (!preg_match('~~u', $Wc)) $m = 'File must be in UTF-8 encoding.';
            else {
                cookie("adminer_import", "output=" . urlencode($ya["output"]) . "&format=" . urlencode($_POST["separator"]));
                $H = true;
                $ob = array_keys($o);
                preg_match_all('~(?>"[^"]*"|[^"\r\n]+)+~', $Wc, $Be);
                $za = count($Be[0]);
                $l->begin();
                $gh = ($_POST["separator"] == "csv" ? "," : ($_POST["separator"] == "tsv" ? "\t" : ";"));
                $K = array();
                foreach ($Be[0] as $z => $X) {
                    preg_match_all("~((?>\"[^\"]*\")+|[^$gh]*)$gh~", $X . $gh, $Ce);
                    if (!$z && !array_diff($Ce[1], $ob)) {
                        $ob = $Ce[1];
                        $za--;
                    } else {
                        $N = array();
                        foreach ($Ce[1] as $t => $jb) $N[idf_escape($ob[$t])] = ($jb == "" && $o[$ob[$t]]["null"] ? "NULL" : q(str_replace('""', '"', preg_replace('~^"|"$~', '', $jb))));
                        $K[] = $N;
                    }
                }
                $H = (!$K || $l->insertUpdate($a, $K, $jg));
                if ($H) $H = $l->commit();
                queries_redirect(remove_from_uri("page"), lang(array('%d row has been imported.', '%d rows have been imported.'), $za), $H);
                $l->rollback();
            }
        }
    }
    $Nh = $b->tableName($R);
    if (is_ajax()) {
        page_headers();
        ob_start();
    } else
        page_header('Select' . ": $Nh", $m);
    $N = null;
    if (isset($Qg["insert"]) || !support("table")) {
        $N = "";
        foreach ((array)$_GET["where"] as $X) {
            if ($gd[$X["col"]] && count($gd[$X["col"]]) == 1 && ($X["op"] == "=" || (!$X["op"] && !preg_match('~[_%]~', $X["val"])))) $N .= "&set" . urlencode("[" . bracket_escape($X["col"]) . "]") . "=" . urlencode($X["val"]);
        }
    }
    $b->selectLinks($R, $N);
    if (!$e && support("table")) echo "<p class='error'>" . 'Unable to select the table' . ($o ? "." : ": " . error()) . "\n"; else {
        echo "<form action='' id='form'>\n", "<div style='display: none;'>";
        hidden_fields_get();
        echo(DB != "" ? '<input type="hidden" name="db" value="' . h(DB) . '">' . (isset($_GET["ns"]) ? '<input type="hidden" name="ns" value="' . h($_GET["ns"]) . '">' : "") : "");
        echo '<input type="hidden" name="select" value="' . h($a) . '">', "</div>\n";
        $b->selectColumnsPrint($L, $e);
        $b->selectSearchPrint($Z, $e, $x);
        $b->selectOrderPrint($yf, $e, $x);
        $b->selectLimitPrint($_);
        $b->selectLengthPrint($bi);
        $b->selectActionPrint($x);
        echo "</form>\n";
        $E = $_GET["page"];
        if ($E == "last") {
            $jd = $f->result(count_rows($a, $Z, $Zd, $od));
            $E = floor(max(0, $jd - 1) / $_);
        }
        $bh = $L;
        $pd = $od;
        if (!$bh) {
            $bh[] = "*";
            $Eb = convert_fields($e, $o, $L);
            if ($Eb) $bh[] = substr($Eb, 2);
        }
        foreach ($L
                 as $z => $X) {
            $n = $o[idf_unescape($X)];
            if ($n && ($Fa = convert_field($n))) $bh[$z] = "$Fa AS $X";
        }
        if (!$Zd && $Fi) {
            foreach ($Fi
                     as $z => $X) {
                $bh[] = idf_escape($z);
                if ($pd) $pd[] = idf_escape($z);
            }
        }
        $H = $l->select($a, $bh, $Z, $pd, $yf, $_, $E, true);
        if (!$H) echo "<p class='error'>" . error() . "\n"; else {
            if ($y == "mssql" && $E) $H->seek($_ * $E);
            $vc = array();
            echo "<form action='' method='post' enctype='multipart/form-data'>\n";
            $K = array();
            while ($J = $H->fetch_assoc()) {
                if ($E && $y == "oracle") unset($J["RNUM"]);
                $K[] = $J;
            }
            if ($_GET["page"] != "last" && $_ != "" && $od && $Zd && $y == "sql") $jd = $f->result(" SELECT FOUND_ROWS()");
            if (!$K) echo "<p class='message'>" . 'No rows.' . "\n"; else {
                $Oa = $b->backwardKeys($a, $Nh);
                echo "<div class='scrollable'>", "<table id='table' cellspacing='0' class='nowrap checkable'>", script("mixin(qs('#table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true), onkeydown: editingKeydown});"), "<thead><tr>" . (!$od && $L ? "" : "<td><input type='checkbox' id='all-page' class='jsonly'>" . script("qs('#all-page').onclick = partial(formCheck, /check/);", "") . " <a href='" . h($_GET["modify"] ? remove_from_uri("modify") : $_SERVER["REQUEST_URI"] . "&modify=1") . "'>" . 'Modify' . "</a>");
                $Ue = array();
                $ld = array();
                reset($L);
                $yg = 1;
                foreach ($K[0] as $z => $X) {
                    if (!isset($Fi[$z])) {
                        $X = $_GET["columns"][key($L)];
                        $n = $o[$L ? ($X ? $X["col"] : current($L)) : $z];
                        $D = ($n ? $b->fieldName($n, $yg) : ($X["fun"] ? "*" : $z));
                        if ($D != "") {
                            $yg++;
                            $Ue[$z] = $D;
                            $d = idf_escape($z);
                            $Cd = remove_from_uri('(order|desc)[^=]*|page') . '&order%5B0%5D=' . urlencode($z);
                            $ac = "&desc%5B0%5D=1";
                            echo "<th id='th[" . h(bracket_escape($z)) . "]'>" . script("mixin(qsl('th'), {onmouseover: partial(columnMouse), onmouseout: partial(columnMouse, ' hidden')});", ""), '<a href="' . h($Cd . ($yf[0] == $d || $yf[0] == $z || (!$yf && $Zd && $od[0] == $d) ? $ac : '')) . '">';
                            echo
                                apply_sql_function($X["fun"], $D) . "</a>";
                            echo "<span class='column hidden'>", "<a href='" . h($Cd . $ac) . "' title='" . 'descending' . "' class='text'> ↓</a>";
                            if (!$X["fun"]) {
                                echo '<a href="#fieldset-search" title="' . 'Search' . '" class="text jsonly"> =</a>', script("qsl('a').onclick = partial(selectSearch, '" . js_escape($z) . "');");
                            }
                            echo "</span>";
                        }
                        $ld[$z] = $X["fun"];
                        next($L);
                    }
                }
                $te = array();
                if ($_GET["modify"]) {
                    foreach ($K
                             as $J) {
                        foreach ($J
                                 as $z => $X) $te[$z] = max($te[$z], min(40, strlen(utf8_decode($X))));
                    }
                }
                echo ($Oa ? "<th>" . 'Relations' : "") . "</thead>\n";
                if (is_ajax()) {
                    if ($_ % 2 == 1 && $E % 2 == 1) odd();
                    ob_end_clean();
                }
                foreach ($b->rowDescriptions($K, $gd) as $Te => $J) {
                    $Ci = unique_array($K[$Te], $x);
                    if (!$Ci) {
                        $Ci = array();
                        foreach ($K[$Te] as $z => $X) {
                            if (!preg_match('~^(COUNT\((\*|(DISTINCT )?`(?:[^`]|``)+`)\)|(AVG|GROUP_CONCAT|MAX|MIN|SUM)\(`(?:[^`]|``)+`\))$~', $z)) $Ci[$z] = $X;
                        }
                    }
                    $Di = "";
                    foreach ($Ci
                             as $z => $X) {
                        if (($y == "sql" || $y == "pgsql") && preg_match('~char|text|enum|set~', $o[$z]["type"]) && strlen($X) > 64) {
                            $z = (strpos($z, '(') ? $z : idf_escape($z));
                            $z = "MD5(" . ($y != 'sql' || preg_match("~^utf8~", $o[$z]["collation"]) ? $z : "CONVERT($z USING " . charset($f) . ")") . ")";
                            $X = md5($X);
                        }
                        $Di .= "&" . ($X !== null ? urlencode("where[" . bracket_escape($z) . "]") . "=" . urlencode($X) : "null%5B%5D=" . urlencode($z));
                    }
                    echo "<tr" . odd() . ">" . (!$od && $L ? "" : "<td>" . checkbox("check[]", substr($Di, 1), in_array(substr($Di, 1), (array)$_POST["check"])) . ($Zd || information_schema(DB) ? "" : " <a href='" . h(ME . "edit=" . urlencode($a) . $Di) . "' class='edit'>" . 'edit' . "</a>"));
                    foreach ($J
                             as $z => $X) {
                        if (isset($Ue[$z])) {
                            $n = $o[$z];
                            $X = $l->value($X, $n);
                            if ($X != "" && (!isset($vc[$z]) || $vc[$z] != "")) $vc[$z] = (is_mail($X) ? $Ue[$z] : "");
                            $A = "";
                            if (preg_match('~blob|bytea|raw|file~', $n["type"]) && $X != "") $A = ME . 'download=' . urlencode($a) . '&field=' . urlencode($z) . $Di;
                            if (!$A && $X !== null) {
                                foreach ((array)$gd[$z] as $q) {
                                    if (count($gd[$z]) == 1 || end($q["source"]) == $z) {
                                        $A = "";
                                        foreach ($q["source"] as $t => $uh) $A .= where_link($t, $q["target"][$t], $K[$Te][$uh]);
                                        $A = ($q["db"] != "" ? preg_replace('~([?&]db=)[^&]+~', '\1' . urlencode($q["db"]), ME) : ME) . 'select=' . urlencode($q["table"]) . $A;
                                        if ($q["ns"]) $A = preg_replace('~([?&]ns=)[^&]+~', '\1' . urlencode($q["ns"]), $A);
                                        if (count($q["source"]) == 1) break;
                                    }
                                }
                            }
                            if ($z == "COUNT(*)") {
                                $A = ME . "select=" . urlencode($a);
                                $t = 0;
                                foreach ((array)$_GET["where"] as $W) {
                                    if (!array_key_exists($W["col"], $Ci)) $A .= where_link($t++, $W["col"], $W["val"], $W["op"]);
                                }
                                foreach ($Ci
                                         as $ee => $W) $A .= where_link($t++, $ee, $W);
                            }
                            $X = select_value($X, $A, $n, $bi);
                            $u = h("val[$Di][" . bracket_escape($z) . "]");
                            $Y = $_POST["val"][$Di][bracket_escape($z)];
                            $qc = !is_array($J[$z]) && is_utf8($X) && $K[$Te][$z] == $J[$z] && !$ld[$z];
                            $ai = preg_match('~text|lob~', $n["type"]);
                            echo "<td id='$u'";
                            if (($_GET["modify"] && $qc) || $Y !== null) {
                                $td = h($Y !== null ? $Y : $J[$z]);
                                echo ">" . ($ai ? "<textarea name='$u' cols='30' rows='" . (substr_count($J[$z], "\n") + 1) . "'>$td</textarea>" : "<input name='$u' value='$td' size='$te[$z]'>");
                            } else {
                                $xe = strpos($X, "<i>…</i>");
                                echo " data-text='" . ($xe ? 2 : ($ai ? 1 : 0)) . "'" . ($qc ? "" : " data-warning='" . h('Use edit link to modify this value.') . "'") . ">$X</td>";
                            }
                        }
                    }
                    if ($Oa) echo "<td>";
                    $b->backwardKeysPrint($Oa, $K[$Te]);
                    echo "</tr>\n";
                }
                if (is_ajax()) exit;
                echo "</table>\n", "</div>\n";
            }
            if (!is_ajax()) {
                if ($K || $E) {
                    $Fc = true;
                    if ($_GET["page"] != "last") {
                        if ($_ == "" || (count($K) < $_ && ($K || !$E))) $jd = ($E ? $E * $_ : 0) + count($K); elseif ($y != "sql" || !$Zd) {
                            $jd = ($Zd ? false : found_rows($R, $Z));
                            if ($jd < max(1e4, 2 * ($E + 1) * $_)) $jd = reset(slow_query(count_rows($a, $Z, $Zd, $od))); else$Fc = false;
                        }
                    }
                    $Lf = ($_ != "" && ($jd === false || $jd > $_ || $E));
                    if ($Lf) {
                        echo(($jd === false ? count($K) + 1 : $jd - $E * $_) > $_ ? '<p><a href="' . h(remove_from_uri("page") . "&page=" . ($E + 1)) . '" class="loadmore">' . 'Load more data' . '</a>' . script("qsl('a').onclick = partial(selectLoadMore, " . (+$_) . ", '" . 'Loading' . "…');", "") : ''), "\n";
                    }
                }
                echo "<div class='footer'><div>\n";
                if ($K || $E) {
                    if ($Lf) {
                        $Ee = ($jd === false ? $E + (count($K) >= $_ ? 2 : 1) : floor(($jd - 1) / $_));
                        echo "<fieldset>";
                        if ($y != "simpledb") {
                            echo "<legend><a href='" . h(remove_from_uri("page")) . "'>" . 'Page' . "</a></legend>", script("qsl('a').onclick = function () { pageClick(this.href, +prompt('" . 'Page' . "', '" . ($E + 1) . "')); return false; };"), pagination(0, $E) . ($E > 5 ? " …" : "");
                            for ($t = max(1, $E - 4); $t < min($Ee, $E + 5); $t++) echo
                            pagination($t, $E);
                            if ($Ee > 0) {
                                echo($E + 5 < $Ee ? " …" : ""), ($Fc && $jd !== false ? pagination($Ee, $E) : " <a href='" . h(remove_from_uri("page") . "&page=last") . "' title='~$Ee'>" . 'last' . "</a>");
                            }
                        } else {
                            echo "<legend>" . 'Page' . "</legend>", pagination(0, $E) . ($E > 1 ? " …" : ""), ($E ? pagination($E, $E) : ""), ($Ee > $E ? pagination($E + 1, $E) . ($Ee > $E + 1 ? " …" : "") : "");
                        }
                        echo "</fieldset>\n";
                    }
                    echo "<fieldset>", "<legend>" . 'Whole result' . "</legend>";
                    $fc = ($Fc ? "" : "~ ") . $jd;
                    echo
                        checkbox("all", 1, 0, ($jd !== false ? ($Fc ? "" : "~ ") . lang(array('%d row', '%d rows'), $jd) : ""), "var checked = formChecked(this, /check/); selectCount('selected', this.checked ? '$fc' : checked); selectCount('selected2', this.checked || !checked ? '$fc' : checked);") . "\n", "</fieldset>\n";
                    if ($b->selectCommandPrint()) {
                        echo '<fieldset', ($_GET["modify"] ? '' : ' class="jsonly"'), '><legend>Modify</legend><div>
<input type="submit" value="Save"', ($_GET["modify"] ? '' : ' title="' . 'Ctrl+click on a value to modify it.' . '"'), '>
</div></fieldset>
<fieldset><legend>Selected <span id="selected"></span></legend><div>
<input type="submit" name="edit" value="Edit">
<input type="submit" name="clone" value="Clone">
<input type="submit" name="delete" value="Delete">', confirm(), '</div></fieldset>
';
                    }
                    $hd = $b->dumpFormat();
                    foreach ((array)$_GET["columns"] as $d) {
                        if ($d["fun"]) {
                            unset($hd['sql']);
                            break;
                        }
                    }
                    if ($hd) {
                        print_fieldset("export", 'Export' . " <span id='selected2'></span>");
                        $If = $b->dumpOutput();
                        echo($If ? html_select("output", $If, $ya["output"]) . " " : ""), html_select("format", $hd, $ya["format"]), " <input type='submit' name='export' value='" . 'Export' . "'>\n", "</div></fieldset>\n";
                    }
                    $b->selectEmailPrint(array_filter($vc, 'strlen'), $e);
                }
                echo "</div></div>\n";
                if ($b->selectImportPrint()) {
                    echo "<div>", "<a href='#import'>" . 'Import' . "</a>", script("qsl('a').onclick = partial(toggle, 'import');", ""), "<span id='import' class='hidden'>: ", "<input type='file' name='csv_file'> ", html_select("separator", array("csv" => "CSV,", "csv;" => "CSV;", "tsv" => "TSV"), $ya["format"], 1);
                    echo " <input type='submit' name='import' value='" . 'Import' . "'>", "</span>", "</div>";
                }
                echo "<input type='hidden' name='token' value='$mi'>\n", "</form>\n", (!$od && $L ? "" : script("tableCheck();"));
            }
        }
    }
    if (is_ajax()) {
        ob_end_clean();
        exit;
    }
} elseif (isset($_GET["variables"])) {
    $O = isset($_GET["status"]);
    page_header($O ? 'Status' : 'Variables');
    $Ti = ($O ? show_status() : show_variables());
    if (!$Ti) echo "<p class='message'>" . 'No rows.' . "\n"; else {
        echo "<table cellspacing='0'>\n";
        foreach ($Ti
                 as $z => $X) {
            echo "<tr>", "<th><code class='jush-" . $y . ($O ? "status" : "set") . "'>" . h($z) . "</code>", "<td>" . h($X);
        }
        echo "</table>\n";
    }
} elseif (isset($_GET["script"])) {
    header("Content-Type: text/javascript; charset=utf-8");
    if ($_GET["script"] == "db") {
        $Kh = array("Data_length" => 0, "Index_length" => 0, "Data_free" => 0);
        foreach (table_status() as $D => $R) {
            json_row("Comment-$D", h($R["Comment"]));
            if (!is_view($R)) {
                foreach (array("Engine", "Collation") as $z) json_row("$z-$D", h($R[$z]));
                foreach ($Kh + array("Auto_increment" => 0, "Rows" => 0) as $z => $X) {
                    if ($R[$z] != "") {
                        $X = format_number($R[$z]);
                        json_row("$z-$D", ($z == "Rows" && $X && $R["Engine"] == ($xh == "pgsql" ? "table" : "InnoDB") ? "~ $X" : $X));
                        if (isset($Kh[$z])) $Kh[$z] += ($R["Engine"] != "InnoDB" || $z != "Data_free" ? $R[$z] : 0);
                    } elseif (array_key_exists($z, $R)) json_row("$z-$D");
                }
            }
        }
        foreach ($Kh
                 as $z => $X) json_row("sum-$z", format_number($X));
        json_row("");
    } elseif ($_GET["script"] == "kill") $f->query("KILL " . number($_POST["kill"]));
    else {
        foreach (count_tables($b->databases()) as $k => $X) {
            json_row("tables-$k", $X);
            json_row("size-$k", db_size($k));
        }
        json_row("");
    }
    exit;
} else {
    $Th = array_merge((array)$_POST["tables"], (array)$_POST["views"]);
    if ($Th && !$m && !$_POST["search"]) {
        $H = true;
        $Je = "";
        if ($y == "sql" && $_POST["tables"] && count($_POST["tables"]) > 1 && ($_POST["drop"] || $_POST["truncate"] || $_POST["copy"])) queries("SET foreign_key_checks = 0");
        if ($_POST["truncate"]) {
            if ($_POST["tables"]) $H = truncate_tables($_POST["tables"]);
            $Je = 'Tables have been truncated.';
        } elseif ($_POST["move"]) {
            $H = move_tables((array)$_POST["tables"], (array)$_POST["views"], $_POST["target"]);
            $Je = 'Tables have been moved.';
        } elseif ($_POST["copy"]) {
            $H = copy_tables((array)$_POST["tables"], (array)$_POST["views"], $_POST["target"]);
            $Je = 'Tables have been copied.';
        } elseif ($_POST["drop"]) {
            if ($_POST["views"]) $H = drop_views($_POST["views"]);
            if ($H && $_POST["tables"]) $H = drop_tables($_POST["tables"]);
            $Je = 'Tables have been dropped.';
        } elseif ($y != "sql") {
            $H = ($y == "sqlite" ? queries("VACUUM") : apply_queries("VACUUM" . ($_POST["optimize"] ? "" : " ANALYZE"), $_POST["tables"]));
            $Je = 'Tables have been optimized.';
        } elseif (!$_POST["tables"]) $Je = 'No tables.';
        elseif ($H = queries(($_POST["optimize"] ? "OPTIMIZE" : ($_POST["check"] ? "CHECK" : ($_POST["repair"] ? "REPAIR" : "ANALYZE"))) . " TABLE " . implode(", ", array_map('idf_escape', $_POST["tables"])))) {
            while ($J = $H->fetch_assoc()) $Je .= "<b>" . h($J["Table"]) . "</b>: " . h($J["Msg_text"]) . "<br>";
        }
        queries_redirect(substr(ME, 0, -1), $Je, $H);
    }
    page_header(($_GET["ns"] == "" ? 'Database' . ": " . h(DB) : 'Schema' . ": " . h($_GET["ns"])), $m, true);
    if ($b->homepage()) {
        if ($_GET["ns"] !== "") {
            echo "<h3 id='tables-views'>" . 'Tables and views' . "</h3>\n";
            $Sh = tables_list();
            if (!$Sh) echo "<p class='message'>" . 'No tables.' . "\n"; else {
                echo "<form action='' method='post'>\n";
                if (support("table")) {
                    echo "<fieldset><legend>" . 'Search data in tables' . " <span id='selected2'></span></legend><div>", "<input type='search' name='query' value='" . h($_POST["query"]) . "'>", script("qsl('input').onkeydown = partialArg(bodyKeydown, 'search');", ""), " <input type='submit' name='search' value='" . 'Search' . "'>\n", "</div></fieldset>\n";
                    if ($_POST["search"] && $_POST["query"] != "") {
                        $_GET["where"][0]["op"] = "LIKE %%";
                        search_tables();
                    }
                }
                echo "<div class='scrollable'>\n", "<table cellspacing='0' class='nowrap checkable'>\n", script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"), '<thead><tr class="wrap">', '<td><input id="check-all" type="checkbox" class="jsonly">' . script("qs('#check-all').onclick = partial(formCheck, /^(tables|views)\[/);", ""), '<th>' . 'Table', '<td>' . 'Engine' . doc_link(array('sql' => 'storage-engines.html')), '<td>' . 'Collation' . doc_link(array('sql' => 'charset-charsets.html', 'mariadb' => 'supported-character-sets-and-collations/')), '<td>' . 'Data Length' . doc_link(array('sql' => 'show-table-status.html', 'pgsql' => 'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT', 'oracle' => 'REFRN20286')), '<td>' . 'Index Length' . doc_link(array('sql' => 'show-table-status.html', 'pgsql' => 'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT')), '<td>' . 'Data Free' . doc_link(array('sql' => 'show-table-status.html')), '<td>' . 'Auto Increment' . doc_link(array('sql' => 'example-auto-increment.html', 'mariadb' => 'auto_increment/')), '<td>' . 'Rows' . doc_link(array('sql' => 'show-table-status.html', 'pgsql' => 'catalog-pg-class.html#CATALOG-PG-CLASS', 'oracle' => 'REFRN20286')), (support("comment") ? '<td>' . 'Comment' . doc_link(array('sql' => 'show-table-status.html', 'pgsql' => 'functions-info.html#FUNCTIONS-INFO-COMMENT-TABLE')) : ''), "</thead>\n";
                $S = 0;
                foreach ($Sh
                         as $D => $T) {
                    $Wi = ($T !== null && !preg_match('~table~i', $T));
                    $u = h("Table-" . $D);
                    echo '<tr' . odd() . '><td>' . checkbox(($Wi ? "views[]" : "tables[]"), $D, in_array($D, $Th, true), "", "", "", $u), '<th>' . (support("table") || support("indexes") ? "<a href='" . h(ME) . "table=" . urlencode($D) . "' title='" . 'Show structure' . "' id='$u'>" . h($D) . '</a>' : h($D));
                    if ($Wi) {
                        echo '<td colspan="6"><a href="' . h(ME) . "view=" . urlencode($D) . '" title="' . 'Alter view' . '">' . (preg_match('~materialized~i', $T) ? 'Materialized view' : 'View') . '</a>', '<td align="right"><a href="' . h(ME) . "select=" . urlencode($D) . '" title="' . 'Select data' . '">?</a>';
                    } else {
                        foreach (array("Engine" => array(), "Collation" => array(), "Data_length" => array("create", 'Alter table'), "Index_length" => array("indexes", 'Alter indexes'), "Data_free" => array("edit", 'New item'), "Auto_increment" => array("auto_increment=1&create", 'Alter table'), "Rows" => array("select", 'Select data'),) as $z => $A) {
                            $u = " id='$z-" . h($D) . "'";
                            echo($A ? "<td align='right'>" . (support("table") || $z == "Rows" || (support("indexes") && $z != "Data_length") ? "<a href='" . h(ME . "$A[0]=") . urlencode($D) . "'$u title='$A[1]'>?</a>" : "<span$u>?</span>") : "<td id='$z-" . h($D) . "'>");
                        }
                        $S++;
                    }
                    echo(support("comment") ? "<td id='Comment-" . h($D) . "'>" : "");
                }
                echo "<tr><td><th>" . sprintf('%d in total', count($Sh)), "<td>" . h($y == "sql" ? $f->result("SELECT @@default_storage_engine") : ""), "<td>" . h(db_collation(DB, collations()));
                foreach (array("Data_length", "Index_length", "Data_free") as $z) echo "<td align='right' id='sum-$z'>";
                echo "</table>\n", "</div>\n";
                if (!information_schema(DB)) {
                    echo "<div class='footer'><div>\n";
                    $Qi = "<input type='submit' value='" . 'Vacuum' . "'> " . on_help("'VACUUM'");
                    $uf = "<input type='submit' name='optimize' value='" . 'Optimize' . "'> " . on_help($y == "sql" ? "'OPTIMIZE TABLE'" : "'VACUUM OPTIMIZE'");
                    echo "<fieldset><legend>" . 'Selected' . " <span id='selected'></span></legend><div>" . ($y == "sqlite" ? $Qi : ($y == "pgsql" ? $Qi . $uf : ($y == "sql" ? "<input type='submit' value='" . 'Analyze' . "'> " . on_help("'ANALYZE TABLE'") . $uf . "<input type='submit' name='check' value='" . 'Check' . "'> " . on_help("'CHECK TABLE'") . "<input type='submit' name='repair' value='" . 'Repair' . "'> " . on_help("'REPAIR TABLE'") : ""))) . "<input type='submit' name='truncate' value='" . 'Truncate' . "'> " . on_help($y == "sqlite" ? "'DELETE'" : "'TRUNCATE" . ($y == "pgsql" ? "'" : " TABLE'")) . confirm() . "<input type='submit' name='drop' value='" . 'Drop' . "'>" . on_help("'DROP TABLE'") . confirm() . "\n";
                    $j = (support("scheme") ? $b->schemas() : $b->databases());
                    if (count($j) != 1 && $y != "sqlite") {
                        $k = (isset($_POST["target"]) ? $_POST["target"] : (support("scheme") ? $_GET["ns"] : DB));
                        echo "<p>" . 'Move to other database' . ": ", ($j ? html_select("target", $j, $k) : '<input name="target" value="' . h($k) . '" autocapitalize="off">'), " <input type='submit' name='move' value='" . 'Move' . "'>", (support("copy") ? " <input type='submit' name='copy' value='" . 'Copy' . "'> " . checkbox("overwrite", 1, $_POST["overwrite"], 'overwrite') : ""), "\n";
                    }
                    echo "<input type='hidden' name='all' value=''>";
                    echo
                    script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^(tables|views)\[/));" . (support("table") ? " selectCount('selected2', formChecked(this, /^tables\[/) || $S);" : "") . " }"), "<input type='hidden' name='token' value='$mi'>\n", "</div></fieldset>\n", "</div></div>\n";
                }
                echo "</form>\n", script("tableCheck();");
            }
            echo '<p class="links"><a href="' . h(ME) . 'create=">' . 'Create table' . "</a>\n", (support("view") ? '<a href="' . h(ME) . 'view=">' . 'Create view' . "</a>\n" : "");
            if (support("routine")) {
                echo "<h3 id='routines'>" . 'Routines' . "</h3>\n";
                $Ug = routines();
                if ($Ug) {
                    echo "<table cellspacing='0'>\n", '<thead><tr><th>' . 'Name' . '<td>' . 'Type' . '<td>' . 'Return type' . "<td></thead>\n";
                    odd('');
                    foreach ($Ug
                             as $J) {
                        $D = ($J["SPECIFIC_NAME"] == $J["ROUTINE_NAME"] ? "" : "&name=" . urlencode($J["ROUTINE_NAME"]));
                        echo '<tr' . odd() . '>', '<th><a href="' . h(ME . ($J["ROUTINE_TYPE"] != "PROCEDURE" ? 'callf=' : 'call=') . urlencode($J["SPECIFIC_NAME"]) . $D) . '">' . h($J["ROUTINE_NAME"]) . '</a>', '<td>' . h($J["ROUTINE_TYPE"]), '<td>' . h($J["DTD_IDENTIFIER"]), '<td><a href="' . h(ME . ($J["ROUTINE_TYPE"] != "PROCEDURE" ? 'function=' : 'procedure=') . urlencode($J["SPECIFIC_NAME"]) . $D) . '">' . 'Alter' . "</a>";
                    }
                    echo "</table>\n";
                }
                echo '<p class="links">' . (support("procedure") ? '<a href="' . h(ME) . 'procedure=">' . 'Create procedure' . '</a>' : '') . '<a href="' . h(ME) . 'function=">' . 'Create function' . "</a>\n";
            }
            if (support("sequence")) {
                echo "<h3 id='sequences'>" . 'Sequences' . "</h3>\n";
                $ih = get_vals("SELECT sequence_name FROM information_schema.sequences WHERE sequence_schema = current_schema() ORDER BY sequence_name");
                if ($ih) {
                    echo "<table cellspacing='0'>\n", "<thead><tr><th>" . 'Name' . "</thead>\n";
                    odd('');
                    foreach ($ih
                             as $X) echo "<tr" . odd() . "><th><a href='" . h(ME) . "sequence=" . urlencode($X) . "'>" . h($X) . "</a>\n";
                    echo "</table>\n";
                }
                echo "<p class='links'><a href='" . h(ME) . "sequence='>" . 'Create sequence' . "</a>\n";
            }
            if (support("type")) {
                echo "<h3 id='user-types'>" . 'User types' . "</h3>\n";
                $Oi = types();
                if ($Oi) {
                    echo "<table cellspacing='0'>\n", "<thead><tr><th>" . 'Name' . "</thead>\n";
                    odd('');
                    foreach ($Oi
                             as $X) echo "<tr" . odd() . "><th><a href='" . h(ME) . "type=" . urlencode($X) . "'>" . h($X) . "</a>\n";
                    echo "</table>\n";
                }
                echo "<p class='links'><a href='" . h(ME) . "type='>" . 'Create type' . "</a>\n";
            }
            if (support("event")) {
                echo "<h3 id='events'>" . 'Events' . "</h3>\n";
                $K = get_rows("SHOW EVENTS");
                if ($K) {
                    echo "<table cellspacing='0'>\n", "<thead><tr><th>" . 'Name' . "<td>" . 'Schedule' . "<td>" . 'Start' . "<td>" . 'End' . "<td></thead>\n";
                    foreach ($K
                             as $J) {
                        echo "<tr>", "<th>" . h($J["Name"]), "<td>" . ($J["Execute at"] ? 'At given time' . "<td>" . $J["Execute at"] : 'Every' . " " . $J["Interval value"] . " " . $J["Interval field"] . "<td>$J[Starts]"), "<td>$J[Ends]", '<td><a href="' . h(ME) . 'event=' . urlencode($J["Name"]) . '">' . 'Alter' . '</a>';
                    }
                    echo "</table>\n";
                    $Dc = $f->result("SELECT @@event_scheduler");
                    if ($Dc && $Dc != "ON") echo "<p class='error'><code class='jush-sqlset'>event_scheduler</code>: " . h($Dc) . "\n";
                }
                echo '<p class="links"><a href="' . h(ME) . 'event=">' . 'Create event' . "</a>\n";
            }
            if ($Sh) echo
            script("ajaxSetHtml('" . js_escape(ME) . "script=db');");
        }
    }
}
page_footer();