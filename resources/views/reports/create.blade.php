<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OC No. 1 - Learning Standards (Form & Dashboard)</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        /* --- GLOBAL STYLES --- */
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f4f4f4; }
        
        /* --- SIDEBAR STYLES --- */
        .sidebar { position: fixed; left: 0; top: 0; width: 260px; height: 100vh; background-color: #2c3e50; padding: 20px; box-sizing: border-box; color: white; overflow-y: auto; }
        .sidebar h3 { text-align: center; margin-top: 0; margin-bottom: 20px; border-bottom: 1px solid #444; padding-bottom: 10px; }
        .sidebar a { display: block; color: #ecf0f1; text-decoration: none; padding: 15px; border-radius: 5px; margin-bottom: 10px; font-weight: bold; }
        .sidebar a:hover { background-color: #34495e; }
        .sidebar a.active { background-color: #007bff; color: white; }
        /* Submenu styles handled in sidebar.blade.php inline styles/classes */

        /* --- MAIN CONTENT LAYOUT --- */
        .main-content { margin-left: 260px; padding: 20px; }
        h2 { color: #333; text-align: center; }
        
        .page-container { display: flex; gap: 20px; max-width: 1600px; margin: auto; }
        
        /* --- COLUMNS --- */
        .form-column { 
            flex: 2; 
            min-width: 500px; 
            background-color: #fff; 
            border-radius: 8px; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); 
            padding: 20px; 
        }
        .graph-column { 
            flex: 1; 
            min-width: 400px; 
        }
        
        /* --- STICKY WRAPPER (Right Side) --- */
        .sticky-wrapper { 
            position: sticky; 
            top: 20px; 
            background-color: #fff; 
            padding: 20px; 
            border-radius: 8px; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); 
        }

        /* --- FORM GRID --- */
        form { padding: 0; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { display: flex; flex-direction: column; }
        .form-group label { margin-bottom: 5px; font-weight: bold; color: #555; }
        .form-group select, .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .grid-header { grid-column: 1 / -1; margin-top: 20px; margin-bottom: 0; padding-bottom: 10px; border-bottom: 2px solid #007bff; color: #0056b3; }
        
        /* --- ALERTS --- */
        .success-message { grid-column: 1 / -1; padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; }
        @if ($errors->any())
        .success-message { background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; }
        @endif
        
        /* --- DASHBOARD ELEMENTS --- */
        .sticky-wrapper h3 { margin-top: 0; }
        .filters { background-color: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .filters select { padding: 8px; font-size: 16px; width: 100%; margin-bottom: 10px; }
        .chart-container { width: 100%; max-width: 400px; margin: auto; }
        
        /* --- BUTTON --- */
        .submit-button-sticky { 
            width: 100%; 
            padding: 12px 15px; 
            background-color: #28a745; 
            color: white; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
            font-size: 16px; 
            font-weight: bold; 
            margin-top: 20px; 
        }
        .submit-button-sticky:hover { background-color: #218838; }
    </style>
</head>
<body>

    @include('reports.sidebar')

    <div class="main-content">

        <h2>OC No. 1: Learning Standards (Entry & Monitoring)</h2>

        <form action="{{ route('reports.store') }}" method="POST">
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

                        <h3 class="grid-header">Outstanding (90-100)</h3>
                        <div class="form-group"><label for="outstanding_male">Male Count:</label><input type="number" name="outstanding_male" id="outstanding_male" value="0" min="0" required></div>
                        <div class="form-group"><label for="outstanding_female">Female Count:</label><input type="number" name="outstanding_female" id="outstanding_female" value="0" min="0" required></div>

                        <h3 class="grid-header">Very Satisfactory (85-89)</h3>
                        <div class="form-group"><label for="very_satisfactory_male">Male Count:</label><input type="number" name="very_satisfactory_male" id="very_satisfactory_male" value="0" min="0" required></div>
                        <div class="form-group"><label for="very_satisfactory_female">Female Count:</label><input type="number" name="very_satisfactory_female" id="very_satisfactory_female" value="0" min="0" required></div>

                        <h3 class="grid-header">Satisfactory (80-84)</h3>
                        <div class="form-group"><label for="satisfactory_male">Male Count:</label><input type="number" name="satisfactory_male" id="satisfactory_male" value="0" min="0" required></div>
                        <div class="form-group"><label for="satisfactory_female">Female Count:</label><input type="number" name="satisfactory_female" id="satisfactory_female" value="0" min="0" required></div>

                        <h3 class="grid-header">Fairly Satisfactory (75-79)</h3>
                        <div class="form-group"><label for="fairly_satisfactory_male">Male Count:</label><input type="number" name="fairly_satisfactory_male" id="fairly_satisfactory_male" value="0" min="0" required></div>
                        <div class="form-group"><label for="fairly_satisfactory_female">Female Count:</label><input type="number" name="fairly_satisfactory_female" id="fairly_satisfactory_female" value="0" min="0" required></div>

                        <h3 class="grid-header">Did not Meet Expectations (74 and below)</h3>
                        <div class="form-group"><label for="did_not_meet_male">Male Count:</label><input type="number" name="did_not_meet_male" id="did_not_meet_male" value="0" min="0" required></div>
                        <div class="form-group"><label for="did_not_meet_female">Female Count:</label><input type="number" name="did_not_meet_female" id="did_not_meet_female" value="0" min="0" required></div>
                        
                    </div>
                </div>

                <div class="graph-column">
                    <div class="sticky-wrapper">
                        <h3>Performance Statistics</h3>

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

                        <div class="chart-container">
                            <canvas id="myChart"></canvas>
                        </div>
                        
                        <button type="submit" class="submit-button-sticky">Save Report</button>
                        
                        <script>
                            // Filter Logic
                            function applyFilters() {
                                let quarter = document.getElementById('quarter_filter').value;
                                let grade = document.getElementById('grade_level_filter').value;
                                // Redirect sa parehong page pero may GET parameters
                                let url = `{{ route('reports.create') }}?quarter=${encodeURIComponent(quarter)}&grade_level=${encodeURIComponent(grade)}`;
                                window.location.href = url;
                            }
                        
                            // Chart Logic
                            const chartData = @json($chartData);
                            const ctx = document.getElementById('myChart').getContext('2d');
                            const myChart = new Chart(ctx, {
                                type: 'pie',
                                data: {
                                    labels: chartData.labels,
                                    datasets: [{
                                        label: 'Number of Students',
                                        data: chartData.data,
                                        backgroundColor: [
                                            'rgba(40, 167, 69, 0.7)',  // Green
                                            'rgba(54, 162, 235, 0.7)', // Blue
                                            'rgba(255, 206, 86, 0.7)', // Yellow
                                            'rgba(255, 159, 64, 0.7)', // Orange
                                            'rgba(255, 99, 132, 0.7)'  // Red
                                        ],
                                        borderColor: '#fff',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: { 
                                        legend: { position: 'top' }, 
                                        title: { display: true, text: 'Student Performance Distribution' } 
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