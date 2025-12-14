# Guía de Testing - Módulo SIE

## Introducción

Esta guía describe la estrategia de testing, herramientas y procedimientos para asegurar la calidad del módulo SIE. Incluye tests unitarios, de integración, funcionales y de rendimiento.

## Tabla de Contenidos

- [Configuración del Entorno de Testing](#configuración-del-entorno-de-testing)
- [Tipos de Tests](#tipos-de-tests)
- [Estructura de Tests](#estructura-de-tests)
- [Ejecutar Tests](#ejecutar-tests)
- [Escribir Tests](#escribir-tests)
- [Cobertura de Código](#cobertura-de-código)
- [Testing de API](#testing-de-api)
- [Testing de Base de Datos](#testing-de-base-de-datos)
- [Testing de Seguridad](#testing-de-seguridad)
- [CI/CD y Automatización](#cicd-y-automatización)

## Configuración del Entorno de Testing

### Requisitos

- PHPUnit 9.0+
- Higgs7 Testing Framework
- Base de datos de testing (separada de desarrollo)
- Faker para datos de prueba

### Instalación

```bash
# Instalar dependencias de testing
composer install --dev

# Configurar base de datos de testing
cp .env .env.testing
```

### Configuración de Base de Datos de Testing

```env
# .env.testing
CI_ENVIRONMENT = testing

# Base de datos de testing
database.tests.hostname = localhost
database.tests.database = sie_testing
database.tests.username = sie_test_user
database.tests.password = test_password
database.tests.DBDriver = MySQLi
database.tests.DBPrefix = test_

# Configuración de testing
SIE_TESTING_MODE = true
SIE_CACHE_HANDLER = array
SIE_SESSION_DRIVER = array
```

### Configuración PHPUnit

```xml
<!-- phpunit.xml -->
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="https://schema.phpunit.de/9.5/phpunit.xsd"
         bootstrap="vendor/higgs/framework/system/Test/bootstrap.php"
         colors="true"
         convertDeprecationsToExceptions="true"
         convertErrorsToExceptions="true"
         convertNoticesToExceptions="true"
         convertWarningsToExceptions="true"
         stopOnError="false"
         stopOnFailure="false"
         stopOnIncomplete="false"
         stopOnSkipped="false">
    
    <testsuites>
        <testsuite name="SIE Unit Tests">
            <directory>./tests/unit</directory>
        </testsuite>
        <testsuite name="SIE Integration Tests">
            <directory>./tests/integration</directory>
        </testsuite>
        <testsuite name="SIE Feature Tests">
            <directory>./tests/feature</directory>
        </testsuite>
    </testsuites>
    
    <filter>
        <whitelist processUncoveredFilesFromWhitelist="true">
            <directory suffix=".php">./app/Modules/Sie</directory>
            <exclude>
                <directory>./app/Modules/Sie/Views</directory>
                <directory>./app/Modules/Sie/Language</directory>
            </exclude>
        </whitelist>
    </filter>
    
    <logging>
        <log type="coverage-html" target="./tests/coverage"/>
        <log type="coverage-clover" target="./tests/coverage/clover.xml"/>
    </logging>
</phpunit>
```

## Tipos de Tests

### 1. Tests Unitarios

Prueban componentes individuales de forma aislada.

```php
<?php
namespace Tests\Unit\Models;

use Higgs\Test\HiggsUnitTestCase;
use Modules\Sie\Models\Sie_Students;

class StudentModelTest extends HiggsUnitTestCase
{
    protected $studentModel;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->studentModel = new Sie_Students();
    }
    
    public function testCanCreateStudent()
    {
        $studentData = [
            'user_id' => 1,
            'student_code' => 'EST001',
            'document_type' => 'CC',
            'document_number' => '12345678',
            'status' => 'active'
        ];
        
        $result = $this->studentModel->insert($studentData);
        
        $this->assertIsNumeric($result);
        $this->assertGreaterThan(0, $result);
    }
    
    public function testValidatesRequiredFields()
    {
        $this->expectException(\Higgs\Database\Exceptions\ValidationException::class);
        
        $this->studentModel->insert([
            'student_code' => 'EST002'
            // Falta user_id requerido
        ]);
    }
    
    public function testGeneratesStudentCode()
    {
        $code = $this->studentModel->generateStudentCode();
        
        $this->assertStringStartsWith('EST', $code);
        $this->assertEquals(8, strlen($code));
    }
}
```

### 2. Tests de Integración

Prueban la interacción entre múltiples componentes.

```php
<?php
namespace Tests\Integration\Controllers;

use Higgs\Test\HiggsTestCase;
use Higgs\Test\DatabaseTestTrait;

class StudentControllerTest extends HiggsTestCase
{
    use DatabaseTestTrait;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpDatabase();
    }
    
    public function testCanCreateStudentThroughController()
    {
        $studentData = [
            'name' => 'Juan Pérez',
            'email' => 'juan@test.com',
            'document_type' => 'CC',
            'document_number' => '12345678'
        ];
        
        $response = $this->withSession(['user_id' => 1])
                         ->post('/sie/students/store', $studentData);
        
        $response->assertRedirect('/sie/students');
        $this->seeInDatabase('sie_students', [
            'document_number' => '12345678'
        ]);
    }
    
    public function testRequiresAuthentication()
    {
        $response = $this->get('/sie/students');
        
        $response->assertRedirect('/login');
    }
}
```

### 3. Tests Funcionales (Feature Tests)

Prueban funcionalidades completas desde la perspectiva del usuario.

```php
<?php
namespace Tests\Feature;

use Higgs\Test\FeatureTestCase;

class StudentEnrollmentTest extends FeatureTestCase
{
    public function testCompleteEnrollmentProcess()
    {
        // Crear usuario y autenticar
        $user = $this->createUser(['role' => 'admin']);
        $this->actingAs($user);
        
        // Crear programa
        $program = $this->createProgram();
        
        // Crear estudiante
        $student = $this->createStudent();
        
        // Realizar matriculación
        $response = $this->post('/sie/enrollments/store', [
            'student_id' => $student->id,
            'program_id' => $program->id,
            'enrollment_date' => date('Y-m-d')
        ]);
        
        $response->assertSuccessful();
        
        // Verificar que la matriculación se creó
        $this->seeInDatabase('sie_enrollments', [
            'student_id' => $student->id,
            'program_id' => $program->id
        ]);
        
        // Verificar que se puede acceder a los cursos
        $response = $this->get("/sie/students/{$student->id}/courses");
        $response->assertSuccessful();
    }
}
```

## Estructura de Tests

```
tests/
├── _support/
│   ├── Factories/
│   │   ├── StudentFactory.php
│   │   ├── ProgramFactory.php
│   │   └── CourseFactory.php
│   ├── Helpers/
│   │   └── TestHelper.php
│   └── Traits/
│       └── DatabaseSeeder.php
├── unit/
│   ├── Models/
│   ├── Libraries/
│   └── Helpers/
├── integration/
│   ├── Controllers/
│   ├── Services/
│   └── Database/
├── feature/
│   ├── Authentication/
│   ├── StudentManagement/
│   ├── AcademicManagement/
│   └── FinancialManagement/
└── performance/
    ├── LoadTests/
    └── StressTests/
```

## Ejecutar Tests

### Comandos Básicos

```bash
# Ejecutar todos los tests
php spark test

# Ejecutar tests específicos
php spark test --group unit
php spark test --group integration
php spark test --group feature

# Ejecutar un test específico
php spark test Tests\\Unit\\Models\\StudentModelTest

# Ejecutar con cobertura
php spark test --coverage

# Ejecutar en modo verbose
php spark test --verbose
```

### Tests por Módulo

```bash
# Tests de estudiantes
php spark test --group students

# Tests de cursos
php spark test --group courses

# Tests de evaluaciones
php spark test --group evaluations

# Tests de pagos
php spark test --group payments
```

## Escribir Tests

### Factories para Datos de Prueba

```php
<?php
namespace Tests\Support\Factories;

use Faker\Factory;

class StudentFactory
{
    public static function create($attributes = [])
    {
        $faker = Factory::create('es_ES');
        
        $defaults = [
            'user_id' => UserFactory::create()->id,
            'student_code' => 'EST' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
            'document_type' => 'CC',
            'document_number' => $faker->unique()->numerify('########'),
            'birth_date' => $faker->dateTimeBetween('-25 years', '-18 years')->format('Y-m-d'),
            'gender' => $faker->randomElement(['M', 'F']),
            'status' => 'active',
            'admission_date' => $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d')
        ];
        
        $data = array_merge($defaults, $attributes);
        
        $model = new \Modules\Sie\Models\Sie_Students();
        $id = $model->insert($data);
        
        return $model->find($id);
    }
    
    public static function createMultiple($count, $attributes = [])
    {
        $students = [];
        for ($i = 0; $i < $count; $i++) {
            $students[] = self::create($attributes);
        }
        return $students;
    }
}
```

### Traits Útiles

```php
<?php
namespace Tests\Support\Traits;

trait DatabaseSeeder
{
    protected function seedBasicData()
    {
        // Crear datos básicos necesarios para tests
        $this->seedCountries();
        $this->seedInstitutions();
        $this->seedPrograms();
        $this->seedUsers();
    }
    
    protected function seedCountries()
    {
        $countries = [
            ['name' => 'Colombia', 'code' => 'CO'],
            ['name' => 'México', 'code' => 'MX'],
            ['name' => 'Argentina', 'code' => 'AR']
        ];
        
        foreach ($countries as $country) {
            $this->db->table('sie_countries')->insert($country);
        }
    }
    
    protected function cleanDatabase()
    {
        // Limpiar tablas en orden correcto (respetando foreign keys)
        $tables = [
            'sie_evaluations',
            'sie_enrolleds',
            'sie_enrollments',
            'sie_students',
            'sie_users',
            'sie_courses',
            'sie_programs',
            'sie_institutions'
        ];
        
        foreach ($tables as $table) {
            $this->db->table($table)->truncate();
        }
    }
}
```

### Mocking y Stubs

```php
<?php
namespace Tests\Unit\Services;

use Higgs\Test\HiggsUnitTestCase;
use Modules\Sie\Services\EmailService;
use Modules\Sie\Services\MoodleService;

class NotificationServiceTest extends HiggsUnitTestCase
{
    public function testSendsEnrollmentNotification()
    {
        // Mock del servicio de email
        $emailService = $this->createMock(EmailService::class);
        $emailService->expects($this->once())
                    ->method('send')
                    ->with(
                        $this->equalTo('student@test.com'),
                        $this->stringContains('Matriculación Exitosa')
                    )
                    ->willReturn(true);
        
        // Mock del servicio de Moodle
        $moodleService = $this->createMock(MoodleService::class);
        $moodleService->expects($this->once())
                     ->method('createUser')
                     ->willReturn(['id' => 123]);
        
        $notificationService = new NotificationService($emailService, $moodleService);
        
        $result = $notificationService->sendEnrollmentNotification($student, $program);
        
        $this->assertTrue($result);
    }
}
```

## Cobertura de Código

### Configuración

```php
// En phpunit.xml
<filter>
    <whitelist processUncoveredFilesFromWhitelist="true">
        <directory suffix=".php">./app/Modules/Sie</directory>
        <exclude>
            <directory>./app/Modules/Sie/Views</directory>
            <directory>./app/Modules/Sie/Language</directory>
            <file>./app/Modules/Sie/Config/Routes.php</file>
        </exclude>
    </whitelist>
</filter>
```

### Generar Reportes

```bash
# Generar reporte HTML
php spark test --coverage-html tests/coverage

# Generar reporte XML (para CI/CD)
php spark test --coverage-clover tests/coverage/clover.xml

# Generar reporte de texto
php spark test --coverage-text
```

### Objetivos de Cobertura

- **Modelos**: 90%+ cobertura
- **Controladores**: 85%+ cobertura
- **Servicios**: 95%+ cobertura
- **Helpers**: 80%+ cobertura
- **General**: 85%+ cobertura total

## Testing de API

### Tests de Endpoints

```php
<?php
namespace Tests\Feature\Api;

use Higgs\Test\FeatureTestCase;

class StudentApiTest extends FeatureTestCase
{
    protected $apiToken;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->apiToken = $this->generateApiToken();
    }
    
    public function testCanGetStudentsList()
    {
        $students = StudentFactory::createMultiple(5);
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->apiToken,
            'Accept' => 'application/json'
        ])->get('/sie/api/students');
        
        $response->assertStatus(200)
                ->assertJsonStructure([
                    'status',
                    'data' => [
                        'students' => [
                            '*' => ['id', 'name', 'email', 'student_code']
                        ],
                        'pagination'
                    ]
                ]);
    }
    
    public function testCanCreateStudent()
    {
        $studentData = [
            'name' => 'Test Student',
            'email' => 'test@example.com',
            'document_type' => 'CC',
            'document_number' => '12345678'
        ];
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->apiToken,
            'Content-Type' => 'application/json'
        ])->post('/sie/api/students', $studentData);
        
        $response->assertStatus(201)
                ->assertJson([
                    'status' => 'success',
                    'data' => [
                        'registration' => [
                            'email' => 'test@example.com'
                        ]
                    ]
                ]);
    }
    
    public function testValidatesApiInput()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->apiToken,
            'Content-Type' => 'application/json'
        ])->post('/sie/api/students', [
            'name' => '', // Campo requerido vacío
            'email' => 'invalid-email'
        ]);
        
        $response->assertStatus(422)
                ->assertJsonStructure([
                    'status',
                    'message',
                    'errors'
                ]);
    }
}
```

## Testing de Base de Datos

### Migrations Testing

```php
<?php
namespace Tests\Integration\Database;

use Higgs\Test\DatabaseTestCase;

class MigrationsTest extends DatabaseTestCase
{
    public function testCanRunAllMigrations()
    {
        // Ejecutar migraciones
        $this->artisan('migrate:fresh');
        
        // Verificar que las tablas existen
        $this->assertTrue($this->schema->hasTable('sie_students'));
        $this->assertTrue($this->schema->hasTable('sie_programs'));
        $this->assertTrue($this->schema->hasTable('sie_courses'));
    }
    
    public function testCanRollbackMigrations()
    {
        $this->artisan('migrate:rollback');
        
        // Verificar que se puede hacer rollback sin errores
        $this->assertTrue(true);
    }
}
```

### Seeders Testing

```php
<?php
namespace Tests\Integration\Database;

class SeedersTest extends DatabaseTestCase
{
    public function testBasicSeederWorks()
    {
        $this->artisan('db:seed', ['--class' => 'SieBasicSeeder']);
        
        $this->seeInDatabase('sie_countries', ['code' => 'CO']);
        $this->seeInDatabase('sie_user_roles', ['name' => 'admin']);
    }
}
```

## Testing de Seguridad

### Tests de Autenticación

```php
<?php
namespace Tests\Feature\Security;

class AuthenticationTest extends FeatureTestCase
{
    public function testRequiresAuthenticationForProtectedRoutes()
    {
        $protectedRoutes = [
            '/sie/students',
            '/sie/courses',
            '/sie/enrollments',
            '/sie/reports'
        ];
        
        foreach ($protectedRoutes as $route) {
            $response = $this->get($route);
            $response->assertRedirect('/login');
        }
    }
    
    public function testPreventsCSRFAttacks()
    {
        $user = $this->createUser();
        $this->actingAs($user);
        
        // Intentar POST sin token CSRF
        $response = $this->post('/sie/students/store', [
            'name' => 'Test Student'
        ]);
        
        $response->assertStatus(419); // CSRF token mismatch
    }
}
```

### Tests de Autorización

```php
<?php
namespace Tests\Feature\Security;

class AuthorizationTest extends FeatureTestCase
{
    public function testStudentCannotAccessAdminRoutes()
    {
        $student = $this->createUser(['role' => 'registration']);
        $this->actingAs($student);
        
        $response = $this->get('/sie/admin/settings');
        
        $response->assertStatus(403);
    }
    
    public function testTeacherCanOnlyAccessOwnCourses()
    {
        $teacher = $this->createUser(['role' => 'teacher']);
        $otherTeacher = $this->createUser(['role' => 'teacher']);
        
        $course = $this->createCourse(['teacher_id' => $otherTeacher->id]);
        
        $this->actingAs($teacher);
        
        $response = $this->get("/sie/courses/{$course->id}/edit");
        
        $response->assertStatus(403);
    }
}
```

## CI/CD y Automatización

### GitHub Actions

```yaml
# .github/workflows/tests.yml
name: Tests

on:
  push:
    branches: [ main, develop ]
  pull_request:
    branches: [ main ]

jobs:
  test:
    runs-on: ubuntu-latest
    
    services:
      mysql:
        image: mysql:8.0
        env:
          MYSQL_ROOT_PASSWORD: root
          MYSQL_DATABASE: sie_testing
        ports:
          - 3306:3306
        options: --health-cmd="mysqladmin ping" --health-interval=10s --health-timeout=5s --health-retries=3
    
    steps:
    - uses: actions/checkout@v2
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.1'
        extensions: mbstring, xml, ctype, iconv, intl, pdo_mysql
        coverage: xdebug
    
    - name: Install dependencies
      run: composer install --prefer-dist --no-progress
    
    - name: Copy environment file
      run: cp .env.testing .env
    
    - name: Generate application key
      run: php spark key:generate
    
    - name: Run migrations
      run: php spark migrate
    
    - name: Run tests
      run: php spark test --coverage-clover coverage.xml
    
    - name: Upload coverage to Codecov
      uses: codecov/codecov-action@v1
      with:
        file: ./coverage.xml
```

### Scripts de Automatización

```bash
#!/bin/bash
# scripts/run-tests.sh

echo "🧪 Ejecutando suite completa de tests..."

# Limpiar cache
php spark cache:clear

# Ejecutar tests unitarios
echo "📋 Tests unitarios..."
php spark test --group unit

# Ejecutar tests de integración
echo "🔗 Tests de integración..."
php spark test --group integration

# Ejecutar tests funcionales
echo "🎯 Tests funcionales..."
php spark test --group feature

# Generar reporte de cobertura
echo "📊 Generando reporte de cobertura..."
php spark test --coverage-html tests/coverage

echo "✅ Tests completados. Ver reporte en tests/coverage/index.html"
```

### Hooks de Git

```bash
#!/bin/sh
# .git/hooks/pre-commit

echo "Ejecutando tests antes del commit..."

# Ejecutar tests rápidos
php spark test --group unit

if [ $? -ne 0 ]; then
    echo "❌ Tests fallaron. Commit cancelado."
    exit 1
fi

echo "✅ Tests pasaron. Continuando con el commit."
```

## Mejores Prácticas

### Naming Conventions

- **Test Classes**: `{ClassBeingTested}Test`
- **Test Methods**: `test{WhatIsBeingTested}`
- **Factories**: `{Model}Factory`
- **Traits**: `{Purpose}Trait`

### Organización

- Un test por funcionalidad específica
- Tests independientes (no dependen de otros)
- Usar factories para datos de prueba
- Limpiar datos después de cada test
- Usar mocks para dependencias externas

### Performance

- Usar transacciones para tests de base de datos
- Minimizar operaciones de I/O
- Usar cache en memoria para tests
- Paralelizar tests cuando sea posible

Esta guía de testing asegura que el módulo SIE mantenga alta calidad y confiabilidad a través de pruebas exhaustivas y automatizadas.
