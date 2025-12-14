<?php
/** @var string $parent */
/** @var string $views */
/** @var string $prefix */
/** @var object $parent */
$server = service('server');
$benchmark = service('timer');
$benchmark->start('time');
/** @var object $server */
$version = (string)round($server->get_DirectorySize(APPPATH . 'Modules/Sie') / 102400, 6);
$data = $parent->get_Array();
$rviews = array(
    "default" => "{$views}\E404\index",
    "sie-denied" => "{$views}\Denied\index",
    "sie-home" => "{$views}\Home\index",
    //[students]--------------------------------------------------------------------------------------------------------
    "sie-students-create" => "{$views}\Students\Create\index",
    "sie-students-list" => "{$views}\Students\List\index",
    "sie-students-view" => "{$views}\Students\View\index",
    "sie-students-edit" => "{$views}\Students\Edit\index",
    "sie-students-delete" => "{$views}\Students\Delete\index",
    //[teachers]--------------------------------------------------------------------------------------------------------
    "sie-teachers-create" => "{$views}\Teachers\Create\index",
    "sie-teachers-list" => "{$views}\Teachers\List\index",
    "sie-teachers-view" => "{$views}\Teachers\View\index",
    "sie-teachers-edit" => "{$views}\Teachers\Edit\index",
    "sie-teachers-delete" => "{$views}\Teachers\Delete\index",
    "sie-teachers-report" => "{$views}\Teachers\Report\index",
    //[programs]--------------------------------------------------------------------------------------------------------
    "sie-programs-home" => "$views\Programs\Home\index",
    "sie-programs-list" => "$views\Programs\List\index",
    "sie-programs-view" => "$views\Programs\View\index",
    "sie-programs-create" => "$views\Programs\Create\index",
    "sie-programs-edit" => "$views\Programs\Edit\index",
    "sie-programs-delete" => "$views\Programs\Delete\index",
    //[Grids]----------------------------------------------------------------------------------------
    "sie-grids-home" => "$views\Grids\Home\index",
    "sie-grids-list" => "$views\Grids\List\index",
    "sie-grids-view" => "$views\Grids\View\index",
    "sie-grids-create" => "$views\Grids\Create\index",
    "sie-grids-edit" => "$views\Grids\Edit\index",
    "sie-grids-delete" => "$views\Grids\Delete\index",
    //[Academic Models]----------------------------------------------------------------------------------------
    "sie-models-home"=>"$views\Models\Home\index",
    "sie-models-list"=>"$views\Models\List\index",
    "sie-models-view"=>"$views\Models\View\index",
    "sie-models-create"=>"$views\Models\Create\index",
    "sie-models-edit"=>"$views\Models\Edit\index",
    "sie-models-delete"=>"$views\Models\Delete\index",
    //[Versions]----------------------------------------------------------------------------------------
    "sie-versions-home" => "$views\Versions\Home\index",
    "sie-versions-list" => "$views\Versions\List\index",
    "sie-versions-view" => "$views\Versions\View\index",
    "sie-versions-create" => "$views\Versions\Create\index",
    "sie-versions-edit" => "$views\Versions\Edit\index",
    "sie-versions-delete" => "$views\Versions\Delete\index",
    "sie-versions-status" => "$views\Versions\Status\index",
    //[modules]---------------------------------------------------------------------------------------------------------
    "sie-modules-home" => "$views\Modules\Home\index",
    "sie-modules-list" => "$views\Modules\List\index",
    "sie-modules-view" => "$views\Modules\View\index",
    "sie-modules-create" => "$views\Modules\Create\index",
    "sie-modules-edit" => "$views\Modules\Edit\index",
    "sie-modules-delete" => "$views\Modules\Delete\index",
    //[pensums]---------------------------------------------------------------------------------------------------------
    "sie-pensums-home" => "$views\Pensums\Home\index",
    "sie-pensums-list" => "$views\Pensums\List\index",
    "sie-pensums-view" => "$views\Pensums\View\index",
    "sie-pensums-create" => "$views\Pensums\Create\index",
    "sie-pensums-edit" => "$views\Pensums\Edit\index",
    "sie-pensums-delete" => "$views\Pensums\Delete\index",
    //[courses]---------------------------------------------------------------------------------------------------------
    "sie-courses-home" => "$views\Courses\Home\index",
    "sie-courses-list" => "$views\Courses\List\index",
    "sie-courses-view" => "$views\Courses\View\index",
    "sie-courses-create" => "$views\Courses\Create\index",
    "sie-courses-edit" => "$views\Courses\Edit\index",
    "sie-courses-delete" => "$views\Courses\Delete\index",
    "sie-courses-print" => "$views\Courses\Print\index",
    "sie-courses-execution" => "$views\Courses\Execution\index",
    //[enrolleds]-------------------------------------------------------------------------------------------------------
    "sie-enrolleds-home" => "$views\Enrolleds\Home\index",
    "sie-enrolleds-list" => "$views\Enrolleds\List\index",
    "sie-enrolleds-view" => "$views\Enrolleds\View\index",
    "sie-enrolleds-create" => "$views\Enrolleds\Create\index",
    "sie-enrolleds-edit" => "$views\Enrolleds\Edit\index",
    "sie-enrolleds-delete" => "$views\Enrolleds\Delete\index",
    //[enrolleds]-------------------------------------------------------------------------------------------------------
    "sie-settings-home" => "$views\Settings\Home\index",
    "sie-settings-list" => "$views\Settings\List\index",
    "sie-settings-view" => "$views\Settings\View\index",
    "sie-settings-moodle" => "$views\Settings\Moodle\index",
    "sie-settings-formats" => "$views\Settings\Formats\index",
    "sie-settings-contact" => "$views\Settings\Contact\index",
    "sie-settings-create" => "$views\Settings\Create\index",
    "sie-settings-edit" => "$views\Settings\Edit\index",
    "sie-settings-delete" => "$views\Settings\Delete\index",
    //[financial]-------------------------------------------------------------------------------------------------------
    "sie-financial-home" => "$views\Financial\Home\index",
    "sie-financial-report" => "$views\Reports\Financial\General\index",
    //[Products]----------------------------------------------------------------------------------------
    "sie-products-home" => "$views\Products\Home\index",
    "sie-products-list" => "$views\Products\List\index",
    "sie-products-view" => "$views\Products\View\index",
    "sie-products-create" => "$views\Products\Create\index",
    "sie-products-edit" => "$views\Products\Edit\index",
    "sie-products-delete" => "$views\Products\Delete\index",
    //[Discounts]----------------------------------------------------------------------------------------
    "sie-discounts-home" => "$views\Discounts\Home\index",
    "sie-discounts-list" => "$views\Discounts\List\index",
    "sie-discounts-view" => "$views\Discounts\View\index",
    "sie-discounts-create" => "$views\Discounts\Create\index",
    "sie-discounts-edit" => "$views\Discounts\Edit\index",
    "sie-discounts-delete" => "$views\Discounts\Delete\index",
    //[Registrations]----------------------------------------------------------------------------------------
    "sie-registrations-home" => "$views\Registrations\Home\index",
    "sie-registrations-list" => "$views\Registrations\List\index",
    "sie-registrations-view" => "$views\Registrations\View\index",
    "sie-registrations-create" => "$views\Registrations\Create\index",
    "sie-registrations-documents" => "$views\Registrations\Documents\index",
    "sie-registrations-edit" => "$views\Registrations\Edit\index",
    "sie-registrations-delete" => "$views\Registrations\Delete\index",
    "sie-registrations-cancel" => "$views\Registrations\Cancel\index",
    "sie-registrations-billing" => "$views\Registrations\Billing\index",
    "sie-registrations-notify" => "$views\Registrations\Notify\index",
    "sie-registrations-schedule" => "$views\Registrations\Schedule\index",
    "sie-registrations-updates" => "$views\Registrations\Updates\index",
    "sie-registrations-agreements" => "$views\Registrations\Agreements\index",
    "sie-registrations-settings-view" => "$views\Registrations\Settings\View\index",
    "sie-registrations-settings-edit" => "$views\Registrations\Settings\Edit\index",
    //[certifications]----------------------------------------------------------------------------------------
    "sie-certifications-home" => "$views\Certifications\Home\index",
    "sie-certifications-studies" => "$views\Certifications\Studies\index",
    "sie-certifications-transcript" => "$views\Certifications\Transcript\index",
    //[Enrrollments]----------------------------------------------------------------------------------------
    "sie-enrollments-home" => "$views\Enrollments\Home\index",
    "sie-enrollments-list" => "$views\Enrollments\List\index",
    "sie-enrollments-academic" => "$views\Enrollments\Academic\index",
    "sie-enrollments-view" => "$views\Enrollments\View\index",
    "sie-enrollments-create" => "$views\Enrollments\Create\index",
    "sie-enrollments-edit" => "$views\Enrollments\Edit\index",
    "sie-enrollments-delete" => "$views\Enrollments\Delete\index",
    "sie-enrollments-move" => "$views\Enrollments\Move\index",
    "sie-enrollments-cancel" => "$views\Enrollments\Cancel\index",
    "sie-enrollments-billing" => "$views\Enrollments\Billing\index",
    "sie-enrollments-notify" => "$views\Enrollments\Notify\index",
    //[agreements]------------------------------------------------------------------------------------------------------
    "sie-agreements-home" => "$views\Agreements\Home\index",
    "sie-agreements-list" => "$views\Agreements\List\index",
    "sie-agreements-view" => "$views\Agreements\View\index",
    "sie-agreements-create" => "$views\Agreements\Create\index",
    "sie-agreements-edit" => "$views\Agreements\Edit\index",
    "sie-agreements-delete" => "$views\Agreements\Delete\index",
    "sie-agreements-cancel" => "$views\Agreements\Cancel\index",
    "sie-agreements-billing" => "$views\Agreements\Billing\index",
    "sie-agreements-notify" => "$views\Agreements\Notify\index",
    //[importers]---------------------------------------------------------------------------------------------------------
    "sie-importers-asobancaria" => "$views\Importers\Asobancaria\index",
    //[Payments]----------------------------------------------------------------------------------------
    "sie-payments-home" => "$views\Payments\Home\index",
    "sie-payments-list" => "$views\Payments\List\index",
    "sie-payments-view" => "$views\Payments\View\index",
    "sie-payments-create" => "$views\Payments\Create\index",
    "sie-payments-edit" => "$views\Payments\Edit\index",
    "sie-payments-delete" => "$views\Payments\Delete\index",
    //[reports]---------------------------------------------------------------------------------------------------------
    "sie-reports-home" => "$views\Reports\Home\index",
    "sie-reports-registrations" => "$views\Reports\Registrations\index",
    "sie-reports-admissions" => "$views\Reports\Admissions\index",
    "sie-reports-programs" => "$views\Reports\Programs\index",
    "sie-reports-evalteachers" => "$views\Reports\Evalteachers\index",
    "sie-reports-graduations" => "$views\Reports\Graduations\index",
    "sie-reports-preenrollments" => "$views\Reports\Preenrollments\index",
    "sie-reports-snies-enrolleds" => "$views\Reports\Snies\Enrolleds\index",
    "sie-reports-snies-freeofcharge" => "$views\Reports\Snies\Freeofcharge\index",
    "sie-reports-snies-coursesenrolled" => "$views\Reports\Snies\CoursesEnrolled\index",
    "sie-reports-snies-coursed" => "$views\Reports\Snies\Coursed\index",
    "sie-reports-snies-graduateds" => "$views\Reports\Snies\Graduateds\index",
    "sie-reports-humanresources-home" => "$views\Reports\HumanResources\index",
    "sie-reports-population-home" => "$views\Reports\Population\index",
    "sie-reports-enrolleds" => "$views\Reports\Enrolleds\index",
    "sie-reports-participants" => "$views\Reports\Participants\Others\index",
    "sie-reports-registereds" => "$views\Reports\Snies\Registereds\index",
    "sie-reports-registeredslistregistereds" => "$views\Reports\Snies\RegisteredsListRegistereds\index",
    "sie-reports-firstyear" => "$views\Reports\Snies\FirstYear\index",
    "sie-reports-coverage" => "$views\Reports\Snies\Coverage\index",
    "sie-reports-biller" => "$views\Reports\Biller\index",
    "sie-reports-projected-home" => "$views\Reports\Projected\index",
    "sie-reports-control-home" => "$views\Reports\Control\Home\index",
    "sie-reports-control-graduations" => "$views\Reports\Control\Graduations\index",
    "sie-reports-courses-home" => "$views\Courses\Reports\Home\index",
    "sie-reports-courses-general" => "$views\Courses\Reports\General\index",
    "sie-reports-statistics-home" => "$views\Reports\Statistics\Home\index",
    "sie-reports-statistics-general" => "$views\Reports\Statistics\General\index",
    "sie-reports-enrolledcourses" => "$views\Reports\Snies\EnrolledCourses\index",
    "sie-reports-teachers" => "$views\Reports\Teachers\index",
    "sie-reports-invoicing" => "$views\Reports\Invoicing\index",
    "sie-reports-observations-general" => "$views\Observations\Reports\General\index",
    //[Orders]----------------------------------------------------------------------------------------
    "sie-orders-home" => "$views\Orders\Home\index",
    "sie-orders-list" => "$views\Orders\List\index",
    "sie-orders-view" => "$views\Orders\View\index",
    "sie-orders-create" => "$views\Orders\Create\index",
    "sie-orders-edit" => "$views\Orders\Edit\index",
    "sie-orders-delete" => "$views\Orders\Delete\index",
    "sie-orders-credit" => "$views\Orders\Credit\index",
    "sie-orders-print" => "$views\Orders\Print\index",
    //[Institutions]----------------------------------------------------------------------------------------------------
    "sie-institutions-home" => "$views\Institutions\Home\index",
    "sie-institutions-list" => "$views\Institutions\List\index",
    "sie-institutions-view" => "$views\Institutions\View\index",
    "sie-institutions-create" => "$views\Institutions\Create\index",
    "sie-institutions-edit" => "$views\Institutions\Edit\index",
    "sie-institutions-delete" => "$views\Institutions\Delete\index",
    //[Groups]----------------------------------------------------------------------------------------
    "sie-groups-home" => "$views\Groups\Home\index",
    "sie-groups-list" => "$views\Groups\List\index",
    "sie-groups-view" => "$views\Groups\View\index",
    "sie-groups-create" => "$views\Groups\Create\index",
    "sie-groups-edit" => "$views\Groups\Edit\index",
    "sie-groups-delete" => "$views\Groups\Delete\index",
    //[Spaces]----------------------------------------------------------------------------------------
    "sie-spaces-home" => "$views\Spaces\Home\index",
    "sie-spaces-list" => "$views\Spaces\List\index",
    "sie-spaces-view" => "$views\Spaces\View\index",
    "sie-spaces-create" => "$views\Spaces\Create\index",
    "sie-spaces-edit" => "$views\Spaces\Edit\index",
    "sie-spaces-delete" => "$views\Spaces\Delete\index",
    //[Headquarters]----------------------------------------------------------------------------------------
    "sie-headquarters-home" => "$views\Headquarters\Home\index",
    "sie-headquarters-list" => "$views\Headquarters\List\index",
    "sie-headquarters-view" => "$views\Headquarters\View\index",
    "sie-headquarters-create" => "$views\Headquarters\Create\index",
    "sie-headquarters-edit" => "$views\Headquarters\Edit\index",
    "sie-headquarters-delete" => "$views\Headquarters\Delete\index",
    //[Qualifications]----------------------------------------------------------------------------------------
    "sie-qualifications-home" => "$views\Qualifications\Home\index",
    "sie-qualifications-list" => "$views\Qualifications\List\index",
    "sie-qualifications-view" => "$views\Qualifications\View\index",
    "sie-qualifications-create" => "$views\Qualifications\Create\index",
    "sie-qualifications-edit" => "$views\Qualifications\Edit\index",
    "sie-qualifications-delete" => "$views\Qualifications\Delete\index",
    //[Evaluations]----------------------------------------------------------------------------------------
    "sie-evaluations-home" => "$views\Evaluations\Home\index",
    "sie-evaluations-list" => "$views\Evaluations\List\index",
    "sie-evaluations-view" => "$views\Evaluations\View\index",
    "sie-evaluations-create" => "$views\Evaluations\Create\index",
    "sie-evaluations-edit" => "$views\Evaluations\Edit\index",
    "sie-evaluations-delete" => "$views\Evaluations\Delete\index",
    //[Psychometrics]---------------------------------------------------------------------------------------------------
    "sie-psychometrics-home" => "$views\Psychometrics\Home\index",
    "sie-psychometrics-list" => "$views\Psychometrics\List\index",
    "sie-psychometrics-view" => "$views\Psychometrics\View\index",
    "sie-psychometrics-create" => "$views\Psychometrics\Create\index",
    "sie-psychometrics-edit" => "$views\Psychometrics\Edit\index",
    "sie-psychometrics-delete" => "$views\Psychometrics\Delete\index",
    //[Progress]--------------------------------------------------------------------------------------------------------
    "sie-progress-home" => "$views\Progress\Home\index",
    "sie-progress-list" => "$views\Progress\List\index",
    "sie-progress-reader" => "$views\Progress\Reader\index",
    "sie-progress-view" => "$views\Progress\View\index",
    "sie-progress-create" => "$views\Progress\Create\index",
    "sie-progress-edit" => "$views\Progress\Edit\index",
    "sie-progress-delete" => "$views\Progress\Delete\index",
    "sie-progress-print" => "$views\Progress\Print\index",
    //[Tools]-----------------------------------------------------------------------------------------------------------
    "sie-tools-home" => "$views\Tools\Home\index",
    "sie-tools-enroller" => "$views\Tools\Enroller\index",
    "sie-tools-snies" => "$views\Tools\Snies\index",
    "sie-tools-preenrollment" => "$views\Tools\Preenrollment\index",
    "sie-tools-preenrollments" => "$views\Tools\Preenrollments\index",
    "sie-tools-discounts" => "$views\Tools\Discounts\index",
    "sie-tools-training-registration" => "$views\Tools\Training\Registration\index",
    "sie-tools-importer" => "$views\Tools\Importer\index",
    "sie-tools-progresspensummodule" => "$views\Tools\ProgressPensumModule\index",
    "sie-tools-statuses-registrations" => "$views\Tools\Statuses\Registrations\index",
    "sie-tools-community" => "$views\Tools\Community\index",
    "sie-tools-users-autocreate" => "$views\Tools\Users\AutoCreate\index",
    "sie-tools-users-home" => "$views\Tools\Users\Home\index",
    "sie-tools-autoenrollment" => "$views\Tools\Autoenrollment\index",
    "sie-tools-moodle-courses" => "$views\Tools\Moodle\Courses\One\index",
    "sie-tools-moodle-coursesenrollments" => "$views\Tools\Moodle\Courses\All\index",
    "sie-tools-direct-courses" => "$views\Tools\Direct\Courses\index",
    //[Executions]------------------------------------------------------------------------------------------------------
    "sie-executions-home" => "$views\Executions\Home\index",
    "sie-executions-list" => "$views\Executions\List\index",
    "sie-executions-view" => "$views\Executions\View\index",
    "sie-executions-create" => "$views\Executions\Create\index",
    "sie-executions-edit" => "$views\Executions\Edit\index",
    "sie-executions-delete" => "$views\Executions\Delete\index",
    //[Q10files]--------------------------------------------------------------------------------------------------------
    "sie-q10files-home" => "$views\Q10files\Home\index",
    "sie-q10files-list" => "$views\Q10files\List\index",
    "sie-q10files-view" => "$views\Q10files\View\index",
    "sie-q10files-create" => "$views\Q10files\Create\index",
    "sie-q10files-edit" => "$views\Q10files\Edit\index",
    "sie-q10files-delete" => "$views\Q10files\Delete\index",
    "sie-q10files-import" => "$views\Q10files\Import\index",
    "sie-q10files-clear" => "$views\Q10files\Clear\index",
    "sie-q10files-read" => "$views\Q10files\Read\index",
    //[trainings]-------------------------------------------------------------------------------------------------------
    "sie-trainings-home" => "$views\Trainings\Home\index",
    "sie-trainings-list" => "$views\Trainings\List\index",
    //[Q10profiles]----------------------------------------------------------------------------------------
    "sie-q10profiles-home" => "$views\Q10profiles\Home\index",
    "sie-q10profiles-list" => "$views\Q10profiles\List\index",
    "sie-q10profiles-view" => "$views\Q10profiles\View\index",
    "sie-q10profiles-create" => "$views\Q10profiles\Create\index",
    "sie-q10profiles-edit" => "$views\Q10profiles\Edit\index",
    "sie-q10profiles-delete" => "$views\Q10profiles\Delete\index",
    //[Graduations]----------------------------------------------------------------------------------------
    "sie-graduations-home" => "$views\Graduations\Home\index",
    "sie-graduations-list" => "$views\Graduations\List\index",
    "sie-graduations-view" => "$views\Graduations\View\index",
    "sie-graduations-create" => "$views\Graduations\Create\index",
    "sie-graduations-edit" => "$views\Graduations\Edit\index",
    "sie-graduations-delete" => "$views\Graduations\Delete\index",
    "sie-graduations-settings-view" => "$views\Graduations\Settings\View\index",
    "sie-graduations-settings-edit" => "$views\Graduations\Settings\Edit\index",
    //[Preenrrollments]----------------------------------------------------------------------------------------
    "sie-preenrollments-home" => "$views\Preenrollments\Home\index",
    "sie-preenrollments-list" => "$views\Preenrollments\List\index",
    "sie-preenrollments-view" => "$views\Preenrollments\View\index",
    "sie-preenrollments-create" => "$views\Preenrollments\Create\index",
    "sie-preenrollments-edit" => "$views\Preenrollments\Edit\index",
    "sie-preenrollments-delete" => "$views\Preenrollments\Delete\index",
    //[Statuses]----------------------------------------------------------------------------------------
    "sie-statuses-home" => "$views\Statuses\Home\index",
    "sie-statuses-list" => "$views\Statuses\List\index",
    "sie-statuses-view" => "$views\Statuses\View\index",
    "sie-statuses-create" => "$views\Statuses\Create\index",
    "sie-statuses-edit" => "$views\Statuses\Edit\index",
    "sie-statuses-delete" => "$views\Statuses\Delete\index",
    //[Networks]----------------------------------------------------------------------------------------
    "sie-networks-home" => "$views\Networks\Home\index",
    "sie-networks-list" => "$views\Networks\List\index",
    "sie-networks-view" => "$views\Networks\View\index",
    "sie-networks-create" => "$views\Networks\Create\index",
    "sie-networks-edit" => "$views\Networks\Edit\index",
    "sie-networks-delete" => "$views\Networks\Delete\index",
    //[Subsectors]----------------------------------------------------------------------------------------
    "sie-subsectors-home" => "$views\Subsectors\Home\index",
    "sie-subsectors-list" => "$views\Subsectors\List\index",
    "sie-subsectors-view" => "$views\Subsectors\View\index",
    "sie-subsectors-create" => "$views\Subsectors\Create\index",
    "sie-subsectors-edit" => "$views\Subsectors\Edit\index",
    "sie-subsectors-delete" => "$views\Subsectors\Delete\index",
    //[Observations]----------------------------------------------------------------------------------------
    "sie-observations-home" => "$views\Observations\Home\index",
    "sie-observations-list" => "$views\Observations\List\index",
    "sie-observations-view" => "$views\Observations\View\index",
    "sie-observations-create" => "$views\Observations\Create\index",
    "sie-observations-edit" => "$views\Observations\Edit\index",
    "sie-observations-delete" => "$views\Observations\Delete\index",
    "sie-observations-reports" => "$views\Observations\Reports\Individual\index",
    "sie-observations-teacher" => "$views\Observations\Teacher\index",
    //[Costs]----------------------------------------------------------------------------------------
    "sie-costs-view" => "$views\Costs\View\index",
    "sie-costs-create" => "$views\Costs\Create\index",
    "sie-costs-edit" => "$views\Costs\Edit\index",
    "sie-costs-delete" => "$views\Costs\Delete\index",
    "sie-costs-list" => "$views\Costs\List\index",
    //[Messenger]-------------------------------------------------------------------------------------------------------
    "sie-moodle-home" => "$views\\Moodle\\Home\\index",
    "sie-moodle-synchronization" => "$views\\Moodle\\Users\\Synchronization\\index",
    //[Formats]----------------------------------------------------------------------------------------
    "sie-formats-home" => "$views\Formats\Home\index",
    "sie-formats-list" => "$views\Formats\List\index",
    "sie-formats-view" => "$views\Formats\View\index",
    "sie-formats-create" => "$views\Formats\Create\index",
    "sie-formats-edit" => "$views\Formats\Edit\index",
    "sie-formats-delete" => "$views\Formats\Delete\index",
    //[Certificates]----------------------------------------------------------------------------------------
    "sie-certificates-home" => "$views\Certificates\Home\index",
    "sie-certificates-list" => "$views\Certificates\List\index",
    "sie-certificates-view" => "$views\Certificates\View\index",
    "sie-certificates-create" => "$views\Certificates\Create\index",
    "sie-certificates-edit" => "$views\Certificates\Edit\index",
    "sie-certificates-delete" => "$views\Certificates\Delete\index",
    "sie-certificates-search" => "$views\Certificates\Search\index",
    //[Directs]----------------------------------------------------------------------------------------
    "sie-directs-home"=>"$views\Directs\Home\index",
    "sie-directs-list"=>"$views\Directs\List\index",
    "sie-directs-view"=>"$views\Directs\View\index",
    "sie-directs-create"=>"$views\Directs\Create\index",
    "sie-directs-edit"=>"$views\Directs\Edit\index",
    "sie-directs-delete"=>"$views\Directs\Delete\index",
    //[others]----------------------------------------------------------------------------------------------------------

);
$uri = !isset($rviews[$prefix]) ? $rviews["default"] : $rviews[$prefix];
$json = view($uri, $data);
$mmu = model("App\Modules\Messenger\Models\Messenger_Users");
//[build]---------------------------------------------------------------------------------------------------------------
$assign = array();
$assign['theme'] = "Higgs";
$assign['main_template'] = safe_json($json, 'main_template', "c9c3");
$assign['breadcrumb'] = safe_json($json, 'breadcrumb');
$assign['main'] = safe_json($json, 'main');
$assign['left'] = get_sie_sidebar2();
$assign['right'] = safe_json($json, 'right') . get_application_copyright();
$assign['logo_portrait'] = get_logo("logo_portrait");
$assign['logo_landscape'] = get_logo("logo_landscape");
$assign['logo_portrait_light'] = get_logo("logo_portrait_light");
$assign['logo_landscape_light'] = get_logo("logo_landscape_light");
$assign['type'] = safe_json($json, 'type');
$assign['canonical'] = safe_json($json, 'canonical');
$assign['title'] = safe_json($json, 'title');
$assign['description'] = safe_json($json, 'description');
$assign['categories'] = safe_json($json, 'categories');
$assign['featureds'] = safe_json($json, 'featureds');
$assign['sponsoreds'] = safe_json($json, 'sponsoreds');
$assign['articles'] = safe_json($json, 'articles');
$assign['themostseens'] = safe_json($json, 'themostseens');
$assign['article'] = safe_json($json, 'article');
$assign['next'] = safe_json($json, 'next');
$assign['previus'] = safe_json($json, 'previus');
$assign['messenger'] = true;
$assign['messenger_users'] = false;
$benchmark->stop('time');
$assign['modals'] = safe_module_modal();
$assign['benchmark'] = $benchmark->getElapsedTime('time', 4);
$assign['version'] = $version;
//[print]---------------------------------------------------------------------------------------------------------------
$template = view("App\Views\Themes\Gamma\index", $assign);
echo($template);
?>