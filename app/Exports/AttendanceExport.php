<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Event;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromArray, ShouldAutoSize, WithStyles
{
    protected $event_id;

    public function __construct($event_id)
    {
        $this->event_id = $event_id;
    }

    public function array(): array
    {
        $event = Event::findOrFail($this->event_id);

        $rows = [];

        $rows[] = ['Attendance Report'];
        $rows[] = ['Event Name:', $event->event_name];
        $rows[] = ['Event Date:', $event->event_date ? Carbon::parse($event->event_date)->format('F d, Y') : ''];
        $rows[] = [];

        $rows[] = [
            'Student Number',
            'Name',
            'Course',
            'Barcode',
            'Time In',
            'Time Out',
            'Remarks',
        ];

        $attendances = Attendance::where('event_id', $this->event_id)->get();

        foreach ($attendances as $attendance) {
            $rows[] = [
                $attendance->student_number,
                $attendance->name,
                $attendance->course,
                $attendance->barcode,
                $attendance->time_in
                    ? Carbon::parse($attendance->time_in)->timezone('Asia/Manila')->format('h:i A')
                    : '',
                $attendance->time_out
                    ? Carbon::parse($attendance->time_out)->timezone('Asia/Manila')->format('h:i A')
                    : '',
                $attendance->time_in && $attendance->time_out
                    ? 'Complete Attendance'
                    : ($attendance->time_in ? 'Time In' : ''),
            ];
        }

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 16],
            ],
            2 => [
                'font' => ['bold' => true],
            ],
            3 => [
                'font' => ['bold' => true],
            ],
            5 => [
                'font' => ['bold' => true],
            ],
        ];
    }

}