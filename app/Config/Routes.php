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

$routes->group('api', ['namespace' => 'App\Controllers\Api'], function ($routes) {
    $routes->get('home', 'Home::index');
    $routes->post('stresstest', 'Home::stresstest');
});

$routes->post('/config-teacher-student/active-year/list-year', 'Configs\ActiveYear::show_years', ['filter' => 'auth']);
$routes->post('/config-teacher-student/active-year/set-year', 'Configs\ActiveYear::set_year', ['filter' => 'auth']);

$routes->get('/dashboard/admin', 'Dashboard\DashboardAdmin::index', ['filter' => 'auth']);
$routes->get('/dashboard/admin/change-password', 'Dashboard\DashboardAdmin::change_password', ['filter' => 'auth']); #done
$routes->post('/dashboard/admin/update-password', 'Dashboard\DashboardAdmin::update_password', ['filter' => 'auth']); 

$routes->post('/system/student/notification/store', 'System\NotificationStudent::store', ['filter' => 'auth']); 




$routes->get('/dashboard/teacher', 'Dashboard\DashboardTeacher::index', ['filter' => 'auth']);
$routes->get('/dashboard/teacher/change-password', 'Dashboard\DashboardTeacher::change_password', ['filter' => 'auth']); #done
$routes->post('/dashboard/teacher/update-password', 'Dashboard\DashboardTeacher::update_password', ['filter' => 'auth']); #done
$routes->post('/dashboard/teacher/data-dashboard', 'Dashboard\DashboardTeacher::data_dashboard', ['filter' => 'auth']); #done

$routes->get('/dashboard/student', 'Dashboard\DashboardStudent::index', ['filter' => 'auth']);
$routes->get('/dashboard/student/change-password', 'Dashboard\DashboardStudent::change_password', ['filter' => 'auth']); #done
$routes->post('/dashboard/student/update-password', 'Dashboard\DashboardStudent::update_password', ['filter' => 'auth']); #done
$routes->post('/dashboard/student/data-dashboard', 'Dashboard\DashboardStudent::data_dashboard', ['filter' => 'auth']); #done

## BEGIN TEACHER ROUTE
$routes->get('/teacher/activity', 'Activity\ActivityTeacher::index', ['filter' => 'auth']);
$routes->get('/teacher/activity/get-data', 'Activity\ActivityTeacher::get_data', ['filter' => 'auth']);

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
$routes->post('/teacher/lesson/additional/grab-list-lesson-title', 'LearningMS\Lessons\AdditionalLesson::grab_list_lesson_title', ['filter' => 'auth']); #done

$routes->get('/teacher/lesson/public', 'LearningMS\Lessons\PublicLesson::index', ['filter' => 'auth']);
$routes->get('/teacher/lesson/public/view-content/(:num)', 'LearningMS\Lessons\PublicLesson::view_content/$1', ['filter' => 'auth']);
$routes->get('/teacher/lesson/public/lesson-list', 'LearningMS\Lessons\PublicLesson::lesson_list', ['filter' => 'auth']);
$routes->post('/teacher/lesson/public/get-content', 'LearningMS\Lessons\PublicLesson::get_content', ['filter' => 'auth']);
$routes->post('/teacher/lesson/public/first-page', 'LearningMS\Lessons\PublicLesson::first_page', ['filter' => 'auth']);

$routes->get('/teacher/question-bank/additional', 'LearningMS\QuestionBank\AdditionalQuestionBank::index', ['filter' => 'auth']);
$routes->get('/teacher/question-bank/additional/view-content/(:num)/(:num)', 'LearningMS\QuestionBank\AdditionalQuestionBank::view_content/$1/$2', ['filter' => 'auth']);
$routes->post('/teacher/question-bank/additional/grab-list-quest-title', 'LearningMS\QuestionBank\AdditionalQuestionBank::grab_list_quest_title', ['filter' => 'auth']);
$routes->post('/teacher/question-bank/additional/first-page', 'LearningMS\QuestionBank\AdditionalQuestionBank::first_page', ['filter' => 'auth']);
$routes->post('/teacher/question-bank/additional/update-content', 'LearningMS\QuestionBank\AdditionalQuestionBank::update_content', ['filter' => 'auth']);
$routes->post('/teacher/question-bank/additional/remove-content', 'LearningMS\QuestionBank\AdditionalQuestionBank::remove_content', ['filter' => 'auth']);
$routes->post('/teacher/question-bank/additional/get-question', 'LearningMS\QuestionBank\AdditionalQuestionBank::get_question', ['filter' => 'auth']);
$routes->post('/teacher/question-bank/additional/get-title-list', 'LearningMS\QuestionBank\AdditionalQuestionBank::get_title_list', ['filter' => 'auth']);
$routes->post('/teacher/question-bank/additional/share-task', 'LearningMS\QuestionBank\AdditionalQuestionBank::share_task', ['filter' => 'auth']);
$routes->post('/teacher/question-bank/additional/upload-task', 'LearningMS\QuestionBank\AdditionalQuestionBank::upload_task', ['filter' => 'auth']);

