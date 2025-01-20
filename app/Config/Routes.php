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

$routes->post('/config-teacher-student/active-year/list-year', 'Configs\ActiveYear::show_years', ['filter' => 'auth']);
$routes->post('/config-teacher-student/active-year/set-year', 'Configs\ActiveYear::set_year', ['filter' => 'auth']);

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
$routes->post('/teacher/lesson/standart/first-page', 'LearningMS\Lessons\StandartLesson::first_page', ['filter' => 'auth']);
$routes->get('/teacher/lesson/standart/lesson-list', 'LearningMS\Lessons\StandartLesson::lesson_list', ['filter' => 'auth']);
$routes->get('/teacher/lesson/standart/create', 'LearningMS\Lessons\StandartLesson::create', ['filter' => 'auth']); #done
$routes->post('/teacher/lesson/standart/ref-data', 'LearningMS\Lessons\StandartLesson::ref_data', ['filter' => 'auth']);
$routes->get('/teacher/lesson/standart/view-subject/(:num)', 'LearningMS\Lessons\StandartLesson::view_subject/$1', ['filter' => 'auth']);
$routes->get('/teacher/lesson/standart/view-content/(:num)/(:num)', 'LearningMS\Lessons\StandartLesson::view_content/$1/$2', ['filter' => 'auth']);
$routes->post('/teacher/lesson/standart/grab-content', 'LearningMS\Lessons\StandartLesson::grab_content', ['filter' => 'auth']);

$routes->get('/teacher/lesson/school', 'LearningMS\Lessons\SchoolLesson::index', ['filter' => 'auth']);
$routes->get('/teacher/lesson/school/view-content/(:num)/(:num)', 'LearningMS\Lessons\SchoolLesson::view_content/$1/$2', ['filter' => 'auth']);
$routes->post('/teacher/lesson/school/grab-content', 'LearningMS\Lessons\SchoolLesson::grab_content', ['filter' => 'auth']);
$routes->post('/teacher/lesson/school/first-page', 'LearningMS\Lessons\SchoolLesson::first_page', ['filter' => 'auth']);
$routes->post('/teacher/lesson/school/grab-child-sort', 'LearningMS\Lessons\SchoolLesson::grab_child_sort', ['filter' => 'auth']);
$routes->post('/teacher/lesson/school/grab-parent-sort', 'LearningMS\Lessons\SchoolLesson::grab_parent_sort', ['filter' => 'auth']);
$routes->post('/teacher/lesson/school/update-content', 'LearningMS\Lessons\SchoolLesson::update_content', ['filter' => 'auth']);
$routes->post('/teacher/lesson/school/grab-all-subchap', 'LearningMS\Lessons\SchoolLesson::grab_all_subchap', ['filter' => 'auth']);
$routes->post('/teacher/lesson/school/remove-content', 'LearningMS\Lessons\SchoolLesson::remove_content', ['filter' => 'auth']);

