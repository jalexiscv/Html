<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

    <title>Plupload - Custom example</title>

    <!-- production -->
    <script type="text/javascript" src="../plupload/plupload.full.min.js"></script>


    <!-- debug
    <script type="text/javascript" src="../js/moxie.js"></script>
    <script type="text/javascript" src="../js/plupload.dev.js"></script>
    -->

</head>
<body style="font: 13px Verdana; background: #eee; color: #333">

<h1>Custom example</h1>

<p>Shows you how to use the core plupload API.</p>

<div id="filelist">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
<br/>

<div id="container">
    <a id="pickfiles" href="javascript:;">[Select files]</a>
    <a id="uploadfiles" href="javascript:;">[Upload files]</a>
</div>

<br/>
<pre id="console"></pre>


<script type="text/javascript">
    // Custom example logic

    var uploader = new plupload.Uploader({
        runtimes: 'html5,flash,silverlight,html4',
        browse_button: 'pickfiles', // you can pass an id...
        container: document.getElementById('container'), // ... or DOM Element itself
        url: 'upload.php',
        flash_swf_url: '../js/Moxie.swf',
        silverlight_xap_url: '../js/Moxie.xap',
        chunk_size: '1000kb',
        max_retries: 10,
        filters: {
            max_file_size: '1000mb',
            mime_types: [
                {title: "Image files", extensions: "jpg,gif,png"},
                {title: "Archivos de video", extensions: "mp4,avi,mov,wmv,flv"},
                {title: "Zip files", extensions: "zip"}
            ]
        },

        init: {
            PostInit: function () {
                document.getElementById('filelist').innerHTML = '';
                document.getElementById('uploadfiles').onclick = function () {
                    uploader.start();
                    return false;
                };
            },

            FilesAdded: function (up, files) {
                plupload.each(files, function (file) {
                    var name = "<div class=\"col-6\">" + file.name + "</div>";
                    var size = "<div class=\"col-6\" id=\"size\">" + plupload.formatSize(file.size) + "</div>";
                    var info = "<div id=\"" + file.id + "\" class=\"row\">" + name + size + "</div>";
                    document.getElementById('filelist').innerHTML += info;
                });
            },

            UploadProgress: function (up, file) {
                document.getElementById(file.id).getElementsById('size')[0].innerHTML = '<span>' + file.percent + "%</span>";
            },

            Error: function (up, err) {
                document.getElementById('console').appendChild(document.createTextNode("\nError #" + err.code + ": " + err.message));
            }
        }
    });
    uploader.init();
</script>
</body>
</html>
