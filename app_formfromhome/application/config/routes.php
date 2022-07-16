<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'auth/auth/secure_user_login_authorization';

$route['reg-secure'] = 'auth/auth/register_admin';
$route['verify'] = 'auth/auth/secure_user_verification';
$route['verify-user/(:any)/(:any)'] = 'auth/auth/verify_user/$1/$2';
$route['verify-app/(:any)/(:any)'] = 'app/auth/app_verification/$1/$2';

// LOGIN
$route['login-auth'] = 'auth/auth/secure_user_login_authorization';
$route['forgot-password'] = 'auth/auth/forgot_password';


// LOGOUT
$route['auth-logout'] = 'auth/auth/logout';


$route['f3-dashboard'] = 'admin/dashboard';

// WHATSAPP
$route['send-whatsapp-msg'] = 'admin/whatsapp/sendMsg';


// exam
$route['exam-add'] = 'admin/exam/add';
$route['exam-view'] = 'admin/exam/index';
$route['get-exam'] = 'admin/exam/showExam';
$route['exam-detail'] = 'admin/exam/exam_detail';
$route['exam-edit/(:any)'] = 'admin/exam/edit/$1';

// STATE
$route['add-state'] = 'admin/state/add';
$route['view-state'] = 'admin/state/index';
$route['edit-state/(:any)'] = 'admin/state/edit/$1';
$route['get-state'] = 'admin/state/showState';
$route['reset-password'] = 'auth/auth/reset_password';


// RESULT
$route['add-result'] = 'admin/result/add';
$route['view-result'] = 'admin/result/index';
$route['edit-result/(:any)'] = 'admin/result/edit/$1';
$route['delete-result/(:any)'] = 'admin/result/delete/$1';
$route['get-result'] = 'admin/result/showResult';

// ADMIT CARD
$route['add-admit-card'] = 'admin/admitcard/add';
$route['view-admit-card'] = 'admin/admitcard/index';
$route['edit-admit-card/(:any)'] = 'admin/admitcard/edit/$1';
$route['delete-admit-card/(:any)'] = 'admin/admitcard/delete/$1';
$route['get-admit-card'] = 'admin/admitcard/showAdmitcard';

// ANSWER KEY
$route['add-answer-key'] = 'admin/answerkey/add';
$route['view-answer-key'] = 'admin/answerkey/index';
$route['edit-answer-key/(:any)'] = 'admin/answerkey/edit/$1';
$route['delete-answer-key/(:any)'] = 'admin/answerkey/delete/$1';
$route['get-admit-card'] = 'admin/answerkey/showAnswerkey';


// TEXT SLIDER
$route['add-text-slider'] = 'admin/textslider/add';
$route['view-text-slider'] = 'admin/textslider/index';
$route['edit-text-slider/(:any)'] = 'admin/textslider/edit/$1';
$route['delete-text-slider/(:any)'] = 'admin/textslider/delete/$1';
$route['get-text-slider'] = 'admin/textslider/showTextslider';


// EXECUTIVE
$route['add-user-executive'] = 'admin/executive/add';
$route['executive-listing'] = 'admin/executive/index';
$route['active/(:any)'] = 'admin/executive/active/$1';
$route['inactive/(:any)'] = 'admin/executive/inactive/$1';
$route['exe-edit/(:any)'] = 'admin/executive/edit/$1';
$route['application-view'] = 'admin/application/application_list';
$route['get-application'] = 'admin/application/showapplication';
$route['application-status'] = 'admin/application/application_status';
$route['app-info'] = 'admin/application/get_app_info';

$route['exe-password/(:any)'] = 'auth/auth/passwordedit/$1';
$route['get-executive'] = 'admin/executive/showExecutive';

//category
$route['add-category']	= 'admin/category/add';
$route['view-category']	=	'admin/category/index';
$route['get-category']  = 'admin/category/showcategory';
$route['edit-caterory/(:any)']  = 'admin/category/edit/$1';

//
$route['view-log']  = 'admin/log/index';
$route['get-log']  = 'admin/log/showlog';


//service charges

$route['add-service-charges'] = 'admin/servicecharges/add';
$route['view-service-charges'] = 'admin/servicecharges/index';
$route['get-service-charges']  = 'admin/servicecharges/showservicecharges';
$route['edit-service-charges/(:any)']  = 'admin/servicecharges/edit/$1';

//board
$route['add-board'] = 'admin/selectors/add_board';
$route['view-board'] = 'admin/selectors/index_board';
$route['get-board'] = 'admin/selectors/showboard';
$route['edit-board/(:any)'] = 'admin/selectors/edit_board/$1';
//stream
$route['add-stream'] = 'admin/selectors/add_stream';
$route['view-stream'] = 'admin/selectors/index_stream';
$route['get-stream'] = 'admin/selectors/showstream';
$route['edit-stream/(:any)'] = 'admin/selectors/edit_stream/$1';

