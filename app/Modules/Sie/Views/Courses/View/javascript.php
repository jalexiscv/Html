<?php
$course = $oid;
?>
<script>
    // Student data array - will be populated from API
    let studentsData = [];
    let searchTimeout = null; // For debouncing search requests

    // Sample data structure for demonstration
    const sampleStudents = [
        {
            id: 1,
            cedula: '12345678',
            nombre: 'Juan Pérez',
            email: 'juan.perez@email.com',
            telefono: '555-0001',
            photo: '/themes/assets/images/profile-portrait.png'
        },
        {
            id: 2,
            cedula: '87654321',
            nombre: 'María García',
            email: 'maria.garcia@email.com',
            telefono: '555-0002',
            photo: '/themes/assets/images/profile-portrait.png'
        },
        {
            id: 3,
            cedula: '11223344',
            nombre: 'Carlos López',
            email: 'carlos.lopez@email.com',
            telefono: '555-0003',
            photo: '/themes/assets/images/profile-portrait.png'
        },
        {
            id: 4,
            cedula: '44332211',
            nombre: 'Ana Martínez',
            email: 'ana.martinez@email.com',
            telefono: '555-0004',
            photo: '/themes/assets/images/profile-portrait.png'
        },
        {
            id: 5,
            cedula: '55667788',
            nombre: 'Luis Rodríguez',
            email: 'luis.rodriguez@email.com',
            telefono: '555-0005',
            photo: '/themes/assets/images/profile-portrait.png'
        }
    ];

    // Initialize modal when document is ready
    document.addEventListener('DOMContentLoaded', function () {
        // Create modal HTML structure
        createStudentModal();

        // Initialize event listeners
        initializeEventListeners();

        // Load sample data (replace with API call)
        loadStudentData();
    });

    // Create the Bootstrap 5 modal HTML structure
    function createStudentModal() {
        const modalHTML = `
        <!-- Student Selection Modal -->
        <div class="modal fade" id="studentSelectionModal" tabindex="-1" aria-labelledby="studentSelectionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="studentSelectionModalLabel">
                            <i class="fas fa-user-graduate me-2"></i>Posibles Inscripciones
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Search Input -->
                        <div class="mb-3">
                            <label for="studentSearch" class="form-label">Buscar por Cédula:</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" class="form-control" id="studentSearch" 
                                       placeholder="Ingrese la cédula del estudiante..." 
                                       autocomplete="off">
                                <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="form-text">Escriba para filtrar los resultados en tiempo real</div>
                        </div>
                        
                        <!-- Loading Indicator -->
                        <div id="loadingIndicator" class="text-center py-3 d-none">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <p class="mt-2 text-muted">Cargando estudiantes...</p>
                        </div>
                        
                        <!-- No Results Message -->
                        <div id="noResultsMessage" class="alert alert-info d-none" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            No se encontraron estudiantes que coincidan con la búsqueda.
                        </div>
                        
                        <!-- Students List -->
                        <div id="studentsList" class="student-list">
                            <!-- Students will be populated here -->
                        </div>
                        
                        <!-- Results Counter -->
                        <div class="mt-3">
                            <small class="text-muted">
                                Mostrando <span id="resultsCount">0</span> estudiante(s)
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </button>
                        <button type="button" class="btn btn-primary" id="selectStudentBtn" disabled>
                            <i class="fas fa-check me-1"></i>Inscribir al Curso
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Custom Styles -->
        <style>
            .student-list {
                max-height: 400px;
                overflow-y: auto;
                border: 1px solid #dee2e6;
                border-radius: 0.375rem;
            }
            
            .student-item {
                padding: 12px 16px;
                border-bottom: 1px solid #f8f9fa;
                cursor: pointer;
                transition: all 0.2s ease;
                background: white;
            }
            
            .student-item:hover {
                background-color: #f8f9fa;
                transform: translateX(2px);
            }
            
            .student-item.selected {
                background-color: #e3f2fd;
                border-left: 4px solid #2196f3;
            }
            
            .student-item:last-child {
                border-bottom: none;
            }
            
            .student-profile-container {
                display: flex;
                align-items: center;
                gap: 12px;
            }
            
            .student-photo {
                flex-shrink: 0;
            }
            
            .profile-img {
                width: 50px;
                height: 50px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid #e0e0e0;
                transition: border-color 0.2s ease;
            }
            
            .student-item:hover .profile-img {
                border-color: #2196f3;
            }
            
            .student-item.selected .profile-img {
                border-color: #1976d2;
                box-shadow: 0 0 0 2px rgba(33, 150, 243, 0.2);
            }
            
            .student-info {
                flex: 1;
                min-width: 0;
            }
            
            .student-cedula {
                font-weight: 600;
                color: #1976d2;
                font-size: 1.1em;
                margin-bottom: 2px;
            }
            
            .student-name {
                font-weight: 500;
                color: #333;
                margin-bottom: 4px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            
            .student-details {
                font-size: 0.85em;
                color: #666;
                line-height: 1.4;
            }
            
            .highlight {
                background-color: #fff3cd;
                padding: 1px 2px;
                border-radius: 2px;
                font-weight: 600;
            }
            
            .modal-lg {
                max-width: 800px;
            }
            
            .input-group-text {
                background-color: #f8f9fa;
                border-color: #ced4da;
            }
            
            #studentSearch:focus {
                border-color: #86b7fe;
                box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            }
            
            .btn-close-white {
                filter: invert(1) grayscale(100%) brightness(200%);
            }
        </style>
    `;

        // Append modal to body
        document.body.insertAdjacentHTML('beforeend', modalHTML);
    }

    // Initialize event listeners
    function initializeEventListeners() {
        // Header-add button click event
        const headerAddBtn = document.getElementById('header-add');
        if (headerAddBtn) {
            headerAddBtn.addEventListener('click', function () {
                showStudentModal();
            });
        }

        // Search input event with debounce
        document.addEventListener('input', function (e) {
            if (e.target.id === 'studentSearch') {
                const searchTerm = e.target.value;

                // Clear previous timeout
                if (searchTimeout) {
                    clearTimeout(searchTimeout);
                }

                // Set new timeout for debounced search
                searchTimeout = setTimeout(() => {
                    searchStudentsRealTime(searchTerm);
                }, 300); // Wait 300ms after user stops typing
            }
        });

        // Clear search button
        document.addEventListener('click', function (e) {
            if (e.target.id === 'clearSearch' || e.target.closest('#clearSearch')) {
                document.getElementById('studentSearch').value = '';
                // Clear any pending search timeout
                if (searchTimeout) {
                    clearTimeout(searchTimeout);
                }
                // Load all students (no search)
                searchStudentsRealTime('');
            }
        });

        // Student selection
        document.addEventListener('click', function (e) {
            if (e.target.closest('.student-item')) {
                selectStudent(e.target.closest('.student-item'));
            }
        });

        // Select button click
        document.addEventListener('click', function (e) {
            if (e.target.id === 'selectStudentBtn') {
                confirmStudentSelection();
            }
        });

        // Modal events
        const modal = document.getElementById('studentSelectionModal');
        if (modal) {
            modal.addEventListener('shown.bs.modal', function () {
                document.getElementById('studentSearch').focus();
            });

            modal.addEventListener('hidden.bs.modal', function () {
                resetModal();
            });
        }
    }

    // Show student modal
    function showStudentModal() {
        const modal = new bootstrap.Modal(document.getElementById('studentSelectionModal'));
        modal.show();

        // Refresh data when modal opens
        loadStudentData();
    }

    // Load initial student data from API (without search)
    async function loadStudentData() {
        try {
            showLoading(true);

            // Get course ID from PHP variable
            const courseId = '<?php echo $course; ?>';

            // Make API call without search parameter for initial load
            const response = await fetch(`/sie/api/students/json/cantakecourse/${courseId}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            studentsData = data.students || data; // Handle different response formats

            // Fallback to sample data if API returns empty or fails
            if (!studentsData || studentsData.length === 0) {
                console.warn('No students returned from API, using sample data');
                studentsData = sampleStudents;
            }

            showLoading(false);
            renderStudents(studentsData);

        } catch (error) {
            console.error('Error loading student data:', error);
            showLoading(false);

            // Use sample data as fallback
            console.warn('Using sample data due to API error');
            studentsData = sampleStudents;
            renderStudents(studentsData);

            // Optionally show error message
            // showError('Error al cargar los datos de estudiantes. Mostrando datos de ejemplo.');
        }
    }

    // Real-time search function that calls API
    async function searchStudentsRealTime(searchTerm) {
        try {
            // Show loading indicator for search
            showSearchLoading(true);

            // Get course ID from PHP variable
            const courseId = '<?php echo $course; ?>';

            // Build URL with search parameter
            let apiUrl = `/sie/api/students/json/cantakecourse/${courseId}`;
            if (searchTerm && searchTerm.trim() !== '') {
                // Add search parameter to URL
                apiUrl += `?search=${encodeURIComponent(searchTerm.trim())}`;
            }

            // Make API call with search parameter
            const response = await fetch(apiUrl, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            const searchResults = data.students || data; // Handle different response formats

            showSearchLoading(false);

            // If no search term, use all data, otherwise use search results
            if (!searchTerm || searchTerm.trim() === '') {
                studentsData = searchResults || sampleStudents;
                renderStudents(studentsData);
            } else {
                // Render search results with highlighting
                renderStudents(searchResults || [], searchTerm);
            }

        } catch (error) {
            console.error('Error searching students:', error);
            showSearchLoading(false);

            // Fallback to local filtering if API fails
            console.warn('API search failed, falling back to local filtering');
            filterStudentsLocally(searchTerm);
        }
    }

    // Local filter function (fallback when API fails)
    function filterStudentsLocally(searchTerm) {
        const filteredStudents = studentsData.filter(student =>
            student.cedula.toLowerCase().includes(searchTerm.toLowerCase()) ||
            student.nombre.toLowerCase().includes(searchTerm.toLowerCase())
        );

        renderStudents(filteredStudents, searchTerm);
    }

    // Legacy filter function for backward compatibility
    function filterStudents(searchTerm) {
        // Now uses real-time search instead of local filtering
        searchStudentsRealTime(searchTerm);
    }

    // Render students list
    function renderStudents(students, searchTerm = '') {
        const studentsList = document.getElementById('studentsList');
        const resultsCount = document.getElementById('resultsCount');
        const noResultsMessage = document.getElementById('noResultsMessage');

        resultsCount.textContent = students.length;

        if (students.length === 0) {
            studentsList.innerHTML = '';
            noResultsMessage.classList.remove('d-none');
            return;
        }

        noResultsMessage.classList.add('d-none');

        const studentsHTML = students.map(student => {
            const highlightedCedula = highlightText(student.cedula, searchTerm);
            const highlightedName = highlightText(student.nombre, searchTerm);
            const photoUrl = student.photo || '/themes/assets/images/profile-portrait.png';

            return `
            <div class="student-item" data-student-id="${student.id}">
                <div class="student-profile-container">
                    <div class="student-photo">
                        <img src="${photoUrl}" alt="Foto de ${student.nombre}" class="profile-img" 
                             onerror="this.src='/themes/assets/images/profile-portrait.png'">
                    </div>
                    <div class="student-info">
                        <div class="student-cedula">${highlightedCedula}</div>
                        <div class="student-name">${highlightedName}</div>
                        <div class="student-details">
                            <i class="fas fa-id-card me-1"></i>Matrícula: ${student.enrollment || 'N/A'}
                            ${student.email ? `| <i class="fas fa-envelope me-1"></i>${student.email}` : ''}
                            ${student.telefono ? `| <i class="fas fa-phone me-1"></i>${student.telefono}` : ''}
                        </div>
                    </div>
                </div>
            </div>
        `;
        }).join('');

        studentsList.innerHTML = studentsHTML;
    }

    // Highlight search term in text
    function highlightText(text, searchTerm) {
        if (!searchTerm) return text;

        const regex = new RegExp(`(${searchTerm})`, 'gi');
        return text.replace(regex, '<span class="highlight">$1</span>');
    }

    // Select a student
    function selectStudent(studentElement) {
        // Remove previous selection
        document.querySelectorAll('.student-item.selected').forEach(item => {
            item.classList.remove('selected');
        });

        // Add selection to clicked item
        studentElement.classList.add('selected');

        // Enable select button
        document.getElementById('selectStudentBtn').disabled = false;
    }

    // Confirm student selection
    function confirmStudentSelection() {
        const selectedItem = document.querySelector('.student-item.selected');
        if (!selectedItem) return;

        const studentId = selectedItem.dataset.studentId;
        const selectedStudent = studentsData.find(s => s.id == studentId);

        if (selectedStudent) {
            // Get course ID from PHP variable
            const courseId = '<?php echo $course; ?>';

            // Build URL for course execution with student parameter
            const executionUrl = `/sie/courses/execution/${courseId}?registration=${selectedStudent.id}&progress=${selectedStudent.progress}`;

            // Redirect to course execution page
            window.location.href = executionUrl;

            // Note: Modal will close automatically when page redirects
        }
    }

    // Callback function when student is selected (customize as needed)
    function onStudentSelected(student) {
        console.log('Student selected:', student);

        // TODO: Implement your logic here
        // Example: Fill form fields, update UI, etc.
        alert(`Estudiante seleccionado:\nCédula: ${student.cedula}\nNombre: ${student.nombre}`);
    }

    // Show/hide loading indicator
    function showLoading(show) {
        const loadingIndicator = document.getElementById('loadingIndicator');
        const studentsList = document.getElementById('studentsList');

        if (show) {
            loadingIndicator.classList.remove('d-none');
            studentsList.style.display = 'none';
        } else {
            loadingIndicator.classList.add('d-none');
            studentsList.style.display = 'block';
        }
    }

    // Show/hide search loading (lighter loading for searches)
    function showSearchLoading(show) {
        const studentsList = document.getElementById('studentsList');

        if (show) {
            // Add a subtle loading overlay to the students list
            studentsList.style.opacity = '0.6';
            studentsList.style.pointerEvents = 'none';

            // Add loading text if list is empty
            if (studentsList.children.length === 0) {
                studentsList.innerHTML = `
                <div class="text-center py-3 text-muted">
                    <i class="fas fa-search fa-spin me-2"></i>
                    Buscando estudiantes...
                </div>
            `;
            }
        } else {
            studentsList.style.opacity = '1';
            studentsList.style.pointerEvents = 'auto';
        }
    }

    // Show error message
    function showError(message) {
        const studentsList = document.getElementById('studentsList');
        studentsList.innerHTML = `
        <div class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            ${message}
        </div>
    `;
    }

    // Reset modal to initial state
    function resetModal() {
        document.getElementById('studentSearch').value = '';
        document.getElementById('selectStudentBtn').disabled = true;
        document.querySelectorAll('.student-item.selected').forEach(item => {
            item.classList.remove('selected');
        });
        document.getElementById('noResultsMessage').classList.add('d-none');
    }

    // API integration function (replace with your actual API endpoint)
    async function fetchStudentsFromAPI(courseId = null) {
        try {
            // Use the course ID from PHP if not provided
            const course = courseId || '<?php echo $course; ?>';

            const response = await fetch(`/sie/api/students/json/cantakecourse/${course}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            return data.students || data; // Handle different response formats
        } catch (error) {
            console.error('API Error:', error);
            throw error;
        }
    }

    // Delegación de eventos para botones dinámicos
    document.addEventListener('click', function (e) {
        if (e.target && e.target.matches('button[data-value]')) {
            const dataValue = e.target.getAttribute('data-value');
            const dataType = e.target.getAttribute('data-type');
            let dataMessage = dataType;

            if (dataType === "enrollment") {
                dataMessage = "Está visualizando el <b>código de matrícula</b> del estudiante";
            } else if (dataType === "progress") {
                dataMessage = "Está visualizando el <b>código del progreso del estudiante</b>, se denomina de esta forma al código asignado al módulo que deberá cursar el estudiante mediante ejecuciones para obtener el título académico relacionado.";
            } else if (dataType === "execution") {
                dataMessage = "Está visualizando el <b>código de ejecución</b> del estudiante, se denomina de esta forma a cada curso realizado como intento para aprobar un progreso dentro del pensum de la matrícula específica de un estudiante.";
            }
            const modal = new bootstrap.Modal(document.getElementById('infoModal'));
            document.getElementById('modalDataValue').innerHTML = dataValue;
            document.getElementById('modalDataMessage').innerHTML = dataMessage;
            modal.show();
        }
    });



</script>
