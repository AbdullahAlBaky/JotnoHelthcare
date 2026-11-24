# JotnoHealthcare — Academic MVP Foundation

JotnoHealthcare is a university capstone prototype for doctor-supervised virtual home-care workflows.

## Technology stack
- Vue.js 3, JavaScript, HTML templates, Tailwind CSS, Chart.js
- Laravel 12 REST API, PHP 8.2+
- SQLite database
- Flask + Python + scikit-learn for the existing general symptom model
- Sanctum bearer-token authentication

## MVP modules
1. Five-role accounts and API authentication
2. Patient profile and virtual admission request/review
3. Caregiver access request and approval
4. Patient observations, history, chart and review reminders
5. Dataset-based symptom prediction with clinician review status
6. Reports, care plans, specialist referrals, consultations and in-app notifications
7. Role-aware dashboard screens and synthetic demo records

## Known boundaries
The model is a dataset exercise and has not been clinically validated. Trend flags are simple configurable heuristics, not a risk score. Patient summaries are structured records, not generative AI. Bilingual clinical explanation generation is not included. Video calls require an external provider; the MVP stores schedule and meeting URL only. Email/SMS/push delivery is not configured.

Never use real patient data or rely on this prototype for diagnosis, treatment, triage or emergencies.
