<?php

defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR') || define('HOUR', 3600);
defined('DAY') || define('DAY', 86400);
defined('WEEK') || define('WEEK', 604800);
defined('MONTH') || define('MONTH', 2592000);
defined('YEAR') || define('YEAR', 31536000);
defined('DECADE') || define('DECADE', 315360000);
defined('EXIT_SUCCESS') || define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR') || define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG') || define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE') || define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS') || define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') || define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE') || define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN') || define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') || define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
$protocol = 'https://' . $_SERVER['HTTP_HOST'];
//$protocol = str_replace("www.", "", $protocol);
defined('BASE_URL') || define('BASE_URL', $protocol);
//[Icons]---------------------------------------------------------------------------------------------------------------
const ICON_ACADEMIC_PROGRAMS = 'fa-regular fa-book';

const ICON_TRAINING = 'fa-light fa-book-open-reader';

const ICON_ACADEMIC = 'fa-regular fa-book';

const ICON_GRADUATIONS = 'fa-light fa-diploma';

const ICON_FINANCIAL = 'fa-light fa-money-bill';

const ICON_ACCOUNT = 'fa-regular fa-id-card-clip';
const ICON_ACCOUNTS = 'fa-regular fa-id-card-clip';
const ICON_ADD = 'fas fa-plus ';
const ICON_APPOINTMENT = 'fas fa-calendar-alt';

const ICON_AGREEMENTS = 'fa-light fa-handshake';
const ICON_APPOINTMENTS = 'fas fa-calendar-alt';
const ICON_ATTACH_FILE = 'fa-light fa-paperclip';
const ICON_ATTACHMENTS = 'fa-regular fa-paperclip';
const ICON_BACK = 'fas fa-arrow-left ';
const ICON_BADGE_CHECK = 'fa-duotone fa-badge-check';
const ICON_BAN = 'fa-regular fa-ban';
const ICON_BOLT = 'icon fa-regular fa-bolt';
const ICON_BOOK = 'fa-light fa-book';

const ICON_BOOKMARK = 'fa-regular fa-bookmark';
const ICON_BOT = 'fa-regular fa-robot';
const ICON_BREACHES = 'fa-light fa-block-brick-fire';

const ICON_BILLING = 'fa-regular fa-file-invoice-dollar';
const ICON_CALENDARS = 'fas fa-calendar-alt';
const ICON_CAMPUS = "fa-light fa-diploma";
const ICON_CANCEL = 'fas fa-ban ';
const ICON_CASE = 'fa-light fa-suitcase';
const ICON_CASES = 'fa-light fa-suitcase';
const ICON_CATEGORY = ' fa-regular fa-tags ';
const ICON_CENTERS = 'fa-sharp fa-solid fa-arrows-to-eye';
const ICON_CHARTS = 'fa-light fa-chart-simple';
const ICON_CLOCK = 'fa-regular fa-clock';

const ICON_CLIENTS = 'fa-light fa-users';



const ICON_COUNTRIES = 'fa-light fa-globe';
const ICON_CLOSE = 'fas fa-times ';
const ICON_CONTROLLER = 'far fa-gamepad-alt';
const ICON_CONTINUE = 'fas fa-arrow-right ';
const ICON_COURSES = 'fa-light fa-book-open-reader';
const ICON_CREATE = 'far fa-sparkles ';
const ICON_CROWN = 'fa-regular fa-crown ';
const ICON_CUSTOMERS = 'fa-regular fa-users';

const ICON_DIPLOMA = 'fa-light fa-diploma';

const ICON_DB = 'fa-light fa-database';
const ICON_DARKWEB = 'fa-light fa-user-secret';
const ICON_DASHBOARD = 'fas fa-tachometer-alt';
const ICON_DECREES = 'fa-regular fa-books';
const ICON_DEEPWEB = 'icon fa-regular fa-spider-web';
const ICON_DELETE = ' far fa-trash ';
const ICON_DIRECTIVE = 'fa-light fa-compass';

const ICON_DISCOUNTS = 'fa-light fa-percent';
const ICON_DIMENSIONS = 'fa-light fa-layer-group';
const ICON_DOWNLOAD = 'fas fa-download ';
const ICON_EDIT = 'fa-regular fa-pen';

