# Security Architecture, Privacy & Compliance

## Security Baseline
1. **Tenant Scoping**: All Eloquent queries are scoped to the active tenant/organization to prevent horizontal privilege escalation.
2. **Break-Glass Emergency Access**: In critical clinical emergencies, clinicians can access unassigned patient files by triggering a break-glass event that records mandatory justification, IP address, timestamp, and user ID into `audit_events`.
3. **Data Protection at Rest & In Transit**: Passwords hashed with `Argon2id` / `Bcrypt`. Sensitive authentication tokens encrypted.
4. **No Medical PHI in Logs**: AI telemetry, error trackers, and query logs strip sensitive diagnostic and prescription payloads.
5. **Role-Based Access Control**: Strict policies verify user roles before permitting clinical documentation or prescription signing.

---
*Author: [Imran Ahmed](https://imrandev.bd) (me@imrandev.bd)*
