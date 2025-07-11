<html>
<head>
    <script src="/templates/terminal/jquery-1.11.1.min.js" type="text/javascript"></script>
    <script src="/templates/terminal/phpquery.min.js" type="text/javascript"></script>
    <link href="/templates/terminal/phpquery.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="terminal"></div>
<script>
    jQuery(function ($, undefined) {
        $('#terminal').terminal(function (command, term) {
            term.ajax(command<?php
                if (isset($_SESSION["user"]["token"])) {
                    echo ",'" . $_SESSION["user"]["token"] . "'";
                } else echo ",''";
                ?>);
        }, {
            greetings: '',
            name: 'phpquery',
            prompt: 'PHPQuery:~$ / '
        });
    });
</script>
</body>
</html>