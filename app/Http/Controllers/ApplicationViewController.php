<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Grantee;
use App\Models\StudentAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use App\Models\Semester;

class ApplicationViewController extends Controller
{
    public function index()
    {
        $viewingSemester = Semester::where('is_viewing', true)->first();

        $applications = Application::with('semester')
            ->when($viewingSemester, function ($query) use ($viewingSemester) {
                $query->where('semester_id', $viewingSemester->id);
            })
            ->orderByDesc('id')
            ->get();

        return view('application_list', compact('applications', 'viewingSemester'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'a_student_id' => ['required', 'string', 'max:50'],
            'a_last_name'  => ['required', 'string', 'max:100'],
            'a_given_name' => ['required', 'string', 'max:100'],
            'a_email'      => ['nullable', 'email', 'max:255'],
        ]);

        Application::create([
            'student_id' => $validated['a_student_id'],
            'last_name'  => $validated['a_last_name'],
            'given_name' => $validated['a_given_name'],
            'email'      => $validated['a_email'] ?? null,
            'status'     => 'pending',
        ]);

        return back()->with('success', 'Application created successfully!');
    }

    public function approve(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer', 'exists:tblapplications,id'],
        ]);

        try {
            $email = null;
            $plainPassword = null;
            $studentName = null;
            $studentId = null;

            DB::transaction(function () use ($request, &$email, &$plainPassword, &$studentName, &$studentId) {
                $app = Application::lockForUpdate()->findOrFail($request->id);

                if (($app->status ?? 'pending') !== 'pending') {
                    throw new \Exception('This application is no longer pending.');
                }

                if (!empty($app->email)) {
                    $existingStudentAccount = StudentAccount::where('email', $app->email)->first();
                    if ($existingStudentAccount) {
                        throw new \Exception('A student account with this email already exists.');
                    }
                }

                $existingGrantee = Grantee::where('application_id', $app->id)->first();
                if ($existingGrantee) {
                    throw new \Exception('This application is already in the grantees list.');
                }

                $app->status = 'approved';
                $app->save();

                $plainPassword = Str::upper(Str::random(8));

                $fullName = trim(
                    ($app->given_name ?? '') . ' ' .
                    ($app->middle_name ?? '') . ' ' .
                    ($app->last_name ?? '')
                );

                $studentName = preg_replace('/\s+/', ' ', $fullName);
                $studentId = $app->student_id;
                $email = $app->email;

                StudentAccount::create([
                    'student_id' => $app->student_id,
                    'name' => $studentName,
                    'email' => $app->email,
                    'password' => Hash::make($plainPassword),
                    'is_temp_password' => 1,
                ]);

                $nextSeq = (Grantee::max('seq') ?? 0) + 1;

                Grantee::create([
                    'application_id'    => $app->id,
                    'student_id'        => $app->student_id,
                    'seq'               => $nextSeq,
                    'last_name'         => $app->last_name,
                    'first_name'        => $app->given_name,
                    'middle_name'       => $app->middle_name,
                    'extension_name'    => $app->ext_name,
                    'mobile_number'     => $app->contact_number,
                    'email'             => $app->email,
                    'course'            => $app->program_name,
                    'year'              => $app->year_level,
                    'years_of_stay'     => null,
                    'status_of_student' => 'Active',
                    'remarks'           => 'Approved',
                    'batch_id'          => null,
                    'scholarship_id'    => null,
                ]);
            });

            if (!empty($email)) {
                Mail::raw(
                    "Hello {$studentName},\n\n" .
                    "Your student account has been created.\n\n" .
                    "Student ID: {$studentId}\n" .
                    "Email: {$email}\n" .
                    "Temporary Password: {$plainPassword}\n\n" .
                    "Please log in and change your password immediately.",
                    function ($message) use ($email, $studentName) {
                        $message->to($email, $studentName)
                            ->subject('Your Student Account Credentials');
                    }
                );
            }

            return back()->with('success', 'Application approved successfully, added to grantees list, and account credentials sent.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function reject(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer', 'exists:tblapplications,id'],
            'reason' => ['required', 'string', 'max:1000'],
        ]);

        $app = Application::findOrFail($request->id);

        if (($app->status ?? 'pending') !== 'pending') {
            return back()->with('error', 'This application is no longer pending.');
        }

        $app->status = 'rejected';
        $app->rejection_reason = $request->reason;
        $app->save();

        return back()->with('success', 'Application rejected successfully.');
    }

    public function edit($id)
    {
        $application = Application::findOrFail($id);
        return response()->json($application);
    }

    public function show($id)
    {
        $application = Application::findOrFail($id);
        return response()->json($application);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'ea_id' => ['required', 'integer', 'exists:tblapplications,id'],
            'ea_student_id' => ['required', 'string', 'max:50'],
            'ea_last_name' => ['required', 'string', 'max:100'],
            'ea_given_name' => ['required', 'string', 'max:100'],
            'ea_middle_name' => ['nullable', 'string', 'max:100'],
            'ea_ext_name' => ['nullable', 'string', 'max:20'],
            'ea_email' => ['nullable', 'email', 'max:255'],
            'ea_sex' => ['nullable', 'string', 'max:10'],
            'ea_birth_date' => ['nullable', 'date'],
            'ea_program_name' => ['nullable', 'string', 'max:150'],
            'ea_year_level' => ['nullable', 'string', 'max:50'],
            'ea_father_last_name' => ['nullable', 'string', 'max:100'],
            'ea_father_given_name' => ['nullable', 'string', 'max:100'],
            'ea_father_middle_name' => ['nullable', 'string', 'max:100'],
            'ea_mother_last_name' => ['nullable', 'string', 'max:100'],
            'ea_mother_given_name' => ['nullable', 'string', 'max:100'],
            'ea_mother_middle_name' => ['nullable', 'string', 'max:100'],
            'ea_street_barangay' => ['nullable', 'string', 'max:255'],
            'ea_zipcode' => ['nullable', 'string', 'max:10'],
            'ea_contact_number' => ['nullable', 'string', 'max:30'],
            'ea_disability' => ['nullable', 'string', 'max:255'],
            'ea_indigenous_group' => ['nullable', 'string', 'max:255'],
        ]);

        $app = Application::findOrFail($validated['ea_id']);

        $app->update([
            'student_id' => $validated['ea_student_id'],
            'last_name' => $validated['ea_last_name'],
            'given_name' => $validated['ea_given_name'],
            'middle_name' => $validated['ea_middle_name'] ?? null,
            'ext_name' => $validated['ea_ext_name'] ?? null,
            'email' => $validated['ea_email'] ?? null,
            'sex' => $validated['ea_sex'] ?? null,
            'birthdate' => $validated['ea_birth_date'] ?? null,
            'program_name' => $validated['ea_program_name'] ?? null,
            'year_level' => $validated['ea_year_level'] ?? null,
            'father_last_name' => $validated['ea_father_last_name'] ?? null,
            'father_given_name' => $validated['ea_father_given_name'] ?? null,
            'father_middle_name' => $validated['ea_father_middle_name'] ?? null,
            'mother_last_name' => $validated['ea_mother_last_name'] ?? null,
            'mother_given_name' => $validated['ea_mother_given_name'] ?? null,
            'mother_middle_name' => $validated['ea_mother_middle_name'] ?? null,
            'street_barangay' => $validated['ea_street_barangay'] ?? null,
            'zipcode' => $validated['ea_zipcode'] ?? null,
            'contact_number' => $validated['ea_contact_number'] ?? null,
            'disability' => $validated['ea_disability'] ?? null,
            'indigenous_group' => $validated['ea_indigenous_group'] ?? null,
        ]);

        return back()->with('success', 'Application updated successfully!');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'da_id' => ['required', 'integer', 'exists:tblapplications,id'],
        ]);

        $application = Application::findOrFail($request->da_id);

        $existingGrantee = Grantee::where('application_id', $application->id)->first();

        if ($existingGrantee) {
            return back()->with('error', 'Cannot delete this application because it is already in the grantees list.');
        }

        $application->delete();

        return back()->with('success', 'Application deleted successfully!');
    }

    public function approved()
    {
        $applications = Application::where('status', 'approved')
            ->orderByDesc('id')
            ->paginate(10);

        return view('approve_list.approved', compact('applications'));
    }

    public function rejected()
    {
        $applications = Application::where('status', 'rejected')
            ->orderByDesc('id')
            ->paginate(10);

        return view('approve_list.rejected', compact('applications'));
    }

