<?php
header("Status: 301 Moved Permanently");
header("Location: " . $facebook->login_url());
exit;
?>