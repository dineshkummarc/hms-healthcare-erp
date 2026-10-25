# Testing & Quality Assurance Suite

## Automated Test Execution

Execute the full feature and workflow test suite:

```bash
php artisan test
```

## Verified Test Matrix
1. `test_public_website_pages_render_successfully`: Asserts HTTP 200 and required content across Homepage, Features, Modules, and Demo pages.
2. `test_hospital_microsite_renders`: Validates organization branded microsite at `/h/{slug}`.
3. `test_public_online_booking_and_concurrency_collision_prevention`: Verifies public patient self-scheduling and confirms simultaneous duplicate booking attempts on the same doctor/slot fail with collision error.
4. `test_module_registry_activation_and_dependency_enforcement`: Tests dynamic module enabling, disabling, and protects core modules from being disabled.
5. `test_outpatient_clinical_encounter_and_prescription_workflow`: Validates full encounter triage, vital signs, diagnosis documentation, and clinician digital sign-off.
6. `test_inpatient_admission_and_bed_collision_protection`: Tests ward bed allocation and verifies occupied bed collision protection.
7. `test_pharmacy_inventory_stock_tracking`: Verifies atomic decrement of stock quantities during medicine sales.
8. `test_billing_and_payment_reconciliation`: Tests itemized invoice calculation, partial payments, and status transitions from `unpaid` -> `partially_paid` -> `paid`.
9. `test_journal_entry_double_entry_balance`: Validates that debit and credit amounts in accounting entries match.
10. `test_unicode_pdf_generation`: Verifies invoice and prescription PDF output via `imrandevbd/laravel-unicode-pdf`.
11. `test_ai_clinical_assistant_safety_and_fallback`: Verifies SOAP summarization and tests safe fallback behavior.
12. `test_api_sanctum_auth_and_endpoints`: Verifies API token issuance, health check, and authenticated profile endpoints.
13. `test_attendance_hub_synchronization`: Tests biometric attendance log sync via `imrandevbd/laravel-attendance-hub`.

---
*Author: [Imran Ahmed](https://imrandev.bd) (me@imrandev.bd)*