public function exportExcel()
{
    $applications = Application::orderBy('last_name')
        ->orderBy('given_name')
        ->get();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Annex 1');

    $blue = '0B4F9C';
    $gold = 'C58A1C';
    $white = 'FFFFFF';
    $black = '000000';
    $grayBorder = '9E9E9E';

    // Column widths
    $widths = [
        'A' => 7,
        'B' => 14,
        'C' => 16,
        'D' => 16,
        'E' => 12,
        'F' => 15,
        'G' => 11,
        'H' => 15,
        'I' => 28,
        'J' => 12,
        'K' => 14,
        'L' => 14,
        'M' => 14,
        'N' => 14,
        'O' => 14,
        'P' => 14,
        'Q' => 20,
        'R' => 12,
        'S' => 18,
        'T' => 15,
        'U' => 22,
        'V' => 20,
    ];

    foreach ($widths as $col => $width) {
        $sheet->getColumnDimension($col)->setWidth($width);
    }

    // Row heights
    $sheet->getDefaultRowDimension()->setRowHeight(20);
    $sheet->getRowDimension(1)->setRowHeight(8);
    $sheet->getRowDimension(2)->setRowHeight(24);
    $sheet->getRowDimension(3)->setRowHeight(24);
    $sheet->getRowDimension(4)->setRowHeight(22);
    $sheet->getRowDimension(5)->setRowHeight(8);
    $sheet->getRowDimension(6)->setRowHeight(26);
    $sheet->getRowDimension(7)->setRowHeight(8);
    $sheet->getRowDimension(8)->setRowHeight(8);
    $sheet->getRowDimension(9)->setRowHeight(22);  // instruction
    $sheet->getRowDimension(10)->setRowHeight(22); // white header row
    $sheet->getRowDimension(11)->setRowHeight(28); // blue group header
    $sheet->getRowDimension(12)->setRowHeight(44); // gold subheader

    // Logos
    $leftLogoPath = public_path('images/ched.png');
    $rightLogoPath = public_path('images/unifastLogoclear.png');

    if (file_exists($leftLogoPath)) {
        $drawing = new Drawing();
        $drawing->setName('CHED Logo');
        $drawing->setDescription('CHED Logo');
        $drawing->setPath($leftLogoPath);
        $drawing->setHeight(64);
        $drawing->setCoordinates('D2');
        $drawing->setOffsetX(12);
        $drawing->setOffsetY(4);
        $drawing->setWorksheet($sheet);
    }

    if (file_exists($rightLogoPath)) {
        $drawing2 = new Drawing();
        $drawing2->setName('UniFAST Logo');
        $drawing2->setDescription('UniFAST Logo');
        $drawing2->setPath($rightLogoPath);
        $drawing2->setHeight(64);
        $drawing2->setCoordinates('N2');
        $drawing2->setOffsetX(8);
        $drawing2->setOffsetY(4);
        $drawing2->setWorksheet($sheet);
    }

    // Title area
    $sheet->mergeCells('F2:L2');
    $sheet->mergeCells('F3:L3');
    $sheet->mergeCells('F4:L4');
    $sheet->mergeCells('F6:L6');

    $sheet->setCellValue('F2', 'Republic of the Philippines');
    $sheet->setCellValue('F3', 'IFUGAO STATE UNIVERSITY');
    $sheet->setCellValue('F4', 'Academic Year 2025-2026');
    $sheet->setCellValue('F6', 'LIST OF TES APPLICANTS');

    $sheet->getStyle('F2:L6')->getAlignment()
        ->setHorizontal(Alignment::HORIZONTAL_CENTER)
        ->setVertical(Alignment::VERTICAL_CENTER);

    $sheet->getStyle('F2:L2')->getFont()->setSize(11);
    $sheet->getStyle('F3:L3')->getFont()->setSize(14)->setBold(true)->setItalic(true);
    $sheet->getStyle('F4:L4')->getFont()->setSize(11)->setBold(true);
    $sheet->getStyle('F4:L4')->getFont()->getColor()->setRGB('C0392B');
    $sheet->getStyle('F6:L6')->getFont()->setSize(15)->setBold(true);

    // Instruction row
    $sheet->mergeCells('A9:V9');
    $sheet->setCellValue('A9', 'Please read the instructions in the General Instructions tab of this template');
    $sheet->getStyle('A9:V9')->getFont()->setSize(10);
    $sheet->getStyle('A9:V9')->getAlignment()
        ->setHorizontal(Alignment::HORIZONTAL_LEFT)
        ->setVertical(Alignment::VERTICAL_CENTER);

    /*
    |--------------------------------------------------------------------------
    | WHITE GROUP HEADER ROW (ROW 10)
    |--------------------------------------------------------------------------
    */
    $sheet->mergeCells('B10:H10'); // STUDENT INFORMATION
    $sheet->mergeCells('I10:J10'); // STUDENT'S PROFILE
    $sheet->mergeCells('K10:P10'); // FAMILY BACKGROUND
    $sheet->mergeCells('Q10:R10'); // PERMANENT ADDRESS

    $sheet->setCellValue('B10', 'STUDENT INFORMATION');
    $sheet->setCellValue('I10', "STUDENT'S PROFILE");
    $sheet->setCellValue('K10', 'FAMILY BACKGROUND');
    $sheet->setCellValue('Q10', 'PERMANENT ADDRESS');

    $sheet->getStyle('B10:R10')->applyFromArray([
        'font' => [
            'bold' => true,
            'size' => 11,
            'color' => ['rgb' => $black],
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | BLUE GROUP HEADER ROW (ROW 11)
    |--------------------------------------------------------------------------
    */
    $sheet->mergeCells('A11:A12'); // SEQ
    $sheet->mergeCells('B11:B12'); // STUDENT ID
    $sheet->mergeCells('C11:F11'); // STUDENT'S NAME
    $sheet->mergeCells('G11:H11'); // STUDENT INFORMATION
    $sheet->mergeCells('I11:J11'); // STUDENT'S PROFILE
    $sheet->mergeCells('K11:M11'); // FATHER'S NAME
    $sheet->mergeCells('N11:P11'); // MOTHER'S MAIDEN NAME
    $sheet->mergeCells('Q11:R11'); // PERMANENT ADDRESS
    $sheet->mergeCells('S11:S12'); // DISABILITY
    $sheet->mergeCells('T11:T12'); // CONTACT NUMBER
    $sheet->mergeCells('U11:U12'); // EMAIL ADDRESS
    $sheet->mergeCells('V11:V12'); // IP GROUP

    $sheet->setCellValue('A11', 'SEQ');
    $sheet->setCellValue('B11', "STUDENT\nID");
    $sheet->setCellValue('C11', "STUDENT'S NAME");
    $sheet->setCellValue('G11', 'STUDENT INFORMATION');
    $sheet->setCellValue('I11', "STUDENT'S PROFILE");
    $sheet->setCellValue('K11', "FATHER'S NAME");
    $sheet->setCellValue('N11', "MOTHER'S MAIDEN NAME");
    $sheet->setCellValue('Q11', 'PERMANENT ADDRESS');
    $sheet->setCellValue('S11', "DISABILITY\n(leave blank if\nNOT Applicable)");
    $sheet->setCellValue('T11', "CONTACT\nNUMBER");
    $sheet->setCellValue('U11', "EMAIL\nADDRESS");
    $sheet->setCellValue('V11', "INDIGENOUS\nPEOPLE GROUP\n(leave blank if Not\nApplicable)");

    /*
    |--------------------------------------------------------------------------
    | GOLD SUBHEADER ROW (ROW 12)
    |--------------------------------------------------------------------------
    */
    $sheet->setCellValue('C12', 'LAST NAME');
    $sheet->setCellValue('D12', 'GIVEN NAME');
    $sheet->setCellValue('E12', 'EXT. NAME');
    $sheet->setCellValue('F12', 'MIDDLE NAME');

    $sheet->setCellValue('G12', "SEX\n(Male\nor Female)");
    $sheet->setCellValue('H12', "BIRTHDATE\n(dd/mm/yyyy)");

    $sheet->setCellValue('I12', "COMPLETE PROGRAM NAME\n(Should be consistent with your HEI\nRegistry)");
    $sheet->setCellValue('J12', "YEAR LEVEL\n(1,2,3,4,5)");

    $sheet->setCellValue('K12', 'LAST NAME');
    $sheet->setCellValue('L12', 'GIVEN NAME');
    $sheet->setCellValue('M12', 'MIDDLE NAME');

    $sheet->setCellValue('N12', 'LAST NAME');
    $sheet->setCellValue('O12', 'GIVEN NAME');
    $sheet->setCellValue('P12', 'MIDDLE NAME');

    $sheet->setCellValue('Q12', "STREET &\nBARANGAY");
    $sheet->setCellValue('R12', "ZIPCODE\n(TES\nApplicant)");

    // Alignment for all headers
    $sheet->getStyle('A11:V12')->getAlignment()
        ->setHorizontal(Alignment::HORIZONTAL_CENTER)
        ->setVertical(Alignment::VERTICAL_CENTER)
        ->setWrapText(true);

    // Blue cells
    foreach (['A11', 'C11', 'G11', 'I11', 'K11', 'N11', 'Q11', 'S11', 'V11'] as $cell) {
        $sheet->getStyle($cell)->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => $blue],
            ],
            'font' => [
                'bold' => true,
                'size' => 10,
                'color' => ['rgb' => $white],
            ],
        ]);
    }

    // Gold cells
    foreach (['B11', 'T11', 'U11'] as $cell) {
        $sheet->getStyle($cell)->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => $gold],
            ],
            'font' => [
                'bold' => true,
                'size' => 10,
                'color' => ['rgb' => $white],
            ],
        ]);
    }

    // Gold subheader row
    $sheet->getStyle('C12:R12')->applyFromArray([
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => $gold],
        ],
        'font' => [
            'bold' => true,
            'size' => 9,
            'color' => ['rgb' => $white],
        ],
    ]);

    // Borders for headers
    $sheet->getStyle('A11:V12')->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['rgb' => $black],
            ],
        ],
    ]);

    // Data starts at row 13
    $row = 13;
    $seq = 1;

    foreach ($applications as $app) {
        $birthdate = '';

        if (!empty($app->birthdate)) {
            try {
                $birthdate = \Carbon\Carbon::parse($app->birthdate)->format('d/m/Y');
            } catch (\Exception $e) {
                $birthdate = $app->birthdate;
            }
        }

        $sheet->setCellValue("A{$row}", $seq);
        $sheet->setCellValue("B{$row}", $app->student_id ?? '');
        $sheet->setCellValue("C{$row}", $app->last_name ?? '');
        $sheet->setCellValue("D{$row}", $app->given_name ?? '');
        $sheet->setCellValue("E{$row}", $app->ext_name ?? '');
        $sheet->setCellValue("F{$row}", $app->middle_name ?? '');
        $sheet->setCellValue("G{$row}", $app->sex ?? '');
        $sheet->setCellValue("H{$row}", $birthdate);
        $sheet->setCellValue("I{$row}", $app->program_name ?? '');
        $sheet->setCellValue("J{$row}", $app->year_level ?? '');
        $sheet->setCellValue("K{$row}", $app->father_last_name ?? '');
        $sheet->setCellValue("L{$row}", $app->father_given_name ?? '');
        $sheet->setCellValue("M{$row}", $app->father_middle_name ?? '');
        $sheet->setCellValue("N{$row}", $app->mother_last_name ?? '');
        $sheet->setCellValue("O{$row}", $app->mother_given_name ?? '');
        $sheet->setCellValue("P{$row}", $app->mother_middle_name ?? '');
        $sheet->setCellValue("Q{$row}", $app->street_barangay ?? '');
        $sheet->setCellValue("R{$row}", $app->zipcode ?? '');
        $sheet->setCellValue("S{$row}", $app->disability ?? '');
        $sheet->setCellValue("T{$row}", $app->contact_number ?? '');
        $sheet->setCellValue("U{$row}", $app->email ?? '');
        $sheet->setCellValue("V{$row}", $app->indigenous_group ?? '');

        $sheet->getRowDimension($row)->setRowHeight(22);

        $row++;
        $seq++;
    }

    $lastRow = $row - 1;

    if ($lastRow >= 13) {
        $sheet->getStyle("A13:V{$lastRow}")->applyFromArray([
            'font' => [
                'size' => 9,
                'color' => ['rgb' => $black],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => $grayBorder],
                ],
            ],
        ]);

        $sheet->getStyle("C13:F{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("I13:I{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("K13:Q{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("T13:V{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    }

    if ($lastRow >= 11) {
        $sheet->getStyle("A11:V{$lastRow}")->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color' => ['rgb' => $black],
                ],
            ],
        ]);
    }

    $sheet->freezePane('A13');

    $sheet->getPageSetup()->setOrientation(
        \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE
    );

    $sheet->getPageSetup()->setPaperSize(
        \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4
    );

    $sheet->getPageSetup()->setFitToWidth(1);
    $sheet->getPageSetup()->setFitToHeight(0);

    $sheet->getPageMargins()->setTop(0.30);
    $sheet->getPageMargins()->setRight(0.20);
    $sheet->getPageMargins()->setLeft(0.20);
    $sheet->getPageMargins()->setBottom(0.30);
    $sheet->getPageMargins()->setHeader(0.15);
    $sheet->getPageMargins()->setFooter(0.15);

    $sheet->getSheetView()->setZoomScale(85);

    $fileName = 'TES_Applicants_Annex1_' . now()->format('Ymd_His') . '.xlsx';

    return response()->streamDownload(function () use ($spreadsheet) {
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }, $fileName, [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ]);
}
}