$routes->get('/teacher/lesson/additional', 'LearningMS\Lessons\AdditionalLesson::index', ['filter' => 'auth']);
$routes->get('/teacher/lesson/additional/view-content/(:num)/(:num)', 'LearningMS\Lessons\AdditionalLesson::view_content/$1/$2', ['filter' => 'auth']);
$routes->get('/teacher/lesson/additional/create/(:num)/(:num)', 'LearningMS\Lessons\AdditionalLesson::create/$1/$2', ['filter' => 'auth']);
$routes->post('/teacher/lesson/additional/first-page', 'LearningMS\Lessons\AdditionalLesson::first_page', ['filter' => 'auth']);
$routes->post('/teacher/lesson/additional/store', 'LearningMS\Lessons\AdditionalLesson::store', ['filter' => 'auth']);
$routes->post('/teacher/lesson/additional/grab-chaps', 'LearningMS\Lessons\AdditionalLesson::grab_chaps', ['filter' => 'auth']);
$routes->post('/teacher/lesson/additional/grab-content', 'LearningMS\Lessons\AdditionalLesson::grab_content', ['filter' => 'auth']);
$routes->post('/teacher/lesson/additional/grab-topic-content', 'LearningMS\Lessons\AdditionalLesson::grab_topic_content', ['filter' => 'auth']);
$routes->post('/teacher/lesson/additional/update-content', 'LearningMS\Lessons\AdditionalLesson::update_content', ['filter' => 'auth']);
$routes->post('/teacher/lesson/additional/upload-content', 'LearningMS\Lessons\AdditionalLesson::upload_content', ['filter' => 'auth']);
$routes->post('/teacher/lesson/additional/remove-content', 'LearningMS\Lessons\AdditionalLesson::remove_content', ['filter' => 'auth']);
$routes->get('/teacher/lesson/additional/edit/(:num)', 'LearningMS\Lessons\AdditionalLesson::edit/$1', ['filter' => 'auth']);
$routes->post('/teacher/lesson/additional/update', 'LearningMS\Lessons\AdditionalLesson::update', ['filter' => 'auth']);
$routes->post('/teacher/lesson/additional/status', 'LearningMS\Lessons\AdditionalLesson::status', ['filter' => 'auth']); #done
$routes->delete('/teacher/lesson/additional/destroy', 'LearningMS\Lessons\AdditionalLesson::destroy', ['filter' => 'auth']); #done
$routes->post('/teacher/lesson/additional/share-topic', 'LearningMS\Lessons\AdditionalLesson::share_topic', ['filter' => 'auth']); #done
$routes->post('/teacher/lesson/additional/question-bank', 'LearningMS\Lessons\AdditionalLesson::question_bank', ['filter' => 'auth']); #done
$routes->post('/teacher/lesson/additional/get-question', 'LearningMS\Lessons\AdditionalLesson::get_question', ['filter' => 'auth']); #done

$routes->get('/teacher/lesson/public', 'LearningMS\Lessons\PublicLesson::index', ['filter' => 'auth']);
$routes->get('/teacher/lesson/public/view-content/(:num)', 'LearningMS\Lessons\PublicLesson::view_content/$1', ['filter' => 'auth']);
$routes->get('/teacher/lesson/public/lesson-list', 'LearningMS\Lessons\PublicLesson::lesson_list', ['filter' => 'auth']);
$routes->post('/teacher/lesson/public/get-content', 'LearningMS\Lessons\PublicLesson::get_content', ['filter' => 'auth']);
$routes->post('/teacher/lesson/public/first-page', 'LearningMS\Lessons\PublicLesson::first_page', ['filter' => 'auth']);

$routes->get('/teacher/question-bank/additional', 'LearningMS\QuestionBank\AdditionalQuestionBank::index', ['filter' => 'auth']);
$routes->get('/teacher/question-bank/additional/view-content/(:num)/(:num)', 'LearningMS\QuestionBank\AdditionalQuestionBank::view_content/$1/$2', ['filter' => 'auth']);
$routes->post('/teacher/question-bank/additional/update-content', 'LearningMS\QuestionBank\AdditionalQuestionBank::update_content', ['filter' => 'auth']);
$routes->post('/teacher/question-bank/additional/remove-content', 'LearningMS\QuestionBank\AdditionalQuestionBank::remove_content', ['filter' => 'auth']);
$routes->post('/teacher/question-bank/additional/get-question', 'LearningMS\QuestionBank\AdditionalQuestionBank::get_question', ['filter' => 'auth']);
$routes->post('/teacher/question-bank/additional/get-title-list', 'LearningMS\QuestionBank\AdditionalQuestionBank::get_title_list', ['filter' => 'auth']);
$routes->post('/teacher/question-bank/additional/share-task', 'LearningMS\QuestionBank\AdditionalQuestionBank::share_task', ['filter' => 'auth']);
$routes->post('/teacher/question-bank/additional/upload-tasks', 'LearningMS\QuestionBank\AdditionalQuestionBank::upload_tasks', ['filter' => 'auth']);

$routes->get('/teacher/question-bank/standart', 'LearningMS\QuestionBank\StandartQuestionBank::index', ['filter' => 'auth']);
$routes->get('/teacher/question-bank/standart/view-subject/(:num)', 'LearningMS\QuestionBank\StandartQuestionBank::view_subject/$1', ['filter' => 'auth']);
$routes->get('/teacher/question-bank/standart/view-content/(:num)/(:num)', 'LearningMS\QuestionBank\StandartQuestionBank::view_content/$1/$2', ['filter' => 'auth']);
$routes->post('/teacher/question-bank/standart/get-question', 'LearningMS\QuestionBank\StandartQuestionBank::get_question', ['filter' => 'auth']);
$routes->post('/teacher/question-bank/standart/get-title-list', 'LearningMS\QuestionBank\StandartQuestionBank::get_title_list', ['filter' => 'auth']);
$routes->post('/teacher/question-bank/standart/update-content', 'LearningMS\QuestionBank\StandartQuestionBank::update_content', ['filter' => 'auth']);

