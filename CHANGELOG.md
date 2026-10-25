# Changelog

All notable changes to the GrandHealth ERP platform are documented in this file.

## [1.0.0] - 2026-10-25
### Initial Production Release
- **Architecture**: Established multi-tenant and multi-branch database schema with 36 migrations.
- **Filament 5**: Configured Admin Panel (`/admin`), Doctor Portal (`/doctor`), and Patient Portal (`/portal`).
- **Module Control Center**: Implemented `ModuleRegistry` supporting dynamic activation and dependency resolution for all 38 healthcare modules.
- **Clinical Suite**: EMR, Outpatient triage, E-Prescriptions with digital sign-off, Inpatient admissions, Wards, Beds, Nursing observation charts.
- **Diagnostics**: Laboratory Information System (LIS) and Radiology Information System (RIS).
- **Commerce**: Pharmacy batch and expiry tracking, suppliers, purchase orders, invoices, payments, and double-entry accounting.
- **Specialties**: Telemedicine, Dental tooth charts (1–32), Physiotherapy pain scales (1–10), Ambulances, and Surgeries.
- **Integrations**: Integrated Drutogoti, Laravel AI Hub, Laravel Attendance Hub, Laravel Unicode PDF, Laravel Universal Slug, and Laravel AI Catalog.
- **Public Marketing Website**: 30 responsive public marketing pages, hospital microsite generator, online self-scheduling, and 7-step onboarding wizard.
- **Demo Dataset**: Seeded 3 organizations, 7 branches, 85 users, 22 doctors, 52 staff members, 205 patients, and role-based accounts.
- **Automated Tests**: 15 feature and integration tests passing with 48 assertions.

---
*Lead Architect: [Imran Ahmed](https://imrandev.bd) (me@imrandev.bd)*
