<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Authentication\AuthConfig::sign_in', ['filter' => 'noauth']);
$routes->get('/sign-in', 'Authentication\AuthConfig::sign_in', ['filter' => 'noauth']);
$routes->get('/forgot-password', 'Authentication\AuthConfig::forgot_password', ['filter' => 'noauth']);
$routes->get('/reset-password/(:any)/(:any)', 'Authentication\AuthConfig::reset_password/$1/$2', ['filter' => 'noauth']);
$routes->post('/request-reset', 'Authentication\AuthConfig::request_reset');
$routes->post('/submit-reset-password', 'Authentication\AuthConfig::submit_reset_password');
$routes->post('/login', 'Authentication\AuthConfig::login');
$routes->get('/logout', 'Authentication\AuthConfig::logout');
$routes->get('/blocked', 'Authentication\AuthConfig::blocked');
$routes->get('/notfound', 'Authentication\AuthConfig::notfound');

$routes->get('/dashboard/admin', 'Dashboard\DashboardAdmin::index', ['filter' => 'auth']);
$routes->get('/dashboard/admin/change-password', 'Dashboard\DashboardAdmin::change_password', ['filter' => 'auth']); #done
$routes->post('/dashboard/admin/update-password', 'Dashboard\DashboardAdmin::update_password', ['filter' => 'auth']); #done

$routes->get('/dashboard/school', 'Dashboard\DashboardSchool::index', ['filter' => 'auth']);
$routes->get('/dashboard/school/show/(:num)', 'Dashboard\DashboardSchool::show/$1', ['filter' => 'auth']);
$routes->get('/dashboard/school/edit/(:num)', 'Dashboard\DashboardSchool::edit/$1', ['filter' => 'auth']); #done
$routes->post('/dashboard/school/list_area', 'Dashboard\DashboardSchool::list_area', ['filter' => 'auth']);
$routes->post('/dashboard/school/update', 'Dashboard\DashboardSchool::update', ['filter' => 'auth']); #done
$routes->get('/dashboard/school/change-password', 'Dashboard\DashboardSchool::change_password', ['filter' => 'auth']); #done
$routes->post('/dashboard/school/update-password', 'Dashboard\DashboardSchool::update_password', ['filter' => 'auth']); #done
$routes->post('/dashboard/school/email-verify', 'Dashboard\DashboardSchool::email_verify', ['filter' => 'auth']); #done
$routes->get('/dashboard/school/validate-email/(:any)/(:any)', 'Dashboard\DashboardSchool::validate_email/$1/$2', ['filter' => 'auth']);

$routes->get('/dashboard/teacher', 'Dashboard\DashboardTeacher::index', ['filter' => 'auth']);
$routes->get('/dashboard/teacher/change-password', 'Dashboard\DashboarTeacher::change_password', ['filter' => 'auth']); #done
$routes->post('/dashboard/teacher/update-password', 'Dashboard\DashboarTeacher::update_password', ['filter' => 'auth']); #done

$routes->get('/dashboard/student', 'Dashboard\DashboardStudent::index', ['filter' => 'auth']);
$routes->get('/dashboard/student/change-password', 'Dashboard\DashboardStudent::change_password', ['filter' => 'auth']); #done
$routes->post('/dashboard/student/update-password', 'Dashboard\DashboardStudent::update_password', ['filter' => 'auth']); #done

