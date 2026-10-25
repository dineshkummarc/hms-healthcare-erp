<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Health and public metadata
    Route::get('/health', [ApiController::class, 'health']);
    Route::get('/modules', [ApiController::class, 'modules']);

    // Public auth
    Route::post('/auth/login', [ApiController::class, 'login']);

    // Authenticated endpoints
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/auth/user', [ApiController::class, 'user']);
        Route::post('/auth/logout', [ApiController::class, 'logout']);

        // Patient Mobile App Endpoints
        Route::middleware('module:patient_management')->group(function () {
            Route::get('/patients/profile', [ApiController::class, 'patientProfile']);
            Route::get('/patients/prescriptions', [ApiController::class, 'patientPrescriptions']);
            Route::get('/patients/lab-orders', [ApiController::class, 'patientLabOrders']);
            Route::get('/patients/invoices', [ApiController::class, 'patientInvoices']);
        });

        // Appointment Endpoints
        Route::middleware('module:appointment_management')->group(function () {
            Route::get('/appointments', [ApiController::class, 'appointments']);
            Route::post('/appointments', [ApiController::class, 'bookAppointment']);
            Route::post('/appointments/{id}/cancel', [ApiController::class, 'cancelAppointment']);
            Route::get('/doctors', [ApiController::class, 'doctors']);
        });

        // Clinical / Doctor App Endpoints
        Route::middleware('module:opd_management')->group(function () {
            Route::get('/doctor/queue', [ApiController::class, 'doctorQueue']);
            Route::post('/doctor/encounters', [ApiController::class, 'createEncounter']);
        });

        // Pharmacy Endpoints
        Route::middleware('module:pharmacy_management')->group(function () {
            Route::get('/pharmacy/medicines', [ApiController::class, 'medicines']);
            Route::get('/pharmacy/stock-alerts', [ApiController::class, 'stockAlerts']);
        });
    });
});
