<?php
header("Status: 301 Moved Permanently");
header("Location: " . $facebook->logout_url());
exit;
?>