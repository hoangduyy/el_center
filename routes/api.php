<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\ClassScheduleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\MailjetController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SinglePageController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentCourseController;
use App\Http\Controllers\StudentPointController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\TimeKeepingComplainController;
use App\Http\Controllers\TimeKeepingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::resource('/contact', ContactController::class);

Route::post("/lead/{id}", [LeadController::class, "store"]);
Route::get("/{slug}/profile", [LeadController::class, "info"]);
Route::get("/{slug}/top", [LeadController::class, "top"]);
Route::get('/campaign/{slug}', [SinglePageController::class, 'info']);

Route::prefix('/admin')->group(function () {

    Route::post('/login', [AdminController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/upload', [AdminController::class, 'upload']);
        Route::get('/mailjet', [MailjetController::class, 'index']);
        Route::get('/mailjet/{id}', [MailjetController::class, 'show']);
        Route::resource('/campaign', CampaignController::class);
        Route::resource('/template', TemplateController::class);
        Route::get('/lead/{id}', [LeadController::class, 'index']);

        Route::put('/profile', [UserController::class, 'updateProfile']);

        Route::get('/report/overview', [ReportController::class, 'overview']);
        Route::get('/report/customer', [ReportController::class, 'customer']);
        Route::get('/report/revenue', [ReportController::class, 'revenue']);
        Route::get('/report/revenue/export', [ReportController::class, 'exportReportRevenue']);

        Route::resource('/category', CategoryController::class);

        Route::resource('/blog-category', BlogCategoryController::class);
        Route::resource('/blog-post', BlogPostController::class);

        Route::resource('/branch', BranchController::class);

        Route::get('/room/schedule', [RoomController::class, 'roomSchedules']);
        Route::resource('/room', RoomController::class);

        Route::resource('/course', CourseController::class);

        Route::resource('/level', LevelController::class);

        Route::get('/class/student-info/{id}/{classId}', [ClassRoomController::class, 'getStudentInfo']);
        Route::resource('/class', ClassRoomController::class);
        Route::resource('/class-schedule', ClassScheduleController::class);

        Route::get('/teacher/schedule', [TeacherController::class, 'getSchedule']);
        Route::resource('/teacher', TeacherController::class);
        Route::resource('/question', QuestionController::class);

        Route::get('/student/course', [StudentCourseController::class, 'index']);
        Route::get('/student/schedule', [StudentController::class, 'getSchedule']);
        Route::resource('/student', StudentController::class);

        Route::resource('/student-point', StudentPointController::class);


        Route::resource('/order', OrderController::class);
        Route::resource('/order-history', OrderHistoryController::class);

        Route::resource('/degree', DegreeController::class);
        Route::resource('/certificate', CertificateController::class);

        Route::apiResource("/time-keeping", TimeKeepingController::class)->only(['index', 'store']);
        Route::apiResource("/time-keeping-complain", TimeKeepingComplainController::class)->only(["update","store", "index"]);
    });

    Route::get('/order/export/{id}', [OrderController::class, 'exportOrder']);
    Route::get('/order/export-pdf/{id}', [OrderController::class, 'exportPDFOrder']);
});
