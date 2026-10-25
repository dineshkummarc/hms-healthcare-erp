# System Architecture & Technical Design

## Overview
GrandHealth ERP is organized as a modular monolith in Laravel 12 and Filament 5. It incorporates domain-driven principles while maintaining straightforward maintainability and high operational velocity.

```mermaid
flowchart TD
    Client[Browser / Mobile Client] --> Gateway[HTTP Middleware Stack]
    Gateway --> Guard[Tenant & Module Guard]
    Guard --> Panels[Filament 5 Admin / Doctor / Patient Panels]
    Guard --> API[REST API v1 / Sanctum]
    
    subgraph DomainServices [Application & Domain Services]
        MR[ModuleRegistry]
        PDF[PdfGenerationService - Laravel Unicode PDF]
        AI[AiClinicalAssistantService - Laravel AI Hub]
        ATT[AttendanceDeviceSyncService - Laravel Attendance Hub]
        ACC[Double-Entry Ledger Engine]
    end

    Panels --> DomainServices
    API --> DomainServices

    DomainServices --> Repos[Eloquent Domain Models]
    Repos --> DB[(Relational Database: SQLite / MySQL 8 / PostgreSQL)]
```

## Key Architectural Decisions
1. **Shared Database Tenancy**: Strict tenant and branch scoping prevents data leakage between organizations while allowing consolidated platform administration.
2. **Dynamic Module Control**: Modules declare dependencies in `ModuleRegistry`. Activation is checked at runtime with cached results (`300s TTL`).
3. **Concurrency-Safe Operations**: Double-booking of appointment slots and simultaneous assignment of hospital beds use atomic database checks.
4. **Offline-Safe AI & Hardware Services**: Third-party integrations (such as AI providers or hardware terminals) degrade safely without disrupting clinical operations.

---
*Author: [Imran Ahmed](https://imrandev.bd) (me@imrandev.bd)*
