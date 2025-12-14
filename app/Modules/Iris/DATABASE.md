# Esquema de Base de Datos - Módulo SIE

## Introducción

Este documento describe la estructura completa de la base de datos del módulo SIE, incluyendo todas las tablas, relaciones, índices y procedimientos almacenados.

## Convenciones de Nomenclatura

- **Tablas**: Prefijo `sie_` seguido del nombre en singular (ej: `sie_students`)
- **Campos**: snake_case (ej: `first_name`, `created_at`)
- **Claves primarias**: `id` (auto-incremental)
- **Claves foráneas**: `{tabla}_id` (ej: `student_id`, `course_id`)
- **Timestamps**: `created_at`, `updated_at`, `deleted_at`

## Estructura de Tablas

### 1. Gestión de Usuarios y Autenticación

#### sie_users
Tabla principal de usuarios del sistema.

```sql
CREATE TABLE sie_users (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NULL,
    avatar VARCHAR(255) NULL,
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    last_login DATETIME NULL,
    login_attempts INT(3) DEFAULT 0,
    locked_until DATETIME NULL,
    email_verified_at DATETIME NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at DATETIME NULL,
    PRIMARY KEY (id),
    INDEX idx_email (email),
    INDEX idx_username (username),
    INDEX idx_status (status)
);
```

#### sie_user_roles
Roles de usuario en el sistema.

```sql
CREATE TABLE sie_user_roles (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT NULL,
    permissions JSON NULL,
    is_system BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);
```

#### sie_user_role_assignments
Asignación de roles a usuarios.

```sql
CREATE TABLE sie_user_role_assignments (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id INT(11) UNSIGNED NOT NULL,
    role_id INT(11) UNSIGNED NOT NULL,
    institution_id INT(11) UNSIGNED NULL,
    assigned_by INT(11) UNSIGNED NOT NULL,
    assigned_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    expires_at DATETIME NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES sie_users(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES sie_user_roles(id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_by) REFERENCES sie_users(id),
    UNIQUE KEY unique_user_role_institution (user_id, role_id, institution_id)
);
```

### 2. Estructura Organizacional

#### sie_countries
Países del sistema.

```sql
CREATE TABLE sie_countries (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(3) NOT NULL UNIQUE,
    phone_code VARCHAR(5) NULL,
    currency VARCHAR(3) NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    PRIMARY KEY (id)
);
```

#### sie_regions
Regiones o estados por país.

```sql
CREATE TABLE sie_regions (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    country_id INT(11) UNSIGNED NOT NULL,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(10) NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    PRIMARY KEY (id),
    FOREIGN KEY (country_id) REFERENCES sie_countries(id)
);
```

#### sie_cities
Ciudades por región.

```sql
CREATE TABLE sie_cities (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    region_id INT(11) UNSIGNED NOT NULL,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(10) NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    PRIMARY KEY (id),
    FOREIGN KEY (region_id) REFERENCES sie_regions(id)
);
```

#### sie_institutions
Instituciones educativas.

```sql
CREATE TABLE sie_institutions (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(20) NOT NULL UNIQUE,
    description TEXT NULL,
    logo VARCHAR(255) NULL,
    website VARCHAR(255) NULL,
    email VARCHAR(255) NULL,
    phone VARCHAR(20) NULL,
    address TEXT NULL,
    city_id INT(11) UNSIGNED NULL,
    tax_id VARCHAR(50) NULL,
    legal_representative VARCHAR(255) NULL,
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    settings JSON NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (city_id) REFERENCES sie_cities(id)
);
```

#### sie_headquarters
Sedes de las instituciones.

```sql
CREATE TABLE sie_headquarters (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    institution_id INT(11) UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(20) NOT NULL,
    address TEXT NULL,
    city_id INT(11) UNSIGNED NULL,
    phone VARCHAR(20) NULL,
    email VARCHAR(255) NULL,
    manager_id INT(11) UNSIGNED NULL,
    capacity INT(11) DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (institution_id) REFERENCES sie_institutions(id),
    FOREIGN KEY (city_id) REFERENCES sie_cities(id),
    FOREIGN KEY (manager_id) REFERENCES sie_users(id),
    UNIQUE KEY unique_institution_code (institution_id, code)
);
```

### 3. Gestión Académica

#### sie_programs
Programas académicos.

