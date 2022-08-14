<?php


use App\Http\Controllers\Backend\ProfileController;
use Illuminate\Support\Facades\Mail;

Route::get('/mail', function () {
    try {
        $link = route('order.show', ['id' => 9]);
        Mail::send('frontend.mail_order_success', ['link' => $link], function ($message) {
            $message->to('yeuemtenthai@gmail.com', 'yeuemtenthai')->subject('Test send mail ok oy nay xxx');
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        });
    } catch (\Exception $e) {
        dd($e);
    }
});


use App\Http\Controllers\AboutPageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\BranchController;
use App\Http\Controllers\Backend\ClassController;
use App\Http\Controllers\Backend\CourseController;
use App\Http\Controllers\Backend\ManagerController;
use App\Http\Controllers\Backend\NewController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\RoomController;
use App\Http\Controllers\Backend\TeacherController;
use App\Http\Controllers\Backend\TkbController;
use App\Http\Controllers\BlogPageController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ContactPageController;
use App\Http\Controllers\CoursePageController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\MailjetController;
use App\Http\Controllers\Backend\QuestionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\VnpayController;
use App\Http\Controllers\AuthFEController;
use App\Models\MailConfig;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Auth\AuthController as AuthBe;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get("/debug", function () {
    dd(now()->hour(15)->minute(0)->second(0)->diffInMinutes(now(),false));
    $config = MailConfig::with("template", "campaign")
        ->where("campaign_id", 19)
        ->first();
    dd($config);

    $html = $config->template->html;
    dd($html);

    // $lead = Lead::first();
    // $campaign = Campaign::first();
    // return view("Email.tiktok-invited",compact("lead","campaign"));
    // dispatch(new HandleInvited(43, 1));
});

// Auth::routes();

Route::get('/vnpay/checkout', [VnpayController::class, 'payment'])->where('path', '[a-zA-Z0-9-/]+');
Route::get('/vnpay/success', [VnpayController::class, 'success'])->where('path', '[a-zA-Z0-9-/]+');

Route::get('/', [HomePageController::class, 'index'])->name('home')->where('path', '[a-zA-Z0-9-/]+');
Route::get('/tin-tuc', [BlogPageController::class, 'getTinTuc'])->where('path', '[a-zA-Z0-9-/]+')->name('tin-tuc');
Route::get('/tin-tuc/{slug}', [BlogPageController::class, 'getTinTucDetail'])->where('path', '[a-zA-Z0-9-/]+')->name('tin_tuc.chi_tiet');
Route::get('/bai-viet', [BlogPageController::class, 'getBaiViet'])->name('bai-viet');
Route::get('/bai-viet/{slug}', [BlogPageController::class, 'getBaiVietDetail'])->name('bai-viet.chi_tiet');
Route::get('/course', [CoursePageController::class, 'index'])->where('path', '[a-zA-Z0-9-/]+')->name('course');
Route::get('/course/{slug}/{classId}/detail', [CoursePageController::class, 'detailClass'])->where('path', '[a-zA-Z0-9-/]+');
Route::get('/course/{slug}/{classId}/register', [CoursePageController::class, 'register'])->where('path', '[a-zA-Z0-9-/]+');
Route::post('/course/{slug}/{classId}/register', [CoursePageController::class, 'storeRegister'])->where('path', '[a-zA-Z0-9-/]+');
Route::get('/course/{slug}/classes', [CoursePageController::class, 'classes'])->where('path', '[a-zA-Z0-9-/]+');
Route::get('/course/{slug}', [CoursePageController::class, 'detail'])->where('path', '[a-zA-Z0-9-/]+');

Route::get('/about', [AboutPageController::class, 'index'])->where('path', '[a-zA-Z0-9-/]+');
Route::get('/contact', [ContactPageController::class, 'index'])->where('path', '[a-zA-Z0-9-/]+');
Route::post('/contact', [ContactPageController::class, 'store'])->where('path', '[a-zA-Z0-9-/]+');

Route::get('/register', [AuthFEController::class, 'register'])->name('get.register');;
Route::post('/register', [AuthFEController::class, 'postRegister'])->name('post.register');
Route::get('/login', [AuthFEController::class, 'login'])->name('get.login');
Route::post('/login', [AuthFEController::class, 'postLogin'])->name('post.login');
Route::get('/logout', [AuthFEController::class, 'logout'])->name('get.logout');
Route::get('/forgot-password', [AuthFEController::class, 'forgotPassword'])->name('forgot_password');
Route::post('/forgot-password', [AuthFEController::class, 'postForgotPassword'])->name('post.forgot_password');
Route::get('/setting-new-password/{otp}', [AuthFEController::class, 'settingNewPassword'])->name('setting_new_password');
Route::post('/setting-new-password/{otp}', [AuthFEController::class, 'postSettingNewPassword'])->name('post.setting_new_password');

