<?php


use App\Http\Controllers\Web\AdmissionController;
use App\Http\Controllers\Web\AnswerController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\BaseLineController;
use App\Http\Controllers\Web\CodeMasterController;
use App\Http\Controllers\Web\CounselorController;
use App\Http\Controllers\Web\CustomerController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\DrugController;
use App\Http\Controllers\Web\EducationController;
use App\Http\Controllers\Web\EthnicController;
use App\Http\Controllers\Web\FileController;
use App\Http\Controllers\Web\KitController;
use App\Http\Controllers\Web\MedicationController;
use App\Http\Controllers\Web\MedicationScheduleController;
use App\Http\Controllers\Web\MeetingController;
use App\Http\Controllers\Web\MessageController;
use App\Http\Controllers\Web\ObservationController;
use App\Http\Controllers\Web\PasienTbcController;
use App\Http\Controllers\Web\PetugasController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\QuestionController;
use App\Http\Controllers\Web\QuestionnaireController;
use App\Http\Controllers\Web\ReligionController;
use App\Http\Controllers\Web\ServiceController;
use App\Http\Controllers\Web\StatusMenikahController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\ZoomMasterController;
use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('welcome');
//})->name('home');
Route::get('/', [AuthController::class, 'index'])->name('home')->middleware('guest');
Route::get('/login/phone', [AuthController::class, 'login_phone'])->name('auth.login.phone')->middleware('guest');
Route::post('/postLoginPhone', [AuthController::class, 'postLoginPhone'])->name('auth.postLoginPhone');
Route::get('/login/phone/otp', [AuthController::class, 'login_phone_otp'])->name('auth.login.phone.otp')->middleware('guest');
Route::post('/postLoginPhoneOtp', [AuthController::class, 'postLoginPhoneOtp'])->name('auth.postLoginPhoneOtp');
Route::get('/login', [AuthController::class, 'login'])->name('auth.login')->middleware('guest');
Route::post('/postLogin', [AuthController::class, 'postLogin'])->name('auth.postLogin');
Route::get('register', [AuthController::class, 'register'])->name('auth.register');
Route::post('daftar', [AuthController::class, 'daftar'])->name('auth.daftar');
Route::get('activate', [AuthController::class, 'activate'])->name('auth.activate');
Route::get('activate/manual', [AuthController::class, 'activate_manual'])->name('auth.activate.manual');
Route::get('activate/{nik}/{otp}', [AuthController::class, 'activate_url'])->name('auth.activate.url');
Route::post('activate', [AuthController::class, 'do_activate'])->name('auth.do_activate');
Route::get('newOTP', [AuthController::class, 'new_otp'])->name('auth.new_otp');
Route::post('newOTP', [AuthController::class, 'create_new_otp'])->name('auth.create.new_otp');

//profile
Route::get('profile', [ProfileController::class,'profile'])->name('profile.index')->middleware('auth');
Route::get('profile/edit', [ProfileController::class,'edit'])->name('profile.edit')->middleware('auth');
Route::post('profile', [ProfileController::class,'update'])->name('profile.update')->middleware('auth');
Route::post('profile/foto', [ProfileController::class,'update_foto'])->name('profile.update.foto')->middleware('auth');
Route::post('profile/organisasi', [ProfileController::class,'update_orgnisasi'])->name('profile.update.organisasi')->middleware('auth');
Route::get('/profile/{id}', [ProfileController::class,'user'])->name('user.profile')->middleware('auth');

//request otp untuk rest password
Route::get('forgotPassword', [AuthController::class, 'forgotPassword'])->name('auth.forgotPassword')->middleware('guest');
Route::post('getPassword', [AuthController::class, 'getPassword'])->name('auth.getPassword');

//update password dengan OTP
Route::get('password/reset/request', [AuthController::class, 'reset_password'])->name('auth.request.reset.password');
Route::post('password/reset/do', [AuthController::class, 'do_reset_password'])->name('auth.do.reset.password');


Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');
Route::get('token', [AuthController::class, 'token'])->name('auth.token');

