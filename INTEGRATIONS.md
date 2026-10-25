# Ecosystem Integrations Reference

GrandHealth ERP integrates six specialized packages authored by Imran Ahmed:

1. **Drutogoti (`imrandevbd/drutogoti`)**:
   - Application speed optimization and N+1 query detection.
   - Monitors execution latency across high-throughput clinical endpoints.

2. **Laravel AI Hub (`imrandevbd/laravel-ai-hub`)**:
   - Multi-provider AI interface (Gemini, Claude, GPT, Ollama).
   - Generates structured SOAP documentation summaries from clinician observations.
   - Fallback offline mode prevents interruption when third-party AI APIs are unreachable.

3. **Laravel Attendance Hub (`imrandevbd/laravel-attendance-hub`)**:
   - Universal driver interface for biometric fingerprint, face ID, and RFID attendance terminals.
   - Auto-detects devices and maps raw terminal punch logs to employee IDs.

4. **Laravel Unicode PDF (`imrandevbd/laravel-unicode-pdf`)**:
   - High-fidelity PDF generation with UTF-8 Unicode font fallback.
   - Supports complex scripts and RTL layouts (English, Bengali, Arabic, Hindi).

5. **Laravel Universal Slug (`imrandevbd/laravel-universal-slug`)**:
   - Unicode-safe slug generator with historical redirection.
   - Supports non-Latin characters for doctor profiles and hospital department URLs.

6. **Laravel AI Catalog (`imrandevbd/laravel-ai-catalog`)**:
   - Intelligent catalog engine for medical supplies and consumable equipment.

---
*Author: [Imran Ahmed](https://imrandev.bd) (me@imrandev.bd)*
