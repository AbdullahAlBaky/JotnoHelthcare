# API quick reference

Base URL: `http://127.0.0.1:8000/api`. Authenticated routes require `Authorization: Bearer <token>`. JSON validation errors use HTTP 422; role/access failures use 403.

## Public
- `POST /register` — patient/caregiver registration (`name,email,password,password_confirmation,role`)
- `POST /login` — sign in

## Authenticated
- `GET /me`, `POST /logout`, `GET /dashboard`
- `GET /users?role=specialist` — staff selector for doctor/admin
- `GET /patients`, `POST /patients`, `GET /patients/{patient}`, `PUT /patients/{patient}`
- `POST /admissions`, `GET /admissions`, `PATCH /admissions/{admission}/review`
- `POST /caregiver-access`, `GET /caregiver-access/requests`, `PATCH /caregiver-access/{access}`, `GET /caregiver/patients`
- `POST /patients/{patient}/observations`, `GET /patients/{patient}/observations`
- `POST /predict`, `GET /assessments`, `PATCH /assessments/{assessment}/review`
- `GET|POST /patients/{patient}/care-plans`
- `GET /referrals`, `POST /patients/{patient}/referrals`, `PATCH /referrals/{referral}`
- `POST /patients/{patient}/reports` (multipart field `report`, optional `description`)
- `GET /notifications`, `PATCH /notifications/{notification}/read`
- `GET /consultations`, `POST /patients/{patient}/consultations`
- `GET /patients/{patient}/summary`

Role checks and ownership/approved-caregiver checks apply to patient resources. See controller validation rules for field limits. Do not expose this demo API publicly with real health records.
