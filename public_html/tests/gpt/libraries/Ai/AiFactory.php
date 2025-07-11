<?php
namespace App\Libraries\Ai;

/**
 * Fábrica para crear instancias de diferentes proveedores de IA
 * 
 * Esta clase implementa el patrón Factory para manejar la creación de
 * diferentes implementaciones de servicios de IA. Permite registrar
 * nuevos proveedores dinámicamente y garantiza que las implementaciones
 * sean válidas.
 * 
 * @package Libraries
 */
class AiFactory {
    /**
     * Registro de proveedores de IA disponibles
     * 
     * Mapeo de nombres de proveedores a sus clases correspondientes
     * @var array<string, string>
     */
    private static $providers = [
        'claude' => ClaudeAi::class,
        // Agregar más proveedores aquí conforme estén disponibles
        // 'gemini' => GeminiAi::class,
        // 'meta' => MetaAi::class,
    ];

    /**
     * Crea una nueva instancia de un proveedor de IA
     * 
     * @param string $provider Identificador del proveedor (ej: 'claude', 'gemini')
     * @param array $config Configuración específica para el proveedor
     * @return Ai Instancia del proveedor de IA solicitado
     * @throws \Exception Si el proveedor no está registrado
     */
    public static function create(string $provider, array $config): Ai {
        if (!isset(self::$providers[$provider])) {
            throw new \Exception("Unsupported AI provider: {$provider}");
        }

        $className = self::$providers[$provider];
        return new $className($config);
    }

    /**
     * Registra un nuevo proveedor de IA en la fábrica
     * 
     * @param string $name Identificador único para el proveedor
     * @param string $className Nombre completo de la clase del proveedor
     * @throws \Exception Si la clase no existe o no extiende la clase base Ai
     */
    public static function registerProvider(string $name, string $className): void {
        if (!class_exists($className)) {
            throw new \Exception("Class {$className} does not exist");
        }

        if (!is_subclass_of($className, Ai::class)) {
            throw new \Exception("Class {$className} must extend the Ai base class");
        }

        self::$providers[$name] = $className;
    }
}
?>
