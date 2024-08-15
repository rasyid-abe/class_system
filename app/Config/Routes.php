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

$routes->get('/teacher/lesson/standart', 'LearningMS\Lessons\StandartLesson::index', ['filter' => 'auth']);
$routes->get('/teacher/lesson/standart/create', 'LearningMS\Lessons\StandartLesson::create', ['filter' => 'auth']); #done
$routes->post('/teacher/lesson/standart/ref-data', 'LearningMS\Lessons\StandartLesson::ref_data', ['filter' => 'auth']);

$routes->get('/teacher/lesson/school', 'LessonsMS\SchoolLesson::index', ['filter' => 'auth']);

$routes->get('/teacher/lesson/additional', 'LearningMS\Lessons\AdditionalLesson::index', ['filter' => 'auth']);
$routes->get('/teacher/lesson/additional/view-content/(:num)/(:num)', 'LearningMS\Lessons\AdditionalLesson::view_content/$1/$2', ['filter' => 'auth']);
$routes->get('/teacher/lesson/additional/create/(:num)/(:num)', 'LearningMS\Lessons\AdditionalLesson::create/$1/$2', ['filter' => 'auth']);
$routes->post('/teacher/lesson/additional/store', 'LearningMS\Lessons\AdditionalLesson::store', ['filter' => 'auth']);
$routes->post('/teacher/lesson/additional/grab-chaps', 'LearningMS\Lessons\AdditionalLesson::grab_chaps', ['filter' => 'auth']);
$routes->post('/teacher/lesson/additional/grab-content', 'LearningMS\Lessons\AdditionalLesson::grab_content', ['filter' => 'auth']);
$routes->post('/teacher/lesson/additional/grab-topic-content', 'LearningMS\Lessons\AdditionalLesson::grab_topic_content', ['filter' => 'auth']);
$routes->post('/teacher/lesson/additional/update-content', 'LearningMS\Lessons\AdditionalLesson::update_content', ['filter' => 'auth']);
$routes->get('/teacher/lesson/additional/edit/(:num)', 'LearningMS\Lessons\AdditionalLesson::edit/$1', ['filter' => 'auth']);
$routes->post('/teacher/lesson/additional/update', 'LearningMS\Lessons\AdditionalLesson::update', ['filter' => 'auth']);
$routes->post('/teacher/lesson/additional/status', 'LearningMS\Lessons\AdditionalLesson::status', ['filter' => 'auth']); #done
$routes->delete('/teacher/lesson/additional/destroy', 'LearningMS\Lessons\AdditionalLesson::destroy', ['filter' => 'auth']); #done

$routes->get('/teacher/lesson/public', 'LessonsMS\PublicLesson::index', ['filter' => 'auth']);

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