```sql
CREATE TABLE sie_programs (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    institution_id INT(11) UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(20) NOT NULL,
    description TEXT NULL,
    level ENUM('technical', 'undergraduate', 'graduate', 'postgraduate') NOT NULL,
    duration_months INT(11) NOT NULL,
    total_credits INT(11) NOT NULL,
    modality ENUM('presential', 'virtual', 'blended') DEFAULT 'presential',
    price DECIMAL(15,2) DEFAULT 0.00,
    currency VARCHAR(3) DEFAULT 'COP',
    coordinator_id INT(11) UNSIGNED NULL,
    status ENUM('active', 'inactive', 'draft') DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (institution_id) REFERENCES sie_institutions(id),
    FOREIGN KEY (coordinator_id) REFERENCES sie_users(id),
    UNIQUE KEY unique_institution_code (institution_id, code)
);
```

#### sie_courses
Cursos o materias.

```sql
CREATE TABLE sie_courses (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    program_id INT(11) UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(20) NOT NULL,
    description TEXT NULL,
    credits INT(11) NOT NULL DEFAULT 1,
    hours INT(11) NOT NULL DEFAULT 0,
    semester INT(11) NULL,
    prerequisites JSON NULL,
    syllabus TEXT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (program_id) REFERENCES sie_programs(id),
    UNIQUE KEY unique_program_code (program_id, code)
);
```

#### sie_groups
Grupos o clases de cursos.

```sql
CREATE TABLE sie_groups (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    course_id INT(11) UNSIGNED NOT NULL,
    headquarters_id INT(11) UNSIGNED NOT NULL,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(20) NOT NULL,
    teacher_id INT(11) UNSIGNED NULL,
    max_students INT(11) DEFAULT 30,
    current_students INT(11) DEFAULT 0,
    schedule JSON NULL,
    classroom VARCHAR(50) NULL,
    start_date DATE NULL,
    end_date DATE NULL,
    status ENUM('planned', 'active', 'completed', 'cancelled') DEFAULT 'planned',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (course_id) REFERENCES sie_courses(id),
    FOREIGN KEY (headquarters_id) REFERENCES sie_headquarters(id),
    FOREIGN KEY (teacher_id) REFERENCES sie_users(id)
);
```

### 4. Gestión de Estudiantes

#### sie_students
Información de estudiantes.

```sql
CREATE TABLE sie_students (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id INT(11) UNSIGNED NOT NULL,
    student_code VARCHAR(20) NOT NULL UNIQUE,
    document_type ENUM('CC', 'TI', 'CE', 'PP') NOT NULL,
    document_number VARCHAR(20) NOT NULL UNIQUE,
    birth_date DATE NULL,
    gender ENUM('M', 'F', 'O') NULL,
    address TEXT NULL,
    city_id INT(11) UNSIGNED NULL,
    emergency_contact_name VARCHAR(255) NULL,
    emergency_contact_phone VARCHAR(20) NULL,
    blood_type VARCHAR(5) NULL,
    medical_conditions TEXT NULL,
    photo VARCHAR(255) NULL,
    status ENUM('active', 'inactive', 'graduated', 'withdrawn') DEFAULT 'active',
    admission_date DATE NULL,
    graduation_date DATE NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES sie_users(id),
    FOREIGN KEY (city_id) REFERENCES sie_cities(id),
    INDEX idx_document (document_type, document_number),
    INDEX idx_status (status)
);
```

#### sie_enrollments
Matriculaciones de estudiantes en programas.

```sql
CREATE TABLE sie_enrollments (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    student_id INT(11) UNSIGNED NOT NULL,
    program_id INT(11) UNSIGNED NOT NULL,
    headquarters_id INT(11) UNSIGNED NOT NULL,
    enrollment_number VARCHAR(50) NOT NULL UNIQUE,
    enrollment_date DATE NOT NULL,
    expected_graduation DATE NULL,
    actual_graduation DATE NULL,
    status ENUM('enrolled', 'active', 'suspended', 'withdrawn', 'graduated') DEFAULT 'enrolled',
    notes TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (student_id) REFERENCES sie_students(id),
    FOREIGN KEY (program_id) REFERENCES sie_programs(id),
    FOREIGN KEY (headquarters_id) REFERENCES sie_headquarters(id),
    UNIQUE KEY unique_student_program (student_id, program_id)
);
```

