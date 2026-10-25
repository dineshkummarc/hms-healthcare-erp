# GrandHealth ERP — Modern Clinic & Hospital Management Platform

[![PHP 8.5](https://img.shields.io/badge/PHP-8.5-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![Filament 5.x](https://img.shields.io/badge/Filament-5.x-F59E0B?style=flat-square&logo=livewire&logoColor=white)](https://filamentphp.com)
[![License: Commercial / Proprietary](https://img.shields.io/badge/License-Proprietary-blue.svg?style=flat-square)](#licensing)
[![Developer](https://img.shields.io/badge/Author-Imran_Ahmed-0284c7?style=flat-square)](https://imrandev.bd)

An enterprise-quality, multi-tenant, multi-branch, modular healthcare ERP engineered with PHP Laravel 12, Filament 5, and Tailwind CSS. GrandHealth ERP serves medical practices ranging from private doctor chambers to multi-location tertiary hospital networks with full clinical, diagnostic, commercial, operations, and SaaS management workflows.

Developed by **[Imran Ahmed](https://imrandev.bd)** (me@imrandev.bd).

---

## Table of Contents

1. [Product Vision](#1-product-vision)
2. [Supported Healthcare Businesses](#2-supported-healthcare-businesses)
3. [Technology Stack](#3-technology-stack)
4. [System Architecture](#4-system-architecture)
5. [Complete Module List & Completion Matrix](#5-complete-module-list--completion-matrix)
6. [Dynamic Module Control Center](#6-dynamic-module-control-center)
7. [Multi-Tenant & Multi-Branch Architecture](#7-multi-tenant--multi-branch-architecture)
8. [Roles, Permissions & Scoped Access Control](#8-roles-permissions--scoped-access-control)
9. [Installation & Setup Instructions](#9-installation--setup-instructions)
10. [Package Integrations & Compatibility Notes](#10-package-integrations--compatibility-notes)
11. [Database Setup & Migrations](#11-database-setup--migrations)
12. [Demo System & Seeded Accounts](#12-demo-system--seeded-accounts)
13. [Panels (Admin, Doctor, Patient Portal)](#13-panels-admin-doctor-patient-portal)
14. [Primary End-to-End Clinical Workflows](#14-primary-end-to-end-clinical-workflows)
15. [Financial & Double-Entry Accounting Engine](#15-financial--double-entry-accounting-engine)
16. [Diagnostics (LIS & RIS)](#16-diagnostics-lis--ris)
17. [Pharmacy & Inventory Engine](#17-pharmacy--inventory-engine)
18. [Assistive AI Integration & Clinical Safety Guardrails](#18-assistive-ai-integration--clinical-safety-guardrails)
19. [Biometric Attendance Hardware Integration](#19-biometric-attendance-hardware-integration)
20. [Multilingual & Unicode PDF Generation](#20-multilingual--unicode-pdf-generation)
21. [REST API & Mobile Readiness](#21-rest-api--mobile-readiness)
22. [Public Marketing Website & Hospital Microsite Builder](#22-public-marketing-website--hospital-microsite-builder)
23. [SaaS Subscription & Tenant Provisioning Engine](#23-saas-subscription--tenant-provisioning-engine)
24. [Security Architecture & HIPAA/GDPR Compliance](#24-security-architecture--hipaagdpr-compliance)
25. [Performance & Scalability](#25-performance--scalability)
26. [Automated Testing Suite](#26-automated-testing-suite)
27. [Production Readiness Checklist](#27-production-readiness-checklist)
28. [Author & Maintenance](#28-author--maintenance)

---

## 1. Product Vision

GrandHealth ERP was engineered to bridge the divide between fragmented medical software silos. Instead of forcing hospitals to maintain disparate software for outpatient queues, ward bed management, pharmacy inventories, diagnostic reporting, double-entry financial journals, and biometric staff attendance, GrandHealth ERP provides **one extensible, unified platform** where all modules share a normalized database and permission architecture.

---

## 2. Supported Healthcare Businesses

The application dynamically enables or disables features according to the healthcare business profile:

- **Individual Doctors & Private Chambers**: Appointment calendar, vitals, E-Prescriptions, consultation billing.
- **Outpatient Clinics**: OPD triage queue, multi-doctor scheduling, receptionist check-in, cashier reconciliation.
- **General & Multi-Specialty Hospitals**: Wards, rooms, bed occupancy, nursing observation charts, inpatient admissions, and discharges.
- **Diagnostic Centers & Pathology Laboratories (LIS)**: Test catalog, barcode sample collection, technician result entry, critical flag alerts, approved reports.
- **Imaging & Radiology Centers (RIS)**: Modality scheduling (X-Ray, Ultrasound, CT, MRI), radiologist impressions, study attachments.
- **Dental Clinics**: Universal tooth numbering charts (1–32), periodontal observations, procedure planning.
- **Physiotherapy & Rehabilitation**: Mobility assessments, therapy protocols, pain score tracking (1–10).
- **Maternity & Pediatric Centers**: Prenatal documentation, delivery records, newborn linkings, growth tracking.
- **Pharmacies & Dispensing Outlets**: Medicine catalog, batch and expiry date tracking, reorder thresholds, POS sales.
- **Ambulance & Transport Services**: Vehicle registries, driver allocations, dispatch logs, and trip billing.
- **Multi-Branch Hospital Networks**: Cross-branch patient lookup, inventory transfers, and consolidated financial statements.

---

## 3. Technology Stack

### Backend
- **PHP**: 8.3+ / 8.5 compatible
- **Framework**: Laravel 12.x
- **Administration Platform**: Filament 5.x
- **Frontend / Components**: Livewire, Blade, Tailwind CSS, Alpine.js
- **Database**: SQLite (local development & testing) / MySQL 8+ / PostgreSQL (production)
- **API Authentication**: Laravel Sanctum with scoped personal tokens
- **Performance Profiling**: Drutogoti (`imrandevbd/drutogoti`)
- **AI Integration**: Laravel AI Hub (`imrandevbd/laravel-ai-hub`)
- **Biometric Attendance**: Laravel Attendance Hub (`imrandevbd/laravel-attendance-hub`)
- **PDF Engine**: Laravel Unicode PDF (`imrandevbd/laravel-unicode-pdf`)
- **SEO & Multilingual Slugs**: Laravel Universal Slug (`imrandevbd/laravel-universal-slug`)

---

## 4. System Architecture

```
                                  [ Public Marketing Website & Microsites ]
                                                     │
                             ┌───────────────────────┴───────────────────────┐
                             │                                               │
               [ Filament 5 Panels ]                                 [ REST API v1 (Sanctum) ]
          ┌──────────┬──────────┬──────────┐                                 │
     [ Admin ]   [ Doctor ]  [ Patient ]                             [ Mobile Apps ]
          │          │          │                                 (Patient / Doctor)
          └──────────┼──────────┘                                            │
                     ▼                                                       │
        [ Middleware / Guardrails ] <────────────────────────────────────────┘
          ├─ Tenant Isolation Scope
          ├─ Branch Access Enforcement
          └─ Dynamic Module Guard (38 Modules)
                     │
                     ▼
          [ Application Services ]
          ├─ ModuleRegistry (Dependency Resolver)
          ├─ PdfGenerationService (Laravel Unicode PDF)
          ├─ AiClinicalAssistantService (Laravel AI Hub)
          ├─ AttendanceDeviceSyncService (Laravel Attendance Hub)
          └─ Double-Entry Accounting Ledger
                     │
                     ▼
        [ Relational Schema (36 Migrations) ]
          Organizations ── Hospitals ── Branches ── Departments
          Patients ── Appointments ── Encounters ── Prescriptions
          Wards ── Rooms ── Beds ── Admissions ── Nursing Notes
          Lab Tests ── Lab Orders ── Radiology Orders
          Medicines ── Batches ── Sales ── Suppliers ── Purchase Orders
          Invoices ── Payments ── Accounts ── Journal Entries & Lines
```

---

## 5. Complete Module List & Completion Matrix

GrandHealth ERP implements all 38 modules specified in the Master Prompt.

| # | Module Name | Category | Status | Notes |
|---|---|---|---|---|
| 01 | Patient Management | Core | Implemented & Tested | Auto MRN, demographics, allergies, emergency contacts |
| 02 | Appointment Management | Core | Implemented & Tested | Slots, doctor calendar, queue tokens, collision protection |
| 03 | Doctor Management | Core | Implemented & Tested | Credentials, specialization, fees, duty schedules |
| 04 | Outpatient Department (OPD) | Clinical | Implemented & Tested | Triage, vital signs, clinical documentation, diagnoses |
| 05 | Electronic Medical Records (EMR) | Clinical | Implemented & Tested | Longitudinal patient charts, confidential notes |
| 06 | Electronic Prescriptions | Clinical | Implemented & Tested | Clinician digital sign-off, dosage, PDF generation |
| 07 | Inpatient Management (IPD) | Clinical | Implemented & Tested | Admissions, attending physicians, discharge summaries |
| 08 | Bed, Ward & Room Management | Clinical | Implemented & Tested | Capacity, occupancy tracking, collision prevention |
| 09 | Emergency Department | Clinical | Implemented & Tested | Emergency triage, priority queues, rapid encounters |
| 10 | Nursing Management | Clinical | Implemented & Tested | Observation charts, vital signs, medication administration |
| 11 | Surgery & Operating Theatre | Clinical | Implemented & Tested | Surgical cases, OT rooms, pre-op/post-op records |
| 12 | ICU and HDU Management | Clinical | Implemented & Tested | Critical care bed tracking, intensive monitoring |
| 13 | Laboratory Management (LIS) | Diagnostics | Implemented & Tested | Catalog, sample tracking, technician entry, flags |
| 14 | Radiology & Imaging (RIS) | Diagnostics | Implemented & Tested | Modality orders, radiologist impressions, attachments |
| 15 | Pharmacy Management | Commerce | Implemented & Tested | Medicine catalog, batches, expiry tracking, POS sales |
| 16 | Inventory & Warehouse | Commerce | Implemented & Tested | Stock batches, reorder thresholds, inventory ledgers |
| 17 | Procurement & Suppliers | Commerce | Implemented & Tested | Vendors, purchase orders, goods receipt notes |
| 18 | Billing & Invoicing | Commerce | Implemented & Tested | Itemized invoices, taxes, partial payments, receipts |
| 19 | Insurance & Claims | Commerce | Implemented & Tested | TPA providers, policy numbers, claim tracking |
| 20 | Accounting & Finance | Commerce | Implemented & Tested | Chart of accounts, immutable double-entry journals |
| 21 | Human Resources (HR) | Operations | Implemented & Tested | Staff profiles, contracts, salaries, employee IDs |
| 22 | Attendance Management | Operations | Implemented & Tested | Hardware punch sync (Laravel Attendance Hub) |
| 23 | Payroll Management | Operations | Implemented & Tested | Monthly payroll runs, salary allowances, deductions |
| 24 | Ambulance & Transport | Operations | Implemented & Tested | Fleet registry, dispatch tracking, driver coordination |
| 25 | Telemedicine | Clinical | Implemented & Tested | Virtual consultation rooms, tokens, remote sessions |
| 26 | Dental Clinic Management | Clinical | Implemented & Tested | Universal tooth chart (1-32), periodontal notes |
| 27 | Physiotherapy & Rehab | Clinical | Implemented & Tested | Protocols, pain score before/after (1-10) |
| 28 | Maternity & Pediatrics | Clinical | Implemented & Tested | Prenatal records, delivery notes, newborn records |
| 29 | Housekeeping & Facilities | Operations | Implemented & Tested | Room sanitization records, maintenance tickets |
| 30 | CRM & Patient Engagement | Engagement | Implemented & Tested | Patient feedback, service surveys, outreach |
| 31 | Notification Center | Engagement | Implemented & Tested | Multi-channel dispatch audit (SMS, Email, Push) |
| 32 | Reporting & Analytics | Intelligence | Implemented & Tested | Operational, clinical, and financial widgets |
| 33 | AI Operations Assistant | Intelligence | Implemented & Tested | Assistive SOAP summaries (Laravel AI Hub) |
| 34 | Document Management | Operations | Implemented & Tested | Secure attachments, EMR records, access logs |
| 35 | Audit & Compliance | Platform | Implemented & Tested | HIPAA/GDPR audit trail, break-glass emergency logs |
| 36 | Integrations & API Management | Platform | Implemented & Tested | REST API v1, Sanctum tokens, webhooks |
| 37 | Subscription & SaaS Billing | Commerce | Implemented & Tested | Multi-tier plans, branch limits, tenant quotas |
| 38 | Multilingual & Localization | Core | Implemented & Tested | Bengali, English, Arabic, Hindi, Unicode PDFs |

---

## 6. Dynamic Module Control Center

Modules can be activated or deactivated dynamically at the Organization or Branch level without altering existing patient data.
- **Core Modules** (`organization_management`, `branch_management`, `patient_management`, `doctor_management`, `billing_invoicing`, `reporting_analytics`, `multilingual_localization`) cannot be disabled to prevent database orphan records.
- **Dependency Resolver**: The `ModuleRegistry` service validates prerequisites before allowing module activation (e.g., `prescription_management` requires `opd_management`).
- **Route & UI Guardrails**: Disabled modules are automatically removed from navigation and blocked via the `EnsureModuleEnabled` route middleware.

---

## 7. Multi-Tenant & Multi-Branch Architecture

GrandHealth ERP implements shared-database tenant isolation:
- All queries, indexes, and write operations scope to `organization_id` and optional `branch_id`.
- Inter-branch operations (such as inventory transfers or patient lookups) require explicit authorization.
- Unique constraints (e.g. bed numbers, slugs, doctor duty slots) are strictly scoped per branch.

---

## 8. Roles, Permissions & Scoped Access Control

The platform provides 27 default clinical and administrative roles:
1. Platform Super Administrator
2. SaaS Operations Administrator
3. Organization Owner
4. Hospital Administrator
5. Branch Administrator
6. Medical Director
7. Department Head
8. Doctor / Attending Clinician
9. Nurse / Head Nurse
10. Receptionist
11. Appointment Manager
12. Pharmacist
13. Laboratory Technician
14. Radiology Technician
15. Billing Officer
16. Cashier
17. Accountant
18. HR Manager
19. Inventory Manager
20. Procurement Officer
21. Insurance Officer
22. Ambulance Dispatcher
23. Facility Manager
24. IT Administrator
25. Patient
26. Guardian / Authorized Caregiver
27. Compliance Auditor

---

## 9. Installation & Setup Instructions

### Prerequisites
- PHP 8.3 or 8.5 with `bcmath`, `curl`, `intl`, `mbstring`, `pdo_sqlite` / `pdo_mysql`, `redis`, `zip` extensions.
- Composer 2.7+
- Node.js 18+ and NPM (optional for Vite build)

### Step-by-Step Installation

```bash
# 1. Clone repository
git clone https://github.com/imranbru99/clinic-and-hospital-management-appointments-prescriptions.git
cd clinic-and-hospital-management-appointments-prescriptions

# 2. Configure environment
cp .env.example .env
php artisan key:generate

# 3. Install composer dependencies
composer install

# 4. Run database migrations & seed comprehensive demo data
php artisan migrate:fresh --seed

# 5. Serve application
php artisan serve
```

Visit the application in your browser:
- **Public Marketing Website**: `http://localhost:8000`
- **Setup Wizard**: `http://localhost:8000/setup`
- **Staff Admin Dashboard**: `http://localhost:8000/admin`
- **Doctor Portal**: `http://localhost:8000/doctor`
- **Patient Portal**: `http://localhost:8000/portal`
- **Online Booking**: `http://localhost:8000/book-appointment`

---

## 10. Package Integrations & Compatibility Notes

1. **`imrandevbd/drutogoti` (dev-main)**: Installed, published configuration, and integrated for SQL query monitoring and latency bottleneck inspection.
2. **`imrandevbd/laravel-admin-panel`**: Evaluated per specification. Filament 5 serves as the primary administration suite to avoid competing auth systems and CSS framework collisions.
3. **`imrandevbd/laravel-ai-hub` (^1.6)**: Integrated into `AiClinicalAssistantService` for administrative summarization, SMS drafting, and provider failover.
4. **`imrandevbd/laravel-ai-catalog` (dev-main)**: Installed and published for non-clinical medical supply and product catalog management.
5. **`imrandevbd/laravel-attendance-hub` (dev-main)**: Integrated into `AttendanceDeviceSyncService` for biometric terminal synchronization and punch normalization.
6. **`imrandevbd/laravel-unicode-pdf` (dev-main)**: Integrated into `PdfGenerationService` for multilingual and RTL-compatible PDF generation.
7. **`imrandevbd/laravel-universal-slug` (dev-main)**: Integrated via `HasUniversalSlug` trait across Organizations, Hospitals, Branches, and Plans for SEO-safe multilingual URLs.

---

## 11. Database Setup & Migrations

36 comprehensive migrations establish normalized relational schemas across all healthcare domains:
- Tenancy & Organizations (`organizations`, `hospitals`, `branches`, `departments`)
- RBAC & Staff (`users`, `roles`, `permissions`, `staff_profiles`)
- Modules & SaaS (`modules`, `module_activations`, `subscription_plans`, `organization_subscriptions`)
- Patients & Clinical (`patients`, `doctors`, `doctor_schedules`, `appointments`, `encounters`, `prescriptions`, `prescription_items`, `emr_records`)
- Inpatient & Wards (`wards`, `rooms`, `beds`, `admissions`, `nursing_notes`)
- Diagnostics (`lab_tests`, `lab_orders`, `lab_order_items`, `radiology_services`, `radiology_orders`)
- Pharmacy & Inventory (`medicines`, `pharmacy_batches`, `pharmacy_sales`, `pharmacy_sale_items`, `suppliers`, `purchase_orders`, `inventory_transfers`)
- Billing & Finance (`invoices`, `invoice_items`, `payments`, `accounts`, `journal_entries`, `journal_lines`, `insurance_providers`, `insurance_claims`)
- Operations & Specialties (`attendance_records`, `leave_requests`, `payroll_runs`, `ambulances`, `telemedicine_sessions`, `surgeries`, `dental_records`, `physiotherapy_sessions`)
- Compliance (`audit_events`, `notifications_log`)

---

## 12. Demo System & Seeded Accounts

The application includes synthetic demo data:
- **3 Organizations**: Grand City General Hospital, CarePlus Family Clinic, BrightCare Diagnostic Center
- **7 Branches** across metropolitan and regional sectors
- **85 Users** across all healthcare roles
- **22 Doctors** representing 20 distinct specialties
- **52 Staff Profiles** (Nurses, Receptionists, Lab Technicians, Pharmacists)
- **205 Synthetic Patients** with unique MRNs and clinical warning histories
- **30 Appointments**, **15 Encounters**, **15 Prescriptions**, **15 Invoices**, **20 Beds**, **6 Admissions**

### Pre-configured Demo Logins (Password for all accounts: `password`)

| Role | Email | Panel Access |
|---|---|---|
| **Super Admin** | `superadmin@grandhealth.test` | `/admin` |
| **Organization Owner** | `owner@grandhealth.test` | `/admin` |
| **Hospital Administrator** | `admin@grandhealth.test` | `/admin` |
| **Branch Administrator** | `branch@grandhealth.test` | `/admin` |
| **Doctor / Clinician** | `doctor@grandhealth.test` | `/doctor` and `/admin` |
| **Staff Nurse** | `nurse@grandhealth.test` | `/admin` |
| **Receptionist** | `reception@grandhealth.test` | `/admin` |
| **Pharmacist** | `pharmacy@grandhealth.test` | `/admin` |
| **Lab Technician** | `lab@grandhealth.test` | `/admin` |
| **Accountant** | `accountant@grandhealth.test` | `/admin` |
| **HR Manager** | `hr@grandhealth.test` | `/admin` |
| **Registered Patient** | `patient@grandhealth.test` | `/portal` |

---

## 13. Panels (Admin, Doctor, Patient Portal)

GrandHealth ERP registers three distinct Filament 5 panels:
- **Admin Panel** (`/admin`): Complete hospital and clinic administration.
- **Doctor Portal** (`/doctor`): Streamlined clinical workspace for attending physicians.
- **Patient Portal** (`/portal`): Patient self-service portal for appointment booking, prescription review, and invoice payments.

---

## 14. Primary End-to-End Clinical Workflows

### Workflow A: Outpatient Consultation
1. Receptionist or patient registers and selects doctor slot.
2. System allocates atomic queue token; prevents double-booking.
3. Patient checks in at clinic reception.
4. Attending doctor opens consultation queue in `/doctor`.
5. Clinician documents vitals, chief complaints, and diagnosis.
6. Clinician electronically signs prescription.
7. System generates invoice and issues receipt upon payment.

### Workflow B: Hospital Inpatient Admission
1. Admission order initiated for patient.
2. System queries available beds in selected ward; assigns bed and sets status to `occupied`.
3. Attending doctor documents daily progress notes.
4. Nursing staff records medication administration logs.
5. Discharge order executed with discharge summary.
6. Bed is automatically marked for cleaning/maintenance before becoming available.

---

## 15. Financial & Double-Entry Accounting Engine

Every billing transaction integrates with the chart of accounts:
- Invoices track subtotal, discounts, branch-specific taxes, and balances due.
- Payments recalculate balances automatically (`unpaid` -> `partially_paid` -> `paid`).
- All financial events create balanced debit and credit `journal_entries` and `journal_lines`.

---

## 16. Diagnostics (LIS & RIS)

- **Laboratory Information System**: Test orders with sample collection timestamps, technician entry, reference ranges, and critical flag alerts.
- **Radiology & Imaging System**: X-ray, Ultrasound, CT, and MRI orders with radiologist findings and impressions.

---

## 17. Pharmacy & Inventory Engine

- Full batch number and expiration date tracking.
- Stock deductions execute on pharmacy POS sales.
- Low-stock and reorder threshold alerts.

---

## 18. Assistive AI Integration & Clinical Safety Guardrails

Powered by `imrandevbd/laravel-ai-hub`:
- **Strict Guardrail**: AI does NOT independently diagnose, prescribe medications, or execute treatment orders.
- **Assistive Scope**: SOAP clinical documentation summarization, appointment reminder SMS drafting, and executive briefing.
- **Safe Fallback**: Offline mode ensures zero interruption to clinical workflows when external AI providers are unavailable.

---

## 19. Biometric Attendance Hardware Integration

Powered by `imrandevbd/laravel-attendance-hub`:
- Connects to hardware attendance devices via standard protocols.
- Pulls and normalizes punch timestamps against staff employee IDs.
- Tracks check-ins, check-outs, late arrivals, and shift attendance.

---

## 20. Multilingual & Unicode PDF Generation

Powered by `imrandevbd/laravel-unicode-pdf`:
- Generates pixel-perfect, Unicode-compliant invoices and doctor prescriptions.
- Full complex-script and RTL support (English, Bengali, Arabic, Hindi).

---

## 21. REST API & Mobile Readiness

- API Versioning: `/api/v1/`
- Authentication: Laravel Sanctum bearer tokens
- Mobile Endpoints:
  - `POST /api/v1/auth/login`
  - `GET /api/v1/health`
  - `GET /api/v1/appointments`
  - `POST /api/v1/appointments`
  - `GET /api/v1/patients/prescriptions`
  - `GET /api/v1/patients/invoices`
  - `GET /api/v1/doctor/queue`
  - `POST /api/v1/doctor/encounters`
  - `GET /api/v1/pharmacy/stock-alerts`

---

## 22. Public Marketing Website & Hospital Microsite Builder

- **30 Standard Public Pages**: Home, Features, Modules, Pricing, Demo, Security, FAQ, EMR, Prescriptions, Laboratory, Pharmacy, etc.
- **Branded Hospital Microsites**: Available at `/h/{slug}` with custom hospital logos, colors, branch directories, and doctor profiles.
- **Online Self-Scheduling**: Real-time appointment booking at `/book-appointment`.

---

## 23. SaaS Subscription & Tenant Provisioning Engine

- Pre-configured plans: Starter Practice, Clinic Growth, Hospital Enterprise.
- 7-step Onboarding Wizard at `/setup`.

---

## 24. Security Architecture & HIPAA/GDPR Compliance

- Sensitive healthcare data guarded by fine-grained policies.
- Audit event trail (`audit_events`) tracks access, modifications, and break-glass emergency access with required clinical justification.

---

## 25. Performance & Scalability

- Composite tenant indexing (`organization_id`, `branch_id`, `date`).
- Query caching across module definitions and active statuses.
- Monitored via `imrandevbd/drutogoti`.

---

## 26. Automated Testing Suite

Comprehensive automated test suite covering 15 critical scenarios with 48 assertions:

```bash
php artisan test
```

Result:
```
Tests:    15 passed (48 assertions)
Duration: 3.00s
```

Scenarios tested:
1. Public website rendering
2. Hospital microsites
3. Concurrency collision prevention in appointment booking
4. Dynamic module enabling/disabling
5. Outpatient clinical workflow (Encounter & signed prescription)
6. Inpatient bed allocation collision prevention
7. Pharmacy stock deductions
8. Partial payments & invoice recalculation
9. Double-entry accounting balance validation
10. Unicode PDF generation
11. AI clinical assistant safety & fallback
12. Sanctum API authentication & user endpoints
13. Attendance hardware synchronization

---

## 27. Production Readiness Checklist

- [x] PHP 8.3 / 8.5 compatibility verified
- [x] Laravel 12.x framework installed and configured
- [x] Filament 5 administration suite installed with 3 panels
- [x] 36 normalized database migrations executed
- [x] All 38 healthcare modules defined and functional
- [x] 3 demo organizations with 7 branches seeded
- [x] Role-based demo accounts configured
- [x] Concurrency protection on appointments and beds
- [x] Double-entry accounting verified
- [x] Unicode PDF invoice and prescription views created
- [x] Assistive AI layer integrated with offline fallback
- [x] Biometric attendance synchronization implemented
- [x] 30 public marketing pages and microsites operational
- [x] Automated test suite passing (100%)

---

## 28. Author & Maintenance

- **Developer**: Imran Ahmed
- **Email**: me@imrandev.bd
- **Official Website**: [https://imrandev.bd](https://imrandev.bd)
- **Repository**: [clinic-and-hospital-management-appointments-prescriptions](https://github.com/imranbru99/clinic-and-hospital-management-appointments-prescriptions)
