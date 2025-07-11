/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */

// Provide a fileName and get fileExt and mode set based on supported languages

fileExt = fileName.split(".");
fileExt = fileExt[fileExt.length - 1];

var mode =
    fileExt == "js" ? "text/javascript"
        : fileExt == "json" ? "text/javascript"
            : fileExt == "coffee" ? "text/x-coffeescript"
                : fileExt == "ts" ? "application/typescript"
                    : fileExt == "rb" ? "text/x-ruby"
                        : fileExt == "py" ? "text/x-python"
                            : fileExt == "mpy" ? "text/x-python"
                                : fileExt == "css" ? "text/css"
                                    : fileExt == "less" ? "text/x-less"
                                        : fileExt == "md" ? "text/x-markdown"
                                            : fileExt == "xml" ? "application/xml"
                                                : fileExt == "sql" ? "text/x-mysql" // also text/x-sql, text/x-mariadb, text/x-cassandra or text/x-plsql
                                                    : fileExt == "erl" ? "text/x-erlang"
                                                        : fileExt == "yaml" ? "text/x-yaml"
                                                            : fileExt == "java" ? "text/x-java"
                                                                : fileExt == "jl" ? "text/x-julia"
                                                                    : fileExt == "c" ? "text/x-csrc"
                                                                        : fileExt == "h" ? "text/x-csrc"
                                                                            : fileExt == "cpp" ? "text/x-c++src"
                                                                                : fileExt == "ino" ? "text/x-c++src"
                                                                                    : fileExt == "cs" ? "text/x-csharp"
                                                                                        : fileExt == "go" ? "text/x-go"
                                                                                            : fileExt == "lua" ? "text/x-lua"
                                                                                                : fileExt == "pl" ? "text/x-perl"
                                                                                                    : fileExt == "scss" ? "text/x-sass"
                                                                                                        : "application/x-httpd-php";
