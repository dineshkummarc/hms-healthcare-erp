# REST API Documentation (v1)

## Authentication
Authentication is powered by Laravel Sanctum. Supply the Bearer token in the `Authorization` header:

```http
Authorization: Bearer <token>
```

## Endpoints

### 1. Health & Metadata
- `GET /api/v1/health`: System status, application version, timestamp.
- `GET /api/v1/modules`: Directory of all 38 available modules and categories.

### 2. Authentication
- `POST /api/v1/auth/login`: Authenticate with `email` and `password`. Returns bearer token.
- `GET /api/v1/auth/user`: Returns current user object with organization and branch details.
- `POST /api/v1/auth/logout`: Revokes the current access token.

### 3. Patient Mobile Endpoints
- `GET /api/v1/patients/profile`: Current patient demographic and medical profile.
- `GET /api/v1/patients/prescriptions`: Paginated prescription history with medication details.
- `GET /api/v1/patients/lab-orders`: Lab test orders, technician notes, and result values.
- `GET /api/v1/patients/invoices`: Patient invoices, line items, and payment status.

### 4. Appointment & Doctor Endpoints
- `GET /api/v1/doctors?branch_id={id}`: List available doctors.
- `GET /api/v1/appointments`: List appointments for current authenticated role.
- `POST /api/v1/appointments`: Book appointment (`doctor_id`, `branch_id`, `appointment_date`, `start_time`).
- `POST /api/v1/appointments/{id}/cancel`: Cancel scheduled appointment.

### 5. Clinical / Doctor App
- `GET /api/v1/doctor/queue`: Outpatient consultation queue for today.
- `POST /api/v1/doctor/encounters`: Document encounter vitals, chief complaints, and diagnosis.

### 6. Pharmacy & Inventory
- `GET /api/v1/pharmacy/medicines`: Paginated medicine catalog and batch stock.
- `GET /api/v1/pharmacy/stock-alerts`: List medications below reorder threshold.

---
*Author: [Imran Ahmed](https://imrandev.bd) (me@imrandev.bd)*
