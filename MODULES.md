# Complete Healthcare Module Reference (38 Modules)

GrandHealth ERP implements 38 discrete functional modules organized into 7 business categories.

## 1. Core Modules
- `organization_management`: Multi-tenant organization hierarchy and settings.
- `branch_management`: Branch facilities, tax rates, currencies, and schedules.
- `patient_management`: Master patient index, MRN numbering, demographics, allergies.
- `doctor_management`: Physician profiles, licenses, consultation fees, rosters.
- `staff_management`: Staff profiles, credentials, role-based access.
- `billing_invoicing`: Invoicing, itemization, payments, receipts.
- `reporting_analytics`: Statistical dashboards, collections, occupancy metrics.
- `multilingual_localization`: UTF-8 Unicode fonts, RTL layout, Universal Slugs.

## 2. Clinical Modules
- `opd_management`: Outpatient department consultation queue and vitals.
- `emr_management`: Longitudinal medical records, history, attachments.
- `prescription_management`: Digital clinician prescriptions and dosage instructions.
- `inpatient_management`: Admissions, attending doctors, discharges.
- `bed_ward_management`: Wards, rooms, bed occupancy tracking.
- `emergency_department`: Triage scoring and rapid encounter logs.
- `nursing_management`: Nurse observation charts, care plans, medication logs.
- `surgery_ot`: Operating room schedules, surgical cases, pre-op/post-op records.
- `icu_hdu`: Critical care bed observation and intensive monitoring.
- `telemedicine`: Virtual video appointments and remote prescriptions.
- `dental_management`: Universal tooth charts (1–32) and dental treatments.
- `physiotherapy`: Rehab protocols and pain scale tracking (1–10).
- `maternity_pediatrics`: Prenatal charts, delivery logs, newborn linkages.

## 3. Diagnostics Modules
- `laboratory_management`: LIS test catalog, sample barcodes, technician results.
- `radiology_imaging`: RIS modality scheduling, radiologist findings.

## 4. Commerce & Supply Chain
- `pharmacy_management`: Medicine inventory, batch tracking, POS sales.
- `inventory_warehouse`: Consumables, stock transfers, reorder alerts.
- `procurement_suppliers`: Supplier directory, purchase orders, goods receipts.
- `insurance_claims`: Insurance providers, claim submissions, approvals.
- `accounting_finance`: Chart of accounts and double-entry journals.
- `saas_billing`: Tenant plans, branch quotas, billing subscriptions.

## 5. Operations & Facilities
- `human_resources`: Employee onboarding, contracts, designations.
- `attendance_management`: Hardware biometric terminal sync.
- `payroll_management`: Monthly payroll periods, salary slips.
- `ambulance_transport`: Ambulance fleet registry, dispatch logs, fares.
- `housekeeping_facilities`: Room sanitation logs, maintenance tickets.
- `document_management`: Secure file attachments and downloads.

## 6. Engagement & Marketing
- `crm_engagement`: Patient inquiries, feedback, service reviews.
- `notification_center`: Multi-channel notifications (SMS, Email, Push).

## 7. Intelligence & Platform
- `ai_operations_assistant`: Assistive summaries, SMS drafts via Laravel AI Hub.
- `audit_compliance`: Immutable access logs and break-glass emergency auditing.
- `integrations_api`: REST API v1 with Sanctum tokens.

---
*Author: [Imran Ahmed](https://imrandev.bd) (me@imrandev.bd)*