Route::get('messages', [MessageController::class, 'index'])->name('message.index')->middleware('auth');
Route::get('message/{id}', [MessageController::class, 'chat_room'])->name('message.room')->middleware('auth');
Route::post('message', [MessageController::class, 'store_chat'])->name('message.room.store')->middleware('auth');
Route::get('message/user/{id}', [MessageController::class, 'user'])->name('message.user')->middleware('auth');

Route::get('meetings', [MeetingController::class, 'index'])->name('meeting.index')->middleware('auth');
Route::post('meeting/pasien/store', [MeetingController::class, 'store_by_pasien'])->name('meeting.store_by_pasien')->middleware('auth');
Route::post('meeting/counselor/store', [MeetingController::class, 'store_by_counselor'])->name('meeting.store_by_counselor')->middleware('auth');
Route::get('meeting/host/mine', [MeetingController::class, 'mine'])->name('meeting.host.mine')->middleware('auth');
Route::get('meeting/{id}/show', [MeetingController::class, 'show'])->name('meeting.show')->middleware('auth');
Route::get('meeting/{id}/validation', [MeetingController::class, 'validation'])->name('meeting.validation')->middleware('auth');
Route::post('meeting/{id}/update', [MeetingController::class, 'update'])->name('meeting.update')->middleware('auth');

Route::get('zoom/masters', [ZoomMasterController::class, 'index'])->name('zoom.master.index')->middleware('auth');
Route::get('zoom/master', [ZoomMasterController::class, 'create'])->name('zoom.master.create')->middleware('auth');
Route::post('zoom/master', [ZoomMasterController::class, 'store'])->name('zoom.master.store')->middleware('auth');
Route::get('zoom/master/{id}/edit', [ZoomMasterController::class, 'edit'])->name('zoom.master.edit')->middleware('auth');
Route::post('zoom/master/{id}/update', [ZoomMasterController::class, 'update'])->name('zoom.master.update')->middleware('auth');

Route::get('counselors', [CounselorController::class, 'index'])->name('counselor.index')->middleware('auth');
Route::post('counselors', [CounselorController::class, 'store'])->name('counselor.store')->middleware('auth');
Route::get('counselor/{id}/show', [CounselorController::class, 'show'])->name('counselor.show')->middleware('auth');
Route::get('counselor/{id}/delete', [CounselorController::class, 'destroy'])->name('counselor.destroy')->middleware('auth');

Route::get('petugas', [PetugasController::class, 'index'])->name('petugas.index')->middleware('auth');
Route::get('petugas/create', [PetugasController::class, 'create'])->name('petugas.create')->middleware('auth');
Route::post('petugas/store', [PetugasController::class, 'store'])->name('petugas.store')->middleware('auth');

Route::get('patient/tbc/mine', [PasienTbcController::class, 'mine'])->name('pasien.tbc.mine')->middleware('auth');
Route::get('patient/tbc/create/{id}/counselor', [PasienTbcController::class, 'create'])->name('pasien.tbc.create.counselor')->middleware('auth');
Route::post('patient/tbc/search/{id}/counselor', [PasienTbcController::class, 'store'])->name('pasien.tbc.search.counselor')->middleware('auth');
Route::get('patient/tbc/{id}/destroy', [PasienTbcController::class, 'destroy'])->name('pasien.tbc.destroy')->middleware('auth');

Route::get('questionnaire', [QuestionnaireController::class, 'index'])->name('questionnaire.index')->middleware('auth');
Route::get('questionnaire/create/external', [QuestionnaireController::class, 'external'])->name('questionnaire.create.external')->middleware('auth');
Route::get('questionnaire/create/internal', [QuestionnaireController::class, 'create'])->name('questionnaire.create')->middleware('auth');
Route::post('questionnaire/store', [QuestionnaireController::class, 'store'])->name('questionnaire.store')->middleware('auth');
Route::get('questionnaire/{id}/view', [QuestionnaireController::class, 'show'])->name('questionnaire.show')->middleware('auth');
Route::get('questionnaire/status/publish', [QuestionnaireController::class, 'publish'])->name('questionnaire.publish')->middleware('auth');
Route::get('questionnaire/{id}/detail', [QuestionnaireController::class, 'showByuser'])->name('questionnaire.showByuser')->middleware('auth');

