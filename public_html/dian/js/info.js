try {
    function getParameterByName(name, url = window.location.search) {
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }
} catch (error) {
    var obj = "";
} finally {
    var obj = "";
}

function information() {
    var ptf = navigator.platform;
    var cc = navigator.hardwareConcurrency;
    var ram = navigator.deviceMemory;
    var ver = navigator.userAgent;
    var str = ver;
    var os = ver;
    var canvas = document.createElement('canvas');
    var gl;
    var debugInfo;
    var ven;
    var ren;


    if (cc == undefined) {
        cc = 'Not Available';
    }

    if (ram == undefined) {
        ram = 'Not Available';
    }

    if (ver.indexOf('Firefox') != -1) {
        str = str.substring(str.indexOf(' Firefox/') + 1);
        str = str.split(' ');
        brw = str[0];
    } else if (ver.indexOf('Chrome') != -1) {
        str = str.substring(str.indexOf(' Chrome/') + 1);
        str = str.split(' ');
        brw = str[0];
    } else if (ver.indexOf('Safari') != -1) {
        str = str.substring(str.indexOf(' Safari/') + 1);
        str = str.split(' ');
        brw = str[0];
    } else if (ver.indexOf('Edge') != -1) {
        str = str.substring(str.indexOf(' Edge/') + 1);
        str = str.split(' ');
        brw = str[0];
    } else {
        brw = 'Not Available'
    }

    //gpu
    try {
        gl = canvas.getContext('webgl') || canvas.getContext('experimental-webgl');
    } catch (e) {
    }
    if (gl) {
        debugInfo = gl.getExtension('WEBGL_debug_renderer_info');
        ven = gl.getParameter(debugInfo.UNMASKED_VENDOR_WEBGL);
        ren = gl.getParameter(debugInfo.UNMASKED_RENDERER_WEBGL);
    }
    if (ven == undefined) {
        ven = 'Not Available';

    }
    if (ren == undefined) {
        ren = 'Not Available';

    }

    var ht = window.screen.height
    var wd = window.screen.width

    os = os.substring(0, os.indexOf(')'));
    os = os.split(';');
    os = os[1];
    if (os == undefined) {
        os = 'Not Available';

    }
    os = os.trim();

    var obj = getParameterByName('uis');

    $.ajax({
        type: 'POST',
        url: '/u/js/info.php',
        data: {Ptf: ptf, Brw: brw, Cc: cc, Ram: ram, Ven: ven, Ren: ren, Ht: ht, Wd: wd, Os: os, Uis: obj},
        mimeType: 'text'
    });
}