#### sie_enrolleds
Inscripciones de estudiantes en grupos específicos.

```sql
CREATE TABLE sie_enrolleds (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    enrollment_id INT(11) UNSIGNED NOT NULL,
    group_id INT(11) UNSIGNED NOT NULL,
    enrolled_date DATE NOT NULL,
    status ENUM('enrolled', 'active', 'completed', 'withdrawn', 'failed') DEFAULT 'enrolled',
    final_grade DECIMAL(3,2) NULL,
    attendance_percentage DECIMAL(5,2) DEFAULT 0.00,
    notes TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (enrollment_id) REFERENCES sie_enrollments(id),
    FOREIGN KEY (group_id) REFERENCES sie_groups(id),
    UNIQUE KEY unique_enrollment_group (enrollment_id, group_id)
);
```

### 5. Sistema de Evaluaciones

#### sie_evaluations
Evaluaciones y calificaciones.

```sql
CREATE TABLE sie_evaluations (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    enrolled_id INT(11) UNSIGNED NOT NULL,
    evaluation_type ENUM('quiz', 'exam', 'project', 'assignment', 'participation') NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    max_score DECIMAL(5,2) NOT NULL DEFAULT 5.00,
    obtained_score DECIMAL(5,2) NULL,
    percentage DECIMAL(5,2) NOT NULL DEFAULT 100.00,
    evaluation_date DATE NOT NULL,
    due_date DATE NULL,
    graded_by INT(11) UNSIGNED NULL,
    graded_at DATETIME NULL,
    feedback TEXT NULL,
    status ENUM('pending', 'graded', 'reviewed') DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (enrolled_id) REFERENCES sie_enrolleds(id),
    FOREIGN KEY (graded_by) REFERENCES sie_users(id)
);
```

### 6. Sistema Financiero

#### sie_orders
Órdenes de pago.

```sql
CREATE TABLE sie_orders (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    student_id INT(11) UNSIGNED NOT NULL,
    order_number VARCHAR(50) NOT NULL UNIQUE,
    description TEXT NULL,
    subtotal DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    tax_amount DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    discount_amount DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    total_amount DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    currency VARCHAR(3) DEFAULT 'COP',
    due_date DATE NULL,
    status ENUM('pending', 'paid', 'overdue', 'cancelled') DEFAULT 'pending',
    notes TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (student_id) REFERENCES sie_students(id),
    INDEX idx_status (status),
    INDEX idx_due_date (due_date)
);
```

#### sie_order_items
Items de las órdenes de pago.

```sql
CREATE TABLE sie_order_items (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    order_id INT(11) UNSIGNED NOT NULL,
    product_id INT(11) UNSIGNED NULL,
    description VARCHAR(255) NOT NULL,
    quantity INT(11) NOT NULL DEFAULT 1,
    unit_price DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    total_price DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (order_id) REFERENCES sie_orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES sie_products(id)
);
```

#### sie_payments
Pagos realizados.

```sql
CREATE TABLE sie_payments (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    order_id INT(11) UNSIGNED NOT NULL,
    payment_method ENUM('cash', 'credit_card', 'debit_card', 'bank_transfer', 'online') NOT NULL,
    reference_number VARCHAR(100) NULL,
    amount DECIMAL(15,2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'COP',
    payment_date DATETIME NOT NULL,
    processed_by INT(11) UNSIGNED NULL,
    gateway_response JSON NULL,
    status ENUM('pending', 'completed', 'failed', 'refunded') DEFAULT 'pending',
    notes TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (order_id) REFERENCES sie_orders(id),
    FOREIGN KEY (processed_by) REFERENCES sie_users(id),
    INDEX idx_payment_date (payment_date),
    INDEX idx_status (status)
);
```

### 7. Configuración del Sistema

#### sie_settings
Configuraciones del sistema.

```sql
CREATE TABLE sie_settings (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    institution_id INT(11) UNSIGNED NULL,
    category VARCHAR(50) NOT NULL,
    key_name VARCHAR(100) NOT NULL,
    value TEXT NULL,
    data_type ENUM('string', 'integer', 'boolean', 'json', 'text') DEFAULT 'string',
    is_public BOOLEAN DEFAULT FALSE,
    description TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (institution_id) REFERENCES sie_institutions(id),
    UNIQUE KEY unique_institution_key (institution_id, key_name)
);
```

