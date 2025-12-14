<?php
$vendorDir = dirname(__DIR__);
$baseDir = dirname($vendorDir);
return array('ci4mongodblibrary\\' => array($baseDir . '/app'), 'Symfony\\Polyfill\\Php80\\' => array($vendorDir . '/symfony/polyfill-php80'), 'MongoDB\\' => array($vendorDir . '/mongodb/mongodb/src'), 'Jean85\\' => array($vendorDir . '/jean85/pretty-package-versions/src'),);