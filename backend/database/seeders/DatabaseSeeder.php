<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{
    User, Patient, Observation, AdmissionRequest, CaregiverAccess,
    Assessment, CarePlan, Referral, Consultation, Notification
};
use Illuminate\Support\Carbon;

/**
 * Synthetic demonstration data only. All names, contact details and health
 * observations below are fictional and must never be treated as real records.
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $makeUser = static function (string $name, string $email, string $role, string $phone): User {
            return User::firstOrCreate(
                ['email' => $email],
                ['name' => $name, 'password' => 'password', 'role' => $role, 'phone' => $phone]
            );
        };

        $admin = $makeUser('Jotno Demo Administrator', 'admin@jotno.test', 'admin', '01000000001');

        // Demo duty doctors
        $doctors = collect([
            ['Dr. Ayesha Rahman', 'ayesha.doctor@jotno.test', '01000000011'],
            ['Dr. Farhan Ahmed', 'farhan.doctor@jotno.test', '01000000012'],
            ['Dr. Nusrat Jahan', 'nusrat.doctor@jotno.test', '01000000013'],
            ['Dr. Mahmud Hasan', 'mahmud.doctor@jotno.test', '01000000014'],
        ])->map(fn ($row) => $makeUser($row[0], $row[1], 'doctor', $row[2]));

        // Demo specialists
        $specialists = collect([
            ['Dr. Samiul Islam', 'samiul.specialist@jotno.test', '01000000021'],
            ['Dr. Tahmina Akter', 'tahmina.specialist@jotno.test', '01000000022'],
            ['Dr. Rafiq Chowdhury', 'rafiq.specialist@jotno.test', '01000000023'],
        ])->map(fn ($row) => $makeUser($row[0], $row[1], 'specialist', $row[2]));

        // A few stable aliases are retained for the original quick-start guide.
        $makeUser('Duty Doctor Demo', 'doctor@jotno.test', 'doctor', '01000000010');
        $makeUser('Specialist Demo', 'specialist@jotno.test', 'specialist', '01000000020');

        $patientRows = [
            ['Demo Patient', 'patient@jotno.test', '01000000101', '1998-04-12', 'Female', 'Dhanmondi, Dhaka', 'Synthetic history: seasonal allergy noted for UI demonstration.', 'Not provided'],
            ['Nabila Sultana', 'nabila.patient@jotno.test', '01000000102', '1995-09-03', 'Female', 'Mirpur, Dhaka', 'Synthetic history: no known history entered in this demo.', 'Not provided'],
            ['Arif Hossain', 'arif.patient@jotno.test', '01000000103', '1989-02-18', 'Male', 'Uttara, Dhaka', 'Synthetic history: sample record for observation chart testing.', 'Not provided'],
            ['Maliha Islam', 'maliha.patient@jotno.test', '01000000104', '2001-11-27', 'Female', 'Savar, Dhaka', 'Synthetic history: demo profile only.', 'Not provided'],
            ['Tanvir Kabir', 'tanvir.patient@jotno.test', '01000000105', '1978-06-09', 'Male', 'Mohammadpur, Dhaka', 'Synthetic history: sample long-term monitoring profile.', 'Not provided'],
            ['Sumaiya Akter', 'sumaiya.patient@jotno.test', '01000000106', '1992-01-15', 'Female', 'Jatrabari, Dhaka', 'Synthetic history: no clinical information supplied.', 'Not provided'],
            ['Rakibul Hasan', 'rakib.patient@jotno.test', '01000000107', '1985-08-21', 'Male', 'Narayanganj, Bangladesh', 'Synthetic history: demo referral workflow profile.', 'Not provided'],
            ['Farzana Noor', 'farzana.patient@jotno.test', '01000000108', '2003-03-30', 'Female', 'Keraniganj, Dhaka', 'Synthetic history: sample admission workflow profile.', 'Not provided'],
        ];

        $patients = collect();
        foreach ($patientRows as $index => [$name, $email, $phone, $dob, $sex, $address, $history, $allergies]) {
            $user = $makeUser($name, $email, 'patient', $phone);
            $profile = Patient::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'date_of_birth' => $dob,
                    'sex' => $sex,
                    'address' => $address,
                    'emergency_contact' => '010000009' . str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT),
                    'medical_history' => $history,
                    'allergies' => $allergies,
                ]
            );
            $patients->push($profile);
        }

        // Demo caregivers and explicit patient-access links
        $caregiverRows = [
            ['Demo Caregiver', 'caregiver@jotno.test', '01000000201'],
            ['Mim Akter', 'mim.caregiver@jotno.test', '01000000202'],
            ['Shakil Ahmed', 'shakil.caregiver@jotno.test', '01000000203'],
            ['Rumana Begum', 'rumana.caregiver@jotno.test', '01000000204'],
        ];
        $caregivers = collect();
        foreach ($caregiverRows as [$name, $email, $phone]) {
            $caregivers->push($makeUser($name, $email, 'caregiver', $phone));
        }

        $doctorList = $doctors->values();
        $specialistList = $specialists->values();

        foreach ($patients as $i => $patient) {
            $doctor = $doctorList[$i % $doctorList->count()];
            $specialist = $specialistList[$i % $specialistList->count()];
            $caregiver = $caregivers[$i % $caregivers->count()];

            CaregiverAccess::firstOrCreate(
                ['patient_id' => $patient->id, 'caregiver_id' => $caregiver->id],
                ['approved_by' => $admin->id, 'status' => $i % 3 === 0 ? 'pending' : 'approved']
            );

            // Seven days of clearly labelled synthetic observations per patient.
            for ($day = 6; $day >= 0; $day--) {
                $recordedAt = Carbon::now()->subDays($day)->setTime(9, 0);
                $tag = 'SYNTHETIC-DEMO-P' . $patient->id . '-D' . $day;
                Observation::firstOrCreate(
                    ['patient_id' => $patient->id, 'notes' => $tag],
                    [
                        'recorded_by' => $patient->user_id,
                        'temperature' => 36.5 + (($i + $day) % 5) * 0.1,
                        'spo2' => 96 + (($i + $day) % 4),
                        'heart_rate' => 70 + (($i * 3 + $day * 2) % 18),
                        'systolic_bp' => 110 + (($i * 2 + $day) % 15),
                        'diastolic_bp' => 70 + (($i + $day) % 10),
                        'symptoms' => $day % 3 === 0 ? ['sample fatigue'] : ['demo observation'],
                        'recorded_at' => $recordedAt,
                    ]
                );
            }

            AdmissionRequest::firstOrCreate(
                ['patient_id' => $patient->id, 'reason' => 'Synthetic demo admission request #' . ($i + 1)],
                [
                    'symptoms' => $i % 2 === 0 ? ['sample fatigue', 'sample headache'] : ['sample cough'],
                    'status' => $i % 3 === 0 ? 'pending' : ($i % 3 === 1 ? 'approved' : 'under_review'),
                    'reviewed_by' => $i % 3 === 0 ? null : $doctor->id,
                    'review_note' => $i % 3 === 0 ? null : 'Demo-only workflow note; clinician review required in real use.',
                    'reviewed_at' => $i % 3 === 0 ? null : now()->subDays($i + 1),
                ]
            );

            Assessment::firstOrCreate(
                ['patient_id' => $patient->id, 'explanation' => 'SYNTHETIC-DEMO-ASSESSMENT-' . $patient->id],
                [
                    'created_by' => $patient->user_id,
                    'symptoms' => ['sample fatigue', 'sample headache'],
                    'predicted_label' => 'Demo prediction — not a diagnosis',
                    'department' => 'General Medicine',
                    'priority' => 'review',
                    'doctor_status' => $i % 2 === 0 ? 'pending' : 'reviewed',
                    'doctor_note' => $i % 2 === 0 ? null : 'Synthetic sample reviewed for interface demonstration.',
                ]
            );

            CarePlan::firstOrCreate(
                ['patient_id' => $patient->id, 'title' => 'Demo monitoring plan ' . ($i + 1)],
                [
                    'doctor_id' => $doctor->id,
                    'instructions' => 'Synthetic placeholder only. No medical advice: replace with an individually clinician-approved care plan.',
                    'reminder_at' => now()->addDays($i + 1),
                    'status' => 'active',
                ]
            );

            if ($i % 2 === 0) {
                Referral::firstOrCreate(
                    ['patient_id' => $patient->id, 'reason' => 'Synthetic referral scenario #' . ($i + 1)],
                    [
                        'doctor_id' => $doctor->id,
                        'specialist_id' => $specialist->id,
                        'department' => ['Cardiology', 'Dermatology', 'Medicine'][$i % 3],
                        'status' => $i % 4 === 0 ? 'pending' : 'accepted',
                        'specialist_note' => $i % 4 === 0 ? null : 'Demo note only; no clinical recommendation.',
                    ]
                );
            }

            if ($i < 4) {
                Consultation::firstOrCreate(
                    ['patient_id' => $patient->id, 'notes' => 'SYNTHETIC-DEMO-CONSULT-' . $patient->id],
                    [
                        'doctor_id' => $doctor->id,
                        'scheduled_at' => now()->addDays($i + 1)->setTime(11 + $i, 0),
                        'meeting_url' => null,
                        'status' => 'scheduled',
                    ]
                );
            }

            Notification::firstOrCreate(
                ['user_id' => $patient->user_id, 'title' => 'Demo profile ready'],
                ['body' => 'This is fictional sample data for the JotnoHealthcare academic demonstration.']
            );
        }

        Notification::firstOrCreate(
            ['user_id' => $admin->id, 'title' => 'Demo data loaded'],
            ['body' => 'Synthetic doctors, specialists, patients, caregivers and workflow records are available for testing.']
        );
    }
}
