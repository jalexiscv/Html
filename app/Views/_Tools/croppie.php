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
<div class="position-relative d-inline-block">
    <img src="<?= $default_image ?>" id="profile-pic-<?= $id ?>" class="img-fluid rounded shadow-sm" alt="Profile Picture" style="max-width: 100%; height: auto;">
    
    <div class="croppie-input-group">
        <input type="hidden" id="<?= $id ?>" name="<?= $id ?>">
        <input type="file" class="croppie-file-input file-input" id="<?= $id ?>-cropper" name="<?= $id ?>-cropper" hidden />
        
        <button type="button" class="btn btn-light btn-sm position-absolute top-0 end-0 m-2 shadow rounded-circle btn-file-<?= $id ?>" title="<?= lang("App.change-photo") ?>">
            <i class="fas fa-camera text-dark"></i>
        </button>
    </div>
</div>

<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="croppie-modal-<?= $id ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg">
            <div class="modal-header py-2">
                <h6 class="modal-title fw-bold"><?= lang("App.crop-image-and-upload") ?></h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 bg-dark d-flex justify-content-center align-items-center" style="min-height: 400px;">
                <div id="resizer-<?= $id ?>"></div>
            </div>
            <div class="modal-footer py-2 justify-content-between bg-light">
                <div class="d-flex">
                    <div class="btn-group me-2" role="group">
                        <button type="button" class="btn btn-outline-secondary rotate-<?= $id ?>" data-deg="90" title="Rotate Left">
                            <i class="fas fa-undo"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary rotate-<?= $id ?>" data-deg="-90" title="Rotate Right">
                            <i class="fas fa-redo"></i>
                        </button>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-secondary zoom-out-<?= $id ?>" title="Zoom Out">
                            <i class="fas fa-search-minus"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary zoom-in-<?= $id ?>" title="Zoom In">
                            <i class="fas fa-search-plus"></i>
                        </button>
                    </div>
                </div>
                <button id="croppie-upload-<?= $id ?>" class="btn btn-primary px-4">
                    <i class="fas fa-cloud-upload-alt me-2"></i><?= lang("App.crop-and-upload") ?>
                </button>
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
        
        // Output dimensions
        const outputWidth = <?= $output_width ? $output_width : 'null' ?>;
        const outputHeight = <?= $output_height ? $output_height : 'null' ?>;

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
                            showZoomer: false, // Hide default slider
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

        // Zoom Buttons
        const zoomStep = 0.1;
        const btnZoomIn = document.querySelector(`.zoom-in-${id}`);
        const btnZoomOut = document.querySelector(`.zoom-out-${id}`);

        if(btnZoomIn) {
            btnZoomIn.addEventListener('click', () => {
                if(croppieInstance) {
                    let info = croppieInstance.get();
                    croppieInstance.setZoom(info.zoom + zoomStep);
                }
            });
        }

        if(btnZoomOut) {
            btnZoomOut.addEventListener('click', () => {
                if(croppieInstance) {
                    let info = croppieInstance.get();
                    croppieInstance.setZoom(info.zoom - zoomStep);
                }
            });
        }

        // Upload
        if(uploadBtn){
            uploadBtn.addEventListener('click', function() {
                if (!croppieInstance) return;

                let resultOptions = { type: 'base64' };
                if (outputWidth && outputHeight) {
                    resultOptions.size = { width: outputWidth, height: outputHeight };
                } else {
                    resultOptions.size = 'viewport';
                }

                croppieInstance.result(resultOptions).then(function(base64) {
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
