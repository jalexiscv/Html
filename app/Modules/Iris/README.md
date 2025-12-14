# IRIS (Intelligent Retinal Imaging System)

**Versión del Módulo**: 1.0.0  
**Estado**: En Desarrollo Activo

IRIS es una plataforma avanzada de diagnóstico oftalmológico integrada en el ecosistema **Higgs7**. Utilizando algoritmos de inteligencia artificial y visión por computadora, IRIS analiza imágenes de fondo de ojo para asistir en la detección temprana de patologías críticas como la Retinopatía Diabética, Glaucoma y Degeneración Macular.

Más allá del diagnóstico, IRIS actúa como un gestor integral de la práctica oftalmológica, administrando perfiles profesionales, agendas especializadas y flujos de trabajo clínicos bajo estándares internacionales.

---

## 🚀 Características Clave

### 🧠 Diagnóstico Asistido por IA
*   Análisis automatizado de imágenes de retina.
*   Triaje inteligente para priorizar casos urgentes.
*   Generación de pre-informes clínicos.

### 🏥 Gestión Clínica Avanzada
*   **Multi-Especialidad**: Soporte para profesionales con múltiples competencias (ej. Retina + Glaucoma).
*   **Estructura Organizacional**: Gestión de departamentos y grupos de práctica (ej. Residentes, Guardia).
*   **Roles Contextuales**: Definición de jerarquías y permisos por grupo.

### 🔗 Interoperabilidad (HL7 / DICOM)
*   **HL7 ADT**: Gestión de admisión y demografía de pacientes.
*   **HL7 ORM/ORU**: Flujos de órdenes de estudio y reporte de resultados.
*   **HL7 STF/PRA**: Estandarización de perfiles médicos y privilegios.

---

## 🏛 Arquitectura de Datos

El módulo implementa un modelo relacional robusto para la gestión del talento humano en salud:

1.  **Profesionales (`iris_professionals`)**: Entidad central (Staff).
2.  **Catálogos Maestros**:
    *   **Especialidades (`iris_specialties`)**: *Qué sabe hacer* (Competencia Clínica).
    *   **Grupos (`iris_groups`)**: *Dónde trabaja* (Unidad Funcional).
3.  **Tablas de Vinculación**:
    *   **Asignaciones (`iris_assignments`)**: Acredita especialidades a un profesional.
    *   **Membresías (`iris_memberships`)**: Afilia un profesional a un grupo con un rol específico.

---

## 📚 Mapa de Documentación

Toda la documentación técnica y funcional se encuentra centralizada en el directorio `Docs/`.

| Componente | Archivo | Descripción |
| :--- | :--- | :--- |
| **Estándares Generales** | [`Docs/STANDARDS.md`](Docs/STANDARDS.md) | Índice maestro de implementaciones HL7. |
| **Profesionales** | [`Docs/Standards/PROFESSIONALS.md`](Docs/Standards/PROFESSIONALS.md) | Definición de la tabla `iris_professionals`. |
| **Especialidades** | [`Docs/Standards/SPECIALTIES.md`](Docs/Standards/SPECIALTIES.md) | Catálogo maestro de especialidades. |
| **Asignaciones** | [`Docs/Standards/ASSIGNMENTS.md`](Docs/Standards/ASSIGNMENTS.md) | Relación Profesional-Especialidad. |
| **Grupos** | [`Docs/Standards/GROUPS.md`](Docs/Standards/GROUPS.md) | Catálogo maestro de grupos de práctica. |
| **Membresías** | [`Docs/Standards/MEMBERSHIPS.md`](Docs/Standards/MEMBERSHIPS.md) | Relación Profesional-Grupo. |
| **Episodios** | [`Docs/Standards/EPISODES.md`](Docs/Standards/EPISODES.md) | Gestión de encuentros clínicos (PV1). |

### Referencias Externas
*   **Higgs7 Core**: Para guías de desarrollo generales, ver [`HIGGS7.md`](HIGGS7.md).
*   **Documentación Oficial**: [https://codehiggs.com/](https://codehiggs.com/)

---

## 🛠 Stack Tecnológico

*   **Backend**: Higgs7
*   **Base de Datos**: MySQL 8.0 (InnoDB)
*   **AI/ML**: Python Microservices (TensorFlow/PyTorch) - *Integración vía API*
*   **Frontend**: Higgs7

---

> [!NOTE]
> Este módulo sigue estrictamente la política de "Documentación Viva". Cualquier cambio en la estructura de la base de datos debe reflejarse inmediatamente en los archivos correspondientes dentro de `Docs/Standards/`.