Route::group(['middleware' => ['authFe']], function(){
    Route::get('/profile', [StudentController::class, 'profile'])->name('get.profile');
    Route::get('/profile/edit', [StudentController::class, 'editProfile'])->name('edit.profile');
    Route::post('/profile/update', [StudentController::class, 'updateProfile'])->name('update.profile');
    Route::get('/order/detail/{id}', [StudentController::class, 'orderDetail'])->name('order.show');
    Route::get('/test', [StudentController::class, 'test'])->name('get.student.test');
    Route::post('/test', [StudentController::class, 'submitTest'])->name('post.student.test.submit');
    Route::post('/answer', [StudentController::class, 'answerQuestion'])->name('post.student.answer');
    Route::get('/ket-qua-test', [StudentController::class, 'getKqTest'])->name('get.student.ket-qua-test');
    Route::get('/course-suggest', [StudentController::class, 'suggest'])->where('path', '[a-zA-Z0-9-/]+')->name('course.suggest');
});


Route::get('/admin/{path?}', [AdminController::class, 'index'])->where('path', '[a-zA-Z0-9-/]+');
Route::get('/preview/{id}/{previewId}', [MailjetController::class, 'preview'])->name("preview");
//Route::get('/{path?}', [SinglePageController::class, 'index'])->where('path', '[a-zA-Z0-9-/]+');

Route::get('/gio-hang', [\App\Http\Controllers\CheckoutController::class, 'cart'])->name('cart');
Route::post('/add-to-cart', [\App\Http\Controllers\CheckoutController::class, 'addCart'])->name('add_cart');
Route::post('/remove-item-cart/{class_id}', [\App\Http\Controllers\CheckoutController::class, 'removeItemCart'])->name('remove_item_cart');
Route::post('/thanh-toan', [\App\Http\Controllers\CheckoutController::class, 'checkout'])->name('checkout');
Route::get('/return-vnpay', [\App\Http\Controllers\CheckoutController::class, 'returnVnpay'])->name('returnVnpay');

// ========== BACKEND AREA ==========
Route::get('management/login', [AuthBe::class, 'showFormLogin'])->name('be.login');
Route::post('management/login', [AuthBe::class, 'postLogin'])->name('be.login.post');
Route::get('management-teacher/login', [AuthBe::class, 'showFormLoginTeacher'])->name('t.login');
Route::post('management-teacher/login', [AuthBe::class, 'postLoginTeacher'])->name('t.login.post');

Route::group(['prefix'=>'management/', 'as'=>'be.', 'middleware' => ['authBackend']], function() {
    Route::get('/', [App\Http\Controllers\Backend\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [AuthBe::class, 'logout'])->name('logout');
    Route::get('/degree', [DegreeController::class, 'index1'])->name('degree');
    Route::get('/certificate', [CertificateController::class, 'index1'])->name('certificate');
//    Route::get('/level', [\App\Http\Controllers\Backend\LevelController::class, 'index'])->name('level');
    Route::get('/lien-he', [App\Http\Controllers\Backend\ContactController::class, 'index'])->name('contact.index');
    Route::get('/order', [App\Http\Controllers\Backend\OrderController::class, 'index'])->name('order');
    Route::get('/order-detail/{id}', [App\Http\Controllers\Backend\OrderController::class, 'detail'])->name('order_detail');
    Route::resource('/question', QuestionController::class);
    Route::resource('/new', NewController::class);
    Route::resource('/post', PostController::class);
    Route::resource('/teacher', TeacherController::class);
    Route::resource('/branch', BranchController::class);
    Route::resource('/room', RoomController::class);
    Route::resource('/course', CourseController::class);
    Route::resource('/class', ClassController::class);
    Route::resource('/staff', ManagerController::class);
    Route::resource('/tkb', TkbController::class);

    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

Route::group(['prefix'=>'management-teacher/', 'as'=>'t.', 'middleware' => ['authTeacher']], function() {
    Route::get('/tkb', [App\Http\Controllers\Teacher\TeacherController::class, 'getTKB'])->name('tkb');
    Route::get('/profile', [App\Http\Controllers\Teacher\TeacherController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [App\Http\Controllers\Teacher\TeacherController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [App\Http\Controllers\Teacher\TeacherController::class, 'update'])->name('profile.update');
    Route::get('/logout', [AuthBe::class, 'logoutTeacher'])->name('logout');
});