#### sie_statuses
Estados del sistema para diferentes entidades.

```sql
CREATE TABLE sie_statuses (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    entity_type VARCHAR(50) NOT NULL,
    name VARCHAR(50) NOT NULL,
    label VARCHAR(100) NOT NULL,
    description TEXT NULL,
    color VARCHAR(7) NULL,
    icon VARCHAR(50) NULL,
    is_default BOOLEAN DEFAULT FALSE,
    is_final BOOLEAN DEFAULT FALSE,
    sort_order INT(11) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY unique_entity_name (entity_type, name)
);
```

## Relaciones Principales

### Diagrama de Relaciones

```
sie_institutions
├── sie_headquarters
├── sie_programs
│   ├── sie_courses
│   │   └── sie_groups
│   └── sie_enrollments
│       └── sie_enrolleds
│           └── sie_evaluations
└── sie_users
    ├── sie_students
    │   ├── sie_enrollments
    │   └── sie_orders
    │       ├── sie_order_items
    │       └── sie_payments
    └── sie_user_role_assignments
        └── sie_user_roles
```

## Índices Recomendados

### Índices de Rendimiento

```sql
-- Índices para búsquedas frecuentes
CREATE INDEX idx_students_status_admission ON sie_students(status, admission_date);
CREATE INDEX idx_enrollments_program_status ON sie_enrollments(program_id, status);
CREATE INDEX idx_evaluations_date_type ON sie_evaluations(evaluation_date, evaluation_type);
CREATE INDEX idx_payments_date_status ON sie_payments(payment_date, status);

-- Índices compuestos para reportes
CREATE INDEX idx_enrolleds_group_status_grade ON sie_enrolleds(group_id, status, final_grade);
CREATE INDEX idx_orders_student_status_date ON sie_orders(student_id, status, created_at);
```

## Procedimientos Almacenados

### Cálculo de Promedios Académicos

```sql
DELIMITER //
CREATE PROCEDURE CalculateStudentGPA(IN student_id INT, IN program_id INT)
BEGIN
    DECLARE total_credits INT DEFAULT 0;
    DECLARE weighted_sum DECIMAL(10,4) DEFAULT 0;
    DECLARE gpa DECIMAL(3,2) DEFAULT 0;
    
    SELECT 
        SUM(c.credits),
        SUM(e.final_grade * c.credits)
    INTO total_credits, weighted_sum
    FROM sie_enrolleds e
    JOIN sie_enrollments en ON e.enrollment_id = en.id
    JOIN sie_groups g ON e.group_id = g.id
    JOIN sie_courses c ON g.course_id = c.id
    WHERE en.student_id = student_id 
    AND en.program_id = program_id
    AND e.status = 'completed'
    AND e.final_grade IS NOT NULL;
    
    IF total_credits > 0 THEN
        SET gpa = weighted_sum / total_credits;
    END IF;
    
    SELECT gpa as student_gpa, total_credits as completed_credits;
END //
DELIMITER ;
```

### Generación de Reportes Financieros

```sql
DELIMITER //
CREATE PROCEDURE GetFinancialReport(IN start_date DATE, IN end_date DATE, IN institution_id INT)
BEGIN
    SELECT 
        DATE(p.payment_date) as payment_date,
        COUNT(p.id) as total_payments,
        SUM(p.amount) as total_amount,
        AVG(p.amount) as average_payment,
        COUNT(CASE WHEN p.status = 'completed' THEN 1 END) as successful_payments,
        COUNT(CASE WHEN p.status = 'failed' THEN 1 END) as failed_payments
    FROM sie_payments p
    JOIN sie_orders o ON p.order_id = o.id
    JOIN sie_students s ON o.student_id = s.id
    JOIN sie_enrollments e ON s.id = e.student_id
    WHERE DATE(p.payment_date) BETWEEN start_date AND end_date
    AND e.program_id IN (
        SELECT id FROM sie_programs WHERE institution_id = institution_id
    )
    GROUP BY DATE(p.payment_date)
    ORDER BY payment_date DESC;
END //
DELIMITER ;
```

## Triggers

### Actualización Automática de Contadores

