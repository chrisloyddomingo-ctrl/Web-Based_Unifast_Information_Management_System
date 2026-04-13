<!DOCTYPE html>
<html>
<head>
    <title>Print Attendance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h2, h4 {
            text-align: center;
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            font-size: 12px;
            text-align: center;
        }

        @media print {
            button {
                display: none;
            }
        }
    </style>
</head>
<body>

    <button onclick="window.print()">🖨 Print</button>

    <h2>{{ $event->event_name }}</h2>
    <h4>{{ $event->event_date }}</h4>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Student Number</th>
                <th>Name</th>
                <th>Course</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $index => $a)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $a->student_number }}</td>
                    <td>{{ $a->name }}</td>
                    <td>{{ $a->course }}</td>
                    <td>{{ $a->time_in }}</td>
                    <td>{{ $a->time_out }}</td>
                    <td>{{ $a->final_remarks }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>

</body>
</html>