# Módulo de Mantenimiento de Activos

## Descripción General

El **Módulo de Mantenimiento de Activos** es una solución integral basada en la nube diseñada para optimizar la gestión
de activos dentro de una organización. Permite la creación y administración de un inventario detallado de activos, el
seguimiento de su estado (operativo, en mantenimiento, fuera de servicio), y la programación de mantenimientos
preventivos y correctivos. Con funciones de notificaciones inteligentes y la capacidad de almacenar evidencia de los
mantenimientos realizados, este módulo asegura una gestión eficiente y en tiempo real, reduciendo costos, aumentando la
productividad y prolongando la vida útil de los equipos.

## Información del Proyecto

- **Framework**: Higgs (Compatible con CodeIgniter 4)
- **Versión**: 2.0.0
- **Autor**: Jose Alexis Correa Valencia <jalexiscv@gmail.com>
- **Licencia**: CloudEngine S.A.S., Inc.
- **Compatibilidad**: PHP 7, PHP 8, PHP 9
- **Namespace**: `App\Modules\Maintenance`

## Características Principales

### 🏭 Gestión Integral de Activos

- **Inventario completo** de activos organizacionales
- **Clasificación por tipos**: Equipos informáticos, electromecánicos, vehículos, maquinaria, etc.
- **Información detallada**: Especificaciones técnicas, ubicación, responsables
- **Documentación**: Almacenamiento de manuales, certificados y documentos relacionados

### 🔧 Sistema de Mantenimientos

- **Mantenimiento preventivo**: Programación automática basada en calendarios
- **Mantenimiento correctivo**: Gestión de reparaciones y averías
- **Seguimiento de estado**: Control en tiempo real del estado de cada activo
- **Historial completo**: Registro detallado de todas las intervenciones

### 📊 Control y Monitoreo

- **Estados de activos**: Operativo, en mantenimiento, fuera de servicio, etc.
- **Notificaciones inteligentes**: Alertas automáticas para mantenimientos programados
- **Reportes**: Generación de informes de gestión y rendimiento
- **Búsqueda avanzada**: Sistema de filtrado y búsqueda multicampo

### 🔐 Seguridad y Permisos

- **Control de acceso granular**: Permisos específicos por funcionalidad
- **Autoría de registros**: Seguimiento de quién crea/modifica cada registro
- **Soft deletes**: Eliminación lógica para mantener trazabilidad

## Estructura del Módulo

```
Modules/Maintenance/
├── Config/
│   ├── Constants.php          # Constantes de tipos y estados
│   └── Routes.php            # Configuración de rutas del módulo
├── Controllers/
│   ├── Api.php              # API REST para integraciones
│   ├── Assets.php           # Controlador de gestión de activos
│   ├── Maintenance.php      # Controlador principal del módulo
│   └── Maintenances.php     # Controlador de mantenimientos
├── Database/                # Migraciones de base de datos
├── Helpers/
│   └── Maintenance_helper.php # Funciones auxiliares y permisos
├── Language/
│   └── es/                  # Archivos de idioma en español
├── Models/
│   ├── Maintenance_Assets.php      # Modelo de activos
│   ├── Maintenance_Attachments.php # Modelo de adjuntos
│   ├── Maintenance_Clients_Modules.php # Modelo de clientes
│   └── Maintenance_Maintenances.php   # Modelo de mantenimientos
└── Views/                   # Vistas organizadas por funcionalidad
    ├── Assets/             # Vistas de gestión de activos
    ├── Denied/             # Vista de acceso denegado
    ├── Home/               # Vista principal del módulo
    └── Maintenances/       # Vistas de mantenimientos
```

## Tipos de Activos Soportados

El módulo soporta una amplia gama de tipos de activos:

- **Equipos Informáticos**: Computadores, servidores, impresoras
- **Equipos Electromecánicos**: Motores, bombas, generadores
- **Vehículos**: Automóviles, camiones, motocicletas
- **Maquinaria**: Equipos de producción e industriales
- **Equipos de Oficina**: Mobiliario, equipos de comunicación
- **Electrodomésticos**: Equipos de cocina, refrigeración
- **Herramientas Manuales**: Herramientas y equipos portátiles
- **Equipos de Seguridad**: Sistemas de alarma, cámaras, extintores
- **Instalaciones Físicas**: Infraestructura y edificaciones
- **Equipos Médicos**: Dispositivos y equipos hospitalarios
- **Y muchos más...**

## Estados de Mantenimiento

### Estados Operacionales

- **OPERATIONAL**: Activo en funcionamiento normal
- **AVAILABLE**: Disponible para uso
- **IN_USE**: Actualmente en uso
- **INSTALLED**: Instalado y configurado

