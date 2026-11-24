# SQLite schema

`users` stores all five roles. `patients` is a one-to-one extension of patient user accounts. `observations`, `assessments`, `medical_reports`, `care_plans`, `referrals`, `consultations`, and `notifications` reference patient/user records with foreign keys. Personal access tokens are stored by Sanctum.

All schema is defined in `backend/database/migrations/2026_11_24_000001_create_jotnohealthcare_tables.php`.
