# JotnoHealthcare — Healthcare, When You Need It.

Academic capstone prototype for doctor-supervised virtual care. Stack: Vue 3 + Tailwind + Laravel REST API + SQLite + Flask/scikit-learn.

## Start here
Read [INSTALLATION.md](INSTALLATION.md). On Windows, run `SETUP-ML-WINDOWS.ps1` from this project folder to configure the ML environment in the correct location.

## Included MVP modules
- Registration/login and five roles: patient, caregiver, duty doctor, specialist, admin
- Patient profiles and virtual admission request/approval workflow
- Caregiver access request and approval workflow
- Symptoms, report uploads, health observations, observation history and Chart.js graph
- Dataset-based preliminary symptom prediction and clinician review workflow
- Configured observation threshold/trend reminders (not a clinical risk score)
- Care plans/reminder timestamps, specialist referrals, consultations and in-app notifications
- Role-aware dashboard screens and synthetic demo records

See [requirement coverage](documentation/REQUIREMENT_COVERAGE.md) for implemented features and known limits.

## Clinical safety boundary
This is an academic prototype, not a medical device. Model output and rule-based flags are informational decision support only. They are not diagnoses, triage, or treatment advice. A qualified clinician must review all information. Do not use this prototype for real patient care or emergencies.

## Synthetic demo accounts and sample records

The database seeder creates fictional demo users and records for academic testing only. All seeded accounts use password `password`.

**Duty doctors**
- ayesha.doctor@jotno.test
- farhan.doctor@jotno.test
- nusrat.doctor@jotno.test
- mahmud.doctor@jotno.test
- doctor@jotno.test (original demo alias)

**Specialists**
- samiul.specialist@jotno.test
- tahmina.specialist@jotno.test
- rafiq.specialist@jotno.test
- specialist@jotno.test (original demo alias)

**Patients**
- patient@jotno.test
- nabila.patient@jotno.test
- arif.patient@jotno.test
- maliha.patient@jotno.test
- tanvir.patient@jotno.test
- sumaiya.patient@jotno.test
- rakib.patient@jotno.test
- farzana.patient@jotno.test

**Caregivers**
- caregiver@jotno.test
- mim.caregiver@jotno.test
- shakil.caregiver@jotno.test
- rumana.caregiver@jotno.test

The seeder also creates fictional profiles, seven days of synthetic observations per patient, admission requests, sample AI assessment records, care-plan placeholders, caregiver access links, selected referrals, consultation schedules and notifications. Observation values and prediction labels are invented test fixtures—not real patient data, clinical guidance, or validated medical findings. Do not use these accounts for real patient information.

To load or reset the local sample database, run `php artisan migrate:fresh --seed` from the `backend` directory. This command deletes existing local database data before recreating it.
