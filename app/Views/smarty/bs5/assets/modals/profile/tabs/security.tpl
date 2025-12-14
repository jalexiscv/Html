<form id="form-modal-tab-profile-security" name="form-modal-tab-profile-security" class="form" novalidate=""
      method="POST">
    <input type="hidden" id="mup-action-profile-security" name="mup-action-profile-security" value="update-security">
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>{lang("App.New-password")}</label>
                        <input
                                class="form-control"
                                type="password"
                                placeholder=""
                                value=""
                                id="mus-newpassword"
                                name="mus-newpassword"
                        >
                        <div class="invalid-feedback">
                            Requerido o no coincidente con la confirmación!.
                        </div>
                        <div class="valid-feedback">
                            Aceptado!
                        </div>
                    </div>
                </div>
                <div class="col mb-3">
                    <div class="form-group">
                        <label>{lang("App.Confirm-password")}</label>
                        <input
                                class="form-control"
                                type="password"
                                placeholder=""
                                value=""
                                id="mus-confirmpassword"
                                name="mus-confirmpassword"
                        >
                        <div class="invalid-feedback">
                            No coincide con la nueva contraseña!.
                        </div>
                        <div class="valid-feedback">
                            Aceptado!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div id="mus-success" class="alert alert-success d-flex align-items-center visually-hidden" role="alert">
                <i class="fa-sharp fa-regular fa-shield-check mx-3"></i>
                <div>
                    Contraseña actualizada, exitosamente!
                </div>
            </div>
            <div id="mus-warning" class="alert alert-warning d-flex align-items-center visually-hidden" role="alert">
                <i class="fa-sharp fa-regular fa-brake-warning mx-3"></i>
                <div>
                    No se pudo actualizar la contraseña!
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col d-flex justify-content-end ">
            <button id="btn-profile-update"
                    class="btn btn-primary js-Higgs-modal-profile-update-security"
                    type="button">
                {lang("App.Update")}
            </button>
        </div>
    </div>