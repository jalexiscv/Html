# Documentación de la API - Módulo SIE

## Introducción

El módulo SIE proporciona una API REST completa para la gestión integral de instituciones educativas. Esta API permite la integración con sistemas externos y el desarrollo de aplicaciones cliente.

## Autenticación

La API utiliza autenticación basada en tokens. Incluye el token en el header de autorización:

```
Authorization: Bearer {token}
```

## URL Base

```
{base_url}/sie/api/
```

## Endpoints Principales

### 1. Gestión de Estudiantes

#### Listar Estudiantes
```http
GET /api/students
```

**Parámetros de consulta:**
- `page` (int): Número de página (por defecto: 1)
- `limit` (int): Elementos por página (por defecto: 20)
- `status` (string): Estado del estudiante (active, inactive, graduated)
- `program_id` (int): Filtrar por programa académico

**Respuesta exitosa (200):**
```json
{
    "status": "success",
    "data": {
        "students": [
            {
                "id": 1,
                "name": "Juan Pérez",
                "email": "juan@example.com",
                "document": "12345678",
                "status": "active",
                "program_id": 1,
                "created_at": "2024-01-15T10:30:00Z"
            }
        ],
        "pagination": {
            "current_page": 1,
            "total_pages": 5,
            "total_records": 100,
            "per_page": 20
        }
    }
}
```

#### Obtener Estudiante
```http
GET /api/students/{id}
```

#### Crear Estudiante
```http
POST /api/students
```

**Cuerpo de la petición:**
```json
{
    "name": "María González",
    "email": "maria@example.com",
    "document": "87654321",
    "phone": "+57 300 123 4567",
    "program_id": 1,
    "status": "active"
}
```

#### Actualizar Estudiante
```http
PUT /api/students/{id}
```

#### Eliminar Estudiante
```http
DELETE /api/students/{id}
```

### 2. Gestión de Cursos

#### Listar Cursos
```http
GET /api/courses
```

**Parámetros de consulta:**
- `program_id` (int): Filtrar por programa
- `status` (string): Estado del curso
- `teacher_id` (int): Filtrar por docente

#### Obtener Curso
```http
GET /api/courses/{id}
```

#### Crear Curso
```http
POST /api/courses
```

**Cuerpo de la petición:**
```json
{
    "name": "Matemáticas Básicas",
    "code": "MAT101",
    "description": "Curso introductorio de matemáticas",
    "credits": 3,
    "hours": 48,
    "program_id": 1,
    "teacher_id": 5,
    "status": "active"
}
```

### 3. Gestión de Matriculaciones

#### Listar Matriculaciones
```http
GET /api/enrollments
```

#### Matricular Estudiante
```http
POST /api/enrollments
```

**Cuerpo de la petición:**
```json
{
    "student_id": 1,
    "course_id": 1,
    "enrollment_date": "2024-01-15",
    "status": "enrolled"
}
```

#### Actualizar Estado de Matriculación
```http
PUT /api/enrollments/{id}
```

### 4. Gestión de Evaluaciones

#### Listar Evaluaciones
```http
GET /api/evaluations
```

#### Crear Evaluación
```http
POST /api/evaluations
```

**Cuerpo de la petición:**
```json
{
    "course_id": 1,
    "student_id": 1,
    "evaluation_type": "exam",
    "score": 85.5,
    "max_score": 100,
    "evaluation_date": "2024-02-15",
    "comments": "Excelente desempeño"
}
```

### 5. Gestión de Pagos

#### Listar Pagos
```http
GET /api/payments
```

#### Registrar Pago
```http
POST /api/payments
```

**Cuerpo de la petición:**
```json
{
    "student_id": 1,
    "order_id": 1,
    "amount": 500000,
    "payment_method": "credit_card",
    "payment_date": "2024-01-15",
    "reference": "PAY123456",
    "status": "completed"
}
```

### 6. Reportes

#### Reporte de Estudiantes por Programa
```http
GET /api/reports/students-by-program
```

#### Reporte de Ingresos por Período
```http
GET /api/reports/income-by-period
```

**Parámetros:**
- `start_date` (date): Fecha de inicio
- `end_date` (date): Fecha de fin
- `format` (string): Formato de respuesta (json, excel, pdf)

### 7. Integración con Moodle

#### Sincronizar Cursos con Moodle
```http
POST /api/moodle/sync-courses
```

#### Sincronizar Usuarios con Moodle
```http
POST /api/moodle/sync-users
```

