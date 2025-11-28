<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OC No. 2 - Retention Rate (Form & Dashboard)</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f4f4f4; }
        
        /* SIDEBAR STYLES */
        .sidebar { position: fixed; left: 0; top: 0; width: 260px; height: 100vh; background-color: #2c3e50; padding: 20px; box-sizing: border-box; color: white; overflow-y: auto; }
        .sidebar h3 { text-align: center; margin-top: 0; margin-bottom: 20px; border-bottom: 1px solid #444; padding-bottom: 10px; }
        .sidebar a { display: block; color: #ecf0f1; text-decoration: none; padding: 15px; border-radius: 5px; margin-bottom: 10px; font-weight: bold; }
        .sidebar a:hover { background-color: #34495e; }
        .sidebar a.active { background-color: #007bff; color: white; }
        /* Submenu styles handled in shared sidebar */

        /* MAIN LAYOUT */
        .main-content { margin-left: 260px; padding: 20px; }
        h2 { color: #333; text-align: center; }
        .page-container { display: flex; gap: 20px; max-width: 1600px; margin: auto; }
        
        /* COLUMNS */
        .form-column { flex: 2; min-width: 500px; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 20px; }
        .graph-column { flex: 1; min-width: 400px; }
        .sticky-wrapper { position: sticky; top: 20px; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        
        /* FORM */
        form { padding: 0; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { display: flex; flex-direction: column; }
        .form-group label { margin-bottom: 5px; font-weight: bold; color: #555; }
        .form-group select, .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .grid-header { grid-column: 1 / -1; margin-top: 20px; margin-bottom: 0; padding-bottom: 10px; border-bottom: 2px solid #007bff; color: #0056b3; }
        
        /* ALERTS */
        .success-message { grid-column: 1 / -1; padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; }
        @if ($errors->any())
        .success-message { background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; }
        @endif
        
        /* DASHBOARD */
        .sticky-wrapper h3 { margin-top: 0; }
        .filters { background-color: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .filters select { padding: 8px; font-size: 16px; width: 100%; margin-bottom: 10px; }
        .chart-container { width: 100%; max-width: 400px; margin: 20px auto 0 auto; }
        .card { background-color: #f4f4f4; border: 1px solid #ddd; border-radius: 8px; padding: 20px; margin-bottom: 15px; }
        .card h3 { margin-top: 0; color: #555; }
        .card .number { font-size: 2.5em; font-weight: bold; }
        .card .number.green { color: #28a745; }
        .card .number.red { color: #dc3545; }
        .card .detail { margin-top: 10px; color: #666; }
        
        /* BUTTON */
        .submit-button-sticky { width: 100%; padding: 12px 15px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold; margin-top: 20px; }
        .submit-button-sticky:hover { background-color: #218838; }
    </style>
</head>
<body>

    @include('reports.sidebar')

    <div class="main-content">

        <h2>OC No. 2: Retention Rate (Entry & Monitoring)</h2>

        <form action="{{ route('reports.store-retention') }}" method="POST">
            @csrf
            
            <div class="page-container">

                <div class="form-column">
                    <div class="form-grid">
                        @if (session('success'))
                            <div class="success-message">{{ session('success') }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="success-message">
                                <strong>Error!</strong> May mga problema sa iyong input:
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="quarter">Quarter:</label>
                            <select name="quarter" id="quarter" required>
                                <option value="">Select Quarter</option>
                                <option value="1st Quarter">1st Quarter</option>
                                <option value="2nd Quarter">2nd Quarter</option>
                                <option value="3rd Quarter">3rd Quarter</option>
                                <option value="4th Quarter">4th Quarter</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="grade_level">Grade Level:</label>
                            <select name="grade_level" id="grade_level" required>
                                <option value="">Select Grade Level</option>
                                <option value="Grade 7">Grade 7</option>
                                <option value="Grade 8">Grade 8</option>
                                <option value="Grade 9">Grade 9</option>
                                <option value="Grade 10">Grade 10</option>
                            </select>
                        </div>

                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label for="focus_sports">Focus Sports:</label>
                            <select name="focus_sports" id="focus_sports" required>
                                <option value="">Select Sports</option>
                                <option value="AQUATICS">AQUATICS</option>
                                <option value="ATHLETICS">ATHLETICS</option>
                                <option value="BADMINTON">BADMINTON</option>
                                <option value="GYMNASTICS">GYMNASTICS</option>
                                <option value="JUDO">JUDO</option>
                                <option value="TABLE TENNIS">TABLE TENNIS</option>
                                <option value="TAEKWONDO">TAEKWONDO</option>
                            </select>
                        </div>

                        <h3 class="grid-header">Initial Enrollment (SY 23-24)</h3>
                        <div class="form-group"><label for="initial_enrollment_male">Male Count:</label><input type="number" name="initial_enrollment_male" id="initial_enrollment_male" value="0" min="0" required></div>
                        <div class="form-group"><label for="initial_enrollment_female">Female Count:</label><input type="number" name="initial_enrollment_female" id="initial_enrollment_female" value="0" min="0" required></div>

                        <h3 class="grid-header">Transfer</h3>
                        <div class="form-group"><label for="transfer_male">Male Count:</label><input type="number" name="transfer_male" id="transfer_male" value="0" min="0" required></div>
                        <div class="form-group"><label for="transfer_female">Female Count:</label><input type="number" name="transfer_female" id="transfer_female" value="0" min="0" required></div>

                        <h3 class="grid-header">Dropped</h3>
                        <div class="form-group"><label for="dropped_male">Male Count:</label><input type="number" name="dropped_male" id="dropped_male" value="0" min="0" required></div>
                        <div class="form-group"><label for="dropped_female">Female Count:</label><input type="number" name="dropped_female" id="dropped_female" value="0" min="0" required></div>
                        
                        <h3 class="grid-header">Projected Enrollees for Next SY</h3>
                        <div class="form-group"><label for="projected_enrollees_male">Male Count:</label><input type="number" name="projected_enrollees_male" id="projected_enrollees_male" value="0" min="0" required></div>
                        <div class="form-group"><label for="projected_enrollees_female">Female Count:</label><input type="number" name="projected_enrollees_female" id="projected_enrollees_female" value="0" min="0" required></div>
                    </div>
                </div>

                <div class="graph-column">
                    <div class="sticky-wrapper">
                        <h3>Retention Statistics</h3>
                        
                        <div class="filters">
                            <label for="quarter_filter" style="font-weight: bold;">Filter by Quarter:</label>
                            <select id="quarter_filter" onchange="applyFilters()">
                                <option value="">All Quarters</option>
                                @foreach ($quarters as $q)
                                    <option value="{{ $q->quarter }}" {{ ($selectedQuarter == $q->quarter) ? 'selected' : '' }}>
                                        {{ $q->quarter }}
                                    </option>
                                @endforeach
                            </select>

                            <label for="grade_level_filter" style="font-weight: bold;">Filter by Grade Level:</label>
                            <select id="grade_level_filter" onchange="applyFilters()">
                                <option value="">All Grade Levels</option>
                                @foreach ($gradeLevels as $g)
                                    <option value="{{ $g->grade_level }}" {{ ($selectedGrade == $g->grade_level) ? 'selected' : '' }}>
                                        {{ $g->grade_level }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="card">
                            <h3>Overall Retention Rate</h3>
                            <div class="number green">{{ number_format($retention_rate, 2) }}%</div>
                            <div class="detail">{{ $total_retained }} out of {{ $total_initial }} students retained</div>
                        </div>
                        <div class="card">
                            <h3>Overall Attrition Rate</h3>
                            <div class="number red">{{ number_format($attrition_rate, 2) }}%</div>
                            <div class="detail">{{ $total_attrition }} out of {{ $total_initial }} students (Dropped/Transferred)</div>
                        </div>
                    
                        <div class="chart-container">
                            <canvas id="myChart"></canvas>
                        </div>
                        
                        <button type="submit" class="submit-button-sticky">Save Retention Report</button>
                        
                        <script>
                            function applyFilters() {
                                let quarter = document.getElementById('quarter_filter').value;
                                let grade = document.getElementById('grade_level_filter').value;
                                let url = `{{ route('reports.create-retention') }}?quarter=${encodeURIComponent(quarter)}&grade_level=${encodeURIComponent(grade)}`;
                                window.location.href = url;
                            }
                        
                            const chartData = @json($chartData);
                            const ctx = document.getElementById('myChart').getContext('2d');
                            const myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: chartData.labels, // ['Aquatics', 'Athletics', ...]
                                    datasets: chartData.datasets // [ {label: 'Retained Male', ...}, {label: 'Retained Female', ...} ]
                                },
                                options: {
                                    responsive: true,
                                    plugins: { 
                                        legend: { position: 'top' }, 
                                        title: { display: true, text: 'Retained Students (Male/Female) by Sports' } 
                                    },
                                    scales: {
                                        x: { stacked: true }, 
                                        y: { stacked: true, beginAtZero: true, title: { display: true, text: 'Number of Students' } }
                                    }
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </form>

    </div> </body>
</html>