const ICON_ENROLLMENT = 'fa-regular fa-books';

const ICON_MOVE = 'fa-regular fa-arrows-alt';

const ICON_ENROLL = 'fa-regular fa-diploma';
const ICON_EMAIL = 'fa-light fa-envelope';
const ICON_EMAILS = 'fa-light fa-envelope';
const ICON_ERROR = 'fas fa-times-circle ';
const ICON_FILTERS = 'fa-regular fa-filter';
const ICON_FIREWALL = 'fa-light fa-fire-flame-curved';
const ICON_FURAG = 'fa-light fa-ballot-check';

const ICON_FACEBOOK = 'fa-brands fa-facebook';
const ICON_GENERATORS = 'fas fa-code ';
const ICON_GEO = 'fa-light fa-earth-americas';

const ICON_BOX="fa-light fa-box";

const ICON_RESPONSIBLE="fa-light fa-shield";

const ICON_GOOGLE = 'fa-brands fa-google';

const ICON_HEADQUARTERS = 'fa-light fa-building';
const ICON_HELP = 'fa-light fa-question-circle';
const ICON_HELPDESK = 'fa-regular fa-headset';
const ICON_HISTORY = 'fa-light fa-timeline';
const ICON_HOME = 'fas fa-home';
const ICON_IA = 'fa-regular fa-robot';
const ICON_INFO = 'fas fa-info-circle ';

const ICON_INTELLIGENCE = 'fa-light fa-brain';
const ICON_INTRUSIONS = 'fa-regular fa-shield-exclamation';

const ICON_INSTITUTIONS = 'fa-light fa-university';
const ICON_ISO = 'fa-regular fa-book';
const ICON_CALENDAR = 'fas fa-calendar-alt';

const ICON_OBSERVATIONS = 'fa-light fa-eye';

const ICON_INTERVIEW = 'fa-light fa-clipboard-question';
const ICON_KEYS = 'fa-regular fa-key';
const ICON_KEY = 'fa-regular fa-key';
const ICON_LANG = 'icon fal fa-language';
const ICON_LIBRARY = 'fa-light fa-books';
const ICON_LINK = 'fa-solid fa-link ';
const ICON_LIST = 'fa-light fa-table-list';
const ICON_LIVETRAFFIC = 'fa-regular fa-globe';
const ICON_LOCK = 'fas fa-lock ';

const ICON_LOGOS = 'fa-light fa-image';
const ICON_MANAGER = 'fa-light fa-user-tie';
const ICON_MAP = 'fa-regular fa-map';
const ICON_MEN = "fa-light fa-anchor";

const ICON_MONEY = 'fa-light fa-money-bill';

const ICON_MIGRATIONS = 'fa-light fa-database';
const ICON_MODEL = 'icon far fa-database';
const ICON_MODULES = 'fa-light fa-book';

const ICON_SCHEDULE = 'fa-regular fa-calendar-alt';
const ICON_NEXT = 'fas fa-arrow-right ';

const ICON_NOTIFY = 'fa-regular fa-bell';
const ICON_ORGANIZATION = "fa-regular fa-building";
const ICON_PERMISSIONS = "fad fa-key";
const ICON_PDF = 'fas fa-file-pdf ';
const ICON_PLANS = 'fa-regular fa-clipboard-list-check';

const ICON_PLEX = 'fa-light fa-network-wired';
const ICON_PLUS = 'fa-light fa-plus ';
const ICON_POLICIES = 'fa-regular fa-book';
const ICON_POLITICS = 'fa-regular fa-book';
const ICON_PORTAL = 'fa-light fa-globe';
const ICON_PQRSD = "fa-light fa-hand-wave";

const ICON_PRODUCTS = 'fa-light fa-box-heart';

const ICONS_MODELS='fa-light fa-database';
const ICON_PRINT = 'fas fa-print ';
const ICON_Q10 = 'fa-light fa-notebook';
const ICON_QUESTION = 'fas fa-question-circle ';
const ICON_QUESTION2 = 'fa-regular fa-seal-question';
const ICON_REQUIREMENTS = 'fa-regular fa-book';
const ICON_REPORTS = 'fa-light fa-box';

