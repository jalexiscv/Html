<div class="modal fade" id="modal-profile-photo" tabindex="-1" aria-labelledby="modal-profile-photo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Cargar nuva foto de perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="modal-profile-photo-body" class="modal-body">
                <p class="body-desc">
                    Será más fácil reconocerte si subes tu foto real. Puedes subir la imagen en JPG, GIF o formato
                    PNG. </p>


                <div class="row">
                    <div class="col ">
                        <label for="file-citizenshipcard">Archivo adjunto de imagen de la cédula de ciudadanía</label>:
                        <div class="input-group">
                            <input class="form-control"
                                   type="file"
                                   id="profile-photo"
                                   name="profile-photo"
                                   value=""
                                   onchange="console.log(this.files[0].name);"
                            >
                        </div>
                        <div class="help-block">Generalmente una imagen en JPG, GIF, BMP o PDF</div>
                    </div>
                </div>


                <div class="photo-input text-center">
                    <button class="btn btn-primary" onclick="modal_ProfilePhoto_{$user}();" type="button">Cargar
                        archivo
                    </button>
                </div>

                <p class="footer-title">Si tiene problemas para cargar, intente elegir una foto más pequeña.</p>
            </div>
            <div class="modal-footer">
                <div id="profile-photo-progressbar" class="progress-bar progress-bar-striped bg-success"
                     role="progressbar"
                     style="width: 0%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
</div>

<script>
    function modal_ProfilePhoto_{$user}() {
        var container = document.getElementById('modal-profile-photo-body');
        var html = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        const image_files = document.getElementById('profile-photo').files;
        if (image_files.length) {
            let formData = new FormData();
            formData.append('attachment', image_files[0]);
            let xhr = new XMLHttpRequest();
            xhr.open("POST", '/security/api/uploader/photo/{$user}', true);
            xhr.addEventListener("progress", function (e) {
                container.innerHTML = html;
                if (e.lengthComputable) {
                    let percentComplete = e.loaded / e.total * 100;
                    document.getElementById("profile-photo-progressbar").style.width = percentComplete + '%';
                }
            }, false);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const data = JSON.parse(this.responseText);
                    if (data.success === 1) {
                        document.getElementById("profile-photo-progressbar").classList.remove("bg-success");
                        document.getElementById("profile-photo-progressbar").classList.add("bg-danger");
                        alert("Image Uploading failed. Try again..")
                    }
                    location.reload();
                }
            };
            xhr.send(formData);
        } else {
            alert("No image selected");
        }
    }
</script>