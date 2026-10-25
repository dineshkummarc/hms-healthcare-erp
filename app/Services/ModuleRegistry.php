<?php

namespace App\Services;

use App\Models\Module;
use App\Models\ModuleActivation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ModuleRegistry
{
    /**
     * Complete list of 38 modules with metadata and dependencies
     */
    public static function allDefinitions(): array
    {
        return [
            // Core Modules
            'organization_management' => [
                'name' => 'Organization Management',
                'category' => 'core',
                'description' => 'Multi-tenant organization, hospital hierarchy, and platform settings',
                'is_core' => true,
                'dependencies' => [],
            ],
            'branch_management' => [
                'name' => 'Branch Management',
                'category' => 'core',
                'description' => 'Multi-branch operations, localization, tax, and branch settings',
                'is_core' => true,
                'dependencies' => ['organization_management'],
            ],
            'patient_management' => [
                'name' => 'Patient Management',
                'category' => 'core',
                'description' => 'Patient registration, MRN tracking, demographics, and clinical history',
                'is_core' => true,
                'dependencies' => ['branch_management'],
            ],
            'appointment_management' => [
                'name' => 'Appointment Management',
                'category' => 'core',
                'description' => 'Doctor scheduling, appointment slots, queue token generation, and waitlists',
                'is_core' => true,
                'dependencies' => ['patient_management', 'doctor_management'],
            ],
            'doctor_management' => [
                'name' => 'Doctor Management',
                'category' => 'core',
                'description' => 'Doctor profiles, specializations, credentials, fees, and duty rosters',
                'is_core' => true,
                'dependencies' => ['branch_management'],
            ],
            'staff_management' => [
                'name' => 'Staff Management & RBAC',
                'category' => 'core',
                'description' => 'Staff profiles, departmental assignments, and role-based access control',
                'is_core' => true,
                'dependencies' => ['branch_management'],
            ],
            'billing_invoicing' => [
                'name' => 'Billing and Invoicing',
                'category' => 'core',
                'description' => 'Patient invoices, multi-service charges, payments, and cashier reconciliation',
                'is_core' => true,
                'dependencies' => ['patient_management'],
            ],
            'reporting_analytics' => [
                'name' => 'Reporting and Analytics',
                'category' => 'core',
                'description' => 'Comprehensive operational, clinical, and financial dashboards',
                'is_core' => true,
                'dependencies' => ['billing_invoicing'],
            ],

            // Clinical Modules
            'opd_management' => [
                'name' => 'Outpatient Department (OPD)',
                'category' => 'clinical',
                'description' => 'OPD queue triage, encounter documentation, vitals, and diagnosis',
                'is_core' => false,
                'dependencies' => ['appointment_management'],
            ],
            'emr_management' => [
                'name' => 'Electronic Medical Records (EMR)',
                'category' => 'clinical',
                'description' => 'Longitudinal patient charts, observations, encounter logs, and allergies',
                'is_core' => false,
                'dependencies' => ['patient_management'],
            ],
            'prescription_management' => [
                'name' => 'Electronic Prescriptions',
                'category' => 'clinical',
                'description' => 'Digital prescriptions with doctor digital signatures, dosage advice, and PDF export',
                'is_core' => false,
                'dependencies' => ['opd_management'],
            ],
            'inpatient_management' => [
                'name' => 'Inpatient Department (IPD)',
                'category' => 'clinical',
                'description' => 'Patient admissions, attending physicians, discharge summaries, and IPD billing',
                'is_core' => false,
                'dependencies' => ['bed_ward_management'],
            ],
            'bed_ward_management' => [
                'name' => 'Bed, Ward and Room Management',
                'category' => 'clinical',
                'description' => 'Wards, rooms, bed occupancy tracking, transfers, and daily tariffs',
                'is_core' => false,
                'dependencies' => ['branch_management'],
            ],
            'emergency_department' => [
                'name' => 'Emergency Department',
                'category' => 'clinical',
                'description' => 'Emergency triage scoring, priority queues, and rapid response encounters',
                'is_core' => false,
                'dependencies' => ['patient_management'],
            ],
            'nursing_management' => [
                'name' => 'Nursing Management',
                'category' => 'clinical',
                'description' => 'Nursing observation charts, vital signs recording, and medication administration',
                'is_core' => false,
                'dependencies' => ['inpatient_management'],
            ],
            'surgery_ot' => [
                'name' => 'Surgery and Operating Theatre',
                'category' => 'clinical',
                'description' => 'Surgical case booking, OT rooms, pre-op/post-op notes, and surgical teams',
                'is_core' => false,
                'dependencies' => ['inpatient_management'],
            ],
            'icu_hdu' => [
                'name' => 'ICU and HDU Management',
                'category' => 'clinical',
                'description' => 'Critical care beds, intensive observation, and handover tracking',
                'is_core' => false,
                'dependencies' => ['inpatient_management'],
            ],

            // Diagnostics Modules
            'laboratory_management' => [
                'name' => 'Laboratory Management (LIS)',
                'category' => 'diagnostics',
                'description' => 'Lab test catalog, sample collection, technician results, and verified reports',
                'is_core' => false,
                'dependencies' => ['patient_management'],
            ],
            'radiology_imaging' => [
                'name' => 'Radiology and Imaging (RIS)',
                'category' => 'diagnostics',
                'description' => 'X-ray, USG, CT/MRI orders, PACS integration architecture, and radiologist findings',
                'is_core' => false,
                'dependencies' => ['patient_management'],
            ],

            // Commerce & Inventory Modules
            'pharmacy_management' => [
                'name' => 'Pharmacy Management',
                'category' => 'commerce',
                'description' => 'Medicine catalog, batch & expiry tracking, POS dispensing, and sales invoices',
                'is_core' => false,
                'dependencies' => ['branch_management'],
            ],
            'inventory_warehouse' => [
                'name' => 'Inventory and Warehouse',
                'category' => 'commerce',
                'description' => 'Consumables, stock movements, inter-branch transfers, and reorder alerts',
                'is_core' => false,
                'dependencies' => ['branch_management'],
            ],
            'procurement_suppliers' => [
                'name' => 'Procurement and Suppliers',
                'category' => 'commerce',
                'description' => 'Suppliers, purchase orders, goods receipt notes, and vendor balances',
                'is_core' => false,
                'dependencies' => ['inventory_warehouse'],
            ],
            'insurance_claims' => [
                'name' => 'Insurance and Claims',
                'category' => 'commerce',
                'description' => 'TPA insurance providers, policy verification, and claim tracking',
                'is_core' => false,
                'dependencies' => ['billing_invoicing'],
            ],
            'accounting_finance' => [
                'name' => 'Accounting and Finance',
                'category' => 'commerce',
                'description' => 'Chart of accounts, immutable double-entry journal entries, and balance sheets',
                'is_core' => false,
                'dependencies' => ['billing_invoicing'],
            ],

            // Operations Modules
            'human_resources' => [
                'name' => 'Human Resources (HR)',
                'category' => 'operations',
                'description' => 'Employee contracts, leaves, designations, and departmental rostering',
                'is_core' => false,
                'dependencies' => ['staff_management'],
            ],
            'attendance_management' => [
                'name' => 'Attendance Management',
                'category' => 'operations',
                'description' => 'Hardware terminal synchronization (Laravel Attendance Hub), punch logs, and shifts',
                'is_core' => false,
                'dependencies' => ['human_resources'],
            ],
            'payroll_management' => [
                'name' => 'Payroll Management',
                'category' => 'operations',
                'description' => 'Salary components, monthly payroll runs, salary slips, and journal integration',
                'is_core' => false,
                'dependencies' => ['human_resources'],
            ],
            'ambulance_transport' => [
                'name' => 'Ambulance and Transport',
                'category' => 'operations',
                'description' => 'Fleet registry, dispatch tracking, driver coordination, and trip fares',
                'is_core' => false,
                'dependencies' => ['branch_management'],
            ],
            'housekeeping_facilities' => [
                'name' => 'Housekeeping and Facilities',
                'category' => 'operations',
                'description' => 'Room sanitation tracking, maintenance work orders, and asset servicing',
                'is_core' => false,
                'dependencies' => ['bed_ward_management'],
            ],

            // Specialty Modules
            'telemedicine' => [
                'name' => 'Telemedicine',
                'category' => 'clinical',
                'description' => 'Virtual consultation rooms, secure video links, and remote E-Prescriptions',
                'is_core' => false,
                'dependencies' => ['appointment_management', 'prescription_management'],
            ],
            'dental_management' => [
                'name' => 'Dental Clinic Management',
                'category' => 'clinical',
                'description' => 'Universal tooth charts (1-32), periodontal observations, and dental procedures',
                'is_core' => false,
                'dependencies' => ['patient_management'],
            ],
            'physiotherapy' => [
                'name' => 'Physiotherapy and Rehab',
                'category' => 'clinical',
                'description' => 'Mobility assessments, therapy protocols, pain score tracking, and exercise plans',
                'is_core' => false,
                'dependencies' => ['patient_management'],
            ],
            'maternity_pediatrics' => [
                'name' => 'Maternity and Pediatrics',
                'category' => 'clinical',
                'description' => 'Prenatal records, delivery documentation, newborn linkages, and immunization charts',
                'is_core' => false,
                'dependencies' => ['inpatient_management'],
            ],

            // Engagement & SaaS Modules
            'crm_engagement' => [
                'name' => 'CRM and Patient Engagement',
                'category' => 'engagement',
                'description' => 'Patient feedback, service satisfaction inquiries, and outreach coordination',
                'is_core' => false,
                'dependencies' => ['patient_management'],
            ],
            'notification_center' => [
                'name' => 'Notification Center',
                'category' => 'engagement',
                'description' => 'Multi-channel notifications (SMS, Email, WhatsApp, Push) and dispatch audit',
                'is_core' => false,
                'dependencies' => ['branch_management'],
            ],
            'ai_operations_assistant' => [
                'name' => 'AI Operations Assistant',
                'category' => 'intelligence',
                'description' => 'Multi-provider clinical ops assistance (Laravel AI Hub) and performance metrics (Drutogoti)',
                'is_core' => false,
                'dependencies' => ['reporting_analytics'],
            ],
            'saas_billing' => [
                'name' => 'SaaS Subscription Engine',
                'category' => 'commerce',
                'description' => 'Commercial tenant plans, branch limits, quotas, and subscription lifecycle',
                'is_core' => false,
                'dependencies' => ['organization_management'],
            ],
            'multilingual_localization' => [
                'name' => 'Multilingual & Localization',
                'category' => 'core',
                'description' => 'Bengali, English, Arabic, Hindi, RTL layout, Universal Slugs, and Unicode PDF generator',
                'is_core' => true,
                'dependencies' => ['branch_management'],
            ],
        ];
    }

    /**
     * Check if a module is enabled for an organization and branch
     */
    public static function isEnabled(string $moduleKey, ?int $orgId = null, ?int $branchId = null): bool
    {
        $defs = self::allDefinitions();

        if (! isset($defs[$moduleKey])) {
            return false;
        }

        // Core modules are always active
        if ($defs[$moduleKey]['is_core'] ?? false) {
            return true;
        }

        if (! $orgId) {
            $user = auth()->user();
            $orgId = $user?->organization_id;
            $branchId = $branchId ?? $user?->branch_id;
        }

        if (! $orgId) {
            return true; // platform admin scope
        }

        return Cache::remember("module_{$orgId}_{$branchId}_{$moduleKey}", 300, function () use ($orgId, $branchId, $moduleKey) {
            // Check branch level override first if branch provided
            if ($branchId) {
                $branchActivation = ModuleActivation::where('organization_id', $orgId)
                    ->where('branch_id', $branchId)
                    ->where('module_key', $moduleKey)
                    ->first();

                if ($branchActivation !== null) {
                    return (bool) $branchActivation->is_enabled;
                }
            }

            // Check organization level
            $orgActivation = ModuleActivation::where('organization_id', $orgId)
                ->whereNull('branch_id')
                ->where('module_key', $moduleKey)
                ->first();

            if ($orgActivation !== null) {
                return (bool) $orgActivation->is_enabled;
            }

            // Default to enabled if not explicitly disabled
            return true;
        });
    }

    /**
     * Sync default module records in database
     */
    public static function syncDatabase(): void
    {
        $definitions = self::allDefinitions();
        $order = 1;

        foreach ($definitions as $key => $data) {
            Module::updateOrCreate(
                ['key' => $key],
                [
                    'name' => $data['name'],
                    'category' => $data['category'],
                    'description' => $data['description'],
                    'is_core' => $data['is_core'],
                    'dependencies' => $data['dependencies'],
                    'is_active_default' => true,
                    'display_order' => $order++,
                ]
            );
        }
    }

    /**
     * Activate a module for an organization
     */
    public static function setStatus(string $moduleKey, bool $enabled, int $orgId, ?int $branchId = null): bool
    {
        $defs = self::allDefinitions();

        if (! isset($defs[$moduleKey])) {
            return false;
        }

        // Core modules cannot be disabled
        if ($defs[$moduleKey]['is_core'] && ! $enabled) {
            return false;
        }

        ModuleActivation::updateOrCreate(
            [
                'organization_id' => $orgId,
                'branch_id' => $branchId,
                'module_key' => $moduleKey,
            ],
            [
                'is_enabled' => $enabled,
                'activated_at' => $enabled ? now() : null,
            ]
        );

        Cache::forget("module_{$orgId}_{$branchId}_{$moduleKey}");

        return true;
    }
}
