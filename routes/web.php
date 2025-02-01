<?php

use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\BehaviourAssesmentController;
use App\Http\Controllers\TriageController;
use App\Http\Controllers\AuthController;
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
use App\Http\Controllers\ReceptionController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\IcdSearchController;
use App\Http\Controllers\TherapyController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\RescheduleController;
use App\Http\Controllers\FetchAppointments;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('login', [AuthController::class, 'loginGet'])->name('login');
Route::get('register', [AuthController::class, 'registerGet'])->name('register');
Route::post('register', [AuthController::class, 'registerPost'])->name('register.post');
Route::post('login', [AuthController::class, 'loginPost'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// General Routes
Route::view('/', 'home')->name('home');
Route::get('/admin', function () {
    return view('beaconAdmin');
});

// Parent Routes
Route::get('/parentform', [ParentsController::class, 'create'])->name('parents.create');
Route::post('/storeparents', [ParentsController::class, 'store'])->name('parents.store');
Route::post('/search-parent', [ParentsController::class, 'search'])->name('parents.search');
Route::post('/parent/get-children', [ParentsController::class, 'getChildren'])->name('parent.get-children');

// Child Routes
Route::get('/children/search', [ChildrenController::class, 'search'])->name('children.search');
Route::get('/children/create', [ChildrenController::class, 'create'])->name('children.create');
Route::post('/children/store', [ChildrenController::class, 'store'])->name('children.store');

// Doctor Routes
Route::get('/doctorslist', [DoctorController::class, 'index'])->name('doctors');
Route::view('/doctor_form', 'AddDoctor.doctor_form')->name('doctor.form');
Route::get('/doctors/specialization-search', [VisitController::class, 'showSpecializations'])->name('doctors.specializationSearch');
Route::get('/specializations', [VisitController::class, 'getSpecializations']);
Route::get('/doctors', [VisitController::class, 'getDoctorsBySpecialization']);

// Staff Routes
Route::get('/staff-dropdown', [StaffController::class, 'index']);
Route::get('/staff/fetch', [StaffController::class, 'fetchStaff'])->name('staff.fetch');
Route::get('/staff/names', [StaffController::class, 'fetchStaff']);

// Therapist Views
Route::view('/occupational_therapist', 'therapists.occupationalTherapist')->name('occupational_therapist');
Route::view('/speech_therapist', 'therapists.speechTherapist');
Route::view('/physical_therapist', 'therapists.physiotherapyTherapist');
Route::view('/psychotherapy_therapist', 'therapists.psychotherapyTherapist');
Route::view('/nutritionist', 'therapists.nutritionist');

// Invoice Routes
Route::get('/get-invoice-dates/{childId}', [InvoiceController::class, 'getInvoiceDates']);
Route::get('/get-invoice-details/{childId}', [InvoiceController::class, 'getInvoiceDetails']);

// Authenticated Routes
Route::group(['middleware' => 'auth'], function () {
    Route::get('profile', [AuthController::class, 'profileGet'])->name('profile');
    Route::post('profile', [AuthController::class, 'profilePost'])->name('profile.post');

    // Nurse Routes (role:1)
    Route::group(['middleware' => 'role:1'], function () {
        Route::get('/untriaged-visits', [TriageController::class, 'getUntriagedVisits']);
        Route::post('/start-triage/{visitId}', [TriageController::class, 'startTriage']);
        Route::get('/post-triage-queue', [TriageController::class, 'getPostTriageQueue']);
        Route::view('/post-triage', 'postTriageQueue');
        Route::get('/get-patient-name/{childId}', [ChildrenController::class, 'getPatientName']);
        Route::view('/triageDashboard', 'triageDash')->name('triage.dashboard');
        Route::post('/triage', [TriageController::class, 'store']);
        Route::get('/triage', [TriageController::class, 'create'])->name('triage');
        Route::get('/triage-data/{child_id}', [TriageController::class, 'getTriageData']);
    });

    // Doctor Routes (role:2)
    Route::group(['middleware' => ['role:2', 'track_user_activity']], function () {
        Route::get('/doctorDashboard', [DoctorsController::class, 'dashboard'])->name('doctor.dashboard');
        Route::post('/doctorDashboard/profile/update', [DoctorsController::class, 'updateProfile'])->name('doctor.profile.update');
        Route::get('/doctor/{registrationNumber}', [DoctorsController::class, 'getChildDetails'])->name('doctor.show');
        Route::get('/get-triage-data/{registrationNumber}', [DoctorsController::class, 'getTriageData']);
        Route::post('/save-cns-data/{registrationNumber}', [DoctorsController::class, 'saveCnsData']);
        Route::get('/get-development-milestones/{registrationNumber}', [DoctorsController::class, 'getMilestones']);
        Route::post('/save-development-milestones/{registrationNumber}', [DoctorsController::class, 'saveMilestones']);
        
        // Medical Assessment Routes
        Route::get('/get-behaviour-assessment/{registrationNumber}', [BehaviourAssesmentController::class, 'getBehaviourAssessment']);
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
        
        // Diagnosis and Treatment Routes
        Route::get('/diagnosis/{registrationNumber}', [DiagnosisController::class, 'getDiagnosis']);
        Route::post('/diagnosis/{registrationNumber}', [DiagnosisController::class, 'saveDiagnosis']);
        Route::post('/save-diagnosis/{registrationNumber}', [DiagnosisController::class, 'saveDiagnosis']);
        Route::post('/save-investigations/{registration_number}', [InvestigationController::class, 'saveInvestigations']);
        Route::get('/recordResults/{registration_number}', [InvestigationController::class, 'recordResults'])->name('recordResults');
        Route::post('/saveInvestigationResults/{registration_number}', [InvestigationController::class, 'saveInvestigationResults']);
        Route::post('/save-careplan/{registration_number}', [CarePlanController::class, 'saveCarePlan']);
        Route::get('/get-referral-data/{registration_number}', [ReferralController::class, 'getReferralData']);
        Route::get('/get-child-data/{registration_number}', [ReferralController::class, 'getChildData']);
        Route::post('/save-referral/{registration_number}', [ReferralController::class, 'saveReferral']);
        Route::get('/get-prescriptions/{registrationNumber}', [PrescriptionController::class, 'show']);
        Route::post('/prescriptions/{registrationNumber}', [PrescriptionController::class, 'store']);
        Route::post('/search', [IcdSearchController::class, 'search']);
    });

    // Receptionist Routes (role:3)
    Route::group(['middleware' => 'role:3'], function () {
        Route::get('/dashboard', [ReceptionController::class, 'dashboard'])->name('reception.dashboard');
        Route::get('/patients/{id?}', [ChildrenController::class, 'patientGet'])->name('patients.search');
        Route::get('/guardians', [ChildrenController::class, 'get']);
        Route::post('/guardians', [ChildrenController::class, 'create']);
        Route::get('/guardians/{id?}', [ChildrenController::class, 'childGet'])->name('guardians.search');
        Route::get('/visithandle/{id?}', [ReceptionController::class, 'search'])->name('search.visit');
        Route::post('/visits', [VisitController::class, 'store'])->name('visits.store');
        Route::get('/reception/calendar', [ReceptionController::class, 'calendar'])->name('reception.calendar');
        Route::get('/get-invoices', [InvoiceController::class, 'getInvoices'])->name('invoices');
        Route::get('/invoices/{invoiceId}', [InvoiceController::class, 'getInvoiceContent'])->name('invoice.content');
        Route::get('/invoice/{registrationNumber}', [InvoiceController::class, 'countVisitsForToday'])->where('registrationNumber', '.*');
    });

    // Therapist Routes (role:5)
    Route::group(['middleware' => 'role:5'], function () {
        Route::get('/therapist', [TherapistController::class, 'index'])->name('therapist.index');
        Route::post('/therapist/save', [TherapistController::class, 'saveAssessment']);
        Route::get('/therapist/progress', [TherapistController::class, 'getProgress'])->name('therapist.progress');
        Route::get('/therapist_dashboard', [TherapistController::class, 'showDashboard'])->name('therapist_dashboard');
        
        // Therapy Dashboard Routes
        Route::view('/psychotherapy_dashboard', 'therapists.psychotherapyDashboard');
        Route::view('/physiotherapy_dashboard', 'therapists.physiotherapyDashboard');
        Route::view('/speechtherapy_dashboard', 'therapists.speechtherapyDashboard');
        Route::view('/nutritionist_dashboard', 'therapists.nutritionistDashboard');
        
        // Individual Therapy Routes
        Route::get('/occupationaltherapy_dashboard/{registrationNumber}', [TherapyController::class, 'getChildDetails']);
        Route::get('/occupational_therapist/{registrationNumber}', [TherapyController::class, 'OccupationTherapy']);
        Route::get('/nutritionist/{registrationNumber}', [TherapyController::class, 'NutritionalTherapy']);
        Route::get('/speech_therapist/{registrationNumber}', [TherapyController::class, 'SpeechTherapy']);
        Route::get('/physiotherapist/{registrationNumber}', [TherapyController::class, 'PhysioTherapy']);
        Route::get('/psychotherapist/{registrationNumber}', [TherapyController::class, 'PsychoTherapy']);
        
        // Therapy Session Routes
        Route::post('/saveTherapyGoal', [TherapyController::class, 'saveTherapyGoal'])->name('savetherapy.store');
        Route::post('/completedVisit', [TherapyController::class, 'completedVisit'])->name('completedVisit.store');
        Route::post('/saveAssessment', [TherapyController::class, 'saveAssessment'])->name('saveAssessment.store');
        Route::post('/saveSession', [TherapyController::class, 'saveSession'])->name('saveSession.store');
        Route::post('/saveIndividualized', [TherapyController::class, 'saveIndividualized'])->name('saveIndividualized.store');
        Route::post('/saveFollowup', [TherapyController::class, 'saveFollowup'])->name('saveFollowup.store');
    });

    // Appointment Routes
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/get-doctors/{specializationId}', [AppointmentController::class, 'getDoctors']);
    Route::get('/check-availability', [AppointmentController::class, 'checkAvailability']);
    Route::get('/get-appointments', [FetchAppointments::class, 'getAppointments']);
    Route::delete('/cancel-appointment/{id}', [RescheduleController::class, 'cancelAppointment']);
    Route::post('/reschedule-appointment/{appointmentId}', [RescheduleController::class, 'rescheduleAppointment'])->name('appointments.rescheduleAppointment');

    // Visit Notes Routes
    Route::get('/getDoctorNotes/{registrationNumber}', [VisitController::class, 'getDoctorNotes']);
    Route::post('/saveDoctorNotes', [VisitController::class, 'doctorNotes'])->name('doctorNotes.store');
});