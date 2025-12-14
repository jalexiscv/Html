# Modelo académico de la base de datos

La base de datos modela los procesos académicos internos de una institución educativa.

---

## 1. Estructura académica

- Los **programas académicos** de la institución se almacenan en la tabla `sie_programs`.
- Cada programa está asociado a una **malla curricular** (`sie_grids`), y cada malla puede tener una o varias **versiones**, registradas en `sie_versions`.
- Para cada versión de una malla se define un **pensum** en `sie_pensums`, que es el conjunto de **módulos** (`sie_modules`) que el estudiante debe cursar para obtener su título.

---

## 2. Estudiantes, matrículas y progreso

- Un **estudiante** está representado en la tabla `sie_registrations`.
- Cuando se matricula, se crea un registro en `sie_enrollments`, donde se:
    - vincula el estudiante (`sie_registrations`),
    - con una **versión específica** de la malla (`sie_versions`) de un programa determinado.

A partir de esa matrícula, se construye el **progreso académico** del estudiante en la tabla `sie_progress`.

### 2.1. ¿Qué es `sie_progress`?

Cada registro de `sie_progress` se puede entender como una **instantánea del pensum personal** del estudiante:

- Toma los módulos definidos en `sie_pensums` para la versión en la que se matriculó.
- Los convierte en metas concretas (módulos por cursar) que ese estudiante debe ir aprobando para alcanzar su título académico.

En otras palabras, `sie_progress` es la representación personalizada, para cada estudiante, del pensum que asumió al momento de su matrícula, derivado de la versión de la malla del programa correspondiente.

---

## 3. Cursos, transversalidad y ejecuciones

La tabla `sie_courses` representa los **cursos ofrecidos por la institución**. Cada curso:

- Está asociado a un **pensum** específico.
- Comparte un **módulo base** con el módulo correspondiente definido en ese pensum.

Gracias a ese módulo base, los cursos pueden ser **transversales**:

- Un mismo curso puede ser tomado por distintos estudiantes, siempre que en su `sie_progress` tengan un módulo que comparta ese mismo módulo base.

Cuando un estudiante tiene en su progreso (`sie_progress`) un módulo que coincide con el módulo base de un curso en `sie_courses`, se puede generar una **ejecución** de ese curso, registrada en `sie_executions`.

### 3.1. ¿Qué es `sie_executions`?

La tabla `sie_executions` representa:

- La unión entre un **progreso** (la necesidad de cursar un módulo por parte de un estudiante),
- y un **curso** (`sie_courses`) que comparte el mismo módulo base.

Esta relación puede darse una o varias veces (por ejemplo, si el estudiante repite el curso) hasta que se logre una ejecución exitosa.

---

## 4. Calificaciones y aprobación del módulo

Al **ejecutar** el curso, el estudiante obtiene una serie de calificaciones, generalmente organizadas como **unidades de competencia**:

- `c1`
- `c2`
- `c3`
- y un **total** acumulado

Estas calificaciones quedan registradas en `sie_executions`.

Sin embargo, donde realmente se determina si el estudiante **ganó o no** el módulo correspondiente es en el registro de `sie_progress` asociado a ese módulo.

En `sie_progress`, el campo `status` indica el estado del progreso del estudiante en ese módulo. Entre los posibles valores, hay dos que resultan clave:

- `APPROVED`
- `HOMOLOGATION`

Ambos estados significan que el estudiante **ha cumplido exitosamente** la ejecución del curso asociada a ese módulo (ya sea por cursarlo y aprobarlo, o por un proceso de homologación), y por lo tanto se considera que ese componente del pensum está ganado dentro de su progreso académico.

---