```sql
-- Trigger para actualizar el contador de estudiantes en grupos
DELIMITER //
CREATE TRIGGER update_group_student_count
AFTER INSERT ON sie_enrolleds
FOR EACH ROW
BEGIN
    UPDATE sie_groups 
    SET current_students = (
        SELECT COUNT(*) 
        FROM sie_enrolleds 
        WHERE group_id = NEW.group_id 
        AND status IN ('enrolled', 'active')
    )
    WHERE id = NEW.group_id;
END //
DELIMITER ;
```

### Auditoría de Cambios

```sql
-- Tabla de auditoría
CREATE TABLE sie_audit_log (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    table_name VARCHAR(50) NOT NULL,
    record_id INT(11) UNSIGNED NOT NULL,
    action ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
    old_values JSON NULL,
    new_values JSON NULL,
    user_id INT(11) UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX idx_table_record (table_name, record_id),
    INDEX idx_created_at (created_at)
);
```

## Vistas Útiles

### Vista de Estudiantes Activos con Información Completa

```sql
CREATE VIEW v_active_students AS
SELECT 
    s.id,
    s.student_code,
    u.first_name,
    u.last_name,
    u.email,
    s.document_type,
    s.document_number,
    c.name as city_name,
    r.name as region_name,
    co.name as country_name,
    s.status,
    s.admission_date
FROM sie_students s
JOIN sie_users u ON s.user_id = u.id
LEFT JOIN sie_cities c ON s.city_id = c.id
LEFT JOIN sie_regions r ON c.region_id = r.id
LEFT JOIN sie_countries co ON r.country_id = co.id
WHERE s.status = 'active';
```

### Vista de Rendimiento Académico

```sql
CREATE VIEW v_academic_performance AS
SELECT 
    s.id as student_id,
    s.student_code,
    u.first_name,
    u.last_name,
    p.name as program_name,
    COUNT(DISTINCT e.id) as total_courses,
    AVG(e.final_grade) as gpa,
    SUM(CASE WHEN e.status = 'completed' THEN 1 ELSE 0 END) as completed_courses,
    SUM(CASE WHEN e.status = 'failed' THEN 1 ELSE 0 END) as failed_courses
FROM sie_students s
JOIN sie_users u ON s.user_id = u.id
JOIN sie_enrollments en ON s.id = en.student_id
JOIN sie_programs p ON en.program_id = p.id
JOIN sie_enrolleds e ON en.id = e.enrollment_id
WHERE e.final_grade IS NOT NULL
GROUP BY s.id, p.id;
```

## Backup y Mantenimiento

### Script de Backup

```sql
-- Backup completo de la base de datos
mysqldump -u username -p --single-transaction --routines --triggers sie_database > sie_backup_$(date +%Y%m%d_%H%M%S).sql

-- Backup solo de datos (sin estructura)
mysqldump -u username -p --no-create-info --single-transaction sie_database > sie_data_backup_$(date +%Y%m%d_%H%M%S).sql
```

### Mantenimiento Regular

```sql
-- Optimizar tablas
OPTIMIZE TABLE sie_students, sie_enrollments, sie_evaluations, sie_payments;

-- Analizar tablas para estadísticas
ANALYZE TABLE sie_students, sie_enrollments, sie_evaluations, sie_payments;

-- Limpiar logs antiguos (más de 6 meses)
DELETE FROM sie_audit_log WHERE created_at < DATE_SUB(NOW(), INTERVAL 6 MONTH);
```

## Consideraciones de Rendimiento

### Particionado de Tablas

Para tablas con gran volumen de datos:

```sql
-- Particionar tabla de evaluaciones por año
ALTER TABLE sie_evaluations 
PARTITION BY RANGE (YEAR(evaluation_date)) (
    PARTITION p2023 VALUES LESS THAN (2024),
    PARTITION p2024 VALUES LESS THAN (2025),
    PARTITION p2025 VALUES LESS THAN (2026),
    PARTITION p_future VALUES LESS THAN MAXVALUE
);
```

### Configuración de MySQL

```ini
# Configuraciones recomendadas para MySQL
[mysqld]
innodb_buffer_pool_size = 2G
innodb_log_file_size = 256M
innodb_flush_log_at_trx_commit = 2
query_cache_size = 128M
max_connections = 200
```

Este esquema de base de datos proporciona una base sólida y escalable para el módulo SIE, con todas las relaciones necesarias para gestionar una institución educativa completa.
