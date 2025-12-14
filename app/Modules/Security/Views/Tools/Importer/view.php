<?php
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

use App\Libraries\Sender;

$bootstrap = service("bootstrap");
//[models]--------------------------------------------------------------------------------------------------------------
$musers = model("App\Modules\Security\Models\Security_Users");
$mfields = model("App\Modules\Security\Models\Security_Users_Fields");

$users = $musers->withDeleted()->findAll();


$usuarios = array(
    array("username" => "laguirregonzalez", "password" => "1670765", "firstname" => "Leonel Mauricio", "lastname" => "Aguirre Gonzalez", "email" => "laguirregonzalez@ita.edu.co"),
    array("username" => "tr.villacob", "password" => "9296174", "firstname" => "Teofilo Rafael", "lastname" => "Villacob Hernandez", "email" => "tr.villacob@ita.edu.co"),
    array("username" => "oortizrevelo", "password" => "11433878", "firstname" => "Octavio Fernando", "lastname" => "Ortiz Revelo", "email" => "oortizrevelo@ita.edu.co"),
    array("username" => "ma.caldas", "password" => "14876546", "firstname" => "Mario German", "lastname" => "Caldas Martinez", "email" => "ma.caldas@ita.edu.co"),
    array("username" => "javalencia", "password" => "14885713", "firstname" => "Jaime", "lastname" => "Valencia Martinez", "email" => "javalencia@ita.edu.co"),
    array("username" => "la.rodriguez", "password" => "14888961", "firstname" => "Luis Alberto", "lastname" => "Rodriguez Holguin", "email" => "la.rodriguez@ita.edu.co"),
    array("username" => "se.tejada", "password" => "14889753", "firstname" => "Samy Elias", "lastname" => "Tejada", "email" => "se.tejada@ita.edu.co"),
    array("username" => "jazuluagaarce", "password" => "14896559", "firstname" => "Jhon Alexander", "lastname" => "Zuluaga Arce", "email" => "jazuluagaarce@ita.edu.co"),
    array("username" => "ca.montoya", "password" => "14898414", "firstname" => "Carlos Alberto", "lastname" => "Montoya Correa", "email" => "ca.montoya@ita.edu.co"),
    array("username" => "ygonzalezdiaz", "password" => "16592882", "firstname" => "Yeinner Andrés", "lastname" => "González Díaz", "email" => "ygonzalezdiaz@ita.edu.co"),
    array("username" => "is.vega", "password" => "18391115", "firstname" => "Israel", "lastname" => "Vega Garcia", "email" => "is.vega@ita.edu.co"),
    array("username" => "mc.toro", "password" => "31640433", "firstname" => "Maria Del Carmen", "lastname" => "Toro Salazar", "email" => "mc.toro@ita.edu.co"),
    array("username" => "me.abadia", "password" => "66870366", "firstname" => "Melida", "lastname" => "Abadia Valencia", "email" => "me.abadia@ita.edu.co"),
    array("username" => "gossaossa", "password" => "75069469", "firstname" => "Gustavo Adolfo", "lastname" => "Ossa Ossa", "email" => "gossaossa@ita.edu.co"),
    array("username" => "oforerogonzalez", "password" => "79915459", "firstname" => "Omar Osbaldo", "lastname" => "Forero González", "email" => "oforerogonzalez@ita.edu.co"),
    array("username" => "r.guitierrez", "password" => "94473747", "firstname" => "Ricardo", "lastname" => "Gutierrez Quintero", "email" => "r.guitierrez@ita.edu.co"),
    array("username" => "clozanoorozco", "password" => "94474389", "firstname" => "Carlos Andres", "lastname" => "Lozano Orozco", "email" => "clozanoorozco@ita.edu.co"),
    array("username" => "mg.garcia", "password" => "94475803", "firstname" => "Mauricio", "lastname" => "García Marín", "email" => "mg.garcia@ita.edu.co"),
    array("username" => "jcastillorios", "password" => "94481862", "firstname" => "Jesús David", "lastname" => "Castillo Ríos", "email" => "jcastillorios@ita.edu.co"),
    array("username" => "briveraarenas", "password" => "94482737", "firstname" => "Bladimir", "lastname" => "Rivera Arenas", "email" => "briveraarenas@ita.edu.co"),
    array("username" => "daniel.montoya", "password" => "94483402", "firstname" => "Daniel", "lastname" => "Montoya Moreno", "email" => "daniel.montoya@ita.edu.co"),
    array("username" => "cgallego", "password" => "97477453", "firstname" => "Christiam", "lastname" => "Gallego Arias", "email" => "cgallego@ita.edu.co"),
    array("username" => "ja.tigreros", "password" => "111361947", "firstname" => "Jaime Andres", "lastname" => "Tigreros", "email" => "ja.tigreros@ita.edu.co"),
    array("username" => "J.lozano", "password" => "111571345", "firstname" => "Jeffry Jassan", "lastname" => "Lozano Garcia", "email" => "J.lozano@ita.edu.co"),
    array("username" => "asalamancabedoya", "password" => "111589615", "firstname" => "Andrés Felipe", "lastname" => "Salamanca Bedoya", "email" => "asalamancabedoya@ita.edu.co"),
    array("username" => "malegriaslondono", "password" => "123654789", "firstname" => "Mítchell", "lastname" => "Alegrias Lodoño", "email" => "malegriaslondono@ita.edu.co"),
    array("username" => "lv.vasquez", "password" => "132384634", "firstname" => "Leidy Vanessa", "lastname" => "Vasquez Tenorio", "email" => "lv.vasquez@ita.edu.co"),
    array("username" => "cmartinezjaramillo", "password" => "987654321", "firstname" => "Carlos Alberto", "lastname" => "Martinez Jaramillo", "email" => "cmartinezjaramillo@ita.edu.co"),
    array("username" => "jaragongiraldo", "password" => "1006371445", "firstname" => "Jaime Andrés", "lastname" => "Aragón Giraldo", "email" => "jaragongiraldo@ita.edu.co"),
    array("username" => "caeslava", "password" => "1022375456", "firstname" => "Camilo Andres", "lastname" => "Eslava Cortes", "email" => "caeslava@ita.edu.co"),
    array("username" => "mrobledogomez", "password" => "1060654512", "firstname" => "Manuela", "lastname" => "Robledo Gomez", "email" => "mrobledogomez@ita.edu.co"),
    array("username" => "A.lopez", "password" => "1115072499", "firstname" => "Alejandro", "lastname" => "López Cárdenas", "email" => "A.lopez@ita.edu.co"),
    array("username" => "lmesapenaranda", "password" => "1115075619", "firstname" => "Luis Eduardo", "lastname" => "Mesa Peñaranda", "email" => "lmesapenaranda@ita.edu.co"),
    array("username" => "di.cruz", "password" => "1115079663", "firstname" => "Diego Mauricio", "lastname" => "Cruz Castañeda", "email" => "di.cruz@ita.edu.co"),
    array("username" => "dzunigapatino", "password" => "1118300001", "firstname" => "David Esteban", "lastname" => "Zúñiga Patiño", "email" => "dzunigapatino@ita.edu.co"),
    array("username" => "al.suarez", "password" => "1130682346", "firstname" => "Alejandro", "lastname" => "Suarez Marsiglia", "email" => "al.suarez@ita.edu.co"),
    array("username" => "aflorezcoca", "password" => "1094916353", "firstname" => "Anderson", "lastname" => "Florez Coca", "email" => "aflorezcoca@ita.edu.co"),
    array("username" => "c.tirado", "password" => "41936483", "firstname" => "Carolina", "lastname" => "Tirado", "email" => "c.tirado@ita.edu.co"),
    array("username" => "crinconquiroga", "password" => "6247751", "firstname" => "Carlos Arturo", "lastname" => "Rincón Quiroga", "email" => "crinconquiroga@ita.edu.co"),
    array("username" => "jjimenezcolonia", "password" => "94225425", "firstname" => "Julian", "lastname" => "Jimenez Colonia", "email" => "jjimenezcolonia@ita.edu.co"),
    array("username" => "kvalarezoguerrero", "password" => "1151443292", "firstname" => "Keila", "lastname" => "Valarezo Guerrero", "email" => "kvalarezoguerrero@ita.edu.co"),
    array("username" => "lfigueroalozano", "password" => "16486600", "firstname" => "Leopoldino", "lastname" => "Figueroa Lozano", "email" => "lfigueroalozano@ita.edu.co"),
    array("username" => "frenzomartinez", "password" => "11790980", "firstname" => "Francisco Renzo", "lastname" => "Martinez Valoyes", "email" => "frenzomartinez@ita.edu.co"),
    array("username" => "mamunoz", "password" => "", "firstname" => "Maria Alejandra", "lastname" => "Muñoz Vera", "email" => "mamunoz@ita.edu.co"),
    array("username" => "oeduardotrujillo", "password" => "77236628", "firstname" => "Oscar Eduardo", "lastname" => "Trujillo Obando", "email" => "oeduardotrujillo@ita.edu.co"),
    array("username" => "orendonvargas", "password" => "24589410", "firstname" => "Obeida", "lastname" => "Rendón Vargas", "email" => "orendonvargas@ita.edu.co"),
    array("username" => "s.castano", "password" => "1115071374", "firstname" => "Sebastian", "lastname" => "Castaño Guevara", "email" => "s.castano@ita.edu.co")
);

