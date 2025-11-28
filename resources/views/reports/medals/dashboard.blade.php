<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>OC No. 3 - Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        /* --- GLOBAL RESET --- */
        body { font-family: Arial, sans-serif; margin: 0; background-color: #f4f4f4; overflow-x: hidden; }
        
        /* =========================================
           SIDEBAR STYLES (HARDCODED PARA SIGURADO)
           ========================================= */
        .sidebar { 
            position: fixed; 
            left: 0; 
            top: 0; 
            width: 260px; 
            height: 100vh; 
            background-color: #2c3e50; 
            padding: 20px; 
            box-sizing: border-box; 
            color: white; 
            overflow-y: auto; 
            z-index: 1000;
        }
        
        .sidebar h3 { text-align: center; margin-top: 0; margin-bottom: 20px; border-bottom: 1px solid #444; padding-bottom: 10px; }
        .sidebar a { display: block; color: #ecf0f1; text-decoration: none; padding: 15px; border-radius: 5px; margin-bottom: 10px; font-weight: bold; }
        .sidebar a:hover { background-color: #34495e; }
        .sidebar a.active { background-color: #007bff; color: white; }
        
        /* Submenu adjustments */
        .submenu-container { background-color: #233342; padding: 5px 0; }
        .submenu-item { padding-left: 30px !important; font-size: 0.9em !important; }

        /* Mobile Menu Button (Hidden on Desktop) */
        .mobile-menu-btn { display: none; }
        .close-btn { display: none; }
        .sidebar-overlay { display: none; }

        /* =========================================
           MAIN CONTENT LAYOUT
           ========================================= */
        .main-content { 
            margin-left: 260px; /* Space para sa Sidebar */
            padding: 20px; 
            width: calc(100% - 260px);
            box-sizing: border-box;
        }
        
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        
        /* --- GRID SYSTEM --- */
        .dashboard-grid { 
            display: grid; 
            grid-template-columns: 1fr 1fr; /* 2 Columns */
            gap: 20px; 
            max-width: 1400px; 
            margin: auto; 
        }
        
        /* --- CARDS --- */
        .card { 
            background: white; 
            padding: 20px; 
            border-radius: 8px; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); 
            text-align: center; 
            display: flex; 
            flex-direction: column;
        }
        
        /* --- FILTERS --- */
        .filters { 
            background: #fff; 
            padding: 15px; 
            margin-bottom: 20px; 
            border-radius: 8px; 
            display: flex; 
            gap: 10px; 
            justify-content: center; 
            flex-wrap: wrap; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        select { padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; }

        /* --- CHART FIXED HEIGHT --- */
        .chart-box {
            position: relative;
            width: 100%;
            height: 400px !important;
            min-height: 400px;
            max-height: 400px;
            margin-top: 15px;
        }
        
        canvas {
            width: 100% !important;
            height: 100% !important;
        }

        /* =========================================
           MOBILE RESPONSIVE
           ========================================= */
        @media (max-width: 992px) {
            /* Mobile Nav Elements */
            .mobile-menu-btn {
                display: block;
                position: fixed; top: 15px; left: 15px; z-index: 2000;
                background-color: #2c3e50; color: white;
                border: none; padding: 10px 15px; border-radius: 5px; font-size: 1.4em;
            }
            .close-btn { display: block; font-size: 2em; cursor: pointer; float: right; color: white;}
            
            /* Sidebar Hidden by Default */
            .sidebar { transform: translateX(-100%); transition: transform 0.3s; width: 85%; max-width: 300px; }
            .sidebar.active { transform: translateX(0); }
            
            /* Overlay */
            .sidebar-overlay {
                position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                background: rgba(0,0,0,0.7); z-index: 999; display: none;
            }
            .sidebar-overlay.active { display: block; }

            /* Main Content Full Width */
            .main-content { 
                margin-left: 0 !important; 
                width: 100% !important;
                padding-top: 70px; 
                padding-left: 15px; 
                padding-right: 15px; 
            }
            
            .dashboard-grid { grid-template-columns: 1fr !important; }
            
            .chart-box { 
                height: 300px !important; 
                min-height: 300px;
                max-height: 300px;
            }
            
            select { width: 100%; }
        }
    </style>
</head>
<body>

    @include('reports.sidebar')

    <div class="main-content">
        <h2>OC No. 3: Medal Tally Dashboard</h2>

        <div class="filters">
            <form action="{{ route('medals.dashboard') }}" method="GET" style="display:flex; gap:10px; flex-wrap:wrap; justify-content:center; width: 100%;">
                <select name="quarter" onchange="this.form.submit()">
                    <option value="">All Quarters</option>
                    @foreach($quarters as $q) <option value="{{ $q->quarter }}" {{ $selectedQuarter == $q->quarter ? 'selected' : '' }}>{{ $q->quarter }}</option> @endforeach
                </select>
                <select name="grade_level" onchange="this.form.submit()">
                    <option value="">All Grades</option>
                    @foreach($gradeLevels as $g) <option value="{{ $g->grade_level }}" {{ $selectedGrade == $g->grade_level ? 'selected' : '' }}>{{ $g->grade_level }}</option> @endforeach
                </select>
                <select name="focus_sports" onchange="this.form.submit()">
                    <option value="">All Sports</option>
                    @foreach($sports as $s) <option value="{{ $s->focus_sports }}" {{ $selectedSport == $s->focus_sports ? 'selected' : '' }}>{{ $s->focus_sports }}</option> @endforeach
                </select>
            </form>
        </div>

        <div class="dashboard-grid">
            <div class="card">
                <h3>OC-3.1: National Medals (Total: {{ $total_national }})</h3>
                <div class="chart-box">
                    <canvas id="nationalChart"></canvas>
                </div>
            </div>
            
            <div class="card">
                <h3>OC-3.2: International Medals (Total: {{ $total_international }})</h3>
                <div class="chart-box">
                    <canvas id="internationalChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        const natData = @json($nationalData);
        const intData = @json($internationalData);

        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'top' } },
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
        };

        new Chart(document.getElementById('nationalChart').getContext('2d'), {
            type: 'bar',
            data: { 
                labels: natData.labels, 
                datasets: [{ 
                    label: 'Medals', 
                    data: natData.data, 
                    backgroundColor: ['#FFD700', '#C0C0C0', '#CD7F32'], 
                    borderWidth: 1 
                }] 
            },
            options: chartOptions
        });

        new Chart(document.getElementById('internationalChart').getContext('2d'), {
            type: 'bar',
            data: { 
                labels: intData.labels, 
                datasets: [{ 
                    label: 'Medals', 
                    data: intData.data, 
                    backgroundColor: ['#FFD700', '#C0C0C0', '#CD7F32'], 
                    borderWidth: 1 
                }] 
            },
            options: chartOptions
        });
    </script>
</body>
</html>