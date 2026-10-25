# Clinical Safety, Prescribing Guardrails & Ethics

## Mandatory Clinical Rules
1. **Clinician Authorization**: Only verified doctors possessing valid medical license credentials may author and sign electronic prescriptions.
2. **No Autonomous AI Prescribing**: Under no circumstances does the artificial intelligence subsystem suggest drug dosages, diagnose conditions, or prescribe medications. All AI output is assistive (formatting notes, drafting non-clinical SMS reminders) and labeled as such.
3. **Allergy Warnings**: Patient allergies (such as Penicillin, Sulfa drugs, NSAIDs) are highlighted on all clinical screens, patient headers, and generated prescriptions.
4. **Immutable Documentation**: Once a doctor signs a clinical encounter or prescription, the record is locked against silent edits. Any necessary clinical correction creates a dated amendment log with physician justification.
5. **Bed & Queue Concurrency Protection**: Atomic database transactions prevent double-booking of doctors or simultaneous allocation of patient beds.

---
*Author: [Imran Ahmed](https://imrandev.bd) (me@imrandev.bd)*