### Estados de Mantenimiento

- **UNDER_MAINTENANCE**: En proceso de mantenimiento
- **PENDING**: Mantenimiento pendiente
- **COMPLETED**: Mantenimiento completado
- **REPAIRED**: Reparado y funcional

### Estados Especiales

- **OUT_OF_SERVICE**: Fuera de servicio
- **DAMAGED**: Dañado, requiere reparación
- **DECOMMISSIONED**: Dado de baja
- **RETIRED**: Retirado del servicio
- **EXPIRED**: Vencido o caducado

## Instalación y Configuración

### Requisitos del Sistema

- PHP 7.4 o superior
- Framework Higgs instalado
- Base de datos MySQL/MariaDB
- Servidor web (Apache/Nginx)

### Pasos de Instalación

1. **Clonar el módulo** en el directorio de módulos de Higgs:
   ```bash
   git clone [repository-url] app/Modules/Maintenance
   ```

2. **Configurar la base de datos** en el archivo de configuración principal

3. **Ejecutar migraciones** (se ejecutan automáticamente al cargar el módulo)

4. **Configurar permisos** ejecutando la función de generación de permisos:
   ```php
   generate_maintenance_permissions();
   ```

5. **Acceder al módulo** a través de la URL: `/maintenance`

## Uso del Módulo

### Gestión de Activos

#### Crear un Nuevo Activo

1. Navegar a **Gestión de Activos** → **Crear Activo**
2. Completar la información básica:
    - Nombre del activo
    - Tipo de activo
    - Ubicación
    - Código de identificación
3. Agregar especificaciones técnicas según el tipo
4. Asignar responsables y personal autorizado
5. Guardar el registro

#### Editar un Activo Existente

1. Buscar el activo en la lista
2. Hacer clic en **Editar**
3. Modificar los campos necesarios
4. Guardar los cambios

### Programación de Mantenimientos

#### Crear un Mantenimiento Preventivo

1. Ir a **Mantenimientos** → **Crear Mantenimiento**
2. Seleccionar el activo objetivo
3. Definir tipo de mantenimiento (preventivo/correctivo)
4. Programar fecha de ejecución
5. Asignar responsable
6. Agregar descripción y procedimientos

#### Seguimiento de Mantenimientos

- Ver lista de mantenimientos programados
- Actualizar estado de ejecución
- Registrar evidencias y observaciones
- Marcar como completado

## API y Funciones Principales

### Modelos Principales

#### Maintenance_Assets

```php
// Crear instancia del modelo
$massets = model('App\Modules\Maintenance\Models\Maintenance_Assets');

// Métodos principales
$massets->insert($data);           // Crear nuevo activo
$massets->update($id, $data);      // Actualizar activo
$massets->delete($id);             // Eliminar activo (soft delete)
$massets->getAsset($id);           // Obtener activo por ID
$massets->getGrid($limit, $offset, $field, $search); // Lista paginada
```

#### Maintenance_Maintenances

```php
// Crear instancia del modelo
$mmaintenances = model('App\Modules\Maintenance\Models\Maintenance_Maintenances');

// Métodos principales
$mmaintenances->insert($data);     // Crear mantenimiento
$mmaintenances->update($id, $data); // Actualizar mantenimiento
$mmaintenances->getMaintenance($id); // Obtener mantenimiento
```

### Funciones Helper

```php
// Generar permisos del módulo
generate_maintenance_permissions();

// Obtener sidebar del módulo
get_maintenance_sidebar($active_url);
```

## Sistema de Permisos

El módulo implementa un sistema granular de permisos:

### Permisos de Activos

- `maintenance-assets-access`: Acceso al módulo de activos
- `maintenance-assets-view`: Ver activos propios
- `maintenance-assets-view-all`: Ver todos los activos
- `maintenance-assets-create`: Crear nuevos activos
- `maintenance-assets-edit`: Editar activos propios
- `maintenance-assets-edit-all`: Editar todos los activos
- `maintenance-assets-delete`: Eliminar activos propios
- `maintenance-assets-delete-all`: Eliminar todos los activos

### Permisos de Mantenimientos

- `maintenance-maintenances-access`: Acceso al módulo de mantenimientos
- `maintenance-maintenances-view`: Ver mantenimientos propios
- `maintenance-maintenances-view-all`: Ver todos los mantenimientos
- `maintenance-maintenances-create`: Crear mantenimientos
- `maintenance-maintenances-edit`: Editar mantenimientos propios
- `maintenance-maintenances-edit-all`: Editar todos los mantenimientos
- `maintenance-maintenances-delete`: Eliminar mantenimientos propios
- `maintenance-maintenances-delete-all`: Eliminar todos los mantenimientos

