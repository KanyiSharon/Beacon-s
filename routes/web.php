<?php

use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\BehaviourAssesmentController;
use App\Http\Controllers\TriageController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\TherapistController;
use App\Http\Controllers\FamilySocialHistoryController;
use App\Http\Controllers\PerinatalHistoryController;
use App\Http\Controllers\PastMedicalHistoryController;
use App\Http\Controllers\GeneralExamController;
use App\Http\Controllers\DevelopmentAssessmentController;
use App\Http\Controllers\InvestigationController;
use App\Http\Controllers\CarePlanController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\VisitController;




//Doctor Form Routes

Route::get('/doctorslist', [DoctorController::class, 'index'])->name('doctors');
Route::view('/doctor_form', 'AddDoctor.doctor_form'); // Display the form

//Therapist Routes
Route::get('/therapist', [TherapistController::class, 'index'])->name('therapist.index');
Route::post('/therapist/save', [TherapistController::class, 'saveTherapyNeeds'])->name('therapist.save');
Route::get('/therapist/progress', [TherapistController::class, 'getProgress'])->name('therapist.progress');
Route::view('/doctor_form', 'AddDoctor.doctor_form')->name('doctor.form'); // Display the doctor form once the add doctor button is clicked


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

Route::get('/', function () {
    return view('home');
})->name('home');

//therapist routes
Route::get('/occupational_therapist', function () {
    return view('therapists.occupationalTherapist');
});
Route::get('/speech_therapist', function () {
    return view('therapists.speechTherapist');
});
Route::get('/physical_therapist', function () {
    return view('therapists.physiotherapyTherapist');
});
Route::get('/psychotherapy_therapist', function () {
    return view('therapists.psychotherapyTherapist');
});
Route::get('/nutritionist', function () {
    return view('therapists.nutritionist');
});
//therapist routes end above

Route::get('/receiptionist_dashboard', function () {
    return view('Receiptionist\Receiptionist_dashboard');
});

Route::get('/doctor/{registrationNumber}', [DoctorsController::class, 'getChildDetails'])->name('doctor.show');



//this handles parent related activity
Route::get('/parentform', [ParentsController::class, 'create'])->name('parents.create');
// Handle form submission to store a new parent
Route::post('/storeparents', [ParentsController::class, 'store'])->name('parents.store');
//search for parent
Route::post('/search-parent', [ParentsController::class, 'search'])->name('parents.search');

Route::get('/create',[DiagnosisController::class,'create']);

//Handles child related operations
Route::get('/childform', [ChildrenController::class, 'create'])->name('children.create');
// Handle form submission to store a new child
Route::post('/storechild', [ChildrenController::class, 'store'])->name('children.store');
Route::get('/parents',[ParentsController::class,'create']);


