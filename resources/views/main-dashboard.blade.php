<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NAS M&E System - Main Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f4f4f4; }
        
        /* Sidebar styles (Kahit i-include, kailangan pa rin ng CSS dito kung hindi shared ang CSS file) */
        .sidebar { position: fixed; left: 0; top: 0; width: 260px; height: 100vh; background-color: #2c3e50; padding: 20px; box-sizing: border-box; color: white; overflow-y: auto; }
        .sidebar h3 { text-align: center; margin-top: 0; margin-bottom: 20px; border-bottom: 1px solid #444; padding-bottom: 10px; }
        .sidebar a { display: block; color: #ecf0f1; text-decoration: none; padding: 15px; border-radius: 5px; margin-bottom: 10px; font-weight: bold; }
        .sidebar a:hover { background-color: #34495e; }
        .sidebar a.active { background-color: #007bff; color: white; }
        
        .main-content { margin-left: 260px; padding: 20px; }
        h2 { color: #333; }
        
        .scorecard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .card { background-color: #fff; border-radius: 8px; padding: 25px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; }
        .card h3 { margin-top: 0; color: #555; font-size: 1.1em; }
        .card .number { font-size: 3em; font-weight: bold; margin-top: 10px; margin-bottom: 10px; }
        .card .number.green { color: #28a745; }
        .card .number.blue { color: #007bff; }
        .card .number.orange { color: #fd7e14; }
        .card .number.red { color: #dc3545; }
        .card .number.purple { color: #6f42c1; }
        
        .chart-container-wrapper { background-color: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .chart-container { width: 100%; max-width: 600px; margin: auto; }
    </style>
</head>
<body>

    @include('reports.sidebar')

    <div class="main-content">

        <h2>Welcome to the NAS M&E Dashboard</h2>

        <div class="scorecard-grid">
            <div class="card">
                <h3>Overall Retention Rate</h3>
                <div class="number green">{{ number_format($retention_rate, 1) }}%</div>
            </div>
            <div class="card">
                <h3>Total Athletes Trained</h3>
                <div class="number blue">{{ $total_athletes }}</div>
            </div>
            <div class="card">
                <h3>Total Medals Won</h3>
                <div class="number orange">{{ $total_medals }}</div>
            </div>
            <div class="card">
                <h3>Programs Implemented</h3>
                <div class="number red">{{ $total_programs }}</div>
            </div>
            <div class="card">
                <h3>Facilities Certified</h3>
                <div class="number purple">{{ $total_facilities }}</div>
            </div>
        </div>

        <div class="chart-container-wrapper">
            <h3>Overall Student Performance (OC-1)</h3>
            <div class="chart-container">
                <canvas id="myChart"></canvas>
            </div>
        </div>
        
        <script>
            const chartData = @json($oc1_chart_data);
            const ctx = document.getElementById('myChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Number of Students',
                        data: chartData.data,
                        backgroundColor: ['#28a745', '#007bff', '#ffc107', '#fd7e14', '#dc3545'],
                        borderColor: '#fff',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'top' }, title: { display: true, text: 'Student Performance Distribution' } }
                }
            });
        </script>
    </div> 

</body>
</html>