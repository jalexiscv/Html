<?php
include_once('../../simple_html_dom.php');
function scraping_slashdot()
{
    $html = file_get_html('http://slashdot.org/');
    foreach ($html->find('div[id^=firehose-]') as $article) {
        $item['title'] = trim($article->find('a.datitle', 0)->plaintext);
        $item['body'] = trim($article->find('div.body', 0)->plaintext);
        $ret[] = $item;
    }
    $html->clear();
    unset($html);
    return $ret;
}

$ret = scraping_slashdot();
foreach ($ret as $v) {
    echo $v['title'] . '<br>';
    echo '<ul>';
    echo '<li>' . $v['body'] . '</li>';
    echo '</ul>';
} ?>