$routes->get('/teacher/question-bank/standart', 'LearningMS\QuestionBank\StandartQuestionBank::index', ['filter' => 'auth']);
$routes->get('/teacher/question-bank/standart/view-subject/(:num)', 'LearningMS\QuestionBank\StandartQuestionBank::view_subject/$1', ['filter' => 'auth']);
$routes->get('/teacher/question-bank/standart/view-content/(:num)/(:num)', 'LearningMS\QuestionBank\StandartQuestionBank::view_content/$1/$2', ['filter' => 'auth']);
$routes->get('/teacher/question-bank/standart/qb-list', 'LearningMS\QuestionBank\StandartQuestionBank::qb_list', ['filter' => 'auth']);
$routes->post('/teacher/question-bank/standart/first-page', 'LearningMS\QuestionBank\StandartQuestionBank::first_page', ['filter' => 'auth']);
$routes->post('/teacher/question-bank/standart/get-question', 'LearningMS\QuestionBank\StandartQuestionBank::get_question', ['filter' => 'auth']);
$routes->post('/teacher/question-bank/standart/get-title-list', 'LearningMS\QuestionBank\StandartQuestionBank::get_title_list', ['filter' => 'auth']);
$routes->post('/teacher/question-bank/standart/update-content', 'LearningMS\QuestionBank\StandartQuestionBank::update_content', ['filter' => 'auth']);

$routes->get('/teacher/question-bank/public', 'LearningMS\QuestionBank\PublicQuestionBank::index', ['filter' => 'auth']);
$routes->get('/teacher/question-bank/public/view-task/(:num)/(:any)', 'LearningMS\QuestionBank\PublicQuestionBank::view_task/$1/$2', ['filter' => 'auth']);
$routes->get('/teacher/question-bank/public/quest-list', 'LearningMS\QuestionBank\PublicQuestionBank::quest_list', ['filter' => 'auth']);
$routes->post('/teacher/question-bank/public/first-page', 'LearningMS\QuestionBank\PublicQuestionBank::first_page', ['filter' => 'auth']);

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
$routes->get('/teacher/assessment/get-student-assessment', 'LearningMS\Assessment\Assessment::get_student_assessment', ['filter' => 'auth']);
$routes->post('/teacher/assessment/get-list-religion', 'LearningMS\Assessment\Assessment::get_list_religion', ['filter' => 'auth']);
$routes->post('/teacher/assessment/check-result-assessment', 'LearningMS\Assessment\Assessment::check_result_assessment', ['filter' => 'auth']);
$routes->post('/teacher/assessment/submit-check-assessment', 'LearningMS\Assessment\Assessment::submit_check_assessment', ['filter' => 'auth']);

$routes->get('/teacher/task/index-add', 'LearningMS\Tasks\Task::index', ['filter' => 'auth']);
$routes->get('/teacher/task/index-draft', 'LearningMS\Tasks\Task::index_draft', ['filter' => 'auth']);
$routes->get('/teacher/task/index-scheduled', 'LearningMS\Tasks\Task::index_scheduled', ['filter' => 'auth']);
$routes->get('/teacher/task/index-present', 'LearningMS\Tasks\Task::index_present', ['filter' => 'auth']);
$routes->get('/teacher/task/index-done', 'LearningMS\Tasks\Task::index_done', ['filter' => 'auth']);
$routes->post('/teacher/task/grab-data-lesson', 'LearningMS\Tasks\Task::grab_data_lesson', ['filter' => 'auth']);
$routes->post('/teacher/task/get-edit', 'LearningMS\Tasks\Task::get_edit', ['filter' => 'auth']);
$routes->post('/teacher/task/store-data', 'LearningMS\Tasks\Task::store_data', ['filter' => 'auth']);
$routes->post('/teacher/task/task-lesson', 'LearningMS\Tasks\Task::task_lesson', ['filter' => 'auth']);
$routes->get('/teacher/task/list-task', 'LearningMS\Tasks\Task::list_task', ['filter' => 'auth']);
$routes->get('/teacher/task/get-student-task', 'LearningMS\Tasks\Task::get_student_task', ['filter' => 'auth']);
$routes->post('/teacher/task/check-result-task', 'LearningMS\Tasks\Task::check_result_task', ['filter' => 'auth']);
$routes->post('/teacher/task/submit-check-task', 'LearningMS\Tasks\Task::submit_check_task', ['filter' => 'auth']);