$routes->get('/config/menu', 'Configs\Menu::index', ['filter' => 'auth']); #done
$routes->get('/config/menu/add-menu', 'Configs\Menu::add_menu', ['filter' => 'auth']); #done
$routes->get('/config/menu/add-submenu/(:num)', 'Configs\Menu::add_submenu/$1', ['filter' => 'auth']); #done
$routes->get('/config/menu/add-method/(:num)/(:num)', 'Configs\Menu::add_method/$1/$2', ['filter' => 'auth']); #done
$routes->post('/config/menu/save', 'Configs\Menu::save', ['filter' => 'auth']); #done
$routes->get('/config/menu/edit/(:num)', 'Configs\Menu::edit/$1', ['filter' => 'auth']); #done
$routes->get('/config/menu/edit-submenu/(:num)', 'Configs\Menu::edit_submenu/$1', ['filter' => 'auth']); #done
$routes->get('/config/menu/edit-method/(:num)/(:num)/(:num)', 'Configs\Menu::edit_method/$1/$2/$3', ['filter' => 'auth']); #done
$routes->delete('/config/menu/delete/(:num)', 'Configs\Menu::delete/$1', ['filter' => 'auth']); #done
$routes->post('/config/menu/update', 'Configs\Menu::update', ['filter' => 'auth']); #done
$routes->get('/config/menu/submenu/(:segment)', 'Configs\Menu::submenu/$1', ['filter' => 'auth']); #done
$routes->get('/config/menu/method/(:segment)/(:segment)', 'Configs\Menu::method/$1/$2', ['filter' => 'auth']); #done
$routes->post('/config/menu/status', 'Configs\Menu::status', ['filter' => 'auth']); #done
$routes->post('/config/menu/get-menu', 'Configs\MenuShortcut::get_menu', ['filter' => 'auth']);
$routes->post('/config/menu/shortcut-store', 'Configs\MenuShortcut::shortcut_store', ['filter' => 'auth']);
$routes->post('/config/menu/show-shortcut', 'Configs\MenuShortcut::show_shortcut', ['filter' => 'auth']);

$routes->get('/config/role', 'Configs\Role::index', ['filter' => 'auth']);
$routes->get('/config/role/add', 'Configs\Role::add', ['filter' => 'auth']);
$routes->post('/config/role/save', 'Configs\Role::save', ['filter' => 'auth']);
$routes->get('/config/role/edit/(:num)', 'Configs\Role::edit/$1', ['filter' => 'auth']);
$routes->post('/config/role/update', 'Configs\Role::update', ['filter' => 'auth']);
$routes->delete('/config/role/delete/(:num)', 'Configs\Role::delete/$1', ['filter' => 'auth']);
$routes->get('/config/role/access/(:num)', 'Configs\Role::access/$1', ['filter' => 'auth']);
$routes->post('/config/role/change-access', 'Configs\Role::change_access', ['filter' => 'auth']);

$routes->get('/sms/user/school', 'SchoolMS\Users\School::index', ['filter' => 'auth']); #done
$routes->get('/sms/user/school/show/(:num)', 'SchoolMS\Users\School::show/$1', ['filter' => 'auth']); #done
$routes->get('/sms/user/school/create', 'SchoolMS\Users\School::create', ['filter' => 'auth']); #done
$routes->post('/sms/user/school/list_area', 'SchoolMS\Users\School::list_area', ['filter' => 'auth']); #done
$routes->post('/sms/user/school/store', 'SchoolMS\Users\School::store', ['filter' => 'auth']); #done
$routes->get('/sms/user/school/edit/(:num)', 'SchoolMS\Users\School::edit/$1', ['filter' => 'auth']); #done
$routes->post('/sms/user/school/update', 'SchoolMS\Users\School::update', ['filter' => 'auth']); #done
$routes->post('/sms/user/school/reset-password', 'SchoolMS\Users\School::reset_password', ['filter' => 'auth']); #done
$routes->post('/sms/user/school/export', 'SchoolMS\Users\School::export', ['filter' => 'auth']); #done
$routes->post('/sms/user/school/import', 'SchoolMS\Users\School::import', ['filter' => 'auth']); #done
$routes->post('/sms/user/school/status/(:any)/(:any)', 'SchoolMS\Users\School::status/$1/$2', ['filter' => 'auth']); #done
$routes->delete('/sms/user/school/destroy', 'SchoolMS\Users\School::destroy', ['filter' => 'auth']);

