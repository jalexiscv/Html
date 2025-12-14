<?php
/**
 * @var string $id
 * @var string $oid
 * @var string $reference
 * @var string $default_image
 * @var int $viewport_width
 * @var int $viewport_height
 * @var int $boundary_width
 * @var int $boundary_height
 * @var string $type
 * @var string $url
 * @var string $fieldName
 * @var string $csrfName
 * @var string $csrfHash
 */
?>

<!-- Field Display -->
<img src="<?= $default_image ?>" id="profile-pic-<?= $id ?>" class="img-fluid" alt="">
<div class="croppie-input-group input-group">
    <input type="hidden" id="<?= $id ?>" name="<?= $id ?>">
    <input type="file" class="croppie-file-input file-input" id="<?= $id ?>-cropper" name="<?= $id ?>-cropper" hidden />
    <button type="button" class="btn croppie-btn-file btn-file-<?= $id ?>">
        <i class="bi <?= ICON_ATTACH_FILE ?>"></i>
    </button>
</div>

<!-- Modal -->
<div class="modal fade bg-light" id="croppie-modal-<?= $id ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= lang("App.crop-image-and-upload") ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-0 bgc-blue-l4">
                <div id="resizer-<?= $id ?>"></div>
            </div>
            <div class="modal-footer justify-content-center">
                <a class="btn btn-secondary rotate-<?= $id ?> float-lef" data-deg="90"><i class="fas fa-undo"></i></a>
                <a class="btn btn-secondary rotate-<?= $id ?> float-right" data-deg="-90"><i class="fas fa-redo"></i></i></a>
                <a id="croppie-upload-<?= $id ?>" class="btn btn-danger "><?= lang("App.crop-and-upload") ?></a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const id = "<?= $id ?>";
        const oid = "<?= $oid ?>";
        const uploadUrl = "<?= $url ?>";
        const csrfName = "<?= $csrfName ?>";
        const csrfHash = "<?= $csrfHash ?>";
        const fieldName = "<?= $fieldName ?>";
        const reference = "<?= $reference ?>";
        
        const fileInput = document.getElementById(`${id}-cropper`);
        const uploadBtn = document.getElementById(`croppie-upload-${id}`);
        const modalElement = document.getElementById(`croppie-modal-${id}`);
        const resizer = document.getElementById(`resizer-${id}`);
        const profilePic = document.getElementById(`profile-pic-${id}`);
        const resultInput = document.getElementById(id);
        
        let croppieInstance = null;
        let modal = null;

        // Trigger file input
        const btnFile = document.querySelector(`.btn-file-${id}`);
        if(btnFile){
             btnFile.addEventListener('click', () => {
                fileInput.click();
            });
        }

        // Helper: Base64 to Blob (Singleton check)
        if (typeof window.base64ImageToBlob === 'undefined') {
            window.base64ImageToBlob = function(str) {
                const pos = str.indexOf(';base64,');
                const type = str.substring(5, pos);
                const b64 = str.substr(pos + 8);
                const imageContent = atob(b64);
                const buffer = new ArrayBuffer(imageContent.length);
                const view = new Uint8Array(buffer);
                for (let n = 0; n < imageContent.length; n++) {
                    view[n] = imageContent.charCodeAt(n);
                }
                return new Blob([buffer], { type: type });
            };
        }

        // Helper: Read Image
        const readFile = (input) => {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if(croppieInstance) {
                        croppieInstance.bind({ url: e.target.result });
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        };

        // Initialize Croppie on Modal Show (or just bind it)
        if(fileInput){
            fileInput.addEventListener('change', function(event) {
                if (!modal) {
                    modal = new bootstrap.Modal(modalElement);
                }
                modal.show();
                
                // Delay init to ensure modal is visible for correct calculation
                setTimeout(() => {
                    if (!croppieInstance) {
                        croppieInstance = new Croppie(resizer, {
                            viewport: {
                                width: <?= $viewport_width ?>,
                                height: <?= $viewport_height ?>,
                                type: '<?= $type ?>'
                            },
                            boundary: {
                                width: <?= $boundary_width ?>,
                                height: <?= $boundary_height ?>
                            },
                            enableZoom: true,
                            mouseWheelZoom: 'ctrl',
                            showZoomer: true,
                            enableOrientation: true,
                            enableExif: true,
                            enforceBoundary: true
                        });
                    }
                    readFile(event.target);
                }, 200);
            });
        }

        // Rotate
        document.querySelectorAll(`.rotate-${id}`).forEach(btn => {
            btn.addEventListener('click', function() {
                if (croppieInstance) {
                    croppieInstance.rotate(parseInt(this.dataset.deg));
                }
            });
        });

        // Upload
        if(uploadBtn){
            uploadBtn.addEventListener('click', function() {
                if (!croppieInstance) return;

                croppieInstance.result('base64').then(function(base64) {
                    modal.hide();
                    profilePic.src = "/themes/assets/images/preloader.gif";

                    const formData = new FormData();
                    formData.append(csrfName, csrfHash);
                    formData.append("field", "attachment");
                    formData.append("object", oid);
                    formData.append("reference", reference);
                    formData.append(fieldName, window.base64ImageToBlob(base64));

                    fetch(uploadUrl, {
                        method: 'POST',
                        body: formData
                    })
                    .then(r => r.text())
                    .then(response => {
                        if (response === "error") {
                            profilePic.src = "/themes/assets/images/empty-720x480.png";
                        } else {
                            profilePic.src = base64;
                            resultInput.value = response;
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        profilePic.src = "/themes/assets/images/empty-720x480.png";
                    });
                });
            });
        }

        // Cleanup
        if(modalElement){
            modalElement.addEventListener('hidden.bs.modal', function() {
                if (croppieInstance) {
                    croppieInstance.destroy();
                    croppieInstance = null;
                }
                fileInput.value = ''; // Reset input
            });
        }
    });
</script>
