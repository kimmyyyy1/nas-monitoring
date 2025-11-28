<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OC-3.1 National Medal Entry</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f4f4f4; }
        
        /* SIDEBAR STYLE (Kahit naka-include, need pa rin ng CSS dito kung hindi global) */
        .sidebar { position: fixed; left: 0; top: 0; width: 260px; height: 100vh; background-color: #2c3e50; padding: 20px; box-sizing: border-box; color: white; overflow-y: auto; }
        .sidebar h3 { text-align: center; margin-top: 0; margin-bottom: 20px; border-bottom: 1px solid #444; padding-bottom: 10px; }
        .sidebar a { display: block; color: #ecf0f1; text-decoration: none; padding: 15px; border-radius: 5px; margin-bottom: 10px; font-weight: bold; }
        .sidebar a:hover { background-color: #34495e; }
        .sidebar a.active { background-color: #007bff; color: white; }
        .submenu a { padding-left: 30px !important; font-size: 0.9em; background-color: #233342; }

        /* MAIN CONTENT */
        .main-content { margin-left: 260px; padding: 20px; }
        h2 { color: #333; text-align: center; }
        .page-container { display: flex; gap: 20px; max-width: 1600px; margin: auto; }
        
        /* COLUMNS */
        .form-column { flex: 2; min-width: 500px; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 20px; }
        .graph-column { flex: 1; min-width: 400px; }
        
        /* STICKY RIGHT COLUMN */
        .sticky-wrapper { position: sticky; top: 20px; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        
        /* FORM ELEMENTS */
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
        
        /* DASHBOARD ELEMENTS */
        .sticky-wrapper h3 { margin-top: 0; }
        .filters { background-color: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .filters select { padding: 8px; font-size: 16px; width: 100%; margin-bottom: 10px; }
        .chart-container { width: 100%; max-width: 500px; margin: 20px auto 0 auto; }
        
        .scorecards { display: flex; gap: 20px; width: 100%; }
        .card { background-color: #f4f4f4; border: 1px solid #ddd; border-radius: 8px; padding: 20px; flex: 1; text-align: center; }
        .card h3 { margin-top: 0; color: #555; font-size: 1em; }
        .card .number { font-size: 2.5em; font-weight: bold; }
        .card .number.blue { color: #007bff; }
        
        /* BUTTON */
        .submit-button-sticky { width: 100%; padding: 12px 15px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold; margin-top: 20px; }
        .submit-button-sticky:hover { background-color: #218838; }
    </style>
</head>
<body>

    @include('reports.sidebar')

    <div class="main-content">

        <h2>OC-3.1: National Medal Entry</h2>

        <form action="{{ route('medals.national.store') }}" method="POST">
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
                                <option value="">Select Grade</option>
                                <option value="Grade 7">Grade 7</option>
                                <option value="Grade 8">Grade 8</option>
                                <option value="Grade 9">Grade 9</option>
                                <option value="Grade 10">Grade 10</option>
                            </select>
                        </div>
                        <div class="form-group">
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

                        <h3 class="grid-header">National Competition Medals</h3>
                        <div class="form-group">
                            <label for="national_gold">Gold Medals:</label>
                            <input type="number" name="national_gold" id="national_gold" value="0" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="national_silver">Silver Medals:</label>
                            <input type="number" name="national_silver" id="national_silver" value="0" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="national_bronze">Bronze Medals:</label>
                            <input type="number" name="national_bronze" id="national_bronze" value="0" min="0" required>
                        </div>

                    </div>
                </div>

                <div class="graph-column">
                    <div class="sticky-wrapper">
                        <h3>National Statistics</h3>
                        
                        <div class="filters">
                            <label style="font-weight: bold;">Filters:</label>
                            <select id="quarter_filter" onchange="applyFilters()">
                                <option value="">All Quarters</option>
                                @foreach ($quarters as $q)
                                    <option value="{{ $q->quarter }}" {{ ($selectedQuarter == $q->quarter) ? 'selected' : '' }}>{{ $q->quarter }}</option>
                                @endforeach
                            </select>

                            <select id="grade_level_filter" onchange="applyFilters()">
                                <option value="">All Grade Levels</option>
                                @foreach ($gradeLevels as $g)
                                    <option value="{{ $g->grade_level }}" {{ ($selectedGrade == $g->grade_level) ? 'selected' : '' }}>{{ $g->grade_level }}</option>
                                @endforeach
                            </select>
                            
                            <select id="focus_sports_filter" onchange="applyFilters()">
                                <option value="">All Sports</option>
                                @foreach ($sports as $s)
                                    <option value="{{ $s->focus_sports }}" {{ ($selectedSport == $s->focus_sports) ? 'selected' : '' }}>{{ $s->focus_sports }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="scorecards">
                            <div class="card">
                                <h3>Total National Medals</h3>
                                <div class="number blue">{{ $total_national }}</div>
                            </div>
                        </div>

                        <div class="chart-container">
                            <canvas id="myChart"></canvas>
                        </div>
                        
                        <button type="submit" class="submit-button-sticky">Save National Data</button>
                        
                        <script>
                            function applyFilters() {
                                let quarter = document.getElementById('quarter_filter').value;
                                let grade = document.getElementById('grade_level_filter').value;
                                let sport = document.getElementById('focus_sports_filter').value;
                                let url = `{{ route('medals.national.create') }}?quarter=${encodeURIComponent(quarter)}&grade_level=${encodeURIComponent(grade)}&focus_sports=${encodeURIComponent(sport)}`;
                                window.location.href = url;
                            }
                        
                            const chartData = @json($nationalData);
                            const ctx = document.getElementById('myChart').getContext('2d');
                            const myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: chartData.labels, // ['Gold', 'Silver', 'Bronze']
                                    datasets: [{
                                        label: 'National Medals',
                                        data: chartData.data, 
                                        backgroundColor: ['#FFD700', '#C0C0C0', '#CD7F32'], // Gold, Silver, Bronze
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: { 
                                        legend: { display: false }, 
                                        title: { display: true, text: 'National Medal Breakdown' } 
                                    },
                                    scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                                }
                            });
                        </script>
                    </div> 
                </div> 
            </div> 
        </form>

    </div> 
</body>
</html>