$routes->get('/sms/user/teacher', 'SchoolMS\Users\Teacher::index', ['filter' => 'auth']); #done
$routes->get('/sms/user/teacher/show/(:num)', 'SchoolMS\Users\Teacher::show/$1', ['filter' => 'auth']); #done
$routes->get('/sms/user/teacher/create', 'SchoolMS\Users\Teacher::create', ['filter' => 'auth']); #done
$routes->post('/sms/user/teacher/list_area', 'SchoolMS\Users\Teacher::list_area', ['filter' => 'auth']); #done
$routes->post('/sms/user/teacher/store', 'SchoolMS\Users\Teacher::store', ['filter' => 'auth']); #done
$routes->get('/sms/user/teacher/edit/(:num)', 'SchoolMS\Users\Teacher::edit/$1', ['filter' => 'auth']); #done
$routes->post('/sms/user/teacher/update', 'SchoolMS\Users\Teacher::update', ['filter' => 'auth']); #done
$routes->post('/sms/user/teacher/export', 'SchoolMS\Users\Teacher::export', ['filter' => 'auth']); #done
$routes->post('/sms/user/teacher/import-insert', 'SchoolMS\Users\Teacher::import_insert', ['filter' => 'auth']); #done
$routes->post('/sms/user/teacher/import-update', 'SchoolMS\Users\Teacher::import_update', ['filter' => 'auth']); #done
$routes->get('/sms/user/teacher/download', 'SchoolMS\Users\Teacher::download', ['filter' => 'auth']); #done
$routes->post('/sms/user/teacher/reset-password', 'SchoolMS\Users\Teacher::reset_password', ['filter' => 'auth']); #done
$routes->post('/sms/user/teacher/view-credential', 'SchoolMS\Users\Teacher::view_credential', ['filter' => 'auth']); #done
$routes->post('/sms/user/teacher/status', 'SchoolMS\Users\Teacher::status', ['filter' => 'auth']); #done
$routes->delete('/sms/user/teacher/destroy', 'SchoolMS\Users\Teacher::destroy', ['filter' => 'auth']); #done

$routes->get('/sms/user/student', 'SchoolMS\Users\Student::index', ['filter' => 'auth']); #done
$routes->get('/sms/user/student/show/(:num)', 'SchoolMS\Users\Student::show/$1', ['filter' => 'auth']); #done
$routes->get('/sms/user/student/create', 'SchoolMS\Users\Student::create', ['filter' => 'auth']); #done
$routes->post('/sms/user/student/list_area', 'SchoolMS\Users\Student::list_area', ['filter' => 'auth']); #done
$routes->post('/sms/user/student/store', 'SchoolMS\Users\Student::store', ['filter' => 'auth']); #done
$routes->get('/sms/user/student/edit/(:num)', 'SchoolMS\Users\Student::edit/$1', ['filter' => 'auth']); #done
$routes->post('/sms/user/student/update', 'SchoolMS\Users\Student::update', ['filter' => 'auth']); #done
$routes->post('/sms/user/student/export', 'SchoolMS\Users\Student::export', ['filter' => 'auth']); #done
$routes->post('/sms/user/student/import-insert', 'SchoolMS\Users\Student::import_insert', ['filter' => 'auth']); #done
$routes->post('/sms/user/student/import-update', 'SchoolMS\Users\Student::import_update', ['filter' => 'auth']); #done
$routes->get('/sms/user/student/download', 'SchoolMS\Users\Student::download', ['filter' => 'auth']); #done
$routes->post('/sms/user/student/reset-password', 'SchoolMS\Users\Student::reset_password', ['filter' => 'auth']); #done
$routes->post('/sms/user/student/view-credential', 'SchoolMS\Users\Student::view_credential', ['filter' => 'auth']); #done
$routes->post('/sms/user/student/status', 'SchoolMS\Users\Student::status', ['filter' => 'auth']); #done
$routes->post('/sms/user/student/student-group', 'SchoolMS\Users\Student::student_group', ['filter' => 'auth']); #done
$routes->delete('/sms/user/student/destroy', 'SchoolMS\Users\Student::destroy', ['filter' => 'auth']); #done

$routes->get('/sms/master/major', 'SchoolMS\Master\Major::index', ['filter' => 'auth']); #done
$routes->get('/sms/master/major/create', 'SchoolMS\Master\Major::create', ['filter' => 'auth']);
$routes->post('/sms/master/major/store', 'SchoolMS\Master\Major::store', ['filter' => 'auth']);
$routes->get('/sms/master/major/edit/(:num)', 'SchoolMS\Master\Major::edit/$1', ['filter' => 'auth']);
$routes->post('/sms/master/major/update', 'SchoolMS\Master\Major::update', ['filter' => 'auth']);
$routes->post('/sms/master/major/status', 'SchoolMS\Master\Major::status', ['filter' => 'auth']);
$routes->delete('/sms/master/major/destroy', 'SchoolMS\Master\Major::destroy', ['filter' => 'auth']);

