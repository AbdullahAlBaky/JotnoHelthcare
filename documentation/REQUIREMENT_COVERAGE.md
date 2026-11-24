# Academic MVP requirement coverage

This table distinguishes working foundation features from limited/demo implementations. The project is not a production clinical system.

| Phase / requirement | MVP implementation | Boundary / remaining work |
|---|---|---|
| Patient registration and login | Laravel Sanctum token registration/login; patient and caregiver self-registration | Staff accounts are seeded/admin-provisioned; password reset and email verification are not configured |
| Five roles | Patient, caregiver, duty doctor, specialist, admin role values and middleware | Fine-grained policy/assignment management and audit trail need further hardening |
| Patient profile and medical history | SQLite patient profile fields and profile API | Profile completeness and edit UX can be extended |
| Virtual admission request and approval | Patient request, doctor/admin approve/reject/request-information, notification | No real-world admission/bed allocation |
| Role-aware dashboards | Role label, patient directory, admission queue, patient workspace | Dashboard KPI cards are shared; some specialist-specific views need refinement |
| Symptoms and report submission | Model symptom submission; PDF/JPG/PNG report upload API and Reports screen | Report download currently needs authenticated private-file streaming before production |
| Observation recording/history/charts | Observation API, history list, Chart.js trends | Basic chart only; units/scales should be separated for clinical-grade display |
| Doctor review and clinical notes | Assessment review status/note endpoint | No full medico-legal documentation/audit workflow |
| Care plans and reminders | Doctor/admin can create plans and reminder timestamps; patient can view | No scheduler, push/email delivery, or patient completion tracking |
| Specialist referral | Doctor/admin referral creation; specialist notes/status API | Specialist account assignment is selected from staff list; no automated routing |
| Notifications | In-app notification records, list and mark-read | No email/SMS/push provider |
| General disease prediction | Supplied RandomForest PKL via Flask service | Dataset model is not clinically validated; feature names must match model vocabulary |
| AI preliminary assessment and doctor review | Prediction saved as pending assessment; doctor/specialist/admin can review | It is not a diagnosis, triage, or treatment recommendation |
| Risk / observation trend alerts | Configured threshold and simple sequential trend reminders create doctor notifications | Heuristic flags only; not a validated risk model or continuous device monitoring |
| Patient summary | Structured summary API with history and recent observations/assessments | No LLM-generated summary or automated change-diff engine |
| Bangla / English AI explanations | Safety notices and basic UI copy | No generated bilingual clinical explanation engine; would require curated content or approved LLM integration and clinical review |
| Caregiver authorized access | Caregiver requests patient access; doctor/admin approves; approved links scope patient list and observation/profile access | Consent identity verification and full authorization audit remain future work |
| Video consultation scheduling/session records | Appointment record with optional external meeting URL | No embedded video SDK/provider or recording service; configure a provider separately |
| Responsive frontend | Vue 3 + Tailwind responsive layouts | Browser/device QA remains to be performed locally |
| API validation/error handling | Laravel request validation, role middleware, JSON error responses | Production rate limits, audit logs and security testing remain |
| Demo accounts/sample data | Seeder creates five demo roles, sample observations/admission/care plan/notification | All records are synthetic and for demonstration only |
| Testing/documentation | Setup guide, API docs, schema, coverage and test report | PHP syntax and ZIP integrity checked; full Laravel/Vue/Flask runtime test must be run on target Windows machine |

## Clinical safety

This project is an academic prototype. AI predictions and observation flags are informational workflow prompts only. They are not diagnoses, risk scores, triage, or treatment advice. A qualified clinician must independently review information. Do not enter real patient data or use the system for care or emergencies.
