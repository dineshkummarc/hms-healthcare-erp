<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Prescription;
use ImranDev\UnicodePdf\Facades\UnicodePdf;

class PdfGenerationService
{
    /**
     * Generate multilingual, Unicode-safe invoice PDF
     */
    public static function generateInvoicePdf(Invoice $invoice, string $locale = 'en'): string
    {
        $invoice->load(['patient', 'branch', 'organization', 'items', 'payments']);

        $html = view('pdf.invoice', [
            'invoice' => $invoice,
            'locale' => $locale,
            'isRtl' => in_array($locale, ['ar', 'ur', 'he', 'fa'], true),
        ])->render();

        try {
            return UnicodePdf::html($html)
                ->format('A4')
                ->output();
        } catch (\Throwable $e) {
            // Fallback to basic HTML if font engine requires initialization
            return $html;
        }
    }

    /**
     * Generate multilingual, Unicode-safe doctor prescription PDF
     */
    public static function generatePrescriptionPdf(Prescription $prescription, string $locale = 'en'): string
    {
        $prescription->load(['patient', 'doctor.user', 'doctor.department', 'branch', 'organization', 'items']);

        $html = view('pdf.prescription', [
            'prescription' => $prescription,
            'locale' => $locale,
            'isRtl' => in_array($locale, ['ar', 'ur', 'he', 'fa'], true),
        ])->render();

        try {
            return UnicodePdf::html($html)
                ->format('A4')
                ->output();
        } catch (\Throwable $e) {
            return $html;
        }
    }
}
