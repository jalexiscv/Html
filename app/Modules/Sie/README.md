# SIE - Sistema Integral Educativo

## Descripción del Sistema

Nuestro software como servicio (SaaS) constituye una plataforma revolucionaria de gestión integrada, diseñada específicamente para atender las necesidades multifacéticas de instituciones educativas de vanguardia. Este avanzado sistema en la nube optimiza meticulosamente todos los aspectos de la gestión académica, administrativa y el entorno de aprendizaje virtual, al mismo tiempo que impulsa el crecimiento sostenible y mejora la rentabilidad de su organización.

Al fusionar la accesibilidad con la excelencia operativa, nuestro software ofrece una interfaz intuitiva y soluciones personalizables que se adaptan a la visión única de cada institución. Desde la inscripción y matriculación de estudiantes hasta el seguimiento detallado del rendimiento académico y administración eficiente de recursos, nuestra solución integral promueve un ecosistema académico fluido y cohesivo.

## Características Principales

- **Gestión Académica Integral**: Administración completa de cursos, estudiantes, docentes y programas académicos
- **Plataforma de Aprendizaje Virtual**: Entorno educativo digital optimizado para la enseñanza y el aprendizaje
- **Administración Eficiente**: Herramientas avanzadas para la gestión administrativa y operativa
- **Análisis y Reportes**: Seguimiento detallado del rendimiento académico y métricas institucionales
- **Soluciones Personalizables**: Adaptación flexible a las necesidades específicas de cada institución
- **Interfaz Intuitiva**: Diseño centrado en el usuario para facilitar la adopción y uso diario

## Módulos del Sistema

El sistema SIE está estructurado en diversos módulos especializados que cubren todas las áreas de gestión educativa, incluyendo:

- Gestión de Estudiantes y Matriculación
- Administración de Cursos y Programas
- Evaluaciones y Certificaciones
- Gestión de Costos y Facturación
- Reportes y Análisis
- Administración de Usuarios y Permisos

## Estructura del Módulo

El módulo SIE sigue la arquitectura MVC (Modelo-Vista-Controlador) de Higgs7 y está organizado de la siguiente manera:

### 📁 Directorios Principales

```
Sie/
├── Config/                 # Configuración del módulo (2 archivos)
│   ├── Constants.php      # Constantes del sistema
│   └── Routes.php         # Definición de rutas
├── Controllers/           # Controladores (48 archivos)
├── Models/               # Modelos de datos (44 archivos)
├── Views/                # Vistas y templates (47 directorios)
├── Language/             # Archivos de idioma
│   └── es/              # Traducciones en español (39 archivos)
├── Helpers/              # Funciones auxiliares (2 archivos)
│   ├── Sie_helper.php   # Funciones generales del sistema
│   └── Sie_Excel_helper.php # Funciones para manejo de Excel
├── Database/
│   └── Migrations/       # Migraciones de base de datos
├── README.md             # Documentación del módulo
└── HIGGS7.md            # Guía de desarrollo con Higgs7
```

### 🎮 Controladores Principales

Los controladores están organizados por funcionalidad:

**Gestión Académica:**
- `Courses.php` - Gestión de cursos
- `Programs.php` - Administración de programas académicos
- `Pensums.php` - Gestión de planes de estudio
- `Modules.php` - Administración de módulos académicos
- `Evaluations.php` - Sistema de evaluaciones
- `Qualifications.php` - Gestión de calificaciones

**Gestión de Estudiantes:**
- `Students.php` - Administración de estudiantes
- `Enrollments.php` - Proceso de matriculación
- `Enrolleds.php` - Estudiantes matriculados
- `Registrations.php` - Registro de estudiantes
- `Progress.php` - Seguimiento de progreso académico

**Gestión Administrativa:**
- `Institutions.php` - Administración de instituciones
- `Headquarters.php` - Gestión de sedes
- `Teachers.php` - Administración de docentes
- `Groups.php` - Gestión de grupos
- `Spaces.php` - Administración de espacios físicos

**Gestión Financiera:**
- `Costs.php` - Gestión de costos
- `Orders.php` - Administración de órdenes
- `OrdersItems.php` - Items de órdenes
- `Payments.php` - Gestión de pagos
- `Discounts.php` - Administración de descuentos
- `Financial.php` - Reportes financieros

**Certificaciones y Graduaciones:**
- `Certifications.php` - Gestión de certificaciones
- `Graduations.php` - Proceso de graduación
- `Executions.php` - Ejecución de programas

**Herramientas y Utilidades:**
- `Api.php` - API del sistema
- `Reports.php` - Generación de reportes
- `Excel.php` - Exportación a Excel
- `Pdf.php` - Generación de PDFs
- `Tools.php` - Herramientas del sistema
- `Importers.php` - Importación de datos
- `Sync.php` - Sincronización de datos

**Integración Externa:**
- `Moodle.php` - Integración con Moodle
- `Q10files.php` - Gestión de archivos Q10
- `Q10profiles.php` - Perfiles Q10
- `Psychometrics.php` - Evaluaciones psicométricas

### 📊 Modelos de Datos

Cada controlador tiene su modelo correspondiente con el prefijo `Sie_`:
- Gestión de entidades principales (Students, Teachers, Courses, etc.)
- Relaciones entre entidades (Enrollments, Orders_Items, etc.)
- Configuración del sistema (Settings, Statuses, etc.)
- Datos geográficos (Countries, Regions, Cities, Zones)

### 🖼️ Vistas y Templates

Las vistas están organizadas por módulo funcional:
- Cada controlador tiene su directorio de vistas correspondiente
- Incluye templates para operaciones CRUD (Create, Read, Update, Delete)
- Vistas especializadas para reportes y exportación de datos
- Interface de usuario responsive y moderna

### 🌐 Internacionalización

- Soporte completo para español en `Language/es/`
- Archivos de traducción organizados por módulo
- Facilita la expansión a otros idiomas

### 🔧 Configuración

- `Constants.php`: Define constantes del sistema y configuraciones globales
- `Routes.php`: Mapeo de URLs y rutas del módulo
- Configuración modular que permite personalización por institución

## Tecnología

Sistema desarrollado como módulo para [Higgs7](https://codehiggs.com/), proporcionando una arquitectura robusta y escalable para instituciones educativas modernas. Utiliza el patrón MVC para una separación clara de responsabilidades y facilita el mantenimiento y escalabilidad del código.

### Framework Higgs7

Este módulo está construido sobre el framework Higgs7, que proporciona:
- Arquitectura MVC robusta y flexible
- Sistema de módulos integrado
- Herramientas avanzadas para desarrollo web
- Documentación completa disponible en: [https://codehiggs.com/](https://codehiggs.com/)

Para más información sobre el desarrollo con Higgs7, consulte la documentación oficial del framework.
