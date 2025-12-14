<form id="form-reset" autocomplete="off" class="form-row mt-4" method="POST" accept-charset="utf-8">
    <input type="hidden" name="{$csrf_token}" value="{$csrf_hash}">
    <div class="mb-3">
        <label class="form-label">{lang("App.Email")}</label>
        <input class="form-control form-control-lg" type="email" name="mr-email" id="mr-email"
               placeholder="{lang("App.Email")}">
        <div class="invalid-feedback">
            Incorrecto o no registrado!.
        </div>
        <div class="valid-feedback">
            Usuario existente!
        </div>
    </div>

    <div class="text-right mt-3">
        <button type="submit" id="submit_reset" class="btn btn-primary">{lang("Security.modal-btn-reset")}</button>
        <button type="button" id="cancel" class="btn btn-secondary" data-bs-toggle="modal" data-bs-dismiss="modal"
                data-bs-target="#modalsession">Cancelar
        </button>

    </div>
</form>
<div id="mr-success" class="text-center lh-6   d-none">
    <i class="far fa-engine-warning fa-4x mb-3 animated rotateIn color-success"></i>
    <br>
    {lang("Security.modal-reset-success-message")}
</div>
{literal}
    <script>

        $(document).ready(function () {
            $("#form-reset").submit(function (event) {
                console.log("enviando...");
                event.stopPropagation();
                event.preventDefault();
                var form = $(event.target);
                var data = form.serialize();
                $.ajax({
                    'url': "/security/api/reset/" + Date.now(),
                    'method': "POST",
                    'dataType': "json",
                    'data': data,
                    'success': function (response) {
                        var user = response.messages.user;
                        var error = response.error;
                        var status = response.messages.status;
                        if (error == false && user != null && user.length > 0) {
                            console.log(response);
                            $('#form-reset').addClass("d-none").removeClass("is-valid");
                            $('#mr-success').removeClass("d-none");
                        } else {
                            if (status == "e01") {
                                console.log("Usuario desconocido!");
                                $('#mr-email').addClass("is-invalid").removeClass("is-valid");
                            } else if (status == "e02") {
                                console.log("Faltan datos!");
                                $('#mr-email').addClass("is-invalid").removeClass("is-invalid");
                            }
                        }
                    }
                });
            });
        });

    </script>
{/literal}