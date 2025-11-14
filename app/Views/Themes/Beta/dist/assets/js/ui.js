export function Ui() {
    function render(oid) {
        alert('Renderizando UI');
    }


    function openModalViewer(url) {
        // Crea el elemento modal
        const modal = document.createElement('div');
        modal.classList.add('modal', 'fade');
        modal.setAttribute('tabindex', '-1');
        modal.setAttribute('aria-labelledby', 'modalLabel');
        modal.setAttribute('aria-hidden', 'true');

        // Crea el contenido del modal
        const modalDialog = document.createElement('div');
        modalDialog.classList.add('modal-dialog', 'modal-lg');
        const modalContent = document.createElement('div');
        modalContent.classList.add('modal-content');

        // Crea el encabezado del modal
        const modalHeader = document.createElement('div');
        modalHeader.classList.add('modal-header');
        const modalTitle = document.createElement('h5');
        modalTitle.classList.add('modal-title');
        modalTitle.setAttribute('id', 'modalLabel');
        modalTitle.textContent = 'Visor de contenido';
        const closeButton = document.createElement('button');
        closeButton.classList.add('btn-close');
        closeButton.setAttribute('type', 'button');
        closeButton.setAttribute('data-bs-dismiss', 'modal');
        closeButton.setAttribute('aria-label', 'Close');

        // Crea el cuerpo del modal
        const modalBody = document.createElement('div');
        modalBody.classList.add('modal-body');
        const iframe = document.createElement('iframe');
        iframe.setAttribute('src', url);
        iframe.setAttribute('frameborder', '0');
        iframe.setAttribute('width', '100%');
        iframe.setAttribute('height', '600');

        // Agregar elementos al modal
        modalHeader.appendChild(modalTitle);
        modalHeader.appendChild(closeButton);
        modalBody.appendChild(iframe);
        modalContent.appendChild(modalHeader);
        modalContent.appendChild(modalBody);
        modalDialog.appendChild(modalContent);
        modal.appendChild(modalDialog);

        // Agregar el modal al documento
        document.body.appendChild(modal);

        // Mostrar el modal
        const modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();
    }


    return {
        render: render,
        openModalViewer: openModalViewer
    };

}