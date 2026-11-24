# JotnoHealthcare synthetic demo datasets

These CSV files are **fictional, synthetic academic demo data**. They do not describe real people and are not medical guidance or clinically validated records.

## Files
- `doctors.csv`: 12 fictional doctors and specializations.
- `patients.csv`: 30 fictional patient profiles, each assigned a doctor.
- `visits.csv`: 90 synthetic visit/session records linked by patient and doctor IDs.
- `patient_observations.csv`: 180 synthetic observation records linked to patient and doctor IDs.

## Relationships
- `patients.assigned_doctor_id` -> `doctors.doctor_id`
- `visits.patient_id` -> `patients.patient_id`
- `visits.doctor_id` -> `doctors.doctor_id`
- `patient_observations.patient_id` -> `patients.patient_id`
- `patient_observations.recorded_by_doctor_id` -> `doctors.doctor_id`

## Important ML note
Keep the original `ml-service/models/jotnohealthcare_general_disease_model.pkl` and its disease-symptom training data separate. Doctor and patient profile columns are not input features for the existing disease prediction model. These new CSV files are for database seeding, dashboard tables, relationship demonstrations, and analytics exercises only.

All observations are deliberately labelled as synthetic. Do not use these rows to make real healthcare decisions or to claim clinical model performance.