const ICON_REGISTRATIONS="fa-light fa-id-card";

const ICON_COINS = 'fa-light fa-coins';
const ICON_ROLES = "fad fa-crown";
const ICON_SCREEN = 'fa-sharp fa-regular fa-desktop';
const ICON_SCREENS = 'fa-sharp fa-regular fa-desktop';
const ICON_SEARCH = 'fa-light fa-search ';
const ICON_SETTINGS = 'fa-sharp fa-solid fa-sliders';



const ICON_CERTIFICATIONS='fa-light fa-certificate';
const ICON_SIGNOUT = 'fa-regular fa-sign-out';
const ICON_SMS = 'fas fa-sms';

const ICON_SNIES = 'fa-light fa-star-of-life';

const ICON_CREDIT = 'fa-light fa-file-dashed-line';
const ICON_STORAGE = 'fa-regular fa-box-heart';
const ICON_STUDENTS = 'fa-light fa-screen-users';
const ICON_SUCCESS = 'fas fa-check-circle';
const ICON_SUPPORT = 'fa-light fa-headset';
const ICON_TEACHERS = "fa-light fa-person-chalkboard";

const ICON_THEME = 'fa-light fa-palette';
const ICON_TICKETS = 'fa-regular fa-ticket';
const ICON_TICKET = 'fa-regular fa-ticket';
const ICON_TIME = 'fa-regular fa-clock ';
const ICON_TOOLS = 'fa-light fa-gear ';

const ICON_TRASH = 'fa-regular fa-trash';
const ICON_LANGUAGES = 'fa-regular fa-language';

const ICON_EXE = 'fa-light fa-rocket';
const ICON_UPLOAD = 'fas fa-upload ';
const ICON_UNLOCK = 'fas fa-unlock ';
const ICON_USERS = 'fa-light fa-users ';
const ICON_VIEW = 'far fa-eye ';
const ICON_VERTICAL_DOTS = 'fa-solid fa-ellipsis-vertical';
const ICON_VULNERABILITIES = 'fa-regular fa-heart-crack';
const ICON_WARNING = 'fa-duotone fa-triangle-exclamation';

const ICON_DANGER = 'fa-duotone fa-triangle-exclamation';
const ICON_WAYPONT = 'fa-light fa-map-marker';
const ICON_WEBS = 'fa-regular fa-globe';
const ICON_USER = 'far fa-user ';
const ICON_SAVE = 'fas fa-save ';

const ICON_STAR = 'fa-regular fa-star';

const ICON_SMTP = 'fa-light fa-envelope';

const ICON_IMAP = 'fa-light fa-envelope-open';

const ICON_TEST = 'fa-light fa-envelope-open';

const ICON_WHITELIST = 'fa-light fa-user-check';
const ICON_UPDATE = 'fa-regular fa-sync';

const ICON_STATUS = 'fa-regular fa-check-circle';

const ICON_STATUSES = 'fa-regular fa-check-circle';
const ICON_REFRESH = 'fas fa-sync ';
const COMMENT_HR_SERVICES = "//[services]------------------------------------------------------------------------------------------------------------\n";
const COMMENT_HR_MODELS = "//[models]--------------------------------------------------------------------------------------------------------------\n";
const COMMENT_HR_VARS = "//[vars]----------------------------------------------------------------------------------------------------------------\n";
const COMMENT_HR_FIELDS = "//[fields]----------------------------------------------------------------------------------------------------------------\n";
const COMMENT_HR_GROUPS = "//[groups]----------------------------------------------------------------------------------------------------------------\n";
const COMMENT_HR_BUTTONS = "//[buttons]-------------------------------------------------------------------------------------------------------------\n";
const COMMENT_HR_BUILD = "//[build]---------------------------------------------------------------------------------------------------------------\n";
const COMMENT_HR_EVAL = "//[eval]-----------------------------------------------------------------------------------------------------------------\n";
const COMMENT_MODULECONTROLER_VARS = ""
    . "/**\n"
    . "* @var object \$authentication Authentication service from the ModuleController.\n"
    . "* @var object \$bootstrap Instance of the Bootstrap class from the ModuleController.\n"
    . "* @var string \$component Complete URI to the requested component.\n"
    . "* @var object \$dates Date service from the ModuleController.\n"
    . "* @var string \$oid String representing the object received, usually an object/data to be viewed, transferred from the ModuleController.\n"
    . "* @var object \$parent Represents the ModuleController.\n"
    . "* @var object \$request Request service from the ModuleController.\n"
    . "* @var object \$strings String service from the ModuleController.\n"
    . "* @var string \$view String passed to the view defined in the viewer for evaluation.\n"
    . "* @var string \$viewer Complete URI to the view responsible for evaluating each requested view.\n"
    . "* @var string \$views Complete URI to the module views.\n"
    . "**/\n";