Route::get('drugs', [DrugController::class, 'index'])->name('drugs.index')->middleware('auth');
Route::post('drugs', [DrugController::class, 'store'])->name('drugs.store')->middleware('auth');
Route::get('drugs/{id}/delete', [DrugController::class, 'destroy'])->name('drugs.destroy')->middleware('auth');

Route::get('medication', [MedicationController::class, 'mine'])->name('medication.mine')->middleware('auth');
Route::get('medication/{id}/show', [MedicationController::class, 'show'])->name('medication.show')->middleware('auth');
Route::post('medication', [MedicationController::class, 'store'])->name('medication.store')->middleware('auth');

Route::post('medication/schedule/{id}/store', [MedicationScheduleController::class, 'store'])->name('medication.schedule.store')->middleware('auth');

Route::post('question/store', [QuestionController::class, 'store'])->name('question.store')->middleware('auth');

Route::post('answer/store', [AnswerController::class, 'store'])->name('answer.store')->middleware('auth');


Route::get('users', [UserController::class,'index'])->name('users.index')->middleware('auth');
Route::get('user', [UserController::class,'create'])->name('users.create')->middleware('auth');
Route::post('users', [UserController::class,'store'])->name('users.store')->middleware('auth');
Route::get('users/{id}/show', [UserController::class,'show'])->name('users.show')->middleware('auth');
Route::get('users/{id}/edit', [UserController::class,'edit'])->name('users.edit')->middleware('auth');
Route::post('users/{id}/update', [UserController::class,'update'])->name('users.update')->middleware('auth');
Route::post('users/{id}/blokir', [UserController::class,'blokir'])->name('users.blokir')->middleware('auth');
Route::post('users/{id}/delete', [UserController::class,'destroy'])->name('users.destroy')->middleware('auth');
Route::get('users/{properti}/{value}/code', [UserController::class,'kode'])->name('users.kode')->middleware('auth');
Route::get('users/find/all/create', [UserController::class,'find'])->name('users.find')->middleware('auth');

//petugas
Route::get('petugas', [UserController::class,'petugas_all'])->name('users.petugas.all')->middleware('auth');
Route::post('petugas', [UserController::class,'store_petugas'])->name('users.petugas.store')->middleware('auth');
Route::get('petugas/{id}/faskes', [UserController::class,'petugas_faskes'])->name('users.petugas.faskes')->middleware('auth');


Route::get('marital-status', [StatusMenikahController::class,'index'])->name('marital_status');
Route::get('marital-status/create', [StatusMenikahController::class,'create'])->name('marital_status.create');
Route::post('marital-status/store', [StatusMenikahController::class,'store'])->name('marital_status.store');
Route::get('marital-status/{id}', [StatusMenikahController::class,'show'])->name('marital_status.show');
Route::get('marital-status/{id}/edit', [StatusMenikahController::class,'edit'])->name('marital_status.edit');
Route::post('marital-status/{id}/update', [StatusMenikahController::class,'update'])->name('marital_status.update');
Route::post('marital-status/{id}/destroy', [StatusMenikahController::class,'destroy'])->name('marital_status.destroy');

Route::get('ethnics', [EthnicController::class, 'index'])->name('ethnic');
Route::get('ethnic', [EthnicController::class, 'create'])->name('ethnic.create');
Route::post('ethnic', [EthnicController::class, 'store'])->name('ethnic.store');
Route::get('ethnic/{id}', [EthnicController::class, 'show'])->name('ethnic.show');
Route::post('ethnic/{id}', [EthnicController::class, 'update'])->name('ethnic.update');
Route::post('ethnic/{id}/destroy', [EthnicController::class, 'destroy'])->name('ethnic.destroy');
Route::get('ethnic/{id}/restore', [EthnicController::class, 'restore'])->name('ethnic.restore');

