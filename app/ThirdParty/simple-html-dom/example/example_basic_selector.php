<?php
include('../simple_html_dom.php');
$html = file_get_html('http://www.google.com/');
foreach ($html->find('a') as $e) echo $e->href . '<br>';
foreach ($html->find('img') as $e) echo $e->src . '<br>';
foreach ($html->find('img') as $e) echo $e->outertext . '<br>';
foreach ($html->find('div#gbar') as $e) echo $e->innertext . '<br>';
foreach ($html->find('span.gb1') as $e) echo $e->outertext . '<br>';
foreach ($html->find('td[align=center]') as $e) echo $e->innertext . '<br>';
echo $html->find('td[align="center"]', 1)->plaintext . '<br><hr>';
echo $html->plaintext; ?>