$routes->get('/sms/master/student-group', 'SchoolMS\Master\StudentGroup::index', ['filter' => 'auth']);
$routes->get('/sms/master/student-group/create', 'SchoolMS\Master\StudentGroup::create', ['filter' => 'auth']);
$routes->post('/sms/master/student-group/store', 'SchoolMS\Master\StudentGroup::store', ['filter' => 'auth']);
$routes->get('/sms/master/student-group/edit/(:num)', 'SchoolMS\Master\StudentGroup::edit/$1', ['filter' => 'auth']);
$routes->post('/sms/master/student-group/update', 'SchoolMS\Master\StudentGroup::update', ['filter' => 'auth']);
$routes->post('/sms/master/student-group/status', 'SchoolMS\Master\StudentGroup::status', ['filter' => 'auth']);
$routes->delete('/sms/master/student-group/destroy', 'SchoolMS\Master\StudentGroup::destroy', ['filter' => 'auth']);

$routes->get('/sms/master/subject', 'SchoolMS\Master\Subject::index', ['filter' => 'auth']);
$routes->get('/sms/master/subject/create', 'SchoolMS\Master\Subject::create', ['filter' => 'auth']);
$routes->post('/sms/master/subject/store', 'SchoolMS\Master\Subject::store', ['filter' => 'auth']);
$routes->get('/sms/master/subject/edit/(:num)', 'SchoolMS\Master\Subject::edit/$1', ['filter' => 'auth']);
$routes->post('/sms/master/subject/update', 'SchoolMS\Master\Subject::update', ['filter' => 'auth']);
$routes->post('/sms/master/subject/status', 'SchoolMS\Master\Subject::status', ['filter' => 'auth']);
$routes->delete('/sms/master/subject/destroy', 'SchoolMS\Master\Subject::destroy', ['filter' => 'auth']);

$routes->get('/sms/master/room', 'SchoolMS\Master\Room::index', ['filter' => 'auth']);
$routes->get('/sms/master/room/create', 'SchoolMS\Master\Room::create', ['filter' => 'auth']);
$routes->post('/sms/master/room/store', 'SchoolMS\Master\Room::store', ['filter' => 'auth']);
$routes->get('/sms/master/room/edit/(:num)', 'SchoolMS\Master\Room::edit/$1', ['filter' => 'auth']);
$routes->post('/sms/master/room/update', 'SchoolMS\Master\Room::update', ['filter' => 'auth']);
$routes->post('/sms/master/room/status', 'SchoolMS\Master\Room::status', ['filter' => 'auth']);
$routes->delete('/sms/master/room/destroy', 'SchoolMS\Master\Room::destroy', ['filter' => 'auth']);

$routes->get('/sms/master/teaching-schedule', 'SchoolMS\Master\TeachingSchedule::index', ['filter' => 'auth']);
$routes->get('/sms/master/teaching-schedule/create', 'SchoolMS\Master\TeachingSchedule::create', ['filter' => 'auth']);
$routes->post('/sms/master/teaching-schedule/store', 'SchoolMS\Master\TeachingSchedule::store', ['filter' => 'auth']);
$routes->get('/sms/master/teaching-schedule/edit/(:num)', 'SchoolMS\Master\TeachingSchedule::edit/$1', ['filter' => 'auth']);
$routes->post('/sms/master/teaching-schedule/update', 'SchoolMS\Master\TeachingSchedule::update', ['filter' => 'auth']);
$routes->delete('/sms/master/teaching-schedule/destroy', 'SchoolMS\Master\TeachingSchedule::destroy', ['filter' => 'auth']);

