<?php

use App\Http\Controllers\PublicWebsiteController;
use App\Models\Invoice;
use App\Models\Prescription;
use App\Services\PdfGenerationService;
use Illuminate\Support\Facades\Route;

// Public Homepage
Route::get('/', [PublicWebsiteController::class, 'home'])->name('home');

// Setup Wizard (Section 22)
Route::get('/setup', [PublicWebsiteController::class, 'setupWizard'])->name('setup.wizard');
Route::post('/setup', [PublicWebsiteController::class, 'completeSetupWizard'])->name('setup.complete');

// Public Online Appointment Booking (Patient self-scheduling)
Route::get('/book-appointment', [PublicWebsiteController::class, 'bookAppointmentForm'])->name('booking.form');
Route::post('/book-appointment', [PublicWebsiteController::class, 'submitPublicAppointment'])->name('booking.submit');
Route::get('/booking-confirmed/{token}', [PublicWebsiteController::class, 'bookingSuccess'])->name('booking.success');

// Hospital / Clinic Branded Microsite Builder (Section 10)
Route::get('/h/{slug}', [PublicWebsiteController::class, 'hospitalMicrosite'])->name('hospital.microsite');

// Public Marketing Pages (Section 9 - 30 pages)
Route::get('/p/{slug}', [PublicWebsiteController::class, 'page'])->name('page.show');

// PDF Downloads using Laravel Unicode PDF
Route::get('/invoices/{id}/download', function (int $id) {
    $invoice = Invoice::findOrFail($id);
    $pdf = PdfGenerationService::generateInvoicePdf($invoice, request('locale', 'en'));

    return response($pdf)
        ->header('Content-Type', 'text/html; charset=UTF-8')
        ->header('Content-Disposition', "inline; filename=\"invoice-{$invoice->invoice_number}.html\"");
})->name('invoice.download');

Route::get('/prescriptions/{id}/download', function (int $id) {
    $prescription = Prescription::findOrFail($id);
    $pdf = PdfGenerationService::generatePrescriptionPdf($prescription, request('locale', 'en'));

    return response($pdf)
        ->header('Content-Type', 'text/html; charset=UTF-8')
        ->header('Content-Disposition', "inline; filename=\"prescription-{$prescription->prescription_number}.html\"");
})->name('prescription.download');
