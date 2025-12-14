<?php

$fid = pk();


?>


<form id="form-<?php echo($fid); ?>">
    <input type="hidden" name="submited" value="<?php echo($fid); ?>">
    <div class="row mb-2">
        <div class="col-4">
            <label class="form-label" for="start-region">Orden</label>
            <select id="orden-<?php echo($fid); ?>" name="orden-<?php echo($fid); ?>" class="form-select" required>
                <option value="nacional" selected>Nacional</option>
                <option value="territorial">Territorial</option>
            </select>
            <div class="invalid-feedback">
                Seleccione una!.
            </div>
            <div class="valid-feedback">
                Validado
            </div>
        </div>
        <div class="col-4">
            <label class="form-label" for="start-region">Departamento</label>
            <select id="region-<?php echo($fid); ?>" name="region-<?php echo($fid); ?>" class="form-select" required>
                <option selected>...</option>
            </select>
            <div class="invalid-feedback">
                Seleccione una!.
            </div>
            <div class="valid-feedback">
                Validado
            </div>
        </div>
        <div class="col-4">
            <label class="form-label" for="start-city">Municipio</label>
            <select id="city-<?php echo($fid); ?>" name="city-<?php echo($fid); ?>" class="form-select" required>
                <option selected>...</option>
            </select>
            <div class="invalid-feedback">
                Seleccione una!.
            </div>
            <div class="valid-feedback">
                Validado
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-end">
            <button id="submit" type="submit" class="btn btn-primary float-end">Consultar</button>
        </div>
    </div>
</form>


<script async>
    $(document).ready(function () {
        var country = "CO";
        var region = $("#region-<?php echo($fid);?>");
        var city = $("#city-<?php echo($fid);?>");
        regions_<?php echo($fid);?>();

        function regions_<?php echo($fid);?>() {
            $.ajax({
                data: {"country": country},
                url: '/fleet/api/regions/json/list/' + Date.now(),
                type: 'POST',
                dataType: 'json',
                beforeSend: function () {
                    region.prop('disabled', true);
                    city.prop('disabled', true);
                },
                success: function (response) {
                    region.prop('disabled', false);
                    city.prop('disabled', false);
                    region.find('option').remove();
                    city.find('option').remove();
                    region.append('<option value="00">Seleccione un departamento</option>');
                    $(response).each(function (i, v) {
                        region.append('<option value="' + v.value + '">' + v.label + '</option>');
                    })
                },
                error: function () {
                    console.log('Ocurrió un error en el servidor ..');
                }
            });
        }

        $("#region-<?php echo($fid);?>").change(function () {
            cities_<?php echo($fid);?>();
        });


        function cities_<?php echo($fid);?>() {
            $.ajax({
                data: {"region": region.val()},
                url: '/fleet/api/cities/json/list/' + Date.now(),
                type: 'POST',
                dataType: 'json',
                beforeSend: function () {
                    city.prop('disabled', true);
                },
                success: function (response) {
                    city.prop('disabled', false);
                    city.find('option').remove();
                    city.append('<option value="00">Seleccione un municipio</option>');
                    $(response).each(function (i, v) {
                        city.append('<option value="' + v.value + '">' + v.label + '</option>');
                    })
                },
                error: function () {
                    console.log('Ocurrió un error en el servidor ..');
                }
            });
        }


    });
</script>
