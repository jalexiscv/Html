# Historial Académico - Generador de Certificados

## 📋 Propósito Principal
Este directorio contiene el generador de **historial académico completo** para estudiantes del Sistema Integral Educativo (SIE). Genera documentos Word (.docx) profesionales con el registro académico completo de un estudiante.

## 📄 Archivo Principal: `index.php`

### ⚡ Funcionalidad
Genera un documento Word con el historial académico completo de un estudiante, incluyendo todas las materias cursadas en todos los períodos académicos.

### 📥 Parámetros de Entrada
- **`enrollment`**: ID de matrícula del estudiante (parámetro requerido)

### 🔄 Procesamiento de Datos

#### 1. **Validación y Obtención de Datos**
- Recibe el parámetro `enrollment` (matrícula del estudiante)
- Obtiene datos del estudiante, programa académico y períodos cursados
- Valida que existan los datos necesarios

#### 2. **Procesamiento de Calificaciones**
- Procesa todas las ejecuciones (materias cursadas) por período
- **Estados de materias**:
  - **Aprobado**: nota final ≥ 80.0 (escala 100) o ≥ 3.0 (escala 5)
  - **En Curso**: período actual con nota < 80.0
  - **Reprobado**: períodos anteriores con nota < 80.0

#### 3. **Cálculos Académicos**
- Promedio ponderado por créditos de cada período
- Promedio general acumulado
- Total de créditos cursados y aprobados
- Consolidados por período académico

### 📊 Estructura del Documento Generado

#### **Encabezado**
- Datos del estudiante: nombre completo, identificación, programa

#### **Secciones por Período Académico**
- Código de la materia
- Nombre del módulo
- Ciclo académico
- Estado (Aprobado/Reprobado/En Curso)
- Calificaciones por cortes (C1, C2, C3)
- Nota definitiva
- Créditos

#### **Resumen General**
- Total créditos cursados
- Créditos aprobados
- Promedio general acumulado

### 🎨 Características del Formato
- **Colores diferenciados**:
  - 🔵 **Azul (#4472C4)**: títulos de período
  - 🟢 **Verde (#008000)**: materias aprobadas
  - 🔴 **Rojo (#CC0000)**: materias reprobadas
  - 🟠 **Naranja (#FF8800)**: materias en curso
  - 🟢 **Verde (#70AD47)**: resumen general
- **Formato profesional** con estilos y alineaciones específicas
- **Tablas estructuradas** con anchos de columna optimizados

### 🔧 Métodos de Generación
El sistema implementa **4 métodos** para garantizar la generación:

1. **Plantilla con variables**: usando `cloneRowAndSetValues`
2. **Tablas dinámicas**: creación programática con PHPWord
3. **Texto plano formateado**: fallback en caso de errores
4. **Fallback simple**: método de emergencia

### 📦 Dependencias
- **PHPOffice/PHPWord**: para generación de documentos Word
- **Modelos SIE**: Enrollments, Programs, Progress, Registrations, Executions
- **Plantilla**: `certificado-historial-academico.docx` en `/public/formats/`

### 💾 Salida
- **Archivo temporal**: generado en `/public/tmp/`
- **Descarga automática**: configurada con headers HTTP apropiados
- **Limpieza automática**: archivo temporal eliminado después de descarga
- **Nombre del archivo**: `historial_academico_{enrollment}_{timestamp}.docx`

### 🎯 Casos de Uso
Este generador se utiliza para:
- ✅ Certificaciones académicas oficiales
- ✅ Transferencias entre instituciones educativas
- ✅ Procesos de grado y titulación
- ✅ Auditorías académicas
- ✅ Solicitudes de becas o programas

### ⚙️ Notas Técnicas
- ✅ Manejo robusto de errores con múltiples fallbacks
- ✅ Cálculos ponderados por créditos académicos
- ✅ Formato responsive que se adapta al contenido
- ✅ Validación de datos de entrada
- ✅ Optimización de memoria para grandes historiales

---

## 📁 Archivos en este Directorio
- **`index.php`**: Generador principal del historial académico
- **`README.md`**: Esta documentación (para referencia de IA)

## 🔗 Archivos Relacionados
- **Plantilla requerida**: `/public/formats/certificado-historial-academico.docx`
- **Directorio temporal**: `/public/tmp/` (para archivos generados)
