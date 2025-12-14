<?php

namespace App\Modules\Sie\Controllers;

use Higgs\API\ResponseTrait;
use Higgs\RESTful\ResourceController;

/**
 * Api
 */
class Api extends ResourceController
{
    use ResponseTrait;

    public $namespace;
    protected $prefix;
    protected $module;
    protected $views;
    protected $viewer;
    protected $component;

    public function __construct()
    {
        //header("Content-Type: text/json");
        $this->prefix = 'web-api';
        $this->module = 'App\Modules\Sie';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        $this->component = $this->views . '\Api';
        helper('App\Helpers\Application');
        helper($this->module . '\Helpers\Sie_helper');
    }

    // all users
    public function index()
    {
        $data = array("message" => "Api Online!");
        return $this->respond($data);
    }

    /**
     * Estudiantes
     *
     * @examples 1) http://localhost:8080/sie/api/students/json/list/1
     * @examples 2) http://localhost:8080/sie/api/students/json/cantakecourse/1
     * @param string $format Formato de la respuesta
     * @param string $option Opción de la respuesta
     *                         - list: lista de estudiantes
     *                         - cantakecourse: lista de estudiantes que pueden tomar el curso
     * @param string $oid OID del curso
     * @return void
     */
    public function students(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        //header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Sie\Views\Students\List\json', $data));
            } elseif ($option == "cantakecourse") { // Estudiantes que pueden tomar el curso
                echo(view('App\Modules\Sie\Views\Courses\View\Api\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sie.Api-breaches-no-option")));
        }
    }

    public function teachers(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        //header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Sie\Views\Teachers\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sie.Api-breaches-no-option")));
        }
    }