$usuarios2 = array(
    array("username" => "jalexiscv", "password" => "94478998", "firstname" => "Alexis", "lastname" => "Correa", "email" => "jalexiscv@gmail.com"),
);


$code = "";
$count = 0;
foreach ($usuarios as $usuario) {
    $user = $mfields->get_UserByEmail($usuario['email']);
    $count++;
    if ($user) {
        $code .= "{$count}: " . $usuario['email'] . " ya existe en la base de datos<br>";
        $name = $usuario['firstname'] . " " . $usuario['lastname'];
        //$mfields->insert(array("field" => pk(), "user" => $user, "name" => "alias", "value" => $usuario['username']));
        //$mfields->insert(array("field" => pk(), "user" => $user, "name" => "password", "value" => $usuario['password']));
        //$mfields->insert(array("field" => pk(), "user" => $user, "name" => "firstname", "value" => $usuario['firstname']));
        //$mfields->insert(array("field" => pk(), "user" => $user, "name" => "lastname", "value" => $usuario['lastname']));
        //$mfields->insert(array("field" => pk(), "user" => $user, "name" => "email", "value" => $usuario['email']));
        $sfs1 = "style='font-size: 1.5em;'";
        $code = "<p {$sfs1}>Estimado <b>{$name}</b>,</p>\n";
        $code .= "<p {$sfs1}>Espero que este mensaje le encuentre bien. Les escribimos para proporcionarle la información de su cuenta en nuestro sistema intranet Utedé</p>\n";
        $code .= "<ul>\n";
        $code .= "\t\t<li {$sfs1}><strong>Usuario:</strong> {$usuario['email']}</li>\n";
        $code .= "\t\t<li {$sfs1}><strong>Contraseña:</strong> {$usuario['password']}</li>\n";
        $code .= "</ul>\n";
        $code .= "<p {$sfs1}>Por favor, asegúrese de mantener esta información de forma segura y no compartirla con nadie más. Si tiene alguna pregunta o necesita asistencia adicional, no dude en ponerse en contacto con nosotros.</p>\n";
        $code .= "<p {$sfs1}>Gracias por su atención y que tenga un excelente día.</p>\n";
        $code .= "<p {$sfs1}>Atentamente,<br>\n";
//$code .= "[Su Nombre]<br>\n";
//$code .= "[Su Cargo/Organización]<br>\n";
//$code .= "[Su Información de Contacto]</p>\n";
        $mailer = new Sender();
        $mailer->set_From("soporte@utede.edu.co");
        $mailer->set_Subject("Información de Usuario y Contraseña");
        $mailer->set_Body($code);
        $mailer->add_Address($usuario['email'], $usuario['email']);
        $mailer->send();

    } else {
        $code .= "Usuario: " . $usuario['email'] . " no existe en la base de datos<br>";
        $d = array("user" => pk(), "author" => safe_get_user());
        //$create = $musers->insert($d);
        //$mfields->insert(array("field" => pk(), "user" => $d["user"], "name" => "alias", "value" => $usuario['username']));
        //$mfields->insert(array("field" => pk(), "user" => $d["user"], "name" => "password", "value" => $usuario['password']));
        //$mfields->insert(array("field" => pk(), "user" => $d["user"], "name" => "firstname", "value" => $usuario['firstname']));
        //$mfields->insert(array("field" => pk(), "user" => $d["user"], "name" => "lastname", "value" => $usuario['lastname']));
        //$mfields->insert(array("field" => pk(), "user" => $d["user"], "name" => "email", "value" => $usuario['email']));
    }

}


$card = $bootstrap->get_Card("card-tools", array(
    "title" => "Analisis de Usuarios",
    "header-back" => "/development/home/" . lpk(),
    "content" => $code,
));

echo($card);
?>