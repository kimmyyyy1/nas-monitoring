<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BAR No. 1 - Quarterly Physical Report</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f4f4f4; }
        .sidebar { position: fixed; left: 0; top: 0; width: 260px; height: 100vh; background-color: #2c3e50; padding: 20px; box-sizing: border-box; color: white; overflow-y: auto; }
        .sidebar h3 { text-align: center; margin-top: 0; margin-bottom: 20px; border-bottom: 1px solid #444; padding-bottom: 10px; }
        .sidebar a { display: block; color: #ecf0f1; text-decoration: none; padding: 15px; border-radius: 5px; margin-bottom: 10px; font-weight: bold; }
        .sidebar a:hover { background-color: #34495e; }
        .sidebar a.active { background-color: #007bff; color: white; }
        .main-content { margin-left: 260px; padding: 20px; }
        
        .report-container { background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); overflow-x: auto; }
        h2 { text-align: center; margin-bottom: 5px; color: #333; }
        h4 { text-align: center; margin-top: 0; color: #666; }
        
        table { width: 100%; border-collapse: collapse; font-size: 13px; text-align: center; }
        th, td { border: 1px solid #333; padding: 8px; }
        th { background-color: #d9e2f3; font-weight: bold; vertical-align: middle; }
        .left-align { text-align: left; }
        .total-col { font-weight: bold; background-color: #f0f0f0; }
        .variance-col { font-weight: bold; color: #d9534f; }
        
        /* Style para sa Edit Button */
        .edit-btn {
            background-color: #007bff; 
            color: white; 
            padding: 10px 15px; 
            text-decoration: none; 
            border-radius: 5px; 
            font-weight: bold;
            display: inline-block;
        }
        .edit-btn:hover { background-color: #0056b3; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h3>NAS M&E System</h3>
        <a href="{{ route('main.dashboard') }}">Main Dashboard</a>
        <hr style="border-color: #444;">
        <a href="{{ route('reports.create') }}">OC-1: Learning Standards</a>
        <a href="{{ route('reports.create-retention') }}">OC-2: Retention Rate</a>
        <a href="{{ route('reports.create-medals') }}">OC-3: Medal Tally</a>
        <a href="{{ route('reports.create-athletes-trained') }}">OP-2: Athletes Trained</a>
        <a href="{{ route('reports.create-program') }}">OP-1: Programs</a>
        <a href="{{ route('reports.create-facility') }}">OP-3: Facilities</a>
        <hr style="border-color: #444;">
        <a href="{{ route('reports.bar-report') }}" class="active" style="color: #ffd700;">BAR No. 1 Report</a>
    </div>

    <div class="main-content">
        <div class="report-container">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <div style="text-align: left;">
                    <h2 style="margin:0;">QUARTERLY PHYSICAL REPORT (BAR No. 1)</h2>
                    <h4 style="margin:0;">As of {{ date('F d, Y') }}</h4>
                </div>
                <div>
                    <a href="{{ route('reports.edit-targets') }}" class="edit-btn">
                        ✏️ Edit Targets
                    </a>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th rowspan="2" style="width: 20%;">Particulars / Indicators</th>
                        <th colspan="5">Physical Target (Budget Year)</th>
                        <th colspan="5">Physical Accomplishment (Actual)</th>
                        <th rowspan="2">Variance</th>
                        <th rowspan="2">Remarks</th>
                    </tr>
                    <tr>
                        <th>Q1</th> <th>Q2</th> <th>Q3</th> <th>Q4</th> <th>Total</th>
                        <th>Q1</th> <th>Q2</th> <th>Q3</th> <th>Q4</th> <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reportData as $row)
                    @php
                        $target_total = $row['target']->q1_target + $row['target']->q2_target + $row['target']->q3_target + $row['target']->q4_target;
                        $accom_total = $row['accom']['q1'] + $row['accom']['q2'] + $row['accom']['q3'] + $row['accom']['q4'];
                        $variance = $accom_total - $target_total;
                    @endphp
                    <tr>
                        <td class="left-align"><strong>{{ $row['name'] }}</strong></td>
                        
                        <td>{{ $row['target']->q1_target }}</td>
                        <td>{{ $row['target']->q2_target }}</td>
                        <td>{{ $row['target']->q3_target }}</td>
                        <td>{{ $row['target']->q4_target }}</td>
                        <td class="total-col">{{ $target_total }}</td>

                        <td>{{ $row['accom']['q1'] }}</td>
                        <td>{{ $row['accom']['q2'] }}</td>
                        <td>{{ $row['accom']['q3'] }}</td>
                        <td>{{ $row['accom']['q4'] }}</td>
                        <td class="total-col">{{ $accom_total }}</td>

                        <td class="variance-col" style="color: {{ $variance < 0 ? 'red' : 'green' }}">
                            {{ $variance }}
                        </td>
                        <td>{{ $variance >= 0 ? 'Target Met' : 'Under Target' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>