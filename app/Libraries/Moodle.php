<?php

namespace App\Libraries;

use Exception;
use InvalidArgumentException;
use RuntimeException;

class Moodle
{
    /**
     * Token de acceso a la API de Moodle
     * @var string
     */
    private string $token;

    /**
     * Dominio de la instancia de Moodle
     * @var string
     */
    private string $domainName;

    /**
     * Formato de respuesta de la API
     * @var string
     */
    private string $restFormat;

    /**
     * Endpoint base de la API de Moodle
     * @var string
     */
    private string $endpoint;

    /**
     * Constructor de la clase Moodle
     * Inicializa las propiedades de configuración
     */
    public function __construct()
    {
        $this->token = 'ce890746630ebf2c6b7baf4dde8f41b4';
        $this->domainName = 'https://campus.utede.edu.co';
        $this->restFormat = 'json';
        $this->endpoint = rtrim($this->domainName, '/') . '/webservice/rest/server.php';
    }

    /**
     * Obtiene el ID de un curso por su shortname
     * $course=moodle_get_course("685C25E197397");
     * if($course){
     * echo("El curso existe");
     * echo("<pre>");
     * print_r($course);
     * echo("</pre>");
     * }else{
     * echo("No existe el curso");
     * }
     * @param string $shortname
     * @return false|int|null
     */
    function getCourse(string $shortname)
    {
        // Parámetros de conexión configurados directamente en la función
        $wsfunction = "core_course_get_courses_by_field";
        $postFields = [
            'wstoken' => $this->token,
            'wsfunction' => $wsfunction,
            'moodlewsrestformat' => $this->restFormat,
            'field' => 'shortname',
            'value' => $shortname
        ];

        $ch = curl_init($this->endpoint);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($postFields),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
        ]);

        $raw = curl_exec($ch);
        $err = curl_error($ch);
        $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($raw === false) {
            throw new RuntimeException("Error cURL: $err");
        }
        $data = json_decode($raw, true);
        if ($http >= 400) {
            throw new RuntimeException("HTTP $http: $raw");
        }
        // Moodle devuelve excepciones en JSON con keys 'exception'/'errorcode'/'message'
        if (is_array($data) && isset($data['exception'])) {
            $msg = $data['message'] ?? 'Error Moodle';
            $code = $data['errorcode'] ?? 'unknown';
            throw new RuntimeException("Moodle exception ($code): $msg");
        }

        // Buscar el curso que coincida exactamente con el shortname
        if (isset($data['courses']) && is_array($data['courses']) && count($data['courses']) > 0) {
            foreach ($data['courses'] as $course) {
                if (isset($course['shortname']) && strcasecmp($course['shortname'], $shortname) === 0) {
                    return isset($course['id']) ? (int)$course['id'] : null;
                }
            }
        }

        // No se encontró el curso
        return (false);
    }


    /**
     * Crea un nuevo curso en Moodle
     *
     * Ejemplo de uso:
     * $moodle = new Moodle();
     * $courseData = [
     *     'shortname' => 'CURSO2025A',
     *     'fullname' => 'Curso de Ejemplo 2025A',
     *     'categoryid' => 1,
     *     'summary' => 'Descripción del curso'
     * ];
     * $courseId = $moodle->createCourse($courseData);
     * if ($courseId) {
     *     echo "Curso creado con ID: $courseId";
     * } else {
     *     echo "Error al crear el curso";
     * }
     *
     * @param array $courseData Datos del curso a crear
     * @return int|false ID del curso creado o false en caso de error
     */
    function createCourse(array $courseData)
    {
        // Parámetros de conexión configurados directamente en la función
        $wsfunction = "core_course_create_courses";
        $postFields = [
            'wstoken' => $this->token,
            'wsfunction' => $wsfunction,
            'moodlewsrestformat' => $this->restFormat
        ];

        // Validar campos obligatorios
        if (empty($courseData['shortname']) || empty($courseData['fullname'])) {
            throw new InvalidArgumentException("shortname y fullname son campos obligatorios");
        }

        // Configurar datos por defecto del curso
        $defaultCourse = [
            'shortname' => $courseData['shortname'],
            'fullname' => $courseData['fullname'],
            'categoryid' => $courseData['categoryid'] ?? 1, // Categoría por defecto
            'summary' => $courseData['summary'] ?? '',
            'summaryformat' => $courseData['summaryformat'] ?? 1,
            'format' => $courseData['format'] ?? 'topics',
            'showgrades' => $courseData['showgrades'] ?? 1,
            'newsitems' => $courseData['newsitems'] ?? 5,
            'startdate' => $courseData['startdate'] ?? time(),
            'enddate' => $courseData['enddate'] ?? 0,
            'maxbytes' => $courseData['maxbytes'] ?? 0,
            'showreports' => $courseData['showreports'] ?? 0,
            'visible' => $courseData['visible'] ?? 1,
            'groupmode' => $courseData['groupmode'] ?? 0,
            'groupmodeforce' => $courseData['groupmodeforce'] ?? 0,
            'defaultgroupingid' => $courseData['defaultgroupingid'] ?? 0,
            'enablecompletion' => $courseData['enablecompletion'] ?? 1,
            'completionnotify' => $courseData['completionnotify'] ?? 0,
            'lang' => $courseData['lang'] ?? 'es',
            'forcetheme' => $courseData['forcetheme'] ?? ''
        ];

        // Agregar datos del curso con formato courses[0][campo]
        foreach ($defaultCourse as $field => $value) {
            $postFields["courses[0][$field]"] = $value;
        }

        $ch = curl_init($this->endpoint);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($postFields),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ]);

        $raw = curl_exec($ch);
        $err = curl_error($ch);
        $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($raw === false) {
            throw new RuntimeException("Error cURL: $err");
        }

        $data = json_decode($raw, true);

        if ($http >= 400) {
            throw new RuntimeException("HTTP $http: $raw");
        }

        // Moodle devuelve excepciones en JSON con keys 'exception'/'errorcode'/'message'
        if (is_array($data) && isset($data['exception'])) {
            $msg = $data['message'] ?? 'Error Moodle';
            $code = $data['errorcode'] ?? 'unknown';
            throw new RuntimeException("Moodle exception ($code): $msg");
        }

        // Verificar si se creó el curso exitosamente
        if (isset($data[0]['id']) && is_numeric($data[0]['id'])) {
            return (int)$data[0]['id'];
        }

        // Si llegamos aquí, algo salió mal
        throw new RuntimeException("Respuesta inesperada de Moodle: " . json_encode($data));
    }

    /**
     * Actualiza los datos de un curso existente en Moodle
     * Ejemplo de uso:
     * $moodle = new \App\Libraries\Moodle();
     * $courseData = [
     *     'id' => 123,
     *     'fullname' => 'Nuevo nombre del curso',
     *     'shortname' => 'NUEVO_CODIGO',
     *     'summary' => 'Nueva descripción',
     *     'visible' => 1
     * ];
     * $result = $moodle->updateCourse($courseData);
     * if ($result['success']) {
     *     echo "Curso actualizado exitosamente";
     * } else {
     *     echo "Error: " . $result['error'];
     * }
     *
     * @param array $courseData Datos del curso a actualizar (debe incluir 'id')
     * @return array Array con success, error, originalData y courseInfo
     */
    function updateCourse(array $courseData): array
    {
        $wsfunction = "core_course_update_courses";

        try {
            // Validar campo obligatorio
            if (empty($courseData['id']) || !is_numeric($courseData['id'])) {
                return [
                    "success" => false,
                    "error" => "ID del curso es obligatorio y debe ser numérico",
                    "originalData" => null
                ];
            }

            // Configurar datos por defecto del curso para actualización
            $defaultCourse = [
                'id' => (int)$courseData['id'], // ID del curso es obligatorio
                'fullname' => $courseData['fullname'] ?? null,
                'shortname' => $courseData['shortname'] ?? null,
                'idnumber' => $courseData['idnumber'] ?? null,
                'summary' => $courseData['summary'] ?? null,
                'summaryformat' => $courseData['summaryformat'] ?? null,
                'format' => $courseData['format'] ?? null,
                'showgrades' => $courseData['showgrades'] ?? null,
                'newsitems' => $courseData['newsitems'] ?? null,
                'startdate' => $courseData['startdate'] ?? null,
                'enddate' => $courseData['enddate'] ?? null,
                'maxbytes' => $courseData['maxbytes'] ?? null,
                'showreports' => $courseData['showreports'] ?? null,
                'visible' => $courseData['visible'] ?? null,
                'groupmode' => $courseData['groupmode'] ?? null,
                'groupmodeforce' => $courseData['groupmodeforce'] ?? null,
                'defaultgroupingid' => $courseData['defaultgroupingid'] ?? null,
                'enablecompletion' => $courseData['enablecompletion'] ?? null,
                'completionnotify' => $courseData['completionnotify'] ?? null,
                'lang' => $courseData['lang'] ?? null,
                'forcetheme' => $courseData['forcetheme'] ?? null,
                'categoryid' => $courseData['categoryid'] ?? null
            ];

            // Remover campos null para enviar solo los campos que se quieren actualizar
            $courseToUpdate = array_filter($defaultCourse, function ($value) {
                return $value !== null;
            });

            // Construir parámetros para la API
            $params = [
                'courses' => [$courseToUpdate]
            ];

            // Construir URL para la API
            $serverUrl = $this->endpoint
                . '?wstoken=' . $this->token
                . '&wsfunction=' . $wsfunction
                . '&moodlewsrestformat=' . $this->restFormat;

            // Realizar la petición
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $serverUrl,
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => http_build_query($params),
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_TIMEOUT => 30
            ]);

            $response = curl_exec($curl);
            $errorInfo = "";
            $result = null;

            if ($response === false) {
                $errorInfo = 'Error cURL: ' . curl_error($curl);
            } else {
                $result = json_decode($response, true);

                // Verificar si hay errores en la respuesta
                if (isset($result['exception'])) {
                    $errorInfo = 'Error al actualizar curso: ' . ($result['message'] ?? 'Error desconocido')
                        . ' (Código: ' . ($result['errorcode'] ?? 'N/A') . ')';
                } elseif (isset($result['warnings']) && !empty($result['warnings'])) {
                    // Si hay warnings, considerarlo como error
                    $warnings = array_map(function ($warning) {
                        return $warning['message'] ?? 'Warning desconocido';
                    }, $result['warnings']);
                    $errorInfo = 'Warnings al actualizar curso: ' . implode(', ', $warnings);
                }
            }

            curl_close($curl);

            // Preparar respuesta
            return [
                "success" => empty($errorInfo),
                "error" => $errorInfo,
                "originalData" => $result,
                "courseInfo" => [
                    "courseId" => $courseData['id'],
                    "updatedFields" => array_keys($courseToUpdate),
                    "fieldCount" => count($courseToUpdate)
                ]
            ];

        } catch (Exception $e) {
            return [
                "success" => false,
                "error" => "Excepción: " . $e->getMessage(),
                "originalData" => null
            ];
        }
    }

    /**
     * Clona un curso en Moodle basado en plantillas predefinidas según subsector/red
     *
     * Ejemplo de uso:
     * $moodle = new Moodle();
     * $result = $moodle->cloneCourse('CURSO001');
     * if ($result['success']) {
     *     echo "Curso clonado con ID: " . $result['clonedCourseId'];
     * } else {
     *     echo "Error: " . $result['error'];
     * }
     *
     * @param string $courseCode Código del curso a clonar
     * @return array Array con success, clonedCourseId, error y originalData
     */
    function cloneCourse(string $courseCode): array
    {
        // Parámetros de conexión configurados directamente en la función
        $wsfunction = 'core_course_duplicate_course';
        $params = [
            'courseid' => '', // ID del curso plantilla a clonar
            'fullname' => '',
            'shortname' => '',
            'categoryid' => 1,
            'visible' => 1,
            'options' => [
                [
                    'name' => 'users',
                    'value' => 0 // No incluir usuarios
                ]
            ]
        ];

        try {
            // Cargar modelos necesarios
            $mcourses = model("App\Modules\Sie\Models\Sie_Courses");
            $mmodules = model("App\Modules\Sie\Models\Sie_Modules");
            $mpensums = model("App\Modules\Sie\Models\Sie_Pensums");

            // Obtener información del curso
            $course = $mcourses->get_Course($courseCode);
            if (!$course) {
                return [
                    "success" => false,
                    "clonedCourseId" => "",
                    "error" => "Curso no encontrado: $courseCode",
                    "originalData" => null
                ];
            }

            $pensum = $mpensums->get_Pensum($course["pensum"]);
            if (!$pensum) {
                return [
                    "success" => false,
                    "clonedCourseId" => "",
                    "error" => "Pensum no encontrado para el curso: $courseCode",
                    "originalData" => null
                ];
            }

            $module = $mmodules->get_Module($pensum["module"]);
            if (!$module) {
                return [
                    "success" => false,
                    "clonedCourseId" => "",
                    "error" => "Módulo no encontrado para el pensum del curso: $courseCode",
                    "originalData" => null
                ];
            }

            $red = $module["red"];
            $subsector = $module["subsector"];

            // Determinar el curso plantilla a clonar según subsector/red
            $clonar = "";
            if ($subsector == "SBM") {
                $clonar = "577"; // Módulo base red de transformación productiva - Subsector minería
            } elseif ($subsector == "SBA") {
                $clonar = "574"; // Módulo base red de transformación productiva - Subsector agrícola
            } elseif ($subsector == "SBG") {
                $clonar = "573"; // Módulo base red de arte, ocio y recreación - Subsector Gastronomía
            } elseif ($subsector == "SBS") {
                $clonar = "572"; // Módulo base red de arte, ocio y recreación - Subsector software
            } elseif ($subsector == "SBE") {
                $clonar = "571"; // Módulo base red de agregación de valor - Subsector empresarial
            } elseif ($red == "F") {
                $clonar = "576"; // Módulo base fundamentación
            } elseif ($red == "EI") {
                $clonar = "575"; // Módulo base red de escuela de idiomas
            }

            if (empty($clonar)) {
                return [
                    "success" => false,
                    "clonedCourseId" => "",
                    "error" => "No se pudo determinar el curso plantilla para red: $red, subsector: $subsector",
                    "originalData" => null
                ];
            }

            // Parámetros para la clonación
            $params['courseid'] = $clonar; // ID del curso plantilla a clonar
            $params['fullname'] = $course["name"];
            $params['shortname'] = $course["course"];

            // Construir URL para la API
            $serverUrl = $this->endpoint
                . '?wstoken=' . $this->token
                . '&wsfunction=' . $wsfunction
                . '&moodlewsrestformat=' . $this->restFormat;

            // Realizar la petición
            $curl = curl_init($serverUrl);
            curl_setopt_array($curl, [
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => http_build_query($params),
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_TIMEOUT => 30
            ]);

            $response = curl_exec($curl);
            $errorInfo = "";
            $clonedCourseId = "";
            $result = null;

            if ($response === false) {
                $errorInfo = 'Error cURL: ' . curl_error($curl);
            } else {
                $result = json_decode($response, true);
                if (isset($result['id'])) {
                    $clonedCourseId = $result['id'];
                    // Actualizar el ID del curso en la base de datos local
                    $siecourse = [
                        "course" => $course["course"],
                        "moodle_course" => $clonedCourseId,
                    ];
                    $mcourses->update($course['course'], $siecourse);
                } else {
                    $errorInfo = $result['message'] ?? 'Error al clonar el curso';
                }
            }

            curl_close($curl);

            // Preparar respuesta
            return [
                "success" => !empty($clonedCourseId),
                "clonedCourseId" => $clonedCourseId,
                "error" => $errorInfo,
                "originalData" => $result,
                "templateCourseId" => $clonar,
                "courseInfo" => [
                    "code" => $course["course"],
                    "name" => $course["name"],
                    "red" => $red,
                    "subsector" => $subsector
                ]
            ];

        } catch (Exception $e) {
            return [
                "success" => false,
                "clonedCourseId" => "",
                "error" => "Excepción: " . $e->getMessage(),
                "originalData" => null
            ];
        }
    }

    /**
     * Elimina un curso en Moodle por su ID
     *
     * Ejemplo de uso:
     * $moodle = new \App\Libraries\Moodle();
     * $result = $moodle->deleteCourse(123);
     * if ($result['success']) {
     *     echo "Curso eliminado exitosamente";
     * } else {
     *     echo "Error: " . $result['error'];
     * }
     *
     * @param int $courseId ID del curso a eliminar
     * @return array Array con success, error y originalData
     */
    function deleteCourse(int $courseId): array
    {
        $wsfunction = 'core_course_delete_courses';

        try {
            // Validar que el ID del curso sea válido
            if ($courseId <= 0) {
                return [
                    "success" => false,
                    "error" => "Debe proporcionar un ID de curso válido (mayor a 0)",
                    "originalData" => null
                ];
            }

            // Parámetros para la eliminación
            $params = [
                'courseids' => [$courseId]
            ];

            // Construir URL para la API
            $serverUrl = $this->endpoint
                . '?wstoken=' . $this->token
                . '&wsfunction=' . $wsfunction
                . '&moodlewsrestformat=' . $this->restFormat
                . '&' . http_build_query($params);

            // Realizar la petición
            $curl = curl_init($serverUrl);
            curl_setopt_array($curl, [
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => [],
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_TIMEOUT => 30
            ]);

            $response = curl_exec($curl);
            $errorInfo = "";
            $result = null;

            if ($response === false) {
                $errorInfo = 'Error cURL: ' . curl_error($curl);
            } else {
                $result = json_decode($response, true);
                if (isset($result['exception'])) {
                    $errorInfo = 'Error al eliminar el curso: ' . ($result['message'] ?? 'Error desconocido')
                        . ' (Código: ' . ($result['errorcode'] ?? 'N/A') . ')';
                }
            }

            curl_close($curl);
            // Preparar respuesta
            return [
                "success" => empty($errorInfo),
                "error" => $errorInfo,
                "originalData" => $result,
                "courseId" => $courseId
            ];

        } catch (Exception $e) {
            return [
                "success" => false,
                "error" => "Excepción: " . $e->getMessage(),
                "originalData" => null
            ];
        }
    }

    /**
     * Elimina un usuario (estudiante) de un curso en Moodle por ID de usuario del sistema
     *
     * Ejemplo de uso:
     * $moodle = new Moodle();
     * $result = $moodle->removeUserFromCourse(123, 'USR001');
     * if ($result['success']) {
     *     echo "Usuario eliminado del curso exitosamente";
     * } else {
     *     echo "Error: " . $result['error'];
     * }
     *
     * @param int $courseId ID del curso en Moodle
     * @param string $userId ID del usuario en el sistema SIE
     * @return array Array con success, error, originalData y userInfo
     */
    function removeUserFromCourse(int $courseId, string $identification): array
    {
        try {
            // Validar parámetros
            if ($courseId <= 0) {
                return [
                    "success" => false,
                    "error" => "ID del curso debe ser mayor a 0",
                    "originalData" => null
                ];
            }

            if (empty($identification)) {
                return [
                    "success" => false,
                    "error" => "ID del usuario es requerido",
                    "originalData" => null
                ];
            }

            // Obtener los datos del usuario desde el modelo
            $mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
            $registration = $mregistrations->get_RegistrationByIdentification($identification);

            if (!$registration || empty($registration["identification_number"])) {
                return [
                    "success" => false,
                    "error" => "No se pudo obtener la cédula del usuario con ID: " . $identification,
                    "originalData" => null
                ];
            }

            $identification_number = $registration["identification_number"];

            // 1. Buscar el usuario por username en Moodle
            $getUserFunction = 'core_user_get_users';
            $searchParams = http_build_query([
                'criteria' => [['key' => 'idnumber', 'value' => $identification_number]]
            ]);

            $getUserUrl = $this->endpoint
                . '?wstoken=' . $this->token
                . '&wsfunction=' . $getUserFunction
                . '&moodlewsrestformat=' . $this->restFormat
                . '&' . $searchParams;

            $curl = curl_init($getUserUrl);
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_TIMEOUT => 30
            ]);

            $response = curl_exec($curl);
            if ($response === false) {
                curl_close($curl);
                return [
                    "success" => false,
                    "error" => "Error cURL al buscar usuario: " . curl_error($curl),
                    "originalData" => null
                ];
            }
            curl_close($curl);

            $userResult = json_decode($response, true);
            if (empty($userResult['users'][0]['id'])) {
                return [
                    "success" => false,
                    "error" => "Usuario no encontrado en Moodle: " . $identification_number,
                    "originalData" => $userResult
                ];
            }

            $moodleUserId = $userResult['users'][0]['id'];

            // 2. Desenrolar usuario del curso
            $unenrollFunction = 'enrol_manual_unenrol_users';
            $unenrollParams = http_build_query([
                'enrolments' => [[
                    'userid' => $moodleUserId,
                    'courseid' => $courseId
                ]]
            ]);

            $unenrollUrl = $this->endpoint
                . '?wstoken=' . $this->token
                . '&wsfunction=' . $unenrollFunction
                . '&moodlewsrestformat=' . $this->restFormat;

            $curl = curl_init($unenrollUrl);
            curl_setopt_array($curl, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $unenrollParams,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_TIMEOUT => 30
            ]);

            $unenrollResponse = curl_exec($curl);
            if ($unenrollResponse === false) {
                $error = curl_error($curl);
                curl_close($curl);
                return [
                    "success" => false,
                    "error" => "Error cURL al eliminar usuario del curso: " . $error,
                    "originalData" => null
                ];
            }
            curl_close($curl);

            $unenrollResult = json_decode($unenrollResponse, true);
            if (isset($unenrollResult['exception'])) {
                return [
                    "success" => false,
                    "error" => "Error al eliminar usuario del curso: " . ($unenrollResult['message'] ?? 'Error desconocido'),
                    "originalData" => $unenrollResult
                ];
            }

            return [
                "success" => true,
                "error" => "",
                "originalData" => $unenrollResult,
                "userInfo" => [
                    "sieUserId" => $identification,
                    "moodleUserId" => $moodleUserId,
                    "username" => $identification_number,
                    "courseId" => $courseId,
                    "fullName" => ($userData["first_name"] ?? "") . " " . ($userData["first_surname"] ?? "")
                ]
            ];

        } catch (Exception $e) {
            return [
                "success" => false,
                "error" => "Excepción: " . $e->getMessage(),
                "originalData" => null
            ];
        }
    }

    /**
     * Reasigna el profesor de un curso (elimina todos los profesores existentes y asigna uno nuevo)
     *
     * Ejemplo de uso:
     * $moodle = new Moodle();
     * $result = $moodle->reassignTeacherInCourse(123, 'profesor_nuevo');
     * if ($result['success']) {
     *     echo "Profesor reasignado exitosamente";
     * } else {
     *     echo "Error: " . $result['error'];
     * }
     *
     * @param int $courseId ID del curso en Moodle
     * @param string $newTeacherUsername Username del nuevo profesor
     * @param int $roleId ID del rol (por defecto 3 = Profesor)
     * @return array Array con success, error, originalData y reassignmentInfo
     */
    function reassignTeacherInCourse(int $courseId, string $newTeacherUsername, int $roleId = 3): array
    {
        try {
            // Validar parámetros
            if ($courseId <= 0) {
                return [
                    "success" => false,
                    "error" => "ID del curso debe ser mayor a 0",
                    "originalData" => null
                ];
            }

            if (empty($newTeacherUsername)) {
                return [
                    "success" => false,
                    "error" => "Username del nuevo profesor es requerido",
                    "originalData" => null
                ];
            }

            // 1. Obtener todos los usuarios enrollados en el curso con rol de profesor
            $getEnrolledFunction = 'core_enrol_get_enrolled_users';
            $getEnrolledUrl = $this->endpoint
                . '?wstoken=' . $this->token
                . '&wsfunction=' . $getEnrolledFunction
                . '&moodlewsrestformat=' . $this->restFormat
                . '&courseid=' . $courseId;

            $curl = curl_init($getEnrolledUrl);
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_TIMEOUT => 30
            ]);

            $response = curl_exec($curl);
            if ($response === false) {
                curl_close($curl);
                return [
                    "success" => false,
                    "error" => "Error cURL al obtener usuarios enrollados: " . curl_error($curl),
                    "originalData" => null
                ];
            }
            curl_close($curl);

            $enrolledUsers = json_decode($response, true);
            if (isset($enrolledUsers['exception'])) {
                return [
                    "success" => false,
                    "error" => "Error al obtener usuarios enrollados: " . ($enrolledUsers['message'] ?? 'Error desconocido'),
                    "originalData" => $enrolledUsers
                ];
            }

            // 2. Filtrar solo los profesores (rol 3) y eliminarlos
            $removedTeachers = [];
            if (is_array($enrolledUsers)) {
                foreach ($enrolledUsers as $user) {
                    if (isset($user['roles']) && is_array($user['roles'])) {
                        foreach ($user['roles'] as $role) {
                            if (isset($role['roleid']) && $role['roleid'] == $roleId) {
                                // Este usuario tiene rol de profesor, eliminarlo
                                $removeResult = $this->removeTeacherFromCourse($courseId, $user['username']);
                                $removedTeachers[] = [
                                    'username' => $user['username'],
                                    'userId' => $user['id'],
                                    'removeResult' => $removeResult
                                ];
                                break; // Solo necesitamos eliminar una vez por usuario
                            }
                        }
                    }
                }
            }

            // 3. Asignar el nuevo profesor
            $assignResult = $this->assignTeacherToCourse($courseId, $newTeacherUsername, $roleId);
            if (!$assignResult['success']) {
                return [
                    "success" => false,
                    "error" => "Error al asignar nuevo profesor: " . $assignResult['error'],
                    "originalData" => $assignResult,
                    "reassignmentInfo" => [
                        "step" => "assign_new_teacher",
                        "newTeacher" => $newTeacherUsername,
                        "courseId" => $courseId,
                        "removedTeachers" => $removedTeachers
                    ]
                ];
            }

            return [
                "success" => true,
                "error" => "",
                "originalData" => [
                    "removedTeachers" => $removedTeachers,
                    "assignResult" => $assignResult
                ],
                "reassignmentInfo" => [
                    "step" => "completed",
                    "newTeacher" => $newTeacherUsername,
                    "courseId" => $courseId,
                    "newTeacherUserId" => $assignResult['teacherInfo']['userId'],
                    "roleId" => $roleId,
                    "removedTeachersCount" => count($removedTeachers),
                    "removedTeachers" => array_column($removedTeachers, 'username')
                ]
            ];

        } catch (Exception $e) {
            return [
                "success" => false,
                "error" => "Excepción: " . $e->getMessage(),
                "originalData" => null
            ];
        }
    }

    /**
     * Elimina un profesor de un curso en Moodle
     *
     * Ejemplo de uso:
     * $moodle = new Moodle();
     * $result = $moodle->removeTeacherFromCourse(123, 'profesor123');
     * if ($result['success']) {
     *     echo "Profesor eliminado exitosamente";
     * } else {
     *     echo "Error: " . $result['error'];
     * }
     *
     * @param int $courseId ID del curso en Moodle
     * @param string $teacherUsername Username del profesor (cédula)
     * @return array Array con success, error, originalData y teacherInfo
     */
    function removeTeacherFromCourse(int $courseId, string $teacherUsername): array
    {
        try {
            // Validar parámetros
            if ($courseId <= 0) {
                return [
                    "success" => false,
                    "error" => "ID del curso debe ser mayor a 0",
                    "originalData" => null
                ];
            }

            if (empty($teacherUsername)) {
                return [
                    "success" => false,
                    "error" => "Username del profesor es requerido",
                    "originalData" => null
                ];
            }

            // 1. Buscar el usuario por username
            $getUserFunction = 'core_user_get_users';
            $searchParams = http_build_query([
                'criteria' => [['key' => 'username', 'value' => $teacherUsername]]
            ]);

            $getUserUrl = $this->endpoint
                . '?wstoken=' . $this->token
                . '&wsfunction=' . $getUserFunction
                . '&moodlewsrestformat=' . $this->restFormat
                . '&' . $searchParams;

            $curl = curl_init($getUserUrl);
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_TIMEOUT => 30
            ]);

            $response = curl_exec($curl);
            if ($response === false) {
                curl_close($curl);
                return [
                    "success" => false,
                    "error" => "Error cURL al buscar usuario: " . curl_error($curl),
                    "originalData" => null
                ];
            }
            curl_close($curl);

            $userResult = json_decode($response, true);
            if (empty($userResult['users'][0]['id'])) {
                return [
                    "success" => false,
                    "error" => "Usuario no encontrado: " . $teacherUsername,
                    "originalData" => $userResult
                ];
            }

            $userId = $userResult['users'][0]['id'];

            // 2. Desenrolar usuario del curso
            $unenrollFunction = 'enrol_manual_unenrol_users';
            $unenrollParams = http_build_query([
                'enrolments' => [[
                    'userid' => $userId,
                    'courseid' => $courseId
                ]]
            ]);

            $unenrollUrl = $this->endpoint
                . '?wstoken=' . $this->token
                . '&wsfunction=' . $unenrollFunction
                . '&moodlewsrestformat=' . $this->restFormat;

            $curl = curl_init($unenrollUrl);
            curl_setopt_array($curl, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $unenrollParams,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_TIMEOUT => 30
            ]);

            $unenrollResponse = curl_exec($curl);
            if ($unenrollResponse === false) {
                $error = curl_error($curl);
                curl_close($curl);
                return [
                    "success" => false,
                    "error" => "Error cURL al eliminar profesor: " . $error,
                    "originalData" => null
                ];
            }
            curl_close($curl);

            $unenrollResult = json_decode($unenrollResponse, true);
            if (isset($unenrollResult['exception'])) {
                return [
                    "success" => false,
                    "error" => "Error al eliminar profesor: " . ($unenrollResult['message'] ?? 'Error desconocido'),
                    "originalData" => $unenrollResult
                ];
            }

            return [
                "success" => true,
                "error" => "",
                "originalData" => $unenrollResult,
                "teacherInfo" => [
                    "userId" => $userId,
                    "username" => $teacherUsername,
                    "courseId" => $courseId
                ]
            ];

        } catch (Exception $e) {
            return [
                "success" => false,
                "error" => "Excepción: " . $e->getMessage(),
                "originalData" => null
            ];
        }
    }

    /**
     * Asigna un profesor a un curso en Moodle
     *
     * Ejemplo de uso:
     * $moodle = new Moodle();
     * $result = $moodle->assignTeacherToCourse(123, 'profesor123');
     * if ($result['success']) {
     *     echo "Profesor asignado exitosamente";
     * } else {
     *     echo "Error: " . $result['error'];
     * }
     *
     * @param int $courseId ID del curso en Moodle
     * @param string $teacherUsername Username del profesor (cédula)
     * @param int $roleId ID del rol (por defecto 3 = Profesor)
     * @return array Array con success, error, originalData y teacherInfo
     */
    function assignTeacherToCourse(int $courseId, string $teacherUsername, int $roleId = 3): array
    {
        try {
            // Validar parámetros
            if ($courseId <= 0) {
                return [
                    "success" => false,
                    "error" => "ID del curso debe ser mayor a 0",
                    "originalData" => null
                ];
            }

            if (empty($teacherUsername)) {
                return [
                    "success" => false,
                    "error" => "Username del profesor es requerido",
                    "originalData" => null
                ];
            }

            // 1. Buscar el usuario por username
            $getUserFunction = 'core_user_get_users';
            $searchParams = http_build_query([
                'criteria' => [['key' => 'username', 'value' => $teacherUsername]]
            ]);

            $getUserUrl = $this->endpoint
                . '?wstoken=' . $this->token
                . '&wsfunction=' . $getUserFunction
                . '&moodlewsrestformat=' . $this->restFormat
                . '&' . $searchParams;

            $curl = curl_init($getUserUrl);
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_TIMEOUT => 30
            ]);

            $response = curl_exec($curl);
            if ($response === false) {
                curl_close($curl);
                return [
                    "success" => false,
                    "error" => "Error cURL al buscar usuario: " . curl_error($curl),
                    "originalData" => null
                ];
            }
            curl_close($curl);

            $userResult = json_decode($response, true);
            if (empty($userResult['users'][0]['id'])) {
                return [
                    "success" => false,
                    "error" => "Usuario no encontrado: " . $teacherUsername,
                    "originalData" => $userResult
                ];
            }

            $userId = $userResult['users'][0]['id'];

            // 2. Enrolar usuario en curso
            $enrollFunction = 'enrol_manual_enrol_users';
            $enrollParams = http_build_query([
                'enrolments' => [[
                    'roleid' => $roleId,
                    'userid' => $userId,
                    'courseid' => $courseId
                ]]
            ]);

            $enrollUrl = $this->endpoint
                . '?wstoken=' . $this->token
                . '&wsfunction=' . $enrollFunction
                . '&moodlewsrestformat=' . $this->restFormat;

            $curl = curl_init($enrollUrl);
            curl_setopt_array($curl, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $enrollParams,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_TIMEOUT => 30
            ]);

            $enrollResponse = curl_exec($curl);
            if ($enrollResponse === false) {
                $error = curl_error($curl);
                curl_close($curl);
                return [
                    "success" => false,
                    "error" => "Error cURL al asignar profesor: " . $error,
                    "originalData" => null
                ];
            }
            curl_close($curl);

            $enrollResult = json_decode($enrollResponse, true);
            if (isset($enrollResult['exception'])) {
                return [
                    "success" => false,
                    "error" => "Error al asignar profesor: " . ($enrollResult['message'] ?? 'Error desconocido'),
                    "originalData" => $enrollResult
                ];
            }

            return [
                "success" => true,
                "error" => "",
                "originalData" => $enrollResult,
                "teacherInfo" => [
                    "userId" => $userId,
                    "username" => $teacherUsername,
                    "courseId" => $courseId,
                    "roleId" => $roleId
                ]
            ];

        } catch (Exception $e) {
            return [
                "success" => false,
                "error" => "Excepción: " . $e->getMessage(),
                "originalData" => null
            ];
        }
    }

    /**
     * Enrola/agrega un usuario (estudiante) a un curso en Moodle
     *
     * @param int $courseId ID del curso en Moodle
     * @param string $identification Número de cédula del estudiante
     * @param int $roleId ID del rol en Moodle (5 = estudiante por defecto)
     * @return array Array con success, error, originalData y userInfo
     *
     * @example
     * $moodle = new \App\Libraries\Moodle();
     * $result = $moodle->enrollUserInCourse(123, "1234567890", 5);
     * if ($result['success']) {
     *     echo "Usuario enrolado exitosamente: " . $result['userInfo']['fullName'];
     * } else {
     *     echo "Error: " . $result['error'];
     * }
     */
    function enrollUserInCourse(int $courseId, string $identification, int $roleId = 5): array
    {
        try {
            // Validar parámetros
            if ($courseId <= 0) {
                return [
                    "success" => false,
                    "error" => "ID del curso debe ser mayor a 0",
                    "originalData" => null
                ];
            }

            if (empty($identification)) {
                return [
                    "success" => false,
                    "error" => "Número de cédula del estudiante es requerido",
                    "originalData" => null
                ];
            }

            if ($roleId <= 0) {
                return [
                    "success" => false,
                    "error" => "ID del rol debe ser mayor a 0",
                    "originalData" => null
                ];
            }

            // Obtener los datos del usuario desde el modelo
            $mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
            $registration = $mregistrations->get_RegistrationByIdentification($identification);

            if (!$registration || empty($registration["identification_number"])) {
                return [
                    "success" => false,
                    "error" => "No se pudo obtener la registración del usuario con cédula: " . $identification,
                    "originalData" => null
                ];
            }

            $identification_number = $registration["identification_number"];

            // 1. Buscar el usuario por idnumber en Moodle
            $getUserFunction = 'core_user_get_users';
            $searchParams = http_build_query([
                'criteria' => [['key' => 'idnumber', 'value' => $identification_number]]
            ]);

            $getUserUrl = $this->endpoint
                . '?wstoken=' . $this->token
                . '&wsfunction=' . $getUserFunction
                . '&moodlewsrestformat=' . $this->restFormat
                . '&' . $searchParams;

            $curl = curl_init($getUserUrl);
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_TIMEOUT => 30
            ]);

            $response = curl_exec($curl);
            if ($response === false) {
                curl_close($curl);
                return [
                    "success" => false,
                    "error" => "Error cURL al buscar usuario: " . curl_error($curl),
                    "originalData" => null
                ];
            }
            curl_close($curl);

            $userResult = json_decode($response, true);
            if (empty($userResult['users'][0]['id'])) {
                return [
                    "success" => false,
                    "error" => "Usuario no encontrado en Moodle: " . $identification_number,
                    "originalData" => $userResult
                ];
            }

            $moodleUserId = $userResult['users'][0]['id'];
            $userData = $userResult['users'][0];

            // 2. Enrolar el usuario en el curso
            $enrollFunction = 'enrol_manual_enrol_users';
            $enrollParams = http_build_query([
                'enrolments' => [
                    [
                        'roleid' => $roleId,
                        'userid' => $moodleUserId,
                        'courseid' => $courseId
                    ]
                ]
            ]);

            $enrollUrl = $this->endpoint
                . '?wstoken=' . $this->token
                . '&wsfunction=' . $enrollFunction
                . '&moodlewsrestformat=' . $this->restFormat
                . '&' . $enrollParams;

            $curl = curl_init($enrollUrl);
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_TIMEOUT => 30
            ]);

            $response = curl_exec($curl);
            if ($response === false) {
                curl_close($curl);
                return [
                    "success" => false,
                    "error" => "Error cURL al enrolar usuario: " . curl_error($curl),
                    "originalData" => null
                ];
            }
            curl_close($curl);

            $enrollResult = json_decode($response, true);

            // Verificar si hay errores en la respuesta
            if (isset($enrollResult['exception'])) {
                return [
                    "success" => false,
                    "error" => "Error de Moodle: " . $enrollResult['message'],
                    "originalData" => $enrollResult
                ];
            }

            if (isset($enrollResult['warnings']) && !empty($enrollResult['warnings'])) {
                return [
                    "success" => false,
                    "error" => "Warning de Moodle: " . $enrollResult['warnings'][0]['message'],
                    "originalData" => $enrollResult
                ];
            }

            return [
                "success" => true,
                "error" => "",
                "originalData" => $enrollResult,
                "userInfo" => [
                    "sieUserId" => $identification,
                    "moodleUserId" => $moodleUserId,
                    "username" => $identification_number,
                    "courseId" => $courseId,
                    "roleId" => $roleId,
                    "fullName" => ($userData["firstname"] ?? "") . " " . ($userData["lastname"] ?? "")
                ]
            ];

        } catch (Exception $e) {
            return [
                "success" => false,
                "error" => "Excepción: " . $e->getMessage(),
                "originalData" => null
            ];
        }
    }

    /**
     * Crea un usuario en Moodle sin asignarle ningún rol
     * Ejemplo de uso:
     * $moodle = new Moodle();
     * $userData = [
     *     'username' => '1234567890',
     *     'password' => 'TempPass123!',
     *     'firstname' => 'Juan',
     *     'lastname' => 'Pérez',
     *     'email' => 'juan.perez@example.com',
     *     'idnumber' => '1234567890'
     * ];
     * $result = $moodle->createUser($userData);
     * if ($result['success']) {
     *     echo "Usuario creado con ID: " . $result['userId'];
     * } else {
     *     echo "Error: " . $result['error'];
     * }
     * @param array $userData Datos del usuario a crear
     * @return array Array con success, userId, error, originalData y userInfo
     */
    function createUser(array $userData): array
    {
        $wsfunction = 'core_user_create_users';

        try {
            // Validar campos obligatorios
            $requiredFields = ['username', 'password', 'firstname', 'lastname', 'email'];
            foreach ($requiredFields as $field) {
                if (empty($userData[$field])) {
                    return [
                        "success" => false,
                        "userId" => null,
                        "error" => "Campo obligatorio faltante: $field",
                        "originalData" => null
                    ];
                }
            }

            // Validar formato de email
            if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
                return [
                    "success" => false,
                    "userId" => null,
                    "error" => "Formato de email inválido: " . $userData['email'],
                    "originalData" => null
                ];
            }

            // Configurar datos por defecto del usuario
            $defaultUser = [
                'username' => $userData['username'],
                'password' => $userData['password'],
                'firstname' => $userData['firstname'],
                'lastname' => $userData['lastname'],
                'email' => $userData['email'],
                'idnumber' => $userData['idnumber'] ?? $userData['username'],
                'lang' => $userData['lang'] ?? 'es',
                'timezone' => $userData['timezone'] ?? 'America/Bogota',
                'mailformat' => $userData['mailformat'] ?? 1,
                'description' => $userData['description'] ?? '',
                'city' => $userData['city'] ?? 'Bogotá',
                'country' => $userData['country'] ?? 'CO',
                'firstnamephonetic' => $userData['firstnamephonetic'] ?? '',
                'lastnamephonetic' => $userData['lastnamephonetic'] ?? '',
                'middlename' => $userData['middlename'] ?? '',
                'alternatename' => $userData['alternatename'] ?? ''
            ];

            // Construir parámetros para la API
            $params = [
                'users' => [$defaultUser]
            ];

            // Construir URL para la API
            $serverUrl = $this->endpoint
                . '?wstoken=' . $this->token
                . '&wsfunction=' . $wsfunction
                . '&moodlewsrestformat=' . $this->restFormat;

            // Realizar la petición
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $serverUrl,
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => http_build_query($params),
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_TIMEOUT => 30
            ]);

            $response = curl_exec($curl);
            $errorInfo = "";
            $result = null;
            $userId = null;

            if ($response === false) {
                $errorInfo = 'Error cURL: ' . curl_error($curl);
            } else {
                $result = json_decode($response, true);

                // Verificar si hay errores en la respuesta
                if (isset($result['exception'])) {
                    $errorInfo = 'Error al crear usuario: ' . ($result['message'] ?? 'Error desconocido')
                        . ' (Código: ' . ($result['errorcode'] ?? 'N/A') . ')';
                } elseif (isset($result['warnings']) && !empty($result['warnings'])) {
                    // Si hay warnings, considerarlo como error
                    $warnings = array_map(function ($warning) {
                        return $warning['message'] ?? 'Warning desconocido';
                    }, $result['warnings']);
                    $errorInfo = 'Warnings al crear usuario: ' . implode(', ', $warnings);
                } elseif (isset($result[0]['id']) && is_numeric($result[0]['id'])) {
                    // Usuario creado exitosamente
                    $userId = (int)$result[0]['id'];
                } else {
                    $errorInfo = 'Respuesta inesperada de Moodle al crear usuario';
                }
            }

            curl_close($curl);

            // Preparar respuesta
            return [
                "success" => empty($errorInfo) && !is_null($userId),
                "userId" => $userId,
                "error" => $errorInfo,
                "originalData" => $result,
                "userInfo" => [
                    "username" => $userData['username'],
                    "firstname" => $userData['firstname'],
                    "lastname" => $userData['lastname'],
                    "email" => $userData['email'],
                    "idnumber" => $defaultUser['idnumber'],
                    "fullName" => $userData['firstname'] . ' ' . $userData['lastname'],
                    "moodleUserId" => $userId
                ]
            ];

        } catch (Exception $e) {
            return [
                "success" => false,
                "userId" => null,
                "error" => "Excepción: " . $e->getMessage(),
                "originalData" => null
            ];
        }
    }

    /**
     * Consulta los datos del perfil de un usuario en Moodle
     * Ejemplo de uso:
     * $moodle = new Moodle();
     * $result = $moodle->getUserProfile('1234567890');
     * if ($result['success']) {
     *     echo "Usuario encontrado: " . $result['userInfo']['fullName'];
     * } else {
     *     echo "Error: " . $result['error'];
     * }
     *
     * @param string $searchValue Valor a buscar (username, email, idnumber)
     * @param string $searchField Campo por el cual buscar (username, email, idnumber)
     * @return array Array con success, error, originalData y userInfo
     */
    function getUserProfile(string $searchValue, string $searchField = 'idnumber'): array
    {
        $wsfunction = 'core_user_get_users';

        try {
            // Validar parámetros
            if (empty($searchValue)) {
                return [
                    "success" => false,
                    "error" => "Valor de búsqueda es requerido",
                    "originalData" => null,
                    "userInfo" => null
                ];
            }

            // Validar campo de búsqueda
            $validFields = ['username', 'email', 'idnumber'];
            if (!in_array($searchField, $validFields)) {
                return [
                    "success" => false,
                    "error" => "Campo de búsqueda inválido. Debe ser: " . implode(', ', $validFields),
                    "originalData" => null,
                    "userInfo" => null
                ];
            }

            // Construir parámetros de búsqueda
            $searchParams = http_build_query([
                'criteria' => [['key' => $searchField, 'value' => $searchValue]]
            ]);

            // Construir URL para la API
            $getUserUrl = $this->endpoint
                . '?wstoken=' . $this->token
                . '&wsfunction=' . $wsfunction
                . '&moodlewsrestformat=' . $this->restFormat
                . '&' . $searchParams;

            // Realizar la petición
            $curl = curl_init($getUserUrl);
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_TIMEOUT => 30
            ]);

            $response = curl_exec($curl);
            $errorInfo = "";
            $result = null;
            $userInfo = null;

            if ($response === false) {
                $errorInfo = 'Error cURL: ' . curl_error($curl);
            } else {
                $result = json_decode($response, true);

                // Verificar si hay errores en la respuesta
                if (isset($result['exception'])) {
                    $errorInfo = 'Error al consultar usuario: ' . ($result['message'] ?? 'Error desconocido')
                        . ' (Código: ' . ($result['errorcode'] ?? 'N/A') . ')';
                } elseif (isset($result['warnings']) && !empty($result['warnings'])) {
                    $warnings = array_map(function ($warning) {
                        return $warning['message'] ?? 'Warning desconocido';
                    }, $result['warnings']);
                    $errorInfo = 'Warnings al consultar usuario: ' . implode(', ', $warnings);
                } elseif (empty($result['users'])) {
                    $errorInfo = "Usuario no encontrado con $searchField: $searchValue";
                } else {
                    // Usuario encontrado, extraer información
                    $user = $result['users'][0];
                    $userInfo = [
                        "id" => $user['id'] ?? null,
                        "username" => $user['username'] ?? '',
                        "firstname" => $user['firstname'] ?? '',
                        "lastname" => $user['lastname'] ?? '',
                        "fullname" => ($user['firstname'] ?? '') . ' ' . ($user['lastname'] ?? ''),
                        "email" => $user['email'] ?? '',
                        "idnumber" => $user['idnumber'] ?? '',
                        "lang" => $user['lang'] ?? '',
                        "timezone" => $user['timezone'] ?? '',
                        "description" => $user['description'] ?? '',
                        "city" => $user['city'] ?? '',
                        "country" => $user['country'] ?? '',
                        "profileimageurlsmall" => $user['profileimageurlsmall'] ?? '',
                        "profileimageurl" => $user['profileimageurl'] ?? '',
                        "firstaccess" => $user['firstaccess'] ?? null,
                        "lastaccess" => $user['lastaccess'] ?? null,
                        "lastcourseaccess" => $user['lastcourseaccess'] ?? null,
                        "suspended" => $user['suspended'] ?? false,
                        "confirmed" => $user['confirmed'] ?? false,
                        "mailformat" => $user['mailformat'] ?? null,
                        "theme" => $user['theme'] ?? '',
                        "auth" => $user['auth'] ?? '',
                        "customfields" => $user['customfields'] ?? []
                    ];
                }
            }

            curl_close($curl);

            // Preparar respuesta
            return [
                "success" => empty($errorInfo) && !is_null($userInfo),
                "error" => $errorInfo,
                "originalData" => $result,
                "userInfo" => $userInfo,
                "searchCriteria" => [
                    "field" => $searchField,
                    "value" => $searchValue
                ]
            ];

        } catch (Exception $e) {
            return [
                "success" => false,
                "error" => "Excepción: " . $e->getMessage(),
                "originalData" => null,
                "userInfo" => null
            ];
        }
    }

    /**
     * Actualiza los datos de un usuario en Moodle
     * Ejemplo de uso:
     * $moodle = new Moodle();
     * $userData = [
     *     'id' => 123,
     *     'firstname' => 'Juan',
     *     'lastname' => 'Pérez',
     *     'email' => 'juan.perez@example.com'
     * ];
     * $result = $moodle->updateUser($userData);
     * if ($result['success']) {
     *     echo "Usuario actualizado exitosamente";
     * } else {
     *     echo "Error: " . $result['error'];
     * }
     *
     * @param array $userData Datos del usuario a actualizar (debe incluir 'id')
     * @return array Array con success, error, originalData y userInfo
     */
    function updateUser(array $userData): array
    {
        $wsfunction = 'core_user_update_users';

        try {
            // Validar campo obligatorio
            if (empty($userData['id']) || !is_numeric($userData['id'])) {
                return [
                    "success" => false,
                    "error" => "ID del usuario es obligatorio y debe ser numérico",
                    "originalData" => null,
                    "userInfo" => null
                ];
            }

            // Configurar datos del usuario para actualización
            $userToUpdate = [
                'id' => (int)$userData['id'], // ID del usuario es obligatorio
                'firstname' => $userData['firstname'] ?? null,
                'lastname' => $userData['lastname'] ?? null,
                'email' => $userData['email'] ?? null,
                'idnumber' => $userData['idnumber'] ?? null,
                'lang' => $userData['lang'] ?? null,
                'timezone' => $userData['timezone'] ?? null,
                'description' => $userData['description'] ?? null,
                'city' => $userData['city'] ?? null,
                'country' => $userData['country'] ?? null,
                'mailformat' => $userData['mailformat'] ?? null,
                'theme' => $userData['theme'] ?? null
            ];

            // Remover campos null para enviar solo los campos que se quieren actualizar
            $userToUpdate = array_filter($userToUpdate, function ($value) {
                return $value !== null;
            });

            // Construir parámetros para la API
            $params = [
                'users' => [$userToUpdate]
            ];

            // Construir URL para la API
            $serverUrl = $this->endpoint
                . '?wstoken=' . $this->token
                . '&wsfunction=' . $wsfunction
                . '&moodlewsrestformat=' . $this->restFormat;

            // Realizar la petición
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $serverUrl,
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => http_build_query($params),
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_TIMEOUT => 30
            ]);

            $response = curl_exec($curl);
            $errorInfo = "";
            $result = null;

            if ($response === false) {
                $errorInfo = 'Error cURL: ' . curl_error($curl);
            } else {
                $result = json_decode($response, true);

                // Verificar si hay errores en la respuesta
                if (isset($result['exception'])) {
                    $errorInfo = 'Error al actualizar usuario: ' . ($result['message'] ?? 'Error desconocido')
                        . ' (Código: ' . ($result['errorcode'] ?? 'N/A') . ')';
                } elseif (isset($result['warnings']) && !empty($result['warnings'])) {
                    // Si hay warnings, considerarlo como error
                    $warnings = array_map(function ($warning) {
                        return $warning['message'] ?? 'Warning desconocido';
                    }, $result['warnings']);
                    $errorInfo = 'Warnings al actualizar usuario: ' . implode(', ', $warnings);
                }
            }

            curl_close($curl);

            // Preparar respuesta
            return [
                "success" => empty($errorInfo),
                "error" => $errorInfo,
                "originalData" => $result,
                "userInfo" => [
                    "userId" => $userData['id'],
                    "updatedFields" => array_keys($userToUpdate),
                    "fieldCount" => count($userToUpdate)
                ]
            ];

        } catch (Exception $e) {
            return [
                "success" => false,
                "error" => "Excepción: " . $e->getMessage(),
                "originalData" => null,
                "userInfo" => null
            ];
        }
    }

    /**
     * Elimina un usuario de Moodle por su ID
     *
     * Ejemplo de uso:
     * $moodle = new \App\Libraries\Moodle();
     * $result = $moodle->deleteUser(123);
     * if ($result['success']) {
     *     echo "Usuario eliminado exitosamente";
     * } else {
     *     echo "Error: " . $result['error'];
     * }
     *
     * @param int $userId ID del usuario en Moodle
     * @return array Array con success, error, originalData y userInfo
     */
    function deleteUser(int $userId): array
    {
        $wsfunction = 'core_user_delete_users';

        try {
            // Validar que el ID del usuario sea válido
            if ($userId <= 0) {
                return [
                    "success" => false,
                    "error" => "ID de usuario inválido: $userId",
                    "originalData" => null,
                    "userInfo" => null
                ];
            }

            // Construir parámetros para la API
            $params = [
                'userids' => [$userId]
            ];

            // Construir URL para la API
            $serverUrl = $this->endpoint
                . '?wstoken=' . $this->token
                . '&wsfunction=' . $wsfunction
                . '&moodlewsrestformat=' . $this->restFormat;

            // Realizar la petición
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $serverUrl,
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => http_build_query($params),
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_TIMEOUT => 30
            ]);

            $response = curl_exec($curl);
            $errorInfo = "";
            $result = null;

            if ($response === false) {
                $errorInfo = 'Error cURL: ' . curl_error($curl);
            } else {
                $result = json_decode($response, true);

                // Verificar si hay errores en la respuesta
                if (isset($result['exception'])) {
                    $errorInfo = 'Error al eliminar usuario: ' . ($result['message'] ?? 'Error desconocido')
                        . ' (Código: ' . ($result['errorcode'] ?? 'N/A') . ')';
                } elseif (isset($result['warnings']) && !empty($result['warnings'])) {
                    // Si hay warnings, considerarlo como error
                    $warnings = array_map(function ($warning) {
                        return $warning['message'] ?? 'Warning desconocido';
                    }, $result['warnings']);
                    $errorInfo = 'Warnings al eliminar usuario: ' . implode(', ', $warnings);
                } elseif ($result === null || $result === []) {
                    // Respuesta vacía significa éxito en eliminación
                    $errorInfo = "";
                } else {
                    $errorInfo = 'Respuesta inesperada de Moodle al eliminar usuario';
                }
            }

            curl_close($curl);

            if (empty($errorInfo)) {
                return [
                    "success" => true,
                    "error" => null,
                    "originalData" => $result,
                    "userInfo" => [
                        "userId" => $userId,
                        "deleted" => true
                    ]
                ];
            } else {
                return [
                    "success" => false,
                    "error" => $errorInfo,
                    "originalData" => $result,
                    "userInfo" => null
                ];
            }
        } catch (Exception $e) {
            return [
                "success" => false,
                "error" => "Excepción: " . $e->getMessage(),
                "originalData" => null,
                "userInfo" => null
            ];
        }
    }
}

?>