$routes->get('/sms/master/exam-schedule', 'SchoolMS\Master\ExamSchedule::index', ['filter' => 'auth']);
$routes->get('/sms/master/exam-schedule/create', 'SchoolMS\Master\ExamSchedule::create', ['filter' => 'auth']);
$routes->post('/sms/master/exam-schedule/store', 'SchoolMS\Master\ExamSchedule::store', ['filter' => 'auth']);
$routes->get('/sms/master/exam-schedule/edit/(:num)', 'SchoolMS\Master\ExamSchedule::edit/$1', ['filter' => 'auth']);
$routes->post('/sms/master/exam-schedule/update', 'SchoolMS\Master\ExamSchedule::update', ['filter' => 'auth']);
$routes->delete('/sms/master/exam-schedule/destroy', 'SchoolMS\Master\ExamSchedule::destroy', ['filter' => 'auth']);

$routes->get('/sms/master/school-year', 'SchoolMS\Master\SchoolYear::index', ['filter' => 'auth']);
$routes->get('/sms/master/school-year/create', 'SchoolMS\Master\SchoolYear::create', ['filter' => 'auth']);
$routes->post('/sms/master/school-year/store', 'SchoolMS\Master\SchoolYear::store', ['filter' => 'auth']);
$routes->get('/sms/master/school-year/edit/(:num)', 'SchoolMS\Master\SchoolYear::edit/$1', ['filter' => 'auth']);
$routes->post('/sms/master/school-year/update', 'SchoolMS\Master\SchoolYear::update', ['filter' => 'auth']);
$routes->delete('/sms/master/school-year/destroy', 'SchoolMS\Master\SchoolYear::destroy', ['filter' => 'auth']);

$routes->get('/sms/management/teacher-jobdesc', 'SchoolMS\Management\TeacherJobdesc::index', ['filter' => 'auth']);
$routes->get('/sms/management/teacher-jobdesc/create', 'SchoolMS\Management\TeacherJobdesc::create', ['filter' => 'auth']);
$routes->post('/sms/management/teacher-jobdesc/store', 'SchoolMS\Management\TeacherJobdesc::store', ['filter' => 'auth']);
$routes->get('/sms/management/teacher-jobdesc/edit/(:num)', 'SchoolMS\Management\TeacherJobdesc::edit/$1', ['filter' => 'auth']);
$routes->post('/sms/management/teacher-jobdesc/update', 'SchoolMS\Management\TeacherJobdesc::update', ['filter' => 'auth']);
$routes->delete('/sms/management/teacher-jobdesc/destroy', 'SchoolMS\Management\TeacherJobdesc::destroy', ['filter' => 'auth']);

$routes->get('/sms/management/list-class', 'SchoolMS\Management\ListClass::index', ['filter' => 'auth']);
$routes->get('/sms/management/list-class/create', 'SchoolMS\Management\ListClass::create', ['filter' => 'auth']);
$routes->post('/sms/management/list-class/store', 'SchoolMS\Management\ListClass::store', ['filter' => 'auth']);
$routes->get('/sms/management/list-class/edit/(:num)', 'SchoolMS\Management\ListClass::edit/$1', ['filter' => 'auth']);
$routes->post('/sms/management/list-class/update', 'SchoolMS\Management\ListClass::update', ['filter' => 'auth']);
$routes->delete('/sms/management/list-class/destroy', 'SchoolMS\Management\ListClass::destroy', ['filter' => 'auth']);

$routes->get('/sms/activity/list-class', 'SchoolMS\Management\ListClass::index', ['filter' => 'auth']);
$routes->get('/sms/activity/list-class/create', 'SchoolMS\Management\ListClass::create', ['filter' => 'auth']);
$routes->post('/sms/activity/list-class/store', 'SchoolMS\Management\ListClass::store', ['filter' => 'auth']);
$routes->get('/sms/activity/list-class/edit/(:num)', 'SchoolMS\Management\ListClass::edit/$1', ['filter' => 'auth']);
$routes->post('/sms/activity/list-class/update', 'SchoolMS\Management\ListClass::update', ['filter' => 'auth']);
$routes->delete('/sms/activity/list-class/destroy', 'SchoolMS\Management\ListClass::destroy', ['filter' => 'auth']);