## Base de Datos

### Tabla: maintenance_assets

Almacena la información completa de los activos:

```sql
-- Campos principales
asset (PK)              # Identificador único del activo
name                    # Nombre del activo
type                    # Tipo de activo (ver constantes)
status                  # Estado actual del activo
description             # Descripción detallada
entry_date              # Fecha de ingreso
location                # Ubicación física
code                    # Código de identificación

-- Especificaciones técnicas
brand                   # Marca
model                   # Modelo
serial_number           # Número de serie
voltage                 # Voltaje
amperage               # Amperaje
frequency              # Frecuencia
power                  # Potencia
rpm                    # Revoluciones por minuto
operation_hours        # Horas de operación

-- Información de vehículos
license_plate          # Placa del vehículo
vehicle_brand          # Marca del vehículo
vehicle_line           # Línea del vehículo
engine_displacement    # Cilindraje
vehicle_model          # Modelo del vehículo
vehicle_class          # Clase del vehículo
body_type             # Tipo de carrocería
doors_number          # Número de puertas
engine_number         # Número del motor
chassis_number        # Número de chasis
tonnage_capacity      # Capacidad de tonelaje
passengers            # Número de pasajeros

-- Gestión y control
equipment_function     # Función del equipo
authorized_personnel   # Personal autorizado
authorized_drivers     # Conductores autorizados
maintenance_manager    # Responsable de mantenimiento
photo_url             # URL de la foto del activo
observations          # Observaciones adicionales
author                # Usuario que creó el registro

-- Timestamps
created_at            # Fecha de creación
updated_at            # Fecha de última actualización
deleted_at            # Fecha de eliminación (soft delete)
```

### Tabla: maintenance_maintenances

Gestiona los registros de mantenimiento:

```sql
maintenance (PK)       # Identificador único del mantenimiento
asset                 # ID del activo (FK)
type                  # Tipo de mantenimiento
scheduled             # Fecha programada
execution             # Fecha de ejecución
responsible           # Responsable del mantenimiento
status                # Estado del mantenimiento
description           # Descripción del mantenimiento
author                # Usuario que creó el registro
created_at            # Fecha de creación
updated_at            # Fecha de actualización
deleted_at            # Fecha de eliminación
```

## Rutas del Módulo

### Rutas Principales

- `/maintenance` - Página principal del módulo
- `/maintenance/home/{alias}` - Vista de inicio

### Rutas de Activos

- `/maintenance/assets/home/{rnd}` - Lista de activos
- `/maintenance/assets/create/{rnd}` - Crear activo
- `/maintenance/assets/edit/{id}` - Editar activo
- `/maintenance/assets/view/{id}` - Ver detalles del activo
- `/maintenance/assets/delete/{id}` - Eliminar activo

### Rutas de Mantenimientos

- `/maintenance/maintenances/home/{rnd}` - Lista de mantenimientos
- `/maintenance/maintenances/create/{rnd}` - Crear mantenimiento
- `/maintenance/maintenances/edit/{id}` - Editar mantenimiento
- `/maintenance/maintenances/view/{id}` - Ver mantenimiento
- `/maintenance/maintenances/delete/{id}` - Eliminar mantenimiento

## Beneficios del Sistema

### 💰 Reducción de Costos

- **Mantenimiento preventivo** reduce reparaciones costosas
- **Optimización de recursos** mediante programación eficiente
- **Extensión de vida útil** de los equipos

### 📈 Aumento de Productividad

- **Minimización de tiempos de inactividad**
- **Planificación eficiente** de mantenimientos
- **Acceso rápido** a información de activos

### 🎯 Mejora en la Gestión

- **Trazabilidad completa** de mantenimientos
- **Reportes detallados** para toma de decisiones
- **Control de cumplimiento** de programas de mantenimiento

### 🔒 Seguridad y Cumplimiento

- **Registro de personal autorizado**
- **Documentación completa** para auditorías
- **Control de acceso** por permisos

## Soporte y Contacto

Para soporte técnico, consultas o reportar problemas:

- **Autor**: Jose Alexis Correa Valencia
- **Email**: jalexiscv@gmail.com
- **Website**: https://www.codehiggs.com
- **Empresa**: CloudEngine S.A.S., Inc.

## Licencia

Este software se proporciona "TAL CUAL", sin garantía de ningún tipo, expresa o implícita. Para obtener información
completa sobre derechos de autor y licencia, consulte el archivo LICENCIA que se distribuyó con este código fuente.

---

**Versión del Documento**: 1.0.0  
**Última Actualización**: 2025-01-03  
**Framework**: Higgs 2.0.0