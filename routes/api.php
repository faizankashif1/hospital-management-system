<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\HospitalController;
use App\Http\Controllers\Api\HospitalBranchController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\PatientController;

Route::middleware(['auth:sanctum', 'permission:PATIENT_CREATE'])->group(function () {
    Route::post('/patients', [PatientController::class, 'store']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/patients', [PatientController::class, 'index']);
    Route::get('/patients/{id}', [PatientController::class, 'show']);
    Route::put('/patients/{id}', [PatientController::class, 'update']);
    Route::delete('/patients/{id}', [PatientController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'permission:BRANCH_UPDATE'])->group(function () {
    Route::post('/departments', [DepartmentController::class, 'store']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/departments', [DepartmentController::class, 'index']);
    Route::get('/departments/{id}', [DepartmentController::class, 'show']);
    Route::put('/departments/{id}', [DepartmentController::class, 'update']);
    Route::delete('/departments/{id}', [DepartmentController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'permission:HOSPITAL_CREATE'])->group(function () {
    Route::post('/hospitals', [HospitalController::class, 'store']);
});

Route::middleware(['auth:sanctum', 'permission:BRANCH_CREATE'])->group(function () {
    Route::post('/branches', [HospitalBranchController::class, 'store']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/hospitals', [HospitalController::class, 'index']);
    Route::get('/hospitals/{id}', [HospitalController::class, 'show']);
    Route::put('/hospitals/{id}', [HospitalController::class, 'update']);
    Route::delete('/hospitals/{id}', [HospitalController::class, 'destroy']);

    Route::get('/branches', [HospitalBranchController::class, 'index']);
    Route::get('/branches/{id}', [HospitalBranchController::class, 'show']);
    Route::put('/branches/{id}', [HospitalBranchController::class, 'update']);
    Route::delete('/branches/{id}', [HospitalBranchController::class, 'destroy']);
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});
Route::middleware(['auth:sanctum', 'permission:DOCTOR_CREATE'])->group(function () {
    Route::post('/doctors', [DoctorController::class, 'store']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/doctors', [DoctorController::class, 'index']);
    Route::get('/doctors/{id}', [DoctorController::class, 'show']);
    Route::put('/doctors/{id}', [DoctorController::class, 'update']);
    Route::delete('/doctors/{id}', [DoctorController::class, 'destroy']);
});
