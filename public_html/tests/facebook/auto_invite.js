// Función para obtener un tiempo aleatorio entre clicks (entre 1 y 3 segundos)
function getRandomDelay() {
    return Math.floor(Math.random() * (1000 - 1000 + 1)) + 1000;
}

// Variable global para el contador de invitaciones
let invitationCount = 0;

// Función para actualizar el contador en la UI
function updateCounterDisplay() {
    const counter = document.getElementById('invitation-counter');
    if (counter) {
        counter.textContent = `Invitaciones enviadas: ${invitationCount}`;
    }
}

// Función para encontrar y hacer clic en los botones de invitar
async function clickInviteButtons() {
    // Buscar todos los botones que contienen el texto "Invitar" y tienen la clase específica de Facebook
    const buttons = Array.from(document.querySelectorAll('div[role="button"].x1i10hfl')).filter(
        button => button.textContent.includes('Invitar')
    );

    // Si no hay botones, hacer scroll y verificar nuevamente
    if (buttons.length === 0) {
        window.scrollBy(0, window.innerHeight);
        // Esperar un momento para que cargue el nuevo contenido
        await new Promise(resolve => setTimeout(resolve, 1500));
        clickInviteButtons(); // Llamada recursiva
        return;
    }

    console.log(`Encontrados ${buttons.length} botones de invitar`);

    // Hacer clic en cada botón con un retraso aleatorio
    for (const button of buttons) {
        await new Promise(resolve => setTimeout(resolve, getRandomDelay()));
        try {
            button.click();
            invitationCount++;
            updateCounterDisplay();
            console.log(`Click realizado en botón de invitar. Total: ${invitationCount}`);
        } catch (error) {
            console.error('Error al hacer click:', error);
        }
    }

    // Después de procesar todos los botones visibles, hacer scroll y continuar
    window.scrollBy(0, window.innerHeight);
    await new Promise(resolve => setTimeout(resolve, 500));
    clickInviteButtons(); // Llamada recursiva
}

// Función principal que inicia el proceso
function startAutoInvite() {
    console.log('Iniciando proceso de invitaciones automáticas...');
    clickInviteButtons();
}

// Función para inicializar el botón de control y el contador
function initializeControlButton() {
    // Verificar si el botón ya existe
    let existingButton = document.getElementById('auto-invite-button');
    if (existingButton) {
        return existingButton;
    }

    // Crear el contenedor para el botón y el contador
    const container = document.createElement('div');
    container.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 10px;
    `;

    // Crear el botón
    const button = document.createElement('button');
    button.id = 'auto-invite-button';
    button.textContent = 'Iniciar Auto-Invitar';
    button.style.cssText = `
        padding: 10px 20px;
        background-color: #1877f2;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-family: Helvetica, Arial, sans-serif;
        font-size: 14px;
        font-weight: bold;
    `;

    // Crear el contador
    const counter = document.createElement('div');
    counter.id = 'invitation-counter';
    counter.style.cssText = `
        padding: 8px 16px;
        background-color: #ffffff;
        color: #1877f2;
        border: 2px solid #1877f2;
        border-radius: 6px;
        font-family: Helvetica, Arial, sans-serif;
        font-size: 14px;
        font-weight: bold;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    `;
    counter.textContent = 'Invitaciones enviadas: 0';

    // Agregar el evento click al botón
    button.addEventListener('click', () => {
        if (button.textContent === 'Iniciar Auto-Invitar') {
            invitationCount = 0; // Reiniciar contador al iniciar
            updateCounterDisplay();
            button.textContent = 'Detener Auto-Invitar';
            button.style.backgroundColor = '#dc3545';
            startAutoInvite();
        } else {
            button.textContent = 'Iniciar Auto-Invitar';
            button.style.backgroundColor = '#1877f2';
            // Recargar la página para detener el proceso
            window.location.reload();
        }
    });

    // Agregar elementos al contenedor
    container.appendChild(button);
    container.appendChild(counter);

    // Agregar el contenedor al documento
    document.body.appendChild(container);
    return button;
}

// Inicializar el botón cuando se ejecute el script
initializeControlButton();
