# Database Schema & Relational Specifications

## Entity-Relationship Architecture

```mermaid
erDiagram
    ORGANIZATIONS ||--o{ HOSPITALS : contains
    ORGANIZATIONS ||--o{ BRANCHES : operates
    BRANCHES ||--o{ DEPARTMENTS : contains
    ORGANIZATIONS ||--o{ USERS : employs
    USERS ||--o| DOCTORS : credentials
    USERS ||--o| STAFF_PROFILES : records
    ORGANIZATIONS ||--o{ PATIENTS : manages
    PATIENTS ||--o{ APPOINTMENTS : books
    DOCTORS ||--o{ APPOINTMENTS : attends
    APPOINTMENTS ||--o| ENCOUNTERS : initiates
    ENCOUNTERS ||--o| PRESCRIPTIONS : authors
    PRESCRIPTIONS ||--o{ PRESCRIPTION_ITEMS : contains
    BRANCHES ||--o{ WARDS : accommodates
    WARDS ||--o{ ROOMS : divides
    ROOMS ||--o{ BEDS : houses
    BEDS ||--o| ADMISSIONS : occupies
    PATIENTS ||--o{ INVOICES : billed
    INVOICES ||--o{ INVOICE_ITEMS : details
    INVOICES ||--o{ PAYMENTS : settles
    JOURNAL_ENTRIES ||--o{ JOURNAL_LINES : debits_credits
    ACCOUNTS ||--o{ JOURNAL_LINES : references
```

## Schema Domains
- **Tenancy**: `organizations`, `hospitals`, `branches`, `departments`, `subscriptions`, `subscription_plans`.
- **Identity & RBAC**: `users`, `roles`, `permissions`, `staff_profiles`, `audit_events`.
- **Clinical**: `patients`, `doctors`, `doctor_schedules`, `appointments`, `encounters`, `prescriptions`, `prescription_items`, `emr_records`.
- **Inpatient & Facilities**: `wards`, `rooms`, `beds`, `admissions`, `nursing_notes`.
- **Diagnostics**: `lab_tests`, `lab_orders`, `lab_order_items`, `radiology_services`, `radiology_orders`.
- **Pharmacy & Inventory**: `medicines`, `pharmacy_batches`, `pharmacy_sales`, `suppliers`, `purchase_orders`, `inventory_transfers`.
- **Finance**: `invoices`, `invoice_items`, `payments`, `accounts`, `journal_entries`, `journal_lines`, `insurance_providers`, `insurance_claims`.

---
*Author: [Imran Ahmed](https://imrandev.bd) (me@imrandev.bd)*
