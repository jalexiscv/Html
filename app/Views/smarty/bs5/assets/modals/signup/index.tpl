<form id="form-signup" class="row g-2 needs-validation" method="POST" novalidate>
    <div class="col-md-6">
        <label for="su-firstname" class="form-label">{lang("App.Firstname")}</label>
        <input type="text" class="form-control" id="su-firstname" name="su-firstname" required>
        <div class="valid-feedback">
            Validado
        </div>
    </div>
    <div class="col-md-6">
        <label for="su-lastname" class="form-label">{lang("App.Lastname")}</label>
        <input type="text" class="form-control" id="su-lastname" name="su-lastname" required>
        <div class="valid-feedback">
            Validado
        </div>
    </div>
    <div class="col-md-6">
        <label for="su-email" class="form-label">{lang("App.Email")}</label>
        <input type="email" class="form-control" id="su-email" name="su-email" required>
        <div class="invalid-feedback">
            Incorrecto o registrado por otro usuario!.
        </div>
        <div class="valid-feedback">
            Validado
        </div>
    </div>


    <div class="col-md-6">
        <label for="su-phone" class="form-label">{lang("App.Phone")}</label>
        <input type="text" class="form-control" id="su-phone" name="su-phone" required>
        <div class="valid-feedback">
            Validado
        </div>
    </div>


    <div class="col-12">
        <label for="su-address" class="form-label">{lang("App.Address")}</label>
        <input type="text" class="form-control" id="su-address" name="su-address" required>
        <div class="valid-feedback">
            Validado
        </div>
    </div>


    <div class="col-md-6">
        <label for="su-password" class="form-label">{lang("App.Password")}</label>
        <input type="password" class="form-control" id="su-password" name="su-password" required>
        <div class="valid-feedback">
            Validado
        </div>
    </div>

    <div class="col-md-6">
        <label for="su-confirm" class="form-label">{lang("App.Confirm")}</label>
        <input type="password" class="form-control" id="su-confirm" name="su-confirm" required>
        <div class="valid-feedback">Coincide con la contraseña</div>
        <div class="invalid-feedback">No coincide con la contraseña</div>
    </div>

    <div class="col-12 align-right">
        <button id="btn-form-submit" type="button" onclick="signup_submit();" class="btn btn-primary">Continuar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    </div>
</form>
<script>

    function removeAll(selectBox) {
        while (selectBox.options.length > 0) {
            selectBox.remove(0);
        }
    }

    function signup_submit() {
        console.log('signup submit');
        var vfirstname = noEmpty("firstname");
        var vlastname = noEmpty("lastname");
        var vemail = noEmpty("email");
        var vphone = noEmpty("phone");
        var vaddress = noEmpty("address");
        var vpassword = noEmpty("password");
        var vconfirm = fieldEquals("password", "confirm");
        var url = "/security/api/signup/" + Date.now();
        var token = localStorage.getItem("token");
        var hash = localStorage.getItem("hash");
        //if (vfirstname == true && vlastname == true&& vemail == true && vphone == true&& vaddress == true && vpassword == true&& vconfirm == true) {
        let formData = new FormData();
        formData.append('su-firstname', getFieldValue('firstname'));
        formData.append('su-lastname', getFieldValue('lastname'));
        formData.append('su-email', getFieldValue('email'));
        formData.append('su-phone', getFieldValue('phone'));
        formData.append('su-address', getFieldValue('address'));
        formData.append('su-password', getFieldValue('password'));
        var xhr = new XMLHttpRequest();
        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 400) {
                console.log(xhr.responseText);
                var formsignup = document.getElementById('form-signup');
                formsignup.classList.add("d-none");
                var signupsuccess = document.getElementById('signup-success');
                signupsuccess.classList.remove("d-none");
                //location.reload();
            } else {
                console.error('Error en la solicitud: ' + xhr.status);
            }
        };
        xhr.onerror = function () {
            console.error('Error de red');
        };
        xhr.open("POST", url);
        xhr.send(formData);
        //} else {

        //}
    }


    function getFieldValue(name) {
        var namefield = "su-" + name;
        var value = null;
        if (!!document.getElementById(namefield)) {
            var element = document.getElementById(namefield);
            value = element.value;
            console.log(namefield + "=" + value);
        }
        return (value);
    }

    function fieldEquals(password, confirm) {
        var fpassword = document.getElementById('su-' + password);
        var fconfirm = document.getElementById('su-' + confirm);
        var vpassword = getFieldValue("password");
        var vconfirm = getFieldValue("confirm");
        if (vpassword != vconfirm) {
            fconfirm.classList.add("is-valid");
            fconfirm.classList.remove("is-invalid");
            return (false);
        } else {
            fconfirm.classList.add("is-invalid");
            fconfirm.classList.remove("is-valid");
            return (true);
        }
    }

    function noEmpty(name) {
        console.log('noEmpty-' + field);
        var field = document.getElementById('su-' + name);
        val = getFieldValue(name);
        if (val != null && val.length > 3) {
            field.classList.add("is-valid");
            field.classList.remove("is-invalid");
            return (true);
        } else {
            field.classList.add("is-invalid");
            field.classList.remove("is-valid");
            return (false);
        }
    }

</script>