    public function programs(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        //header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Sie\Views\Programs\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sie.Api-breaches-no-option")));
        }
    }


    public function grids(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        //header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'select') {
                echo(view('App\Modules\Sie\Views\Api\grids', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sie.Api-breaches-no-option")));
        }
    }

    public function versions(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        //header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'active') {
                echo(view('App\Modules\Sie\Views\Api\Versions\active', $data));
            } elseif ($option == 'all') {
                echo(view('App\Modules\Sie\Views\Api\Versions\all', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sie.Api-breaches-no-option")));
        }
    }

    public function pensums(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'select') {
                echo(view('App\Modules\Sie\Views\Api\Pensums\select', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sie.Api-breaches-no-option")));
        }
    }


    public function modules(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        //header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Sie\Views\Modules\List\json', $data));
            } elseif ($option == 'select') {
                echo(view('App\Modules\Sie\Views\Api\Pensums\list', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sie.Api-breaches-no-option")));
        }
    }

    public function courses(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        //header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Sie\Views\Courses\List\json', $data));
            } elseif ($option == 'modules') {
                echo(view('App\Modules\Sie\Views\Courses\Modules\json', $data));
            } elseif ($option == 'pensum') {
                echo(view('App\Modules\Sie\Views\Api\Courses\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sie.Api-breaches-no-option")));
        }
    }


    public function products(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        //header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Sie\Views\Products\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sie.Api-breaches-no-option")));
        }
    }


    public function productsbydiscount(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        //header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Sie\Views\Discounts\View\json.php', $data));
            } elseif ($option == 'edit') {
                echo(view('App\Modules\Sie\Views\Discounts\View\check.php', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sie.Api-breaches-no-option")));
        }
    }


    public function discounts(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        //header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Sie\Views\Discounts\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sie.Api-breaches-no-option")));
        }
    }

    public function registrations(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        //header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Sie\Views\Registrations\List\json', $data));
            } elseif ($option == 'identification') {
                echo(view('App\Modules\Sie\Views\Api\Registrations\identification', $data));
            } elseif ($option == 'regions') {
                echo(view('App\Modules\Sie\Views\Api\regions', $data));
            } elseif ($option == 'cities') {
                echo(view('App\Modules\Sie\Views\Api\cities', $data));
            } elseif ($option == 'status') {
                echo(view('App\Modules\Sie\Views\Api\Registrations\status', $data));
            } elseif ($option == 'groups') {
                echo(view('App\Modules\Sie\Views\Api\Registrations\groups', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sie.Api-breaches-no-option")));
        }
    }

    public function agreementsOLD(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        //header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Sie\Views\Agreements\List\json', $data));
            } elseif ($option == 'identification') {
                echo(view('App\Modules\Sie\Views\Api\Agreements\identification', $data));
            } elseif ($option == 'regions') {
                echo(view('App\Modules\Sie\Views\Api\regions', $data));
            } elseif ($option == 'cities') {
                echo(view('App\Modules\Sie\Views\Api\cities', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sie.Api-breaches-no-option")));
        }
    }

    public function enrollments(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        //header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Sie\Views\Enrollments\List\json', $data));
            } elseif ($option == 'academic') {
                echo(view('App\Modules\Sie\Views\Enrollments\Academic\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sie.Api-breaches-no-option")));
        }
    }

    public function payments(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        //header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Sie\Views\Payments\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sie.Api-breaches-no-option")));
        }
    }


    public function discounteds(string $format, string $option, string $oid)
    {
        header("Content-Type: text/json");
        //header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'create') {
                echo(view('App\Modules\Sie\Views\Api\Discounteds\create', $data));
            } elseif ($option == 'delete') {
                echo(view('App\Modules\Sie\Views\Api\Discounteds\delete', $data));
            } elseif ($option == 'list') {
                echo(view('App\Modules\Sie\Views\Api\Discounteds\list', $data));
            } else {
                echo("Opción desconocida o no hay opción: {$option}");
            }
        } else {
            return ($this->failNotFound(lang("Sie.Api-breaches-no-option")));
        }
    }


    public function institutions(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Sie\Views\Institutions\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sie.Api-breaches-no-option")));
        }
    }

    public function agreements(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Sie\Views\Agreements\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sie.Api-breaches-no-option")));
        }
    }


    public function headquarters(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Sie\Views\Headquarters\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sie.Api-breaches-no-option")));
        }
    }

    public function spaces(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Sie\Views\Spaces\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sie.Api-breaches-no-option")));
        }
    }


    public function executions(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        //header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'update') {
                echo(view('App\Modules\Sie\Views\Executions\Update\json', $data));
            } elseif ($option == 'change') {
                echo(view('App\Modules\Sie\Views\Executions\Change\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sie.Api-breaches-no-option")));
        }
    }

    /**
     * Eje: http://localhost:8080/sie/api/observations/json/create/1
     * @param string $format
     * @param string $option
     * @param string $oid
     * @return void
     */
    public function observations(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        //header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'create') {
                echo(view('App\Modules\Sie\Views\Observations\Api\Create\index', $data));
            } elseif ($option == 'read') {
                echo(view('App\Modules\Sie\Views\Observations\Api\Read\index', $data));
            } elseif ($option == 'edit') {
                echo(view('App\Modules\Sie\Views\Observations\Api\Edit\index', $data));
            } elseif ($option == 'delete') {
                echo(view('App\Modules\Sie\Views\Observations\Api\Delete\index', $data));
            } elseif ($option == 'grid') {
                echo(view('App\Modules\Sie\Views\Observations\Api\Grid\index', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sie.Api-breaches-no-option")));
        }
    }


    /**
     * Eje: http://localhost:8080/sie/api/observations/json/create/1
     * @param string $format
     * @param string $option
     * @param string $oid
     * @return void
     */
    public function orders(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        //header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'create') {
                echo(view('App\Modules\Sie\Views\Orders\Api\create', $data));
            } elseif ($option == 'grid') {
                echo(view('App\Modules\Sie\Views\Orders\Api\grid', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sie.Api-breaches-no-option")));
        }
    }

    public function reports(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        //header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'freeofcharge') {
                echo(view('App\Modules\Sie\Views\Reports\Snies\Freeofcharge\json', $data));
            } elseif ($option == 'enrolledcourses') {
                echo(view('App\Modules\Sie\Views\Reports\Snies\EnrolledCourses\json', $data));
            } else {
                return ($option);
            }
        } else {
            return ($this->failNotFound(lang("Sie.Api-breaches-no-option")));
        }
    }

    public function moodle(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        //header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'users') {
                echo(view('App\Modules\Sie\Views\Moodle\Api\users', $data));
            } elseif ($option == 'courses') {
                echo(view('App\Modules\Sie\Views\Moodle\Api\courses', $data));
            } elseif ($option == 'course-synch') {
                echo(view('App\Modules\Sie\Views\Tools\Moodle\Courses\Api\json', $data));
            } elseif ($option == 'teachers-update') {
                echo(view('App\Modules\Sie\Views\Moodle\Teachers\Synchronization\moodle-teachers', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sie.Api-breaches-no-option")));
        }
    }


    /**
     * Metódo de ejemplo para la creacion de nuevos metodos en el API
     * @param string $format json or html
     * @param string $option list
     * @param string $oid oid of the module
     * @return void
     */
    public function test(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        //header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Sie\Views\test\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Sie.Api-breaches-no-option")));
        }
    }


}