//mediam
$route['add-mediam'] = 'admin/selectors/add_mediam';
$route['view-mediam'] = 'admin/selectors/index_mediam';
$route['get-mediam'] = 'admin/selectors/showmediam';
$route['edit-mediam/(:any)'] = 'admin/selectors/edit_mediam/$1';



//qualification
$route['add-qualification'] = 'admin/selectors/add_qualification';
$route['view-qualification'] = 'admin/selectors/index_qualification';
$route['get-qualification'] = 'admin/selectors/showqualification';
$route['edit-qualification/(:any)'] = 'admin/selectors/edit_qualification/$1';


//student
$route['student-listing'] = 'admin/student/index';
$route['get-student'] = 'admin/student/showstudent';
$route['student-details'] = 'admin/student/showprofile';
$route['send-email/(:any)'] = 'admin/student/send_email_to_student/$1';
$route['student-info'] = 'admin/student/student_info';


$route['add-student'] = 'admin/student/add_student';
$route['edit-student/(:any)'] = 'admin/student/edit_student/$1';
$route['a-add-academic/(:any)'] = 'admin/academic/add/$1';
$route['a-edit-academic/(:any)'] = 'admin/academic/edit/$1';
$route['admin-view-academic/(:any)'] = 'admin/academic/viewAcademic/$1';
$route['delete-marksheet'] = 'admin/academic/delete_marksheet';


$route['a-add-certificate/(:any)'] = 'admin/certificate/add/$1';
$route['a-edit-certificate/(:any)'] = 'admin/certificate/edit/$1';
$route['student-delete/(:any)'] = 'admin/student/delete_all/$1';
$route['admin-view-certificate/(:any)'] = 'admin/certificate/viewCertificate/$1';
$route['delete-certificate'] = 'admin/certificate/delete_certificate';

// EMAIL
$route['compose'] = 'admin/email/compose';
$route['send-email'] = 'admin/email/send_email';

// MESSAGE
$route['compose-message'] = 'admin/message/compose';


// ZIP ROUTES
$route['get-zip/(:any)'] = 'admin/student/download_zip/$1';
$route['download-zip-file'] = 'admin/zip/download';


/*
/
*/
//APP ROUTES
/*
/
*/


// APP LOGIN
$route['register'] = 'app/auth/app_registration';
$route['app-login'] = 'app/auth/app_login';
$route['app-logout'] = 'app/auth/app_logout';
$route['forget-password'] = 'app/auth/forget_password';
$route['reset-password'] = 'app/auth/reset_password';
$route['confirm'] = 'app/auth/confirm_password';

$route['student-profile'] = 'app/student/add_student_profile';
$route['edit-profile/(:any)'] = 'app/student/edit_profile/$1';
$route['personal-details'] = 'app/student/view_profile';
$route['academic-details'] = 'app/student/view_academic';
$route['edit-academic/(:any)'] = 'app/student/edit_academic/$1';
$route['certificate-details'] = 'app/student/view_certificate';
$route['my-profile'] = 'app/student/personal_details';
$route['order-history'] = 'app/application/index';


// APP EXAM
$route['exam'] = 'app/exam/get_all_exam';
$route['detail'] = 'app/exam/get_exam_detail';

//app exam-selectors
$route['qualification'] = 'app/qualification/all_qualification';
$route['board'] = 'app/board/all_board';
$route['stream'] = 'app/stream/all_stream';
$route['mediam'] = 'app/mediam/all_mediam';
$route['help']  =  'app/help/index';
$route['student-order'] = 'app/order/index';
$route['notification'] = 'app/notification/index';

// ACADEMIC
$route['add-academic'] = 'app/academic/add';
$route['add-certificate'] = 'app/certificate/add';
$route['edit-certificate/(:any)'] = 'app/certificate/edit/$1';


// CART
$route['save-item-to-cart'] = 'app/cart/save_item_to_cart';
$route['cart'] = 'app/cart/view_cart';
$route['delete-item'] = 'app/cart/delete_cart_item';

// NOTIFICATION
$route['get-notification'] = 'app/application/get_all_notification';


// FEEDBACK
$route['feedback'] = 'app/feedback/feedback';
$route['read-feedback'] = 'admin/feedback/index';
$route['get-feedback'] = 'admin/feedback/showFeedback';



// APP DASHBOARD
$route['app-root'] = 'app/root/index';


// RESULT
$route['getresult'] = 'result/getresult';

// ADMIT CARD
$route['getadmitcard'] = 'admitcard/getadmitcard';

// ANSWER KEY
$route['getanswerkey'] = 'answerkey/getanswerkey';

// TEXT SLIDER
$route['gettextslider'] = 'textslider/gettextslider';




// API 

// AUTHENTICATION
// $route['generateotp'] = 'auth/generate_otp';
// $route['validateotp'] = 'auth/validate_otp';



$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
