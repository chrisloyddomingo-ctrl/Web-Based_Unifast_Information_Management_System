<?php

namespace App\Imports;

use App\Models\Batch;
use App\Models\Grantee;
use App\Models\Scholarship;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GranteesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $scholarshipInput = trim(
            $row['scholarship']
            ?? $row['grant_type']
            ?? $row['program']
            ?? ''
        );

        $batchInput = trim($row['batch'] ?? '');

        $normalizedScholarship = strtoupper($scholarshipInput);

        if (in_array($normalizedScholarship, ['TES', 'TERTIARY EDUCATION SUBSIDY'])) {
            $scholarshipName = 'Tertiary Education Subsidy';
        } elseif (in_array($normalizedScholarship, ['TDP', 'TULONG DUNONG PROGRAM'])) {
            $scholarshipName = 'Tulong Dunong Program';
        } else {
            $scholarshipName = $scholarshipInput;
        }

        $scholarship = null;

        if ($scholarshipName !== '') {
            $scholarship = Scholarship::firstOrCreate([
                'name' => $scholarshipName
            ]);
        }

        $batch = null;

        if ($scholarship && $batchInput !== '') {
            $batch = Batch::firstOrCreate([
                'scholarship_id' => $scholarship->id,
                'name' => $batchInput,
            ]);
        }

        $studentId = trim($row['student_id'] ?? '');
        $applicationId = trim((string) ($row['application_id'] ?? ''));
        $seq = trim((string) ($row['seq'] ?? ''));
        $lastName = trim($row['last_name'] ?? '');
        $firstName = trim($row['first_name'] ?? '');
        $middleName = trim($row['middle_name'] ?? '');
        $extensionName = trim($row['extension_name'] ?? '');
        $mobileNumber = trim((string) ($row['mobile_number'] ?? ''));
        $email = trim($row['email'] ?? '');
        $course = trim($row['course'] ?? '');
        $year = trim((string) ($row['year'] ?? ''));
        $yearsOfStay = trim((string) ($row['years_of_stay'] ?? ''));
        $statusOfStudent = trim($row['status_of_student'] ?? 'Enrolled');
        $remarks = trim($row['remarks'] ?? '');

        if ($studentId === '' || $lastName === '' || $firstName === '') {
            return null;
        }

        Grantee::updateOrCreate(
            ['student_id' => $studentId],
            [
                'application_id' => $applicationId !== '' ? (int) $applicationId : null,
                'seq' => $seq !== '' ? $seq : null,
                'last_name' => $lastName,
                'first_name' => $firstName,
                'middle_name' => $middleName !== '' ? $middleName : null,
                'extension_name' => $extensionName !== '' ? $extensionName : null,
                'mobile_number' => $mobileNumber !== '' ? $mobileNumber : null,
                'email' => $email !== '' ? $email : null,
                'course' => $course !== '' ? $course : null,
                'year' => $year !== '' ? $year : null,
                'years_of_stay' => $yearsOfStay !== '' ? (int) $yearsOfStay : null,
                'status_of_student' => $statusOfStudent !== '' ? $statusOfStudent : 'Enrolled',
                'remarks' => $remarks !== '' ? $remarks : null,
                'batch_id' => $batch?->id,
                'scholarship_id' => $scholarship?->id,
            ]
        );

        return null;
    }
}