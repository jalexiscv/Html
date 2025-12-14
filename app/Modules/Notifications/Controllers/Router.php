<?php

namespace App\Modules\Notifications\Controllers;

use Higgs\Controller;
use Higgs\Exceptions\PageNotFoundException;
use Higgs\HTTP\ResponseInterface;
use ReflectionException;
use ReflectionMethod;

/**
 * Clase Router Controller
 * Controlador personalizado para implementar un enfoque de enrutamiento "lazy".
 */
class Router extends Controller
{
    /**
     * Método para enrutar las solicitudes de manera dinámica
     * Este método toma dos parámetros de la URL, los trata como el nombre del controlador y el método,
     * y luego intenta llamar a ese método del controlador. Si el controlador o el método no existen,
     * se lanza un error 404.
     * @param string $controller El primer segmento de la URL, tratado como el nombre del controlador.
     * @param string $method El segundo segmento de la URL, tratado como el nombre del método.
     * @return mixed El resultado de llamar al método del controlador.
     * @throws PageNotFoundException Si el controlador o el método no existen.
     */
    public function route2($controller, $method)
    {
        // Convierte los nombres de la URL a la convención de nombres de las clases y los métodos
        $module = "Notifications";
        $controller = ucfirst($controller);
        $method = strtolower($method);
        // Construye el nombre de clase completo con su espacio de nombres
        $class = "\App\Modules\\{$module}\\Controllers\\{$controller}";
        // Verifica si la clase y el método existen
        if (class_exists($class) && method_exists($class, $method)) {
            // Si existen, crea una nueva instancia de la clase
            $instance = new $class;
            // Obtiene los argumentos adicionales
            $args = array_slice(func_get_args(), 2);
            // Llama al método con los argumentos
            return call_user_func_array([$instance, $method], $args);
        } else {
            // Si no existen, muestra un error 404
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function route($component = "home", $view = "index", ...$params)
    {
        $class = "\\App\\Modules\\Notifications\\Controllers\\" . ucfirst($component);
        if (class_exists($class)) {
            $controller = new $class();
            if (method_exists($controller, $view)) {
                try {
                    $reflectionMethod = new ReflectionMethod($controller, $view);
                    $requiredParams = $reflectionMethod->getNumberOfRequiredParameters();
                    if (count($params) >= $requiredParams) {
                        return ($controller->$view(...$params));
                    } else {
                        return (view('errors/html/error_404', ["message" => "Parámetros insuficientes para el método {$view} en el controlador {$component}."]));
                    }
                } catch (ReflectionException $e) {
                    return (view('errors/html/error_404', ["message" => "Error de reflexión para el método {$view} en el controlador {$component}."]));
                }
            } else {
                return (view('errors/html/error_404', ["message" => "La vista(método) \"<b>{$view}</b>\" no existe en el componente(controlador) \"<b>{$component}</b>\"."]));
            }
        } else {
            return (view('errors/html/error_404', ["message" => "El componente(controlador) \"<b>{$component}</b>\" no existe."]));
        }
    }


}

?>