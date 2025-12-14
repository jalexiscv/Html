<form id="form-modal-tab-profile-update" name="form-modal-tab-profile-update" class="form" novalidate="" method="POST">
    <input type="hidden" name="mup-action" value="update-content">
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>{lang("App.Firstname")}</label>
                        <input
                                class="form-control"
                                type="text"
                                placeholder="{lang("App.Firstname")}"
                                {if (isset($firstname))}
                                    value="{urldecode($firstname)}"
                                {/if}
                                id="mu-firstname"
                                name="mu-firstname"
                        >
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>{lang("App.Lastname")}</label>
                        <input
                                class="form-control"
                                type="text"
                                placeholder="{lang("App.Lastname")}"
                                {if (isset($lastname))}
                                    value="{urldecode($lastname)}"
                                {/if}
                                id="mu-lastname"
                                name="mu-lastname"
                        >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>{lang("App.Email")}</label>
                        <input
                                class="form-control"
                                type="email"
                                placeholder="user@example.com"
                                {if (isset($email))}
                                    value="{urldecode($email)}"
                                {/if}
                                id="mu-email"
                                name="mu-email"
                        >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <div class="form-group"><label>{lang("App.About")}</label>
                        <textarea
                                class="form-control"
                                rows="5"
                                placeholder="My Bio"
                                id="mu-about"
                                name="mu-about"
                        >
                            {if (isset($about))}
                                {urldecode($about)}
                            {/if}
                        </textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div id="mu-success" class="alert alert-success d-flex align-items-center visually-hidden" role="alert">
                <i class="fa-sharp fa-regular fa-shield-check mx-3"></i>
                <div>
                    Perfil actualizado, exitosamente!
                </div>
            </div>
            <div id="mu-warning" class="alert alert-warning d-flex align-items-center visually-hidden" role="alert">
                <i class="fa-sharp fa-regular fa-brake-warning mx-3"></i>
                <div>
                    No se pudo actualizar el perfil!
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col d-flex justify-content-end">
            <button id="btn-profile-update"
                    class="btn btn-primary"
                    type="button"
                    onclick="update_user_fields('{$user}');"
            >
                {lang("App.Update")}
            </button>
        </div>
    </div>
</form>
<script>
    document.addEventListener('DOMContentLoaded', function () {


        function load_profile_{$user}() {
            console.log('Inicializando perfil...');
            var container = document.getElementById('modal-profile-body');
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function (e) {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = xhr.response;
                    var json = JSON.parse(response);
                    var mufirstname = document.getElementById("mu-firstname");
                    var mulastname = document.getElementById("mu-lastname");
                    var muemail = document.getElementById("mu-email");
                    var muabout = document.getElementById("mu-about");
                    mufirstname.value = json.content.firstname;
                    mulastname.value = json.content.lastname;
                    muemail.value = json.content.email;
                    muabout.value = json.content.about;
                }
            }
            xhr.open("GET", '/security/api/profile/{$user}', true);
            xhr.setRequestHeader('Content-type', 'application/application/json');
            xhr.send();
        }

        load_profile_{$user}();
    });
</script>