$routes->get('/teacher/question-bank/public', 'LearningMS\QuestionBank\PublicQuestionBank::index', ['filter' => 'auth']);
$routes->get('/teacher/question-bank/public/view-task/(:num)/(:any)', 'LearningMS\QuestionBank\PublicQuestionBank::view_task/$1/$2', ['filter' => 'auth']);

$routes->get('/teacher/assessment/index-add', 'LearningMS\Assessment\Assessment::index', ['filter' => 'auth']);
$routes->get('/teacher/assessment/index-draft', 'LearningMS\Assessment\Assessment::index_draft', ['filter' => 'auth']);
$routes->get('/teacher/assessment/list-assessment', 'LearningMS\Assessment\Assessment::list_assessment', ['filter' => 'auth']);
$routes->get('/teacher/assessment/index-scheduled', 'LearningMS\Assessment\Assessment::index_scheduled', ['filter' => 'auth']);
$routes->get('/teacher/assessment/index-present', 'LearningMS\Assessment\Assessment::index_present', ['filter' => 'auth']);
$routes->get('/teacher/assessment/index-done', 'LearningMS\Assessment\Assessment::index_done', ['filter' => 'auth']);
$routes->post('/teacher/assessment/data-option', 'LearningMS\Assessment\Assessment::data_option', ['filter' => 'auth']);
$routes->post('/teacher/assessment/store-data', 'LearningMS\Assessment\Assessment::store_data', ['filter' => 'auth']);
$routes->post('/teacher/assessment/view-question-bank', 'LearningMS\Assessment\Assessment::view_question_bank', ['filter' => 'auth']);
$routes->post('/teacher/assessment/get-edit', 'LearningMS\Assessment\Assessment::get_edit', ['filter' => 'auth']);
$routes->post('/teacher/assessment/view-assessment-question', 'LearningMS\Assessment\Assessment::view_assessment_question', ['filter' => 'auth']);

$routes->get('/teacher/tasks/index-add', 'LearningMS\Tasks\Tasks::index', ['filter' => 'auth']);
$routes->get('/teacher/tasks/index-draft', 'LearningMS\Tasks\Tasks::index_draft', ['filter' => 'auth']);
$routes->get('/teacher/tasks/index-scheduled', 'LearningMS\Tasks\Tasks::index_scheduled', ['filter' => 'auth']);
$routes->get('/teacher/tasks/index-present', 'LearningMS\Tasks\Tasks::index_present', ['filter' => 'auth']);
$routes->get('/teacher/tasks/index-done', 'LearningMS\Tasks\Tasks::index_done', ['filter' => 'auth']);
$routes->post('/teacher/tasks/grab-data-lesson', 'LearningMS\Tasks\Tasks::grab_data_lesson', ['filter' => 'auth']);
$routes->post('/teacher/tasks/get-edit', 'LearningMS\Tasks\Tasks::get_edit', ['filter' => 'auth']);
$routes->post('/teacher/tasks/store-data', 'LearningMS\Tasks\Tasks::store_data', ['filter' => 'auth']);
$routes->post('/teacher/tasks/task-lesson', 'LearningMS\Tasks\Tasks::task_lesson', ['filter' => 'auth']);
$routes->get('/teacher/tasks/list-tasks', 'LearningMS\Tasks\Tasks::list_tasks', ['filter' => 'auth']);

$routes->get('/teacher/groups/view-students/(:num)', 'LearningMS\Groups\Groups::view_students/$1', ['filter' => 'auth']);
$routes->get('/teacher/groups/get-list-student', 'LearningMS\Groups\Groups::get_list_students', ['filter' => 'auth']);


$routes->get('/student/lesson/standart', 'LearningMS\Lessons\StandartLesson::s_index', ['filter' => 'auth']);