$routes->get('/teacher/groups/view-students/(:num)', 'LearningMS\Groups\Groups::view_students/$1', ['filter' => 'auth']);
$routes->get('/teacher/groups/get-list-student', 'LearningMS\Groups\Groups::get_list_students', ['filter' => 'auth']);
$routes->post('/teacher/groups/get-summary', 'LearningMS\Groups\Groups::get_summary', ['filter' => 'auth']);

## BEGIN STUDENT ROUTE
$routes->get('/student/activity', 'Activity\ActivityStudent::index', ['filter' => 'auth']);
$routes->get('/student/activity/get-data', 'Activity\ActivityStudent::get_data', ['filter' => 'auth']);

$routes->get('/student/lesson/standart', 'LearningMS\Lessons\StandartLesson::s_index', ['filter' => 'auth']);
$routes->get('/student/lesson/standart/subject-list', 'LearningMS\Lessons\StandartLesson::s_list_subject', ['filter' => 'auth']);
$routes->post('/student/lesson/standart/first-page', 'LearningMS\Lessons\StandartLesson::s_first_page', ['filter' => 'auth']);
$routes->get('/student/lesson/standart/view-content/(:num)/(:num)', 'LearningMS\Lessons\StandartLesson::s_view_content/$1/$2', ['filter' => 'auth']);
$routes->post('/student/lesson/standart/grab-content', 'LearningMS\Lessons\StandartLesson::grab_content', ['filter' => 'auth']);

$routes->get('/student/lesson/school', 'LearningMS\Lessons\SchoolLesson::s_index', ['filter' => 'auth']);
$routes->get('/student/lesson/school/subject-list', 'LearningMS\Lessons\SchoolLesson::s_list_subject', ['filter' => 'auth']);
$routes->post('/student/lesson/school/first-page', 'LearningMS\Lessons\SchoolLesson::s_first_page', ['filter' => 'auth']);
$routes->get('/student/lesson/school/view-content/(:num)/(:num)', 'LearningMS\Lessons\SchoolLesson::s_view_content/$1/$2', ['filter' => 'auth']);
$routes->post('/student/lesson/school/grab-content', 'LearningMS\Lessons\SchoolLesson::grab_content', ['filter' => 'auth']);

$routes->post('/student/lesson/additional/get-question', 'LearningMS\Lessons\AdditionalLesson::get_question', ['filter' => 'auth']);

$routes->get('/student/assessment/present', 'LearningMS\Assessment\Assessment::s_index_present', ['filter' => 'auth']);
$routes->get('/student/assessment/missed', 'LearningMS\Assessment\Assessment::s_index_missed', ['filter' => 'auth']);
$routes->get('/student/assessment/done', 'LearningMS\Assessment\Assessment::s_index_done', ['filter' => 'auth']);
$routes->get('/student/assessment/list-assessment', 'LearningMS\Assessment\Assessment::s_list_assessment', ['filter' => 'auth']);
$routes->post('/student/assessment/get-assessment', 'LearningMS\Assessment\Assessment::s_get_assessment', ['filter' => 'auth']);
$routes->post('/student/assessment/submit-assessment', 'LearningMS\Assessment\Assessment::s_submit_assessment', ['filter' => 'auth']);
$routes->post('/student/assessment/get-assessment-done', 'LearningMS\Assessment\Assessment::s_get_assessment_done', ['filter' => 'auth']);

$routes->get('/student/task/present', 'LearningMS\Tasks\Task::s_index_present', ['filter' => 'auth']);
$routes->get('/student/task/missed', 'LearningMS\Tasks\Task::s_index_missed', ['filter' => 'auth']);
$routes->get('/student/task/done', 'LearningMS\Tasks\Task::s_index_done', ['filter' => 'auth']);
$routes->get('/student/task/list-task', 'LearningMS\Tasks\Task::s_list_task', ['filter' => 'auth']);
$routes->post('/student/task/act-get-task', 'LearningMS\Tasks\Task::s_act_get_task', ['filter' => 'auth']);
$routes->post('/student/task/save-action-task', 'LearningMS\Tasks\Task::s_save_action_task', ['filter' => 'auth']);
$routes->post('/student/task/get-task-done', 'LearningMS\Tasks\Task::s_get_task_done', ['filter' => 'auth']);