Route::get('login', [AuthController::class, 'loginGet'])->name('login');
Route::get('register', [AuthController::class, 'registerGet'])->name('register');
Route::post('register', [AuthController::class, 'registerPost'])->name('register.post');
Route::post('login', [AuthController::class, 'loginPost'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/visits', [VisitController::class, 'index'])->name('visits.index');
        Route::get('/visits-page', function () {
            return view('visits');
        })->name('visits.page');


//routes accessible when logged in only
Route::group(['middleware' => 'auth'], function () {

    Route::get('profile', [AuthController::class, 'profileGet'])->name('profile');
    Route::post('profile', [AuthController::class, 'profilePost'])->name('profile.post');

    //routes accessible based on role_id
    //Nurse
    Route::group(['middleware' => 'role:1'], function () {
        Route::get('/untriaged-visits', [TriageController::class, 'getUntriagedVisits']); //->name('visits.untriaged');

        Route::get('/untriaged-visits', [TriageController::class, 'getUntriagedVisits']);
        Route::post('/start-triage/{visitId}', [TriageController::class, 'startTriage']);
        // // In routes/web.php
        Route::get('/get-untriaged-visits', [TriageController::class, ' getUntriagedVisits']);

        Route::get('/post-triage-queue', [TriageController::class, 'getPostTriageQueue']);
        Route::get('/post-triage', function () {
            return view('postTriageQueue');
        });
        Route::get('/doctorDashboard', [TriageController::class, 'getPostTriageQueue']);

        Route::get('/get-patient-name/{childId}', [ChildrenController::class, 'getPatientName']);
    });

    //Doctor
    Route::group(['middleware' => 'role:2'], function () {

        Route::get('/doctorDashboard', [DoctorsController::class, 'dashboard'])->name('doctor.dashboard');

        Route::get('/doctor/{registrationNumber}', [DoctorsController::class, 'show'])->name('doctor.show');

        Route::get('/get-triage-data/{registrationNumber}', [DoctorsController::class, 'getTriageData']);

        Route::post('/save-cns-data/{registrationNumber}', [DoctorsController::class, 'saveCnsData']);

        Route::get('/get-development-milestones/{registrationNumber}', [DoctorsController::class, 'getMilestones']);

        Route::post('/save-development-milestones/{registrationNumber}', [DoctorsController::class, 'saveMilestones']);

        Route::get('/create', [DiagnosisController::class, 'create']);
        Route::get('/get-behaviour-assessment/{registrationNumber}', [BehaviourAssesmentController::class, 'getBehaviourAssessment']);

        // Save or update Behaviour Assessment for a child
        Route::post('/save-behaviour-assessment/{registrationNumber}', [BehaviourAssesmentController::class, 'saveBehaviourAssessment']);

        Route::get('/get-family-social-history/{visitId}', [FamilySocialHistoryController::class, 'getFamilySocialHistory']);
        Route::post('/save-family-social-history/{visitId}', [FamilySocialHistoryController::class, 'saveFamilySocialHistory']);

        Route::get('/perinatal-history/{registrationNumber}', [PerinatalHistoryController::class, 'getPerinatalHistory']);
        Route::post('/perinatal-history/{registrationNumber}', [PerinatalHistoryController::class, 'savePerinatalHistory']);

        Route::get('/past-medical-history/{registrationNumber}', [PastMedicalHistoryController::class, 'getPastMedicalHistory']);
        Route::post('/save-past-medical-history/{registrationNumber}', [PastMedicalHistoryController::class, 'savePastMedicalHistory']);

        Route::get('/general-exam/{registrationNumber}', [GeneralExamController::class, 'getGeneralExam']);
        Route::post('/general-exam/{registrationNumber}', [GeneralExamController::class, 'saveGeneralExam']);

        Route::get('/development-assessment/{registrationNumber}', [DevelopmentAssessmentController::class, 'getDevelopmentAssessment']);
        Route::post('/development-assessment/{registrationNumber}', [DevelopmentAssessmentController::class, 'saveDevelopmentAssessment']);

        Route::get('/diagnosis/{registrationNumber}', [DiagnosisController::class, 'getDiagnosis']);
        Route::post('/diagnosis/{registrationNumber}', [DiagnosisController::class, 'saveDiagnosis']);

        Route::post('/save-investigations/{registration_number}', [InvestigationController::class, 'saveInvestigations']);
        Route::get('/recordResults/{registration_number}', [InvestigationController::class, 'recordResults'])->name('recordResults');
        Route::post('/saveInvestigationResults/{registration_number}', [InvestigationController::class, 'saveInvestigationResults']);

        Route::post('/save-careplan/{registration_number}', [CarePlanController::class, 'saveCarePlan']);

        Route::get('/get-referral-data/{registration_number}', [ReferralController::class, 'getReferralData']);
        Route::get('/get-child-data/{registration_number}', [ReferralController::class, 'getChildData']);
        Route::post('/save-referral/{registration_number}', [ReferralController::class, 'saveReferral']);

        Route::get('/get-prescriptions/{registrationNumber}', [PrescriptionController::class, 'show']);
        Route::post('/prescriptions/{registrationNumber}', [PrescriptionController::class, 'store']);
    });

    //Receptionist
    Route::group(['middleware' => 'role:3'], function () {});

    //Admin
    Route::group(['middleware' => 'role:4'], function () {});
});

