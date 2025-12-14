# Guía de Contribución

¡Gracias por tu interés en contribuir al módulo SIE! Esta guía te ayudará a entender cómo puedes participar en el desarrollo del proyecto.

## Tabla de Contenidos

- [Código de Conducta](#código-de-conducta)
- [¿Cómo puedo contribuir?](#cómo-puedo-contribuir)
- [Configuración del Entorno de Desarrollo](#configuración-del-entorno-de-desarrollo)
- [Estándares de Código](#estándares-de-código)
- [Proceso de Pull Request](#proceso-de-pull-request)
- [Reporte de Bugs](#reporte-de-bugs)
- [Sugerencias de Funcionalidades](#sugerencias-de-funcionalidades)

## Código de Conducta

Este proyecto adhiere a un código de conducta. Al participar, se espera que mantengas este código.

## ¿Cómo puedo contribuir?

### Reportar Bugs

Los bugs se rastrean como issues de GitHub. Cuando reportes un bug, incluye:

- **Título descriptivo** que identifique el problema
- **Descripción detallada** del comportamiento esperado vs. actual
- **Pasos para reproducir** el problema
- **Información del entorno** (versión de Higgs7, PHP, base de datos)
- **Screenshots** si es aplicable

### Sugerir Mejoras

Las sugerencias de mejoras también se manejan como issues. Incluye:

- **Título claro** de la funcionalidad sugerida
- **Descripción detallada** de la funcionalidad
- **Justificación** de por qué sería útil
- **Ejemplos** de uso si es posible

### Contribuir con Código

1. Fork el repositorio
2. Crea una rama para tu funcionalidad (`git checkout -b feature/nueva-funcionalidad`)
3. Realiza tus cambios siguiendo los estándares de código
4. Escribe o actualiza tests según sea necesario
5. Asegúrate de que todos los tests pasen
6. Commit tus cambios (`git commit -m 'Agrega nueva funcionalidad'`)
7. Push a la rama (`git push origin feature/nueva-funcionalidad`)
8. Abre un Pull Request

## Configuración del Entorno de Desarrollo

### Requisitos Previos

- PHP 8.0 o superior
- Composer
- Base de datos (MySQL/PostgreSQL)
- Framework Higgs7

### Instalación

1. Clona el repositorio:
   ```bash
   git clone [URL_DEL_REPOSITORIO]
   cd Sie
   ```

2. Instala dependencias:
   ```bash
   composer install
   ```

3. Configura la base de datos en `.env`

4. Ejecuta las migraciones:
   ```bash
   php spark migrate
   ```

5. Ejecuta los seeders (si están disponibles):
   ```bash
   php spark db:seed
   ```

## Estándares de Código

### Convenciones de Nomenclatura

- **Clases**: PascalCase (`UserController`, `StudentModel`)
- **Métodos y Variables**: camelCase (`getUserData()`, `$studentInfo`)
- **Constantes**: UPPER_SNAKE_CASE (`MAX_STUDENTS`, `DEFAULT_STATUS`)
- **Archivos**: PascalCase para clases, snake_case para otros

### Estilo de Código

Seguimos los estándares PSR-12 con algunas adaptaciones:

```php
<?php
namespace Modules\Sie\Controllers;

use App\Controllers\BaseController;
use Modules\Sie\Models\StudentModel;

class StudentController extends BaseController
{
    protected $studentModel;
    
    public function __construct()
    {
        $this->studentModel = new StudentModel();
    }
    
    public function index(): string
    {
        $data = [
            'students' => $this->studentModel->findAll()
        ];
        
        return view('Modules\Sie\Views\Students\index', $data);
    }
}
```

### Documentación de Código

- Usa PHPDoc para documentar clases y métodos
- Incluye descripción, parámetros, tipos de retorno y excepciones

```php
/**
 * Obtiene la lista de estudiantes matriculados
 *
 * @param int $programId ID del programa académico
 * @param string $status Estado del estudiante (active, inactive)
 * @return array Lista de estudiantes
 * @throws \Exception Si el programa no existe
 */
public function getEnrolledStudents(int $programId, string $status = 'active'): array
{
    // Implementación
}
```

## Proceso de Pull Request

### Antes de Enviar

- [ ] El código sigue los estándares establecidos
- [ ] Se han agregado tests para nueva funcionalidad
- [ ] Todos los tests existentes pasan
- [ ] La documentación ha sido actualizada
- [ ] El CHANGELOG.md ha sido actualizado

### Plantilla de Pull Request

```markdown
## Descripción
Breve descripción de los cambios realizados.

## Tipo de Cambio
- [ ] Bug fix (cambio que corrige un problema)
- [ ] Nueva funcionalidad (cambio que agrega funcionalidad)
- [ ] Breaking change (cambio que podría romper funcionalidad existente)
- [ ] Actualización de documentación

## ¿Cómo se ha probado?
Describe las pruebas realizadas para verificar los cambios.

## Checklist
- [ ] Mi código sigue los estándares del proyecto
- [ ] He realizado una auto-revisión de mi código
- [ ] He comentado mi código, especialmente en áreas difíciles de entender
- [ ] He realizado cambios correspondientes en la documentación
- [ ] Mis cambios no generan nuevas advertencias
- [ ] He agregado tests que prueban que mi corrección es efectiva o que mi funcionalidad funciona
- [ ] Tests unitarios nuevos y existentes pasan localmente con mis cambios
```

## Testing

### Ejecutar Tests

```bash
# Todos los tests
php spark test

# Tests específicos
php spark test --group students
```

### Escribir Tests

- Coloca los tests en `tests/`
- Usa nombres descriptivos para los métodos de test
- Sigue el patrón Arrange-Act-Assert

```php
public function testCanCreateStudent()
{
    // Arrange
    $studentData = [
        'name' => 'Juan Pérez',
        'email' => 'juan@example.com'
    ];
    
    // Act
    $result = $this->studentModel->create($studentData);
    
    // Assert
    $this->assertTrue($result);
    $this->seeInDatabase('students', $studentData);
}
```

## Recursos Adicionales

- [Documentación de Higgs7](https://codehiggs.com/)
- [Guía de PSR-12](https://www.php-fig.org/psr/psr-12/)
- [Documentación del módulo SIE](README.md)

## Contacto

Si tienes preguntas sobre cómo contribuir, no dudes en:
- Abrir un issue para discusión
- Contactar a los mantenedores del proyecto

¡Gracias por contribuir al desarrollo del sistema SIE!