//[Bootstrap Icons]---------------------------------------------------------------------------------------------------------------
const BS_ICON_INFO = 'fas fa-info-circle';
const BS_ICON_SUCCESS = 'fas fa-check-circle';
const BS_ICON_ERROR = 'fas fa-times-circle';
const BS_ICON_WARNING = 'fas fa-exclamation-circle';
const BS_ICON_QUESTION = 'fas fa-question-circle';
const BS_ICON_LOCK = 'fas fa-lock';
const BS_ICON_UNLOCK = 'fas fa-unlock';
const ICON_ASOBANCARIA = 'fa-light fa-piggy-bank';

const ICON_PAYMENTS = 'fa-light fa-money-bill';

const ICON_MOODLE = 'fa-light fa-scribble';

const ICON_SEND='fas fa-send';
const LIST_FILE_TYPES_GENERAL = array(
    array("value" => "G-001", "label" => "Documentos"),
    array("value" => "G-002", "label" => "Certificados"),
    array("value" => "G-003", "label" => "Comunicados"),
    array("value" => "G-004", "label" => "Contratos"),
    array("value" => "G-005", "label" => "Cuestionarios"),
    array("value" => "G-006", "label" => "Documentos"),
    array("value" => "G-007", "label" => "Estatutos"),
    array("value" => "G-008", "label" => "Guías"),
    array("value" => "G-009", "label" => "Informes"),
    array("value" => "G-010", "label" => "Manual"),
    array("value" => "G-011", "label" => "Memorias"),
    array("value" => "G-012", "label" => "Normas"),
    array("value" => "G-014", "label" => "Políticas"),
    array("value" => "G-015", "label" => "Presentaciones"),
    array("value" => "G-016", "label" => "Protocolos"),
    array("value" => "G-017", "label" => "Reglamentos"),
    array("value" => "G-018", "label" => "Resoluciones"),
    array("value" => "G-019", "label" => "Requisitos"),
    array("value" => "G-020", "label" => "Revisiones"),
    array("value" => "G-021", "label" => "Rutas"),
    array("value" => "G-022", "label" => "Sanciones"),
    array("value" => "G-023", "label" => "Solicitudes"),
    array("value" => "G-024", "label" => "Tablas"),
    array("value" => "G-025", "label" => "Términos"),
    array("value" => "G-026", "label" => "Títulos"),
    array("value" => "G-027", "label" => "Trámites"),
    array("value" => "G-028", "label" => "Fotografías"),
    array("value" => "G-029", "label" => "Plan"),
    array("value" => "G-030", "label" => "Formulario"),
    array("value" => "G-031", "label" => "Actas"),
    array("value" => "G-999", "label" => "Otros"),
);
/*
  |--------------------------------------------------------------------------
  | Higgs
  |--------------------------------------------------------------------------
  |
*/
if (!defined('APPNODE')) {
    $fsn = str_replace(".", "", str_replace("www", "", $_SERVER['SERVER_NAME']));
    define('APPNODE', "{$fsn}_");
}
if (!defined('DOMAIN')) {
    $domain = str_replace("www.", "", $_SERVER['SERVER_NAME']);
    define('DOMAIN', $domain);
}
if (!defined('PUBLICPATH')) {
    define('PUBLICPATH', realpath(APPPATH . '../public_html') . DIRECTORY_SEPARATOR);
}

global $db_default, $db_session;
