<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Attendance;
use App\Models\Grantee;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('event_date', 'desc')->get();

        return view('attendance.attendance', compact('events'));
    }

    public function storeEvent(Request $request)
    {
        $request->validate([
            'event_name' => 'required|string|max:255',
            'event_date' => 'nullable|date',
        ]);

        Event::create([
            'event_name' => $request->event_name,
            'event_date' => $request->event_date,
        ]);

        return redirect()->route('attendance.index')->with('success', 'Event added successfully.');
    }

    public function editEvent($id)
    {
        $event = Event::findOrFail($id);

        return view('attendance.edit_event', compact('event'));
    }

    public function updateEvent(Request $request, $id)
    {
        $request->validate([
            'event_name' => 'required|string|max:255',
            'event_date' => 'nullable|date',
        ]);

        $event = Event::findOrFail($id);

        $event->update([
            'event_name' => $request->event_name,
            'event_date' => $request->event_date,
        ]);

        return redirect()->route('attendance.index')
            ->with('success', 'Event updated successfully.');
    }

    public function deleteEvent($id)
    {
        $event = Event::findOrFail($id);

        $hasAttendance = Attendance::where('event_id', $event->id)->exists();

        if ($hasAttendance) {
            return redirect()->route('attendance.index')
                ->with('error', 'Cannot delete event because it already has attendance records.');
        }

        $event->delete();

        return redirect()->route('attendance.index')
            ->with('success', 'Event deleted successfully.');
    }

    public function showEvent($id)
    {
        $event = Event::findOrFail($id);

        $attendances = Attendance::where('event_id', $event->id)
            ->latest()
            ->get();

        $completeAttendance = Attendance::where('event_id', $event->id)
            ->whereNotNull('time_in')
            ->whereNotNull('time_out')
            ->count();

        $incompleteAttendance = Attendance::where('event_id', $event->id)
            ->where(function ($query) {
                $query->whereNotNull('time_in')
                      ->orWhereNotNull('time_out');
            })
            ->where(function ($query) {
                $query->whereNull('time_in')
                      ->orWhereNull('time_out');
            })
            ->count();

        return view('attendance.event_students', compact(
            'event',
            'attendances',
            'completeAttendance',
            'incompleteAttendance'
        ));
    }

    public function testScan($value)
    {
        $grantee = Grantee::where('student_id', $value)->first();

        if (!$grantee) {
            return response()->json([
                'message' => 'Grantee not found'
            ], 404);
        }

        $fullName = trim(
            $grantee->first_name . ' ' .
            ($grantee->middle_name ? $grantee->middle_name . ' ' : '') .
            $grantee->last_name .
            ($grantee->extension_name ? ' ' . $grantee->extension_name : '')
        );

        return response()->json([
            'student_id' => $grantee->student_id,
            'name' => $fullName,
            'course' => $grantee->course,
        ]);
    }

    public function scanPage()
    {
        $events = Event::orderBy('event_date', 'desc')->get();

        return view('attendance.scan', compact('events'));
    }

    public function processScan(Request $request, $id)
    {
        $request->validate([
            'student_id' => 'required'
        ]);

        $studentId = trim($request->student_id);

        $event = Event::findOrFail($id);

        $grantee = Grantee::where('student_id', $studentId)->first();

        if (!$grantee) {
            return back()->with('error', 'Grantee not found: ' . $studentId);
        }

        $fullName = trim(
            $grantee->first_name . ' ' .
            ($grantee->middle_name ? $grantee->middle_name . ' ' : '') .
            $grantee->last_name .
            ($grantee->extension_name ? ' ' . $grantee->extension_name : '')
        );

        $attendance = Attendance::where('student_number', $grantee->student_id)
            ->where('event_id', $event->id)
            ->first();

        if (!$attendance) {
            Attendance::create([
                'student_number' => $grantee->student_id,
                'event_id' => $event->id,
                'name' => $fullName,
                'course' => $grantee->course,
                'barcode' => $studentId,
                'time_in' => now(),
                'time_out' => null,
                'remarks' => 'Incomplete Attendance',
            ]);

            return back()->with('success', 'Time In saved successfully')
                ->with('student', [
                    'student_id' => $grantee->student_id,
                    'name' => $fullName,
                    'course' => $grantee->course,
                ]);
        }

        if (!$attendance->time_out) {
            $attendance->update([
                'time_out' => now(),
                'remarks' => null,
            ]);

            return back()->with('success', 'Time Out recorded successfully')
                ->with('student', [
                    'student_id' => $grantee->student_id,
                    'name' => $fullName,
                    'course' => $grantee->course,
                ]);
        }

        return back()->with('info', 'Already timed out')
            ->with('student', [
                'student_id' => $grantee->student_id,
                'name' => $fullName,
                'course' => $grantee->course,
            ]);
    }

    public function export($id)
    {
        $event = Event::findOrFail($id);

        return Excel::download(
            new AttendanceExport($event->id),
            $event->event_name . '_attendance.xlsx'
        );
    }

    public function print($event_id)
    {
        $event = Event::findOrFail($event_id);

        $attendances = Attendance::where('event_id', $event_id)->get();

        return view('attendance.print', compact('event', 'attendances'));
    }

    public function timeIn(Request $request, $eventId)
    {
        $request->validate([
            'barcode' => 'required'
        ]);

        $barcode = trim($request->barcode);

        $grantee = Grantee::where('student_id', $barcode)->first();

        if (!$grantee) {
            return back()->with('error', 'Grantee not found.');
        }

        $attendance = Attendance::where('event_id', $eventId)
            ->where('barcode', $barcode)
            ->first();

        $fullName = trim(
            $grantee->first_name . ' ' .
            ($grantee->middle_name ? $grantee->middle_name . ' ' : '') .
            $grantee->last_name .
            ($grantee->extension_name ? ' ' . $grantee->extension_name : '')
        );

        if (!$attendance) {
            Attendance::create([
                'student_number' => $grantee->student_id,
                'event_id' => $eventId,
                'name' => $fullName,
                'course' => $grantee->course,
                'barcode' => $barcode,
                'time_in' => now(),
                'time_out' => null,
                'remarks' => 'Incomplete Attendance',
            ]);

            return back()->with('success', 'Time in recorded successfully.');
        }

        if ($attendance->time_in) {
            return back()->with('info', 'Already timed in.');
        }

        $attendance->update([
            'student_number' => $grantee->student_id,
            'name' => $fullName,
            'course' => $grantee->course,
            'barcode' => $barcode,
            'time_in' => now(),
            'remarks' => $attendance->time_out ? null : 'Incomplete Attendance',
        ]);

        return back()->with('success', 'Time in recorded successfully.');
    }

    public function timeOut(Request $request, $eventId)
    {
        $request->validate([
            'barcode' => 'required'
        ]);

        $barcode = trim($request->barcode);

        $grantee = Grantee::where('student_id', $barcode)->first();

        if (!$grantee) {
            return back()->with('error', 'Grantee not found.');
        }

        $attendance = Attendance::where('event_id', $eventId)
            ->where('barcode', $barcode)
            ->first();

        $fullName = trim(
            $grantee->first_name . ' ' .
            ($grantee->middle_name ? $grantee->middle_name . ' ' : '') .
            $grantee->last_name .
            ($grantee->extension_name ? ' ' . $grantee->extension_name : '')
        );

        if (!$attendance) {
            Attendance::create([
                'student_number' => $grantee->student_id,
                'event_id' => $eventId,
                'name' => $fullName,
                'course' => $grantee->course,
                'barcode' => $barcode,
                'time_in' => null,
                'time_out' => now(),
                'remarks' => 'Incomplete Attendance',
            ]);

            return back()->with('success', 'Time out recorded successfully.');
        }

        if ($attendance->time_out) {
            return back()->with('info', 'Already timed out.');
        }

        $attendance->update([
            'student_number' => $grantee->student_id,
            'name' => $fullName,
            'course' => $grantee->course,
            'barcode' => $barcode,
            'time_out' => now(),
            'remarks' => $attendance->time_in ? null : 'Incomplete Attendance',
        ]);

        return back()->with('success', 'Time out recorded successfully.');
    }
}