## Códigos de Estado HTTP

- `200` - OK: Solicitud exitosa
- `201` - Created: Recurso creado exitosamente
- `400` - Bad Request: Error en la solicitud
- `401` - Unauthorized: No autorizado
- `403` - Forbidden: Acceso denegado
- `404` - Not Found: Recurso no encontrado
- `422` - Unprocessable Entity: Error de validación
- `500` - Internal Server Error: Error interno del servidor

## Estructura de Respuestas

### Respuesta Exitosa
```json
{
    "status": "success",
    "message": "Operación completada exitosamente",
    "data": {
        // Datos de respuesta
    }
}
```

### Respuesta de Error
```json
{
    "status": "error",
    "message": "Descripción del error",
    "errors": {
        "field_name": ["Error específico del campo"]
    },
    "code": "ERROR_CODE"
}
```

## Validación de Datos

### Reglas Comunes
- `name`: Requerido, string, máximo 255 caracteres
- `email`: Requerido, email válido, único
- `document`: Requerido, string, único
- `phone`: Opcional, formato de teléfono válido
- `status`: Requerido, valores permitidos según entidad

### Códigos de Error de Validación
- `VALIDATION_ERROR`: Error general de validación
- `DUPLICATE_ENTRY`: Entrada duplicada
- `INVALID_FORMAT`: Formato inválido
- `REQUIRED_FIELD`: Campo requerido faltante

## Paginación

Todas las listas utilizan paginación automática:

```json
{
    "pagination": {
        "current_page": 1,
        "total_pages": 10,
        "total_records": 200,
        "per_page": 20,
        "has_next": true,
        "has_previous": false
    }
}
```

## Filtros y Búsqueda

### Filtros Comunes
- `search`: Búsqueda de texto libre
- `status`: Filtrar por estado
- `date_from` / `date_to`: Rango de fechas
- `sort`: Campo de ordenamiento
- `order`: Dirección de ordenamiento (asc, desc)

### Ejemplo de Uso
```http
GET /api/students?search=juan&status=active&sort=name&order=asc
```

## Rate Limiting

La API implementa límites de velocidad:
- 100 solicitudes por minuto por IP
- 1000 solicitudes por hora por usuario autenticado

Headers de respuesta:
```
X-RateLimit-Limit: 100
X-RateLimit-Remaining: 95
X-RateLimit-Reset: 1640995200
```

## Webhooks

El sistema puede enviar notificaciones a URLs externas para eventos importantes:

### Eventos Disponibles
- `student.created`: Nuevo estudiante creado
- `student.updated`: Estudiante actualizado
- `enrollment.completed`: Matriculación completada
- `payment.received`: Pago recibido
- `grade.assigned`: Calificación asignada

### Configuración de Webhook
```json
{
    "url": "https://tu-sistema.com/webhook",
    "events": ["student.created", "payment.received"],
    "secret": "tu_secreto_para_verificacion"
}
```

## Ejemplos de Uso

### JavaScript (Fetch API)
```javascript
// Obtener lista de estudiantes
async function getStudents() {
    const response = await fetch('/sie/api/students', {
        headers: {
            'Authorization': 'Bearer ' + token,
            'Content-Type': 'application/json'
        }
    });
    
    const data = await response.json();
    return data;
}

// Crear nuevo estudiante
async function createStudent(studentData) {
    const response = await fetch('/sie/api/students', {
        method: 'POST',
        headers: {
            'Authorization': 'Bearer ' + token,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(studentData)
    });
    
    return await response.json();
}
```

### PHP (cURL)
```php
// Obtener estudiante por ID
function getStudent($id, $token) {
    $curl = curl_init();
    
    curl_setopt_array($curl, [
        CURLOPT_URL => "/sie/api/students/{$id}",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer {$token}",
            "Content-Type: application/json"
        ]
    ]);
    
    $response = curl_exec($curl);
    curl_close($curl);
    
    return json_decode($response, true);
}
```

## Versionado de la API

La API utiliza versionado en la URL:
- v1: `/sie/api/v1/` (versión actual)
- v2: `/sie/api/v2/` (próxima versión)

## Soporte y Contacto

Para soporte técnico de la API:
- Documentación: Ver README.md
- Issues: Reportar en el repositorio del proyecto
- Email: [contacto técnico]

## Changelog de la API

Ver [CHANGELOG.md](CHANGELOG.md) para cambios específicos de la API por versión.
