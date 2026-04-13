<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 24px;
            color: #000;
            background: #fff;
        }

        .print-container {
            width: 100%;
            margin: 0 auto;
        }

        .print-header-wrap {
            text-align: center;
            margin-bottom: 10px;
        }

        .print-header-image {
            width: 100%;
            max-width: 1000px;
            height: auto;
            display: block;
            margin: 0 auto;
            object-fit: contain;
        }

        .print-title-wrap {
            text-align: center;
            margin-bottom: 18px;
        }

        .print-title-wrap h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }

        .print-subtitle {
            margin-top: 4px;
            color: #555;
            font-size: 14px;
        }

        .print-date {
            margin-top: 4px;
            color: #444;
            font-size: 13px;
        }

        .print-toolbar {
            display: flex;
            gap: 10px;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .print-toolbar button {
            border: none;
            background: #ff8c00;
            color: #fff;
            padding: 10px 16px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        .print-toolbar button.secondary {
            background: #6c757d;
        }

        .print-note {
            text-align: center;
            font-size: 13px;
            color: #666;
            margin-bottom: 16px;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        thead th {
            background: #f2f2f2;
            color: #000;
            border: 1px solid #cfcfcf;
            text-align: center;
            vertical-align: middle;
            padding: 8px;
            font-weight: 700;
        }

        tbody td {
            border: 1px solid #d9d9d9;
            padding: 6px 8px;
            vertical-align: middle;
            word-break: break-word;
        }

        tbody tr:nth-child(even) td {
            background: #fafafa;
        }

        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 0;
            font-size: 11px;
            font-weight: 600;
            color: #000;
            background: none !important;
            border: none !important;
        }

        @media print {
            @page {
                margin: 10mm;
            }

            body {
                padding: 0;
            }

            .print-toolbar,
            .print-note {
                display: none !important;
            }

            .print-header-image {
                max-width: 900px;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body>
    <div class="print-container">
        <div class="print-toolbar">
            <button type="button" onclick="window.print()">Print</button>
            <button type="button" class="secondary" onclick="window.close()">Close</button>
        </div>

        @if(!empty($headerImage))
            <div class="print-header-wrap">
                <img src="{{ $headerImage }}" alt="Print Header" class="print-header-image">
            </div>
        @endif

        <div class="print-title-wrap">
            <h2>{{ $title }}</h2>
            <div class="print-subtitle">{{ $subtitle }}</div>
            <div class="print-date">Date Printed: {{ $printedAt }}</div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        @foreach($headers as $header)
                            <th>{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($rows as $row)
                        <tr>
                            @foreach($row as $cell)
                                <td>{!! $cell !!}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>