<?php
error_reporting(E_ALL);
include_once('../simple_html_dom.php');
function dump_memory($init_size)
{
    $peak = number_format(memory_get_peak_usage() / 1024, 0, '.', ',');
    $curr = number_format(memory_get_usage() / 1024, 0, '.', ',');
    $diff = $curr - $init_size;
    echo 'peak: ' . $peak . ' kb, end: ' . $curr . ' kb, add: ' . $diff . " kb<br>";
}

$filename = './html/google.htm';
function test_load_file_memory($filename, $init_size)
{
    echo '[load file] init memory: ' . number_format(memory_get_usage() / 1024, 0, '.', ',') . '<br>';
    echo '--------------------------------------------------------------------<br>';
    flush();
    for ($i = 0; $i < 3; ++$i) {
        $str = file_get_contents($filename);
        dump_memory($init_size);
        unset($str);
    }
    echo 'after loop: ' . number_format(memory_get_usage(), 0, '.', ',') . '<br>';
    echo '--------------------------------------------------------------------<br>';
    flush();
}

function test_multi_str_get_html($filename, $init_size)
{
    global $__g_node_mgr;
    $str = file_get_contents($filename);
    echo '[str_get_html] init memory: ' . number_format(memory_get_usage() / 1024, 0, '.', ',') . '<br>';
    echo '--------------------------------------------------------------------<br>';
    flush();
    for ($i = 0; $i < 3; ++$i) {
        $html = str_get_html($str);
        dump_memory($init_size);
        flush();
    }
    echo 'after loop: ' . number_format(memory_get_usage(), 0, '.', ',') . '<br>';
    echo '--------------------------------------------------------------------<br>';
    flush();
    unset($str);
}

function test_multi_file_get_html($filename, $init_size)
{
    echo '[file_get_html] init memory: ' . number_format(memory_get_usage() / 1024, 0, '.', ',') . '<br>';
    echo '--------------------------------------------------------------------<br>';
    flush();
    for ($i = 0; $i < 3; ++$i) {
        $html = file_get_html($filename);
        unset($html);
        dump_memory($init_size);
        flush();
    }
    echo 'after loop: ' . number_format(memory_get_usage(), 0, '.', ',') . '<br>';
    echo '--------------------------------------------------------------------<br>';
    flush();
}

$init_size = number_format(memory_get_usage(), 0, '.', ',');
echo 'init ' . $init_size . " bytes<br>";
flush();
echo '<br>before function: ' . number_format(memory_get_usage() / 1024, 0, '.', ',') . '<br>';
test_load_file_memory($filename, $init_size);
echo 'after function: ' . number_format(memory_get_usage() / 1024, 0, '.', ',') . '<br><br>';
flush();
echo '<br>before function: ' . number_format(memory_get_usage() / 1024, 0, '.', ',') . '<br>';
test_multi_file_get_html($filename, $init_size);
echo 'after function: ' . number_format(memory_get_usage() / 1024, 0, '.', ',') . '<br><br>';
flush();
echo '<br>before function: ' . number_format(memory_get_usage() / 1024, 0, '.', ',') . '<br>';
test_multi_file_get_html($filename, $init_size);
echo 'after function: ' . number_format(memory_get_usage() / 1024, 0, '.', ',') . '<br><br>';
flush(); ?>