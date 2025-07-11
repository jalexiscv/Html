<!DOCTYPE html>
<html lang="en">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#000000">

    <video width="640" height="360" controls>
        <source src="<?php echo htmlspecialchars($_POST['foo1']); ?>" type="video/mp4">
        Tu navegador no soporta HTML5 video.
    </video>


    </body>
</html>

