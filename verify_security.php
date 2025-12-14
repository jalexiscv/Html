<?php
require __DIR__ . '/vendor/autoload.php';

use Higgs\Html\Html;
use Higgs\Html\HtmlTag;

// 1. Test XSS Protection
echo "Testing XSS Protection...\n";
$unsafe = '<script>alert("xss")</script>';
$tag = Html::div([], $unsafe);
$rendered = (string)$tag;

if (strpos($rendered, '&lt;script&gt;') !== false) {
    echo "[PASS] Content was escaped: " . $rendered . "\n";
} else {
    echo "[FAIL] Content was NOT escaped: " . $rendered . "\n";
    exit(1);
}

// 2. Test Serialization
echo "\nTesting Serialization...\n";
$original = Html::div(['class' => 'test'], 'content');
$serialized = serialize($original);
$unserialized = unserialize($serialized);

if ((string)$original === (string)$unserialized) {
    echo "[PASS] Serialization round-trip successful.\n";
} else {
    echo "[FAIL] Serialization mismatch.\n";
    var_dump($original, $unserialized);
    exit(1);
}

// 3. Test Factory Optimization (Implicit)
echo "\nTesting Factory...\n";
$div = Html::tag('div');
if ($div instanceof \Higgs\Html\Tag\Tag) {
    echo "[PASS] Factory returned Tag instance.\n";
} else {
    echo "[FAIL] Factory returned wrong instance.\n";
    exit(1);
}