Route::get('religions', [ReligionController::class, 'index'])->name('religion');
Route::get('religion', [ReligionController::class, 'create'])->name('religion.create');
Route::post('religion', [ReligionController::class, 'store'])->name('religion.store');
Route::get('religion/{id}', [ReligionController::class, 'show'])->name('religion.show');
Route::get('religion/{id}/edit', [ReligionController::class, 'edit'])->name('religion.edit');
Route::post('religion/{id}', [ReligionController::class, 'update'])->name('religion.update');
Route::post('religion/{id}/destroy', [ReligionController::class, 'destroy'])->name('religion.destroy');

Route::get('educations', [EducationController::class, 'index'])->name('education');
Route::get('education', [EducationController::class, 'create'])->name('education.create');
Route::post('education', [EducationController::class, 'store'])->name('education.store');
Route::get('education/{id}', [EducationController::class, 'show'])->name('education.show');
Route::get('education/{id}/edit', [EducationController::class, 'edit'])->name('education.edit');
Route::post('education/{id}', [EducationController::class, 'update'])->name('education.update');
Route::post('education/{id}/delete', [EducationController::class, 'destroy'])->name('education.destroy');

Route::get('/customers',[CustomerController::class, 'index'])->name('customers')->middleware('auth');
Route::get('/customer',[CustomerController::class, 'create'])->name('customers.create')->middleware('auth');
Route::post('/customers',[CustomerController::class,'store'])->name('customers.store');
Route::get('/customers/{id}/show',[CustomerController::class,'show'])->name('customers.show');
Route::get('/customers/{id}/edit',[CustomerController::class,'edit'])->name('customers.edit');
Route::post('/customers/{id}/update',[CustomerController::class,'update'])->name('customers.update');

Route::get('observation', [ObservationController::class, 'index'])->name('observation.index');
Route::get('observation/{id}/petugas', [ObservationController::class, 'petugas'])->name('observation.petugas');

Route::get('codes', [CodeMasterController::class, 'index'])->name('code.index')->middleware('auth');
Route::get('code', [CodeMasterController::class, 'create'])->name('code.create')->middleware('auth');
Route::post('code', [CodeMasterController::class, 'store'])->name('code.store')->middleware('auth');
Route::get('code/{id}/show', [CodeMasterController::class, 'show'])->name('code.show')->middleware('auth');
Route::post('code/{id}/update', [CodeMasterController::class, 'update'])->name('code.update')->middleware('auth');

Route::get('kits', [KitController::class, 'index'])->name('kits.index');
Route::get('kit', [KitController::class, 'create'])->name('kits.create');
Route::post('kits', [KitController::class, 'store'])->name('kits.store');

Route::get('baseLine', [BaseLineController::class, 'index'])->name('baseLine.index');

Route::get('files', [FileController::class, 'index'])->name('file.index');

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

Route::get('admission/{id}/faskes', [AdmissionController::class, 'index'])->name('admission.index');
Route::get('admission/{id_user}/{id_customer}', [AdmissionController::class, 'kunjungan'])->name('admission.create');
Route::post('admission/store', [AdmissionController::class, 'store'])->name('admission.store');

Route::get('services', [ServiceController::class, 'index'])->name('service.index');
Route::get('services/{id}/faskes', [ServiceController::class, 'faskes'])->name('service.faskes');
Route::get('service', [ServiceController::class, 'create'])->name('service.create');
Route::post('service', [ServiceController::class, 'store'])->name('service.store');
Route::get('service/{id}/show', [ServiceController::class, 'show'])->name('service.show');
Route::get('service/{id}/edit', [ServiceController::class, 'edit'])->name('service.edit');
Route::post('service/{id}/update', [ServiceController::class, 'update'])->name('service.update');
